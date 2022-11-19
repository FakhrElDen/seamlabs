<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProblemSolvingController extends Controller
{
    public function problemOne(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_number'     => ['required', 'numeric', 'lt:end_number'],
            'end_number'       => ['required', 'numeric', 'gt:start_number'],
        ]);

        if ($validator->fails()) {
            return $validator->messages();
        }

        $request->merge([
            'start_number'  => abs($request->start_number),
            'end_number'    => abs($request->end_number),
        ]);

        $result = 0;

        for ($i = $request->start_number; $i <= $request->end_number; $i++) {
            if (!$this->checkNumberHasFive($i)) {
                $result++;
            }
        }

        $response['Result'] = $result;
        return response()->json($response);
    }

    protected function checkNumberHasFive($number)
    {
        $arrofNum = str_split(strval($number));
        foreach ($arrofNum as $value) {
            if ($value == 5) {
                return true;
            }
        }
        return false;
    }

    public function problemTwo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'input_string'     => ['required', 'string', 'max:3'],
        ]);

        if ($validator->fails()) {
            return $validator->messages();
        }

        $request->merge([
            'input_string'  => strtoupper($request->input_string),
        ]);

        $alphabets_num = 26;

        if (strlen($request->input_string) == 1) {
            $result = $this->getLetterValue($request->input_string);
            $response['OUTPUT'] = $result;
            return response()->json($response);

        } elseif (strlen($request->input_string) == 2) {
            $result = $alphabets_num + ($alphabets_num * ($this->getLetterValue($request->input_string[0]) - 1)) + $this->getLetterValue($request->input_string[1]);
            $response['OUTPUT'] = $result;
            return response()->json($response);

        } elseif (strlen($request->input_string) == 3) {
            $result = ($alphabets_num * $alphabets_num) + $alphabets_num
            + (($alphabets_num * $alphabets_num) * ($this->getLetterValue($request->input_string[0]) - 1)) 
            + ($alphabets_num * ($this->getLetterValue($request->input_string[1]) - 1)) 
            + $this->getLetterValue($request->input_string[2]);
            $response['OUTPUT'] = $result;
            return response()->json($response);
        }
    }

    protected function getLetterValue($letter)
    {
        $alphabets = [ 
            "A" => 1, "B" => 2, "C" => 3, "D" => 4, "E" => 5, "F" => 6, "G" => 7, "H" => 8, "I" => 9, "J" => 10, "K" => 11, "L" => 12, "M" => 13,
            "N" => 14, "O" => 15, "P" => 16, "Q" => 17, "R" => 18, "S" => 19, "T" => 20, "U" => 21, "V" => 22, "W" => 23, "X" => 24, "Y" => 25, "Z" => 26
        ];
        foreach ($alphabets as $key => $value) {
            if ($key == $letter) {
                return $value;
            } 
        }
    }

    public function problemThree(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Q.*' => ['required', 'numeric', 'between:1,10000'],
        ]);

        if ($validator->fails()) {
            return $validator->messages();
        }
        
        $result = [];
        foreach ($request->Q as $key => $num) {
            $result[$key] = $this->reduceNumbertoZero($num);
        }
        $response['OUTPUT'] = $result;
        return response()->json($response);
    }

    protected function reduceNumbertoZero($num) 
    {
        $steps = 0;
        while (0 < $num) {
            if($num % 2 == 0){
                $num = $num - ($num / 2);
                $steps++;
            } elseif ($num % 3 == 0) {
                $num = $num - ($num / 3);
                $steps++;
            } elseif ($num % 5 == 0) {
                $num = $num - ($num / 5);
                $steps++;
            } else {
                $num--;
                $steps++;
            }
        }
        return $steps;
    } 
}
