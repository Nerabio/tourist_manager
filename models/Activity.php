<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "activity".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $status_id
 * @property int $adress_id
 * @property string $mark
 * @property string $color
 * @property string $picture_url
 * @property int $look_counter
 * @property int $owner_user_id
 * @property int $creator_user_id
 * @property int $modyfy_user_id
 * @property string $date_start
 * @property string $date_end
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $modyfyUser
 * @property User $creatorUser
 * @property User $ownerUser
 */
class Activity extends \yii\db\ActiveRecord
{
    public $isFavorite = false;

    public $imageFile;

    const DEFAULT_IMAGE = 'uploads/default_image.jpg';
    const DEFAULT_COLOR = '#c0c0c0';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'activity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'owner_user_id', 'description','adress_id', 'date_start', 'date_end'], 'required'],
            [['status_id', 'adress_id', 'look_counter', 'owner_user_id', 'creator_user_id', 'modyfy_user_id'], 'integer'],
            [['date_start', 'date_end', 'created_at', 'updated_at', 'mark', 'picture_url'], 'safe'],
            [['title', 'description', 'mark', 'picture_url'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 7],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 1],
            [['modyfy_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['modyfy_user_id' => 'id']],
            [['creator_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_user_id' => 'id']],
            [['owner_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Описание',
            'status_id' => 'Статус',
            'adress_id' => 'Адрес',
            'mark' => 'Метка',
            'color' => 'Цвет для фона',
            'picture_url' => 'Изображение',
            'imageFile' => 'Изображение',
            'look_counter' => 'Счетчик',
            'owner_user_id' => 'Ответственный за мероприятие',
            'creator_user_id' => 'Creator User ID',
            'modyfy_user_id' => 'Modyfy User ID',
            'date_start' => 'Дата начала',
            'date_end' => 'Дата завершения',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModyfyUser()
    {
        return $this->hasOne(User::className(), ['id' => 'modyfy_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatorUser()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwnerUser()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdress()
    {
        return $this->hasOne(Address::className(), ['id' => 'adress_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavoritActivities()
    {
        return $this->hasMany(FavoritActivity::className(), ['activity_id' => 'id']);
    }

    public function getPictureUrl()
    {
        return $this->picture_url ? Yii::getAlias('@web/'.$this->picture_url) : Yii::getAlias('@web/'.self::DEFAULT_IMAGE);
    }

    public function getColor()
    {
        return $this->color ? $this->color : self::DEFAULT_COLOR;
    }
}
