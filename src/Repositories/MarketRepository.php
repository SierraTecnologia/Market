<?php

namespace Market\Repositories;

use Illuminate\Support\Facades\Schema;
use Market\Models\Market;
use Market\Repositories\FavoriteRepository;

class MarketRepository
{
    public function __construct(Market $product)
    {
        $this->model = $product;
    }
    // Using Aggregate Methods
    // $users = DB::table('users')->count();
    
    // $price = DB::table('orders')->max('price');
    
    // $price = DB::table('orders')->min('price');
    
    // $price = DB::table('orders')->avg('price');
    
    // $total = DB::table('users')->sum('votes');
    /**
     * Returns all Markets.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    public function allForCustomer(Collections $products, $location = false)
    {
    }

    public function allGroupedByCategory()
    {
        $users = DB::table('users')
                    ->orderBy('name', 'desc')
                    ->groupBy('count')
                    ->having('count', '>', 100)
                    ->get();
    }

    /**
     * Get cusomter favorites
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function favorites()
    {
        $favorites = app(FavoriteRepository::class)->all()->pluck('product_id');

        return $this->model->whereIn('id', $favorites)->get();
    }

    /**
     * Returns all paginated Market.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function paginated()
    {
        if (isset(request()->dir) && isset(request()->field)) {
            $model = $this->model->orderBy(request()->field, request()->dir);
        } else {
            $model = $this->model->orderBy('created_at', 'desc');
        }

        return $model->paginate(\Illuminate\Support\Facades\Config::get('siravel.pagination', 25));
    }

    /**
     * Search Market.
     *
     * @param string $input
     *
     * @return Market
     */
    public function search($payload, $paginate)
    {
        $query = $this->model->orderBy('created_at', 'desc');

        $columns = Schema::getColumnListing('products');
        $query->where('id', 'LIKE', '%'.$payload.'%');

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$payload.'%');
        }

        return $query->paginate($paginate);
    }

    /**
     * Stores Market into database.
     *
     * @param array $input
     *
     * @return Market
     */
    public function create($input)
    {
        return $this->model->create($input);
    }

    /**
     * Find Market by given id.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Market
     */
    public function find($id)
    {
        if (!$model = $this->model->find($id)) {
            return abort(404);
        }
        return $model;
    }

    /**
     * Destroy Market.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Market
     */
    public function destroy($id)
    {
        return $this->model->find($id)->delete();
    }

    /**
     * Updates Market in the database.
     *
     * @param int   $id
     * @param array $inputs
     *
     * @return Market
     */
    public function update($id, $inputs)
    {
        $product = $this->model->find($id);
        $product->fill($inputs);
        $product->save();

        return $product;
    }

    /*
    |--------------------------------------------------------------------------
    | Store End
    |--------------------------------------------------------------------------
    */

    /**
     * Get all published products.
     *
     * @return
     */
    public function getPublishedMarkets()
    {
        return $this->model->where('is_published', 1);
    }

    /**
     * Find Markets by URL.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Markets
     */
    public function findMarketByURL($url)
    {
        return $this->model->where('url', $url)->where('is_available', 1)->where('is_published', 1)->first();
    }
}
