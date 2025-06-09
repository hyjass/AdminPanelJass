<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as Admin;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }
    public function dashboard(Request $request)
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            $data = Admin::all();
            return view('admin.dashboard', ['data' => $data]);
        } else if (Auth::check() && Auth::user()->role === 'user') {
            return view('dashboard');
        }

        return redirect()->route('login');

    }


    public function store(Request $request)
    {

        $id = $request->id;
        $emailRule = 'required|email|unique:users,email';
        if ($id) {
            $emailRule = 'required|email|unique:users,email,' . $id;
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => $emailRule,
            'country' => 'required',
            'password' => 'string|nullable',
        ]);

        if (!empty($id)) {
            $data = Admin::find($id);
            if ($data) {
                $data->name = $request->name;
                $data->email = $request->email;
                $data->country = $request->country;
                if ($request->filled('password')) {
                    $data->password = bcrypt($request->password);
                }
                // dd($data);
                $data->save();
            }
        } else {
            $data = new Admin();
            $data->name = $request->name;
            $data->email = $request->email;
            $data->country = $request->country;
            if (!$request->role) {
                $data->role = "user";
            } else {
                $data->role = $request->role;
            }
            if ($request->filled('password')) {
                $data->password = bcrypt($request->password);
            }
            $data->save();
        }

        return response()->json(['success' => true]);
    }



    public function checkadmin(Request $request)
    {
        $credentials = $request->validate(rules: [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role == 'user') {
                return response()->json(['success' => true, 'message' => 'Login successful', 'redirect' => 'user']);
            } else if ($user->role == 'admin') {
                return response()->json(['success' => true, 'message' => 'Login successful', 'redirect' => 'admin']);
            } else {
                return response()->json(['success' => false, 'message' => 'Unauthorized access'], 403);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password.',
        ], 422);
    }


    public function delete(Request $request)
    {
        $id = $request->id;
        $data = Admin::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false], 404);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

}
