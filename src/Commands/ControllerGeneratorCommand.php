<?php

namespace EMedia\Generators\Commands;

class ControllerGeneratorCommand extends BaseGeneratorCommand
{

	protected $name = 'scaffold:controller';
	protected $description = 'Scaffold a controller through controller generator';
	protected $type = 'Controller';

	public function afterHandle()
	{
		// parent::fire();

		$routesFilePath = base_path('routes/web.php');
		$entityURI 	= snake_case($this->getEntityPlural());
		$hypenCaseURI = str_replace('_', '-', $entityURI);
		$controllerName = $this->getEntityPlural();

		$appendLines = [
			"",
			"",
			"// Routes for " . $controllerName,
			"Route::group(['prefix' => 'manage', 'middleware' => ['web', 'auth', 'auth.acl:roles[super-admin|admin]'], 'as' => 'manage.'], function()",
			"{",
			"	Route::resource('$hypenCaseURI', '{$controllerName}Controller')->only('index', 'show', 'store', 'edit', 'update', 'destroy');",
			"});",
		];

		// ask the user and update the routes file if required
		if ($this->confirm("Update routes file for {$controllerName}?", true))
		{
			$result = $this->files->append($routesFilePath, implode($appendLines, "\n"));
			if ($result) $this->info('Routes file updated.');
		}
	}

	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub()
	{
		return __DIR__ . '/../../Stubs/Http/Controllers/Controller.stub';
	}

	protected function getPath($name)
	{
		return app_path('Http/Controllers/'
			. $this->getEntityPlural() . 'Controller.php');
	}

}