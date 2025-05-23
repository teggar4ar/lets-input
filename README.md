# Input Penduduk (Population Data Management System)

A comprehensive Laravel-based web application for managing population data with clean architecture principles and maintainable code structure.

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Architecture](#architecture)
- [Installation](#installation)
- [Usage](#usage)
- [API Documentation](#api-documentation)
- [File Structure](#file-structure)
- [Contributing](#contributing)
- [License](#license)

## 🎯 Overview

Input Penduduk is a robust population data management system built with Laravel 11. The application has been completely refactored to follow clean code principles, SOLID principles, and modern PHP best practices, eliminating spaghetti code and improving maintainability.

### Key Improvements Made

- **Service Layer Pattern**: Business logic extracted from controllers to dedicated service classes
- **Repository Pattern**: Data access logic abstracted to repository classes
- **Form Request Validation**: Validation logic moved to dedicated FormRequest classes
- **Dependency Injection**: Proper dependency injection throughout the application
- **Type Safety**: Full type hints and return type declarations
- **Error Handling**: Comprehensive error handling with try-catch blocks

## ✨ Features

- **Population Management**: Complete CRUD operations for population data
- **Family Management**: Manage families and their members
- **Advanced Filtering**: Filter by gender, religion, education, job, marital status, age range
- **Data Export**: Export filtered data to Excel format
- **Address Management**: Comprehensive address handling with coordinates
- **User Authentication**: Secure user authentication and profile management
- **Responsive Design**: Modern, responsive UI built with Tailwind CSS

## 🏗️ Architecture

### Clean Architecture Implementation

The application follows clean architecture principles with clear separation of concerns:

```
┌─────────────────┐
│   Controllers   │ ← HTTP Layer (Routes, Requests, Responses)
├─────────────────┤
│    Services     │ ← Business Logic Layer
├─────────────────┤
│  Repositories   │ ← Data Access Layer
├─────────────────┤
│     Models      │ ← Domain Models (Eloquent)
└─────────────────┘
```

### Service Layer

- **PendudukService**: Handles all population-related business logic
- **ExportService**: Manages data export functionality

### Repository Layer

- **PendudukRepository**: Abstracts population data access
- **ReferenceDataRepository**: Handles reference data (religions, jobs, etc.)

### Form Requests

- **StoreFamilyRequest**: Validates family creation data
- **UpdatePendudukRequest**: Validates population update data
- **StoreFamilyMemberRequest**: Validates family member addition

## 🛠️ Installation

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL/SQLite database

### Setup Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd input-pend
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   # Configure your database settings in .env
   php artisan migrate
   php artisan db:seed
   ```

5. **Build assets**
   ```bash
   npm run build
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

## 🚀 Usage

### Population Management

1. **View Population Data**
   - Navigate to `/penduduk` to view the population listing
   - Use filters to search and filter data
   - Sort by various columns

2. **Add New Family**
   - Click "Tambah Keluarga" button
   - Fill in family and address information
   - Add family members
   - Submit the form

3. **Edit Population Data**
   - Click edit button on any population record
   - Update information as needed
   - Save changes

4. **Export Data**
   - Use the export functionality to download filtered data
   - Supports Excel format with custom naming based on filters

### API Endpoints

The application provides RESTful endpoints for population management:

- `GET /penduduk` - List population with filters
- `POST /penduduk` - Create new family
- `GET /penduduk/{id}` - Show specific population record
- `PUT /penduduk/{id}` - Update population record
- `DELETE /penduduk/{id}` - Delete population record
- `GET /penduduk/add-family-member/{kk}` - Add family member form
- `POST /penduduk/store-family-member` - Store new family member

## 📁 File Structure

### Core Application Files

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── PendudukController.php    # Population management
│   │   ├── ExportController.php      # Data export
│   │   └── ProfileController.php     # User profiles
│   └── Requests/
│       ├── StoreFamilyRequest.php    # Family validation
│       ├── UpdatePendudukRequest.php # Update validation
│       └── StoreFamilyMemberRequest.php # Member validation
├── Services/
│   ├── PendudukService.php           # Population business logic
│   └── ExportService.php             # Export functionality
├── Repositories/
│   ├── PendudukRepository.php        # Population data access
│   └── ReferenceDataRepository.php   # Reference data access
├── Models/
│   ├── Penduduk.php                  # Population model
│   ├── Alamat.php                    # Address model
│   ├── Agama.php                     # Religion model
│   └── [other reference models]
└── Providers/
    └── AppServiceProvider.php        # Service registration
```

### Key Components

#### Controllers
- **PendudukController**: Handles HTTP requests for population management
- **ExportController**: Manages data export requests
- **ProfileController**: User profile management

#### Services
- **PendudukService**: Contains business logic for population operations
- **ExportService**: Handles export logic and file generation

#### Repositories
- **PendudukRepository**: Database operations for population data
- **ReferenceDataRepository**: Reference data retrieval

#### Models
- **Penduduk**: Main population model with relationships
- **Alamat**: Address model
- Various reference models (Agama, Pekerjaan, etc.)

## 🔧 Configuration

### Service Registration

Services and repositories are automatically registered in `AppServiceProvider`:

```php
// Services
$this->app->bind(PendudukService::class, ...);
$this->app->bind(ExportService::class, ...);

// Repositories
$this->app->bind(PendudukRepository::class, ...);
$this->app->bind(ReferenceDataRepository::class, ...);
```

### Database Configuration

The application supports multiple database drivers. Configure in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=input_pend
DB_USERNAME=root
DB_PASSWORD=
```

## 🧪 Testing

Run the test suite:

```bash
php artisan test
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Code Standards

- Follow PSR-12 coding standards
- Use type hints and return type declarations
- Write descriptive method and variable names
- Add proper PHPDoc comments
- Maintain the service/repository pattern

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🏆 Credits

- Built with [Laravel](https://laravel.com/)
- UI components with [Tailwind CSS](https://tailwindcss.com/)
- Excel export with [Laravel Excel](https://laravel-excel.com/)

---

**Note**: This application has been completely refactored from spaghetti code to clean, maintainable code following modern PHP and Laravel best practices.

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
