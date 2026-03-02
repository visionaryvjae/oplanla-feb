{{-- /resources/views/terms/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Terms and Conditions - OPLANLA')

@section('content')

<style>

    .main-tc-container{
        width:70%;
    }

    @media (max-width: 768px) {
        .main-tc-container{
            width:85%;
        }

    }

    @media (max-width: 480px) {
        .main-tc-container{
            width:100%;
        }
    }
</style>

<div class="container mx-auto px-4 py-8">
    <div class="main-tc-container mx-auto bg-white p-6 md:p-10 rounded-lg shadow-md">

        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            OPLANLA Terms and Conditions
        </h1>
        <p class="text-sm text-gray-500 mb-6">
            <strong>Effective Date:</strong> 12 September 2025
        </p>

        <hr class="my-6">

        {{-- 1. Introduction --}}
        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-3">1. Introduction</h2>
            <p class="text-gray-600 leading-relaxed">
                Welcome to OPLANLA. By using our services to book accommodation, you agree to be bound by these Terms and Conditions, including our Refunds and Cancellation Policy. Please read them carefully before proceeding with any bookings. These terms are governed by the laws of the Republic of South Africa, and any disputes shall be subject to the exclusive jurisdiction of the courts of South Africa. 
            </p>
        </section>

        {{-- 2. Definitions --}}
        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-3">2. Definitions</h2>
            <div class="space-y-2 text-gray-600 leading-relaxed">
                <p><strong>“Customer”:</strong> Any person who uses the Platform to book accommodation. </p>
                <p><strong>“Accommodation Provider”:</strong> The owner, operator, or agent of the property listed on the Platform. </p>
                <p><strong>“Booking”:</strong> A confirmed reservation made via the Platform for accommodation. </p>
                <p><strong>“Cancellation Period”:</strong> The time frame within which a Customer may cancel a Booking without penalty or with partial refund, as defined below. </p>
                <p><strong>“Non-Refundable Rate”:</strong> A rate offered at a discounted price where no refunds are issued upon cancellation. </p>
            </div>
        </section>

        {{-- 3. Booking Confirmation & Payment --}}
        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-3">3. Booking Confirmation & Payment</h2>
            <p class="text-gray-600 leading-relaxed mb-2">
                All bookings are confirmed only upon successful payment and receipt of a confirmation email from the Platform. Payments are processed securely through approved third-party payment gateways. We do not store sensitive card information. Prices displayed include applicable taxes unless otherwise stated. Additional charges (e.g., cleaning fees, tourist levies) will be disclosed prior to final payment. 
            </p>
        </section>

        {{-- 4. Cancellation Policy --}}
        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-3">4. Cancellation Policy</h2>
            <div class="space-y-4">
                <div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">4.1 Standard Cancellation Policy</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Customers may cancel their booking up to 48 hours prior to the scheduled check-in date and receive a 75% refund of the total amount paid. The remaining 25% is retained by the Platform as a non-refundable administrative and processing fee. 
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">4.2 Late Cancellation / No-Show</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Cancellations made less than 48 hours before check-in, or failure to arrive (“no-show”), result in forfeiture of 100% of the booking amount. No refund will be issued. 
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">4.3 Non-Refundable Bookings</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Some properties or rates may be advertised as “Non-Refundable”. These bookings are strictly non-refundable under any circumstances, including illness, travel disruption, or personal emergencies. 
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">4.4 Force Majeure</h3>
                    <p class="text-gray-600 leading-relaxed">
                        In exceptional circumstances beyond reasonable control (e.g., natural disasters, government-mandated lockdowns, pandemics), we may offer flexible cancellation or rescheduling at our sole discretion. Proof of event may be required.
                    </p>
                </div>
            </div>
        </section>

        {{-- 5. Refund Process --}}
        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-3">5. Refund Process</h2>
            <p class="text-gray-600 leading-relaxed">
                Refunds (where applicable) will be processed within 7–14 business days back to the original payment method. They may be subject to bank processing times and currency conversion fees if applicable. The Platform reserves the right to withhold refunds if fraud, abuse, or violation of these terms is suspected. 
            </p>
        </section>

        {{-- 6. Amendments to Bookings --}}
        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-3">6. Amendments to Bookings</h2>
            <p class="text-gray-600 leading-relaxed">
                Changes to dates, rooms, or guests may be requested but are subject to availability and the Accommodation Provider’s policy. Any modification may incur additional charges or require rebooking, potentially triggering new cancellation policies. 
            </p>
        </section>

        {{-- 7. Consumer Rights Under South African Law --}}
        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-3">7. Consumer Rights Under South African Law</h2>
            <p class="text-gray-600 leading-relaxed mb-3">As per the Consumer Protection Act (CPA): </p>
            <ul class="list-disc list-inside text-gray-600 leading-relaxed space-y-2">
                <li>You have the right to clear, plain language terms. </li>
                <li>You have the right to cancel certain agreements within a cooling-off period — however, this does NOT apply to accommodation bookings once confirmed, as they are considered “services rendered” under Section 16 of the CPA. </li>
                <li>You may not be charged hidden fees — all charges must be disclosed upfront. </li>
                <li>You have the right to lodge complaints with the National Consumer Commission (NCC) if you believe your rights have been violated.</li>
            </ul>
        </section>

        {{-- 8. Limitation of Liability --}}
        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-3">8. Limitation of Liability</h2>
             <p class="text-gray-600 leading-relaxed">
                The Platform acts as an intermediary between Customers and Accommodation Providers. We are not responsible for the quality, safety, or condition of the accommodation. We are not liable for any indirect, consequential, or punitive damages arising from your use of the Platform or any booking. In no event shall our total liability exceed the total amount paid for the specific booking in question.
             </p>
        </section>

        {{-- 9. Dispute Resolution --}}
        <section class="mb-6">
             <h2 class="text-2xl font-semibold text-gray-700 mb-3">9. Dispute Resolution</h2>
             <p class="text-gray-600 leading-relaxed">
                Any dispute arising from these terms shall first be submitted in writing to our customer support team. If unresolved within 30 days, you may refer the matter to the National Consumer Commission (NCC) or the Ombud for Financial Services Providers (Ombudsman), depending on the nature of the complaint. Alternatively, parties may agree to mediation or arbitration in accordance with the rules of the Arbitration Foundation of Southern Africa (AFSA).
             </p>
        </section>

        {{-- 10. Privacy & Data Protection --}}
        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-3">10. Privacy & Data Protection</h2>
            <p class="text-gray-600 leading-relaxed">
                We comply with the Protection of Personal Information Act (POPIA). Your personal data is collected solely for booking purposes and will not be sold or shared with third parties without consent, except as required by law or to fulfill your booking. For full details, please refer to our Privacy Policy.
            </p>
        </section>

        {{-- 11. General Provisions --}}
        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-3">11. General Provisions</h2>
            <p class="text-gray-600 leading-relaxed">
                These terms may be updated from time to time. Continued use of the Platform constitutes acceptance of revised terms. If any provision is found unenforceable, the remainder of the agreement remains valid. You may not assign or transfer your rights under these terms without our written consent.
            </p>
        </section>

        {{-- 12. Contact Us --}}
        <section class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-3">12. Contact Us</h2>
            <p class="text-gray-600 leading-relaxed">For questions, complaints, or assistance: </p>
            <ul class="list-none text-gray-600 leading-relaxed mt-2">
                <li><strong>Email:</strong> <a href="mailto:support@oplanla.com" target="_blank" class="text-blue-600 hover:underline">support@oplanla.com</a> </li>
                <li><strong>Phone:</strong> +27 61 501 3726 </li>
                <li><strong>Address:</strong> 51 Harrison Street, Johannesburg, 2001, South Africa</li>
            </ul>
        </section>

        <hr class="my-6">

        <div class="mt-8 bg-gray-100 p-4 rounded-lg">
            <p class="text-center text-gray-700 font-semibold">
                By completing a booking on OPLANLA, you acknowledge that you have read, understood, and agreed to these Terms and Conditions, including the Refunds and Cancellation Policy.
            </p>
        </div>

    </div>
</div>
@endsection