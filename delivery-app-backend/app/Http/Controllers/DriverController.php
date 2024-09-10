<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Assuming drivers are stored in the User model
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    // 1. View all drivers
    public function index()
    {
        $drivers = User::where('type', 'driver')->get();

        return response()->json($drivers);
    }

    // 2. View one driver
    public function show($id)
    {
        $driver = User::where('id', $id)->where('type', 'driver')->first();

        if (!$driver) {
            return response()->json([
                'status' => 404,
                'message' => 'Driver not found'
            ], 404);
        }

        return response()->json($driver);
    }

    // 3. Add a new driver
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        $driver = new User();
        $driver->first_name = $validated['first_name'];
        $driver->last_name = $validated['last_name'];
        $driver->phone_number = $validated['phone_number'];
        $driver->address = $validated['address'];
        $driver->type = 'driver'; // Set type as driver
        $driver->password = Hash::make($validated['password']); // Hash the password

        $driver->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Driver added successfully',
            'driver' => $driver
        ]);
    }

    // 4. Edit a driver
    public function update(Request $request, $id)
    {
        $driver = User::where('id', $id)->where('type', 'driver')->first();

        if (!$driver) {
            return response()->json([
                'status' => 404,
                'message' => 'Driver not found'
            ], 404);
        }

        $validated = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'phone_number' => 'sometimes|string|max:20',
            'address' => 'sometimes|string|max:255',
            'password' => 'sometimes|string|min:8',
        ]);

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
        if (isset($validated['password'])) {
            $driver->password = Hash::make($validated['password']);
        }

        $driver->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Driver updated successfully',
            'driver' => $driver
        ]);
    }

    // 5. Delete a driver
    public function destroy($id)
    {
        $driver = User::where('id', $id)->where('type', 'driver')->first();

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
