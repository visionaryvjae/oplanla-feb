<div class="mb-6">
    <a href="{{ $route ?? url()->previous() }}" class="text-sm font-medium hover:text-purple-800 flex items-center">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        Back to {{ $title ?? 'previous page' }}
    </a>
</div>