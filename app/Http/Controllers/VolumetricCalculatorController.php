<?php

namespace App\Http\Controllers;

use App\Models\Calculator;
use Illuminate\Http\Request;

class VolumetricCalculatorController extends Controller
{
    public function volumetricCalculator()
    {
        return view('calculator');
    }

    public function subCalculator(Request $request)
    {
        $data = $request->all();
        // dd($data);

        $volumetricWeight = 0;
        $createData = new Calculator();
        $createData->conversion_type = $data['selectedUnit'];
        $createData->length = $data['length'];
        $createData->width = $data['width'];
        $createData->heigth = $data['heigth'];
        $createData->quantity = $data['quantity'];

        if ($data['selectedUnit'] === 'kg') {
            $volumetricWeight = ($data['length'] * $data['width'] * $data['heigth'] * $data['quantity']) / 6000;
        } else {
            $volumetricWeight = ($data['length'] * $data['width'] * $data['heigth'] * $data['quantity']) / 166;
        }
        $createData->volume = $volumetricWeight;
        $createData->save();
        if($createData){
            return response()->json(['status' => true, 'data' => $createData]);
        }else{
            return response()->json(['status' => false, 'message' => 'Something went wrong']);
        }
    }
}
