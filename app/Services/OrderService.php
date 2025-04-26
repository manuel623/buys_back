<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderService
{
    /**
     * Obtiene todas las ordenes
     */
    public function listOrder()
    {
        $orders = Order::select('id', 'total', 'description', 'billing_date', 'payment_method', 'created_at', 'updated_at')
            ->orderBy('created_at', 'desc') // responde las ordenes ordenadas por fecha de creación
            ->get();
        return response()->json([
            'success' => true,
            'data' => $orders
        ], 200);
    }

    /**
     * Crea una orden
     */
    public function createOrder($data)
    {
        $validator = $this->validatorOrder($data);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        try {
            DB::beginTransaction();
            $order = Order::create([
                'total' => $data->input('total'),
                'description' => $data->input('description'),
                'billing_date' => $data->input('billing_date'),
                'payment_method' => $data->input('payment_method')
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Orden registrada con éxito',
                'data' => $order,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Edita una orden
     */
    public function updateOrder($data, $id)
    {
        $validator = $this->validatorOrder($data);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        try {
            DB::beginTransaction();
            $order = Order::find($id);

            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Orden no encontrada'], 404);
            }
            $order->update([
                'total' => $data->input('total'),
                'description' => $data->input('description'),
                'billing_date' => $data->input('billing_date'),
                'payment_method' => $data->input('payment_method')
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Orden actualizada con éxito',
                'data' => $order
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Elimina una orden
     */
    public function deleteOrder($id)
    {
        $order = Order::find($id);

        if ($order) {
            $order->delete();
            return response()->json(['success' => true, 'message' => 'Orden eliminada con éxito.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Orden no encontrada.'], 404);
        }
    }

    /**
     * Validaciones a la hora de crear o actualizar una orden
     */
    public function validatorOrder($data)
    {
        $rules = [
            'total' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'billing_date' => 'required|date',
            'payment_method' => 'required|string|max:255'
        ];

        return Validator::make($data->all(), $rules);
    }
}