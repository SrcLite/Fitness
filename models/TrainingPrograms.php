<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "training_programs".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $duration_weeks
 * @property string $focus_area
 * @property int $trainer_id
 *
 * @property Schedule[] $schedules
 * @property User $trainer
 */
class TrainingPrograms extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'training_programs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'duration_weeks', 'focus_area', 'trainer_id'], 'required'],
            [['description', 'focus_area'], 'string'],
            [['duration_weeks', 'trainer_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['trainer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['trainer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'duration_weeks' => 'Duration Weeks',
            'focus_area' => 'Focus Area',
            'trainer_id' => 'Trainer ID',
        ];
    }

    /**
     * Gets query for [[Schedules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(Schedule::class, ['training_program_id' => 'id']);
    }

    /**
     * Gets query for [[Trainer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrainer()
    {
        return $this->hasOne(User::class, ['id' => 'trainer_id']);
    }
}