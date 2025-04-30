<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $featuredEvents = Event::with(['user', 'category'])
            ->when(!$user, function ($query) {
                return $query->where('status', 'published');
            })
            ->when($user, function ($query) use ($user) {
                return $query->where(function ($q) use ($user) {
                    $q->where('status', 'published')
                      ->orWhere(function ($q) use ($user) {
                          $q->where('status', 'draft')
                            ->where('user_id', $user->id);
                      });
                });
            })
            ->where('start_date', '>', now())
            ->orderBy('start_date')
            ->take(6)
            ->get();

        $upcomingEvents = Event::with(['user', 'category'])
            ->when(!$user, function ($query) {
                return $query->where('status', 'published');
            })
            ->when($user, function ($query) use ($user) {
                return $query->where(function ($q) use ($user) {
                    $q->where('status', 'published')
                      ->orWhere(function ($q) use ($user) {
                          $q->where('status', 'draft')
                            ->where('user_id', $user->id);
                      });
                });
            })
            ->where('start_date', '>', now())
            ->orderBy('start_date')
            ->skip(6)
            ->take(6)
            ->get();

        $categories = Category::withCount('events')
            ->orderBy('events_count', 'desc')
            ->take(8)
            ->get();

        return view('home', compact('featuredEvents', 'upcomingEvents', 'categories'));
    }
}
