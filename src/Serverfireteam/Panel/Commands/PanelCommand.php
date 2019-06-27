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
	public function handle()
	{
            $this->info('[ Blueprint Panel Installation ]       ');

	        $this->call('elfinder:publish');

            $this->call('vendor:publish', array(
                '--force' => true,
                '--provider' => 'Serverfireteam\Panel\PanelServiceProvider',
            ));

            $this->call('migrate', array(
                '--path' => 'vendor/xfactor/panel/src/database/migrations',
                '--force' => true,
            ));

            $this->call('db:seed', array(
                '--class' => '\Serverfireteam\Panel\LinkSeeder',
                '--force' => true,
            ));

            $this->call('db:seed', array(
                '--class' => '\Serverfireteam\Panel\Database\Seeds\AdminSeeder',
                '--force' => true,
            ));
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
