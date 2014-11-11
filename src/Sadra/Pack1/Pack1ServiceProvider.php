<?php namespace Sadra\Pack1;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Route;

class Pack1ServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
        
        public function boot(){
                     
            
            $this->package('sadra/pack1');                                  
            
            Route::get('/panel2/{entity}/all', function($entity){
                $controller = \App::make('Sadra\\Pack1\\'.$entity.'Controller');
                return $controller->callAction('all', array('entity' => $entity));
            });
    
             Route::any('/panel2/{entity}/edit', function($entity){
                $controller = \App::make('Sadra\\Pack1\\'.$entity.'Controller');
                return $controller->callAction('edit', array('entity' => $entity));
            });
           
            
            
           
              
            include __DIR__."/../../routes.php";

            AliasLoader::getInstance()->alias('Sadra', 'Sadra\Pack1\Sadra');
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