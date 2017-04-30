<?php namespace Serverfireteam\Panel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Route;
use Illuminate\Translation;
use Serverfireteam\Panel\libs;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation;
use Serverfireteam\Panel\Commands;

class PanelServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function register()
    {
        $this->publishes([
            __DIR__.'/config/elfinder.php' => config_path('elfinder.php'),
        ]);

        // register zofe\rapyd
        $this->app->register('Zofe\Rapyd\RapydServiceProvider');

        // register html service provider
        $this->app->register('Illuminate\Html\HtmlServiceProvider');

        // 'Maatwebsite\Excel\ExcelServiceProvider'
        $this->app->register('Maatwebsite\Excel\ExcelServiceProvider');

	    // Barryvdh\Elfinder\ElfinderServiceProvider
	    $this->app->register('Barryvdh\Elfinder\ElfinderServiceProvider');

        /*
         * Create aliases for the dependency.
         */
        $loader = AliasLoader::getInstance();
        $loader->alias('Form', 'Illuminate\Html\FormFacade');
        $loader->alias('Html', 'Illuminate\Html\HtmlFacade');
        $loader->alias('Excel', 'Maatwebsite\Excel\Facades\Excel');

        $this->app['panel::install'] = $this->app->share(function()
        {
            return new \Serverfireteam\Panel\Commands\PanelCommand();
        });

        $this->app['panel::crud'] = $this->app->share(function()
        {
            return new \Serverfireteam\Panel\Commands\CrudCommand();
        });

        $this->app['panel::createmodel'] = $this->app->share(function()
        {
           $fileSystem = new Filesystem(); 

           return new \Serverfireteam\Panel\Commands\CreateModelCommand($fileSystem);
        });

        $this->app['panel::createcontroller'] = $this->app->share(function()
        {
           $fileSystem = new Filesystem();

           return new \Serverfireteam\Panel\Commands\CreateControllerPanelCommand($fileSystem);
        });

        $this->commands('panel::createmodel');

        $this->commands('panel::createcontroller');

        $this->commands('panel::install');

        $this->commands('panel::crud');

        $this->publishes([
            __DIR__ . '/../../../public' => public_path('packages/serverfireteam/panel')
        ]);

        $this->publishes([
            __DIR__.'/config/panel.php' => config_path('panel.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../../database/seeds/' => database_path('seeds'),  # using the panel admin seeder for now
            __DIR__ . '/../../database/migrations/' => database_path('migrations')
        ], 'database');
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../../views', 'panelViews');
        $this->publishes([
            __DIR__.'/../../views' => base_path('resources/views/vendor/panelViews'),
        ]);

        include __DIR__."/../../routes.php";

    	$this->loadTranslationsFrom(base_path() . '/vendor/xfactor/panel/src/lang', 'panel');
        $this->loadTranslationsFrom(base_path() . '/vendor/serverfireteam/rapyd-laravel/lang', 'rapyd');
        $this->loadTranslationsFrom(base_path() . '/vendor/xfactor/panel/src/lang', 'rapyd');

        AliasLoader::getInstance()->alias('Serverfireteam', 'Serverfireteam\Panel\Serverfireteam');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
