<?php

namespace App\Http\Controllers;

use App\Services\OrderDetailService;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    protected $orderDetailService;

    /**
     * Instancia el servicio OrderDetailsService
     */
    public function __construct(OrderDetailService $orderDetailService)
    {
        $this->orderDetailService = $orderDetailService;
    }

    /** 
     * Funcion para listar los detalles de la orden
     */
    public function listOrderDetail()
    {
        $data = $this->orderDetailService->listOrderDetail();
        return response()->json($data);
    }

    /** 
     * Funcion para crear detalles de cada orden 
     */
    public function createOrderDetail(Request $request)
    {
        $data = $this->orderDetailService->createOrderDetail($request);
        return response()->json($data);
    }

    /** 
     * Funcion para editar los detalles de las ordenes 
     */
    public function updateOrderDetail(Request $request, $id)
    {
        $data = $this->orderDetailService->updateOrderDetail($request, $id);
        return response()->json($data);
    }

    /** 
     * Funcion para eliminar los detalles de las ordenes
     */
    public function deleteOrderDetail($id)
    {
        $data = $this->orderDetailService->deleteOrderDetail($id);
        return response()->json($data);
    }
}
