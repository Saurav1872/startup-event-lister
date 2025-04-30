<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $categoryId = $request->query('category');
        
        $events = Event::with(['user', 'category'])
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
            ->when($categoryId, function ($query) use ($categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->where('start_date', '>', now())
            ->orderBy('start_date')
            ->paginate(12);

        $categories = Category::withCount('events')
            ->orderBy('events_count', 'desc')
            ->take(8)
            ->get();

        return view('events.index', compact('events', 'categories', 'categoryId'));
    }

    public function create()
    {
        if (!auth()->user()->hasAnyRole(['organizer', 'admin'])) {
            abort(403, 'Only organizers and admins can create events.');
        }
        
        $categories = Category::all();
        return view('events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasAnyRole(['organizer', 'admin'])) {
            abort(403, 'Only organizers and admins can create events.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'venue_type' => 'required|in:physical,virtual,hybrid',
            'cover_image' => 'nullable|image|max:2048',
            'max_attendees' => 'nullable|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($request->title);
        $validated['status'] = 'draft';

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('events', 'public');
            $validated['cover_image'] = $path;
        }

        $event = Event::create($validated);

        return redirect()->route('events.show', $event)
            ->with('success', 'Event created successfully!');
    }

    public function show(Event $event)
    {
        $event->load(['user', 'category']);
        return view('events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        if (!Gate::allows('update', $event)) {
            abort(403);
        }
        
        $categories = Category::all();
        return view('events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        if (!Gate::allows('update', $event)) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'venue_type' => 'required|in:physical,virtual,hybrid',
            'cover_image' => 'nullable|image|max:2048',
            'max_attendees' => 'nullable|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:draft,published,cancelled',
        ]);

        $validated['slug'] = Str::slug($request->title);

        if ($request->hasFile('cover_image')) {
            if ($event->cover_image) {
                Storage::disk('public')->delete($event->cover_image);
            }
            $path = $request->file('cover_image')->store('events', 'public');
            $validated['cover_image'] = $path;
        }

        $event->update($validated);

        return redirect()->route('events.show', $event)
            ->with('success', 'Event updated successfully!');
    }

    public function publish(Event $event)
    {
        if (!Gate::allows('update', $event)) {
            abort(403);
        }

        $event->update(['status' => 'published']);

        return redirect()->route('events.show', $event)
            ->with('success', 'Event published successfully!');
    }

    public function destroy(Event $event)
    {
        if (!Gate::allows('delete', $event)) {
            abort(403);
        }

        if ($event->cover_image) {
            Storage::disk('public')->delete($event->cover_image);
        }

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully!');
    }
}
