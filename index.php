<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusHub - The Ultimate Hub for Campus Life</title>
    
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Righteous&display=swap" rel="stylesheet">
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    
    <link rel="stylesheet" href="style/custom.css">
</head>
<body class="bg-light" style="font-family: 'Poppins', sans-serif;">

    
    <nav class="navbar navbar-expand-lg fixed-top landing-navbar">
        <div class="container">
            <a class="navbar-brand brand d-flex align-items-center gap-2" href="#">
                <i class="bi bi-mortarboard-fill fs-3" style="color: var(--primary);"></i>
                <span class="font-righteous fs-4" style="color: var(--primary);">CampusHub</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto fw-medium">
                    <li class="nav-item"><a class="nav-link px-3" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#portals">Portals</a></li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="student.php" class="btn btn-outline-primary px-4 rounded-pill fw-semibold">Sign In</a>
                </div>
            </div>
        </div>
    </nav>

    
    <section class="landing-hero" id="home">
        <div class="hero-bg-shapes">
            <div class="shape-1"></div>
            <div class="shape-2"></div>
            <div class="shape-3"></div>
        </div>
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <span class="badge badge-soft-success rounded-pill px-3 py-2 mb-4 fw-semibold border border-success border-opacity-25" style="background: rgba(34,197,94,0.1); color: var(--accent);">
                        <i class="bi bi-stars me-1"></i> Welcome to the Next-Gen Campus Platform
                    </span>
                    <h1 class="hero-title">The Ultimate Hub for Campus Life</h1>
                    <p class="lead text-muted mb-5 px-md-5 fw-medium">
                        Connect with your peers, discover exciting events, manage your organizations, and stay updated with real-time announcements. Everything you need, all in one premium portal.
                    </p>
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="student.php" class="btn btn-primary btn-lg rounded-pill px-5 shadow-lg d-flex align-items-center justify-content-center gap-2">
                            Access Student Portal <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="admin.php" class="btn btn-outline-dark btn-lg rounded-pill px-5 d-flex align-items-center justify-content-center gap-2 bg-white bg-opacity-75" style="backdrop-filter: blur(10px);">
                            Admin Portal <i class="bi bi-shield-lock"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-5 my-5" id="features">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="font-righteous" style="color: var(--primary); font-size: 3rem;">Empower Your Experience</h2>
                <p class="text-muted fw-medium fs-5">Everything you need to thrive in your academic community.</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="landing-feature-card text-center">
                        <div class="feature-icon-wrapper mx-auto">
                            <i class="bi bi-calendar2-heart-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-3" style="color: var(--text);">Dynamic Events</h4>
                        <p class="text-muted mb-0">Discover and register for upcoming campus events, workshops, and extracurricular activities instantly.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="landing-feature-card text-center">
                        <div class="feature-icon-wrapper mx-auto">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-3" style="color: var(--text);">Communities</h4>
                        <p class="text-muted mb-0">Join clubs, departments, and organizations to connect with like-minded peers and collaborate seamlessly.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="landing-feature-card text-center">
                        <div class="feature-icon-wrapper mx-auto">
                            <i class="bi bi-megaphone-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-3" style="color: var(--text);">Announcements</h4>
                        <p class="text-muted mb-0">Stay informed with real-time updates and notifications directly from university administration.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="landing-feature-card text-center">
                        <div class="feature-icon-wrapper mx-auto">
                            <i class="bi bi-images"></i>
                        </div>
                        <h4 class="fw-bold mb-3" style="color: var(--text);">Media Gallery</h4>
                        <p class="text-muted mb-0">Share, view, and organize rich multimedia content capturing the best moments of campus life.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="py-5" id="portals">
        <div class="container my-5">
            <div class="p-5 rounded-5 shadow-lg position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--primary), #4c1d95);">
                <div class="position-absolute top-0 end-0 p-5 opacity-25">
                    <i class="bi bi-mortarboard-fill" style="font-size: 15rem; color: white;"></i>
                </div>
                <div class="row align-items-center position-relative z-1">
                    <div class="col-lg-8 text-white">
                        <h2 class="font-righteous mb-3" style="font-size: 3rem;">Ready to dive in?</h2>
                        <p class="lead mb-4 opacity-75">Join thousands of students utilizing CampusHub to manage their university journey efficiently and beautifully.</p>
                        <a href="student.php" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-primary shadow">Get Started Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <footer class="bg-white border-top py-5 mt-5">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="bi bi-mortarboard-fill fs-4" style="color: var(--primary);"></i>
                        <span class="font-righteous fs-5" style="color: var(--primary);">CampusHub</span>
                    </div>
                    <p class="text-muted small pe-lg-5">The premier digital platform transforming the way university communities connect, organize, and thrive.</p>
                </div>
                <div class="col-6 col-lg-2 offset-lg-2">
                    <h6 class="fw-bold mb-3">Portals</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="student.php" class="text-decoration-none text-muted">Student Portal</a></li>
                        <li class="mb-2"><a href="admin.php" class="text-decoration-none text-muted">Admin Portal</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="fw-bold mb-3">Resources</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Help Center</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-muted">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h6 class="fw-bold mb-3">Connect</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-muted fs-5 hover-primary"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="text-muted fs-5 hover-primary"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-muted fs-5 hover-primary"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 text-muted opacity-25">
            <div class="text-center small text-muted">
                &copy; 2026 CampusHub Platform. All rights reserved.
            </div>
        </div>
    </footer>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
