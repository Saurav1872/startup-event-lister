<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Events') }}
            </h2>
            @auth
                @if(auth()->user()->hasAnyRole(['admin', 'organizer']))
                    <a href="{{ route('events.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        Create Event
                    </a>
                @endif
            @endauth
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="mb-8">
                <h3 class="text-lg font-semibold mb-4">Categories</h3>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('events.index') }}" 
                       class="px-4 py-2 rounded-full {{ !$categoryId ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        All Events
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('events.index', ['category' => $category->id]) }}" 
                           class="px-4 py-2 rounded-full {{ $categoryId == $category->id ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            {{ $category->name }} ({{ $category->events_count }})
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($events as $event)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        @if($event->cover_image)
                            <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                        @endif
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <span class="px-3 py-1 text-sm font-semibold text-blue-600 bg-blue-100 rounded-full">
                                    {{ $event->category->name }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    {{ $event->start_date->format('M d, Y') }}
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-semibold mb-2">
                                <a href="{{ route('events.show', $event) }}" class="hover:text-blue-600">
                                    {{ $event->title }}
                                </a>
                            </h3>
                            
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ Str::limit($event->description, 150) }}
                            </p>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    {{ $event->location ?? 'Location not set' }}
                                </span>
                                <span class="text-lg font-semibold">
                                    ₹{{ number_format($event->price ?? 0, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500 text-lg">No events found.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $events->links() }}
            </div>
        </div>
    </div>
</x-app-layout> 