<?php

namespace app\modules\photo;

/**
 * photo module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\photo\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->modules = [
           'admin' => [
               'class' => 'app\modules\photo\admin\Module',
           ],
           'ui' => [
           'class' => 'app\modules\photo\ui\Module',
           ],
       ];

    }
}
