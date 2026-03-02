<style>
    /* Custom colors for Tailwind */
    :root {
        --color-primary-p: #ad68e4;
        --color-secondary-s: #68e4ad;
        --color-accent: rgb(17 24 39 );
        --color-dark-bg: #282c34; /* Dark background from footer image */
        --color-text-light: #e0e0e0; /* Light text for dark backgrounds */
        --color-text-dark: #333333; /* Dark text for light backgrounds */
    }
    .bg-primary-p { background-color: var(--color-primary-p); }
    .text-primary-p { color: var(--color-primary-p); }
    .hover\:bg-primary-p-darker:hover { background-color: #973fdf; /* Slightly darker primary-p-p */ }
    .bg-secondary-s { background-color: var(--color-secondary-s); }
    .text-secondary-s { color: var(--color-secondary-s); }
    .bg-accent { background-color: var(--color-accent); }
    .text-accent {color: var(--color-accent)}
    .bg-dark-bg { background-color: var(--color-dark-bg); }
    .text-text-light { color: var(--color-text-light); }
    .text-text-dark { color: var(--color-text-dark); }

    /* Inter font */
    body {
        font-family: 'Inter', sans-serif;
        color: var(--color-text-dark);
    }
    
    /* Review card styling */
    .review-card {
        margin-bottom: 20px;
    }
    
    /* Truncate the text by default */
    .truncated-text {
        line-height: 1.6;
        font-size: 16px;
        color: #333;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 5; /* Show 3 lines of text by default */
        -webkit-box-orient: vertical;
        max-height: 48px; /* Adjust based on font size and line height */
        transition: max-height 0.3s ease;
    }
    
    /* Expanded state */
    .review-card.expanded .truncated-text {
        max-height: none;
        -webkit-line-clamp: unset;
    }
</style>

@php
    $roundedRating = round($avgRating, 2);
@endphp

<div class="w-full mx-auto p-5 bg-white my-10" style="width:100%; border-top:solid #ccc 1px; background-color: #ddd;">
    <!-- Section Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center pb-4 mb-6 border-b border-gray-200">
        <h2 class="text-2xl md:text-3xl font-bold text-accent mb-4 md:mb-0">Guest Reviews</h2>
        <div class="flex items-center gap-4">
            <div class="text-4xl md:text-5xl font-bold text-secondary-s">{{number_format($roundedRating, 1)}}</div>
            <div>
                <div class="flex text-accent text-xl">
                    @for($j = 0; $j < floor($roundedRating); $j++)
                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" style="width:1.5rem; height:1.125rem; color: #68e4ad;">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                    @endfor
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <div class="text-gray-500 text-sm">{{$numReviews}} Reviews</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    {{-- <div class="flex flex-wrap gap-2 mb-8">
        <button class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full font-medium hover:bg-blue-200 transition active:bg-primary-p active:text-white">All Reviews</button>
        <button class="px-4 py-2 bg-gray-100 rounded-full font-medium hover:bg-gray-200 transition">5 Stars</button>
        <button class="px-4 py-2 bg-gray-100 rounded-full font-medium hover:bg-gray-200 transition">4 Stars</button>
        <button class="px-4 py-2 bg-gray-100 rounded-full font-medium hover:bg-gray-200 transition">3 Stars</button>
        <button class="px-4 py-2 bg-gray-100 rounded-full font-medium hover:bg-gray-200 transition">Recent</button>
    </div> --}}

    <!-- Reviews List -->
    <div class="space-y-6 mb-10">
        <!-- Review 1 -->
        @foreach($reviews as $index => $review)
            @php
                $datestr = new DateTime($review->created_at);
                $formattedDate = $datestr->format('d F Y h:iA');
                // dd($review->user);
            @endphp
            <div class="review-card p-6 bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex flex-col sm:flex-row justify-between mb-4">
                    <div class="flex items-center gap-4 mb-3 sm:mb-0">
                        <img 
                            class="w-12 h-12 rounded-full bg-primary-p flex items-center justify-center text-white font-bold text-lg"
                                    src="{{ $review->user->avatar ? asset('storage/avatars/' . $review->user->avatar->avatar) : 'https://placeholder.co/256x256/3b82f6/FFFFFF?text=' . substr($review->user->name, 0, 1) }}"
                                
                                alt="https://placehold.co/256x256/3b82f6/FFFFFF?text=substr($review->user->name, 0, 1) }}"
                        >
                        <div>
                            <div class="font-semibold text-lg text-secondary-s">{{ $review->user->name }}</div>
                            <div class="text-gray-500 text-sm">{{$review->created_at ? $formattedDate : "unknown date" }}</div>
                        </div>
                    </div>
                    <div class="flex text-accent text-lg">
                        @for($j = 0; $j < $review->rating; $j++)
                            <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" style="width:1.5rem; height:1.125rem; color: #68e4ad;">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                        @endfor
                    </div>
                </div>
                <div class="review-card">
                    <p class="truncated-text">
                        {{ $review->comment }}
                    </p>
                    <button class="read-more-button"  style="color:#ad68e4;">Read More</button>
                </div>
                {{-- <div class="flex items-center gap-4 text-gray-500 text-sm">
                    <button class="flex items-center gap-1 text-primary-p hover:underline">
                        <i class="far fa-thumbs-up"></i> Helpful (24)
                    </button>
                    <span>•</span>
                    <a href="#" class="text-primary-p hover:underline">Reply</a>
                </div> --}}
            </div>
        @endforeach
    </div>

    <!-- Add Review Section -->
    {{-- <div class="bg-gray-50 p-6 rounded-lg">
        <h3 class="text-xl font-bold text-secondary-s mb-4">Write a Review</h3>
        
        <div class="mb-5">
            <p class="font-medium mb-2">Your Rating</p>
            <div class="flex gap-1">
                <input type="radio" id="star5" name="rating" value="5" class="hidden" />
                <label for="star5" class="cursor-pointer text-2xl text-gray-300 hover:text-accent">
                    <i class="fas fa-star"></i>
                </label>
                
                <input type="radio" id="star4" name="rating" value="4" class="hidden" />
                <label for="star4" class="cursor-pointer text-2xl text-gray-300 hover:text-accent">
                    <i class="fas fa-star"></i>
                </label>
                
                <input type="radio" id="star3" name="rating" value="3" class="hidden" />
                <label for="star3" class="cursor-pointer text-2xl text-gray-300 hover:text-accent">
                    <i class="fas fa-star"></i>
                </label>
                
                <input type="radio" id="star2" name="rating" value="2" class="hidden" />
                <label for="star2" class="cursor-pointer text-2xl text-gray-300 hover:text-accent">
                    <i class="fas fa-star"></i>
                </label>
                
                <input type="radio" id="star1" name="rating" value="1" class="hidden" />
                <label for="star1" class="cursor-pointer text-2xl text-gray-300 hover:text-accent">
                    <i class="fas fa-star"></i>
                </label>
            </div>
        </div>
        
        <form class="review-form">
            <textarea 
                placeholder="Share your experience..." 
                class="w-full p-4 border border-gray-300 rounded-lg resize-y min-h-[120px] mb-4 focus:ring-2 focus:ring-primary-p focus:border-transparent">
            </textarea>
            <button 
                type="submit" 
                class="px-6 py-3 bg-primary-p text-white font-semibold rounded-lg hover:bg-blue-600 transition">
                Submit Review
            </button>
        </form>
    </div> --}}
</div>

<script>
    document.querySelectorAll('.read-more-button').forEach(button => {
        const card = button.closest('.review-card'); // Get the parent .review-card
    
        button.addEventListener('click', () => {
            // Toggle the 'expanded' class on the review card
            card.classList.toggle('expanded');
    
            // Update button text based on state
            if (card.classList.contains('expanded')) {
                button.textContent = 'Read Less';
            } else {
                button.textContent = 'Read More';
            }
        });
    });
</script>

{{-- <script>
    // Filter functionality
    document.querySelectorAll('.gap-2 button').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.gap-2 button').forEach(btn => {
                btn.classList.remove('bg-primary-p', 'text-white');
                btn.classList.add('bg-gray-100');
            });
            this.classList.remove('bg-gray-100');
            this.classList.add('bg-primary-p', 'text-white');
        });
    });

    // Star rating interaction
    const stars = document.querySelectorAll('.gap-1 label');
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('for').replace('star', '');
            document.querySelectorAll('.gap-1 input').forEach(input => {
                input.checked = false;
            });
            document.getElementById(`star${rating}`).checked = true;
            
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.add('text-accent');
                    s.classList.remove('text-gray-300');
                } else {
                    s.classList.remove('text-accent');
                    s.classList.add('text-gray-300');
                }
            });
        });
        
        star.addEventListener('mouseover', function() {
            const rating = this.getAttribute('for').replace('star', '');
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.add('text-accent');
                    s.classList.remove('text-gray-300');
                } else {
                    s.classList.remove('text-accent');
                    s.classList.add('text-gray-300');
                }
            });
        });
    });

    // Reset stars on mouseout
    document.querySelector('.gap-1').addEventListener('mouseleave', function() {
        const checked = document.querySelector('.gap-1 input:checked');
        if (checked) {
            const rating = checked.id.replace('star', '');
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.add('text-accent');
                    s.classList.remove('text-gray-300');
                } else {
                    s.classList.remove('text-accent');
                    s.classList.add('text-gray-300');
                }
            });
        } else {
            stars.forEach(s => {
                s.classList.remove('text-accent');
                s.classList.add('text-gray-300');
            });
        }
    });

    // Helpful button functionality
    document.querySelectorAll('.fa-thumbs-up').forEach(button => {
        button.parentElement.addEventListener('click', function(e) {
            e.preventDefault();
            const countElement = this.querySelector('span') || this.nextSibling;
            let countText = this.textContent;
            let count = parseInt(countText.match(/\d+/)[0]) || 0;
            count++;
            this.innerHTML = `<i class="far fa-thumbs-up"></i> Helpful (${count})`;
            this.disabled = true;
            this.classList.add('text-gray-700');
            this.classList.remove('hover:underline');
        });
    });

    // Form submission
    document.querySelector('.review-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const rating = document.querySelector('input[name="rating"]:checked');
        const reviewText = this.querySelector('textarea').value;
        
        if(!rating) {
            alert('Please select a rating');
            return;
        }
        
        if(reviewText.trim() === '') {
            alert('Please write your review');
            return;
        }
        
        alert('Thank you for your review!');
        this.reset();
        stars.forEach(s => {
            s.classList.remove('text-accent');
            s.classList.add('text-gray-300');
        });
    });
</script> --}}