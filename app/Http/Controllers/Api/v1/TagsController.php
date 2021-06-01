<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Repositories\Contracts\TagRepository;
use App\Services\Contracts\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;

class TagsController extends Controller
{
    /**
     * @var TagRepository $repository
     */
    protected $repository;

    /**
     * @var string $modelName
     */
    private $modelName = 'Tag';

    /**
     * @var string $modelNameMultiple
     */
    private $modelNameMultiple = 'Tags';
    /**
     * @var TagService $service
     */
    protected $service;

    /**
     * TagController constructor.
     * @param TagRepository $repository
     * @param TagService $service
     */
    public function __construct(
        TagRepository $repository,
        TagService $service
    ){
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index()
    {
        return response(
            $this->successResponse(
                $this->modelNameMultiple,
                $this->repository->all()
            )
        );
    }

    /**
     * Show one tag data
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $model = $this->repository->find($id);
        $data = $this->successResponse($this->modelName, $model);
        return response()->json(array_merge($data, [
            'code' => 20000
        ]));
    }

}
