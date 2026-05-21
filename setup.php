<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quickhire";
$port=3307;

// connect without db
$conn = mysqli_connect($servername, $username, $password, "", $port);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS quickhire";
mysqli_query($conn, $sql);

mysqli_close($conn);

// connect with db
$conn = mysqli_connect($servername, $username, $password, $dbname,3307);

if(!$conn){
    die("Database connection failed: " . mysqli_connect_error());
}

// create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Job Seeker', 'Recruiter', 'admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if(mysqli_query($conn, $sql)){
    echo "Users table created successfully or already exists";
}
else{
    echo "Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS job_seeker_profile (
    job_seeker_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    image VARCHAR(255),
    full_name VARCHAR(100) NOT NULL,
    email_address VARCHAR(100) NOT NULL UNIQUE,
    mobile_number VARCHAR(15),
    location VARCHAR(100),
    desired_role VARCHAR(100),
    experience VARCHAR(50),
    
    skills TEXT,
    qualification VARCHAR(100),
    college_name VARCHAR(100),
    specialization VARCHAR(100),
    graduation_year YEAR,
    certificates TEXT,
    about_me TEXT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
)";

if(mysqli_query($conn, $sql)){
    echo "<br>Job seeker profile table created successfully or already exists";
}
else{
    echo "<br>Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS recruiter_profile (
    recruiter_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    company_name VARCHAR(150) NOT NULL,
    industry_type VARCHAR(100),
    company_size VARCHAR(50),
    founded_year YEAR,
    headquarters_location VARCHAR(150),
    branches_offices VARCHAR(255),
    recruiter_name VARCHAR(100),
    hr_designation VARCHAR(100),
    company_email VARCHAR(100) NOT NULL UNIQUE,
    contact_number VARCHAR(15),
    company_website VARCHAR(255),
    website_url VARCHAR(255),
    company_location VARCHAR(150),
    specialties TEXT,
    about_company TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
)";

if(mysqli_query($conn, $sql)){
    echo "<br>Recruiter profile table created successfully or already exists";
}
else{
    echo "<br>Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS jobs (
    job_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    job_title VARCHAR(100) NOT NULL,
    company_name VARCHAR(100) NOT NULL,
    company_email VARCHAR(100) NOT NULL,
    job_location VARCHAR(100) NOT NULL,
    work_mode ENUM('Onsite','Remote','Hybrid') NOT NULL,
    
    required_experience VARCHAR(50) NOT NULL,
    salary_range VARCHAR(50),
    number_of_vacancies INT NOT NULL DEFAULT 1,
    required_skills TEXT,
    industry_type VARCHAR(100),
    qualification VARCHAR(100),
    application_deadline DATE NOT NULL,
    
    roles_responsibilities TEXT,
    job_description TEXT NOT NULL,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
)";
if(mysqli_query($conn,$sql)){
    echo "<br>Jobs table created successfully or already exists";
}
else{
    echo "<br>Error creating table: " . mysqli_error($conn);
}

$sql = "CREATE TABLE IF NOT EXISTS applications (
    application_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    job_id INT NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    resume VARCHAR(255) NOT NULL,
    cover_letter TEXT,
    application_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (job_id) REFERENCES jobs(job_id) ON DELETE CASCADE
)";

if(mysqli_query($conn, $sql)){
    echo "<br>Application table created successfully or already exists";
}
else{
    echo "<br>Error creating table: " . mysqli_error($conn);
}
mysqli_close($conn);
?>