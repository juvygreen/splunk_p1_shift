<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

class RotationQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return null|RotationQuery
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @inheritdoc
     * @return null|RotationQuery[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}

class Rotation extends ActiveRecord {

    /**
     * @return RotationQuery
     */
    public static function find()
    {
        return new RotationQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rotation}}';
    }
}
