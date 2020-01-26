<?php

namespace EMedia\Generators\Commands;

class RepositoryGeneratorCommand extends BaseGeneratorCommand
{

	protected $name = 'scaffold:repository';
	protected $description = 'Scaffold a repository through repository generator';
	protected $type = 'Repository';


	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub()
	{
		return __DIR__ . '/../../Stubs/Entities/Model/ModelRepository.stub';
	}

	protected function getPath($name)
	{
		return app_path('Entities/'
			. $this->getEntityPlural() . '/'
			. $this->getEntityPlural() . 'Repository.php');
	}

}