<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Client;
use App\Models\Shop;

class OrderController extends Controller
{
    // 1. View all orders
    public function index()
    {
        $orders = Order::with(['client', 'shop', 'driver'])->get();

        return response()->json($orders);
    }

    // 2. View one order
    public function show($id)
    {
        $order = Order::with(['client', 'shop', 'driver'])->find($id);

        if (!$order) {
            return response()->json([
                'status' => 404,
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json($order);
    }

    // 3. Add a new order
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'shop_id' => 'required|exists:shops,id',
            'driver_id' => 'nullable|exists:users,id,type,driver', // Ensure the driver exists and is of type 'driver'
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'order_number' => 'required|string|unique:orders,order_number',
        ]);

        $order = new Order();
        $order->client_id = $validated['client_id'];
        $order->shop_id = $validated['shop_id'];
        $order->driver_id = $validated['driver_id'] ?? null; // Driver can be nullable
        $order->date = $validated['date'];
        $order->amount = $validated['amount'];
        $order->order_number = $validated['order_number'];

        $order->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Order added successfully',
            'order' => $order
        ]);
    }

    // 4. Edit an order
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => 404,
                'message' => 'Order not found'
            ], 404);
        }

        $validated = $request->validate([
            'client_id' => 'sometimes|exists:clients,id',
            'shop_id' => 'sometimes|exists:shops,id',
            'driver_id' => 'nullable|exists:users,id,type,driver',
            'date' => 'sometimes|date',
            'amount' => 'sometimes|numeric',
            'order_number' => 'sometimes|string|unique:orders,order_number,' . $id,
        ]);

        if (isset($validated['client_id'])) {
            $order->client_id = $validated['client_id'];
        }
        if (isset($validated['shop_id'])) {
            $order->shop_id = $validated['shop_id'];
        }
        if (isset($validated['driver_id'])) {
            $order->driver_id = $validated['driver_id'];
        }
        if (isset($validated['date'])) {
            $order->date = $validated['date'];
        }
        if (isset($validated['amount'])) {
            $order->amount = $validated['amount'];
        }
        if (isset($validated['order_number'])) {
            $order->order_number = $validated['order_number'];
        }

        $order->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Order updated successfully',
            'order' => $order
        ]);
    }

    // 5. Delete an order
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => 404,
                'message' => 'Order not found'
            ], 404);
        }

        $order->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Order deleted successfully'
        ]);
    }
}
