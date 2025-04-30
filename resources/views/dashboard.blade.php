<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Profile Information</h3>
                        <p class="mt-1 text-sm text-gray-600">Update your account's profile information and email address.</p>
                    </div>

                    <div class="mt-4">
                        <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Bio:</strong> {{ Auth::user()->bio ?? 'Not provided' }}</p>
                        <p><strong>Startup Affiliation:</strong> {{ Auth::user()->startup_affiliation ?? 'Not provided' }}</p>
                        <p><strong>Role:</strong> {{ Auth::user()->getRoleNames()->first() }}</p>
                    </div>

                    @if(Auth::user()->hasRole('organizer'))
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900">Organizer Dashboard</h3>
                            <p class="mt-1 text-sm text-gray-600">Manage your events and registrations.</p>
                            <!-- Add organizer-specific content here -->
                        </div>
                    @endif

                    @if(Auth::user()->hasRole('admin'))
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900">Admin Dashboard</h3>
                            <p class="mt-1 text-sm text-gray-600">Manage users, events, and system settings.</p>
                            <!-- Add admin-specific content here -->
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
