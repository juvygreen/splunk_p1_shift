<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

class ZoneQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return null|ZoneQuery
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @inheritdoc
     * @return null|ZoneQuery[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}

class Zone extends ActiveRecord {

    /**
     * @return ZoneQuery
     */
    public static function find()
    {
        return new ZoneQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%zone}}';
    }
}
