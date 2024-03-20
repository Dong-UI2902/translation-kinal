<?php

namespace App\Http\Controllers;

use App\Http\Requests\SynonymRequest;
use App\Models\Chinese;
use App\Models\Vietnamese;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WordSynonymController extends Controller
{
    public function store(SynonymRequest $request): JsonResponse
    {
        $wordId = $request->get('wordId');
        $synonymId = $request->get('synonymId');
        $class = $this->getClass($request->get('type'));

        $word = app($class)->find($wordId);
        $synonym = app($class)->find($synonymId);
        if ($word && $synonym) {
            $word->syncSynonym($synonym);
        }

        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    public function show(SynonymRequest $request, int $wordId): JsonResponse
    {
        $class = $this->getClass($request->get('type'));

        $word = app($class)->find($wordId);
        $synonyms = $word->synonyms()->with('synonyms')->get();

        return response()->json($synonyms);
    }

    public function destroy(SynonymRequest $request, int $wordId): JsonResponse
    {
        $synonymId = $request->get('synonymId');
        $class = $this->getClass($request->get('type'));

        $word = app($class)->find($wordId);
        $synonym = app($class)->find($synonymId);

        $word->detachSynonym($synonym);

        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    public function getClass(string $type): string
    {
        $class = Chinese::class;
        if ($type == "vietnamese") {
            $class = Vietnamese::class;
        }

        return $class;
    }
}
