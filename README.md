# Moodle Block: Competency Report Overview

This is a Moodle dashboard block that provides students with a quick summary of their competency achievements across all courses.

## Features
- Shows total proficiencies achieved directly on the dashboard.
- When added to a specific course, provides a direct link to the full student competency report.

## Requirements & Compatibility

- **Moodle Compatibility:** Moodle 4.5+ (including Moodle 5.0+). Tested successfully against `MOODLE_405_STABLE`.
- **PHP Compatibility:** PHP 8.1, 8.2, and 8.3.
- **Database:** PostgreSQL (13+) or MySQL/MariaDB.
- **Dependencies:** Must be used in conjunction with `local_competency_report`.

## Installation
1. Ensure you have installed the dependencies (`qbank_competency` and `local_competency_report`).
2. Copy this folder to `blocks/competency_report`.
3. Go to **Site administration > Notifications** to complete the installation.
