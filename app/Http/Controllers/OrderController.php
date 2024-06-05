<?php

namespace App\Http\Controllers;

use App\Mail\OrderAdminCreated;
use App\Mail\OrderCreated;
use App\Mail\OrderModified;
use App\Models\Device;
use App\Models\Models;
use App\Models\Order;
use App\Models\Reparation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

use function Laravel\Prompts\select;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $orders = Order::all(); // Obtener todas las órdenes de reparación
        // foreach ($orders as $order){
        //     $order['userName'] = User::where('id',$order['user_id'])->value('name');    
        // }

        $orders = Order::with(['reparation.device.model'])->get();
        foreach ($orders as $order) {
            $order['userName'] = User::where('id', $order['user_id'])->value('name');
        }

        $ordersData = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'userName' => $order->userName,
                'user_id' => $order->user_id,
                'order_date' => $order->order_date,
                'status' => $order->status,
                'reparation_date' => $order->reparation_date,
                'reparation_info' => [
                    'reparation_id' => $order->reparation_id,
                    'type' => $order->reparation->reparation_type,
                    'device' => $order->reparation->device->name,
                    'model' => $order->reparation->device->model->name,
                    'price' => $order->reparation->price,
                ],
            ];
        });

        $reparations = Reparation::all();
        foreach ($reparations as $reparation) {
            $deviceModelId = Device::where('id', $reparation['device_id'])->value('model_id');
            $deviceName = Device::where('id', $reparation['device_id'])->value('name');
            $modelName = Models::where('id', $deviceModelId)->value('name');
            $reparation['name'] = $reparation['reparation_type'] . " " . $modelName . " " . $deviceName;
        }
        $users = User::where('admin', 0)->get();
        return inertia('Orders', [
            'titulo' => 'Órdenes',
            'orders' => $ordersData,
            'tableName' => 'order',
            'users' => $users,
            'reparations' => $reparations,
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
            'user_id' => 'required|int',
            'reparation_id' => 'required|int',
            'order_date' => 'required|date',
            'status' => 'required|string|max:255',
            'reparation_date' => 'nullable',
            // Agrega más validaciones según tus necesidades
        ]);
        Order::create($validatedData);

        return redirect()->back();
    }

    public function storeUser(Request $request)
    {
        // Valida y guarda la nueva orden
        $validatedData = $request->validate([
            'user_id' => 'required|int',
            'reparation_id' => 'required|int',
            'order_date' => 'required|date',
            'status' => 'required|string|max:255',
            'reparation_date' => 'nullable|date',
        ]);

        $order = Order::create($validatedData);

        // Obtén el cliente y el administrador
        $client = User::findOrFail($order->user_id);
        $admin = User::where('admin', 1)->first(); // Suponiendo que solo hay un administrador

        // Envía el correo electrónico al cliente
        Mail::to($client->email)->send(new OrderCreated($order));

        // Envía el correo electrónico al administrador
        Mail::to('tecnoinformaticahuelva@gmail.com')->send(new OrderAdminCreated($order, $client));

        return redirect()->back()->with('success', 'Orden creada con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $mail = false;
        $order = Order::findOrFail($request->id);
        $client = User::findOrFail($order->user_id);

        if($request->status != $order->status){
            $mail = true;
        }

        $order->update([
            'user_id' => $request->user_id,
            'status' => $request->status,
            'order_date' => $request->order_date,
            'reparation_date' => $request->reparation_date,
            'reparation_id' => $request->reparation_info['reparation_id'],
        ]);

        if($mail){
            Mail::to($client->email)->send(new OrderModified($order));
        }

        return redirect()->back()->with('success', 'Orden actualizada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
        $order->delete();
        return redirect()->back();
    }

}
