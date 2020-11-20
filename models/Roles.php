<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

class RolesQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return null|RolesQuery
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @inheritdoc
     * @return null|RolesQuery[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}

class Roles extends ActiveRecord {

    /**
     * @return RolesQuery
     */
    public static function find()
    {
        return new RolesQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%roles}}';
    }
}
