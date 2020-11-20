<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

class SupportGroupShiftQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return null|SupportGroupShiftQuery
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @inheritdoc
     * @return null|SupportGroupShiftQuery[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}

class SupportGroupShift extends ActiveRecord {

    /**
     * @return SupportGroupShiftQuery
     */
    public static function find()
    {
        return new SupportGroupShiftQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%support_group_shift}}';
    }
    
    public static function flatForm($resource)
    {
		return ['id' => $resource->id, 'name' => $resource->name];
	}
	
}
