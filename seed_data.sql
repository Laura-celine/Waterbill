-- Insert default admin account
INSERT INTO users (full_name, email, password, phone, address, role) 
VALUES ('Admin User', 'admin@example.com', MD5('admin123'), '1234567890', 'Admin Office', 'admin');

-- Sample users for testing
INSERT INTO users (full_name, email, password, phone, address) 
VALUES 
('John Doe', 'john@example.com', MD5('user123'), '9876543210', 'Apartment 101'),
('Jane Smith', 'jane@example.com', MD5('user456'), '8765432109', 'Apartment 102');

-- Sample bills
INSERT INTO bills (user_id, amount, due_date, status) 
VALUES 
(2, 50.00, '2025-03-01', 'Pending'),
(3, 60.50, '2025-03-05', 'Paid');

-- Sample payments
INSERT INTO payments (user_id, bill_id, amount, payment_status) 
VALUES 
(3, 2, 60.50, 'Successful');

-- Sample support tickets
INSERT INTO support_tickets (user_id, subject, message, status) 
VALUES 
(2, 'Water Issue', 'No water supply since morning.', 'Pending');

-- Sample admin log
INSERT INTO admin_logs (admin_id, action) 
VALUES 
(1, 'Updated bill details for User ID 2.');