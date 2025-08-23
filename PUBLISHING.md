# Publishing Your Package

This guide will walk you through publishing your Laravel Entity Generator package to make it available to the Laravel community.

## 🚀 Publishing to Packagist (Public Distribution)

### Step 1: Prepare Your Repository

1. **Update your GitHub repository:**
   ```bash
   git add .
   git commit -m "Prepare package for publishing"
   git push origin main
   ```

2. **Ensure your repository is public** on GitHub

### Step 2: Submit to Packagist

1. **Go to [Packagist.org](https://packagist.org/)**
2. **Sign up/Login** with your GitHub account
3. **Click "Submit Package"**
4. **Enter your repository URL:** `https://github.com/leon-99/laravel-entity-generator`
5. **Click "Check"** - Packagist will automatically detect your `composer.json`
6. **Click "Submit"** to submit for approval

### Step 3: After Approval

Once approved, your package will be available at:
```
https://packagist.org/packages/win-aung/laravel-entity-generator
```

Users can install it with:
```bash
composer require win-aung/laravel-entity-generator
```

## 🔄 Automatic Updates

After your package is on Packagist:

1. **Push updates to GitHub**
2. **Create a new tag** for version updates:
   ```bash
   git tag v1.0.0
   git push origin v1.0.0
   ```
3. **Packagist will automatically update** when you push new tags

## 🧪 Testing Before Publishing

### Local Testing

1. **In a Laravel project, add local repository:**
   ```bash
   composer config repositories.local path ../laravel-entity-generator
   ```

2. **Require the package:**
   ```bash
   composer require win-aung/laravel-entity-generator:dev-master
   ```

3. **Test the command:**
   ```bash
   php artisan make:entity TestEntity
   ```

### Run Tests

```bash
composer test
```

## 📋 Pre-Publishing Checklist

- [ ] All files are committed to Git
- [ ] Tests are passing (`composer test`)
- [ ] README.md is complete and accurate
- [ ] LICENSE.md is present
- [ ] composer.json has correct metadata
- [ ] Repository is public on GitHub
- [ ] Package name is unique (check Packagist)

## 🎯 Package Information

Your package details:
- **Name:** `win-aung/laravel-entity-generator`
- **GitHub:** `https://github.com/leon-99/laravel-entity-generator`
- **Description:** Laravel CRUD entity generator with service pattern
- **License:** MIT
- **Keywords:** laravel, crud, generator, entity, service

## 🆘 Troubleshooting

### Package Name Already Taken

If `win-aung/laravel-entity-generator` is taken, try:
- `leon-99/laravel-entity-generator`
- `leon-99/crud-generator`
- `leon-99/laravel-crud-generator`

### Validation Errors

Common issues:
- **Missing required fields** in composer.json
- **Invalid namespace** format
- **Missing dependencies** in require section

### Approval Delays

- Packagist usually approves within 24 hours
- Ensure your repository is public
- Check that all links in composer.json are valid

## 🌟 After Publishing

1. **Share on social media** (Twitter, LinkedIn, Laravel communities)
2. **Post on Laravel News** or similar sites
3. **Respond to issues** and pull requests
4. **Maintain and update** regularly

## 📚 Resources

- [Packagist Documentation](https://packagist.org/about)
- [Composer Documentation](https://getcomposer.org/doc/)
- [Laravel Package Development](https://laravel.com/docs/packages)

---

**Good luck with your package! 🎉**
