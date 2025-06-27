<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employee Purchase System - Laravel & Filament</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #1a1a1a;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #667eea;
            text-decoration: none;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }
        
        .nav-links a {
            text-decoration: none;
            color: #4a5568;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .nav-links a:hover {
            color: #667eea;
        }
        
        .cta-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }
        
        /* Hero Section */
        .hero {
            padding: 120px 0 80px;
            text-align: center;
            color: white;
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
            animation: float 20s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        
        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-primary {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }
        
        .btn-primary:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid white;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }
        
        .btn-secondary:hover {
            background: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        /* Features Section */
        .features {
            padding: 80px 0;
            background: white;
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 3rem;
            color: #2d3748;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .feature-card {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            padding: 2rem;
            border-radius: 20px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(102, 126, 234, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover::before {
            transform: scaleX(1);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }
        
        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #2d3748;
        }
        
        .feature-card p {
            color: #4a5568;
            line-height: 1.6;
        }
        
        /* Tech Stack */
        .tech-stack {
            padding: 80px 0;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        }
        
        .tech-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }
        
        .tech-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .tech-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        
        .tech-logo {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .tech-card h4 {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }
        
        .tech-card p {
            color: #4a5568;
            font-size: 0.9rem;
        }
        
        /* Developer Section */
        .developer {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 80px 0;
            text-align: center;
            color: white;
        }
        
        .developer-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 3rem;
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .developer-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            border: 4px solid rgba(255, 255, 255, 0.3);
        }
        
        .developer h3 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .developer p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        /* CTA Section */
        .cta-section {
            padding: 80px 0;
            background: white;
            text-align: center;
        }
        
        .cta-content {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #2d3748;
        }
        
        .cta-section p {
            font-size: 1.25rem;
            color: #4a5568;
            margin-bottom: 2rem;
        }
        
        /* Footer */
        .footer {
            background: #2d3748;
            color: white;
            padding: 2rem 0;
            text-align: center;
        }
        
        .footer p {
            opacity: 0.8;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1.1rem;
            }
            
            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn-primary, .btn-secondary {
                width: 100%;
                max-width: 300px;
            }
            
            .nav-links {
                display: none;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .animate-delay-1 { animation-delay: 0.1s; }
        .animate-delay-2 { animation-delay: 0.2s; }
        .animate-delay-3 { animation-delay: 0.3s; }
        .animate-delay-4 { animation-delay: 0.4s; }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="nav">
                <a href="#" class="logo">🏢 Employee Purchase System</a>
                <ul class="nav-links">
                    <li><a href="#features">Features</a></li>
                    <li><a href="#tech">Technology</a></li>
                    <li><a href="#developer">Developer</a></li>
                </ul>admin@gmail.com
                <a href="https://nawasrah.site/employees-payment/admin/login" class="cta-button">Go to Dashboard</a>
            </nav>
        </div>
    </header>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="animate-fadeInUp">Employee Purchase System</h1>
            <p class="animate-fadeInUp animate-delay-1">
                A comprehensive Laravel & Filament solution for managing employee vending machine purchases 
                with real-time validation, daily balance management, and detailed reporting.
            </p>

            <!-- Credentials Display -->
            <div class="login-credentials animate-fadeInUp animate-delay-2 bg-gray-100 dark:bg-gray-800 text-sm p-4 rounded-lg shadow w-fit mx-auto mt-4">
                <strong>Demo Login Credentials:</strong><br>
                <span>Email:</span> <code class="text-blue-600">admin@gmail.com</code><br>
                <span>Password:</span> <code class="text-blue-600">password</code>
            </div>

            <!-- Buttons -->
            <div class="hero-buttons animate-fadeInUp animate-delay-3 mt-6">
                <a href="https://nawasrah.site/employees-payment/admin/login" class="btn-primary">Access Dashboard</a>
                <a href="#features" class="btn-secondary">Explore Features</a>
            </div>
        </div>
    </div>
</section>


    <!-- Features Section -->
    <section id="features" class="features">
        <div class="container">
            <h2 class="section-title">🚀 Key Features</h2>
            <div class="features-grid">
                <div class="feature-card animate-fadeInUp">
                    <div class="feature-icon">👥</div>
                    <h3>Employee Management</h3>
                    <p>Comprehensive employee management with classifications, daily limits, and card-based authentication system.</p>
                </div>
                
                <div class="feature-card animate-fadeInUp animate-delay-1">
                    <div class="feature-icon">🏪</div>
                    <h3>Vending Machine Control</h3>
                    <p>Complete vending machine and slot management with category mapping and real-time inventory tracking.</p>
                </div>
                
                <div class="feature-card animate-fadeInUp animate-delay-2">
                    <div class="feature-icon">💳</div>
                    <h3>Purchase API</h3>
                    <p>RESTful API for seamless vending machine integration with real-time validation and transaction processing.</p>
                </div>
                
                <div class="feature-card animate-fadeInUp animate-delay-3">
                    <div class="feature-icon">🔄</div>
                    <h3>Daily Balance Recharge</h3>
                    <p>Automated daily balance recharge system that runs at midnight to reset employee purchase limits.</p>
                </div>
                
                <div class="feature-card animate-fadeInUp animate-delay-4">
                    <div class="feature-icon">📊</div>
                    <h3>Transaction Logging</h3>
                    <p>Detailed transaction logging with comprehensive reporting, filtering, and real-time dashboard widgets.</p>
                </div>
                
                <div class="feature-card animate-fadeInUp animate-delay-1">
                    <div class="feature-icon">🎯</div>
                    <h3>Category-Based Limits</h3>
                    <p>Flexible purchase limits by category (juice/meal/snack) with role-based restrictions and validation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tech Stack Section -->
    <section id="tech" class="tech-stack">
        <div class="container">
            <h2 class="section-title">⚡ Built with Modern Technology</h2>
            <div class="tech-grid">
                <div class="tech-card animate-fadeInUp">
                    <div class="tech-logo">🔧</div>
                    <h4>Laravel 12</h4>
                    <p>Robust PHP framework with MVC architecture</p>
                </div>
                
                <div class="tech-card animate-fadeInUp animate-delay-1">
                    <div class="tech-logo">🎨</div>
                    <h4>Filament 3.0</h4>
                    <p>Modern admin panel with intuitive UI</p>
                </div>
                
                <div class="tech-card animate-fadeInUp animate-delay-2">
                    <div class="tech-logo">🌐</div>
                    <h4>RESTful API</h4>
                    <p>Seamless vending machine integration</p>
                </div>
                
                <div class="tech-card animate-fadeInUp animate-delay-3">
                    <div class="tech-logo">🗄️</div>
                    <h4>MySQL Database</h4>
                    <p>Reliable data storage with relationships</p>
                </div>
                
                <div class="tech-card animate-fadeInUp animate-delay-4">
                    <div class="tech-logo">⚙️</div>
                    <h4>Scheduled Tasks</h4>
                    <p>Automated daily balance recharge</p>
                </div>
                
                <div class="tech-card animate-fadeInUp animate-delay-1">
                    <div class="tech-logo">🔐</div>
                    <h4>Validation & Security</h4>
                    <p>Comprehensive error handling</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Developer Section -->
    <section id="developer" class="developer">
        <div class="container">
            <div class="developer-card animate-fadeInUp">
                <div class="developer-avatar">👨‍💻</div>
                <h3>Built by Dev Abdallah Khattab</h3>
                <p>
                    Crafted with expertise in Laravel and Filament, this system represents a complete 
                    solution for modern employee purchase management. Built following Laravel best 
                    practices with production-ready architecture.
                </p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content animate-fadeInUp">
                <h2>Ready to Get Started?</h2>
                <p>
                    Access the powerful Filament admin dashboard to manage employees, vending machines, 
                    and monitor all transactions in real-time.
                </p>
                <a href="https://nawasrah.site/employees-payment/admin/login" class="cta-button" style="font-size: 1.1rem; padding: 1rem 3rem;">
                    Launch Dashboard
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Employee Purchase System. Built with Laravel & Filament by Dev Abdallah Khattab.</p>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
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

        // Add scroll effect to header
        window.addEventListener('scroll', () => {
            const header = document.querySelector('.header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(255, 255, 255, 0.98)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all animation elements
        document.querySelectorAll('.animate-fadeInUp').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease-out';
            observer.observe(el);
        });
    </script>
</body>
</html>