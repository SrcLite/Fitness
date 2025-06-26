<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "schedule".
 *
 * @property int $id
 * @property int $gym_location_id
 * @property int $trainer_id
 * @property int $training_program_id
 * @property string $start_time
 * @property string $end_time
 * @property string $type
 * @property int $capacity
 * @property string|null $description
 *
 * @property GymLocation $gymLocation
 * @property User $trainer
 * @property TrainingPrograms $trainingProgram
 */
class Schedule extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'schedule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gym_location_id', 'trainer_id', 'training_program_id', 'start_time', 'end_time', 'type', 'capacity'], 'required'],
            [['gym_location_id', 'trainer_id', 'training_program_id', 'capacity'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
            [['type'], 'string'],
            [['description'], 'string'],
            [['gym_location_id'], 'exist', 'skipOnError' => true, 'targetClass' => GymLocation::class, 'targetAttribute' => ['gym_location_id' => 'id']],
            [['trainer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['trainer_id' => 'id']],
            [['training_program_id'], 'exist', 'skipOnError' => true, 'targetClass' => TrainingPrograms::class, 'targetAttribute' => ['training_program_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gym_location_id' => 'Gym Location ID',
            'trainer_id' => 'Trainer ID',
            'training_program_id' => 'Training Program ID',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'type' => 'Type',
            'capacity' => 'Capacity',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[GymLocation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGymLocation()
    {
        return $this->hasOne(GymLocation::class, ['id' => 'gym_location_id']);
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

    /**
     * Gets query for [[TrainingProgram]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrainingProgram()
    {
        return $this->hasOne(TrainingPrograms::class, ['id' => 'training_program_id']);
    }
}