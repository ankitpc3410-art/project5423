-- Optional migration for displaying company logos on homepage job cards.
-- Run this once in phpMyAdmin after selecting the job_portal database.
ALTER TABLE companies ADD COLUMN company_logo VARCHAR(255) DEFAULT NULL;

-- Example (update the ID and file path to match your company):
-- UPDATE companies SET company_logo = 'uploads/company_logos/acme.png' WHERE id = 1;
