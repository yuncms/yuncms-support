<?php

namespace yuncms\support\migrations;

use yii\db\Migration;

class M171114024553Create_support_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        /**
         * 赞表
         */
        $this->createTable('{{%support}}', [
            'id' => $this->primaryKey()->unsigned()->comment('ID'),
            'user_id' => $this->integer()->unsigned()->notNull()->comment('User ID'),
            'model_id' => $this->integer()->notNull()->comment('Model ID'),
            'model' => $this->string(100)->notNull()->comment('Model'),
            'created_at' => $this->integer()->unsigned()->notNull()->comment('Created At'),
            'updated_at' => $this->integer()->unsigned()->notNull()->comment('Updated At'),
        ], $tableOptions);

        $this->addForeignKey('{{%support_fk_1}}', '{{%support}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
        $this->createIndex('{{%support_index}}', '{{%support}}', ['model_id', 'model'], false);
    }

    public function safeDown()
    {
        $this->dropTable('{{%support}}');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M171114024553Create_support_table cannot be reverted.\n";

        return false;
    }
    */
}
