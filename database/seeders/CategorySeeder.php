<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Pitch Competitions',
            'Networking Events',
            'Workshops',
            'Conferences',
            'Hackathons',
            'Mentorship Programs',
            'Investor Meetups',
            'Startup Showcases',
            'Accelerator Programs',
            'Industry Panels'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'description' => "Events related to {$category} for startups and entrepreneurs."
            ]);
        }
    }
}
