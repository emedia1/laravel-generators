<?php

namespace EMedia\Generators\Commands;

class ModelMigrationGeneratorCommand extends BaseGeneratorCommand
{

	protected $name = 'scaffold:model:migration';
	protected $description = 'Scaffold a model migration through migration generator';
	protected $type = 'Model Migration';


	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub()
	{
		return __DIR__ . '/../../Stubs/migrations/ModelMigration.stub';
	}

	protected function getPath($name)
	{
		// get microtime of file generation to preserve migration sequence
		$time = explode(" ",microtime());

		// change the format to 2008_07_14_010813.982
		$generationTime = date("Y_m_d_His", $time[1]) . '.' .substr((string)$time[0], 2, 5);

		$fileName = $generationTime . '_create_' . $this->getEntityPluralLower('snake_case') . '_table.php';

		return base_path('database/migrations/' . $fileName);
	}

}