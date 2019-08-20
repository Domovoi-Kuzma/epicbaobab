<?php

class m190820_152140_create_room_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('room', array(
			'ID' => 'pk',
			'Number' => 'varchar(255)',
		));

		$this->insert('room', array(
				'Number' => '301',
			)
		);
		$this->insert('room', array(
				'Number' => '302',
			)
		);
		$this->insert('room', array(
				'Number' => '303',
			)
		);

		$this->addColumn('meets', 'Place', 'int');
		$this->update('meets',	['Place' => 1]);
		//$this->update('meets',	['Place' => 1], ['ID' => 1]);
		//$this->update('meets',	['Place' => 1], ['ID' => 2]);
		//$this->update('meets',	['Place' => 2], ['ID' => 3]);
		//$this->update('meets',	['Place' => 2], ['ID' => 4]);
	}

	public function down()
	{
		$this->dropTable('room');
		$this->dropColumn('meets', 'Place');
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