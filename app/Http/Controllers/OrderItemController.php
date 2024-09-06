<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index($orderId)
    {
        $order = Order::findOrFail($orderId);
        $page_option = ['main' => 'orders', 'sub' => 'order_items_manage'];
        $page_name = "Order Items Overview";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Orders', 'url' => route('orders.manage')],
            ['name' => 'Order Items', 'url' => route('order-items.manage', ['orderId' => $orderId])],
            ['name' => 'View', 'url' => '#']
        ];

        $orderItems = $order->items; // Assuming an `items` relationship in Order model

        return view('page.order-items.index', compact('page_name', 'breadcrumbs', 'page_option', 'orderItems', 'order'));
    }

    public function create($orderId)
    {
        $order = Order::findOrFail($orderId);
        $page_option = ['main' => 'orders', 'sub' => 'order_items_create'];
        $page_name = "Add New Item to Order";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Orders', 'url' => route('orders.manage')],
            ['name' => 'Order Items', 'url' => route('order-items.manage', ['orderId' => $orderId])],
            ['name' => 'Add New', 'url' => '#']
        ];

        $teaTypes = TeaType::all(); // Fetch available tea types

        return view('page.order-items.create', compact('page_name', 'breadcrumbs', 'page_option', 'order', 'teaTypes'));
    }

    public function store(Request $request, $orderId)
    {
        $validated = $request->validate([
            'tea_type_id' => 'required|exists:tea_types,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $order = Order::findOrFail($orderId);

        $orderItem = new OrderItem($validated);
        $orderItem->order_id = $order->id;
        $orderItem->save();

        return redirect()->route('order-items.manage', ['orderId' => $orderId])
                            ->with('success', 'Item added to order successfully.');
    }

    public function edit($orderId, $itemId)
    {
        $order = Order::findOrFail($orderId);
        $orderItem = OrderItem::findOrFail($itemId);
        $page_option = ['main' => 'orders', 'sub' => 'order_items_edit'];
        $page_name = "Edit Order Item";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Orders', 'url' => route('orders.manage')],
            ['name' => 'Order Items', 'url' => route('order-items.manage', ['orderId' => $orderId])],
            ['name' => 'Edit', 'url' => '#']
        ];

        $teaTypes = TeaType::all(); // Fetch available tea types

        return view('page.order-items.edit', compact('page_name', 'breadcrumbs', 'page_option', 'orderItem', 'order', 'teaTypes'));
    }

    public function update(Request $request, $orderId, $itemId)
    {
        $validated = $request->validate([
            'tea_type_id' => 'required|exists:tea_types,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $orderItem = OrderItem::findOrFail($itemId);
        $orderItem->update($validated);

        return redirect()->route('order-items.manage', ['orderId' => $orderId])
                            ->with('success', 'Order item updated successfully.');
    }

    public function destroy($orderId, $itemId)
    {
        $orderItem = OrderItem::findOrFail($itemId);
        $orderItem->delete();

        return redirect()->route('order-items.manage', ['orderId' => $orderId])
                            ->with('success', 'Order item removed successfully.');
    }
    
}
