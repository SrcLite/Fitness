# Yii 2 Basic Project Template

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Build Status](https://github.com/yiisoft/yii2-app-basic/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-basic/actions?query=workflow%3Abuild)
[![License](https://img.shields.io/badge/license-BSD--3--Clause-blue.svg)](https://github.com/yiisoft/yii2-app-basic/blob/master/LICENSE.md)

<div align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1>Yii 2 Basic Project Template</h1>
    <p>A professional foundation for your PHP applications</p>
    <br>
</div>

Yii 2 Basic Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application designed for rapidly creating small to medium-sized web projects. This template provides essential features including user authentication, contact forms, and a clean MVC architecture to help you start developing immediately.

## ✨ Features

- **Modern MVC Architecture** - Clean separation of concerns
- **User Authentication** - Complete login/logout functionality
- **Contact Form** - Ready-to-use contact page with validation
- **Bootstrap Integration** - Responsive UI components
- **Testing Ready** - Pre-configured for unit and functional tests
- **Security Best Practices** - CSRF protection, input validation, and secure defaults
- **Database Abstraction** - Powerful ActiveRecord implementation
- **Internationalization Support** - Built-in translation capabilities

## 🚀 Quick Start

### Prerequisites

- PHP 5.6.0 or higher
- Composer installed
- Web server (Apache/Nginx) or PHP built-in server
- Database (MySQL, PostgreSQL, SQLite)

### Installation via Composer

```bash
# Create new project
composer create-project --prefer-dist yiisoft/yii2-app-basic my-project

# Navigate to project directory
cd my-project

# Initialize application (set cookie validation key)
php init
```

### Configuration

1. **Database Setup**: Edit `config/db.php` with your database credentials:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=my_database',
    'username' => 'root',
    'password' => 'password',
    'charset' => 'utf8',
];
```

2. **Create Database**: Manually create your database before running migrations

3. **Run Migrations**: Set up the database schema

```bash
php yii migrate
```

4. **Start Development Server**:

```bash
php yii serve
```

Visit `http://localhost:8080` to see your application running!

## 📁 Project Structure

```
basic/
├── assets/              # Asset bundle definitions
├── commands/            # Console commands
├── config/              # Application configurations
│   ├── console.php      # Console application configuration
│   ├── db.php           # Database configuration
│   └── web.php          # Web application configuration
├── controllers/         # Controller classes
├── mail/                # Email templates
├── models/              # Model classes
├── runtime/             # Runtime files (logs, cache)
├── tests/               # Test suites
├── vendor/              # Composer dependencies
├── views/               # View files
├── web/                 # Web accessible directory
│   ├── css/             # CSS files
│   ├── js/              # JavaScript files
│   └── index.php        # Entry script
└── yii                  # Console application executable
```

## 🧪 Testing

### Running Tests

This template comes with complete testing setup using [Codeception](http://codeception.com/):

```bash
# Run all tests
vendor/bin/codecept run

# Run specific test types
vendor/bin/codecept run unit      # Unit tests
vendor/bin/codecept run functional # Functional tests
vendor/bin/codecept run acceptance # Acceptance tests (requires setup)
```

### Test Configuration

- **Unit Tests**: Test individual components and classes
- **Functional Tests**: Test application functionality without browser
- **Acceptance Tests**: Test application in real browser environment

For acceptance testing, you'll need to set up Selenium Server and configure it in `tests/acceptance.suite.yml`.

## 🐳 Docker Support

This project includes Docker configuration for easy development environments:

```bash
# Build and start containers
docker-compose up -d

# Install dependencies
docker-compose run --rm php composer install

# Run migrations
docker-compose run --rm php php yii migrate

# Access application
open http://localhost:8000
```

## 🔧 Customization Tips

### Adding New Pages

1. Create controller in `controllers/` directory
2. Define actions in your controller
3. Create view files in `views/controller-name/`
4. Configure routes in `config/web.php`

### Theming

Override default views or create custom asset bundles to customize the appearance of your application.

### Database Operations

Use Yii's powerful ActiveRecord for all database operations:

```php
// Create new record
$model = new MyModel();
$model->attributes = $data;
$model->save();

// Query data
$records = MyModel::find()->where(['status' => 1])->all();
```

## 📚 Learning Resources

- [Yii Framework Official Guide](http://www.yiiframework.com/doc-2.0/guide-index.html)
- [Yii API Documentation](http://www.yiiframework.com/doc-2.0/index.html)
- [Yii Forum](http://www.yiiframework.com/forum/)
- [Yii Extension Library](http://www.yiiframework.com/extensions/)

## 🤝 Contributing

We welcome contributions! Please see our [contributing guidelines](CONTRIBUTING.md) for details.

## 📄 License

Yii 2 Basic Project Template is released under the BSD-3-Clause License. See [LICENSE](LICENSE.md) for details.

## 🆘 Support

- [Official Yii Documentation](http://www.yiiframework.com/doc-2.0/)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/yii2)
- [Yii Forum](http://www.yiiframework.com/forum/)

---

<div align="center">
    <sub>Built with ❤️ by the <a href="https://github.com/yiisoft">Yii team</a> and contributors</sub>
</div>
