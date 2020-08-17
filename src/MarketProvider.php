<?php

namespace Market;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Market\Services\MarketService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

use Log;
use App;
use Config;
use Route;
use Illuminate\Routing\Router;

use Muleta\Traits\Providers\ConsoleTools;

use Market\Facades\Market as MarketFacade;
use Illuminate\Contracts\Events\Dispatcher;


class MarketProvider extends ServiceProvider
{
    use ConsoleTools;

    public $packageName = 'market';
    const pathVendor = 'sierratecnologia/market';

    public static $aliasProviders = [
        'Market' => \Market\Facades\Market::class,
    ];

    public static $providers = [

        \Support\SupportProviderService::class,

        
    ];

    /**
     * Rotas do Menu
     */
    public static $menuItens = [
        [
            'text' => 'Market',
            'icon' => 'fas fa-fw fa-search',
            'icon_color' => "blue",
            'label_color' => "success",
            'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
        ],
        'Market' => [
            [
                'text'        => 'Procurar',
                'icon'        => 'fas fa-fw fa-search',
                'icon_color'  => 'blue',
                'label_color' => 'success',
                'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                // 'access' => \App\Models\Role::$ADMIN
            ],
            'Procurar' => [
                [
                    'text'        => 'Projetos',
                    'route'       => 'rica.market.projetos.index',
                    'icon'        => 'fas fa-fw fa-ship',
                    'icon_color'  => 'blue',
                    'label_color' => 'success',
                    'level'       => 3, // 0 (Public), 1, 2 (Admin) , 3 (Root)
                    // 'access' => \App\Models\Role::$ADMIN
                ],
            ],
        ],
    ];

    /**
     * Alias the services in the boot.
     */
    public function boot()
    {
        
        // Register configs, migrations, etc
        $this->registerDirectories();

        // COloquei no register pq nao tava reconhecendo as rotas para o adminlte
        $this->app->booted(function () {
            $this->routes();
        });

        $this->loadLogger();
    }

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
         * Market; Routes
         */
        $this->loadRoutesForRiCa(__DIR__.'/../routes');
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
            'market', function () {
                return new Market();
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
            MarketService::class, function ($app) {
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
            $this->getPublishesPath('config/sitec') => config_path('sitec'),
            ], ['config',  'sitec', 'sitec-config']
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
            $viewsPath => base_path('resources/views/vendor/market'),
            ], ['views',  'sitec', 'sitec-views']
        );

    }
    
    private function loadTranslations()
    {
        // Publish lanaguage files
        $this->publishes(
            [
            $this->getResourcesPath('lang') => resource_path('lang/vendor/market')
            ], ['lang',  'sitec', 'sitec-lang', 'translations']
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
            'logging.channels.sitec-market', [
            'driver' => 'single',
            'path' => storage_path('logs/sitec-market.log'),
            'level' => env('APP_LOG_LEVEL', 'debug'),
            ]
        );
    }

}
