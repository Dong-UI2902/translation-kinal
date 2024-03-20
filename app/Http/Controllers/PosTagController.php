<?php


namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PosTagController extends Controller
{
    public function index(): JsonResponse
    {
        $posTags = DB::table('word_pos_tags')->get();

        return response()->json($posTags);
    }
}
