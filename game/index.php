<?php  
    // Start session to access session variables
    include("system/session.php");
    // Load utility functions from utils.php to record all error messages
    include_once("system/utils.php");
   
    // If user is not logged in, allow access to signup and login modules
    

    // If user is already logged in, redirect to auth.php for session restoration
        
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Signup / Login</title>
  <!-- External CSS for styling -->
  <link rel="stylesheet" href="user/signup.css"> 
  <!-- Responsive layout -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
</head>
<body>
  <div class="container">
    <!-- Image Banner -->
    <div class="image-section">
      <img src="user/banner.jpg" alt="Banner">
    </div>

    <!-- Form -->
    <div class="form-wrapper">
      <div class="form-section">

        <!-- Toggle buttons to switch between signup and login forms -->
        <div class="toggle-buttons">
          <button onclick="showForm('signup')">Sign Up</button>
          <button onclick="showForm('login')">Log In</button>
        </div>

        <!-- Signup Form (initially hidden) -->
        <div id="signup-form" class="hidden">
          


            <!-- Submit button -->
            <button type="submit">Sign Up</button>
          </form>
        </div>

        <!-- Login form (visible by default) -->
        <div id="login-form">
          
          <form method="POST" action="user/login.php">
          
          
          
            <!-- Submit button -->
            <button type="submit">Login</button>
          </form>
        </div>

      </div>  <!-- form-section close -->
    </div>  <!-- form-wrapper close -->
  </div>  <!-- container close -->

  <!-- JavaScript to handle toggle between signup and login forms -->
  <script>
    function showForm(formType) {
      // Hide both forms
      document.getElementById('signup-form').classList.add('hidden');
      document.getElementById('login-form').classList.add('hidden');
      // Show the selected form
      document.getElementById(formType + '-form').classList.remove('hidden');
    }
    
    // Auto-toggle to signup or login form based on error
    window.onload = function() {
      <?php if ($signupError): ?>
        showForm('signup');
      <?php elseif ($loginError): ?>
        showForm('login');
      <?php else: ?>
        showForm('login');
      <?php endif; ?>
    };
    
  </script>
  
</body>
</html>