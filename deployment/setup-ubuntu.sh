#!/bin/bash

###############################################################################
# Furniture AR Project - Ubuntu Server Setup Script
# This script sets up the complete deployment environment on Ubuntu
###############################################################################

set -e  # Exit on any error

# Color output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}=========================================${NC}"
echo -e "${GREEN}Furniture AR - Ubuntu Setup Script${NC}"
echo -e "${GREEN}=========================================${NC}"

# Check if running as root
if [ "$EUID" -ne 0 ]; then 
    echo -e "${RED}Please run as root or with sudo${NC}"
    exit 1
fi

# Get user input for configuration
read -p "Enter your domain or IP address (e.g., example.com or 192.168.1.100): " APP_URL
read -p "Enter MySQL root password: " MYSQL_ROOT_PASSWORD
read -p "Enter MySQL database name [furniture_shop_ar]: " DB_DATABASE
DB_DATABASE=${DB_DATABASE:-furniture_shop_ar}
read -p "Enter MySQL username [furniture_user]: " DB_USERNAME
DB_USERNAME=${DB_USERNAME:-furniture_user}
read -sp "Enter MySQL user password: " DB_PASSWORD
echo
read -p "Enter Laravel APP_KEY (leave empty to generate new): " APP_KEY

# Project directory
PROJECT_DIR="/opt/furniture-ar"
echo -e "${YELLOW}Project will be installed at: $PROJECT_DIR${NC}"

###############################################################################
# 1. Update system and install dependencies
###############################################################################
echo -e "${GREEN}[1/8] Updating system...${NC}"
apt-get update
apt-get upgrade -y

echo -e "${GREEN}[2/8] Installing required packages...${NC}"
apt-get install -y \
    curl \
    wget \
    git \
    unzip \
    ca-certificates \
    gnupg \
    lsb-release \
    ufw \
    fail2ban

###############################################################################
# 2. Install Docker
###############################################################################
echo -e "${GREEN}[3/8] Installing Docker...${NC}"

# Check if Docker is already installed
if command -v docker &> /dev/null; then
    echo -e "${YELLOW}Docker is already installed${NC}"
else
    # Add Docker's official GPG key
    install -m 0755 -d /etc/apt/keyrings
    curl -fsSL https://download.docker.com/linux/ubuntu/gpg | gpg --dearmor -o /etc/apt/keyrings/docker.gpg
    chmod a+r /etc/apt/keyrings/docker.gpg

    # Set up Docker repository
    echo \
      "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
      $(lsb_release -cs) stable" | tee /etc/apt/sources.list.d/docker.list > /dev/null

    # Install Docker Engine
    apt-get update
    apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

    # Enable Docker to start on boot
    systemctl enable docker
    systemctl start docker

    echo -e "${GREEN}Docker installed successfully${NC}"
fi

# Verify Docker installation
docker --version
docker compose version

###############################################################################
# 3. Create project directory structure
###############################################################################
echo -e "${GREEN}[4/8] Creating project structure...${NC}"

# Create directories
mkdir -p $PROJECT_DIR/{logs/app,logs/nginx,logs/redis,backups/db,sql,public/images}
cd $PROJECT_DIR

# Set proper permissions
chmod -R 755 $PROJECT_DIR

###############################################################################
# 4. Create docker-compose.yml
###############################################################################
echo -e "${GREEN}[5/8] Creating docker-compose.yml...${NC}"

