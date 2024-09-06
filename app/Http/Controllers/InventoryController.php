<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{

    public function index()
    {
        $page_option = ['main' => 'inventory', 'sub' => 'inventory_manage'];
        $page_name = "Inventory Overview";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Inventory', 'url' => route('inventory.manage')],
            ['name' => 'View', 'url' => '#']
        ];


        return view('page.inventory.index', compact('page_name', 'breadcrumbs', 'page_option'));
    }

    public function create()
    {
        $page_option = ['main' => 'inventory', 'sub' => 'inventory_create'];
        $page_name = "Add New Stock";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Inventory', 'url' => route('inventory.manage')],
            ['name' => 'Add New', 'url' => '#']
        ];

        return view('page.inventory.create', compact('page_name', 'breadcrumbs', 'page_option'));
    }

    public function store(Request $request)
    {

        return redirect()->route('inventory.manage')->with('success', 'Inventory item added successfully.');
    }

    public function adjust()
    {
        $page_option = ['main' => 'inventory', 'sub' => 'inventory_adjust'];
        $page_name = "Adjust Stock";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Inventory', 'url' => route('inventory.manage')],
            ['name' => 'Adjust Stock', 'url' => '#']
        ];

        return view('page.inventory.adjust', compact('page_name', 'breadcrumbs', 'page_option'));
    }

    public function updateStock(Request $request)
    {

        return redirect()->route('inventory.manage')->with('success', 'Stock adjusted successfully.');
    }
    
}
