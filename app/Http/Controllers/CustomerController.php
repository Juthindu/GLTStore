<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $page_option = ['main' => 'customers', 'sub' => 'customers_manage'];
        $page_name = "Customer Overview";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Customers', 'url' => route('customers.manage')],
            ['name' => 'View', 'url' => '#']
        ];

        $customers = Customer::all(); 

        return view('page.customers.index', compact('page_name', 'breadcrumbs', 'page_option', 'customers'));
    }

    public function create()
    {
        $page_option = ['main' => 'customers', 'sub' => 'customers_create'];
        $page_name = "Add New Customer";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Customers', 'url' => route('customers.manage')],
            ['name' => 'Add New', 'url' => '#']
        ];

        return view('page.customers.create', compact('page_name', 'breadcrumbs', 'page_option'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:15',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.manage')->with('success', 'Customer added successfully.');
    }

    public function update()
    {
        $page_option = ['main' => 'customers', 'sub' => 'customers_update'];
        $page_name = "Customer Update";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Customers', 'url' => route('customers.manage')],
            ['name' => 'Update', 'url' => '#']
        ];


        return view('page.customers.update', compact('page_name', 'breadcrumbs', 'page_option'));
    }
}
