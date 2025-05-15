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

### Database Tables

The application uses several database tables to store and manage data. Here are some key tables with their important fields:

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

#### Reference Tables

The application uses various reference tables to store standardized values:

| Table Name            | Primary Field              | Field Length | Description                        |
|-----------------------|----------------------------|-------------:|------------------------------------| 
| agamas                | nama_agama                 | 255          | Religions                          |
| pendidikans           | nama_pendidikan            | 255          | Education levels                   |
| pendidikan_sedangs    | nama_pendidikan_sedangs    | 100          | Current education status           |
| pekerjaans            | nama_pekerjaan             | 255          | Occupations                        |
| stat_kawins           | nama_status_kawin          | 255          | Marital status                     |
| stat_hub_keluargas    | nama_status_hub_keluarga   | 255          | Family relationship status         |
| gol_darahs            | nama_golongan_darah        | 255          | Blood types                        |
| cacats                | nama_cacat                 | 255          | Disability types                   |
| cara_kbs              | nama_cara_kb               | 255          | Family planning methods            |
| stat_rekams           | nama_status_rekam          | 255          | ID card recording status           |
| stat_dasars           | nama_status_dasar          | 255          | Basic population status            |
| asuransis             | nama_asuransi              | 255          | Insurance types                    |

> Note: Field lengths are important to consider when adding new reference data through seeders. The `pendidikan_sedangs` table in particular requires values to be under 100 characters.

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

- Database indexes are in place for commonly queried fields:
  - Indexed fields include `nama`, `no_kk` on the `penduduks` table
  - `dusun` field is indexed on the `alamats` table for efficient filtering
  - These indexes were added on May 15, 2025 to improve search performance
- Pagination is implemented for large data sets
- Caching is configured for appropriate data
- Eager loading is used to prevent N+1 query problems

## Database Seeding

The application includes several database seeders to populate initial data:

1. **ReferenceTablesSeeder**
   - Populates all reference tables with standard values
   - Includes religions, education levels, occupations, etc.
   - Important note: Some reference data has character length limitations
     - The `pendidikan_sedangs` table's `nama_pendidikan_sedangs` field is limited to 100 characters

2. **UpdateDropdownValuesSeeder**
   - Updates or adds additional values to reference tables
   - Used for maintaining reference data consistency

3. **OperatorAccountsSeeder**
   - Creates default operator accounts (operator1-operator10)
   - Generates random secure passwords
   - Saves credentials to `storage/app/operator-credentials.txt`

To run all seeders:
```bash
php artisan db:seed
```

To run a specific seeder:
```bash
php artisan db:seed --class=ReferenceTablesSeeder
```

## Security Considerations

See [SECURITY_POLICY.md](./SECURITY_POLICY.md) for complete security implementation details.

### HTTP Protocol Support

The application has been configured to support both HTTP and HTTPS protocols in production:

1. **Configuration Options**
   - `FORCE_HTTPS` environment variable (defaults to `true`)
   - Controls whether strict HTTPS-only security features are enabled

2. **Conditional Security Headers**
   - HSTS headers are only applied when using HTTPS
   - Other security headers are applied regardless of protocol

3. **Cookie Security**
   - Session cookies' `secure` flag is tied to the `FORCE_HTTPS` setting
   - HTTP-only cookies are always enabled for security

4. **Implementation Details**
   - `SecureHeaders` middleware conditions HTTPS-specific headers based on the request protocol
   - Session configuration adapts based on environment variables
   - See [SECURE_DEPLOYMENT_GUIDE.md](./SECURE_DEPLOYMENT_GUIDE.md) for detailed deployment instructions

### Security Recommendations

While HTTP support is available, we strongly recommend:
- Using HTTPS in any environment handling sensitive data
- Limiting HTTP deployments to internal networks with additional security controls
- Implementing network-level security when HTTPS cannot be used

## Backup and Recovery

The application implements:

- Automatic daily database backups
- File system backups for uploads
- Point-in-time recovery capabilities

## Logging and Monitoring

- Application errors are logged to `storage/logs/laravel.log`
- Security events are logged with appropriate severity levels
- Suspicious activities trigger alerts
- Audit logs track user actions in the `audit_logs` table (added May 14, 2025)
  - Records user operations on sensitive data
  - Maintains compliance with data protection regulations
  - Provides accountability for all data modifications

## Development Workflow

1. Clone the repository
2. Set up local environment
3. Create feature branch
4. Implement changes
5. Run tests
6. Submit pull request
7. Code review
8. Merge to main branch

## Running the Application

### Development Environment

For local development:

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install

# Build assets
npm run build

# Set up environment
cp .env.example .env
php artisan key:generate

# Set up database
php artisan migrate
php artisan db:seed

# Start the development server
php artisan serve
```

### Troubleshooting Common Issues

1. **Database Seeder Issues**
   - If you encounter "String data, right truncated" errors during seeding, check the field lengths in your migration files and ensure they can accommodate the data being seeded.
   - For example, the `pendidikan_sedangs` table's `nama_pendidikan_sedangs` field must be at least 100 characters to fit all seed data.

2. **Permission Issues**
   - Ensure the `storage` and `bootstrap/cache` directories are writable by the web server
   - Run `chmod -R 775 storage bootstrap/cache` if needed

3. **File Upload Issues**
   - Check storage disk configuration in `config/filesystems.php`
   - Verify symlinks with `php artisan storage:link`

## Deployment

See [SECURE_DEPLOYMENT_GUIDE.md](./SECURE_DEPLOYMENT_GUIDE.md) for detailed deployment instructions.

---

*Last updated: May 15, 2025*
