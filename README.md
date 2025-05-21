# Student Management System (PHP + MySQL)

This is a simple student record management system developed using:
- PHP
- MySQL
- PDO
- HTML/CSS

## Features Implemented
- Add, Edit, Delete, View student records
- Profile image upload & display
- Search/filter by name or course
- PDF export of student list (optional)
- Clean, responsive UI with card layout

## Folder Structure
- `config/` - database connection (`db.php`)
- `public/` - all main pages (index, add, edit)
- `uploads/` - stores student profile images
- `library/fpdf/` - PDF export (optional)

## How to Run
1. Move project to `C:/xampp/htdocs/`
2. Start XAMPP and visit `http://localhost/student-management-neo/public`
3. Create database: `student_db` via phpMyAdmin
4. Import table:
```sql
CREATE TABLE students (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  contact_no VARCHAR(15),
  course VARCHAR(50),
  profile_image VARCHAR(255),
  registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
