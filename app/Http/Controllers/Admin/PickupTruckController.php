<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PickupTruck;
use Illuminate\Http\Request;

class PickupTruckController extends Controller
{
    public function index()
    {
        $trucks = PickupTruck::orderBy('created_at', 'desc')->paginate(10);
        return view('Admin.trucks.index', compact('trucks'));
    }

    public function create()
    {
        return view('Admin.trucks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'       => 'required|string',
            'plat_nomor' => 'required|string|unique:pickup_truck,plat_nomor',
            'kapasitas'  => 'required|integer|min:1',
            'warehouse'  => 'required|string',
            'status'     => 'required|in:idle,maintenance,penjemputan',
        ]);

        PickupTruck::create($validated);

        return redirect()
            ->route('admin.trucks.index')
            ->with('success', 'Truck created successfully.');
    }

    // show() removed per requirements

    public function edit($id)
    {
        $truck = PickupTruck::findOrFail($id);
        return view('Admin.trucks.edit', compact('truck'));
    }

    public function update(Request $request, $id)
    {
        $truck = PickupTruck::findOrFail($id);

        $validated = $request->validate([
            'nama'       => 'sometimes|string',
            'plat_nomor' => 'sometimes|string|unique:pickup_truck,plat_nomor,' . $id . ',id_truck',
            'kapasitas'  => 'sometimes|integer|min:1',
            'warehouse'  => 'sometimes|string',
            'status'     => 'sometimes|in:idle,maintenance,penjemputan',
        ]);

        $truck->update($validated);

        return redirect()
            ->route('admin.trucks.index')
            ->with('success', 'Truck updated successfully.');
    }

    public function destroy($id)
    {
        $truck = PickupTruck::findOrFail($id);
        $truck->delete();
        return redirect()->route('admin.trucks.index')->with('success', 'Truck deleted successfully.');
    }
}
