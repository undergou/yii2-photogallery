<?php

use yii\db\Migration;

/**
 * Handles the creation of table `image`.
 */
class m171007_180218_create_image_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('image', [
            'id' => $this->primaryKey(),
            'author' => $this->string(),
            'category' => $this->string(),
            'title' => $this->string(),
            'date' => $this->date(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('image');
    }
}
