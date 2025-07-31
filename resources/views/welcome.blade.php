<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to SHSMedical - MedQuote Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'medical-blue': '#3B82F6',
                        'medical-light': '#EFF6FF',
                        'medical-dark': '#1E40AF',
                        'medical-accent': '#60A5FA',
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delayed': 'float 6s ease-in-out infinite 2s',
                        'fade-in': 'fadeIn 1s ease-in-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.15);
        }

        .logo-float {
            animation: float 8s ease-in-out infinite;
        }

        .logo-float:nth-child(2) { animation-delay: 1s; }
        .logo-float:nth-child(3) { animation-delay: 2s; }
        .logo-float:nth-child(4) { animation-delay: 3s; }
        .logo-float:nth-child(5) { animation-delay: 4s; }

        .fade-in-scroll {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }

        .fade-in-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen overflow-x-hidden">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200 fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-medical-blue rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h1 class="text-xl font-bold text-medical-dark">MedQuote</h1>
                    </div>
                </div>
                <div class="flex space-x-4">
                    <a href="/login" class="text-gray-600 hover:text-medical-blue transition-colors duration-200 px-4 py-2">Login</a>
                    <a href="/register" class="bg-medical-blue text-white px-6 py-2 rounded-lg hover:bg-medical-dark transition-all duration-200 transform hover:scale-105">Register</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-medical-light via-white to-blue-50 pt-24 pb-20 lg:pt-32 lg:pb-32 relative overflow-hidden">
        <!-- Floating Background Elements -->
        <!-- Colorful Floating Background Elements -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full animate-float shadow-lg shadow-blue-400/30 blur-sm"></div>
        <div class="absolute top-40 right-20 w-16 h-16 bg-gradient-to-tr from-medical-blue to-cyan-400 rounded-full animate-float-delayed shadow-lg shadow-cyan-400/30 blur-sm"></div>
        <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-gradient-to-r from-medical-accent to-blue-300 rounded-full animate-float shadow-lg shadow-blue-300/30 blur-sm"></div>

        <div class="absolute top-60 right-1/3 w-10 h-10 bg-gradient-to-bl from-indigo-400 to-medical-blue rounded-full animate-float shadow-lg shadow-indigo-400/30 blur-sm"></div>
        <div class="absolute bottom-40 right-20 w-14 h-14 bg-gradient-to-tl from-sky-400 to-medical-accent rounded-full animate-float-delayed shadow-lg shadow-sky-400/30 blur-sm"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center animate-slide-up">
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-gray-900 mb-6 leading-tight">
                    Welcome to <span class="text-medical-blue">SHSMedical</span>
                </h1>
                <p class="text-xl md:text-2xl lg:text-3xl text-gray-600 mb-8 max-w-4xl mx-auto leading-relaxed">
                    Helping hospitals get fast, secure image quotes from professionals.
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center mt-12">
                    <a href="/register" class="group bg-medical-blue text-white px-10 py-4 rounded-xl text-lg font-semibold hover:bg-medical-dark transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <span class="flex items-center">
                            Get Started
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </span>
                    </a>
                    <a href="/login" class="bg-white text-medical-blue px-10 py-4 rounded-xl text-lg font-semibold border-2 border-medical-blue hover:bg-medical-light transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 fade-in-scroll">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
                    Why Choose MedQuote?
                </h2>
                <p class="text-lg md:text-xl text-gray-600 max-w-3xl mx-auto">
                    Our platform streamlines medical imaging consultation with cutting-edge technology and trusted professionals
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
                <!-- Feature 1 -->
                <div class="card-hover bg-gradient-to-br from-medical-light to-white rounded-2xl p-8 text-center border border-gray-100 fade-in-scroll">
                    <div class="bg-gradient-to-r from-medical-blue to-medical-accent rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-semibold text-gray-900 mb-4">
                        Upload medical images securely from any device
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        HIPAA-compliant platform supporting DICOM, JPEG, PNG formats with enterprise-grade security and encryption.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="card-hover bg-gradient-to-br from-medical-light to-white rounded-2xl p-8 text-center border border-gray-100 fade-in-scroll">
                    <div class="bg-gradient-to-r from-medical-blue to-medical-accent rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-semibold text-gray-900 mb-4">
                        Receive quotes from certified radiologists and professionals
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        Connect with board-certified specialists and get competitive quotes within hours from our network of trusted professionals.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="card-hover bg-gradient-to-br from-medical-light to-white rounded-2xl p-8 text-center border border-gray-100 fade-in-scroll">
                    <div class="bg-gradient-to-r from-medical-blue to-medical-accent rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl md:text-2xl font-semibold text-gray-900 mb-4">
                        Pay securely and track processing in real time
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        Secure payment processing with real-time status updates and detailed reporting delivered within 24-48 hours.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 fade-in-scroll">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Trusted by hospitals and clinics across the region
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Join over 500+ healthcare institutions that rely on our platform for their medical imaging needs
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-8 items-center opacity-60">
                <div class="logo-float bg-white p-6 rounded-lg shadow-sm flex items-center justify-center h-20">
                    <div class="text-gray-400 font-bold text-lg">Hospital A</div>
                </div>
                <div class="logo-float bg-white p-6 rounded-lg shadow-sm flex items-center justify-center h-20">
                    <div class="text-gray-400 font-bold text-lg">Clinic B</div>
                </div>
                <div class="logo-float bg-white p-6 rounded-lg shadow-sm flex items-center justify-center h-20">
                    <div class="text-gray-400 font-bold text-lg">Medical C</div>
                </div>
                <div class="logo-float bg-white p-6 rounded-lg shadow-sm flex items-center justify-center h-20">
                    <div class="text-gray-400 font-bold text-lg">Health D</div>
                </div>
                <div class="logo-float bg-white p-6 rounded-lg shadow-sm flex items-center justify-center h-20 col-span-2 md:col-span-1">
                    <div class="text-gray-400 font-bold text-lg">Center E</div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 fade-in-scroll">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    How It Works
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Get started with our simple 3-step process
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
                <!-- Step 1 -->
                <div class="text-center fade-in-scroll">
                    <div class="relative">
                        <div class="bg-medical-blue rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6 shadow-lg">
                            <span class="text-white font-bold text-xl">1</span>
                        </div>
                        <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-gray-200 -z-10"></div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Upload Images</h3>
                    <p class="text-gray-600">
                        Securely upload your medical images through our encrypted platform with support for all major formats.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center fade-in-scroll">
                    <div class="relative">
                        <div class="bg-medical-blue rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6 shadow-lg">
                            <span class="text-white font-bold text-xl">2</span>
                        </div>
                        <div class="hidden md:block absolute top-8 left-full w-full h-0.5 bg-gray-200 -z-10"></div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Get Quoted</h3>
                    <p class="text-gray-600">
                        Receive competitive quotes from certified radiologists and medical imaging professionals within hours.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center fade-in-scroll">
                    <div class="bg-medical-blue rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-white font-bold text-xl">3</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Secure Payment & Results</h3>
                    <p class="text-gray-600">
                        Make secure payments and receive detailed medical reports with professional analysis and recommendations.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="bg-gradient-to-r from-medical-blue to-medical-dark py-20">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8 fade-in-scroll">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6">
                Ready to transform your medical imaging workflow?
            </h2>
            <p class="text-xl text-blue-100 mb-8 leading-relaxed">
                Join thousands of healthcare professionals who trust MedQuote for their imaging consultation needs.
            </p>
            <a href="/register" class="inline-block bg-white text-medical-blue px-10 py-4 rounded-xl text-lg font-semibold hover:bg-gray-100 transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                Start Your Free Trial Today
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16 fade-in-scroll">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-medical-blue rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V8z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold">MedQuote</h3>
                    </div>
                    <p class="text-gray-300 mb-6 leading-relaxed">
                        Professional medical imaging consultation platform providing secure, fast, and reliable services to healthcare institutions worldwide.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="/about" class="text-gray-300 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="/services" class="text-gray-300 hover:text-white transition-colors">Services</a></li>
                        <li><a href="/pricing" class="text-gray-300 hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="/contact" class="text-gray-300 hover:text-white transition-colors">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Legal</h4>
                    <ul class="space-y-3">
                        <li><a href="/privacy" class="text-gray-300 hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="/terms" class="text-gray-300 hover:text-white transition-colors">Terms of Service</a></li>
                        <li><a href="/hipaa" class="text-gray-300 hover:text-white transition-colors">HIPAA Compliance</a></li>
                        <li><a href="/security" class="text-gray-300 hover:text-white transition-colors">Security</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                <p class="text-gray-300">
                    © 2025 Nana Tech. All rights reserved. |
                    <a href="/contact" class="text-medical-blue hover:text-medical-accent transition-colors">Contact Us</a> |
                    <a href="/privacy" class="text-medical-blue hover:text-medical-accent transition-colors">Privacy Policy</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for scroll animations -->
    <script>
        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe all elements with fade-in-scroll class
        document.querySelectorAll('.fade-in-scroll').forEach(el => {
            observer.observe(el);
        });

        // Smooth scrolling for anchor links
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
    </script>
</body>
</html>
