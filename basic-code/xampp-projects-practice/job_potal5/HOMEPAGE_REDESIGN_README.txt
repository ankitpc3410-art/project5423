JOBVALA HOMEPAGE REDESIGN

Files updated:
- index.php: new hero section, homepage job search, redesigned latest-job cards, company logo support/fallback initials.
- assets/css/style.css: responsive visual styling for hero, search bar, cards, and call-to-action.
- includes/header.php: corrected document structure and added Bootstrap Icons.
- includes/navbar.php: refreshed responsive navigation while preserving role-specific links.
- includes/footer.php: updated footer.
- database_migration_company_logo.sql: optional SQL migration to add a company_logo column.

INSTALLATION
1. Back up your current project folder first.
2. Extract this ZIP and copy the updated files/folders into your existing job_portal folder, overwriting the matching files.
3. Keep your existing config/database.php and other project files unchanged.
4. For company logos, run database_migration_company_logo.sql in phpMyAdmin once. If the column already exists, do not run it again.
5. Put logo image files in uploads/company_logos/ and set companies.company_logo to a relative path such as uploads/company_logos/acme.png.
6. Open http://localhost/job_portal/ in your browser.

NOTES
- The homepage works if company_logo has not been added yet; it shows a letter placeholder instead.
- The hero visual is built with CSS so no extra background image download is required.
- Bootstrap, Bootstrap Icons, and Google Fonts are loaded from CDNs, so internet access may be needed for those external assets.
- Existing project database settings are intentionally left unchanged. Do not share database passwords publicly.
