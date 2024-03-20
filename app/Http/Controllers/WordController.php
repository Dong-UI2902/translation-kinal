<?php


namespace App\Http\Controllers;


use App\Events\WordUpdated;
use App\Http\Requests\WordRequest;
use App\Models\Word;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WordController extends Controller
{
    protected Word $word;

    public function __construct(Word $word)
    {
        $this->word = $word;
    }

    public function store(WordRequest $request): JsonResponse
    {
        $word = $this->word->create($request->only($this->getFields()));
        event(new WordUpdated($word, $request->get('posTag')));

        return response()->json($word)->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(int $wordId): JsonResponse
    {
        return response()->json($this->findById($wordId));
    }

    public function getMeanings(int $wordId): JsonResponse
    {
        $meanings = $this->findById($wordId)->meanings;

        return response()->json($meanings);
    }

    public function getPosTags(int $wordId): JsonResponse
    {
        $posTags = $this->findById($wordId)->posTags;

        return response()->json($posTags);
    }

    public function findByTextAndType(Request $request): JsonResponse
    {
        $word = $this->word->withTrashed()
            ->where($request->only(['type', 'text']))->first();

        return response()->json($word);
    }

    public function findById(int $wordId)
    {
        return $this->word->findOrFail($wordId);
    }

    public function restore(int $wordId): JsonResponse
    {
        $this->word->withTrashed()
            ->where('id', $wordId)
            ->first()
            ->restore();

        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    public function update(WordRequest $request, int $wordId): JsonResponse
    {
        $this->findById($wordId)->update($request->only($this->getFields()));

        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    public function destroy(int $wordId): JsonResponse
    {
        $this->findById($wordId)->delete();

        return response()->json()->setStatusCode(Response::HTTP_NO_CONTENT);
    }

    public function getFields(): array
    {
        return [
            'text',
            'type',
            'definition',
        ];
    }
}
