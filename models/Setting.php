<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

class SettingQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return null|SettingQuery
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @inheritdoc
     * @return null|SettingQuery[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}

class Setting extends ActiveRecord {

    /**
     * @return SettingQuery
     */
    public static function find()
    {
        return new SettingQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%setting}}';
    }
}
