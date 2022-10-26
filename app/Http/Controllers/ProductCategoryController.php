<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductCategoryService;

class ProductCategoryController extends Controller
{
    protected $ProductCategoryService;

    public function __construct(ProductCategoryService $ProductCategoryService)
    {
        $this->ProductCategoryService = $ProductCategoryService;
    }

    /**
     * @OA\Get(
     *   tags={"ProductCategory"},
     *   path="/productCategory",
     *   summary="拿到所有的商品資訊",
     *   @OA\Response(response=200, description="OK",
     *      content={
     *          @OA\MediaType(
     *              mediaType="application/json",
     *                 example={
     *                   {
     *                     "id": 1,
     *                     "name": "Pasquale Reilly",
     *                     "price": "57.00",
     *                     "created_at": "2022-10-20 08:10:53",
     *                     "updated_at": "2022-10-20 08:10:53",
     *                     "products": {
     *                           {
     *                                      "id": 1,
     *                                      "product_categories_id": 1,
     *                                      "size": "big",
     *                                      "color": "Indigo",
     *                                      "stock": 1,
     *                                      "created_at": "2022-10-20 08:10:53",
     *                                      "updated_at": "2022-10-20 08:10:53"
     *                                   }
     *                           }               
     *                  }
     *              }
     *          )
     *       }
     *   )
     * )
     */
    public function index()
    {
        $products = $this->ProductCategoryService->index();

        return $products;
    }
}
