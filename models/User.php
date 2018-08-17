<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $phone
 * @property int $status
 * @property int $role
 * @property int $creator_user_id
 * @property int $modyfy_user_id
 * @property string $created_at
 * @property string $updated_at
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 1;

    const STATUS_CANCELED_PARTICIPATION = 2;
    const STATUS_SENT_QUESTION = 3;
    const STATUS_RECEIVED_INVITATION = 4;
    const STATUS_CONFIRMED_PARTICIPATION = 5;
    const STATUS_SEND_FEEDBACK = 6;
    const STATUS_SATISFIED_ACTIVITY = 7;
    const STATUS_NOT_SATISFIED_ACTIVITY = 8;
    const STATUS_MARKED_DELETION = 9;

    const ROLE_TOURIST =  0;
    const ROLE_MANAGER = 1;
    const ROLE_ADMIN = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'phone'], 'required'],
            [['status', 'role', 'creator_user_id', 'modyfy_user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'phone'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['phone'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }


    public function getStatusSpr()
    {
        return [
            User::STATUS_BLOCKED => 'Заблокирован',
            User::STATUS_ACTIVE => 'Активен',
            User::STATUS_CANCELED_PARTICIPATION => 'Отменил участие',
            User::STATUS_SENT_QUESTION  => 'Отправил вопрос',
            User::STATUS_RECEIVED_INVITATION  => 'Получил приглашение',
            User::STATUS_CONFIRMED_PARTICIPATION  => 'Подтвердил участие',
            User::STATUS_SEND_FEEDBACK => 'Отправил отзыв',
            User::STATUS_SATISFIED_ACTIVITY  => 'Удовлетворен мероприятием',
            User::STATUS_NOT_SATISFIED_ACTIVITY  => 'Не удовлетворен мероприятием',
            User::STATUS_MARKED_DELETION  => 'Отмечен на удаление'
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Имя',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Почта',
            'phone' => 'Телефон',
            'status' => 'Статус',
            'role' => 'Роль',
            'creator_user_id' => 'Создал',
            'modyfy_user_id' => 'Изменил',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
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

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function getFavoritActivities()
    {
        return $this->hasMany(FavoritActivity::className(), ['user_id' => 'id']);
    }

}
