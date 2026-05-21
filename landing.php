<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
  <?php
  include("db_connect.php");
?>
  <?php include 'headerLanding.php'; ?> 
    <div class="hero">
      <div class="hero-image">
        <div class="hero-title">
          <span style="font-size: 4rem;">Find Your Dream Job Today.</span>
          <h2>“Explore thousands of job opportunities from top companies and start your career journey with confidence.”</h2>
        </div>    
    </div>
    </div>
    <h1 class="title-job-group">Discover Opportunities by Category</h1>
    <div class="job-group">
      <div class="box">IT & Software</div>
      <div class="box">Marketing</div>
      <div class="box">Healthcare</div>
      <div class="box">Finance</div>
      <div class="box">Design</div>
      <div class="box">Cybersecurity</div>
    </div>
    <div class="about" id="about-section">
      <div class="about-image"></div>
      <div class="about-desc">
        <h2>About Us</h2>
        <p>We are a modern job portal platform dedicated to connecting talented job seekers with trusted employers. Our mission is to simplify the hiring process by providing a secure, fast, and user-friendly environment for both candidates and companies.
        Whether you are searching for your dream job or looking to hire the right talent, our platform offers smart search tools, verified listings, and an easy application process to make recruitment simple and effective.</p>
      </div>
    </div>
    <h1 class="review-title">Testimonials</h1>
    <div class="Testimonials">
       <div class="review-box">
        <i class="fa-solid fa-star" style="color: rgb(255, 193, 7);"></i>
        <i class="fa-solid fa-star" style="color: rgb(255, 193, 7);"></i>
        <i class="fa-solid fa-star" style="color: rgb(255, 193, 7);"></i>
        <i class="fa-solid fa-star" style="color: rgb(255, 193, 7);"></i>
        <i class="fa-solid fa-star" style="color: rgb(255, 193, 7);"></i>
        <p>"I found my dream job within just two weeks of signing up. The application process was simple and smooth. Highly recommended!"</p>
        <p class="name">— Priya Sharma, Software Developer</p>
       </div>
       <div class="review-box">
        <i class="fa-solid fa-star" style="color: rgb(255, 193, 7);"></i>
        <i class="fa-solid fa-star" style="color: rgb(255, 193, 7);"></i>
        <i class="fa-solid fa-star" style="color: rgb(255, 193, 7);"></i>
        <i class="fa-solid fa-star" style="color: rgb(255, 193, 7);"></i>
        <i class="fa-solid fa-star" style="color: rgb(255, 193, 7);"></i>
        <p>"This platform helped us hire qualified candidates quickly. The filtering system and dashboard are very easy to use."</p>
        <p class="name">— Rahul Mehta, HR Manager</p>
       </div>
       <div class="review-box">
        <i class="fa-solid fa-star" style="color: rgb(255, 193, 7);"></i>
        <i class="fa-solid fa-star" style="color: rgb(255, 193, 7);"></i>
        <i class="fa-solid fa-star" style="color: rgb(255, 193, 7);"></i>
        <i class="fa-solid fa-star" style="color: rgb(255, 193, 7);"></i>
        <i class="fa-solid fa-star" style="color: rgb(255, 193, 7);"></i>
        <p>"As a fresher, I was struggling to find opportunities. This website made job searching much easier and more organized."</p>
        <p class="name">— Sneha Patil, Marketing Executive</p>
       </div>
    </div>
    <footer id="contact-info">
        <div class="footer-top">
          <ul class="footer-box">
          <h2>Company</h2>
          <li><a href="#about-section">About Us</a></li>
          <li><a href="">Contact Us</a></li>
          <li><a href="">Our Team</a></li>
        </ul>
        <ul class="footer-box">
          <h2>Legal</h2>
          <li><a href="">Privacy Policy</a></li>
          <li><a href="">Terms & Conditions</a></li>
          <li><a href="">Cookie Policy</a></li>
        </ul>
        <ul class="footer-box">
          <h2>Support</h2>
          <li><a href="">Help Center</a></li>
          <li><a href="">FAQs</a></li>
          <li><a href="">Report an Issue</a></li>
        </ul>
        </div>
        <p class="footer-bottom">
          © 2026 QuickHire. All rights reserved. Connecting talent with the right opportunities.
        </p>
    </footer>
</body>
</html>