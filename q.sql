-- Drop existing tables if they exist
DROP TABLE IF EXISTS expense_month_details;
DROP TABLE IF EXISTS expense_months;
DROP TABLE IF EXISTS expense_years;
DROP TABLE IF EXISTS expenses;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS budgets;

-- Create tables
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE expenses (
    expense_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    amount DECIMAL(10, 2) NOT NULL,
    category VARCHAR(255),
    description VARCHAR(255),
    expense_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (category) REFERENCES categories(category_name)
);

CREATE TABLE expense_years (
    year_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    year INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE expense_months (
    month_id INT AUTO_INCREMENT PRIMARY KEY,
    year_id INT,
    month INT NOT NULL,
    FOREIGN KEY (year_id) REFERENCES expense_years(year_id)
);

CREATE TABLE expense_month_details (
    detail_id INT AUTO_INCREMENT PRIMARY KEY,
    month_id INT,
    expense_id INT,
    FOREIGN KEY (month_id) REFERENCES expense_months(month_id),
    FOREIGN KEY (expense_id) REFERENCES expenses(expense_id)
);

-- Insert categories
INSERT INTO categories (category_name) VALUES
('Food and groceries'),
('Transportation'),
('Housing'),
('Healthcare'),
('Utilities'),
('Debt payments'),
('Entertainment'),
('Personal care'),
('Clothing and accessories'),
('Savings and investments'),
('Gifts and donations'),
('Miscellaneous');

CREATE TABLE budgets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    budget DECIMAL(10, 2) NOT NULL,
    category VARCHAR(50) NOT NULL,
    timeframe VARCHAR(10) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

