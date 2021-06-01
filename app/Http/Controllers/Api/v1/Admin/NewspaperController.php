<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newspaper;
use App\Presenters\NewspaperDetailPresenter;
use App\Presenters\NewspaperEditDataPresenter;
use App\Presenters\NewspaperPresenter;
use App\Repositories\Contracts\NewspaperRepository;
use App\Services\Contracts\NewspaperService;
use App\Services\Contracts\TelegramService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;

class NewspaperController extends Controller
{
    /**
     * @var NewspaperRepository $repository
     */
    protected $repository;

    /**
     * @var string $modelName
     */
    private $modelName = 'Newspaper';

    /**
     * @var string $modelNameMultiple
     */
    private $modelNameMultiple = 'Newspaper';
    /**
     * @var NewspaperService $service
     */
    protected $service;

    /**
     * @var TelegramService
     */
    private $telegramService;

    /**
     * NewspaperController constructor.
     * @param NewspaperRepository $repository
     * @param NewspaperService $service
     * @param TelegramService $telegramService
     */
    public function __construct(
        NewspaperRepository $repository,
        NewspaperService $service,
        TelegramService $telegramService
    ) {
        $this->repository = $repository;
        $this->service = $service;
        $this->telegramService = $telegramService;
    }

    /**
     * Newspaper list
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = $request->all();

        $status = array_get($data, 'type');
        if ($status) {
            $filterStatus = explode(',', $status);
        } else {
            $filterStatus = ['REVIEWS', 'SERVICE', 'CONTENT', 'SOLUTION', 'QUESTION', 'PROJECT', 'ADVANTAGE'];
        }

        $limit = array_get($data, 'limit', Newspaper::count());
        $sort = array_get($data, 'sort');
        $sortDirection = $sort == '-id' ? 'ASC' : 'DESC';
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $newspaper = $this->repository->statusesScope($filterStatus)->orderBy('created_at', $sortDirection)->setPresenter(NewspaperPresenter::class)->paginate($limit);

        return response(
            $this->successResponse(
                $this->modelNameMultiple,
                $newspaper
            )
        );
    }

    /**
     * Create a new newspaper
     *
     * @param Request $request
     * @param Logger $log
     * @return JsonResponse
     */
    public function store(
        Request $request,
        Logger $log
    )
    {
        $model = $this->service->store($request->all());

        if ($model){
            $message = $this->modelName .' was successfully stored.';
            $log->info($message, ['id' => $model->id]);
            $newspaper = $this->successResponse($this->modelName, $model, $message);
        } else {
            $message = $this->modelName.' was not stored.';
            $log->error($message);
            $newspaper = $this->errorResponse($this->modelName, null, $message);
        }


        return response()->json(array_merge($newspaper, [
            'code' => 20000,
        ]));
    }

    /**
     * Update a newspaper
     *
     * @param Request $request
     * @param Logger $log
     *
     * @return JsonResponse
     */
    public function update(
        Request $request,
        Logger $log
    )
    {
        $id = $request->input('id');
        $model = $this->service->update($id, $request->all());

        if ($model){
            $message = $this->modelName .' was successfully updated.';
            $log->info($message, ['id' => $id]);
            $newspaper = $this->successResponse($this->modelName, $model, $message);
        } else {
            $message = $this->modelName.' was not updated.';
            $log->error($message);
            $newspaper = $this->errorResponse($this->modelName, null, $message);
        }

        return response()->json(array_merge($newspaper, [
            'code' => 20000,
        ]));
    }

    /**
     * Show newspaper
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function show($id)
    {
        $article = $this->repository
            ->setPresenter(NewspaperDetailPresenter::class)
            ->find($id);

        return response()->json(array_merge($article, [
            'code' => 20000,
        ]));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function editData($id)
    {
        $newspaper = $this->repository
            ->setPresenter(NewspaperEditDataPresenter::class)
            ->find($id);

        return response()->json(array_merge($newspaper, [
            'code' => 20000,
        ]));
    }


    /**
     * Change status article
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function changeStatus($id, Request $request)
    {
        $data = $request->all();
        $status = array_get($data, 'status', 0);
        $newspaper = $this->repository->find($id);
        $newspaper->status = $status;
        $response = $this->successResponse($this->modelName, $newspaper->save());
        return response()->json(array_merge($response, ['code' => 20000]));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function toDraft($id)
    {
        $newspaper = $this->repository->find($id);
        $newspaper->status = 0;
        if ($newspaper->save()) {
            $code = 20000;
        } else {
            $code = 50000;
        }
        return response()->json([
            'code' => $code,
            'message' => 'Gazeta aktiv emas holatga o`tkazildi'
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function toActivate($id)
    {
        $newspaper = $this->repository->find($id);
        $newspaper->status = 1;
        if ($newspaper->save()) {
            $code = 20000;
        } else {
            $code = 50000;
        }
        return response()->json([
            'code' => $code,
            'message' => 'Gazeta aktivlashtirildi'
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function toArchive($id)
    {
        $newspaper = $this->repository->find($id);
        $newspaper->status = 1;
        if ($newspaper->save()) {
            $code = 20000;
        } else {
            $code = 50000;
        }
        return response()->json([
            'code' => $code,
            'message' => 'Gazeta arxivga o`tkazildi'
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function sendToTelegram($id)
    {
        /** @var Newspaper $newspaper */
        $newspaper = $this->repository->find($id);

        $this->telegramService->sendDocumentChannel(
            $newspaper->file,
            $newspaper->title,
            $newspaper->number
        );

        return response()->json([
            'code' => 20000,
            'message' => 'Yangilik aktiv emas holatga o`tkazildi'
        ]);
    }

    /**
     * Delete item
     *
     * @param $id
     * @param Logger $log
     *
     * @return JsonResponse
     */
    public function delete(
        $id,
        Logger $log
    )
    {
        $model = $this->service->delete($id);

        if ($model){
            $message = $this->modelName . ' was successfully deleted.';
            $log->info($message, ['id' => $id]);
            $data = $this->successResponse($this->modelName, $model, $message);
        } else {
            $message = $this->modelName . ' was not deleted.';
            $log->error($message);
            $data = $this->errorResponse($this->modelName, null, $message);
        }

        return response()->json(array_merge($data, [
            'code' => 20000
        ]));
    }

}
