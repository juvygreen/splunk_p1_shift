<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

class SupportGroupQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return null|SupportGroupQuery
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @inheritdoc
     * @return null|SupportGroupQuery[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}

class SupportGroup extends ActiveRecord {

    /**
     * @return SupportGroupQuery
     */
    public static function find()
    {
        return new SupportGroupQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%support_group}}';
    }
}
