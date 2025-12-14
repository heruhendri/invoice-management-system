
CREATE TABLE admins (
 id INT AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(50) UNIQUE,
 password VARCHAR(255),
 role ENUM('SUPER','STAFF') DEFAULT 'STAFF'
);

INSERT INTO admins(username,password,role)
VALUES('admin','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','SUPER');

CREATE TABLE customers(
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100),
 phone VARCHAR(20),
 address TEXT
);

CREATE TABLE invoices(
 id INT AUTO_INCREMENT PRIMARY KEY,
 customer_id INT,
 amount DECIMAL(12,2),
 currency VARCHAR(5) DEFAULT 'IDR',
 due_date DATE,
 status ENUM('UNPAID','PAID') DEFAULT 'UNPAID',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
