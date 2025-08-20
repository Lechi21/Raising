<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$host = "localhost";
$user = "qvecmzzj_authors"; 
$pass = "Rock2025";
$dbname = "qvecmzzj_authors_db"; 

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// --- FETCH APPROVED POSTS ---
$sql = "SELECT title, message, fullName, photo, created_at 
        FROM submissions 
        WHERE status='approved' 
        ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Raising Young Authors</title>
    <meta name="description" content="Join the waitlist for Insanjo, a real-time sales tracking, bookkeeping, and predictive analytics tool designed to streamline sales management and decision-making.">
    <meta name="keywords" content="sales tracking, bookkeeping, predictive analysis, sales management, business analytics, Insanjo, real-time sales insights, business efficiency, inventory, stock keeping">
    <meta property="og:title" content="Writing Page, Raising Young Authors">
    <meta property="og:description" content="Be the first to access Writing Page, Raising Young Authors.">
    <meta property="og:image" content="https://insanjo.com/images/logoBox.png">
    <meta property="og:url" content="https://insanjo.com">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_US">
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" >
    <link rel="icon" href="images/New Logo.png" type="image/png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=support_agent" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Outfit:wght@300;400;600&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">

    <style>
        .blog-page {
            display: grid;
            width: 100%;
            margin: 0;
            gap: 0.5rem;
            grid-template-columns: 10rem auto 30rem;
            grid-template-areas:
            'left-side center right-side';
            height: 100vh;
        }

        .post-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .post-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .post-content {
            padding: 15px;
        }

        .post-content span {
            font-size: 0.9rem;
            color: #7A7A7A;
        }

        .post-title {
            font-size: 1.43rem;
            color: #204F3D;
            font-family: 'Merriweather', serif;
        }

        .post-text {
            font-size: 1rem;
            color: #555;
        }
        
        .post-text i {
            color: #204F3D;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .post-meta {
            margin-top: 25px;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
        <a href="index.html">
            <img src="images/New Logo.png" alt="RaisingYoungAuthorLogo">
        </a>
        </div>

        <nav>
        <div class="nav-links" id="navLinks">
            <ul class="menu">
            <li><a href="about.html">About Us</a></li>
            <li>
                <a href="javascript:void(0)" id="resourcesToggle">
                Resources <i class="fa fa-caret-down"></i>
                </a>
                <div class="dropdown" id="resourcesDropdown" style="display: none;">
                <div class="dropImage">
                    <img src="images/Library.jpg" alt="Library">
                    <span>Register and Unlock your <br> personal learning space.</span>
                </div>
                <div class="dropText">
                    <ul>
                    <li><a href="#" class="dropTop">Resources</a></li>
                    <hr style="margin-top: -6px;">
                    <li><a href="courses.html">Courses <span class="material-icons-sharp">arrow_forward</span></a></li>
                    <li><a href="workshop.html">Workbook Shop <span class="material-icons-sharp">arrow_forward</span></a></li>
                    </ul>
                </div>
                </div>
            </li>
            <li><a href="compitition.html">Competition</a></li>
            <li><a href="community.html">Community</a></li>
            <li><a href="contact.html">Contact us</a></li>
            </ul>
        </div>
        </nav>

        <!-- Submit Button -->
        <div id="mobileHeadBtnWrapper">
        <a href="writing.html" class="headBtn" id="headBtn">Submit Your Writing
            <span class="material-icons-sharp">create</span>
        </a>
        </div>

        <!-- Hamburger & Close Icons -->
        <div class="menu-toggle">
        <i class="fa fa-bars" id="openMenu" onclick="showMenu()"></i>
        <i class="fa fa-times" id="closeMenu" onclick="hideMenu()"></i>
        </div>
    </header>

    <section class="com-head-Top community" style="min-height: 40vh !important; margin-bottom: 0 !important;">
        <div class="card-color" style="width: 100%; background-color: #BEFFE6;"></div>
    </section>

    <section class="blog-page">
        <!-- LEFT SIDE -->
        <div class="left-side"></div>

        <!-- CENTER SIDE -->
        <div class="center-side">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="post-card">
                        <div class="photoCard">
                            <?php if (!empty($row['photo'])): ?>
                                <img src="<?php echo $row['photo']; ?>" alt="Post Image" class="post-image">
                            <?php endif; ?>
                        </div> 
                        <div class="post-content">
                            <h2 class="post-title"><?php echo htmlspecialchars($row['title'] ?? 'Untitled'); ?></h2>
                            <p>By <?php echo htmlspecialchars($row['fullName'] ?? 'Anonymous'); ?></p>
                            <span>
                                <?php 
                                    if (!empty($row['created_at'])) {
                                        echo date("M d, Y", strtotime($row['created_at']));
                                    }
                                ?>
                            </span>    
                                
                            <div class="post-meta">
                                <p class="post-text">
                                    <?php 
                                        $message = $row['message'] ?? '';   // full text
                                        $excerpt = substr($message, 0, 200); // first 200 chars
                                    
                                        echo $excerpt; 
                                    
                                        // Show "...More" only if text is longer
                                        if (strlen($message) > 200) {
                                            echo '.....<i>More</i>';
                                        }     
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No approved posts yet. Please check back later.</p>
            <?php endif; ?>
            
            <footer class="features" id="stories">
                <div class="footer-cont">
                    <div class="football">
                    <div class="logo">
                    <a href="index.html">
                        <img src="images/New Logo.png" alt="RaisingYoungAuthorLogo">
                    </a>
                    </div>
                    <div class="centers">
                        <div class="footer-top">
                            <a href="about.html"><p>About Us</p></a>
                            <a href="courses.html"><p>Courses</p></a>
                            <a href="workshop.html"><p>Workbooks</p></a>
                            <a href="community.html"><p>Community</p></a>
                            <a href="contact.html"><p>Contact Us</p></a>
                            <p>FQA</p>
                        </div>
                        <hr style="border: 1px solid #000000; width: 100%; margin: 0 auto;">
                    <div class="footer-down">
                        <p style="color: #000000;">Copyright © 2025 Raising Young Authors, Inc. | All rights reserved.</p>
                    </div>
                </div>
                </div>
                <div class="right ops">
                    <div class="icons">
                        <a href="https://www.facebook.com/raisingyoungauthors/" target="_blank">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/raising.young.authors/" target="_blank">
                            <i class="fa fa-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/@raisingyoungauthors2238" target="_blank">
                            <i class="fa fa-youtube"></i>
                        </a>
                        <a href="https://wa.me/2348037078076?text=Hello%20Raising%20Young%20Authors,%20I%20am%20interested%20in%20your%20services." target="_blank">
                            <i class="fa fa-whatsapp" style="margin-right: 0;"></i>
                        </a>
                    </div>
                    <p style="color: #204F3D;">Support: raisingyoungauthors@gmail.com</p>
                    <p>Location: KM. 3 Old Express Way</p>
                </div>
                </div>
            </footer>
        </div>

        <!-- RIGHT SIDE -->
        <div class="right-side">
            <section class="featureds" id="stories" style="position: sticky;">
                <div class="containss">
                    <div class="card6s">
                        <div class="card-content2s" style="align-items: flex-start;">
                        <div class="leftss">
                            <p class="left-text">Subscribe Our</p>
                            <p class="left-text2">Newsletter</p>
                            <p class="prop" style="font-size: 19px; margin-top: 30px; margin-bottom: 20px; color: #ffffff; font-weight: 500; font-family: 'Urbanist', serif;">Subscribe to our news letter and be the first to receive insight, <br> updates and writing tips to help you be the star that you are 
                            </p>
                        </div>
                        <div class="rightss">
                            <p class="states">Subscribe for updates on what’s new at Raising Young Authors</p>
                            <form style="display: flex; gap: 10px;">
                            <input type="email" id="subEmail" placeholder="Enter your email" required />
                            <button type="submit">Subscribe</button>
                            </form>
                            <span class="states">By subscribing, you agree to our Privacy Policy</span>
                        </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
</body>



<script src="script.js"></script>

</html>
<?php $conn->close(); ?>

