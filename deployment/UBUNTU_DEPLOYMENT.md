# Furniture AR - Ubuntu Deployment Guide

## Prerequisites
- Ubuntu 20.04 LTS or later
- Root or sudo access
- Minimum 2GB RAM, 2 CPU cores
- 20GB available disk space

## Quick Start

### 1. Download and Run Setup Script

```bash
# Download the setup script
wget https://raw.githubusercontent.com/nguyentrungnghia1802/Furniture-AR-Project/main/deployment/setup-ubuntu.sh

# Make it executable
chmod +x setup-ubuntu.sh

# Run as root
sudo ./setup-ubuntu.sh
```

The script will ask for:
- **Domain/IP**: Your server's domain or IP address
- **MySQL root password**: Strong password for MySQL root user
- **Database name**: Database name (default: furniture_shop_ar)
- **MySQL username**: Database user (default: furniture_user)
- **MySQL password**: Database user password
- **APP_KEY**: Laravel encryption key (leave empty to auto-generate)

### 2. What the Script Does

The setup script will:
1. ✅ Update system packages
2. ✅ Install Docker and Docker Compose
3. ✅ Create project directory at `/opt/furniture-ar`
4. ✅ Generate docker-compose.yml configuration
5. ✅ Create .env file with your settings
6. ✅ Configure firewall (UFW)
7. ✅ Create management scripts

### 3. Post-Installation Steps

#### A. Upload Database Backup (Optional)
```bash
# Upload your SQL backup file to the server
scp database/sql/back-up.sql root@YOUR_SERVER:/opt/furniture-ar/sql/

# Or download from your repository
cd /opt/furniture-ar/sql
wget https://your-backup-location/backup.sql
```

#### B. Update Email Configuration
Edit `/opt/furniture-ar/docker-compose.yml` and update mail settings:
```yaml
MAIL_USERNAME: your-email@gmail.com
MAIL_PASSWORD: your-app-password
MAIL_FROM_ADDRESS: your-email@gmail.com
```

#### C. Update TinyMCE API Key (if using rich text editor)
```yaml
TINYMCE_API_KEY: your-tinymce-api-key
```

### 4. Start the Application

```bash
cd /opt/furniture-ar
./start.sh
```

Wait 30-60 seconds for all services to start, then verify:
```bash
docker compose ps
```

You should see:
- ✅ furniture_ar_app (healthy)
- ✅ furniture_ar_db (healthy)
- ✅ furniture_ar_redis (healthy)
- ✅ furniture_ar_queue (running)

### 5. Run Database Migrations

If you uploaded a SQL backup file:
```bash
# The SQL file will be imported automatically on first start
# Check if database is populated:
./artisan.sh db:show
```

If starting fresh without backup:
```bash
./artisan.sh migrate --force
./artisan.sh db:seed --force
```

### 6. Verify Installation

Open your browser and navigate to:
- **Website**: http://YOUR_SERVER_IP
- **Health Check**: http://YOUR_SERVER_IP/health

## Management Commands

### Application Control
```bash
# Start application
/opt/furniture-ar/start.sh

# Stop application
/opt/furniture-ar/stop.sh

# Restart application
/opt/furniture-ar/restart.sh

# Update to latest version
/opt/furniture-ar/update.sh
```

### View Logs
```bash
# View all logs
/opt/furniture-ar/logs.sh

# View specific service logs
/opt/furniture-ar/logs.sh app
/opt/furniture-ar/logs.sh db
/opt/furniture-ar/logs.sh redis
/opt/furniture-ar/logs.sh queue
```

### Database Operations
```bash
# Backup database
/opt/furniture-ar/backup-db.sh

# Restore from backup
/opt/furniture-ar/restore-db.sh backups/db/backup-20251221-120000.sql.gz

# Access MySQL console
docker compose exec db mysql -u root -p
```

### Laravel Artisan Commands
```bash
# Run any artisan command
/opt/furniture-ar/artisan.sh <command>

# Examples:
/opt/furniture-ar/artisan.sh migrate
/opt/furniture-ar/artisan.sh cache:clear
/opt/furniture-ar/artisan.sh queue:work
/opt/furniture-ar/artisan.sh tinker
```

