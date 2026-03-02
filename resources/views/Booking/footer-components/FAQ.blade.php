@extends('layouts.app')

@section('content')
    <style>
        /* Custom colors for Tailwind */
        :root {
            --color-primary-p: #ad68e4;
            --color-complimentary: #68e4ad;
            --color-dark-bg: #282c34; /* Dark background from footer image */
            --color-text-light: #e0e0e0; /* Light text for dark backgrounds */
            --color-text-dark: #333333; /* Dark text for light backgrounds */
        }
        .bg-primary-p { background-color: var(--color-primary-p); }
        .text-primary-p { color: var(--color-primary-p); }
        .hover\:bg-primary-p-darker:hover { background-color: #973fdf; /* Slightly darker primary-p */ }
        .bg-complimentary { background-color: var(--color-complimentary); }
        .text-complimentary { color: var(--color-complimentary); }
        .bg-dark-bg { background-color: var(--color-dark-bg); }
        .text-text-light { color: var(--color-text-light); }
        .text-text-dark { color: var(--color-text-dark); }

        /* Inter font */
        body {
            font-family: 'Inter', sans-serif;
            color: var(--color-text-dark);
        }
        /* Style for accordion */
        .accordion-header {
            cursor: pointer;
            padding: 1rem;
            background-color: #f3f4f6;
            border-bottom: 1px solid #e5e7eb;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .accordion-content {
            padding: 1rem;
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            display: none; /* Hidden by default */
        }
        .accordion-content.active {
            display: block;
        }
        .accordion-header .arrow {
            transition: transform 0.3s ease;
        }
        .accordion-header.active .arrow {
            transform: rotate(90deg);
        }
    </style>

    <main class="flex-grow container mx-auto px-4 py-8">
        <h1 class="text-4xl font-extrabold mb-8 text-center text-dark-bg">Frequently Asked Questions (FAQs)</h1>
        <p class="text-lg text-center mb-12 max-w-3xl mx-auto text-gray-700">
            Find quick answers to the most common questions about using Oplanla.com.
        </p>

        <div class="max-w-4xl mx-auto space-y-4">
            <!-- General Questions Section -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-3xl font-bold mb-6 text-dark-bg">General Questions</h2>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">What is Oplanla.com? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        Oplanla.com is a booking application designed to help users find and book rooms online, especially focusing on smaller and off-the-beaten-path accommodations. Our goal is to connect travelers with unique and authentic stays.
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">How do I create an account? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        You can create an account by clicking on the "Register" button located in the top right corner of our website. Follow the simple prompts to set up your profile.
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">Is Oplanla.com free to use? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        Yes, searching for and booking accommodations on Oplanla.com is free for guests. We charge a commission from property owners on confirmed bookings.
                    </div>
                </div>
            </div>

            <!-- Booking Questions Section -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-3xl font-bold mb-6 text-dark-bg">Booking Questions</h2>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">How do I search for a room? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        Use the search bar on the homepage to enter your desired city, suburb, or web reference. You can then filter your results by property type, price range, number of guests, and more to find your ideal stay.
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">Can I modify my booking dates? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        Modification of booking dates depends on the individual property's policy. You can attempt to modify your booking via your "Dashboard" after logging in, or contact the property directly for assistance.
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">What if I need to cancel my booking? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        Cancellation policies vary by property. Please refer to your booking confirmation email or the "Manage Your Booking" section in your dashboard for specific details regarding cancellation and refund eligibility.
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">How can I contact the property owner after booking? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        The contact details for the property owner will be provided in your booking confirmation email once your reservation is confirmed.
                    </div>
                </div>
            </div>

            <!-- Payment Questions Section -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-3xl font-bold mb-6 text-dark-bg">Payment Questions</h2>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">What payment methods do you accept? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        We accept major credit cards (Visa, MasterCard, American Express) and other secure online payment methods. All payments are processed through a trusted and encrypted gateway.
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">Is my payment secure? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        Absolutely. We prioritize the security of your financial information. All transactions are processed using industry-standard encryption and secure protocols.
                    </div>
                </div>
            </div>

            <!-- Property Questions (for guests) Section -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-3xl font-bold mb-6 text-dark-bg">Property Questions (for guests)</h2>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">What if the property isn't as described? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        If you encounter a significant discrepancy between the property description and its actual state, please contact Oplanla.com support immediately with details and any supporting evidence (e.g., photos). We will investigate the issue promptly.
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">Are pets allowed? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        Pet policies vary by property. Please check the individual property listing details for information regarding pet allowances, or contact the property owner directly before booking.
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-16 bg-white p-8 rounded-xl shadow-lg">
            <h2 class="text-3xl font-bold mb-6 text-dark-bg">Didn't find your answer?</h2>
            <p class="text-lg text-gray-700 mb-8">
                Visit our full Help Centre for more in-depth articles or contact our support team directly.
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="{{ route('footer.help') }}" class="bg-primary-p text-white font-semibold py-3 px-6 rounded-lg hover:bg-primary-p-darker transition duration-300 flex items-center justify-center min-w-[200px]">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17.93c-3.95-.49-7-3.85-7-7.93h7v7.93zm1-15.93c3.95.49 7 3.85 7 7.93h-7V4.07z"/></svg>
                    Go to Help Centre
                </a>
                <a href="mailto:support@oplanla.com" class="bg-complimentary text-white font-semibold py-3 px-6 rounded-lg hover:bg-green-600 transition duration-300 flex items-center justify-center min-w-[200px]">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    Contact Support
                </a>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const accordionHeaders = document.querySelectorAll('.accordion-header');
    
                accordionHeaders.forEach(header => {
                    header.addEventListener('click', function() {
                        const content = this.nextElementSibling;
                        const arrow = this.querySelector('.arrow');
    
                        // Toggle active class on header
                        this.classList.toggle('active');
                        // Toggle active class on content
                        content.classList.toggle('active');
    
                        // Toggle arrow rotation
                        if (this.classList.contains('active')) {
                            arrow.style.transform = 'rotate(90deg)';
                            content.style.display = 'block';
                        } else {
                            arrow.style.transform = 'rotate(0deg)';
                            content.style.display = 'none';
                        }
                    });
                });
            });
    </script>
    </main>

@endsection