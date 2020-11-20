<?php

namespace app\models;

use Faker\Provider\Uuid;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

class AccountQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return null|AccountQuery
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @inheritdoc
     * @return null|AccountQuery[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}

class Account extends ActiveRecord {
	
	const STATUS_NOT_AVAILABLE = 0;
    const STATUS_AVAILABLE = 1;
	const PROFILE_MISSING = 0;
    const PROFILE_COMPLETED = 1;
	const PAYMENT_COMPLETED = 1;
	const DEFAULT_AVATAR = "default-avatar.png";
    const SLACK_URL = "slack://open";
	
	public $support_id;
	
    /**
     * @return AccountQuery
     */
    public static function find()
    {
        return new AccountQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account}}';
    }
	
	public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => new Expression('UNIX_TIMESTAMP(NOW())')
            ]
        ];
    }
	
	 /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_AVAILABLE],
            ['status_p1', 'default', 'value' => self::STATUS_AVAILABLE],
			['profile_completed', 'default', 'value' => self::PROFILE_MISSING],
			['avatar', 'default', 'value' => self::DEFAULT_AVATAR],
            ['slack_url', 'default', 'value' => self::SLACK_URL],
            ['email', 'email'],
            ['timezone', 'safe'],
            ['password_hash', 'safe', 'on' => 'create'],
        ];
    }
	
	
	public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->uuid = Uuid::uuid();
        }
        return parent::beforeSave($insert);
    }

	 /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
	
	public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
	
	 /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::find()->where(['email' => $email])->one();
    }
	
	public static function findByID($id)
    {
        return static::find()->where(['id' => $id])->one();
    }
	
	public static function findByUsername($username)
    {
        return static::find()->where(['username' => $username])->one();
    }
	
	public static function findByUuid($uuid)
    {
        return static::find()->where(['uuid' => $uuid])->one();
    }
	
	public function getFormattedMobile() {
		
		return substr($this->mobile,0,3)."-".substr($this->mobile,3,3)."-".substr($this->mobile,6);
    }
	
	public function getCreatedDateText() {
        return date('M d, Y H:i:s', $this->created_at);
    }
	
	public function getStatusText() {
		$text = "Available";
		if($this->status == 0)
			$text = "NOT Available";
		
		return $text;
    }
}
