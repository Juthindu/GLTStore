<?php

namespace App\Http\Controllers;

use App\Models\TeaType;
use Illuminate\Http\Request;

class TeaTypeController extends Controller
{
    public function index()
    {
        $page_option = ['main' => 'tea_types', 'sub' => 'tea_types_view'];
        $page_name = "Tea Types Overview";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Tea Types', 'url' => route('tea_types.view')],
            ['name' => 'View', 'url' => '#']
        ];

        // Fetch all tea types from the database
        $teaTypes = TeaType::all();

        return view('page.teaType.index', compact('page_name', 'breadcrumbs', 'page_option', 'teaTypes'));
    }

    public function create()
    {
        $page_option = ['main' => 'tea_types', 'sub' => 'tea_types_create'];
        $page_name = "Create New Tea Type";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Tea Types', 'url' => route('tea_types.view')],
            ['name' => 'Create New', 'url' => '#']
        ];

        return view('page.teaType.create', compact('page_name', 'breadcrumbs', 'page_option'));
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


        return view('page.teaType.update', compact('page_name', 'breadcrumbs', 'page_option'));
    }

}
