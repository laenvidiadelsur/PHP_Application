@props(['fundacion', 'voted' => false, 'count' => 0])

<div class="flex items-center gap-2" x-data="{ 
    voted: {{ $voted ? 'true' : 'false' }}, 
    count: {{ $count }},
    loading: false,
    async toggleVote() {
        if (this.loading) return;
        this.loading = true;
        
        try {
            const response = await fetch('{{ route('foundations.vote', $fundacion) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            
            if (response.ok) {
                const data = await response.json();
                this.voted = data.voted;
                this.count = data.votes_count;
                
                if (this.voted) {
                    window.dispatchEvent(new CustomEvent('notify', { 
                        detail: { message: 'Has añadido a favorita esta fundación' } 
                    }));
                }
            }
        } catch (error) {
            console.error('Error voting:', error);
        } finally {
            this.loading = false;
        }
    }
}">
    <button @click="toggleVote()" 
            class="group relative flex items-center justify-center p-2 rounded-full transition-all duration-300 hover:bg-red-50 focus:outline-none"
            :class="{ 'text-red-600': voted, 'text-gray-400 hover:text-red-500': !voted }"
            :disabled="loading">
        <svg xmlns="http://www.w3.org/2000/svg" 
             class="h-6 w-6 heart-animation transition-all duration-300" 
             :class="{ 'fill-current': voted, 'stroke-current fill-none': !voted }"
             viewBox="0 0 24 24" 
             stroke-width="2" 
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
        
        <!-- Pulse effect on click -->
        <span class="absolute inset-0 rounded-full bg-red-400 opacity-0 group-active:animate-ping" x-show="!loading"></span>
    </button>
    <span class="text-sm font-medium text-gray-600" x-text="count"></span>
</div>
