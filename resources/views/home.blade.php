<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Welcome to Startup Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
                    <h1 class="text-4xl font-bold mb-4">Discover Startup Events</h1>
                    <p class="text-xl mb-6">Connect with innovators, learn from experts, and grow your startup network</p>
                    <a href="{{ route('events.index') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition duration-300">
                        Browse All Events
                    </a>
                </div>
            </div>

            <!-- Featured Events -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-6">Featured Events</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($featuredEvents as $event)
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
                            <p class="text-gray-500 text-lg">No featured events available.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Upcoming Events -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-6">Upcoming Events</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($upcomingEvents as $event)
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
                            <p class="text-gray-500 text-lg">No upcoming events available.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Categories -->
            <div class="mb-12">
                <h2 class="text-3xl font-bold mb-6">Popular Categories</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($categories as $category)
                        <a href="{{ route('events.index', ['category' => $category->id]) }}" 
                           class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                            <h3 class="text-lg font-semibold mb-2">{{ $category->name }}</h3>
                            <p class="text-gray-600">{{ $category->events_count }} events</p>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Host Event Section (Only for Organizers) -->
            @auth
                @if(auth()->user()->hasRole('organizer'))
                    <div class="bg-blue-50 p-8 rounded-lg">
                        <div class="max-w-3xl mx-auto text-center">
                            <h2 class="text-3xl font-bold mb-4">Ready to Host Your Event?</h2>
                            <p class="text-gray-600 mb-6">Create and manage your startup events with our easy-to-use platform.</p>
                            <a href="{{ route('events.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                                Create Your Event
                            </a>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</x-app-layout> 