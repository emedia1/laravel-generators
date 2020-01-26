<?php

namespace EMedia\Generators\Commands;

use EMedia\PHPHelpers\Files\FileManager;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

abstract class BaseGeneratorCommand extends GeneratorCommand
{

	protected $dontAsk = false;

	public function handle()
	{
		parent::handle();

		if (method_exists($this, 'afterHandle')) {
			$this->afterHandle();
		}
	}

	/**
	 * Build the class with the given name.
	 *
	 * @param  string  $name
	 * @return string
	 */
	protected function buildClass($name, $stubPath = null)
	{
		if (!$stubPath) $stubPath = $this->getStub();

		$stub = $this->files->get($stubPath);

		$stub = $this->compileVariables($stub);

		return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
	}

	protected function compileVariables($stub)
	{
		$stub = str_replace('{{entityGroup}}', $this->getEntityPlural(), $stub);

		$stub = str_replace('{{entityGroupLower}}', $this->getEntityPluralLower(), $stub);

		$stub = str_replace('{{entityLower}}', $this->getEntitySingularNameLower(), $stub);

		$stub = str_replace('{{tableName}}', $this->getEntityPluralLower('snake_case'), $stub);

		return $stub;
	}

	protected function getPath($name)
	{
		return app_path('Entities/'
			. $this->getEntityPlural() . '/'
			. $this->getEntitySingularName() . '.php');
	}

	protected function getEntityName()
	{
		return studly_case($this->argument('name'));
	}

	protected function getEntitySingularName()
	{
		return studly_case(str_singular($this->getNameInput()));
	}

	protected function getEntityPlural()
	{
		return studly_case(str_plural($this->getNameInput()));
	}

	protected function getEntitySingularNameLower()
	{
		return strtolower(studly_case(str_singular($this->getNameInput())));
	}

	protected function getEntityPluralLower($case = 'studly_case')
	{
		$entityName = str_plural($this->getNameInput());

		switch ($case) {
			case 'snake_case':
				return snake_case($entityName);
				break;
		}

		return strtolower(studly_case($entityName));
	}

	protected function replaceClass($stub, $name)
	{
		return str_replace('DummyClass', $this->getEntitySingularName(), $stub);
	}

	protected function getTimestamp()
	{
		// get microtime of file generation to preserve migration sequence
		$time = explode(" ", microtime());

		// change the format to 2008_07_14_010813.98232
		return date("Y_m_d_His", $time[1]) . '.' . substr((string)$time[0], 2, 5);
	}

	/**
	 * Compile the stubs and generate the files. Outputs data to the console.
	 *
	 * @param array $stubMap
	 */
	public function compileStubs($stubMap = [])
	{
		foreach ($stubMap as $stubData)
		{
			$name = $this->qualifyClass($stubData['name']);

			if (!$this->dontAsk) {
				if (!$this->confirm('Create ' . $stubData['path'] . '?', true)) {
					// skip it
					continue;
				}
			}

			if ($this->files->exists($stubData['path']))
			{
				// if we have a default file given, we compare it against the file that will be replaced
				// if it is identical, we don't ask the user
				$filesAreSimilar = null;
				if (!empty($stubData['default'])) {
					$defaultFile = $stubData['default'];
					if (file_exists($defaultFile)) {
						$filesAreSimilar = FileManager::areFilesSimilar($stubData['path'], $defaultFile);
//						if ($stubData['name'] === 'webpack.mix.js') {
//							dd($filesAreSimilar);
//						}
					}
				}


				if ($filesAreSimilar === null || $filesAreSimilar === false) {
					if ($this->confirm($stubData['path'] . ' already exists. Overwrite?', true)) {

					} else {
						// $this->error($stubData['name'] . ' already exists. Skipped.');
						continue;
					}
				}
			}

			$this->makeDirectory($stubData['path']);

			// parse each file and write
			$this->files->put($stubData['path'], $this->buildClass($name, $stubData['stub']));

			$this->info($stubData['name'] . ' created successfully.');
		}
	}

	/**
	 * Replace the given string in the given file.
	 *
	 * @param  string  $path
	 * @param  string|array  $search
	 * @param  string|array  $replace
	 * @return void
	 */
	protected function replaceIn($path, $search, $replace)
	{
		$this->files->put($path, str_replace($search, $replace, $this->files->get($path)));
	}

	protected function getArguments()
	{
		return [
			['name', InputArgument::REQUIRED, 'The entity name']
		];
	}



}