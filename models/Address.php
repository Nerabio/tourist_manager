<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property int $id
 * @property string $title
 * @property int $type
 * @property int $creator_user_id
 * @property int $modyfy_user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Activity[] $activities
 * @property User $creatorUser
 * @property User $modyfyUser
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['type', 'creator_user_id', 'modyfy_user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['creator_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_user_id' => 'id']],
            [['modyfy_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['modyfy_user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'type' => 'Type',
            'creator_user_id' => 'Creator User ID',
            'modyfy_user_id' => 'Modyfy User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::className(), ['adress_id' => 'id']);
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
    public function getModyfyUser()
    {
        return $this->hasOne(User::className(), ['id' => 'modyfy_user_id']);
    }
}
