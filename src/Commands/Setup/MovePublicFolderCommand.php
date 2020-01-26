<?php

namespace EMedia\Generators\Commands\Setup;

use EMedia\Generators\Commands\BaseGeneratorCommand;

class MovePublicFolderCommand extends BaseGeneratorCommand
{

	protected $signature = 'setup:move-public 
								{--y : Do not confirm with the user if there are no potential issues}';

	protected $description = 'Move public folder to public_html';

	protected $dontAsk = false;

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$this->dontAsk = $this->option('y');

		$this->movePublicFolder();
	}


	protected function movePublicFolder()
	{
		$newFolderName = 'public_html';
		$currentPath = base_path('public');
		$newPath 	 = base_path($newFolderName);

		// see if 'public' exists
		if ( ! $this->files->exists($currentPath)) {
			$this->info("$currentPath not found. Skipping...");
			return;
		}

		if (!$this->dontAsk && !$this->confirm('Move `public` folder to `public_html`?', true)) return;

		if ($this->files->exists($newPath)) {
			$this->error($newPath . ' already exists. Skipping...');
			return;
		}

		// rename folder
		$this->files->move($currentPath, $newPath);

		$serverFilePath = base_path('server.php');
		$appFilePath	= base_path('/bootstrap/app.php');
		if ( ! ($this->files->exists($serverFilePath) && $this->files->exists($appFilePath)) ) {
			$this->error("$serverFilePath or $appFilePath not found");
			return;
		}

		// add new class
		$stub = __DIR__ . '/../../../Stubs/Application.stub';
		$this->files->copy($stub, app_path('Application.php'));

		$this->replaceIn($serverFilePath, ['/public', '/public/'], ['/public_html', '/public_html/']);
		$this->replaceIn($appFilePath, 'new Illuminate\Foundation\Application', 'new App\Application');
	}

	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub()
	{
		// TODO: Implement getStub() method.
	}

}