<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
$sql = "SELECT id, title, message, fullName, photo, created_at, likes 
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
            grid-template-areas: 'left-side center right-side';
            padding-top: 60px;
        }
        
        .left-side { grid-area: left-side; }
        .center-side { grid-area: center; }
        
        .center-side {
            display: flex;
            flex-direction: column;
        }

        .center-side-post {
            margin-bottom: 10rem;
        }

        .post-card {
            display: flex;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            width: 95%;
            padding: 15px;
            align-items: center;
            gap: 2rem;
        }

        .photoCard {
            /*flex-basis: 35%;*/
            overflow: hidden;
            position: relative;
            border-radius: 10px;
        }
        
        .photoCard img {
            /*justify-self: flex-end;*/
            width: 100%;
            height: 270px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .photoCard::after {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0);
            transition: background 0.5s ease;
            z-index: 1;
        }
        
        .photoCard:hover::after {
            background: rgba(0, 0, 0, 0.3);
        }
        
        .photoCard:hover img {
            transform: scale(1.05);
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
        
        .post-meta {
            margin-top: 25px;
        }

        .post-text {
            font-size: 1rem;
            color: #555;
        }
        
        .post-text i {
            color: #204F3D;
            font-size: 0.9rem;
            cursor: pointer;
            font-weight: bold;
        }
        
        /*-- RIGHT SIDE --*/
        .right-side { 
            grid-area: right-side; 
            position: sticky;
            top: 100px;
            align-self: flex-start;
        }
        
        .blog-content2 {
            display: flex;
            flex-direction: column;
            max-width: 400px;
        }
        
        .blog-content2 .lefts .left-text {
            /*color: #ffffff;*/
            font-family: 'Merriweather', serif;
            font-weight: 500;
            font-size: 24px;
        }
        
        .blog-content2 .lefts .left-text2 {
            /*color: #ffffff;*/
            font-family: 'Pacifico', serif;
            font-size: 24px;
        }
        
        .states {
            font-size: 14px;
        }
        
        .righter input[type="email"] {
            padding: 10px;
            border-radius: 17px;
            border: none;
            margin-right: 10px;
            width: 250px;
            background: #0000000D;
        }
        
        .righter button {
            font-family: 'Urbanist', serif;
            padding: 10px;
            background: #446f5e;
            width: 250px;
            color: #ffffff;
            border: 1px solid;
            font-size: 14px;
            border-radius: 17px;
            cursor: pointer;
        }
        
        /* Footer pinned correctly */
        footer {
            background: linear-gradient(to right, #fff 50%, #ffefd5 100%);
            padding: 20px 0;
            margin-top: 2rem;
            margin-bottom: 10px;
        }
        
        footer .footers {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }
        
        .foots {
            display: flex;
            align-items: center;
            flex-basis: 100%;
            justify-content: center;
            gap: 4rem;
        }
        
        .foots .logo img {
            flex: 1;
            width: 90px;
            height: 90px;
            object-fit: contain;
            position: relative;
            cursor: pointer;
        }
        
        .foots .centers {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-direction: column;
        }
        
        .foots .centers .footer-top {
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        
        .foots .centers p {
            color: #204F3D;
            font-size: 14px;
        }
        
        /*LIKES SECTION*/
        .like-btn {
            transition: all 0.2s ease;
        }
        
        .like-btn.liked {
            color: #e63946;
            font-weight: bold;
            transform: scale(1.1);
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

    <!--<section class="com-head-Top community" style="min-height: 40vh !important; margin-bottom: 0 !important;">-->
    <!--    <div class="card-color" style="width: 100%; background-color: #BEFFE6;"></div>-->
    <!--</section>-->

    <section class="blog-page">
        <!-- LEFT SIDE -->
        <div class="left-side"></div>

        <!-- CENTER SIDE -->
        <div class="center-side">
            <div class="center-side-post">
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
                                            $excerpt = substr($message, 0, 50); // first 200 chars
                                        
                                            echo $excerpt; 
                                        
                                            // Show "...More" only if text is longer
                                            // if (strlen($message) > 50) {
                                            //     echo '.....<a href="post.php?id=' . $row['id'] . '"><i>More</i></a>';
                                            // }
                                            
                                            
                                            if (strlen($message) > 200) {
                                                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $row['title'])));
                                                echo '.....<a href="post/' . $row['id'] . '/' . $slug . '"><i>More</i></a>';
                                            }
                                        ?>
                                    </p>
                                </div>
                                <div class="post-actions">
                                  <!-- Like Button -->
                                    <button style="margin-top: 15px; border: none; background: none; cursor: pointer;" class="like-btn" data-post="<?php echo htmlspecialchars($row['id']); ?>">
                                        👍 Like 
                                        <span id="like-count-<?php echo htmlspecialchars($row['id']); ?>">
                                            <?php echo isset($row['likes']) ? (int)$row['likes'] : 0; ?>
                                        </span>

                                    </button>
                                
                                  <!-- Share Buttons -->
                                  <!--<div class="share-buttons">-->
                                  <!--  <a href="https://twitter.com/intent/tweet?url=https://yourblog.com/post-slug&text=Check%20this%20out!" target="_blank">🐦 Tweet</a>-->
                                  <!--  <a href="https://www.facebook.com/sharer/sharer.php?u=https://yourblog.com/post-slug" target="_blank">📘 Share</a>-->
                                  <!--  <a href="https://wa.me/?text=Check%20this%20post:%20https://yourblog.com/post-slug" target="_blank">💬 WhatsApp</a>-->
                                  <!--</div>-->
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No approved posts yet. Please check back later.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="right-side">
            <section class="featureds" id="stories">
                <div class="blog-contains">
                    <div class="card60">
                        <div class="blog-content2">
                            <div class="lefts">
                                <p class="left-text">Subscribe Our</p>
                                <p class="left-text2">Newsletter</p>
                                <p class="prop" style="font-size: 19px; margin-top: 30px; margin-bottom: 20px; font-weight: 500; font-family: 'Urbanist', serif;">Subscribe to our news letter and be the first to receive insight, <br> updates and writing tips to help you be the star that you are 
                                </p>
                            </div>
                            <div class="righter">
                                <p class="states">Subscribe for updates and join over 2,300 young authors from around the world</p>
                                <form style="display: flex; gap: 10px; flex-direction: column; margin: 15px 0;">
                                <input type="email" id="subEmail" placeholder="Enter your email" required />
                                <button type="submit">Subscribe</button>
                                </form>
                                <span class="states">By subscribing, you agree to our Privacy Policy</span>
                            </div>
                            <div class="right ops" style="margin-top: 20px;">
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
                    </div>
                </div>
            </section>
        </div>
    </section>
    
    <footer>
        <div class="footers">
            <div class="foots">
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
        </div>
    </footer>
</body>



<script src="script.js"></script>
<script>
// Load like count from database on page load
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".like-btn").forEach(btn => {
        const postId = btn.dataset.post;
        const countSpan = document.getElementById("like-count-" + postId);
        const storageKey = "liked_" + postId;

        // ✅ Initial fetch from database
        fetch("likes.php?postId=" + postId)
            .then(res => res.json())
            .then(data => {
                countSpan.textContent = data.likes ?? 0;
                if (localStorage.getItem(storageKey)) {
                    btn.classList.add("liked");
                }
            })
            .catch(err => console.error("Error fetching likes:", err));

        // ✅ Handle click (toggle like/unlike)
        btn.addEventListener("click", () => {
            const liked = localStorage.getItem(storageKey);

            if (!liked) {
                // --- LIKE ---
                countSpan.textContent = parseInt(countSpan.textContent) + 1;
                localStorage.setItem(storageKey, "true");
                btn.classList.add("liked");

                fetch("likes.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ postId: postId, action: "like" })
                }).catch(err => console.error("Error liking post:", err));

            } else {
                // --- UNLIKE ---
                countSpan.textContent = Math.max(parseInt(countSpan.textContent) - 1, 0);
                localStorage.removeItem(storageKey);
                btn.classList.remove("liked");

                fetch("likes.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ postId: postId, action: "unlike" })
                }).catch(err => console.error("Error unliking post:", err));
            }
        });
    });
});
</script>


</html>
<?php $conn->close(); ?>

