<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Era;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class EraApiController extends Controller
{
    public function index(): JsonResponse
    {
        $eras = Era::with('events')->orderBy('id', 'asc')->get();
        
        return response()->json([
            'success' => true,
            'data' => $eras,
            'message' => 'Eras retrieved successfully'
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string'
            ]);

            $era = Era::create($validated);
            $era->load('events');

            return response()->json([
                'success' => true,
                'data' => $era,
                'message' => 'Era created successfully'
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
                'message' => 'Failed to create era: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $era = Era::with('events')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $era,
                'message' => 'Era retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Era not found'
            ], 404);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        try {
            $era = Era::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|nullable|string'
            ]);

            $era->update($validated);
            $era->load('events');

            return response()->json([
                'success' => true,
                'data' => $era,
                'message' => 'Era updated successfully'
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
                'message' => 'Failed to update era: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $era = Era::findOrFail($id);
            $era->delete();

            return response()->json([
                'success' => true,
                'message' => 'Era deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete era: ' . $e->getMessage()
            ], 500);
        }
    }
}
