<?php namespace Serverfireteam\Panel\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PanelCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string holds the name of the command
	 */
	protected $name = 'panel:install';

	/**
	 * The console command description.
	 *
	 * @var string holds the description of the command
	 */
	protected $description = 'Installs  Panel  migrations, configs, views and assets.';

	/**
	 * Create a new command instance.
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 */
	public function fire()
	{
            $this->info('[ Blueprint Panel Installation ]       ');

	        $this->call('elfinder:publish');

            // silly, but --force doesn't work unless it's a key (i.e. downstream doesn't support mixed arrays) :(
            $this->call('vendor:publish', array(
                '--force' => true,
                '--provider' => 'Serverfireteam\Panel\PanelServiceProvider',
            ));

            $this->call('migrate', array('--path' => 'vendor/xfactor/panel/src/database/migrations'));

            $this->call('db:seed', array('--class' => '\Serverfireteam\Panel\LinkSeeder'));

            $this->call('db:seed', array('--class' => '\Serverfireteam\Panel\Database\Seeds\AdminSeeder'));
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}

}
