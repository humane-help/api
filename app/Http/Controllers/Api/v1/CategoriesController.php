<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Repositories\Contracts\CategoryRepository;
use App\Services\Contracts\CategoryService;
use Illuminate\Http\JsonResponse;

/**
 * Class CategoriesController
 * @package App\Http\Controllers\Api\v1
 */
class CategoriesController extends Controller
{
    /**
     * @var CategoryRepository $repository
     */
    protected $repository;

    /**
     * @var string $modelName
     */
    private $modelName = 'Category';

    /**
     * @var string $modelNameMultiple
     */
    private $modelNameMultiple = 'Categories';
    /**
     * @var CategoryService $service
     */
    protected $service;

    /**
     * CategoryController constructor.
     * @param CategoryRepository $repository
     * @param CategoryService $service
     */
    public function __construct(
        CategoryRepository $repository,
        CategoryService $service
    ){
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Show Categories.
     *
     * @return JsonResponse
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
     * Show Categories.
     *
     * @return JsonResponse
     */
    public function menu()
    {
        $categories = $this->repository->orderBy('ord', 'ASC')->all();

        $response = [];
        $res = [];
        foreach ($categories as $key => $category) {
                if (!$category->parent_id) {
                    $response['name'] = $category->name;
                    $response['slug'] = $category->slug;

                    $children = [];
                    $childrenAll = [];
                    foreach ($category->children as $item) {
                        $children['name'] = $item->name;
                        $children['slug'] = $item->slug;
                        $langChildAll = [];
                        foreach ($item->translationsAll as $translateChild) {
                            $langChildAll[$translateChild->language->short_name] = [
                                "name" => $translateChild->name,
                            ];
                        }
                        $children['translations'] = $langChildAll;
                        $childrenAll[] = $children;
                    }

                    $response['children'] = $childrenAll;
                    $langAll = [];
                    foreach ($category->translationsAll as $translate) {
                        $langAll[$translate->language->short_name] = [
                            "name" => $translate->name
                        ];
                    }
                    $response['translations'] = $langAll;
                    $res [] = $response;
                }
        }
        return response(
            $this->successResponse(
                'menu',
                $res
            )
        );
    }

    /**
     * Show item
     *
     * @param $slug
     * @return JsonResponse
     */
    public function show($slug)
    {
        if (is_numeric($slug)) {
            $model = $this->repository->find($slug);
        } else {
            $model = $this->repository->findWhere(['slug' => $slug])->first();
        }

        $response = [];
        foreach ($model->toArray() as $key => $value) {

                $langAll = [];
                if ($key == 'translations') {
                    foreach ($model->translationsAll as $translate) {
                        $langAll[$translate->language->short_name] = [
                            "name" => $translate->name
                        ];
                    }
                } else {
                    $response[$key] = $value;
                }
                $response['translations'] = $langAll;
        }
        $data = $this->successResponse($this->modelName, $response);
        return response()->json(array_merge($data, [
            'code' => 20000
        ]));
    }

}
