<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    /**
     * Instancia el servicio ProductService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /** 
     * Funcion para listar los productos 
     */
    public function listProduct()
    {
        $data = $this->productService->listProduct();
        return response()->json($data);
    }

    /** 
     * Funcion para crear los productos 
     */
    public function createProduct(Request $request)
    {
        $data = $this->productService->createProduct($request);
        return response()->json($data);
    }

    /** 
     * Funcion para editar los productos 
     */
    public function updateProduct(Request $request, $id)
    {
        $data = $this->productService->updateProduct($request, $id);
        return response()->json($data);
    }

    /**
     * funcacion para actualizar el stock
     */
    public function updateStock(Request $request, $id)
    {
        $data = $this->productService->updateStock($request, $id);
        return response()->json($data);
    }

    /** 
     * Funcion para eliminar los productos 
     */
    public function deleteProduct($id)
    {
        $data = $this->productService->deleteProduct($id);
        return response()->json($data);
    }

    /**
     * Funcion que devuelve los 3 productos mas comprados
     */
    public function topPurchasedProducts()
    {
        $data = $this->productService->topPurchasedProducts();
        return response()->json($data);
    }
}
