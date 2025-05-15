# Input Penduduk Application

A secure Laravel application for managing population data.

## Security Features

This application has been hardened with the following security features:

1. **Secure Headers**
   - Implementation of critical HTTP security headers
   - Content Security Policy enforcement
   - XSS protection headers
   - HSTS implementation

2. **Input Validation & Sanitization**
   - XSS attack prevention
   - SQL injection protection
   - Input sanitization
   - Form request validation

3. **Authentication Security**
   - Brute force protection
   - Strong password policy enforcement
   - Secure session handling
   - CSRF protection

4. **File Upload Security**
   - MIME type validation
   - Extension validation
   - Malicious content scanning
   - Secure storage

5. **Request Monitoring**
   - Suspicious request detection
   - Rate limiting
   - API security

6. **Error Handling**
   - Custom error pages
   - No sensitive information leakage
   - Proper logging

7. **Database Protection**
   - Encrypted connections
   - Query parameterization
   - SQL injection prevention

8. **HTTPS Enforcement**
   - All traffic over HTTPS
   - Strict Transport Security

## Security Documentation

For more detailed information, please refer to:

- [Security Policy](./SECURITY_POLICY.md)
- [Secure Deployment Guide](./SECURE_DEPLOYMENT_GUIDE.md)

## Installation

1. Clone the repository
2. Copy `.env.example` to `.env` and configure your environment
3. Generate an application key:
   ```
   php artisan key:generate
   ```
4. Run migrations:
   ```
   php artisan migrate
   ```
5. Seed the database:
   ```
   php artisan db:seed
   ```

## Development

For local development:

```
php artisan serve
```

## Production Deployment

For production deployment, please follow the [Secure Deployment Guide](./SECURE_DEPLOYMENT_GUIDE.md).

## Security Reporting

If you discover any security vulnerabilities, please report them via email rather than using the public issue tracker.

## License

The application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

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
