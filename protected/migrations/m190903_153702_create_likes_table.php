<?php

class m190903_153702_create_likes_table extends CDbMigration
{
	public function up()
	{

        $this->createTable('like', array(
            'ID' => 'pk',
            'user_id' => 'int',
            'meet_id' => 'int',
        ));
        $this->createIndex('likeIndex', 'like', 'meet_id,user_id', true);
	}

	public function down()
	{
	    $this->dropTable('like');
		return true;
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