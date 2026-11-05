# Intentional AI Scan fixtures

These endpoints deliberately contain five vulnerabilities for a pull request
scan. They are not production code or registered WebGoat lessons. Do not deploy
them, expose them to a network, use real data, or merge them into production.
Run only in a disposable local environment with no credentials or sensitive
files. Uploaded PHP executes with the server process's permissions.

| File | Input | Intended severity | Intended finding |
| --- | --- | --- | --- |
| `command.php` | POST `command` | Critical | Unauthenticated OS command injection (CWE-78) |
| `evaluate.php` | POST `code` | Critical | Unauthenticated arbitrary PHP code execution (CWE-95) |
| `upload.php` | Multipart POST `file` | Critical | Unrestricted executable file upload (CWE-434) |
| `employees.php` | GET `id` | High | SQL injection exposing other employee records (CWE-89) |
| `fetch.php` | GET `url` | High | SSRF reaching internal HTTP services (CWE-918) |

The three intended critical findings permit server-side execution. The two
intended high findings permit unauthorized data access or internal network
requests. These are expected classifications, not guaranteed scanner output:
AI Scan determines whether to report each finding and its severity.

## Isolated local setup

Requires PHP with PDO SQLite and cURL extensions. From the repository root:

```sh
php -S 127.0.0.1:8080 -t ai-scan-fixtures
```

This serves only the fixtures and bypasses the legacy application's Apache
rewrite rules. The employee database uses synthetic records in memory; no
application database configuration is required. Successful uploads are saved
under `ai-scan-fixtures/uploads/` and are web-accessible at `/uploads/<filename>`,
including PHP files. Remove each uploaded test file after testing.

There are intentionally no authentication checks or fixes around these five
vulnerable sinks. Other inputs and output formats are kept minimal to avoid
unrelated findings. Close the test PR without merging after evaluating the scan.
