<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    /**
     * Instancia el servicio OrderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /** 
     * Funcion para listar ordenes 
     */
    public function listOrder()
    {
        $data = $this->orderService->listOrder();
        return response()->json($data);
    }

    /** 
     * Funcion para crear ordenes
     */
    public function createOrder(Request $request)
    {
        $data = $this->orderService->createOrder($request);
        return response()->json($data);
    }

    /** 
     * Funcion para editar ordenes 
     */
    public function updateOrder(Request $request, $id)
    {
        $data = $this->orderService->updateOrder($request, $id);
        return response()->json($data);
    }

    /** 
     * Funcion para eliminar ordenes 
     */
    public function deleteOrder($id)
    {
        $data = $this->orderService->deleteOrder($id);
        return response()->json($data);
    }
}
