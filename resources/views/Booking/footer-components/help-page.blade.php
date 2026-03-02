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
        <h1 class="text-4xl font-extrabold mb-8 text-center text-dark-bg">Oplanla.com Help Centre</h1>
        <p class="text-lg text-center mb-12 max-w-3xl mx-auto text-gray-700">
            Welcome to the Oplanla.com Help Centre. Here you'll find answers to common questions and resources to assist you with your booking or listing needs.
        </p>

        <div class="max-w-4xl mx-auto mb-12">
            <div class="relative">
                <input type="text" placeholder="Search for a topic..." class="w-full p-4 pl-12 rounded-lg border-2 border-gray-300 focus:outline-none focus:border-primary-p shadow-sm">
                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>

        <div class="max-w-4xl mx-auto space-y-4">
            <!-- Guest Support Section -->
            <div class="bg-white rounded-xl shadow-lg p-6" id="guest">
                <h2 class="text-3xl font-bold mb-6 text-dark-bg">Guest Support</h2>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">How do I search for a room? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        You can search for a room directly from our homepage. Simply enter your desired city, suburb, or even a specific web reference into the search bar. You can then use filters to refine your results by property type, price range, and number of guests.
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">How can I modify or cancel my booking? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        To modify or cancel your booking, please log in to your Oplanla.com account and navigate to your "Dashboard". Under "Upcoming Bookings," you will find options to manage your reservation. Please note that modification and cancellation policies are set by individual property owners and may vary.
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">What payment methods are accepted? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        We accept major credit cards including Visa, MasterCard, and American Express. Our payment gateway is secure and encrypted to protect your financial information.
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">I haven't received my booking confirmation. <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        Please check your spam or junk mail folder. If you still cannot find it, log in to your dashboard to view your booking details or contact our support team with your booking reference number.
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">What if I have an issue during my stay? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        For immediate concerns during your stay, we recommend contacting the property owner directly using the contact information provided in your booking confirmation. If the issue persists or you need further assistance, please contact Oplanla.com support.
                    </div>
                </div>
            </div>

            <!-- Partner Support Section -->
            <div class="bg-white rounded-xl shadow-lg p-6" id="partner">
                <h2 class="text-3xl font-bold mb-6 text-dark-bg">Partner Support</h2>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">How do I list my property? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        To list your property, navigate to the "List Your Property" page from the footer or header. You'll need to create a partner account, provide details about your accommodation, upload high-quality photos, and set your availability and rates. Our team will review your listing before it goes live.
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">How do I manage my property's availability? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        You can manage your property's availability and pricing through your dedicated Partner Hub dashboard. This allows you to block out dates, adjust rates, and view your booking calendar.
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">How are payments processed for hosts? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        Oplanla.com handles secure payment processing from guests. Payouts to hosts are typically processed [e.g., within 24-48 hours after guest check-in / on a weekly basis] via your preferred payout method, which you can set up in your Partner Hub.
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">What are the fees for listing a property? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        Oplanla.com charges a competitive commission rate on confirmed bookings. There are no upfront fees for listing your property. Detailed fee structures are available in your Partner Hub.
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">How can I respond to guest reviews? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        You can respond to guest reviews directly from your Partner Hub. We encourage hosts to respond to all reviews, positive or negative, as it shows your commitment to guest satisfaction.
                    </div>
                </div>
            </div>

            <!-- Account & Technical Issues Section -->
            <div class="bg-white rounded-xl shadow-lg p-6" id="account">
                <h2 class="text-3xl font-bold mb-6 text-dark-bg">Account & Technical Issues</h2>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">How do I reset my password? <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        On the login page, click on "Forgot Password?" and follow the instructions to reset your password via your registered email address.
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">I'm having trouble logging in. <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        Ensure you are using the correct email and password. Check for any typos. If issues persist, try resetting your password. If you still can't log in, please contact support.
                    </div>
                </div>
                <div class="accordion-item">
                    <div class="accordion-header text-dark-bg">My account has been suspended. <span class="arrow">&#9658;</span></div>
                    <div class="accordion-content text-gray-700">
                        Account suspensions typically occur due to violations of our Terms & Conditions. Please contact our support team immediately to understand the reason for suspension and discuss potential reinstatement.
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-16 bg-white p-8 rounded-xl shadow-lg" >
            <h2 class="text-3xl font-bold mb-6 text-dark-bg">Still Need Help?</h2>
            <p class="text-lg text-gray-700 mb-8">
                If you can't find the answer you're looking for, please don't hesitate to contact us.
            </p>
            <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="mailto:support@oplanla.com" class="bg-primary-p text-white font-semibold py-3 px-6 rounded-lg hover:bg-primary-p-darker transition duration-300 flex items-center justify-center min-w-[200px]">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    Email Us
                </a>
                <a href="tel:+27748923715" class="bg-gray-300 text-dark-bg font-semibold py-3 px-6 rounded-lg hover:bg-gray-400 transition duration-300 flex items-center justify-center min-w-[200px]">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1C10.03 21 3 13.97 3 5c0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1v3.5c0 .35-.09.7-.24 1.02l-2.2 2.2z"/></svg>
                    Call Us
                </a>
                <a href="{{route('contact.create')}}" class="bg-complimentary text-white font-semibold py-3 px-6 rounded-lg hover:bg-green-600 transition duration-300 flex items-center justify-center min-w-[200px]">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm8 4H6v-2h8v2zm4-8H6V5h12v2z"/></svg>
                    Chat with us now
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