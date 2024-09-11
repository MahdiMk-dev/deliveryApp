<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class ShopController extends Controller
{
    // 1. View all shops
    public function index()
    {
        $shops = Shop::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Shops views successfully',
            'shop' => $shops
        ]);
    }

    // 2. View one shop
    public function show($id)
    {
        $shop = Shop::find($id);

        if (!$shop) {
            return response()->json([
                'status' => 404,
                'message' => 'Shop not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'shop' => $shop
        ]);
    }

    // 3. Add a new shop
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'owner' => 'required|string|max:255',
            'number_of_orders' => 'nullable|integer',
            'phone_number' => 'required|string|max:15|unique:shops,phone_number',
        ]);

        $shop = new Shop();
        $shop->name = $validated['name'];
        $shop->owner = $validated['owner'];
        $shop->number_of_orders = $validated['number_of_orders'] ?? 0; // Default to 0 if not provided
        $shop->phone_number = $validated['phone_number'];

        $shop->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Shop added successfully',
            'shop' => $shop
        ]);
    }

    // 4. Edit a shop
    public function update(Request $request)
    {
        $shop = Shop::find($request->id);

        if (!$shop) {
            return response()->json([
                'status' => 404,
                'message' => 'Shop not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'owner' => 'sometimes|string|max:255',
            'number_of_orders' => 'sometimes|nullable|integer',
            'phone_number' => 'sometimes|string|max:15',
        ]);
        $phoneExists = Shop::where('phone_number', $request->phone_number)
        ->where('id', '!=', $request->id)
        ->exists();

    if ($phoneExists) {
        return response()->json([
            'status' => 'error',
            'message' => 'phone number already exists'
        ], 422); // 422 Unprocessable Entity
    }

        if (isset($validated['name'])) {
            $shop->name = $validated['name'];
        }
        if (isset($validated['owner'])) {
            $shop->owner = $validated['owner'];
        }
        if (isset($validated['number_of_orders'])) {
            $shop->number_of_orders = $validated['number_of_orders'];
        }
        if (isset($validated['phone_number'])) {
            $shop->phone_number = $validated['phone_number'];
        }

        $shop->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Shop updated successfully',
            'shop' => $shop
        ]);
    }

    // 5. Delete a shop
    public function destroy($id)
    {
        $shop = Shop::find($id);

        if (!$shop) {
            return response()->json([
                'status' => 404,
                'message' => 'Shop not found'
            ], 404);
        }

        $shop->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Shop deleted successfully'
        ]);
    }
}

