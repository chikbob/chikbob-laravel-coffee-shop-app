<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()->orders()
            ->with('items.product')
            ->latest()
            ->get();

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($request) {
            $totalAmount = 0;
            $orderItems = [];

            foreach ($request->items as $item) {
                $product = \App\Models\Product::find($item['product_id']);
                $itemTotal = $product->price * $item['quantity'];
                $totalAmount += $itemTotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ];
            }

            $order = Order::create([
                'user_id' => $request->user()->id,
                'total_amount' => $totalAmount,
                'shipping_address' => $request->shipping_address,
                'phone' => $request->phone,
                'notes' => $request->notes,
            ]);

            $order->items()->createMany($orderItems);

            return response()->json([
                'order' => $order->load('items.product'),
                'message' => 'Order created successfully'
            ], Response::HTTP_CREATED);
        });
    }

    public function show(Request $request, $id)
    {
        $order = $request->user()->orders()
            ->with('items.product')
            ->findOrFail($id);

        return response()->json($order);
    }
}