### Docker Commands
```bash
cd /opt/furniture-ar

# View running containers
docker compose ps

# View resource usage
docker stats

# Rebuild and restart
docker compose up -d --build

# Remove all containers and volumes (⚠️ WARNING: deletes data)
docker compose down -v
```

## Directory Structure

```
/opt/furniture-ar/
├── docker-compose.yml      # Main configuration
├── .env                    # Environment variables
├── start.sh               # Start script
├── stop.sh                # Stop script
├── restart.sh             # Restart script
├── update.sh              # Update script
├── logs.sh                # View logs
├── backup-db.sh           # Backup database
├── restore-db.sh          # Restore database
├── artisan.sh             # Run artisan commands
├── logs/
│   ├── app/              # Application logs
│   ├── nginx/            # Nginx logs
│   └── redis/            # Redis logs
├── backups/
│   └── db/               # Database backups
├── sql/                  # SQL files for initialization
└── public/
    └── images/           # Uploaded images
```

## Updating the Application

When a new version is released:

```bash
cd /opt/furniture-ar
./update.sh
```

This will:
1. Pull the latest Docker image
2. Stop current containers
3. Start new containers with the updated image
4. Display container status

## Troubleshooting

### Services Won't Start
```bash
# Check logs
/opt/furniture-ar/logs.sh

# Check Docker status
systemctl status docker

# Restart Docker
systemctl restart docker
```

### Database Connection Issues
```bash
# Check database container
docker compose ps db

# Check database logs
docker compose logs db

# Test connection
docker compose exec app php artisan tinker
>>> DB::connection()->getPdo();
```

### Permission Issues
```bash
# Fix storage permissions
docker compose exec app chown -R www-data:www-data /var/www/html/storage
docker compose exec app chmod -R 775 /var/www/html/storage
```

### Application Returns 500 Error
```bash
# Clear all caches
/opt/furniture-ar/artisan.sh cache:clear
/opt/furniture-ar/artisan.sh config:clear
/opt/furniture-ar/artisan.sh route:clear
/opt/furniture-ar/artisan.sh view:clear

# Restart application
/opt/furniture-ar/restart.sh
```

### Queue Not Processing Jobs
```bash
# Check queue worker
docker compose logs queue

# Restart queue worker
docker compose restart queue

# Manually process queue
/opt/furniture-ar/artisan.sh queue:work --once
```

## Security Recommendations

### 1. Change Default Passwords
Update all passwords in `.env` and `docker-compose.yml`

### 2. Enable HTTPS (SSL/TLS)
Install Certbot for free SSL certificates:
```bash
apt install certbot
certbot certonly --standalone -d yourdomain.com
```

### 3. Configure Firewall
```bash
# Check firewall status
ufw status

# Allow only necessary ports
ufw allow 22/tcp   # SSH
ufw allow 80/tcp   # HTTP
ufw allow 443/tcp  # HTTPS
ufw enable
```

### 4. Regular Backups
Set up automatic database backups:
```bash
# Add to crontab
crontab -e

# Backup every day at 2 AM
0 2 * * * /opt/furniture-ar/backup-db.sh
```

### 5. Keep System Updated
```bash
# Update regularly
apt update && apt upgrade -y

# Update Docker images
cd /opt/furniture-ar && ./update.sh
```

## Performance Optimization

### 1. Enable OPcache
Already configured in the Docker image

### 2. Optimize Database
```bash
/opt/furniture-ar/artisan.sh optimize
/opt/furniture-ar/artisan.sh config:cache
/opt/furniture-ar/artisan.sh route:cache
/opt/furniture-ar/artisan.sh view:cache
```

### 3. Monitor Resources
```bash
# Install monitoring tools
apt install htop iotop

# Monitor containers
docker stats
```

## Support

For issues or questions:
- GitHub: https://github.com/nguyentrungnghia1802/Furniture-AR-Project
- Create an issue with logs and configuration details

## License

This project is licensed under the MIT License.
