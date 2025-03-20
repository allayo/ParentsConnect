<?php
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parents Connect</title>
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/jquery-3.js"></script>
</head>
<body>
<header>
      <nav>
          <input type="checkbox" id="check">
          <label for="check" class="checkbtn"> 
              <i class="fa fa-bars"></i>
          </label>
          <label class="logo">Parents Connect</label>
          <ul>
              <li><a href="index.php">Home</a></li>
              <li><a href="about.php">About</a></li>
              <li class="dropdown-parent">
                  <a href="#">Resources</a>
                  <ul class="dropdown">
                      <li><a href="blogs.php">Blogs</a></li>
                      <li><a href="planner.php">Planner</a></li>
                      <li><a href="community.php">Community</a></li>
                  </ul>
              </li>
              <li><a href="contact.php">Contact</a></li>
              <li><a class="regLog" href="profile.php">Profile <i class="bi bi-person-circle"></i></a></li>
          </ul>
      </nav>
</header>

<section class="container-fluid landingContent">
        <div class="container landingBody">
            <div class="row">
                <div class="col-md-6">
                  <img src="assets/images/parent.jpg" alt="Illustration of a boy" class="howToImg">
                </div>
                <div class="col-md-6 landingText">
                  <h3 class="landingHeader">Parents Connect</h3>
                  <p class="landingSub">Your No.1 guide to better childcare information</p>
                  <a href="about.php" class="aboutBtn">Learn More</a>
                </div>
              </div>
              <div class="section-line"> </div>
        </div>
</section>

<section class="container-fluid featuredContent">
    <div class="container featuredBody">
        <div class="featuredText">
            <h3 class="featuredHeader">Featured Content</h3>
            <p class="featuredSub">Top content this week from our community</p>
            <a href="blogs.php" class="featuredBtn">Read More</a>
        </div>
        <div class="row">
            <div class="col-md-4 featureItem">
                <h4>Helping your child navigate pre school</h4>
                <p>Pre school, one of the earliest stage of a childs academic journey is as importaant as all other stages and its necessary for parents to ensure thier children...</p>
            </div>
            <div class="col-md-4 featureItem">
                <h4>Steps to guide your child towards academic excellence</h4>
                <p>Academic excellence is the desire of all parents for their children, but the process of attaining excellent performance in school can be quite tedious for children. Gere are steps to follow to support...</p>
            </div>
        </div>
        <div class="section-line"> </div>
    </div>
    
</section>


<section class="container-fluid featuredContent">
    <div class="container featuredBody">
        <div class="featuredText">
            <h3 class="featuredHeader">Community Updates</h3>
            <p class="featuredSub">Latest updates from our community</p>
            <a href="community.php" class="featuredBtn">Go to community</a>
        </div>
        <div class="row">
            <div class="col-md-8 featureItem">
                <h4>Upcoming Event <i class="bi bi-calendar-date-fill"></i> </h4>
                <p>Weekly New Mothers Annual Conference.</p>
                <p>Location: Zoom</p>
                <p>Date: 25 Aug 2024</p>
                <p>Time: 2:00 PM</p>
                <button class="rememberBtn">Remember</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 featureItem">
                <h4>Upcoming Event <i class="bi bi-calendar-date-fill"></i> </h4>
                <p>Understanding Child Teething in Infants</p>
                <p>Location: Zoom</p>
                <p>Date: 12 Aug 2024</p>
                <p>Time: 5:00 PM</p>
                <button class="rememberBtn">Remember</button>
            </div>
        </div>
        <div class="section-line"> </div>
    </div>
</section>

<section class="container-fluid landingContent">
        <div class="container landingBody">
            <div class="row">
                <div class="col-md-6">
                  <img src="assets/images/meal.jpg" alt="Illustration of a boy" class="howToImg">
                </div>
                <div class="col-md-6 landingText">
                  <h3 class="landingHeader">Check Out Our Meal Planner Tool</h3>
                  <p class="landingSub">Get access to specialized meal plans for different ages</p>
                  <a href="planner.php" class="tryBtn">Try Now</a>
                </div>
              </div>
              <div class="section-line"> </div>
        </div>
</section>

<section class="container-fluid featuredContent">
    <div class="container featuredBody">
        <div class="featuredText">
            <h3 class="featuredHeader">Reviews</h3>
            <p class="featuredSub">What parents say about us</p>
        </div>
        <div class="row">
            <div class="col-md-4 reviewItem">
                <img src="assets/images/woman.jpg" alt="">
                <h4>Mary Ben</h4>
                <p>Parents conneect is a really amazing resource, it has helped me better understanding my toddlers.</p>
                <p class="rating"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></p>
            </div>
            
            <div class="col-md-4 reviewItem">
                <img src="assets/images/man.jpg" alt="">
                <h4>Stanley Clark</h4>
                <p>Parents connect is super easy to use and the resource are amazind, I utilize the meal planner to create exciting meals for my children.</p>
                <p class="rating"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></p>
            </div>

            <div class="col-md-4 reviewItem">
            <img src="assets/images/woman2.jpg" alt="">  
            <h4>Stella Larry</h4>
                <p>Using Parents connect is like having a cheat code for better parenting, it has provided me with valuable tips on how to easily manage my kids academics.</p>
                <p class="rating"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></p>
                
            </div>
        </div>
        <div class="section-line"> </div>
    </div>
</section>

<section class="membership container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-6 membershipInfo">
                <h3>Become a Member</h3>
                <p>Register for our monthly newsletter</p>
            </div>
            <div class="col-md-6 membershipFill">
                <form class="membershipForm">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>
            </div>
        </div>
    </div>
</section>

  <footer>
    <section class="footer container-fluid">
        <div class="container">
            <div class="row socialLinks justify-content-center">
                <div class="col-md-12">
                    <ul>
                        <li><a href="#"><i class="bi bi-instagram"></i></a></li>
                        <li><a href="#"><i class="bi bi-twitter-x"></i></a></li>
                        <li><a href="#"><i class="bi bi-facebook"></i></a></li>
                        <li><a href="#"><i class="bi bi-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="row pagesLinks justify-content-center">
                <div class="col-md-12">
                    <a href="index.php">| Home |</a>
                    <a href="about.php">| About |</a>
                    <a href="contact.php">| Contact |</a>
                </div>
            </div>
            <div class="row copyRight justify-content-center">
                <div class="col-md-12">
                    <p>&copy; 2024 Parents Connect Ltd. All rights reserved.</p>
                </div>
            </div>
        </div>
    </section>
</footer>
</body>
</html>