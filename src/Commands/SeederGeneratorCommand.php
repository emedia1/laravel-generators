<?php

namespace EMedia\Generators\Commands;

class SeederGeneratorCommand extends BaseGeneratorCommand
{

	protected $name = 'scaffold:seeder';
	protected $description = 'Scaffold a seeder through seeder generator';
	protected $type = 'Seeder';


	public function fire()
	{
		parent::fire();

		$tableName = $this->getEntityPlural();
		$this->comment("** Add \"\$this->call({$tableName}TableSeeder::class);\" to DatabaseSeeder.php");
	}

	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub()
	{
		return __DIR__ . '/../../Stubs/migrations/Seeder.stub';
	}

	protected function getPath($name)
	{
		return base_path('database/seeds/'
			. $this->getEntityPlural() . 'TableSeeder.php');
	}

}