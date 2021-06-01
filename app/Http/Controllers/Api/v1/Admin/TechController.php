<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Tech;
use App\Presenters\TechDetailPresenter;
use App\Presenters\TechEditDataPresenter;
use App\Presenters\TechPresenter;
use App\Repositories\Contracts\TechRepository;
use App\Services\Contracts\TelegramService;
use App\Services\Contracts\TechService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;

class TechController extends Controller
{
    /**
     * @var TechRepository $repository
     */
    protected $repository;

    /**
     * @var TelegramService
     */
    private $telegramService;

    /**
     * @var string $modelName
     */
    private $modelName = 'Tech';

    /**
     * @var string $modelNameMultiple
     */
    private $modelNameMultiple = 'Techs';
    /**
     * @var TechService $service
     */
    protected $service;

    /**
     * TechController constructor.
     * @param TechRepository $repository
     * @param TechService $service
     */
    public function __construct(
        TechRepository $repository,
        TechService $service,
        TelegramService $telegramService
    )
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->telegramService = $telegramService;
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function sendToTelegram($id)
    {
        /** @var Tech $tech */
        $tech = $this->repository->find($id);

        $this->telegramService->sendTechChannel(
            $tech->link,
            $tech->title
        );

        return response()->json([
            'code' => 20000,
            'message' => 'Yangilik aktiv emas holatga o`tkazildi'
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $limit = array_get($data, 'limit', 20);
        $sort = array_get($data, 'sort');
        $sortDirection = $sort == '-id' ? 'ASC' : 'DESC';
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $techs = $this->repository->orderBy('created_at', $sortDirection)->setPresenter(TechPresenter::class)->paginate($limit);

        return response(
            $this->successResponse(
                $this->modelNameMultiple,
                $techs
            )
        );
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
        $tech = $this->repository->find($id);
        $tech->status = $status;
        $response = $this->successResponse($this->modelName, $tech->save());
        return response()->json(array_merge($response, ['code' => 20000]));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function toDraft($id)
    {
        $article = $this->repository->find($id);
        $article->status = 0;
        if ($article->save()) {
            $code = 20000;
        } else {
            $code = 50000;
        }
        return response()->json([
            'code' => $code,
            'message' => 'Tech aktiv emas holatga o`tkazildi'
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function toActivate($id)
    {
        $article = $this->repository->find($id);
        $article->status = 1;
        if ($article->save()) {
            $code = 20000;
        } else {
            $code = 50000;
        }
        return response()->json([
            'code' => $code,
            'message' => 'Tech aktivlashtirildi'
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function toArchive($id)
    {
        $article = $this->repository->find($id);
        $article->status = 1;
        if ($article->save()) {
            $code = 20000;
        } else {
            $code = 50000;
        }
        return response()->json([
            'code' => $code,
            'message' => 'Tech arxivga o`tkazildi'
        ]);
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

        if ($model) {
            $message = $this->modelName . ' was successfully stored.';
            $log->info($message, ['id' => $model->id]);
            $data = $this->successResponse($this->modelName, $model, $message);
        } else {
            $message = $this->modelName . ' was not stored.';
            $log->error($message);
            $data = $this->errorResponse($this->modelName, null, $message);
        }

        return response()->json(array_merge($data, [
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

        if ($model) {
            $message = $this->modelName . ' was successfully updated.';
            $log->info($message, ['id' => $id]);
            $data = $this->successResponse($this->modelName, $model, $message);
        } else {
            $message = $this->modelName . ' was not updated.';
            $log->error($message);
            $data = $this->errorResponse($this->modelName, null, $message);
        }

        return response()->json(array_merge($data, [
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
        $tech = $this->repository
            ->setPresenter(TechDetailPresenter::class)
            ->find($id);

        return response()->json(array_merge($tech, [
            'code' => 20000,
        ]));
    }


    /**
     * @param $id
     * @return JsonResponse
     */
    public function editData($id)
    {
        $tech = $this->repository
            ->setPresenter(TechEditDataPresenter::class)
            ->find($id);

        return response()->json(array_merge($tech, [
            'code' => 20000,
        ]));
    }

    /**
     * Delete item
     *
     * @param Request $request
     * @param Logger $log
     *
     * @return JsonResponse
     */
    public function delete(
        Request $request,
        Logger $log
    )
    {
        $id = $request->input('id');
        $model = $this->service->delete($id);

        if ($model) {
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
