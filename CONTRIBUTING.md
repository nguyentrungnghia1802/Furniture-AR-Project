# Contributing to Furniture AR Project

Thank you for your interest in contributing to the Furniture AR Project! This document provides guidelines and instructions for contributing.

## How to Contribute

### Reporting Bugs

If you find a bug, please create an issue with:
- Clear description of the bug
- Steps to reproduce
- Expected behavior
- Actual behavior
- Environment details (OS, browser, device)
- Screenshots if applicable

### Suggesting Features

Feature suggestions are welcome! Please create an issue with:
- Clear description of the feature
- Use case/motivation
- Proposed implementation (if any)
- Examples or mockups (if applicable)

### Code Contributions

1. **Fork the Repository**
   ```bash
   git clone https://github.com/nguyentrungnghia1802/Furniture-AR-Project.git
   cd Furniture-AR-Project
   ```

2. **Create a Branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```

3. **Make Your Changes**
   - Follow existing code style
   - Write clear commit messages
   - Test your changes thoroughly
   - Update documentation if needed

4. **Test Your Changes**
   ```bash
   # Run tests if available
   php artisan test
   
   # Check code style
   ./vendor/bin/pint
   ```

5. **Commit Your Changes**
   ```bash
   git add .
   git commit -m "Add feature: description"
   ```

6. **Push to Your Fork**
   ```bash
   git push origin feature/your-feature-name
   ```

7. **Create a Pull Request**
   - Go to the original repository
   - Click "New Pull Request"
   - Provide clear description of changes
   - Reference any related issues

## Development Guidelines

### Code Style

- Follow PSR-12 coding standards for PHP
- Use meaningful variable and function names
- Add comments for complex logic
- Keep functions small and focused

### Laravel Best Practices

- Use Eloquent ORM for database operations
- Follow MVC pattern
- Use form requests for validation
- Implement proper error handling
- Use Laravel's built-in helpers

### Database Migrations

- Always create reversible migrations
- Use descriptive migration names
- Test up() and down() methods
- Don't modify existing migrations

### Frontend

- Use Bootstrap classes consistently
- Ensure responsive design
- Test on multiple browsers
- Optimize images and assets
- Follow accessibility guidelines

### AR Features

- Test on actual devices (Android/iOS)
- Optimize 3D models for performance
- Provide fallbacks for unsupported devices
- Document AR-specific features

## Areas for Contribution

### High Priority
- [ ] User authentication system
- [ ] Shopping cart functionality
- [ ] Product search and filtering
- [ ] Admin dashboard
- [ ] Unit and feature tests

### Medium Priority
- [ ] Product categories management
- [ ] Customer reviews and ratings
- [ ] Wishlist functionality
- [ ] Order management
- [ ] Email notifications

### Low Priority
- [ ] Social media integration
- [ ] Multi-language support
- [ ] Dark mode theme
- [ ] Product recommendations
- [ ] Analytics dashboard

### AR Enhancements
- [ ] Multiple 3D views per product
- [ ] AR measurement tools
- [ ] Custom AR backgrounds
- [ ] AR sharing features
- [ ] WebXR support

## Testing

Before submitting a pull request:

1. **Manual Testing**
   - Test all modified features
   - Check on different screen sizes
   - Test file uploads
   - Verify AR functionality

2. **Browser Testing**
   - Chrome (desktop and mobile)
   - Firefox
   - Safari (desktop and iOS)
   - Edge

3. **Device Testing** (if AR changes)
   - Android device with ARCore
   - iOS device with ARKit
   - Desktop browsers

## Documentation

Please update documentation when:
- Adding new features
- Changing existing functionality
- Modifying API endpoints
- Adding configuration options

Update these files as needed:
- `README.md` - Main documentation
- `SETUP_GUIDE.md` - Installation instructions
- `AR_IMPLEMENTATION.md` - AR technical details
- `EXAMPLES.md` - Usage examples

## Commit Messages

Use clear and descriptive commit messages:

```
Good:
- "Add user authentication system"
- "Fix product image upload bug"
- "Update AR viewer documentation"

Avoid:
- "Fix bug"
- "Update"
- "Changes"
```

## Code Review Process

1. Maintainer reviews your pull request
2. Feedback provided if changes needed
3. You make requested changes
4. Maintainer approves and merges

## Getting Help

- Open an issue for questions
- Check existing documentation
- Review closed issues and PRs
- Contact maintainer if needed

## License

By contributing, you agree that your contributions will be licensed under the MIT License.

## Recognition

Contributors will be acknowledged in:
- Repository contributors list
- Release notes (for significant contributions)
- Documentation (when appropriate)

## Questions?

If you have questions about contributing, please open an issue with the "question" label.

Thank you for contributing to the Furniture AR Project! 🎉
