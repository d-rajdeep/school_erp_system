<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School ERP System - Comprehensive School Management Solution</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #4e73df;
            --primary-dark: #224abe;
            --primary-light: #6b8cff;
            --secondary: #1cc88a;
            --warning: #f6c23e;
            --danger: #e74a3b;
            --dark: #2c3e50;
            --light: #f8f9fc;
            --gray: #858796;
            --white: #ffffff;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--dark);
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 20px 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding: 15px 0;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo i {
            font-size: 32px;
            color: var(--primary);
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logo span {
            font-size: 24px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 30px;
            list-style: none;
        }

        .nav-menu a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s ease;
            font-size: 16px;
        }

        .nav-menu a:hover {
            color: var(--primary);
        }

        .login-btn {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white !important;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600 !important;
            box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
            transition: all 0.3s ease !important;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(78, 115, 223, 0.4);
            color: white !important;
        }

        .login-btn i {
            font-size: 14px;
        }

        .mobile-menu-btn {
            display: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--primary);
        }

        /* Hero Section */
        .hero {
            padding: 150px 0 100px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            opacity: 0.1;
        }

        .hero-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 48px;
            font-weight: 800;
            color: var(--white);
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .hero-content p {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 30px;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
        }

        .btn-primary {
            background: var(--white);
            color: var(--primary);
            padding: 15px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .btn-outline {
            background: transparent;
            color: var(--white);
            padding: 15px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-outline:hover {
            border-color: var(--white);
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
        }

        .hero-image {
            position: relative;
        }

        .hero-image img {
            width: 100%;
            border-radius: 20px;
            box-shadow: var(--shadow-hover);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        /* Stats Section */
        .stats {
            padding: 80px 0;
            background: var(--white);
        }

        .stats-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .stat-item {
            text-align: center;
            padding: 30px;
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: var(--white);
            font-size: 30px;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .stat-label {
            color: var(--gray);
            font-weight: 500;
        }

        /* Features Section */
        .features {
            padding: 100px 0;
            background: var(--light);
        }

        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 60px;
        }

        .section-header h2 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--dark);
        }

        .section-header p {
            color: var(--gray);
            font-size: 18px;
        }

        .features-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .feature-card {
            background: var(--white);
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            text-align: center;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-light), var(--primary));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            color: var(--white);
            font-size: 35px;
            transform: rotate(45deg);
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: rotate(0deg);
        }

        .feature-icon i {
            transform: rotate(-45deg);
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon i {
            transform: rotate(0deg);
        }

        .feature-card h3 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--dark);
        }

        .feature-card p {
            color: var(--gray);
            line-height: 1.6;
        }

        /* Multi-Tenancy Section */
        .multi-tenant {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
        }

        .tenant-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
        }

        .tenant-content h2 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .tenant-content p {
            font-size: 18px;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .tenant-features {
            list-style: none;
        }

        .tenant-features li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tenant-features i {
            color: var(--secondary);
            font-size: 20px;
        }

        .tenant-image img {
            width: 100%;
            border-radius: 20px;
            box-shadow: var(--shadow-hover);
        }

        /* Admin Roles Section */
        .roles {
            padding: 100px 0;
            background: var(--white);
        }

        .roles-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
        }

        .role-card {
            background: var(--light);
            padding: 40px;
            border-radius: 20px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .role-card.super-admin {
            border-color: var(--primary);
            background: linear-gradient(135deg, rgba(78, 115, 223, 0.1), transparent);
        }

        .role-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow);
        }

        .role-header {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .role-icon {
            width: 60px;
            height: 60px;
            background: var(--primary);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 30px;
        }

        .role-card.super-admin .role-icon {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        }

        .role-card.school-admin .role-icon {
            background: linear-gradient(135deg, var(--secondary), #17a673);
        }

        .role-header h3 {
            font-size: 24px;
            font-weight: 600;
            color: var(--dark);
        }

        .role-description {
            color: var(--gray);
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .role-features {
            list-style: none;
        }

        .role-features li {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--dark);
        }

        .role-features i {
            color: var(--secondary);
            font-size: 16px;
        }

        .school-features {
            margin-top: 25px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 10px;
        }

        .school-features h4 {
            margin-bottom: 15px;
            color: var(--dark);
        }

        /* CTA Section */
        .cta {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            text-align: center;
            color: var(--white);
        }

        .cta h2 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .cta p {
            font-size: 18px;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
        }

        .cta-btn {
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .cta-btn-primary {
            background: var(--white);
            color: var(--primary);
        }

        .cta-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .cta-btn-outline {
            border: 2px solid var(--white);
            color: var(--white);
        }

        .cta-btn-outline:hover {
            background: var(--white);
            color: var(--primary);
            transform: translateY(-3px);
        }

        /* Footer */
        .footer {
            background: var(--dark);
            color: var(--white);
            padding: 60px 0 20px;
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 50px;
        }

        .footer-about p {
            margin: 20px 0;
            opacity: 0.8;
            line-height: 1.6;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .footer-links h3 {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            max-width: 1400px;
            margin: 40px auto 0;
            padding: 20px 30px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {

            .hero-container,
            .tenant-container {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-buttons {
                justify-content: center;
            }

            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .features-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .roles-container {
                grid-template-columns: 1fr;
            }

            .footer-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }

            .nav-menu {
                position: fixed;
                top: 80px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 80px);
                background: var(--white);
                flex-direction: column;
                padding: 40px;
                transition: 0.3s;
                box-shadow: var(--shadow);
            }

            .nav-menu.active {
                left: 0;
            }

            .hero-content h1 {
                font-size: 36px;
            }

            .stats-container,
            .features-container {
                grid-template-columns: 1fr;
            }

            .footer-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <a href="/" class="logo">
                <i class="fas fa-graduation-cap"></i>
                <span>EduManage ERP</span>
            </a>

            <div class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
            </div>

            <ul class="nav-menu" id="navMenu">
                <li><a href="#home">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#solutions">Solutions</a></li>
                <li><a href="#pricing">Pricing</a></li>
                <li><a href="#contact">Contact</a></li>
                <li>
                    <a href="/login" class="login-btn">
                        <i class="fas fa-lock"></i>
                        Login to Dashboard
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-container">
            <div class="hero-content" data-aos="fade-right">
                <h1>Complete School Management Solution</h1>
                <p>Streamline your school operations with our comprehensive ERP system. Manage multiple schools, admins,
                    teachers, students, and parents from a single platform.</p>
                <div class="hero-buttons">
                    <a href="#demo" class="btn-primary">
                        <i class="fas fa-play"></i>
                        Watch Demo
                    </a>
                    <a href="/register" class="btn-outline">
                        <i class="fas fa-rocket"></i>
                        Get Started
                    </a>
                </div>
            </div>
            <div class="hero-image" data-aos="fade-left">
                <img src="https://via.placeholder.com/600x400/4e73df/ffffff?text=School+ERP+Dashboard"
                    alt="School ERP Dashboard">
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stats-container">
            <div class="stat-item" data-aos="fade-up">
                <div class="stat-icon">
                    <i class="fas fa-school"></i>
                </div>
                <div class="stat-number">500+</div>
                <div class="stat-label">Schools</div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">50K+</div>
                <div class="stat-label">Students</div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-number">5K+</div>
                <div class="stat-label">Teachers</div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="stat-number">25+</div>
                <div class="stat-label">Countries</div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="section-header" data-aos="fade-up">
            <h2>Powerful Features for Modern Schools</h2>
            <p>Everything you need to manage your educational institution efficiently</p>
        </div>

        <div class="features-container">
            <div class="feature-card" data-aos="fade-up">
                <div class="feature-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h3>Student Management</h3>
                <p>Complete student lifecycle management from admission to alumni tracking</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h3>Teacher Portal</h3>
                <p>Dedicated dashboard for teachers to manage classes, grades, and attendance</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3>Class & Timetable</h3>
                <p>Smart scheduling and timetable management for all classes</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3>Academic Management</h3>
                <p>Curriculum planning, assignments, and examination management</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Performance Analytics</h3>
                <p>Real-time insights and reports on student and school performance</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <h3>Fee Management</h3>
                <p>Automated fee collection, tracking, and financial reporting</p>
            </div>
        </div>
    </section>

    <!-- Multi-Tenancy Section -->
    <section class="multi-tenant" id="solutions">
        <div class="tenant-container">
            <div class="tenant-content" data-aos="fade-right">
                <h2>Multi-Tenant Architecture</h2>
                <p>Manage multiple schools from a single super admin dashboard with complete isolation and security</p>
                <ul class="tenant-features">
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Centralized super admin control panel</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Independent school admin dashboards</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Data isolation between schools</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Custom branding per school</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle"></i>
                        <span>Scalable architecture for unlimited schools</span>
                    </li>
                </ul>
            </div>
            <div class="tenant-image" data-aos="fade-left">
                <img src="https://via.placeholder.com/600x400/ffffff/4e73df?text=Multi-Tenant+Architecture"
                    alt="Multi-Tenant Architecture">
            </div>
        </div>
    </section>

    <!-- Admin Roles Section -->
    <section class="roles">
        <div class="section-header" data-aos="fade-up">
            <h2>Two-Tier Admin System</h2>
            <p>Hierarchical admin structure for efficient management</p>
        </div>

        <div class="roles-container">
            <!-- Super Admin Card -->
            <div class="role-card super-admin" data-aos="fade-right">
                <div class="role-header">
                    <div class="role-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <h3>Super Admin</h3>
                </div>
                <p class="role-description">Global system administrator with complete control over all schools and
                    settings</p>
                <ul class="role-features">
                    <li><i class="fas fa-check"></i> Create and manage school admins</li>
                    <li><i class="fas fa-check"></i> Global system configuration</li>
                    <li><i class="fas fa-check"></i> Monitor all schools' performance</li>
                    <li><i class="fas fa-check"></i> Billing and subscription management</li>
                    <li><i class="fas fa-check"></i> System-wide analytics and reports</li>
                </ul>
            </div>

            <!-- School Admin Card -->
            <div class="role-card school-admin" data-aos="fade-left">
                <div class="role-header">
                    <div class="role-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3>School Admin</h3>
                </div>
                <p class="role-description">Dedicated administrator for individual schools with complete operational
                    control</p>
                <ul class="role-features">
                    <li><i class="fas fa-check"></i> Manage teachers and staff</li>
                    <li><i class="fas fa-check"></i> Student admissions and records</li>
                    <li><i class="fas fa-check"></i> Class and timetable management</li>
                    <li><i class="fas fa-check"></i> Exam and grade management</li>
                    <li><i class="fas fa-check"></i> Fee collection and accounting</li>
                </ul>
                <div class="school-features">
                    <h4>Each School Admin Gets:</h4>
                    <ul class="role-features">
                        <li><i class="fas fa-check"></i> Custom school branding</li>
                        <li><i class="fas fa-check"></i> Independent database/schema</li>
                        <li><i class="fas fa-check"></i> Separate admin dashboard</li>
                        <li><i class="fas fa-check"></i> School-specific reports</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="features" style="background: var(--white);">
        <div class="section-header" data-aos="fade-up">
            <h2>How It Works</h2>
            <p>Simple 3-step process to get your school on board</p>
        </div>

        <div class="features-container">
            <div class="feature-card" data-aos="fade-up">
                <div class="feature-icon" style="background: linear-gradient(135deg, #f6c23e, #f4b619);">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h3>1. Super Admin Creates School</h3>
                <p>Super admin adds new school and creates school admin account with specific permissions</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon" style="background: linear-gradient(135deg, #1cc88a, #17a673);">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3>2. School Admin Receives Access</h3>
                <p>School admin gets login credentials and access to their dedicated dashboard</p>
            </div>

            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon" style="background: linear-gradient(135deg, #e74a3b, #c9210f);">
                    <i class="fas fa-rocket"></i>
                </div>
                <h3>3. Start Managing School</h3>
                <p>School admin configures their school and starts adding teachers, students, and classes</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="section-header" style="color: white;">
            <h2>Ready to Transform Your School Management?</h2>
            <p>Join 500+ schools already using our ERP system</p>
        </div>
        <div class="cta-buttons">
            <a href="/register" class="cta-btn cta-btn-primary">
                <i class="fas fa-rocket"></i>
                Get Started Now
            </a>
            <a href="/contact" class="cta-btn cta-btn-outline">
                <i class="fas fa-headset"></i>
                Contact Sales
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-about">
                <a href="/" class="logo" style="color: white;">
                    <i class="fas fa-graduation-cap"></i>
                    <span>EduManage ERP</span>
                </a>
                <p>Comprehensive school management solution for modern educational institutions. Empowering schools with
                    technology.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div class="footer-links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#solutions">Solutions</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h3>For Schools</h3>
                <ul>
                    <li><a href="#">School Admin Login</a></li>
                    <li><a href="#">Teacher Portal</a></li>
                    <li><a href="#">Parent App</a></li>
                    <li><a href="#">Student Portal</a></li>
                    <li><a href="#">Support Center</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h3>Contact Info</h3>
                <ul>
                    <li><i class="fas fa-phone"></i> +1 234 567 890</li>
                    <li><i class="fas fa-envelope"></i> info@edumanage.com</li>
                    <li><i class="fas fa-map-marker-alt"></i> 123 Education St, NY</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2024 EduManage ERP. All rights reserved. | <a href="#">Privacy Policy</a> | <a
                    href="#">Terms of Service</a></p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const navMenu = document.getElementById('navMenu');

        mobileMenuBtn.addEventListener('click', function() {
            navMenu.classList.toggle('active');
            mobileMenuBtn.querySelector('i').classList.toggle('fa-bars');
            mobileMenuBtn.querySelector('i').classList.toggle('fa-times');
        });

        // Close mobile menu when clicking a link
        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                mobileMenuBtn.querySelector('i').classList.add('fa-bars');
                mobileMenuBtn.querySelector('i').classList.remove('fa-times');
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>
