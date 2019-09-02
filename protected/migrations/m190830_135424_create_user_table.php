<?php

class m190830_135424_create_user_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('user', array(
			'ID' => 'pk',
			'username' => 'varchar(255)',
			'password' => 'varchar(255)',
			//'profile' => 'varchar(255)',//"enum('admin', 'guest'"
			'profile' => "enum('signed','admin')",
		));
		$this->insertMultiple('user',[
            ['username' => 'admin', 'password' => '$2y$13$q1NwjMjGO6GMSX2DAVuMu.Qqit9o9yAx.kVaIOX/ydcPPDbwCAbPe', 'profile' => 'admin',],
			['username' => 'John',  'password' => '$2y$13$q1NwjMjGO6GMSX2DAVuMu.Qqit9o9yAx.kVaIOX/ydcPPDbwCAbPe',  'profile' => 'signed',],
			['username' => 'Rambo', 'password' => '$2y$13$pa8t1ssT62LqlRcTVDp2Ge.nKF1DQnYy5JOcstvZgM.f6.1pMaPJm',  'profile' => 'signed',],
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