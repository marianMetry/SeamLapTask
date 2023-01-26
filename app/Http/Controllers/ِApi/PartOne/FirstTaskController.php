<?php

namespace App\Http\Controllers\ِApi\PartOne;

use App\Http\Controllers\Controller;
use App\Http\Requests\FirstRequest;
use Illuminate\Http\Request;

class FirstTaskController extends Controller
{
    public function countOfAllNum(FirstRequest $request )
    {
        // return $request;
        $start_num =$request->start_num;
        $end_num =$request->end_num;

            $count = 0;
            $result = [];

            for ($i = $start_num; $i <= $end_num; $i++) {
                if ($i % 5 != 0) {
                    $count += 1 ;
                    $result[]= $i;
                }
            }
            return response()->json([
                'status' => '200',
                'message' => 'Calculated Successfully',
                'count'=>$count,
                'result' => $result,
            ]);

    }
    public function second_task(Request $request )
    {
        $words = $request->words;
            $request = strtolower($words);
            $result = 0;
            for ($i = 0; $i < strlen($request); $i++) {
                $result *= 26;
                $result += ord($request[$i])  - 96;
            }

            return response()->json([
                'status' => '200',
                'message' => 'Calculated Successfully',
                'result' => $result,
            ]);
    
    }

}
