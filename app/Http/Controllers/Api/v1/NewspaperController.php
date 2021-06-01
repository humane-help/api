<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Newspaper;
use App\Presenters\NewspaperPresenter;
use App\Repositories\Contracts\NewspaperRepository;
use App\Services\Contracts\NewspaperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class NewspaperController
 * @package App\Http\Controllers\Api\v1
 */
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
     * NewspaperController constructor.
     * @param NewspaperRepository $repository
     * @param NewspaperService $service
     */
    public function __construct(
        NewspaperRepository $repository,
        NewspaperService $service
    ){
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lang = $request->header('language', 'ru');
        app()->setLocale($lang);

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
