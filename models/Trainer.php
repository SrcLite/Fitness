<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "trainers".
 *
 * @property int $user_id
 * @property string|null $bio
 * @property string|null $specializations
 * @property string|null $certifications
 * @property int|null $experience_years
 *
 * @property User $user
 */
class Trainer extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trainers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'experience_years'], 'integer'],
            [['bio'], 'string'],
            [['specializations', 'certifications'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'bio' => 'Биография',
            'specializations' => 'Специализации',
            'certifications' => 'Сертификаты',
            'experience_years' => 'Стаж работы (лет)',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}