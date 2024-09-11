<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    // 1. View all clients
    public function index()
    {
        $clients = Client::all();

        return response()->json([
            'clients' => $clients,
            'status'=>'success',
        ]);;
    }

    // 2. View one client
    public function show($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                'status' => 404,
                'message' => 'Client not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'clients views successfully',
            'clients' => $client
        ]);
    }

    // 3. Add a new client
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15|unique:clients,phone_number',
            'number_of_orders' => 'nullable|integer',
        ]);

        $client = new Client();
        $client->first_name = $validated['first_name'];
        $client->last_name = $validated['last_name'];
        $client->address = $validated['address'];
        $client->phone_number = $validated['phone_number'];
        $client->number_of_orders = $validated['number_of_orders'] ?? 0; // Default to 0 if not provided

        $client->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Client added successfully',
            'client' => $client
        ]);
    }

    // 4. Edit a client
    public function update(Request $request)
    {
        $client = Client::find($request->id);

        if (!$client) {
            return response()->json([
                'status' => 404,
                'message' => 'Client not found'
            ], 404);
        }

        $validated = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string|max:255',
            'phone_number' => 'sometimes|string|max:15',
            'number_of_orders' => 'nullable|integer',
        ]);
        $phoneExists = Client::where('phone_number', $request->phone_number)
        ->where('id', '!=', $request->id)
        ->exists();

    if ($phoneExists) {
        return response()->json([
            'status' => 'error',
            'message' => 'phone number already exists'
        ], 422); // 422 Unprocessable Entity
    }

        if (isset($validated['first_name'])) {
            $client->first_name = $validated['first_name'];
        }
        if (isset($validated['last_name'])) {
            $client->last_name = $validated['last_name'];
        }
        if (isset($validated['address'])) {
            $client->address = $validated['address'];
        }
        if (isset($validated['phone_number'])) {
            $client->phone_number = $validated['phone_number'];
        }
        if (isset($validated['number_of_orders'])) {
            $client->number_of_orders = $validated['number_of_orders'];
        }

        $client->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Client updated successfully',
            'client' => $client
        ]);
    }

    // 5. Delete a client
    public function destroy($id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                'status' => 404,
                'message' => 'Client not found'
            ], 404);
        }

        $client->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Client deleted successfully'
        ]);
    }
}
