<?php
use yii\db\Schema;
use yii\db\Migration;
use yii\db\Expression;
use backend\models\User;

class m170223_045726_change_admin_table extends Migration
{
	public function up()
	{
		$this->dropTable('{{%admin}}');
		$this->createTable('{{%admin}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'status' => $this->smallInteger()->notNull()
            	->defaultValue(User::STATUS_ACTIVE),
			'created_at' => $this->dateTime(),
			'updated_at' => $this->dateTime(),
		]);
		$this->insert('{{%admin}}', [
			'id' => 1,
			'username' => 'admin',
			'email' => 'admin@m.mm',
			'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('123123'),
			'status' => User::STATUS_ACTIVE,
			'created_at' => date('Y-m-d H:i:s'),
			'updated_at' => date('Y-m-d H:i:s'),
		]);
	}

	public function down()
	{
		// revert old admin table
		$this->dropTable('{{%admin}}');
		$this->createTable('{{%admin}}', [
			'id' => $this->primaryKey(),
			'name' => $this->string(255),
			'email' => $this->string(255)->notNull(),
			'password' => $this->string()->notNull(),
			'remember_token' => $this->string(100)->notNull(),
			'created_at' => $this->timestamp()
				->defaultValue(new Expression('CURRENT_TIMESTAMP')),
			'updated_at' => $this->timestamp()
				->defaultValue(new Expression('CURRENT_TIMESTAMP')),
		]);

		return true;
	}

	/*
	// Use safeUp/safeDown to run migration code within a transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
