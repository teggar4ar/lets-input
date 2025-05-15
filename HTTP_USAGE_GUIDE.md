# HTTP Protocol Usage Guide

This document explains how to configure the Input Penduduk application to run over HTTP in production environments.

## Why HTTP Support?

While HTTPS is strongly recommended for any production deployment handling sensitive data, there are specific scenarios where HTTP might be required:

1. Internal networks completely isolated from the internet
2. Legacy systems that cannot support HTTPS
3. Development or testing environments
4. Network configurations with TLS termination at a higher level

## Configuration Steps

### 1. Environment Variables

Edit your `.env` file to include:

```
# Set to false to allow HTTP protocol
FORCE_HTTPS=false

# Adjust session cookie settings for HTTP
SESSION_SECURE_COOKIE=false
```

### 2. Application Impact

When running with `FORCE_HTTPS=false`:

- HSTS (HTTP Strict Transport Security) headers will not be applied
- Session cookies will not have the 'secure' flag
- Other security headers will still be applied
- All application functionality remains the same

### 3. Security Considerations

When using HTTP instead of HTTPS:

- Data transmitted between server and client is not encrypted
- Greater vulnerability to man-in-the-middle attacks
- Password and sensitive data transmission is less secure
- Cookies are more vulnerable to theft

### 4. Recommended Compensating Controls

If you must use HTTP, implement these additional security measures:

1. **Network Security**
   - Restrict application access to trusted IP ranges
   - Use VPN for remote access
   - Implement network-level encryption where possible

2. **Server Configuration**
   - Configure firewalls to restrict traffic
   - Consider using a reverse proxy with TLS termination
   - Monitor network traffic for suspicious activity

3. **User Education**
   - Inform users about the security implications
   - Establish clear data handling policies
   - Implement stronger authentication methods

## Best Practices

1. **Use HTTP only when necessary**
   - Always prefer HTTPS for production
   - Consider HTTP only for completely isolated networks

2. **Regular Security Reviews**
   - Periodically assess if HTTP is still necessary
   - Review security controls for HTTP traffic
   - Evaluate options for migrating to HTTPS

3. **Documentation**
   - Document the reason for using HTTP
   - Maintain a record of compensating controls
   - Include HTTP usage in security risk assessments

## Technical Implementation

The application has been designed to conditionally apply security features based on the `FORCE_HTTPS` setting:

- `SecureHeaders` middleware only applies HTTPS-specific headers when appropriate
- Session configuration adapts based on environment variables
- All core functionality works identically regardless of protocol

For more detailed information, refer to:
- [TECHNICAL_REFERENCE.md](./TECHNICAL_REFERENCE.md)
- [SECURE_DEPLOYMENT_GUIDE.md](./SECURE_DEPLOYMENT_GUIDE.md)
- [SECURITY_POLICY.md](./SECURITY_POLICY.md)

---

*Last updated: May 15, 2025*
