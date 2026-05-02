<?php include "db.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Website</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="style.css">
        <style>
        /* Floating toggle button */
        #chat-toggle-btn {
            position: fixed;
            bottom: 32px;
            right: 32px;
            width: 62px;
            height: 62px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            color: #fff;
            border: none;
            font-size: 26px;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(13, 110, 253, 0.5);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.22s, box-shadow 0.22s;
        }
        #chat-toggle-btn:hover {
            transform: scale(1.11);
            box-shadow:0 6px 25px rgba(13, 110, 253, 0.7);
        }
        #chat-toggle-btn .notif {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #e74c3c;
            color: #fff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* Chat window */
        #chat-window {
            position: fixed;
            bottom: 106px;
            right: 32px;
            width: 360px;
            height: 460px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 12px 55px rgba(0,0,0,0.16);
            z-index: 9998;
            display: none;
            flex-direction: column;
            overflow: hidden;
            font-family: 'Segoe UI', sans-serif;
            animation: chatSlideUp 0.3s cubic-bezier(.4,0,.2,1);
        }
        #chat-window.open { display: flex; }

        @keyframes chatSlideUp {
            from { opacity: 0; transform: translateY(28px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* Header */
        .chat-header {
            background:linear-gradient(135deg, #0d6efd, #0a58ca);
            color: #fff;
            padding: 15px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
            border-bottom: 3px solid #0d6efd;
        }
        .chat-header .bot-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .chat-header .bot-info h6 {
            margin: 0 0 2px;
            font-size: 15px;
            font-weight: 700;
            color: #fff;
        }
        .chat-header .bot-info small {
            font-size: 11px;
            /* color: #0d6efd; */
        }
        .online-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            background: #2ecc71;
            border-radius: 50%;
            margin-right: 4px;
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0%,100% { opacity: 1; }
            50% { opacity: 0.35; }
        }
        .chat-header .close-btn {
            margin-left: auto;
            background: none;
            border: none;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            opacity: 0.8;
            transition: opacity 0.2s;
        }
        .chat-header .close-btn:hover { opacity: 1; }

        /* Messages */
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            background: #f5f5f0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .chat-messages::-webkit-scrollbar { width: 4px; }
        .chat-messages::-webkit-scrollbar-thumb { background: #ddd; border-radius: 2px; }

        .msg {
            max-width: 83%;
            padding: 10px 14px;
            border-radius: 16px;
            font-size: 13.5px;
            line-height: 1.55;
            word-break: break-word;
            animation: msgFade 0.22s ease;
        }
        @keyframes msgFade {
            from { opacity: 0; transform: translateY(7px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .msg.bot {
            background: #fff;
            color: #222;
            border: 1px solid #e8e8e8;
            border-bottom-left-radius: 4px;
            align-self: flex-start;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .msg.user {
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            color: #fff;
            border-bottom-right-radius: 4px;
            align-self: flex-end;
        }
        .msg.bot .msg-sender {
            font-size: 10.5px;
            font-weight: 700;
            color: #0d6efd;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        /* Typing dots */
        .typing-indicator {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 12px 16px;
            background: #fff;
            border-radius: 16px;
            border-bottom-left-radius: 4px;
            border: 1px solid #e8e8e8;
            align-self: flex-start;
            width: fit-content;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .typing-indicator span {
            width: 7px;
            height: 7px;
            background: #0d6efd;
            border-radius: 50%;
            animation: bounce 1.2s infinite;
        }
        .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
        .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }
        @keyframes bounce {
            0%,80%,100% { transform: translateY(0); }
            40% { transform: translateY(-7px); }
        }

        /* Quick replies */
        .quick-replies {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 7px;
        }
        .qr-btn {
            background: #fff;
            border: 1.5px solid #0d6efd;
            color: #0d6efd;
            border-radius: 20px;
            padding: 5px 13px;
            font-size: 12px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.18s;
        }
        .qr-btn:hover {
            background: #0d6efd;
            color: #fff;
        }

        /* Input area */
        .chat-input-area {
            padding: 12px 14px;
            background: #fff;
            border-top: 1px solid #eee;
            display: flex;
            gap: 8px;
            align-items: center;
            flex-shrink: 0;
        }
        .chat-input-area input {
            flex: 1;
            border: 1.5px solid #e0e0e0;
            border-radius: 25px;
            padding: 9px 16px;
            font-size: 13.5px;
            outline: none;
            transition: border-color 0.2s;
            background: #fafafa;
        }
        .chat-input-area input:focus {
            border-color: #0d6efd;
            background: #fff;
        }
        .chat-input-area button {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0d6efd, #0a58ca);
            color: #fff;
            border: none;
            font-size: 17px;
            cursor: pointer;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.18s;
        }
        .chat-input-area button:hover { transform: scale(1.08); }

        .chat-footer-bar {
            text-align: center;
            font-size: 10.5px;
            color: #bbb;
            padding: 6px;
            background: #fff;
        }

        /* Mobile */
        @media (max-width: 480px) {
            #chat-window {
                width: calc(100vw - 20px);
                right: 10px;
                bottom: 90px;
                height: 72vh;
            }
            #chat-toggle-btn { right: 14px; bottom: 14px; }
        }
        /* ============================================================
           WHATSAPP BUTTON STYLES — Direct redirect, no popup
           ============================================================ */
        #wa-btn {
            position: fixed;
            bottom: 32px;
            left: 32px;
            width: 62px;
            height: 62px;
            border-radius: 50%;
            background: linear-gradient(135deg, #25d366, #128c7e);
            color: #fff;
            border: none;
            font-size: 28px;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(37, 211, 102, 0.55);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: transform 0.22s, box-shadow 0.22s;
            animation: waPop 0.6s cubic-bezier(.34,1.56,.64,1) both;
        }
        @keyframes waPop {
            from { opacity: 0; transform: scale(0.5); }
            to   { opacity: 1; transform: scale(1); }
        }
        #wa-btn:hover {
            transform: scale(1.12);
            box-shadow: 0 6px 28px rgba(37, 211, 102, 0.7);
        }
        /* Green pulse ring */
        #wa-btn::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: rgba(37, 211, 102, 0.35);
            animation: waRing 2s ease-out infinite;
        }
        @keyframes waRing {
            0%   { transform: scale(1);   opacity: 0.8; }
            100% { transform: scale(1.7); opacity: 0; }
        }
        /* Tooltip */
        #wa-tooltip {
            position: fixed;
            bottom: 44px;
            left: 104px;
            background: #fff;
            color: #111;
            font-family: 'Segoe UI', sans-serif;
            font-size: 13px;
            font-weight: 600;
            padding: 8px 14px;
            border-radius: 50px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.14);
            white-space: nowrap;
            z-index: 9997;
            animation: tooltipFade 0.4s ease 1.2s both;
            pointer-events: none;
            transition: opacity 0.4s ease;
        }
        #wa-tooltip::before {
            content: '';
            position: absolute;
            left: -8px;
            top: 50%;
            transform: translateY(-50%);
            border: 6px solid transparent;
            border-right-color: #fff;
        }
        @keyframes tooltipFade {
            from { opacity: 0; transform: translateX(-8px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        #wa-tooltip.hide { opacity: 0; pointer-events: none; }

        @media (max-width: 480px) {
            #wa-btn     { left: 14px; bottom: 14px; }
            #wa-tooltip { left: 86px; bottom: 42px; font-size: 12px; }
        } 
    </style>
    <!-- ===== END CHATBOT + WA CSS ===== -->
</head>
<!-- Tooltip -->
<div id="wa-tooltip">💬 Chat on WhatsApp</div>
    </style>
</head>
<body>
    <!--Header section-->
    <header>
        <i class="fa-solid fa-bars" id="menu"></i>
        <div class="logo">
            <i class="fa-solid fa-house-chimney"></i>
            <span>Bhagwati Properties</span>
        </div>
        <nav class="navbar" id="navList">
            <a href="#home" class="nav-link">Home</a>
            <a href="#servises" class="nav-link">Services</a>
            <a href="#buy" class="nav-link">Buy</a>
            <a href="#rent" class="nav-link">Rent</a>
            <a href="#features" class="nav-link">features</a>
            <a href="#contact" class="nav-link">Contact</a>
            <a href="post_property.php">Post Property</a>
            <a href="#">Blogs</a>
        </nav>
        <div class="signUp" id="sign">
            <a href="login.html" class="login">Login </a>
            <!-- <a href="signUp.php" class="sign">Sign up</a> -->
             <button class="sign" onclick="window.location.href='login.html#register'">Register</button>
        </div>
    </header>

    <!--  Home section  -->
    <section class="home-section" id="home">
        <div class="overlay"></div>
        <div class="home-container">
            <h1>Unlock the Door To Your Ideal Home</h1>
            <p>Discover properties across India's most sought-after locations. Your dream home is just one click away.</p>
            <div class="home-cta">
                <a href="#buy" class="cta-primary">Explore Properties <i class="fa-solid fa-arrow-right"></i></a>
                <a href="#contact" class="cta-secondary">Talk to Expert</a>
            </div>
        </div>
    </section>
    
    <!--  Service section  -->
    <section class="services-section" id="servises">
        <div class="services-container">
            <h1><span>Our </span>Services</h1>
            <div class="servise-boxes">
                <div class="box">
                    <i class="fa-  fa-house-lock"></i>
                    <h3>Property Insurance</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur a magnam nihil provident nulla in ut debitis asperiores, deleniti quaerat!</p>
                </div>
                <div class="box">
                    <div class="box-icon"><i class="fa-solid fa-credit-card"></i></div>
                    <h3>Easy Payment</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eos ipsa illum officiis assumenda iusto, consequatur incidunt quos voluptatum esse maxime?</p>
                </div>
                <div class="box">
                    <div class="box-icon"><i class="fa-solid fa-gears"></i></div>
                    <h3>Property Insurance</h3>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ex dolor voluptatibus corrupti? Amet commodi nemo consequatur doloribus optio aperiam cupiditate.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Filter Section -->
    <section class="main-filter-section">
        <div class="filter-container">
            <form id="globalFilterForm">
                <div class="filter-item">
                    <label>Purpose</label>
                    <select id="mainType">
                        <option value="buy">Buy</option>
                        <option value="rent">Rent</option>
                    </select>
                </div>

                <div class="filter-item">
                    <label>Location</label>
                    <select id="mainCity">
                        <option value="">All Locations</option>
                        <option value="Mumbai">Worli</option>
                        <option value="Thane">Thane West</option>
                        <option value="Powai">Powai</option>
                        <option value="Kalyan">Kalyan</option>
                    </select>
                </div>

                <div class="filter-item">
                    <label>Max Price</label>
                    <input type="number" id="mainPrice" placeholder="e.g. 40000" class="styled-input">
                </div>

                <div class="filter-action-group">
                    <button type="button" class="main-search-btn" onclick="executeGlobalFilter()">
                        <i class="fa-solid fa-magnifying-glass"></i> Search
                    </button>
                    <button type="button" id="clearFilterBtn" class="clear-btn" onclick="clearFilters()" style="display: none;">
                        <i class="fa-solid fa-xmark"></i> Clear
                    </button>
                </div>
            </form>

            <div id="filterResultDisplay" class="filter-results-grid">
                <p class="placeholder-text">Select filters and click search to see properties here.</p>
            </div>
        </div>
    </section>
    <!--  Sell section  -->
    <section class="sell-section" id="buy">
        <div class="sell-container">
            <h1>Best Collection <span>on Buy</span></h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis, fugiat.</p>
            <!-- CARDS CONTAINER -->
            <div class="sell-box">
            <?php 
            $result = mysqli_query($conn, "SELECT * FROM properties 
                WHERE type = 'buy' 
                ORDER BY id DESC 
                LIMIT 6
            ");
            while($row = mysqli_fetch_assoc($result)){ ?>
                <!-- SINGLE CARD -->
                <div class="box-content">
                    <!-- IMAGE + BADGE -->
                    <div class="card-img">
                        <img src="./uploads/<?= $row['image']; ?>" alt="house image">
                        <div class="box-sell">
                            <span>Buy</span>
                        </div>
                    </div>
                    <!-- CARD BODY -->
                    <div class="card-body">
                        <!-- TITLE -->
                        <h2><?= $row['name']; ?></h2>
                        <!-- LOCATION -->
                        <p class="location">
                            <i class="fa-solid fa-location-dot"></i>
                            <?= $row['city']; ?>
                        </p>
                        <!-- FEATURES -->
                        <div class="sell-icon">
                            <span class="icon-text">
                                <i class="fa-solid fa-bed"></i><?= $row['rooms']; ?>BHK
                            </span>
                            <span class="icon-text">
                                <i class="fa-solid fa-bath"></i><?= $row['bathrooms']; ?>
                            </span>
                            <span class="icon-text">
                                <i class="fa-solid fa-ruler-combined"></i><?= $row['area']; ?>sqft
                            </span>
                        </div>
                        <!-- PRICE -->
                        <p class="property-price" style="text-align: left;">
                            <i class="fa-solid fa-indian-rupee-sign"></i>
                            <?= number_format($row['price']); ?>
                        </p>
                        <!-- BUTTON -->
                        <a href="view_details.php?id=<?= $row['id']; ?>" class="view-btn"> View Details </a>
                    </div>
                </div>
            <?php } ?>
            </div>
            <!-- LOAD MORE
            <button id="loadMore" class="load-btn">View More</button> -->
        </div>
    </section>
    <!-- Rent section -->
    <section class="rent" id="rent">
        <div class="rent-container">
            <h1>Property on <span>Rent</span></h1>
            <div class="rent-box">
                <?php
                $result1 = mysqli_query($conn, "SELECT * FROM properties 
                    WHERE type = 'rent' 
                    ORDER BY id DESC 
                    LIMIT 6
                "); 
                while($row = mysqli_fetch_assoc($result1)){ ?>
                <div class="rent-card">
                    <div class="rent-img">
                        <img src="./uploads/<?= $row['image']; ?>" alt="house image">
                    </div>
                    <div class="card-body">
                        <!-- TITLE -->
                        <h2 style="margin: .8rem 0;"><?= $row['name']; ?></h2>
                        <!-- LOCATION -->
                        <p class="location">
                            <i class="fa-solid fa-location-dot"></i>
                            <?= $row['city']; ?>
                        </p>
                        <div class="sell-icon">
                            <span class="icon-text">
                                <i class="fa-solid fa-bed"></i><?= $row['rooms']; ?>BHK
                            </span>

                            <span class="icon-text">
                                <i class="fa-solid fa-bath"></i><?= $row['bathrooms']; ?>
                            </span>

                            <span class="icon-text">
                                <i class="fa-solid fa-ruler-combined"></i><?= $row['area']; ?>sqft
                            </span>
                        </div>
                        <!-- PRICE -->
                        <p class="property-price" style="text-align: left;">
                            <i class="fa-solid fa-indian-rupee-sign"></i>
                            <?= number_format($row['price']); ?>
                        </p>
                        <!-- BUTTON -->
                        <a href="view_details.php?id=<?= $row['id']; ?>" class="view-btn">
                            View Details
                        </a>
                    </div>    
                </div>
                <?php } ?>    
            </div>
        </div>
    </section>

    <!--Features section-->
    <section class="feactures" id="features">
        <div class="feture-content">
                <h1>Our Key <span>Features</span></h1>
            <div class="feature-container">
                <button class="prev">
                    <i class="fa-solid fa-angle-left"></i>
                </button>
                <div class="slider-track">
                    <!--card1-->
                    <div class="slide">
                        <div class="card-item">
                            <img src="./images/card2.jpg" alt="">
                            <h2>Real-Time Updates</h2>
                            <p>Stay updated with the latest listings and property availability in real time</p>
                        </div>
                    </div>
                    <!--Card2-->
                    <div class="slide">
                        <div class="card-item">
                            <img src="./images/card3.jpg" alt="">
                            <h2>Trusted Agents</h2>
                            <p>Connect with verified and experienced real estate agents for smooth transactions.</p>
                        </div>
                    </div>
                    <!--Card3-->
                    <div class="slide">
                        <div class="card-item">
                            <img src="./images/card1.jpg" alt="">
                            <h2>High-Quality Images</h2>
                            <p>View detailed property images and galleries before making decisions.</p>
                        </div>
                    </div>
                    <!--Card4-->
                    <div class="slide">
                        <div class="card-item">
                            <img src="./images/card2.jpg" alt="">
                            <h2>Secure Transactions</h2>
                            <p>Your data and transactions are protected with advanced security systems.</p>
                        </div>
                    </div>
                    <!--Card5-->
                    <div class="slide">
                        <div class="card-item">
                            <img src="./images/card3.jpg" alt="">
                            <h2>Responsive Design.</h2>
                            <p>Access the platform on mobile, tablet, or desktop seamlessly.</p>
                        </div>
                    </div>
                </div>
                <button class="next">
                    <i class="fa-solid fa-angle-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!--Contact section-->
    <section class="contact-section" id="contact">
        <div class="overlay"></div>
        <div class="contact-container">
            <div class="contact-left">
                <h1>Need consultation?</h1>
                <h2>Contact us, we are ready to help.</h2>
                <div class="info">
                    <h3>contact</h3>
                    <p><i class="fa-solid fa-location-dot"></i>Kharghar</p>
                    <p><i class="fa-solid fa-phone"></i> +91 1234567890</p>
                    <p><i class="fa-solid fa-envelope"></i> bhagwatiProperty@gmail.com</p>
                </div>
                <div class="social">
                    <a href="#"><i class="fa-brands fa-instagram"></i></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                </div>
            </div>
            <div class="contact-form">
                <h2>Any Question? Contact Us</h2>
                <form action="form.php" method="post">
                    <input type="text" name="name" placeholder="Enter your name" required>
                    <input type="text" name="number" placeholder="Enter phone Number" required>
                    <input type="text" name="email" placeholder="Enter Your valid email" required>
                    <textarea name="message" id="" cols="30" rows="10" placeholder="Enter your Query" required></textarea>
                    <button type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </section>
    <!--Footer-->
    <footer>
        <div class="logo">
            <i class="fa-solid fa-house-chimney"></i>
            <span>Bhagwati Property</span>
        </div>
        <p>© 2026 <span>Bhagwati Property</span> | Designed by <span> TechKraftiers Digital</span></p>
    </footer>
    <!--Script-->
    <script src="script.js"></script>

    <!-- ============================================================
         myProperty CHATBOT WIDGET
         ============================================================ -->

    <!-- 1. Floating button -->
    <button id="chat-toggle-btn" onclick="toggleChat()" title="Chat with myProperty">
        <i class="fa-solid fa-comments" id="chat-icon"></i>
        <span class="notif" id="chat-notif">1</span>
    </button>

    <!-- 2. Chat window -->
    <div id="chat-window">

        <!-- Header -->
        <!-- <div class="chat-header">
            <div class="bot-avatar">🏠</div>
            <div class="bot-info">
                <h6>myProperty Assistant</h6>
                <small><span class="online-dot"></span>Online · Always here to help</small>
            </div>
            <button class="close-btn" onclick="toggleChat()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div> -->
        <!-- Header -->
        <div class="chat-header">
            <div class="bot-avatar">🏠</div>
            <div class="bot-info">
                <h6>myProperty Assistant</h6>
                <small><span class="online-dot"></span>Online · Always here to help</small>
            </div>
            <button class="close-btn" onclick="toggleChat()">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

       
        <div id="onboard-progress" style="background:#1a2a4a; padding:6px 18px 10px; flex-shrink:0;">
            <div id="progress-label" style="font-size:10px; color:#0d6efd; font-weight:600; letter-spacing:0.5px; margin-bottom:4px;">Step 1 of 5 — Name</div>
            <div style="background:#dde; border-radius:10px; height:5px; width:100%;">
                <div id="progress-fill" style="height:5px; border-radius:10px; background:linear-gradient(90deg,#0d6efd,#0a58ca); width:20%; transition:width 0.4s ease;"></div>
            </div>
        </div>

        
        <!-- Messages -->
        <div class="chat-messages" id="chat-messages"></div>

        <!-- Input -->
        <div class="chat-input-area">
            <input type="text" id="chat-input" placeholder="Ask about property, rent, sell…"
                   onkeydown="if(event.key==='Enter') sendMessage()">
            <button onclick="sendMessage()">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </div>

        <div class="chat-footer-bar">🏡 Powered by myProperty AI</div>
    </div>

    <!-- ============================================================
         WHATSAPP BUTTON — Direct redirect, no popup
         ============================================================ -->
    <a id="wa-btn"
       href="https://wa.me/918779753246?text=Hi!%20I%20found%20you%20on%20myProperty%20website.%20I'm%20interested%20in%20a%20property.%20Please%20share%20more%20details."
       target="_blank"
       rel="noopener noreferrer"
       title="Chat with us on WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
    <a id="wa-btn"
   href="https://wa.me/9619525492?text=Hi!%20I%20found%20you%20on%20myProperty%20website.%20I'm%20interested%20in%20a%20property.%20Please%20share%20more%20details."
   target="_blank"
   rel="noopener noreferrer"
   title="Chat with us on WhatsApp +91 9619525492">
    <i class="fa-brands fa-whatsapp"></i>
</a>

    <!-- ===== CHATBOT JAVASCRIPT ===== -->
    <script>
        /* -------------------------------------------------------
           REAL ESTATE KNOWLEDGE BASE
           Add / edit topics here easily
           ------------------------------------------------------- */
        const BOT_RULES = [
            {
                keywords: ['hello', 'hi', 'hey', 'hii', 'namaste', 'good morning', 'good evening', 'howdy'],
                response: "👋 Welcome to <b>myProperty</b>! I'm your personal property assistant. How can I help you find your dream home today?",
                quickReplies: ["Buy a property", "Rent a property", "Sell my property", "Property insurance", "Contact agent"]
            },
            {
                keywords: ['buy', 'purchase', 'buying', 'want to buy', 'looking to buy'],
                response: "🏡 Great choice! We have excellent properties available for sale across Mumbai, Maharashtra and surrounding areas. Our listings include:<br><ul style='margin:6px 0 0 16px;padding:0'><li>Independent Houses</li><li>Apartments & Flats</li><li>Villas & Bungalows</li><li>Commercial Properties</li></ul>Would you like to explore our current listings?",
                quickReplies: ["View listings", "Budget under ₹50L", "Budget under ₹1Cr", "Contact agent"]
            },
            {
                keywords: ['rent', 'rental', 'renting', 'tenant', 'for rent', 'lease'],
                response: "🏢 Looking to rent? We have a wide variety of rental properties! Prices vary by location and property type. Our rental properties include fully furnished, semi-furnished and unfurnished options.",
                quickReplies: ["1 BHK rent", "2 BHK rent", "3 BHK rent", "Contact agent"]
            },
            {
                keywords: ['sell', 'selling', 'want to sell', 'list my property', 'my property'],
                response: "📋 Want to sell your property? <b>myProperty</b> makes it simple!<br><ul style='margin:6px 0 0 16px;padding:0'><li>Free property listing</li><li>Expert valuation</li><li>Verified buyer network</li><li>End-to-end documentation support</li></ul>Contact our team to get started!",
                quickReplies: ["Get free valuation", "Talk to an agent", "Contact us"]
            },
            {
                keywords: ['insurance', 'property insurance', 'insure', 'protection'],
                response: "🏠🔒 Our <b>Property Insurance</b> service protects your investment! Coverage includes:<br><ul style='margin:6px 0 0 16px;padding:0'><li>Structural damage protection</li><li>Natural disaster coverage</li><li>Theft & burglary protection</li><li>Third-party liability</li></ul>Contact us for a free insurance quote.",
                quickReplies: ["Get insurance quote", "Contact agent", "Our services"]
            },
            {
                keywords: ['payment', 'pay', 'emi', 'loan', 'home loan', 'finance', 'easy payment'],
                response: "💳 We offer <b>Easy Payment</b> options including:<br><ul style='margin:6px 0 0 16px;padding:0'><li>Home loan assistance</li><li>EMI calculator support</li><li>Bank tie-ups for best rates</li><li>Down payment flexibility</li></ul>Our finance team will guide you through the entire process!",
                quickReplies: ["Calculate EMI", "Loan assistance", "Contact agent"]
            },
            {
                keywords: ['price', 'cost', 'how much', 'rate', 'budget', 'affordable', 'cheap'],
                response: "💰 Our property prices vary based on location, size and amenities. To give you accurate pricing:<br><ul style='margin:6px 0 0 16px;padding:0'><li>Apartments start from <b>₹30 Lakh</b></li><li>Independent houses from <b>₹80 Lakh</b></li><li>Villas from <b>₹1.5 Crore</b></li></ul>Let our agent give you a personalized quote!",
                quickReplies: ["Under ₹50 Lakh", "Under ₹1 Crore", "Above ₹1 Crore", "Contact agent"]
            },
            {
                keywords: ['1 bhk', 'one bhk', '1bhk'],
                response: "🛏️ <b>1 BHK Properties</b> — Perfect for singles and couples!<br><br>📍 Available in Mumbai, Navi Mumbai & Thane<br>💰 Price Range: ₹25L – ₹55L (Buy) | ₹8,000 – ₹18,000/month (Rent)<br><br>Our agent can shortlist the best options for you!",
                quickReplies: ["Schedule a visit", "Contact agent", "2 BHK options"]
            },
            {
                keywords: ['2 bhk', 'two bhk', '2bhk'],
                response: "🛏️🛏️ <b>2 BHK Properties</b> — Ideal for small families!<br><br>📍 Available in Mumbai, Navi Mumbai & Thane<br>💰 Price Range: ₹45L – ₹90L (Buy) | ₹14,000 – ₹28,000/month (Rent)<br><br>Schedule a visit to find your perfect 2 BHK!",
                quickReplies: ["Schedule a visit", "Contact agent", "3 BHK options"]
            },
            {
                keywords: ['3 bhk', 'three bhk', '3bhk', 'villa', 'bungalow'],
                response: "🏡 <b>3 BHK / Villa / Bungalow</b> — Spacious living for families!<br><br>📍 Premium locations in Mumbai, Lonavala & Pune<br>💰 Price Range: ₹80L – ₹3Cr (Buy) | ₹25,000 – ₹60,000/month (Rent)<br><br>Let us help you find your dream home!",
                quickReplies: ["Schedule a visit", "Contact agent", "View all listings"]
            },
            {
                keywords: ['location', 'area', 'mumbai', 'navi mumbai', 'thane', 'pune', 'where'],
                response: "📍 We operate in prime locations including:<br><ul style='margin:6px 0 0 16px;padding:0'><li><b>Mumbai</b> – Andheri, Bandra, Powai, Dadar</li><li><b>Navi Mumbai</b> – CBD Belapur, Vashi, Kharghar</li><li><b>Thane</b> – Ghodbunder Road, Majiwada</li><li><b>Pune</b> – Hinjewadi, Wakad, Kothrud</li></ul>",
                quickReplies: ["Properties in Mumbai", "Properties in Pune", "Contact agent"]
            },
            {
                keywords: ['visit', 'schedule', 'site visit', 'appointment', 'book visit'],
                response: "📅 We'd love to arrange a site visit for you! Our agents are available <b>Monday – Saturday, 9 AM – 7 PM</b>.<br><br>📞 Call: <b>+91 1234567890</b><br>📧 Email: <b>myProperty@gmail.com</b><br><br>Or use our Contact form to book!",
                quickReplies: ["Go to contact form", "Call us now", "WhatsApp us"]
            },
            {
                keywords: ['contact', 'agent', 'help', 'support', 'talk', 'call', 'phone', 'consult'],
                response: "📞 Our expert property consultants are ready to help!<br><br><b>📱 Phone:</b> +91 1234567890<br><b>📧 Email:</b> myProperty@gmail.com<br><b>📍 Address:</b> Mumbai, Maharashtra<br><b>🕐 Hours:</b> Mon–Sat, 9 AM – 7 PM<br><br>You can also use our <a href='#' style='color:#c8902a'>Contact Form</a> below!",
                quickReplies: ["Schedule a visit", "Send a message", "Our services"]
            },
            {
                keywords: ['service', 'services', 'what do you offer', 'what you do', 'offer'],
                response: "🏢 <b>myProperty</b> offers a complete real estate experience:<br><ul style='margin:6px 0 0 16px;padding:0'><li>🔑 <b>Buy</b> – Verified properties at best prices</li><li>🏡 <b>Sell</b> – Reach 1000s of buyers</li><li>🏠 <b>Rent</b> – Find your rental home</li><li>🔒 <b>Insurance</b> – Protect your property</li><li>💳 <b>Easy Payment</b> – Home loan assistance</li></ul>",
                quickReplies: ["Buy property", "Rent property", "Sell property", "Contact agent"]
            },
            {
                keywords: ['document', 'registration', 'paperwork', 'legal', 'agreement'],
                response: "📄 <b>Documentation Support</b> — We handle all the paperwork for you!<br><ul style='margin:6px 0 0 16px;padding:0'><li>Sale deed & registration</li><li>Khata & encumbrance certificate</li><li>RERA registration verification</li><li>Loan document processing</li></ul>Our legal team ensures 100% safe transactions.",
                quickReplies: ["Contact legal team", "Talk to agent"]
            },
            {
                keywords: ['rera', 'registered', 'verified', 'safe', 'trust', 'authentic'],
                response: "✅ All properties listed on <b>myProperty</b> are <b>RERA registered</b> and fully verified. We ensure:<br><ul style='margin:6px 0 0 16px;padding:0'><li>Clear title & ownership</li><li>No hidden charges</li><li>100% legal compliance</li><li>Transparent transactions</li></ul>Your investment is completely safe with us!",
                quickReplies: ["Browse properties", "Contact agent"]
            },
            {
                keywords: ['thank', 'thanks', 'thank you', 'awesome', 'great', 'wonderful', 'helpful'],
                response: "😊 You're most welcome! It's our pleasure to help you find your perfect property. Is there anything else I can assist you with?",
                quickReplies: ["Browse properties", "Contact agent", "Our services"]
            },
            {
                keywords: ['bye', 'goodbye', 'see you', 'ok bye', 'no thanks', 'that\'s all'],
                response: "👋 Thank you for visiting <b>myProperty</b>! We hope to help you find your dream home soon. Have a wonderful day! 🏡",
                quickReplies: []
            }
        ];

        const DEFAULT_REPLY = {
            response: "🤔 I'm not sure about that, but our expert agents can definitely help! Here's what I can assist you with:",
            quickReplies: ["Buy a property", "Rent a property", "Sell my property", "Contact agent", "Our services"]
        };

        /* ------- STATE ------- */
        // let isOpen = false;
        // let isTyping = false;
        // const messagesEl = document.getElementById('chat-messages');

        /* ------- STATE ------- */
        let isOpen = false;
        let isTyping = false;
        const messagesEl = document.getElementById('chat-messages');

        /* ✅ ONBOARDING STATE */
        let userInfo = {
            name: '',
            email: '',
            location: '',
            budget: '',
            propertyType: '',
            step: 'idle'
        };

        const STEPS = {
            ask_name:          { label: 'Step 1 of 5 — Name',          width: '20%'  },
            ask_email:         { label: 'Step 2 of 5 — Email',         width: '40%'  },
            ask_location:      { label: 'Step 3 of 5 — Location',      width: '60%'  },
            ask_budget:        { label: 'Step 4 of 5 — Budget',        width: '80%'  },
            ask_property_type: { label: 'Step 5 of 5 — Property Type', width: '100%' },
            done:              { label: 'All set! ✅',                  width: '100%' }
        };

        function updateProgress(step) {
            const s = STEPS[step];
            if (!s) return;
            document.getElementById('progress-label').textContent = s.label;
            document.getElementById('progress-fill').style.width   = s.width;
        }

        function handleOnboarding(input) {
            if (userInfo.step === 'ask_name') {
                userInfo.name  = input;
                userInfo.step  = 'ask_email';
                updateProgress('ask_email');
                addBotMessage(`Nice to meet you, <b>${userInfo.name}</b>! 😊<br><br>Could you please share your <b>Email ID</b>?`, []);
                return true;
            }
            if (userInfo.step === 'ask_email') {
                userInfo.email = input;
                userInfo.step  = 'ask_location';
                updateProgress('ask_location');
                addBotMessage(`Got it! 📧 <b>${userInfo.email}</b><br><br>Which <b>city / location</b> are you looking for a property in?<br><i style="font-size:12px;color:#888">e.g. Mumbai, Pune, Navi Mumbai…</i>`, []);
                return true;
            }
            if (userInfo.step === 'ask_location') {
                userInfo.location = input;
                userInfo.step     = 'ask_budget';
                updateProgress('ask_budget');
                addBotMessage(`Great choice! 📍 <b>${userInfo.location}</b><br><br>What is your <b>budget range</b>? Please select one below 👇`,
                    ["5L – 10L", "10L – 20L", "20L – 35L", "35L – 50L", "Above 50L"]);
                return true;
            }
            if (userInfo.step === 'ask_budget') {
                userInfo.budget = input;
                userInfo.step   = 'ask_property_type';
                updateProgress('ask_property_type');
                addBotMessage(`Budget noted 💰 <b>${userInfo.budget}</b><br><br>What type of <b>property</b> are you interested in? Please select one below 👇`,
                    ["🏢 Flat", "🏬 Apartment", "🏡 Villa", "🌳 Plot / Land"]);
                return true;
            }
      if (userInfo.step === 'ask_property_type') {
    userInfo.propertyType = input;
    userInfo.step         = 'done';
    updateProgress('done');
    document.getElementById('onboard-progress').style.display = 'none';
    document.getElementById('chat-input').placeholder = 'Ask about property, rent, sell…';
    addBotMessage(
        `✅ Thank you, <b>${userInfo.name}</b>! Our agent will contact you shortly. 😊<br><br>How can I help you today?`,
        ["Buy a property", "Rent a property", "Sell my property", "Contact agent"]);
    return true;
}
            return false;
        }
2
        /* ------- TOGGLE ------- */
        function toggleChat() {
            isOpen = !isOpen;
            const win = document.getElementById('chat-window');
            const icon = document.getElementById('chat-icon');
            const notif = document.getElementById('chat-notif');

        //     if (isOpen) {
        //         win.classList.add('open');
        //         icon.className = 'fa-solid fa-xmark';
        //         notif.style.display = 'none';
        //         if (messagesEl.children.length === 0) {
        //             setTimeout(() => addBotMessage(
        //                 "🏡 Hi! I'm the <b>myProperty Assistant</b>. Whether you want to <b>buy, sell or rent</b> — I'm here to guide you. What can I help you with today?",
        //                 ["Buy a property", "Rent a property", "Sell my property", "Contact agent"]
        //             ), 450);
        //         }
        //         scrollToBottom();
        //     } else {
        //         win.classList.remove('open');
        //         icon.className = 'fa-solid fa-comments';
        //     }
        // }

//         if (isOpen) {
//     win.classList.add('open');
//     icon.className = 'fa-solid fa-xmark';
//     notif.style.display = 'none';

//     // ✅ NEW LINE — clears old messages every time chat opens
//     messagesEl.innerHTML = '';

//     // Welcome message always shows fresh
//     setTimeout(() => addBotMessage(
//         "🏡 Hi! I'm the <b>myProperty Assistant</b>. Whether you want to <b>buy, sell or rent</b> — I'm here to guide you. What can I help you with today?",
//         ["Buy a property", "Rent a property", "Sell my property", "Contact agent"]
//     ), 450);

//     scrollToBottom();
// }
if (isOpen) {
            win.classList.add('open');
            icon.className = 'fa-solid fa-xmark';
            notif.style.display = 'none';

            // ✅ Fresh start every time
            messagesEl.innerHTML = '';

            // ✅ Reset onboarding
            userInfo = { name:'', email:'', location:'', budget:'', propertyType:'', step:'ask_name' };

            // ✅ Show progress bar and reset it
            document.getElementById('onboard-progress').style.display = 'block';
            updateProgress('ask_name');

            // ✅ Reset input placeholder
            document.getElementById('chat-input').placeholder = 'Type your answer here…';

            // ✅ First onboarding question
            setTimeout(() => addBotMessage(
                "🏡 Welcome to <b>myProperty</b>! I'm your personal property assistant.<br><br>Before we begin, may I know your <b>name</b> please? 😊",
                []
            ), 450);

            scrollToBottom();
        }
        else {
                win.classList.remove('open');
                 icon.className = 'fa-solid fa-comments';
             }
         }

        /* ------- SEND ------- */
        // function sendMessage() {
        //     const input = document.getElementById('chat-input');
        //     const text = input.value.trim();
        //     if (!text || isTyping) return;
        //     input.value = '';
        //     addUserMessage(text);
        //     showTyping();
        //     setTimeout(() => {
        //         removeTyping();
        //         const reply = getReply(text.toLowerCase());
        //         addBotMessage(reply.response, reply.quickReplies);
        //     }, 900 + Math.random() * 400);
        // }
        /* ------- SEND ------- */
        function sendMessage() {
            const input = document.getElementById('chat-input');
            const text = input.value.trim();
            if (!text || isTyping) return;
            input.value = '';
            addUserMessage(text);
            showTyping();
            setTimeout(() => {
                removeTyping();
                // ✅ Handle onboarding steps first
                if (userInfo.step !== 'done' && userInfo.step !== 'idle') {
                    handleOnboarding(text);
                    return;
                }
                // ✅ Normal replies after onboarding done
                const reply = getReply(text.toLowerCase());
                addBotMessage(reply.response, reply.quickReplies);
            }, 900 + Math.random() * 400);
        }

        /* ------- KNOWLEDGE BASE LOOKUP ------- */
        function getReply(input) {
            for (const rule of BOT_RULES) {
                if (rule.keywords.some(kw => input.includes(kw))) return rule;
            }
            return DEFAULT_REPLY;
        }

        /* ------- ADD USER MESSAGE ------- */
        function addUserMessage(text) {
            const div = document.createElement('div');
            div.className = 'msg user';
            div.textContent = text;
            messagesEl.appendChild(div);
            scrollToBottom();
        }

        /* ------- ADD BOT MESSAGE ------- */
        function addBotMessage(html, quickReplies = []) {
            const div = document.createElement('div');
            div.className = 'msg bot';
            div.innerHTML = `<div class="msg-sender">myProperty Assistant</div>${html}`;

            if (quickReplies.length > 0) {
                const qr = document.createElement('div');
                qr.className = 'quick-replies';
                quickReplies.forEach(label => {
                    const btn = document.createElement('button');
                    btn.className = 'qr-btn';
                    btn.textContent = label;
                    btn.onclick = () => {
                        document.getElementById('chat-input').value = label;
                        sendMessage();
                    };
                    qr.appendChild(btn);
                });
                div.appendChild(qr);
            }

            messagesEl.appendChild(div);
            scrollToBottom();
        }

        /* ------- TYPING INDICATOR ------- */
        function showTyping() {
            isTyping = true;
            const div = document.createElement('div');
            div.className = 'typing-indicator';
            div.id = 'typing-dots';
            div.innerHTML = '<span></span><span></span><span></span>';
            messagesEl.appendChild(div);
            scrollToBottom();
        }

        function removeTyping() {
            isTyping = false;
            const el = document.getElementById('typing-dots');
            if (el) el.remove();
        }

        // /* ------- SCROLL ------- */
        // function scrollToBottom() {
        //     setTimeout(() => { messagesEl.scrollTop = messagesEl.scrollHeight; }, 50);
        // }
        /* ------- SCROLL ------- */
        function scrollToBottom() {
            setTimeout(() => { messagesEl.scrollTop = messagesEl.scrollHeight; }, 50);
        }

        /* NEW — Auto open chatbot after 5 seconds on page load */
        window.addEventListener('load', function () {
            setTimeout(() => {
                if (!isOpen) {
                    toggleChat();
                }
            }, 5000);
        });
    </script>
    <!-- ===== END CHATBOT ===== -->
</body>
</html>