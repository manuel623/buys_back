<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductService
{
    /**
     * Obtiene todos los productos
     */
    public function listProduct()
    {
        $products = Product::select('id', 'name', 'price', 'description', 'stock', 'created_at', 'updated_at')
            ->orderBy('created_at', 'desc') //responde los productos ordenados por fecha de creacion 
            ->get();
        return response()->json([
            'success' => true,
            'data' => $products
        ], 200);
    }

    /**
     * Crea un producto
     */
    public function createProduct($data)
    {
        $validator = $this->validatorProduct($data);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        try {
            DB::beginTransaction();
            $product = Product::create([
                'name' => $data->input('name'),
                'price' => $data->input('price'),
                'description' => $data->input('description'),
                'stock' => $data->input('stock'),
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Producto registrado con éxito',
                'data' => $product,
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
     * Edita un producto
     */
    public function updateProduct($data, $id)
    {
        $validator = $this->validatorProduct($data);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        try {
            DB::beginTransaction();
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Producto no encontrado'], 404);
            }

            $product->update([
                'name' => $data->input('name'),
                'price' => $data->input('price'),
                'description' => $data->input('description'),
                'stock' => $data->input('stock'),
            ]);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Producto actualizado con éxito',
                'data' => $product
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Elimina un producto
     */
    public function deleteProduct($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return response()->json(['success' => true, 'message' => 'Producto eliminado con éxito.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Producto no encontrado.'], 404);
        }
    }

    /**
     * Funcion que devuelve los 3 productos mas comprados
     */
    public function topPurchasedProducts()
    {
        $topProducts = DB::table('order_details')
            ->select('product_id', DB::raw('COUNT(*) as total_sales'))
            ->groupBy('product_id')
            ->orderByDesc('total_sales')
            ->limit(3)
            ->get();

        // trae los detalles de los productos
        $productDetails = Product::whereIn('id', $topProducts->pluck('product_id'))
            ->get()
            ->keyBy('id');

        // mapea la respuesta con las ventas incluidas
        $result = $topProducts->map(function ($item) use ($productDetails) {
            $product = $productDetails[$item->product_id] ?? null;
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'description' => $product->description,
                'stock' => $product->stock,
                'total_sales' => $item->total_sales,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $result
        ], 200);
    }

    /**
     * Validaciones a la hora de crear un nuevo producto
     */
    public function validatorProduct($data)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0'
        ];

        return Validator::make($data->all(), $rules);
    }
}
