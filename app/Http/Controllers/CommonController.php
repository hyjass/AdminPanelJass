<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function getdata(Request $request)
    {
        $search = $request->search ?? '';
        $data = $request->data;
        if (!isset($data)) {
            return response()->json(['error' => 'Data is required'], 400);
        }
        if (!isset($search)) {
            $search = '';
        } else {
            $search = strtolower($search);
        }

        if ($data === 'product') {
            $query = \App\Models\Product::query();
        } elseif ($data === 'subcategory') {
            $query = \App\Models\Subcategory::query();
        } elseif ($data === 'category') {
            $query = \App\Models\Category::query();
        } elseif ($data === 'user') {
            $query = \App\Models\User::query();
        } else {
            return response()->json(['error' => 'Invalid data type'], 400);
        }
        $query->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%']);


        // Get results
        $datas = $query->get();

        return response()->json($datas);
    }


    public function getdatedata(Request $request)
    {
        // Handle the request to save data
        // This is a placeholder function; implement your logic here
        $data = $request->data;

        if (!isset($data)) {
            return response()->json(['error' => 'Data is required'], 400);
        }

        // Select the model based on 'data' value
        if ($data == "product") {
            $query = \App\Models\Product::query();
        } elseif ($data == "subcategory") {
            $query = \App\Models\Subcategory::query();
        } elseif ($data == "category") {
            $query = \App\Models\Category::query();
        } elseif ($data === 'user') {
            $query = \App\Models\User::query();
        } else {
            return response()->json(['error' => 'Invalid data type'], 400);
        }

        // Extract and validate 'from' and 'to' dates
        $from = $request->from ?? '';
        $to = $request->to ?? '';

        if (empty($from) || empty($to)) {
            return response()->json(['error' => 'From and To dates are required'], 400);
        }

        // Convert to date objects for comparison
        $fromDate = \Carbon\Carbon::parse($from);
        $toDate = \Carbon\Carbon::parse($to);

        // Check if 'to' date is before 'from' date
        if ($toDate->lt($fromDate)) {
            return response()->json(['error' => 'To date must be greater than or equal to From date'], 400);
        }

        // Perform the query
        $query->whereBetween('created_at', [$fromDate->startOfDay(), $toDate->endOfDay()]);
        $data = $query->get();

        return response()->json($data);
    }

    public function filterData(Request $request)
    {
        $dataType = $request->data;
        $search = strtolower($request->search ?? '');
        $from = $request->from;
        $to = $request->to;

        // Select model based on 'data'
        switch ($dataType) {
            case 'product':
                $query = \App\Models\Product::query();
                break;
            case 'subcategory':
                $query = \App\Models\Subcategory::query();
                break;
            case 'category':
                $query = \App\Models\Category::query();
                break;
            case 'user':
                $query = \App\Models\User::query();
                break;
            default:
                return response()->json(['error' => 'Invalid data type'], 400);
        }

        // Apply name search if provided
        if (!empty($search)) {
            $query->whereRaw('LOWER(name) LIKE ?', ["%$search%"]);
        }

        // Apply date filter if both from and to are provided
        if (!empty($from) && !empty($to)) {
            $fromDate = \Carbon\Carbon::parse($from)->startOfDay();
            $toDate = \Carbon\Carbon::parse(time: $to)->endOfDay();

            if ($toDate->lt($fromDate)) {
                return response()->json(['error' => 'To date must be after From date'], 400);
            }

            $query->whereBetween('created_at', [$fromDate, $toDate]);
        }
        return response()->json($query->get());
    }

}
