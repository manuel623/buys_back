<?php

namespace App\Services;

use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OrderDetailService
{
    /**
     * Obtiene todos los detalles
     */
    public function listOrderDetail()
    {
        $orders = OrderDetail::select('id', 'order_id', 'product_id', 'quantity', 'unit_price', 'subtotal', 'created_at', 'updated_at')
            ->with('order', 'product') // carga las relaciones con las demas tablas
            ->orderBy('created_at', 'desc') // ordena los detalles por fecha de creación
            ->get();
        return response()->json([
            'success' => true,
            'data' => $orders
        ], 200);
    }

    /**
     * Crea nuevos detalles
     */
    public function createOrderDetail($data)
    {
        $validator = $this->validatorOrderDetail($data);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        try {
            DB::beginTransaction();
            $subtotal = $data->input('quantity') * $data->input('unit_price');
            $orderDetail = OrderDetail::create([
                'order_id' => $data->input('order_id'),
                'product_id' => $data->input('product_id'),
                'quantity' => $data->input('quantity'),
                'unit_price' => $data->input('unit_price'),
                'subtotal' => $subtotal,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Detalle de orden registrado con éxito',
                'data' => $orderDetail,
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
     * Edita los detalles
     */
    public function updateOrderDetail($data, $id)
    {
        $validator = $this->validatorOrderDetail($data);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        try {
            DB::beginTransaction();
            $orderDetail = OrderDetail::find($id);

            if (!$orderDetail) {
                return response()->json(['success' => false, 'message' => 'Detalle de orden no encontrado'], 404);
            }
            $subtotal = $data->input('quantity') * $data->input('unit_price');
            $orderDetail->update([
                'order_id' => $data->input('order_id'),
                'product_id' => $data->input('product_id'),
                'quantity' => $data->input('quantity'),
                'unit_price' => $data->input('unit_price'),
                'subtotal' => $subtotal,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Detalle de orden actualizado con éxito',
                'data' => $orderDetail
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Elimina los detalles
     */
    public function deleteOrderDetail($id)
    {
        $orderDetail = OrderDetail::find($id);

        if ($orderDetail) {
            $orderDetail->delete();
            return response()->json(['success' => true, 'message' => 'Detalle de orden eliminado con éxito.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Detalle de orden no encontrado.'], 404);
        }
    }

    /**
     * Validaciones a la hora de crear o actualizar una detalle
     */
    public function validatorOrderDetail($data)
    {
        $rules = [
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
        ];

        return Validator::make($data->all(), $rules);
    }
}
