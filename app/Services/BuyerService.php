<?php

namespace App\Services;

use App\Models\Buyer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BuyerService
{

    public function listBuyer()
    {
        $buyer = DB::table("buyers")->get();
        return response()->json([
            'success' => true,
            'data' => $buyer
        ],200);
    }

    public function getBuyerByDocument($document)
    {
        $buyer = Buyer::where('document', $document)->first();

        if ($buyer) {
            return response()->json([
                'success' => true,
                'data' => $buyer
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => "No se encontro un comprador con este numero de documento"
            ],404);
        }
    }

    public function createBuyer($data)
    {
        $validator = $this->validatorBuyer($data);
        if($validator->fails()){
            return response()->json(['success' => false, 'errors' => $validator->errors()],400);
        }
        try {
            DB::beginTransaction();
            $buyer = Buyer::create([
                'phone' => $data->input('phone'),
                'document' => $data->input('document'),
                'first_name' => $data->input('first_name'),
                'second_name' => $data->input('second_name'),
                'first_last_name' => $data->input('first_last_name'),
                'second_last_name' => $data->input('second_last_name'),
                'email' => $data->input('email'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Comprador registrado con éxito',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ],500);
        }
    }

    public function editBuyer($data, $id)
    {
        $validator = $this->validatorBuyer($data);
        
        if($validator->fails()){
            return response()->json(['success' => false, 'errors' => $validator->errors()],400);
        }
        try {
            DB::beginTransaction();
            $lottery = Buyer::find($id);
            if(!$lottery){
                return response()->json([
                    'success' => false,
                    'message' => 'Comprador no encontrado.'
                ], 404);
            }

            $lottery ->update([
                'phone' => $data->input('phone'),
                'document' => $data->input('document'),
                'first_name' => $data->input('first_name'),
                'second_name' => $data->input('second_name'),
                'first_last_name' => $data->input('first_last_name'),
                'second_last_name' => $data->input('second_last_name'),
                'email' => $data->input('email'),
                'updated_at' => now(),
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Comprador actualizado con éxito',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ],500);
        }   
    }

    public function deleteBuyer($phone)
    {
        $buyer = Buyer::find($phone);

        if ($buyer) {
            $buyer->delete();
            return response()->json(['success' => true, 'message' => 'Comprador eliminado con éxito.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Comprador no encontrado.'], 404);
        }
    }

    public function validatorBuyer($data)
    {
        $rules = [
            'document' => 'required|string',
            'first_name' => 'required|string',
        ];

        $messages = [
            'document.required' => 'El número de documento es obligatorio.',
            'first_name.required' => 'El nombre es obligatorio.',
        ];

        return Validator::make($data->all(), $rules, $messages);
    }

}