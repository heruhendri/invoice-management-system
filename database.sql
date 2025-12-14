
CREATE TABLE companies (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100),
 logo VARCHAR(255)
);

CREATE TABLE admins (
 id INT AUTO_INCREMENT PRIMARY KEY,
 company_id INT,
 username VARCHAR(50),
 password VARCHAR(255),
 role ENUM('SUPER','STAFF'),
 FOREIGN KEY(company_id) REFERENCES companies(id)
);

CREATE TABLE permissions (
 id INT AUTO_INCREMENT PRIMARY KEY,
 role ENUM('SUPER','STAFF'),
 menu VARCHAR(50),
 allowed TINYINT(1)
);

CREATE TABLE audit_logs (
 id INT AUTO_INCREMENT PRIMARY KEY,
 admin_id INT,
 action TEXT,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE customers (
 id INT AUTO_INCREMENT PRIMARY KEY,
 company_id INT,
 name VARCHAR(100),
 phone VARCHAR(20),
 address TEXT
);

CREATE TABLE invoices (
 id INT AUTO_INCREMENT PRIMARY KEY,
 company_id INT,
 customer_id INT,
 amount DECIMAL(12,2),
 currency VARCHAR(5),
 due_date DATE,
 status ENUM('UNPAID','PAID','OVERDUE') DEFAULT 'UNPAID'
);
