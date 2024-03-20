<?php

namespace App\Http\Controllers\Translation;

use App\Contracts\DictionaryContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\DictionaryRequest;
use App\Models\Chinese;
use App\Models\Vietnamese;
use App\Traits\DictionaryTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DictionaryController extends Controller implements DictionaryContract
{
    use DictionaryTrait;

    public function store(DictionaryRequest $request): JsonResponse
    {
        $word = Chinese::firstOrCreate($request->get('chinese'));
        $meaning = Vietnamese::firstOrCreate($request->get('vietnamese'));
        $posTag = $request->get('posTag');

        $this->saveDictionary($word, $meaning, $posTag);

        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
