<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\ImageRepository;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;

class ImagesController extends Controller
{
    /**
     * @var ImageService
     */
    protected $repository;

    /**
     * @var string $modelName
     */
    private $modelName = 'Image';

    /**
     * @var string $modelNameMultiple
     */
    private $modelNameMultiple = 'Images';

    /**
     * @var ImageService
     */
    protected $service;

    /**
     * ImagesController constructor.
     * @param ImageRepository $repository
     * @param ImageService $service
     */
    public function __construct(
        ImageRepository $repository,
        ImageService $service
    ){
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Get all uploaded images
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function list()
    {
        $images = $this->repository
            ->orderBy('created_at','DESC')
            ->all();

        return response(
            $this->successResponse(
                $this->modelNameMultiple,
                $images
            )
        );
    }

    /**
     * Upload image
     *
     * @param Request $request
     * @param Logger $log
     * @return JsonResponse
     * @throws \Exception
     */
    public function upload(
        Request $request,
        Logger $log
    )
    {
        $model = $this->service->upload($request->all());

        if ($model){
            $message = $this->modelName .' was successfully stored.';
            $log->info($message, ['id' => $model->id]);
            $data = ['location' => $model->file];
        } else {
            $message = $this->modelName.' was not stored.';
            $log->error($message);
            $data = $this->errorResponse($this->modelName, null, $message);
        }

        return response()->json($data);
    }

}
