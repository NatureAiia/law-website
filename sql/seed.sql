-- Seed data for au_law_school
-- Run after schema.sql

USE au_law_school;

-- Admin login: username "admin". Password hash below was generated with
-- password_hash('<see credentials handed to you separately>', PASSWORD_DEFAULT)-equivalent bcrypt.
-- To generate your own instead, run locally:
--   php -r "echo password_hash('yourpassword', PASSWORD_DEFAULT);"
-- and replace the hash string below.
INSERT INTO admins (username, password_hash, full_name) VALUES
('admin', '$2b$10$jXRCdjChElQxeeSmi4LDSeOGgT9jfNYmtXpFVpgtVbXGi49YkplPi', 'Site Administrator');

-- Real news items sourced from africau.edu/college/law/
INSERT INTO news_events (title, category, summary, body, entry_date) VALUES
(
    'School of Law strengthens community legal awareness through strategic outreaches',
    'news',
    'The School of Law continues to expand its community legal awareness programmes, taking legal education directly to underserved communities.',
    'The School of Law has strengthened its commitment to community legal awareness through a series of strategic outreach programmes. Students and lecturers have been working together to bring practical legal knowledge to communities that often lack easy access to legal information and services.\n\nThese outreach initiatives form part of the School''s broader mission to connect classroom learning with real-world impact, giving students hands-on experience while directly serving the public. The Law Clinic has played a central role in coordinating these efforts, identifying communities in need and organising awareness sessions on topics ranging from family law to land and human rights.\n\nThe School plans to continue and expand these outreach efforts in the coming terms.',
    '2026-02-20'
),
(
    'Recognition for competing in the Price Media Law Moot Competition, Oxford, UK',
    'news',
    'Africa University School of Law students earned recognition for their participation in the prestigious Price Media Law Moot Competition held in Oxford, UK.',
    'Students from the School of Law were recognised for their participation in the Price Media Law Moot Court Competition, an international competition held in Oxford, United Kingdom, focused on media law and freedom of expression issues.\n\nParticipating in an international moot competition of this calibre gave the School''s students valuable experience in advocacy, legal research, and courtroom presentation on the global stage, and reflects the growing reputation of the School''s mooting and trial advocacy programmes.',
    '2026-02-17'
);

-- Faculty: Dean is real (sourced from africau.edu); remaining rows are placeholders
-- clearly flagged for replacement with real staff details.
INSERT INTO faculty (full_name, title, department, bio, email, is_dean, display_order) VALUES
('Dr. Tendai C. Nhenga', 'Dean, School of Law', 'Administration',
 'Dr. Tendai C. Nhenga serves as Dean of the School of Law at Africa University, overseeing the School''s academic programmes across Private Law, Procedural Law, and Public Law, and its community outreach work through the Law Clinic.',
 'lawdean@africau.edu', 1, 0),
('[Placeholder] Grace Mutasa', 'Senior Lecturer', 'Private Law',
 'Placeholder faculty entry - replace with a real staff member''s details. Focus areas: contract law and property law.',
 NULL, 0, 1),
('[Placeholder] Farai Chikwanha', 'Lecturer', 'Private Law',
 'Placeholder faculty entry - replace with a real staff member''s details. Focus areas: family law and law of succession.',
 NULL, 0, 2),
('[Placeholder] Rutendo Marimo', 'Senior Lecturer', 'Procedural Law',
 'Placeholder faculty entry - replace with a real staff member''s details. Focus areas: civil and criminal procedure, evidence.',
 NULL, 0, 3),
('[Placeholder] Tapiwa Museka', 'Lecturer', 'Public Law',
 'Placeholder faculty entry - replace with a real staff member''s details. Focus areas: constitutional and human rights law.',
 NULL, 0, 4),
('[Placeholder] Chiedza Gumbo', 'Law Clinic Coordinator', 'Public Law',
 'Placeholder faculty entry - replace with a real staff member''s details. Coordinates the Law Clinic''s community outreach and legal awareness programmes.',
 NULL, 0, 5);
