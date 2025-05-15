# Secure Deployment Guide for Input Penduduk Application

This document provides guidelines for securely deploying the Input Penduduk application to a production environment.

## Pre-Deployment Security Checklist

### Environment Configuration
- [ ] Set up `.env` file with secure values
- [ ] Keep `.env` file out of version control
- [ ] Set `APP_ENV=production` in production
- [ ] Set `APP_DEBUG=false` in production
- [ ] Generate a secure `APP_KEY` using `php artisan key:generate`

### Database Configuration
- [ ] Use a dedicated database user with limited permissions
- [ ] Set a strong database password
- [ ] Ensure database is not publicly accessible
- [ ] Enable SSL for database connections
- [ ] Set `DB_CONNECTION` and other database variables correctly

### File Permissions
- [ ] Ensure proper ownership (typically www-data or nginx)
- [ ] Set directories to 755 (drwxr-xr-x)
- [ ] Set files to 644 (rw-r--r--)
- [ ] Set storage and bootstrap/cache to be writable by web server (775)
- [ ] Ensure `.env` is readable only by the web server process

## Server Configuration

### Web Server (Apache or Nginx)
- [ ] Configure HTTPS with strong SSL/TLS settings (recommended)
- [ ] Enable HTTP/2 for better performance
- [ ] Configure HTTP access if required (see HTTP Protocol Configuration below)
- [ ] Implement proper server hardening
- [ ] Set secure headers (already handled by SecureHeaders middleware)

### PHP Configuration
- [ ] Use latest stable PHP version
- [ ] Set secure `php.ini` settings:
  - `display_errors = Off`
  - `log_errors = On`
  - `expose_php = Off`
  - `max_execution_time = 30`
  - `memory_limit = 256M`
  - `post_max_size = 20M`
  - `upload_max_filesize = 10M`
  - `allow_url_include = Off`
  - `session.cookie_httponly = 1`
  - `session.cookie_secure = 1`
  - `session.cookie_samesite = Strict`
  - `session.use_strict_mode = 1`

### HTTP Protocol Configuration

If you need to run the application over HTTP in production:

1. Configure environment variables in `.env`:
   ```
   FORCE_HTTPS=false
   SESSION_SECURE_COOKIE=false
   ```

2. Security considerations when using HTTP:
   - The application will not use HSTS headers
   - Session cookies will not have the 'secure' flag
   - Be aware that data transmitted over HTTP is not encrypted
   - Consider using a secure VPN if deploying on an internal network
   - Implement network-level security controls to protect unencrypted traffic

3. Server configuration recommendations for HTTP-only deployments:
   - Restrict access to trusted IP ranges when possible
   - Implement additional network security measures
   - Consider using a reverse proxy with TLS termination if feasible

> **Note**: Using HTTPS is still highly recommended for any production deployment handling sensitive data. HTTP should only be used in specific circumstances where HTTPS is not feasible, such as in completely isolated internal networks.

### Firewall Configuration
- [ ] Enable firewall (UFW, iptables, etc.)
- [ ] Allow only necessary ports (80, 443, SSH)
- [ ] Restrict SSH access to trusted IPs
- [ ] Implement rate limiting at server level

## Laravel-Specific Deployment Steps

1. **Optimize Autoloader**
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

2. **Optimize Configuration Loading**
   ```bash
   php artisan config:cache
   ```

3. **Optimize Route Loading**
   ```bash
   php artisan route:cache
   ```

4. **Compile Blade Views**
   ```bash
   php artisan view:cache
   ```

5. **Run Database Migrations**
   ```bash
   php artisan migrate --force
   ```

6. **Generate Asset Files**
   ```bash
   npm run build
   ```

7. **Set Up Task Scheduling**
   ```bash
   * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
   ```

## Post-Deployment Security Verification

1. **Run Security Scan**
   - Use tools like OWASP ZAP or similar scanners
   - Check for common vulnerabilities

2. **Verify All Middleware**
   - Ensure all security middleware is properly running:
     - SecureHeaders
     - PreventXssAttacks
     - SqlInjectionProtection
     - ValidateFileUploads
     - DetectSuspiciousRequests
     - StrongPasswordPolicy
     - RateLimitLogin
     - ApiRateLimiter (for API routes)

3. **Test Authentication System**
   - Verify password policies are enforced
   - Check rate limiting on login attempts
   - Test account lockout functionality

4. **Monitor for Issues**
   - Set up proper logging
   - Configure email notifications for critical errors
   - Implement security monitoring

## Maintenance and Updates

1. **Regular Updates**
   - Keep Laravel framework updated
   - Update all dependencies regularly
   - Apply security patches promptly

2. **Backup Strategy**
   - Regular database backups
   - File system backups
   - Test restoration procedures

3. **Implement Monitoring**
   - Server resource monitoring
   - Application error monitoring
   - Security event monitoring

## Emergency Response Plan

1. **Security Incident Response**
   - Document steps to contain and mitigate security breaches
   - Assign responsibilities
   - Create communication plan

2. **Rollback Procedure**
   - Document how to rollback to previous versions
   - Test rollback procedures

3. **Contact Information**
   - Maintain emergency contact information
   - Document escalation procedures

---

**Note:** This deployment guide should be updated periodically to reflect the latest security best practices. Always test any security measures in a staging environment before deploying to production.
