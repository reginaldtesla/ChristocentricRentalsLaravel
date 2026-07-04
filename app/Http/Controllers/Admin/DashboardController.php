<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\NewsletterSubscriber;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'productCount' => Product::count(),
            'orderCount' => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'subscriberCount' => NewsletterSubscriber::active()->count(),
            'categoryCount' => Category::count(),
            'recentOrders' => Order::latest()->limit(5)->get(),
        ]);
    }
}
