<?php

namespace EMedia\Generators\Commands;

use Illuminate\Console\Command;

class ResourceGeneratorCommand extends Command
{

	protected $signature = 'scaffold:resource {name}';
	protected $description = 'Scaffold a resource through repository generator';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$requiredCommands = [
			'model',
			'repository',
			'controller',
			'model:migration',
			// 'model:migration:relationship',
			'seeder'
		];

		foreach ($requiredCommands as $command)
		{
			$this->call("scaffold:{$command}", [
				'name'	=> $this->argument('name')
			]);
		}

	}
}