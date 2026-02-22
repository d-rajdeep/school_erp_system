<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassesController extends Controller
{

    public function index()
    {
        $classes = Classes::where('tenant_id', Auth::user()->tenant_id)
            ->latest()
            ->get();

        return view('school_admin.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('school_admin.classes.create');
    }

    public function store(Request $request)
    {
        Classes::create([
            'tenant_id' => Auth::user()->tenant_id,
            'name' => $request->name
        ]);

        return redirect()->route('school_admin.classes.index');
    }

    public function edit(Request $request)
    {

    }
}
