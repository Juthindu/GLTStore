<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $page_option = ['main' => 'orders', 'sub' => 'orders_manage'];
        $page_name = "Order Overview";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Orders', 'url' => route('orders.manage')],
            ['name' => 'View', 'url' => '#']
        ];

        $orders = Order::all();

        return view('page.orders.index', compact('page_name', 'breadcrumbs', 'page_option', 'orders'));
    }

    public function create()
    {
        $page_option = ['main' => 'orders', 'sub' => 'orders_create'];
        $page_name = "Create New Order";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Orders', 'url' => route('orders.manage')],
            ['name' => 'Create New', 'url' => '#']
        ];


        return view('page.orders.create', compact('page_name', 'breadcrumbs', 'page_option'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'tea_type_id' => 'required|exists:tea_types,id',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|string|max:255',
        ]);

        Order::create($validated);

        return redirect()->route('orders.manage')->with('success', 'Order created successfully.');
    }

    public function update()
    {
        $page_option = ['main' => 'orders', 'sub' => 'orders_status'];
        $page_name = "Order Status";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Orders', 'url' => route('orders.manage')],
            ['name' => 'Status', 'url' => '#']
        ];

        return view('page.orders.update', compact('page_name', 'breadcrumbs', 'page_option'));
    }
    
}
