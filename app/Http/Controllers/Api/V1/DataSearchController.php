<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\DataResource;
use App\Services\Search\DataService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DataSearchController extends Controller
{
    /**
     * DataSearchController constructor.
     * @param DataService $dataService
     */
    public function __construct(private DataService $dataService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = DataResource::collection(
            $this->dataService->search($request->all())
        );

        return response()->json([
            'success' => true,
            'result' => $data
        ], Response::HTTP_OK);
    }
}
