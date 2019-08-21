<?php

class m190820_150529_create_department_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('department', array(
											'ID' => 'pk',
											'Caption' => 'varchar(255)',
											)
		);
		$this->insert('department', array(
											'Caption' => 'IT',
										)
		);
		$this->insert('department', array(
											'Caption' => 'HQ',
										)
		);

		$this->addColumn('people', 'Dept_ID', 'int');
		$this->update('people', array(
			'Dept_ID' => '1'),
			'ID=1'
		);
		$this->update('people', array(
			'Dept_ID' => '1'),
			'ID=2'
		);
		$this->update('people', array(
			'Dept_ID' => '2'),
			'ID=3'
		);
		//$this->update('people',	['Dept_ID' => 1], ['ID' => 2]);
		//$this->update('people',	['Dept_ID' => 2], ['ID' => 3]);
	}

	public function down()
	{
		$this->dropTable('department');
		$this->dropColumn('people', 'Dept_ID');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}