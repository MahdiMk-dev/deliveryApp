<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming drivers are stored in the User model
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. View all drivers
    public function index()
    {
        $drivers = User::all();

        return response()->json([
            'users' => $drivers,
            'status'=>'success',
        ]);
    }

    // 2. View one driver
    public function show($id)
    {
        $driver = User::where('id', $id)->first();

        if (!$driver) {
            return response()->json([
                'status' => 404,
                'message' => 'Driver not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'user' => $driver
        ]);
    }

    // 3. Add a new driver
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'address' => 'required|string|max:255',
                'password' => 'required|string',
                'username' => 'required|string|unique:users', // Ensure the 'unique' rule is correct
                'type' => 'required|string',
            ]);
    
            // Create a new driver
            $driver = new User();
            $driver->first_name = $validated['first_name'];
            $driver->last_name = $validated['last_name'];
            $driver->address = $validated['address'];
            $driver->phone_number = $validated['phone_number'];
            $driver->type = $validated['type'];
            $driver->username = $validated['username'];
            $driver->password = Hash::make($validated['password']); // Hash the password
    
            $driver->save();
    
            return response()->json([
                'status' => 'success',
                'message' => 'Driver added successfully',
                'driver' => $driver
            ], 201); // 201 for successful resource creation
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username already exists',
                'errors' => $e->errors()
            ], 422); // 422 Unprocessable Entity
        }
    }

// 4. Edit a driver
public function update(Request $request)
{
    $driver = User::find($request->id);

    if (!$driver) {
        return response()->json([
            'status' => 'error',
            'message' => 'User not found'
        ], 404);
    }

    $validated = $request->validate([
        'first_name' => 'sometimes|string|max:255',
        'last_name' => 'sometimes|string|max:255',
        'phone_number' => 'sometimes|string|max:20',
        'address' => 'sometimes|string|max:255',
        'username' => 'sometimes|string',
        'type' => 'sometimes|string',
        'password' => 'sometimes|string|min:8',
    ]);

    // Check if the username exists with a different ID
    $usernameExists = User::where('username', $request->username)
        ->where('id', '!=', $request->id)
        ->exists();

    if ($usernameExists) {
        return response()->json([
            'status' => 'error',
            'message' => 'Username already exists'
        ], 422); // 422 Unprocessable Entity
    }

    // Update fields only if they exist in the validated request
    if (isset($validated['first_name'])) {
        $driver->first_name = $validated['first_name'];
    }
    if (isset($validated['last_name'])) {
        $driver->last_name = $validated['last_name'];
    }
    if (isset($validated['phone_number'])) {
        $driver->phone_number = $validated['phone_number'];
    }
    if (isset($validated['address'])) {
        $driver->address = $validated['address'];
    }
    if (isset($validated['username'])) {
        $driver->username = $validated['username'];
    }
    if (isset($validated['type'])) {
        $driver->type = $validated['type'];
    }
    if (isset($validated['password'])) {
        $driver->password = Hash::make($validated['password']);
    }

    try {
        // Save the updated driver
        $driver->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Driver updated successfully',
            'driver' => $driver
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Error updating driver',
            'errors' => $e->getMessage()
        ], 500); // 500 Internal Server Error
    }
}



    // 5. Delete a driver
    public function destroy($id)
    {
        $driver = User::where('id', $id)->first();

        if (!$driver) {
            return response()->json([
                'status' => 404,
                'message' => 'Driver not found'
            ], 404);
        }

        $driver->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Driver deleted successfully'
        ]);
    }
}