cat > $PROJECT_DIR/docker-compose.yml <<'EOF'
services:
  app:
    image: assassincreed2k1/furniture-ar:latest
    container_name: furniture_ar_app
    restart: unless-stopped
    depends_on:
      db:
        condition: service_healthy
      redis:
        condition: service_healthy
    ports:
      - "80:80"
    environment:
      # Application
      APP_NAME: "Furniture AR Shop"
      APP_ENV: production
      APP_KEY: ${APP_KEY}
      APP_DEBUG: "false"
      APP_URL: ${APP_URL}

      # Logging
      LOG_CHANNEL: stack
      LOG_DEPRECATIONS_CHANNEL: null
      LOG_LEVEL: error

      # Database
      DB_CONNECTION: mysql
      DB_HOST: db
      DB_PORT: 3306
      DB_DATABASE: ${DB_DATABASE}
      DB_USERNAME: ${DB_USERNAME}
      DB_PASSWORD: ${DB_PASSWORD}
      DB_CHARSET: utf8mb4
      DB_COLLATION: utf8mb4_unicode_ci

      # Cache & Session
      CACHE_DRIVER: redis
      FILESYSTEM_DISK: local
      QUEUE_CONNECTION: database
      SESSION_DRIVER: redis
      SESSION_LIFETIME: 120

      # Redis
      REDIS_HOST: redis
      REDIS_PASSWORD: null
      REDIS_PORT: 6379

      # Mail Configuration (update these with your values)
      MAIL_MAILER: smtp
      MAIL_HOST: smtp.gmail.com
      MAIL_PORT: 587
      MAIL_USERNAME: your-email@gmail.com
      MAIL_PASSWORD: your-app-password
      MAIL_ENCRYPTION: tls
      MAIL_FROM_ADDRESS: your-email@gmail.com
      MAIL_FROM_NAME: "Furniture AR Shop"

      # Security
      BCRYPT_ROUNDS: 12

      # TinyMCE API Key
      TINYMCE_API_KEY: your-tinymce-api-key
    volumes:
      - app_storage:/var/www/html/storage
      - ./logs/app:/var/www/html/storage/logs:delegated
      - ./public/images:/var/www/html/public/images
    networks:
      - furniture_network
    healthcheck:
      test: ["CMD", "curl", "-f", "http://localhost/health"]
      interval: 30s
      timeout: 10s
      retries: 5
      start_period: 30s

  db:
    image: mysql:8.0
    container_name: furniture_ar_db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: ${DB_DATABASE}
      MYSQL_USER: ${DB_USERNAME}
      MYSQL_PASSWORD: ${DB_PASSWORD}
      MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD}
    volumes:
      - db_data:/var/lib/mysql
      - ./backups/db:/backups
      - ./sql:/docker-entrypoint-initdb.d
    command: --character-set-server=utf8mb4 --collation-server=utf8mb4_unicode_ci --max_connections=200
    networks:
      - furniture_network
    healthcheck:
      test: ["CMD", "mysqladmin", "ping", "-h", "localhost", "-u", "root", "-p$$MYSQL_ROOT_PASSWORD"]
      interval: 10s
      timeout: 5s
      retries: 5

  redis:
    image: redis:7-alpine
    container_name: furniture_ar_redis
    restart: unless-stopped
    command: redis-server --appendonly yes --appendfsync everysec --save 900 1 --save 300 10 --save 60 10000
    volumes:
      - redis_data:/data
      - ./logs/redis:/var/log/redis:delegated
    networks:
      - furniture_network
    healthcheck:
      test: ["CMD", "redis-cli", "ping"]
      interval: 10s
      timeout: 5s
      retries: 3

  queue:
    image: assassincreed2k1/furniture-ar:latest
    container_name: furniture_ar_queue
    restart: unless-stopped
    depends_on:
      db:
        condition: service_healthy
      redis:
        condition: service_healthy
    environment:
      # Application
      APP_ENV: production
      APP_KEY: ${APP_KEY}
      APP_URL: ${APP_URL}

      # Database
      DB_CONNECTION: mysql
      DB_HOST: db
      DB_PORT: 3306
      DB_DATABASE: ${DB_DATABASE}
      DB_USERNAME: ${DB_USERNAME}
      DB_PASSWORD: ${DB_PASSWORD}

      # Cache & Session
      CACHE_DRIVER: redis
      QUEUE_CONNECTION: database

      # Redis
      REDIS_HOST: redis
      REDIS_PASSWORD: null
      REDIS_PORT: 6379

      # Mail Configuration
      MAIL_MAILER: smtp
      MAIL_HOST: smtp.gmail.com
      MAIL_PORT: 587
      MAIL_USERNAME: your-email@gmail.com
      MAIL_PASSWORD: your-app-password
      MAIL_ENCRYPTION: tls
      MAIL_FROM_ADDRESS: your-email@gmail.com
      MAIL_FROM_NAME: "Furniture AR Shop"
    command: php artisan queue:work --queue=notifications,emails,default --sleep=1 --tries=3 --backoff=5 --max-jobs=1000 --max-time=3600 --timeout=90
    volumes:
      - app_storage:/var/www/html/storage
    networks:
      - furniture_network

networks:
  furniture_network:
    driver: bridge

volumes:
  app_storage:
    driver: local
  db_data:
    driver: local
  redis_data:
    driver: local
EOF

###############################################################################
# 5. Create .env file
###############################################################################
echo -e "${GREEN}[6/8] Creating .env file...${NC}"

# Generate APP_KEY if not provided
if [ -z "$APP_KEY" ]; then
    APP_KEY="base64:$(openssl rand -base64 32)"
    echo -e "${YELLOW}Generated new APP_KEY: $APP_KEY${NC}"
fi

cat > $PROJECT_DIR/.env <<EOF
# Application Settings
APP_URL=${APP_URL}
APP_KEY=${APP_KEY}

# Database Settings
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}
MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD}
EOF

echo -e "${GREEN}.env file created${NC}"

###############################################################################
# 6. Configure firewall
###############################################################################
echo -e "${GREEN}[7/8] Configuring firewall...${NC}"

# Enable UFW
ufw --force enable

# Allow SSH
ufw allow OpenSSH

# Allow HTTP and HTTPS
ufw allow 80/tcp
ufw allow 443/tcp

# Show status
ufw status

###############################################################################
# 7. Create management scripts
###############################################################################
echo -e "${GREEN}[8/8] Creating management scripts...${NC}"

# Start script
cat > $PROJECT_DIR/start.sh <<'EOF'
#!/bin/bash
cd /opt/furniture-ar
docker compose up -d
echo "Furniture AR application started!"
echo "Waiting for services to be healthy..."
sleep 10
docker compose ps
EOF
chmod +x $PROJECT_DIR/start.sh

