<?php

use yii\db\Migration;

class m171007_193039_add_column_user_table extends Migration
{
    // public function safeUp()
    // {
    //
    // }
    //
    // public function safeDown()
    // {
    //     echo "m171007_193039_add_column_user_table cannot be reverted.\n";
    //
    //     return false;
    // }


    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('user', 'username', 'string');
    }

    public function down()
    {
        echo "m171007_193039_add_column_user_table cannot be reverted.\n";

        return false;
    }

}
