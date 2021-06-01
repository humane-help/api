<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Repositories\Contracts\TechRepository;
use App\Services\Contracts\TechService;
use Illuminate\Http\JsonResponse;

/**
 * Class TechController
 * @package App\Http\Controllers\Api\v1
 */
class TechController extends Controller
{
    /**
     * @var TechRepository $repository
     */
    protected $repository;

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
        TechService $service
    ){
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();

        $limit = array_get($data, 'limit', 4);
        $techs = $this->repository->with('tags')->orderBy('created_at','DESC');
        $techs = $techs->paginate($limit);
        $techs = $techs->toArray();

        return response(
            $this->successResponse(
                $this->modelNameMultiple,
                $techs
            )
        );
    }

    /**
     * Get one tech
     *
     * @param $locale
     * @param $id
     * @return JsonResponse
     */
    public function show($locale, $id)
    {
        if (Language::where('short_name', '=', $locale)->first()) {
            app()->setLocale($locale);
        }
        $model = $this->repository->with('tags')->find($id);
        $data = $this->successResponse($this->modelName, $model);
        return response()->json(array_merge($data, [
            'code' => 20000
        ]));
    }

}
