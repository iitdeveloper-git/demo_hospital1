# Security Specifications & Hardening Rules

AarogyaCare enforces enterprise-grade security hardening policies across all layers.

## Implemented Security Features
1. **HTTPS Enforcement:** Forces SSL redirections.
2. **Secure Headers Middleware:** Registers Content-Security-Policy (CSP), HSTS, and XSS protectors on HTTP requests.
3. **Audit Trails:** Automatic event logging for patient registry edits, billing changes, and configuration settings.
4. **Token Authentication:** Secure API tokens for mobile API endpoints.
5. **Input Validation:** Strict rules on image file formats, parameters, and query bindings protecting against SQL-Injection and Cross-Site-Scripting (XSS).
