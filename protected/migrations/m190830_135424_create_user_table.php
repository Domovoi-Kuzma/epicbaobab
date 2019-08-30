<?php

class m190830_135424_create_user_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('user', array(
			'ID' => 'pk',
			'username' => 'varchar(255)',
			'password' => 'varchar(255)',
			'profile' => 'varchar(255)',//"enum('admin', 'guest'"
		));
		$this->insertMultiple('user',[
                                        ['username' => 'admin', 'password' => 'admin', 'profile' => 'admin',],
                                        ['username' => 'user',  'password' => 'user',  'profile' => 'guest',],
                             ]);
	}

	public function down()
	{
		$this->dropTable('user');
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