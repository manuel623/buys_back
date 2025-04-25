<?php

namespace App\Http\Controllers;

use App\Services\BuyerService;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    protected $buyerService;

    public function __construct(BuyerService $buyerService)
    {
        $this->buyerService = $buyerService;
    }

    public function listBuyer()
    {
        $data = $this->buyerService->listBuyer();
        return response()->json($data);
    }

    public function getBuyerByDocument($document)
    {
        $data = $this->buyerService->getBuyerByDocument($document);
        return response()->json($data);
    }

    public function createBuyer(Request $request)
    {
        $data = $this->buyerService->createBuyer($request);
        return response()->json($data);
    }

    public function editBuyer(Request $request, $id)
    {
        $data = $this->buyerService->editBuyer($request, $id);
        return response()->json($data);
    }

    public function deleteBuyer($id){
        $data = $this->buyerService->deleteBuyer($id);
        return response()->json($data);
    }
}
