<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Models;
use Ramsey\Uuid\Type\Integer;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Device::all();
        $models = Models::all();
        $devices = Device::all();

        foreach ($items as $item) {
            $item['model'] = Models::where('id', $item['model_id'])->value('name');
        }
        foreach ($devices as $device) {
            $device['modelName'] = Models::where('id', $device['model_id'])->value('name');
        }
        $deviceTypes = Device::distinct()->pluck('type');
        return Inertia::render('Index', [
            'items' => $items,
            'titulo' => 'Dispositivos',
            'tableName' => 'device',
            'devices' => $devices,
            'models' => $models,
            'deviceTypes' => $deviceTypes
        ]);
    }

    public function indexUser()
    {
        $items = Device::all();
        $models = Models::all();
        $devices = Device::all();

        foreach ($items as $item) {
            $item['model'] = Models::where('id', $item['model_id'])->value('name');
        }
        foreach ($devices as $device) {
            $device['modelName'] = Models::where('id', $device['model_id'])->value('name');
        }
        $deviceTypes = Device::distinct()->pluck('type');
        return Inertia::render('Catalogue', [
            'items' => $items,
            'titulo' => 'Dispositivos',
            'tableName' => 'device',
            'devices' => $devices,
            'models' => $models,
            'deviceTypes' => $deviceTypes
        ]);
    }

    public function indexUserFilter($id)
    {
        $items = Device::where('model_id', $id)->get();
        $models = Models::all();
        $devices = Device::all();

        foreach ($items as $item) {
            $item['model'] = Models::where('id', $item['model_id'])->value('name');
        }
        foreach ($devices as $device) {
            $device['modelName'] = Models::where('id', $device['model_id'])->value('name');
        }
        $deviceTypes = Device::distinct()->pluck('type');
        return Inertia::render('Catalogue', [
            'items' => $items,
            'titulo' => 'Dispositivos',
            'tableName' => 'device',
            'devices' => $devices,
            'models' => $models,
            'deviceTypes' => $deviceTypes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // Valida y guarda el nuevo modelo
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'model_id' => 'required|int|max:11',
            'reference' => 'required|string|max:255',
            // Agrega más validaciones según tus necesidades
        ]);
        Device::create($validatedData);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Device $device)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Device $device)
    {
        // // Validar los datos del formulario
        $validatedData = $request->validate([
            // Agrega aquí las validaciones para los campos que necesites
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'reference' => 'required|string|max:255',
            'model_id' => 'required',
        ]);
        // Actualizar el dispositivo con los datos del formulario
        $device->update($validatedData);
        // Redirigir de vuelta a la página anterior o a la ruta deseada
        return redirect()->back()->with('success', 'Dispositivo actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        //
        $device->delete();
        return redirect()->back();
    }
}
