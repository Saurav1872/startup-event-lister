<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if ($event->cover_image)
                    <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-96 object-cover">
                @endif

                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <span class="px-3 py-1 text-sm font-semibold text-blue-600 bg-blue-100 rounded-full">
                                {{ $event->category->name }}
                            </span>
                            <span class="ml-2 text-sm text-gray-500">
                                {{ $event->start_date->format('M d, Y') }} - {{ $event->end_date->format('M d, Y') }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt mr-1"></i>
                            {{ $event->location }}
                        </div>
                    </div>

                    <h1 class="text-3xl font-bold mb-4">{{ $event->title }}</h1>
                    
                    <div class="prose max-w-none mb-8">
                        {!! nl2br(e($event->description)) !!}
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h2 class="text-xl font-semibold mb-4">Event Details</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Date & Time</h3>
                                <p class="text-gray-600">
                                    {{ $event->start_date->format('l, F j, Y') }}<br>
                                    {{ $event->start_date->format('g:i A') }} - {{ $event->end_date->format('g:i A') }}
                                </p>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Location</h3>
                                <p class="text-gray-600">{{ $event->location }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Category</h3>
                                <p class="text-gray-600">{{ $event->category->name }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Organizer</h3>
                                <p class="text-gray-600">{{ $event->user->name }}</p>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Price</h3>
                                <p class="text-gray-600">₹{{ number_format($event->price ?? 0, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between items-center">
                        <a href="{{ route('events.index') }}" class="text-blue-600 hover:text-blue-800">
                            ← Back to Events
                        </a>
                        @auth
                            @if(auth()->user()->id === $event->user_id)
                                <div class="flex space-x-4">
                                    @if($event->status === 'draft')
                                        <form action="{{ route('events.publish', $event) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                                                Publish Event
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('events.edit', $event) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                        Edit Event
                                    </a>
                                    <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700" onclick="return confirm('Are you sure you want to delete this event?')">
                                            Delete Event
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 