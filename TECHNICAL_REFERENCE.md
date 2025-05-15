# Input Penduduk - Technical Reference

## System Architecture

The Input Penduduk application is built on the Laravel PHP framework, following the Model-View-Controller (MVC) architectural pattern. This document provides technical details for developers, administrators, and technical stakeholders.

## Technology Stack

- **Framework**: Laravel 10.x
- **PHP Version**: 8.1+
- **Database**: MySQL 8.0
- **Frontend**: Blade templating engine, Tailwind CSS, Alpine.js
- **JavaScript**: Vanilla JS with some jQuery
- **Authentication**: Laravel Breeze with customizations
- **Export Functionality**: Laravel Excel package (Maatwebsite)

## System Requirements

- PHP 8.1 or higher
- MySQL 8.0 or higher
- Composer
- Node.js and NPM (for frontend asset compilation)
- Web server (Apache or Nginx)
- SSL certificate for production environment

## Directory Structure

The application follows the standard Laravel directory structure with some custom additions:

```
input-pend/
├── app/
│   ├── Console/            # Console commands
│   ├── Exceptions/         # Exception handlers
│   ├── Exports/            # Export classes
│   ├── Http/
│   │   ├── Controllers/    # Application controllers
│   │   ├── Middleware/     # Custom middleware
│   │   └── Requests/       # Form requests for validation
│   ├── Models/             # Eloquent models
│   ├── Providers/          # Service providers
│   └── Services/           # Business logic services
├── bootstrap/              # App bootstrap files
├── config/                 # Configuration files
├── database/
│   ├── factories/          # Model factories
│   ├── migrations/         # Database migrations
│   └── seeders/            # Database seeders
├── public/                 # Publicly accessible files
├── resources/
│   ├── css/                # CSS files
│   ├── js/                 # JavaScript files
│   └── views/              # Blade templates
├── routes/                 # Route definitions
├── storage/                # App storage
└── tests/                  # Test files
```

## Data Model

### Core Entities

The application centers around the following key entities:

1. **Penduduk (Population)**
   - Main entity for individual person records
   - Connected to various reference tables for normalized data

2. **Alamat (Address)**
   - Contains location information
   - One address can be associated with multiple individuals

3. **Reference Data Tables**
   - Agama (Religion)
   - Pendidikan (Education)
   - Pekerjaan (Occupation)
   - StatKawin (Marital Status)
   - And many others

### Key Database Tables

#### Penduduks Table

Stores the core population data with the following key fields:

| Field                  | Type         | Description                          |
|------------------------|--------------|--------------------------------------|
| id                     | bigint       | Primary key                          |
| alamats_id             | bigint       | Foreign key to addresses             |
| no_kk                  | varchar(16)  | Family card number                   |
| nik                    | varchar(16)  | National ID number                   |
| nama                   | varchar(255) | Person's name                        |
| jk                     | enum         | Gender (laki-laki, perempuan)        |
| tmp_lahir              | varchar(100) | Place of birth                       |
| tgl_lahir              | date         | Date of birth                        |
| agamas_id              | bigint       | Foreign key to religions             |
| pendidikans_id         | bigint       | Foreign key to education levels      |
| pekerjaans_id          | bigint       | Foreign key to occupations           |
| stat_kawins_id         | bigint       | Foreign key to marital status        |
| stat_hub_keluargas_id  | bigint       | Foreign key to family relations      |
| (many more fields)     | various      | Additional demographic information   |
| created_at             | timestamp    | Record creation timestamp            |
| updated_at             | timestamp    | Record update timestamp              |
| deleted_at             | timestamp    | Soft delete timestamp (if deleted)   |

#### Alamats Table

Stores address information:

| Field           | Type         | Description                          |
|-----------------|--------------|--------------------------------------|
| id              | bigint       | Primary key                          |
| nama_alamat     | text         | Address text                         |
| dusun           | varchar(255) | Sub-village name                     |
| no_rt           | int          | RT number                            |
| no_rw           | int          | RW number                            |
| lat             | decimal      | Latitude (optional)                  |
| lng             | decimal      | Longitude (optional)                 |
| alamat_sekarang | text         | Current address (if different)       |
| created_at      | timestamp    | Record creation timestamp            |
| updated_at      | timestamp    | Record update timestamp              |

### Entity Relationships

- **One-to-Many**:
  - One address can belong to many individuals
  - One family card (no_kk) can be associated with multiple individuals

- **Many-to-One**:
  - Each individual belongs to one religion, education level, occupation, etc.
  - Each individual has one marital status, family relationship status, etc.

## Application Components

### Controllers

Key controllers include:

1. **PendudukController**
   - Handles CRUD operations for population data
   - Manages family data
   - Provides search and filtering functionality

2. **ExportController**
   - Handles data export to Excel format
   - Applies filters to exports

### Middleware

Custom security middleware includes:

1. **SecureHeaders**
   - Implements security HTTP headers
   - Prevents common web vulnerabilities

2. **PreventXssAttacks**
   - Sanitizes inputs
   - Detects and blocks XSS patterns

3. **SqlInjectionProtection**
   - Prevents SQL injection attempts
   - Monitors for suspicious SQL patterns

(See SECURITY_POLICY.md for complete middleware details)

### Services

1. **SecureFileUploadService**
   - Manages secure file uploads
   - Validates file content and safety

## API and Integrations

### Internal API

The application provides RESTful endpoints for potential integration:

- `GET /api/penduduk` - List population data (paginated)
- `GET /api/penduduk/{id}` - Get specific person details
- `POST /api/penduduk` - Create new person record
- `PUT /api/penduduk/{id}` - Update person record
- `DELETE /api/penduduk/{id}` - Delete person record

> Note: All API endpoints require proper authentication and authorization.

## Extending the Application

### Adding New Reference Data

To add a new reference data type (e.g., a new religion, occupation):

1. Access the relevant reference data management page
2. Add the new entry
3. The system will automatically make it available in dropdowns

### Custom Development

For custom development and extension:

1. Follow Laravel best practices
2. Adhere to the existing security measures
3. Write tests for new functionality
4. Document changes in this technical reference

## Performance Considerations

- Database indexes are in place for commonly queried fields
- Pagination is implemented for large data sets
- Caching is configured for appropriate data
- Eager loading is used to prevent N+1 query problems

## Security Considerations

See [SECURITY_POLICY.md](./SECURITY_POLICY.md) for complete security implementation details.

## Backup and Recovery

The application implements:

- Automatic daily database backups
- File system backups for uploads
- Point-in-time recovery capabilities

## Logging and Monitoring

- Application errors are logged to `storage/logs/laravel.log`
- Security events are logged with appropriate severity levels
- Suspicious activities trigger alerts

## Development Workflow

1. Clone the repository
2. Set up local environment
3. Create feature branch
4. Implement changes
5. Run tests
6. Submit pull request
7. Code review
8. Merge to main branch

## Deployment

See [SECURE_DEPLOYMENT_GUIDE.md](./SECURE_DEPLOYMENT_GUIDE.md) for detailed deployment instructions.

---

*Last updated: May 15, 2025*
