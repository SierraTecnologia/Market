<?php

namespace Market;

use App;
use Config;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Log;
use Market\Facades\Market as MarketFacade;
use Market\Facades\StoreHelper;

use Market\Services\CartService;
use Market\Services\CustomerProfileService;
use Market\Services\LogisticService;
use Market\Services\MarketService;
use Market\Services\ProductService;
use Market\Services\StoreHelperService;
use Muleta\Traits\Providers\ConsoleTools;
use Route;

class MarketProvider extends ServiceProvider
{
    use ConsoleTools;

    public $packageName = 'market';
    const pathVendor = 'sierratecnologia/market';

    public static $aliasProviders = [
        'Market' => \Market\Facades\Market::class,
        'StoreHelper' => \Market\Facades\StoreHelper::class,
    ];

    public static $providers = [

        \Pedreiro\PedreiroProviderService::class,

        
    ];

    /**
     * Rotas do Menu
     */
    public static $menuItens = [
        [
            'text'        => 'Vendas',
            'url'         => 'admin/commerce-analytics',
            'icon'        => 'laptop',
            'icon_color'  => 'red',
            'label_color' => 'success',
            'section'     => 'painel',
            'level'       => 2,
            'feature' => 'commerce',
        ],
        [
            'text'        => 'Products',
            'url'         => 'admin/products',
            'icon'        => 'laptop',
            'icon_color'  => 'red',
            'label_color' => 'success',
            'section'     => 'painel',
            'level'       => 2,
            'feature' => 'commerce',
        ],
        [
            'text'        => 'Plans',
            'url'         => 'admin/plans',
            'icon'        => 'laptop',
            'icon_color'  => 'red',
            'label_color' => 'success',
            'section'     => 'painel',
            'level'       => 2,
            'feature' => 'commerce',
            'config' => 'market.have-plans',
        ],
        [
            'text'        => 'Coupons',
            'url'         => 'admin/coupons',
            'icon'        => 'laptop',
            'icon_color'  => 'red',
            'label_color' => 'success',
            'section'     => 'painel',
            'level'       => 2,
            'feature' => 'commerce',
            'config' => 'market.have-coupons',
        ],
        [
            'text'        => 'Transactions',
            'url'         => 'admin/transactions',
            'icon'        => 'laptop',
            'icon_color'  => 'red',
            'label_color' => 'success',
            'section'     => 'painel',
            'level'       => 2,
            'feature' => 'commerce',
        ],
        [
            'text'        => 'orders',
            'url'         => 'admin/orders',
            'icon'        => 'laptop',
            'icon_color'  => 'red',
            'label_color' => 'success',
            'section'     => 'painel',
            'level'       => 2,
            'feature' => 'commerce',
        ],
        // [
        //     'text' => 'Market',
        //     'icon' => 'fas fa-fw fa-search',
        //     'icon_color' => "blue",
        //     'label_color' => "success",
        //     'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
        // ],
        // 'Market' => [
        //     [
        //         'text'        => 'Procurar',
        //         'icon'        => 'fas fa-fw fa-search',
        //         'icon_color'  => 'blue',
        //         'label_color' => 'success',
        //         'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
        //         // 'access' => \App\Models\Role::$ADMIN
        //     ],
        //     'Procurar' => [
        //         [
        //             'text'        => 'Projetos',
        //             'route'       => 'rica.market.projetos.index',
        //             'icon'        => 'fas fa-fw fa-ship',
        //             'icon_color'  => 'blue',
        //             'label_color' => 'success',
        //             'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
        //             // 'access' => \App\Models\Role::$ADMIN
        //         ],
        //     ],
        // ],
    ];
    
    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }


        /**
         * Porteiro; Routes
         */
        $this->loadRoutesForRiCa(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'routes');
    }

    /**
     * Alias the services in the boot.
     */
    public function boot()
    {
        $this->routes();
        $loader = AliasLoader::getInstance();
        
        // Register configs, migrations, etc
        $this->registerDirectories();

        // COloquei no register pq nao tava reconhecendo as rotas para o adminlte
        $this->app->booted(
            function () {
                $this->routes();
            }
        );

        $this->loadLogger();

        $loader->alias('StoreHelper', StoreHelper::class);
    }


    /**
     * Register the services.
     */
    public function register()
    {
        $this->mergeConfigFrom($this->getPublishesPath('config/sitec/market.php'), 'sitec.market');
        

        $this->setProviders();
        // $this->routes();



        // Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->app->singleton(
            'market',
            function () {
                return new Market();
            }
        );
        $this->app->singleton(
            'storeHelper',
            function () {
                return app()->make(StoreHelperService::class);
            }
        );
        
        /*
        |--------------------------------------------------------------------------
        | Register the Utilities
        |--------------------------------------------------------------------------
        */
        /**
         * Singleton Market;
         */
        $this->app->singleton(
            MarketService::class,
            function ($app) {
                Log::channel('sitec-market')->info('Singleton Market;');
                return new MarketService(\Illuminate\Support\Facades\Config::get('sitec.market'));
            }
        );

        // Register commands
        $this->registerCommandFolders(
            [
            base_path('vendor/sierratecnologia/market/src/Console/Commands') => '\Market\Console\Commands',
            ]
        );

        // /**
        //  * Helpers
        //  */
        // Aqui noa funciona
        // if (!function_exists('market_asset')) {
        //     function market_asset($path, $secure = null)
        //     {
        //         return route('rica.market.assets').'?path='.urlencode($path);
        //     }
        // }

        $this->app->bind(
            'ProductService',
            function ($app) {
                return app()->make(ProductService::class);
            }
        );

        $this->app->bind(
            'CartService',
            function ($app) {
                return app()->make(CartService::class);
            }
        );

        $this->app->bind(
            'LogisticService',
            function ($app) {
                return app()->make(LogisticService::class);
            }
        );

        $this->app->bind(
            'CustomerProfileService',
            function ($app) {
                return app()->make(CustomerProfileService::class);
            }
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'market',
        ];
    }

    /**
     * Register configs, migrations, etc
     *
     * @return void
     */
    public function registerDirectories()
    {
        // Publish config files
        $this->publishes(
            [
            // Paths
            $this->getPublishesPath('config'.DIRECTORY_SEPARATOR.'sitec') => config_path('sitec'),
            ],
            ['config',  'sitec', 'sitec-config']
        );

        // // Publish market css and js to public directory
        // $this->publishes([
        //     $this->getDistPath('market') => public_path('assets/market')
        // ], ['public',  'sitec', 'sitec-public']);

        $this->loadViews();
        $this->loadTranslations();
    }

    private function loadViews()
    {
        // View namespace
        $viewsPath = $this->getResourcesPath('views');
        $this->loadViewsFrom($viewsPath, 'market');
        $this->publishes(
            [
            $viewsPath => base_path('resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'market'),
            ],
            ['views',  'sitec', 'sitec-views']
        );
    }
    
    private function loadTranslations()
    {
        // Publish lanaguage files
        $this->publishes(
            [
            $this->getResourcesPath('lang') => resource_path('lang'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'market')
            ],
            ['lang',  'sitec', 'sitec-lang', 'translations']
        );

        // Load translations
        $this->loadTranslationsFrom($this->getResourcesPath('lang'), 'market');
    }


    /**
     *
     */
    private function loadLogger()
    {
        Config::set(
            'logging.channels.sitec-market',
            [
            'driver' => 'single',
            'path' => storage_path('logs'.DIRECTORY_SEPARACTOR.'sitec-market.log'),
            'level' => env('APP_LOG_LEVEL', 'debug'),
            ]
        );
    }
}
