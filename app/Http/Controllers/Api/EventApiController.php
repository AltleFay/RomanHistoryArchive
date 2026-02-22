<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class EventApiController extends Controller
{
    public function index(): JsonResponse
    {
        $events = Event::with('era')->orderBy('start_year', 'asc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $events,
            'message' => 'Events retrieved successfully'
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'era_id' => 'required|exists:eras,id',
                'title' => 'required|string|max:255',
                'start_year' => 'required|integer',
                'end_year' => 'nullable|integer',
                'location' => 'nullable|string|max:255',
                'key_figures' => 'nullable|string|max:255',
                'description' => 'required|string'
            ]);

            $event = Event::create($validated);
            $event->load('era');

            return response()->json([
                'success' => true,
                'data' => $event,
                'message' => 'Event created successfully'
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create event: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $event = Event::with('era')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $event,
                'message' => 'Event retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Event not found'
            ], 404);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $event = Event::findOrFail($id);
            
            $validated = $request->validate([
                'era_id' => 'sometimes|required|exists:eras,id',
                'title' => 'sometimes|required|string|max:255',
                'start_year' => 'sometimes|required|integer',
                'end_year' => 'sometimes|nullable|integer',
                'location' => 'sometimes|nullable|string|max:255',
                'key_figures' => 'sometimes|nullable|string|max:255',
                'description' => 'sometimes|required|string'
            ]);

            $event->update($validated);
            $event->load('era');

            return response()->json([
                'success' => true,
                'data' => $event,
                'message' => 'Event updated successfully'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update event: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $event = Event::findOrFail($id);
            $event->delete();

            return response()->json([
                'success' => true,
                'message' => 'Event deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete event: ' . $e->getMessage()
            ], 500);
        }
    }
}
