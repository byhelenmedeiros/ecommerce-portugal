<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::paginate(10);
        return inertia('Admin/Regions/Index', compact('regions'));
    }

    public function create()
    {
        return inertia('Admin/Regions/Create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Region::create($request->only('name'));
        return redirect()->route('admin.regions.index');
    }

    public function edit(Region $region)
    {
        return inertia('Admin/Regions/Edit', compact('region'));
    }

    public function update(Request $request, Region $region)
    {
        $request->validate(['name' => 'required']);
        $region->update($request->only('name'));
        return redirect()->route('admin.regions.index');
    }

    public function destroy(Region $region)
    {
        $region->delete();
        return redirect()->route('admin.regions.index');
    }
}