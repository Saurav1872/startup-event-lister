<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\File;

class EventSeeder extends Seeder
{
    public function run()
    {
        // Create a default user if none exists
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
            ]
        );

        // Read the sample events data
        $json = File::get(database_path('data/sample_events.json'));
        $data = json_decode($json, true);

        foreach ($data['events'] as $eventData) {
            // Find or create the category
            $category = Category::firstOrCreate(['name' => $eventData['category']]);

            // Create the event
            Event::create([
                'title' => $eventData['title'],
                'description' => $eventData['description'],
                'start_date' => $eventData['start_date'],
                'end_date' => $eventData['end_date'],
                'location' => $eventData['location'],
                'category_id' => $category->id,
                'cover_image' => $eventData['cover_image'],
                'status' => $eventData['status'],
                'featured' => $eventData['featured'],
                'user_id' => $user->id,
            ]);
        }
    }
} 