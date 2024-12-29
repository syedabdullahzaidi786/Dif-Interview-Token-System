-- Step 1: Create a database (if not already created)
CREATE DATABASE token_system;

-- Step 2: Select the database
USE token_system;

-- Step 3: Create the table
CREATE TABLE tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    token_number INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    bform VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL
);
