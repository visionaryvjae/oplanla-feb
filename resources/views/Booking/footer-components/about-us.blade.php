@extends('layouts.app')

@section('content')
    <style>
    
        /* --- General & Variables --- */
        :root {
            --primary-color: #6a11cb; /* Your signature purple */
            --secondary-color: #2575fc; /* A vibrant blue for gradients */
            --accent-color: #ffc107; /* A warm gold for highlights */
            --dark-color: #333;
            --light-color: #f9f9f9;
            --white-color: #ffffff;
            --text-color: #555;
        }
        
        body{
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            background-color: var(--white-color);
        }

        .container {
            width: 100%
            padding: 2rem 1.5rem;
        }

        h1, h2, h3 {
            color: var(--dark-color);
            font-weight: 600;
        }

        p{
            line-height: 1.7;
        }

        /* --- Hero Section --- */
        .hero {
            position: relative;
            height: 70vh;
            width:100%;
            display: flex;
            flex-direction:column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--white-color);
            padding: 0 1rem;
            /* --- TODO: Replace with your own high-quality background image --- */
            background: url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?q=80&w=2070') no-repeat center center/cover;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(106, 17, 203, 0.8), rgba(37, 117, 252, 0.8));
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            color: var(--white-color);
            margin-bottom: 0.5rem;
        }

        .hero p {
            font-size: 1.2rem;
            font-weight: 400;
        }

        /* --- Content Sections --- */
        .content-section {
            padding: 4rem 0;
            border-bottom: 1px solid #eee;
        }
        
        .content-section:last-of-type {
            border-bottom: none;
        }

        .content-section h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        
        .section-intro {
            text-align: center;
            width: 100%;
            margin: 0 auto 3rem auto;
            font-size: 1.1rem;
        }
        
        /* --- Mission & Vision Grid --- */
        .mission-vision-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            margin-top: 3rem;
        }
        
        .mission-vision-grid h3 {
            color: var(--primary-color);
            font-size: 1.5rem;
            border-left: 4px solid var(--accent-color);
            padding-left: 1rem;
            margin-bottom: 1rem;
        }

        /* --- Solution Section --- */
        .solution-grid {
             display: grid;
             grid-template-columns: 1fr 1fr;
             gap: 2rem;
             margin-top: 3rem;
        }

        .solution-card {
            background-color: var(--light-color);
            padding: 2rem;
            border-radius: 8px;
        }

        .solution-card h3 {
            margin-top: 0;
        }
        
        .solution-card ul {
            padding-left: 0;
            list-style: none;
        }

        .solution-card li {
            padding: 0.5rem 0;
            font-weight: 600;
        }
        
        .solution-card li span {
            font-weight: 400;
        }

        /* --- Highlight Section --- */
        .highlight-section {
            background-color: var(--dark-color);
            color: var(--white-color);
            text-align: center;
            border-radius: 8px;
            padding: 3rem;
        }

        .highlight-section h3 {
            color: var(--accent-color);
            font-size: 2rem;
            margin-top: 0;
        }

        /* --- CTA Section --- */
        .cta-section {
            text-align: center;
        }

        .btn {
            display: inline-block;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--white-color);
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
        }
        
        .btn-secondary {
            background-color: var(--light-color);
            color: var(--dark-color);
            margin-left: 1rem;
        }
        .btn-secondary:hover {
            background-color: #e2e2e2;
            transform: translateY(-3px);
        }


        /* --- Responsive Design --- */
        @media (max-width: 768px) {
            .hero {
                height: 50vh;
            }
            .hero h1 {
                font-size: 2.2rem;
            }
            .mission-vision-grid, .solution-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <header class="hero">
        <div class="hero-content" style="align-items:center; justify-content:center;">
            <h1 >About OPLANLA:</h1>
            <h1>More Than a Place to Stay. A Place to Belong.</h1>
            <p>We're redefining what it means to find a home away from home by connecting people to places, communities, and local economies.</p>
        </div>
    </header>

    <main class="flex flex-col w-full justify-center px-4">
        <section class="content-section">
            <div class="container">
                <h2>The Search for a Real Home</h2>
                <p class="section-intro">
                    Imagine moving to a new city for 3, 6, or even 12 months. You aren't a tourist looking for a resort; you need a real home in a quiet neighborhood with fair pricing and flexible terms. But when you search online, you find outdated listings, poor photos, or your ideal home is buried under hundreds of irrelevant results.
                </p>
                <p class="section-intro">
                    This is the reality for thousands of travelers, remote workers, students, and relocating professionals needing extended stays in niche areas. These charming "hidden" neighborhoods are often overlooked by major platforms. For property owners in these areas, the frustration is mutual: they have great spaces but no professional platform or marketing budget to reach the right audience. <strong>That’s the gap we’re closing.</strong>
                </p>
            </div>
        </section>
    
        <section class="content-section" style="background-color: var(--light-color);">
            <div class="container">
                <div class="mission-vision-grid">
                    <div class="mission-card">
                        <h3>Our Mission</h3>
                        <p>
                            To empower every traveler and small accommodation provider—no matter their location or budget—by building a unified, fair, and discoverable platform for both short-term tourism and long-term stays. We tackle core problems like fragmented platforms, unfair fees, and invisible neighborhoods by giving small providers the tools and visibility they've been denied.
                        </p>
                    </div>
                    <div class="vision-card">
                        <h3>Our Vision</h3>
                        <p>
                            To build a globally recognized, inclusive brand that gives fair and powerful representation to all accommodation providers. We aim to become the go-to platform for extended stays in overlooked places—where small providers thrive, travelers belong, and communities grow.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    
        <section class="content-section">
            <div class="container">
                <h2>A Fairer Platform for Everyone</h2>
                <p class="section-intro">We aren't just another booking site; we are a movement to democratize accommodation. We bridge the gap with a solution focused on fairness, discoverability, and empowerment.</p>
                <div class="solution-grid">
                    <div class="solution-card">
                        <h3>For Travelers: Discover Your Perfect Stay</h3>
                        <p>Our unified engine lets you search for short-term stays (1-30 nights) and long-term rentals (1-12+ months) in one place. Our smart algorithms help you find authentic homes in suburbs, university towns, and regional gems ignored by big platforms; along side the usual holidy destinations.</p>
                    </div>
                     <div class="solution-card">
                        <h3>For Providers: The Tools to Succeed</h3>
                        <p>We empower small providers with professional tools, reports, and a transparent pricing model that works for you. </p>
                         <ul>
                             <li><strong>Fair Commission:</strong> <span>10%, which is well below the industry average of 15–30%. </span></li>
                             <li><strong>Low Subscription:</strong> <span>Just R250/month to keep your listing active and supported for those providing long term rentals.</span></li>
                         </ul>
                    </div>
                </div>
            </div>
        </section>
        
        <section class="content-section" style="background-color: var(--light-color);">
            <div class="container">
                <div class="highlight-section">
                    <h3>Our Commitment to Quality: We Provide Media Services</h3>
                    <p>First impressions matter. To ensure quality from day one, we are offering <strong>DISCOUNTED professional photography and listing optimization services to our first 100 registered providers.</strong> </p>
                    <p>Stunning photos increase bookings, and we believe every property owner deserves to shine. This is our investment in our community's success.</p>
                </div>
            </div>
        </section>
    
        <section class="content-section cta-section">
            <div class="container">
                <h2>Join the Movement</h2>
                <p class="section-intro">Whether you're looking for a place to call home for a while or you have a space to share, Oplanla is where you belong.</p>
                <div class="space-y-2">
                    <a href="{{route('rooms.landing')}}" class="btn btn-primary">Find Your Next Home</a>
                    <a href="{{route('provider.register')}}" class="btn btn-secondary">List Your Property</a>
                </div>
            </div>
        </section>
    </main>

@endsection