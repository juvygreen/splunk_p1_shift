<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

class RegionQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return null|RegionQuery
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @inheritdoc
     * @return null|RegionQuery[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}

class Region extends ActiveRecord {

    /**
     * @return RegionQuery
     */
    public static function find()
    {
        return new RegionQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%region}}';
    }
}
