<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Tag;
use App\Presenters\ArticleDetailPresenter;
use App\Presenters\ArticleEditDataPresenter;
use App\Presenters\ArticlePresenter;
use App\Repositories\Contracts\ArticleRepository;
use App\Services\Contracts\ArticleService;
use App\Services\Contracts\TelegramService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Log\Logger;

class ArticlesController extends Controller
{
    /**
     * @var ArticleRepository $repository
     */
    protected $repository;

    /**
     * @var string $modelName
     */
    private $modelName = 'Article';

    /**
     * @var string $modelNameMultiple
     */
    private $modelNameMultiple = 'Articles';
    /**
     * @var ArticleService $service
     */
    protected $service;

    /**
     * @var TelegramService
     */
    private $telegramService;

    /**
     * ArticlesController constructor.
     * @param ArticleRepository $repository
     * @param ArticleService $service
     * @param TelegramService $telegramService
     */
    public function __construct(
        ArticleRepository $repository,
        ArticleService $service,
        TelegramService $telegramService
    ){
        $this->repository = $repository;
        $this->service = $service;
        $this->telegramService = $telegramService;
    }

    /**
     * Show Articles.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $limit = array_get($data, 'limit', 10);
        $sort = array_get($data, 'sort');
        $sortDirection = $sort == '-id' ? 'ASC' : 'DESC';
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $articles = $this->repository->orderBy('created_at', $sortDirection)->setPresenter(ArticlePresenter::class)->paginate($limit);
        return response(
            $this->successResponse(
                $this->modelNameMultiple,
                $articles
            )
        );
    }

    /**
     * Create a new article
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
            $data = $this->successResponse($this->modelName, $model, $message);
        } else {
            $message = $this->modelName.' was not stored.';
            $log->error($message);
            $data = $this->errorResponse($this->modelName, null, $message);
        }

        return response()->json(array_merge($data, ['code' => 20000]));
    }

    /**
     * Update a article
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
            $data = $this->successResponse($this->modelName, $model, $message);
        } else {
            $message = $this->modelName.' was not updated.';
            $log->error($message);
            $data = $this->errorResponse($this->modelName, null, $message);
        }

        return response()->json(array_merge($data ,[
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

        if (is_numeric($id)) {
            /** Article $article */
            $article = $this->repository->find($id);
        } else {
            /** Article $article */
            $article = $this->repository->findWhere(['slug' => $id])->first();
        }
        $article->status = $status;
        $response = $this->successResponse($this->modelName, $article->save());
        return response()->json(array_merge($response, ['code' => 20000]));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $article = $this->repository
            ->setPresenter(ArticleDetailPresenter::class)
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
        $article = $this->repository
            ->setPresenter(ArticleEditDataPresenter::class)
            ->find($id);

        return response()->json(array_merge($article, [
            'code' => 20000,
        ]));
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
            'message' => 'Yangilik aktiv emas holatga o`tkazildi'
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function sendToTelegram($id)
    {
        $article = $this->repository->find($id);

        $this->telegramService->sendMessageChannel(
            $article->title,
            $article->url,
            $article->img,
            $article->category->name
        );

        return response()->json([
            'code' => 20000,
            'message' => 'Yangilik aktiv emas holatga o`tkazildi'
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
            'message' => 'Yangilik aktivlashtirildi'
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
            'message' => 'Yangilik arxivga o`tkazildi'
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function createData()
    {
        return response()->json([
            'code' => 20000,
            'data' => [
                'categories' => Category::all(),
                'tags' => Tag::all(),
            ]
        ]);
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
        $id,
        Logger $log
    )
    {
        $model = $this->service->delete($id);

        if ($model){
            $message = $this->modelName . ' was successfully deleted.';
            $log->info($message, ['id' => $id]);
            $code = 20000;
            $data = $this->successResponse($this->modelName, $model, $message);
        } else {
            $message = $this->modelName . ' was not deleted.';
            $log->error($message);
            $code = 50000;
            $data = $this->errorResponse($this->modelName, null, $message);
        }

        return response()->json(array_merge($data, [
            'code' => $code
        ]));
    }

}
