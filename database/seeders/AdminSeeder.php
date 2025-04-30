<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin role if it doesn't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        // Assign admin role to admin user
        $admin->assignRole($adminRole);

        // Create categories
        $categories = [
            'Conference' => 'Tech conferences and summits',
            'Workshop' => 'Hands-on learning sessions',
            'Networking' => 'Professional networking events',
            'Hackathon' => 'Coding and development competitions',
            'Panel Discussion' => 'Expert panel discussions',
        ];

        foreach ($categories as $name => $description) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

        // Create sample events
        $events = [
            [
                'title' => 'Tech Startup Summit 2024',
                'description' => 'Join us for the largest tech startup conference of the year, featuring keynote speakers from leading tech companies, networking opportunities, and pitch competitions.',
                'start_date' => now()->addDays(30),
                'end_date' => now()->addDays(32),
                'location' => 'San Francisco, CA',
                'venue_type' => 'physical',
                'category_id' => Category::where('name', 'Conference')->first()->id,
                'cover_image' => 'https://st2.depositphotos.com/1002277/10073/i/450/depositphotos_100732324-stock-photo-word-event-on-wood-planks.jpg',
                'max_attendees' => 500,
                'price' => 299.99,
                'status' => 'published',
                'featured' => true,
            ],
            [
                'title' => 'AI & Machine Learning Workshop',
                'description' => 'Hands-on workshop covering the latest developments in AI and machine learning, perfect for startup founders looking to integrate AI into their products.',
                'start_date' => now()->addDays(15),
                'end_date' => now()->addDays(16),
                'location' => 'New York, NY',
                'venue_type' => 'hybrid',
                'category_id' => Category::where('name', 'Workshop')->first()->id,
                'cover_image' => 'https://st2.depositphotos.com/1002277/10073/i/450/depositphotos_100732324-stock-photo-word-event-on-wood-planks.jpg',
                'max_attendees' => 200,
                'price' => 149.99,
                'status' => 'published',
                'featured' => true,
            ],
            [
                'title' => 'Women in Tech Networking',
                'description' => 'An evening of networking and inspiration for women in the tech industry. Featuring panel discussions and mentorship opportunities.',
                'start_date' => now()->addDays(45),
                'end_date' => now()->addDays(45),
                'location' => 'Seattle, WA',
                'venue_type' => 'physical',
                'category_id' => Category::where('name', 'Networking')->first()->id,
                'cover_image' => 'https://st2.depositphotos.com/1002277/10073/i/450/depositphotos_100732324-stock-photo-word-event-on-wood-planks.jpg',
                'max_attendees' => 150,
                'price' => 0,
                'status' => 'published',
                'featured' => false,
            ],
            [
                'title' => 'Blockchain & Web3 Conference',
                'description' => 'Explore the future of blockchain technology and Web3 applications. Connect with industry leaders and discover new opportunities.',
                'start_date' => now()->addDays(60),
                'end_date' => now()->addDays(61),
                'location' => 'Austin, TX',
                'venue_type' => 'physical',
                'category_id' => Category::where('name', 'Conference')->first()->id,
                'cover_image' => 'https://st2.depositphotos.com/1002277/10073/i/450/depositphotos_100732324-stock-photo-word-event-on-wood-planks.jpg',
                'max_attendees' => 400,
                'price' => 249.99,
                'status' => 'published',
                'featured' => true,
            ],
            [
                'title' => 'Startup Funding Masterclass',
                'description' => 'Learn the ins and outs of startup funding from successful founders and venture capitalists. Topics include pitch deck creation, valuation, and term sheets.',
                'start_date' => now()->addDays(20),
                'end_date' => now()->addDays(20),
                'location' => 'Boston, MA',
                'venue_type' => 'virtual',
                'category_id' => Category::where('name', 'Workshop')->first()->id,
                'cover_image' => 'https://st2.depositphotos.com/1002277/10073/i/450/depositphotos_100732324-stock-photo-word-event-on-wood-planks.jpg',
                'max_attendees' => 300,
                'price' => 99.99,
                'status' => 'published',
                'featured' => true,
            ],
        ];

        foreach ($events as $event) {
            Event::create(array_merge($event, ['user_id' => $admin->id]));
        }
    }
} 