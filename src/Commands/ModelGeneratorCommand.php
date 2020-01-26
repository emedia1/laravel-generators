<?php

namespace EMedia\Generators\Commands;


class ModelGeneratorCommand extends BaseGeneratorCommand
{

	protected $name = 'scaffold:model';
	protected $description = 'Scaffold a model through model generator';
	protected $type = 'Model';

	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub()
	{
		return __DIR__ . '/../../Stubs/Entities/Model/Model.stub';
	}

}