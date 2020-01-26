<?php

namespace EMedia\Generators;

use EMedia\Generators\Commands\Setup\MovePublicFolderCommand;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class GeneratorServiceProvider extends ServiceProvider
{

	public function boot()
	{
		$this->publishes([
			__DIR__.'/../resources/apidocs' => resource_path('/apidocs')
		], 'apidoc-templates');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// $this->mergeConfigFrom( __DIR__ . '/../config/settings.php', 'settings');

		$registrations = [
			// 'CommonFiles',
			'Model',
			'Repository',
			'Controller',
			'ModelMigration',
			// 'ModelRelationshipMigration',
			'Resource',
			'Seeder',
			// 'ConfigFiles',
		];

		foreach ($registrations as $registration)
		{
			$this->app->singleton("emedia.{$registration}Generator", function () use ($registration) {
				return App::make("EMedia\\Generators\\Commands\\{$registration}GeneratorCommand");
			});
			$this->commands("emedia.{$registration}Generator");
		}

		if (app()->environment('local'))
		{
			$this->commands(MovePublicFolderCommand::class);
		}
	}
}