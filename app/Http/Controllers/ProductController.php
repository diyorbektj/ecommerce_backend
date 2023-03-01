<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pipeline\Pipeline;

class ProductController extends Controller
{
    protected ProductService $productService;

    private ProductRepository $productRepository;

    public function __construct(ProductService $productService, ProductRepository $productRepository)
    {
        $this->productService = $productService;
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $data = $this->productRepository->allProducts();

        return ProductResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductRequest  $request
     * @return ProductResource
     */
    public function store(CreateProductRequest $request): ProductResource
    {
        $product = $this->productService->createProduct($request);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ProductResource
     */
    public function show(int $id): ProductResource
    {
        return new ProductResource($this->productRepository->getProduct($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProductRequest  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, int $id): JsonResponse
    {
        $data = $this->productService->updateProduct($request, $id);

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->productRepository->deleteProduct($id);

        return response()->json(['message' => 'Product deleted'], 200);
    }

    public function SearchProduct(Request $request)
    {
        $data = $this->productRepository->searchProduct($request->get('search'));

        return ProductResource::collection($data);
    }

    public function filterProduct(Request $request): AnonymousResourceCollection
    {
        $query = Product::query();

        $products = app(Pipeline::class)
            ->send($query)
            ->through([
                \App\QueryFilters\ProductCategoryFilter::class,
                \App\QueryFilters\ProductColorFilter::class,
                \App\QueryFilters\ProductPriceFilter::class,
                \App\QueryFilters\ProductOrderTypeFilter::class,
            ])
            ->thenReturn()
            ->get();

        return ProductResource::collection($products);
    }

    public function category($id)
    {
        $data = Product::with('category')->where('category_id', $id)->orderByDesc('created_at')->paginate(16);

        return ProductResource::collection($data);
    }
}
