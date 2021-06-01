<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Language;
use App\Presenters\ArticlePresenter;
use App\Repositories\Contracts\ArticleRepository;
use App\Services\Contracts\ArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ArticlesController
 * @package App\Http\Controllers\Api\v1
 */
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
     * ArticlesController constructor.
     * @param ArticleRepository $repository
     * @param ArticleService $service
     */
    public function __construct(
        ArticleRepository $repository,
        ArticleService $service
    ){
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Show Articles.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */

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
     * Show latest Articles.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function latest(Request $request)
    {
        $data = $request->all();

        $limit = array_get($data, 'limit', 14);
        $articles = $this->repository->active()->orderBy('created_at','DESC');
        $articles = $articles->paginate($limit);
        $articles = $articles->toArray();

        return response(
            $this->successResponse(
                $this->modelNameMultiple,
                $articles
            )
        );
    }

    /**
     * Show latest Articles.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function alike(Request $request, $lang, $slug)
    {
        $data = $request->all();

        $article = $this->repository->with('tags')->findWhere(['slug' => $slug])->first();
        $tag = $article->tags()->first();

        $limit = array_get($data, 'limit', 14);
        $articles = $tag && $tag->articles() ? $tag->articles()->active()->where('id', '!=', $article->id) : [];

        if (!empty($articles)) {
            $articles = $articles->paginate($limit);
            $articles = $articles->toArray();
        }

        return response(
            $this->successResponse(
                $this->modelNameMultiple,
                $articles
            )
        );
    }

    /**
     * Show latest Articles.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $data = $request->all();
        $q = array_get($data, 'q');

        $limit = array_get($data, 'limit', 14);
        $articles = $this->repository
            ->where('articles.status', '=', Article::STATUS_ACTIVE)
            ->leftjoin('article_translations', 'articles.id', '=', 'article_translations.item_id')
            ->where('article_translations.title', 'LIKE', "%{$q}%")
            ->orWhere('article_translations.description', 'LIKE', "%{$q}%")
            ->orWhere('article_translations.content', 'LIKE', "%{$q}%");

        $articles = $articles->paginate($limit);
        $articles = $articles->toArray();

        return response(
            $this->successResponse(
                $this->modelNameMultiple,
                $articles
            )
        );
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id, Request $request)
    {
        $lang = $request->header('language', 'ru');
        app()->setLocale($lang);
        $model = $this->repository->find($id);

        return response(
            $this->successResponse(
                $this->modelNameMultiple,
                $model
            )
        );
    }

}
