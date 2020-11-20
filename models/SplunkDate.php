<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

class SplunkDateQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return null|SplunkDateQuery
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @inheritdoc
     * @return null|SplunkDateQuery[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}

class SplunkDate extends ActiveRecord {

    /**
     * @return SplunkDateQuery
     */
    public static function find()
    {
        return new SplunkDateQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%splunk_date}}';
    }
}
