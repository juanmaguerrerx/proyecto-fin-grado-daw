<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Models;
use App\Models\Reparation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReparationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $items = Reparation::all(); // Obtener todas las órdenes de reparación
        foreach ($items as $item) {
            $deviceName = Device::where('id', $item['device_id'])->value('name');
            $deviceId = Device::where('id', $item['device_id'])->value('model_id');
            $model = Models::where('id', $deviceId)->value('name');
            $item['name'] = $item['reparation_type'] . " " . $model . " " . $deviceName;
        }
        $devices = Device::all();
        foreach ($devices as $device) {
            $model = Models::where('id', $device['model_id'])->value('name');
            $device['modelName'] = ($model . " " . $device['name']);
        }
        $deviceTypes = Device::distinct()->pluck('type');
        $reparationTypes = Reparation::distinct()->pluck('reparation_type');
        $models = Models::all();
        return Inertia::render('Index', [
            'items' => $items,
            'devices' => $devices,
            'titulo' => 'Reparaciones',
            'tableName' => 'reparation',
            'deviceTypes' => $deviceTypes,
            'reparationTypes' => $reparationTypes,
            'models' => $models
        ]);
    }

    public function indexUser()
    {
        //
        $items = Reparation::all(); // Obtener todas las órdenes de reparación
        foreach ($items as $item) {
            $deviceName = Device::where('id', $item['device_id'])->value('name');
            $deviceId = Device::where('id', $item['device_id'])->value('model_id');
            $model = Models::where('id', $deviceId)->value('name');
            $item['name'] = $item['reparation_type'] . " " . $model . " " . $deviceName;
            $item['type'] = Device::where('id', $item['device_id'])->value('type');
        }
        $devices = Device::all();
        foreach ($devices as $device) {
            $model = Models::where('id', $device['model_id'])->value('name');
            $device['modelName'] = ($model . " " . $device['name']);
        }
        $deviceTypes = Device::distinct()->pluck('type');
        $reparationTypes = Reparation::distinct()->pluck('reparation_type');
        $models = Models::all();
        return Inertia::render('Catalogue', [
            'items' => $items,
            'devices' => $devices,
            'titulo' => 'Reparaciones',
            'tableName' => 'reparation',
            'deviceTypes' => $deviceTypes,
            'reparationTypes' => $reparationTypes,
            'models' => $models
        ]);
    }

    public function indexUserFilter($id)
    {
        $items = Reparation::where('device_id', $id)->get(); // Obtener todas las órdenes de reparación
        foreach ($items as $item) {
            $deviceName = Device::where('id', $item['device_id'])->value('name');
            $deviceId = Device::where('id', $item['device_id'])->value('model_id');
            $model = Models::where('id', $deviceId)->value('name');
            $item['name'] = $item['reparation_type'] . " " . $model . " " . $deviceName;
            $item['type'] = Device::where('id', $item['device_id'])->value('type');
        }
        $devices = Device::all();
        foreach ($devices as $device) {
            $model = Models::where('id', $device['model_id'])->value('name');
            $device['modelName'] = ($model . " " . $device['name']);
        }
        $deviceTypes = Device::distinct()->pluck('type');
        $reparationTypes = Reparation::distinct()->pluck('reparation_type');
        $models = Models::all();
        return Inertia::render('Catalogue', [
            'items' => $items,
            'devices' => $devices,
            'titulo' => 'Reparaciones',
            'tableName' => 'reparation',
            'deviceTypes' => $deviceTypes,
            'reparationTypes' => $reparationTypes,
            'models' => $models
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
            'device_id' => 'required|int',
            'reparation_type' => 'required|string|max:255',
            'price' => 'required|numeric'
            // Agrega más validaciones según tus necesidades
        ]);
        Reparation::create($validatedData);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $deviceId = Reparation::where('id', $id)->value('device_id');
        $deviceType = Device::where('id', $deviceId)->value('type');
        $deviceName = Device::where('id', $deviceId)->value('name');
        $modelId = Device::where('id', $deviceId)->value('model_id');
        $model = Models::where('id', $modelId)->value('name');
        $reparationType = Reparation::where('id', $id)->value('reparation_type');
        $item = Reparation::where('id', $id)->first(); // Cambiar a first() para obtener el primer registro como un objeto
        $titulo = $reparationType . " " . $model . " " . $deviceName;
        return Inertia::render('Reparation', [
            'item' => $item,
            'name' => $titulo,
            'titulo' => $titulo,
            'deviceType' => $deviceType, // Asegurarse de que deviceType está incluido
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reparation $reparation)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reparation $reparation)
    {
        //
        $validatedData = $request->validate([
            'device_id' => 'required|int',
            'reparation_type' => 'required|string|max:255',
            'price' => 'required|numeric'
            // Agrega más validaciones según tus necesidades
        ]);
        $reparation->update($validatedData);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reparation $reparation)
    {
        //
        $reparation->delete();
        return redirect()->back();
    }
}
