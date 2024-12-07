<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomersExport;
use App\Imports\CustomersImport;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $customers = Customer::when($search, function ($query) use ($search) {
            $query->where('customer_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone', 'like', "%$search%");
        })->paginate(10);

        return view('customers.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'premium_amount' => 'required|numeric'
        ]);

        $premium_amount = $request->premium_amount;
        $gst_percentage = $request->gst_percentage ?? 18;
        $gst_amount = ($premium_amount * $gst_percentage) / 100;
        $total_premium_collected = $premium_amount + $gst_amount;

        Customer::updateOrCreate(
            ['id' => $request->id],
            [
                'customer_name' => $request->customer_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'premium_amount' => $premium_amount,
                'gst_percentage' => $gst_percentage,
                'gst_amount' => $gst_amount,
                'total_premium_collected' => $total_premium_collected
            ]
        );

        return redirect()->back()->with('success', 'Customer saved successfully.');
    }

    public function delete($id)
    {
        Customer::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Customer deleted successfully.');
    }

    public function export()
    {
        return Excel::download(new CustomersExport, 'customers.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);
        Excel::import(new CustomersImport, $request->file('file'));

        return redirect()->back()->with('success', 'Customers imported successfully.');
    }
}