# Stop script
cat > $PROJECT_DIR/stop.sh <<'EOF'
#!/bin/bash
cd /opt/furniture-ar
docker compose down
echo "Furniture AR application stopped!"
EOF
chmod +x $PROJECT_DIR/stop.sh

# Restart script
cat > $PROJECT_DIR/restart.sh <<'EOF'
#!/bin/bash
cd /opt/furniture-ar
docker compose down
docker compose up -d
echo "Furniture AR application restarted!"
sleep 10
docker compose ps
EOF
chmod +x $PROJECT_DIR/restart.sh

# Update script (pull latest image)
cat > $PROJECT_DIR/update.sh <<'EOF'
#!/bin/bash
cd /opt/furniture-ar
echo "Pulling latest images..."
docker compose pull
echo "Restarting containers..."
docker compose down
docker compose up -d
echo "Update complete!"
sleep 10
docker compose ps
EOF
chmod +x $PROJECT_DIR/update.sh

# Logs script
cat > $PROJECT_DIR/logs.sh <<'EOF'
#!/bin/bash
cd /opt/furniture-ar
if [ -z "$1" ]; then
    docker compose logs -f
else
    docker compose logs -f $1
fi
EOF
chmod +x $PROJECT_DIR/logs.sh

# Database backup script
cat > $PROJECT_DIR/backup-db.sh <<'EOF'
#!/bin/bash
cd /opt/furniture-ar
BACKUP_FILE="backups/db/backup-$(date +%Y%m%d-%H%M%S).sql"
docker compose exec -T db mysqldump -u root -p${MYSQL_ROOT_PASSWORD} ${DB_DATABASE} > $BACKUP_FILE
gzip $BACKUP_FILE
echo "Database backup created: ${BACKUP_FILE}.gz"
EOF
chmod +x $PROJECT_DIR/backup-db.sh

# Database restore script
cat > $PROJECT_DIR/restore-db.sh <<'EOF'
#!/bin/bash
if [ -z "$1" ]; then
    echo "Usage: ./restore-db.sh <backup-file.sql or backup-file.sql.gz>"
    exit 1
fi

cd /opt/furniture-ar
BACKUP_FILE=$1

if [[ $BACKUP_FILE == *.gz ]]; then
    gunzip -c $BACKUP_FILE | docker compose exec -T db mysql -u root -p${MYSQL_ROOT_PASSWORD} ${DB_DATABASE}
else
    docker compose exec -T db mysql -u root -p${MYSQL_ROOT_PASSWORD} ${DB_DATABASE} < $BACKUP_FILE
fi

echo "Database restored from: $BACKUP_FILE"
EOF
chmod +x $PROJECT_DIR/restore-db.sh

# Run artisan commands
cat > $PROJECT_DIR/artisan.sh <<'EOF'
#!/bin/bash
cd /opt/furniture-ar
docker compose exec app php artisan "$@"
EOF
chmod +x $PROJECT_DIR/artisan.sh

###############################################################################
# 8. Display completion message
###############################################################################
echo -e "${GREEN}=========================================${NC}"
echo -e "${GREEN}Setup Complete!${NC}"
echo -e "${GREEN}=========================================${NC}"
echo ""
echo -e "${YELLOW}Project Directory:${NC} $PROJECT_DIR"
echo ""
echo -e "${YELLOW}Available Commands:${NC}"
echo -e "  ${GREEN}$PROJECT_DIR/start.sh${NC}        - Start the application"
echo -e "  ${GREEN}$PROJECT_DIR/stop.sh${NC}         - Stop the application"
echo -e "  ${GREEN}$PROJECT_DIR/restart.sh${NC}      - Restart the application"
echo -e "  ${GREEN}$PROJECT_DIR/update.sh${NC}       - Pull latest image and restart"
echo -e "  ${GREEN}$PROJECT_DIR/logs.sh [service]${NC} - View logs (all or specific service)"
echo -e "  ${GREEN}$PROJECT_DIR/backup-db.sh${NC}    - Backup database"
echo -e "  ${GREEN}$PROJECT_DIR/restore-db.sh <file>${NC} - Restore database"
echo -e "  ${GREEN}$PROJECT_DIR/artisan.sh <command>${NC} - Run Laravel artisan commands"
echo ""
echo -e "${YELLOW}Next Steps:${NC}"
echo -e "1. Review and update mail configuration in docker-compose.yml"
echo -e "2. Add your database backup SQL file to: $PROJECT_DIR/sql/"
echo -e "3. Start the application: ${GREEN}$PROJECT_DIR/start.sh${NC}"
echo -e "4. Run database migrations: ${GREEN}$PROJECT_DIR/artisan.sh migrate${NC}"
echo -e "5. Access your application at: ${GREEN}http://$APP_URL${NC}"
echo ""
echo -e "${YELLOW}Important Files:${NC}"
echo -e "  - Docker Compose: $PROJECT_DIR/docker-compose.yml"
echo -e "  - Environment: $PROJECT_DIR/.env"
echo -e "  - Application logs: $PROJECT_DIR/logs/app/"
echo -e "  - Database backups: $PROJECT_DIR/backups/db/"
echo ""
echo -e "${GREEN}=========================================${NC}"
