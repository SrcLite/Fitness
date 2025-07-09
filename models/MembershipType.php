<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

  /**
     * This is the model class for table "membership_types".
     *
     * @property int $id
     * @property string $name
     * @property string|null $description
     * @property string $price
     * @property int|null $duration_days
     * @property int|null $allowed_group_classes
     */

class MembershipType extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'membership_types';
    }

     /**
     * {@inheritdoc}
     */

    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['duration_days', 'allowed_group_classes'], 'integer'],
            [['name'], 'string, max' => 100],
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
            'desciption' => 'Desciption',
            'price' => 'price',
            'duration_days' => 'Duration Days',
            'allowed_group_classes' => 'Allowed Group Classes',
        ];
    }
}