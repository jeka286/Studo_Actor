-- One-time relational setup for Golubko
-- Run this after the tables already exist.

-- USERS
-- Adds phone to the profile table if it is missing.
ALTER TABLE users
    ADD COLUMN IF NOT EXISTS phone VARCHAR(20) NULL AFTER email;

-- Optional but recommended for fast login/profile lookups.
ALTER TABLE users
    ADD UNIQUE KEY uq_users_email (email);

-- COURSE TASKS
-- Connects tasks to courses.
ALTER TABLE course_tasks
    ADD CONSTRAINT fk_course_tasks_course
    FOREIGN KEY (course_id) REFERENCES Courses(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE;

-- CASTINGS
-- Connects casting submissions to registered users.
ALTER TABLE castings
    ADD CONSTRAINT fk_castings_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE SET NULL
    ON UPDATE CASCADE;
