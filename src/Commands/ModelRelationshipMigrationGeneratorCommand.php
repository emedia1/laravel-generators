<?php

namespace EMedia\Generators\Commands;

class ModelRelationshipMigrationGeneratorCommand extends BaseGeneratorCommand
{

	protected $name = 'scaffold:model:relationship:migration';
	protected $description = 'Scaffold a model relationship migration through migration generator';
	protected $type = 'Model Relationship Migration';


	/**
	 * Get the stub file for the generator.
	 *
	 * @return string
	 */
	protected function getStub()
	{
		return __DIR__ . '/../../Stubs/migrations/ModelRelationshipMigration.stub';
	}

	protected function getPath($name)
	{
		// get microtime of file generation to preserve migration sequence
		$time = explode(" ",microtime());

		// change the format to 2008_07_14_010813.982
		$generationTime = date("Y_m_d_His", $time[1]) . '.' .substr((string)$time[0], 2, 5);

		$fileName = $generationTime . '_create_file_' . $this->getEntitySingularNameLower() . '_table.php';

		return base_path('database/migrations/' . $fileName);
	}

}