$targetFiles = @(
    ".\README.md",
    "..\attemptpassword\README.md",
    "..\failgrade\README.md",
    "..\competency\README.md",
    "..\competency-report\README.md"
)

$securitySection = @"
## 🔒 Security & Code Compliance

This plugin has been audited and hardened according to Moodle's strict security and quality guidelines:

- **CSRF Protection:** Standard Moodle session key verification (`require_sesskey()`) is enforced on all state-mutating actions (such as queueing calculations).
- **SQL Injection Prevention:** Every query utilizes Moodle's Database API (`$DB`) with parameter bindings and named placeholders (`:named`), completely avoiding raw SQL interpolation and protecting against injection attacks.
- **Input Sanitization:** Direct superglobals (`$_GET`, `$_POST`, `$_REQUEST`) are strictly forbidden. Input retrieval uses standard Moodle validation helpers like `required_param()` and `optional_param()` with strict parameter type filters (`PARAM_INT`, `PARAM_BOOL`, etc.).
- **Capability Controls:** Page entry points verify course contexts with `require_login()` and validate explicit capabilities (e.g. `mod/quiz:viewreports`, `local_competency_report:viewreports`) via `require_capability()`.
- **Frankenstyle & Namespace Compliance:** Database tables and autoloaded classes are strictly prefixed and namespaced (e.g. `\local_competency_report\...` or `\quizaccess_failgrade\...`) preventing any class name or table name collisions.
- **Coding Standards:** Code is audited via `PHP_CodeSniffer` (PHPCS) enforcing clean syntax, proper DocBlocks, and standard Moodle conventions.

---

"@

foreach ($file in $targetFiles) {
    if (Test-Path $file) {
        $content = [System.IO.File]::ReadAllText($file, [System.Text.Encoding]::UTF8)
        # Use ASCII search to avoid encoding parsing issues inside script
        if ($content -notmatch 'Security & Code Compliance') {
            # Match start of line ##, then any chars, then License & Credits
            $content = $content -replace '(?mi)^##\s+.*License\s+&\s+Credits', "$securitySection`r`n## 📄 License & Credits"
            $utf8NoBOM = New-Object System.Text.UTF8Encoding $false
            [System.IO.File]::WriteAllText($file, $content, $utf8NoBOM)
            Write-Host "Updated README: $file"
        } else {
            Write-Host "Already updated: $file"
        }
    }
}
