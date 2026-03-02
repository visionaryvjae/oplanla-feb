@extends('layouts.app')

@section('title', 'privacy policy - OPLANLA')

@section('content')

<style>
    .main-pp-container{
        width:70%;
        padding:0 1rem;
        margin-bottom:1.5rem;
    }

    @media (max-width: 768px) {
        .main-pp-container{
            width:85%;
            padding:0 0.5rem;
            margin-bottom:1.5rem;
        }

    }

    @media (max-width: 480px) {
        .main-pp-container{
            width:100%;
            padding:0 0.5rem;
            margin-bottom:1.5rem;
        }
    }
</style>


<div class="main-pp-container mx-auto px-4 mb-6 md:px-8">
    <div class="bg-white shadow-xl rounded-lg overflow-hidden px-4">
        <div class="px-6 py-8 sm:p-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">PRIVACY POLICY</h1>
            
            <div class="text-sm text-gray-500 mb-6">
                <p><strong>Effective Date:</strong> 12 September 2025</p>
                <p><strong>Last Updated:</strong> 10 october 2025</p>
                <p><strong>Platform:</strong> {{ config('app.name', 'Your Booking Application Name') }}</p>
                <p><strong>Registered in:</strong> South Africa</p>
            </div>

            <div class="prose prose-lg text-gray-700">
                <p>This Privacy Policy explains how <strong>{{ config('app.name', 'Your Booking Application Name') }}</strong> ("we", "us", or "our") collects, uses, stores, and protects your personal information when you use our website and mobile application (collectively, the "Platform").</p>
                
                <p>We are committed to protecting your privacy and ensuring compliance with the <strong>Protection of Personal Information Act, 2013 (POPIA)</strong> and other applicable South African data protection laws.</p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">1. Information We Collect</h2>
                
                <h3 class="text-xl font-medium mt-6 mb-3">1.1 From Customers (Guests)</h3>
                <p>When you create an account or make a booking, we collect only the following personal information:</p>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li><strong>Full name</strong></li>
                    <li><strong>Email address</strong></li>
                </ul>
                <p>We do <strong>not</strong> collect or store:</p>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li>Government-issued identification numbers</li>
                    <li>Physical addresses (unless required for specific bookings, with consent)</li>
                    <li>Payment card details (payments are processed securely via third-party gateways such as PayGate, Peach Payments, or Stripe; we never see or store your full card information)</li>
                </ul>

                <h3 class="text-xl font-medium mt-6 mb-3">1.2 From Accommodation Providers</h3>
                <p>For property listings, we collect and display:</p>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li><strong>Business or property name</strong></li>
                    <li><strong>Description of the accommodation</strong> (provided by the provider or written by us)</li>
                    <li><strong>Photographs</strong> — taken <strong>exclusively by our team</strong> during on-site visits. Providers do <strong>not</strong> submit photos, and we do not use third-party or copyrighted images without proper licensing.</li>
                </ul>
                <p>We do <strong>not</strong> collect personal contact details of property owners unless voluntarily provided for operational coordination (e.g., phone number for booking confirmation), and only with explicit consent.</p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">2. Purpose of Processing Personal Information</h2>
                <p>We process your personal information <strong>only for legitimate business purposes</strong>, including:</p>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li>Creating and managing your user account</li>
                    <li>Confirming and managing bookings</li>
                    <li>Communicating booking updates, changes, or cancellations</li>
                    <li>Improving our services and user experience</li>
                    <li>Complying with legal and regulatory obligations</li>
                </ul>
                <p>We <strong>do not</strong> sell, rent, or share your personal information with third parties for marketing purposes.</p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">3. Legal Basis for Processing (POPIA Compliance)</h2>
                <p>Under POPIA, we process your information based on:</p>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li><strong>Consent</strong>: You provide your name and email to use our service.</li>
                    <li><strong>Contractual necessity</strong>: To fulfill your booking request.</li>
                    <li><strong>Legal compliance</strong>: To meet tax, consumer protection, or regulatory requirements.</li>
                </ul>
                <p>You may withdraw consent at any time by deleting your account (see Section 7).</p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">4. Data Sharing & Third Parties</h2>
                <p>We <strong>do not share your personal data</strong> with accommodation providers beyond what is necessary to fulfill your booking (e.g., your name and booking dates may be shared with the property for check-in purposes).</p>
                <p>We use trusted third-party service providers for:</p>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li><strong>Payment processing</strong> (e.g., PayGate, Peach Payments) — they process payments but do not use your data for their own purposes.</li>
                    <li><strong>Cloud hosting and infrastructure</strong> (e.g., AWS, Google Cloud) — data is stored in secure, POPIA-compliant environments.</li>
                    <li><strong>Email delivery</strong> (e.g., SendGrid, Mailgun) — used only to send booking confirmations and updates.</li>
                </ul>
                <p>All third parties are bound by data processing agreements that ensure POPIA-level protection.</p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">5. Data Security</h2>
                <p>We implement appropriate technical and organizational measures to protect your personal information, including:</p>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li>Encryption of data in transit (SSL/TLS)</li>
                    <li>Secure authentication protocols</li>
                    <li>Regular security reviews</li>
                    <li>Limited internal access to personal data (on a need-to-know basis)</li>
                </ul>
                <p>While no system is 100% immune to risk, we take reasonable steps to prevent unauthorized access, loss, or misuse.</p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">6. Data Retention</h2>
                <p>We retain your personal information only as long as necessary:</p>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li><strong>Active users</strong>: While your account is active</li>
                    <li><strong>After account deletion</strong>: We anonymize or delete your data within <strong>30 days</strong></li>
                    <li><strong>Booking records</strong>: Retained for <strong>24 months</strong> to comply with the Consumer Protection Act and financial record-keeping requirements</li>
                </ul>
                <p>Photographs and property details remain on the Platform as long as the accommodation is listed, but can be removed upon provider request.</p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">7. Your Rights Under POPIA</h2>
                <p>As a data subject, you have the right to:</p>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li><strong>Access</strong> the personal information we hold about you</li>
                    <li><strong>Correct</strong> inaccurate or incomplete information</li>
                    <li><strong>Request deletion</strong> of your account and data (subject to legal retention obligations)</li>
                    <li><strong>Object</strong> to processing in certain circumstances</li>
                    <li><strong>Lodge a complaint</strong> with the Information Regulator of South Africa</li>
                </ul>
                <p>To exercise these rights, contact us at: <strong class="text-blue-500"><a href="mailto:support@oplanla.com" target="_blank">support@oplanla.com</a></strong></p>
                <p>We will respond to all verified requests within <strong>30 days</strong>.</p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">8. International Data Transfers</h2>
                <p>Your data is primarily stored and processed within <strong>South Africa</strong>. If we ever transfer data outside South Africa (e.g., to a cloud provider with global servers), we will ensure adequate safeguards are in place in accordance with POPIA Section 72.</p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">9. Changes to This Policy</h2>
                <p>We may update this Privacy Policy from time to time. The updated version will be posted on our Platform with a revised "Effective Date." Continued use of the Platform constitutes acceptance of the changes.</p>

                <h2 class="text-2xl font-semibold mt-8 mb-4">10. Contact Us</h2>
                <p>If you have questions, concerns, or requests regarding this Privacy Policy or your personal information, please contact our Information Officer:</p>
                <div class="bg-gray-50 p-4 rounded-lg mt-4">
                    <p>Email: <strong class="text-blue-500"><a href="mailto:support@oplanla.com" target="_blank">support@oplanla.com</a></strong></p>
                    <p>Phone: <strong>+27 61 501 3726</strong></p>
                    <p>Address: <strong>51 Harrison Street, Johannesburg, 2001, South Africa</strong></p>
                </div>
                <p>You may also lodge a complaint directly with the <strong>Information Regulator of South Africa</strong>:</p>
                <ul class="list-disc pl-6 space-y-1 mt-2">
                    <li><a href="https://www.justice.gov.za/inforeg/" target="_blank" class="text-blue-500">www.justice.gov.za/inforeg/</a></li>
                    <li><a href="complaints.IR@justice.gov.za" target="_blank" class="text-blue-500">complaints.IR@justice.gov.za</a></li>
                </ul>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p><strong>By using {{ config('app.name', 'Your Booking Application Name') }}, you acknowledge that you have read and understood this Privacy Policy and consent to the collection and processing of your personal information as described herein.</strong></p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection