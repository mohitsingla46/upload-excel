<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\User;

class UsersController extends Controller
{
    public function upload_excel(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xls,xlsx',
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors()->first(), 'status' => 400]);
        }
        else{
            $objPHPExcel = IOFactory::load($request->file);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            foreach($sheetData as $key=>$sheet){
                if($key == 1){
                    continue; //skiping the header
                }
                $userData = [
                    'name' => $sheet['A'],
                    'email' => $sheet['B'],
                    'phone' => $sheet['C'],
                    'roll_no' => $sheet['D'],
                    'address' => $sheet['E'],
                ];
                $user_exist = User::where('email', $sheet['B'])->first();
                User::createOrUpdate($userData, $user_exist);
            }
            return response()->json(['message'=>"File has been uploaded!", 'status' => 200]);
        }
    }
}
