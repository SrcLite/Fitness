<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

class User extends ActiveRecord implements IdentityInterface
{
    public $password_repeat;  // Не является полем таблицы, используется для валидации
    public $password;

    public static function tableName()
    {
        return 'users';  // Укажите имя вашей таблицы
    }

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'email', 'password', 'phone_number'], 'required'], 
            [['first_name', 'last_name', 'email', 'phone_number', 'role_id'], 'required', 'on' => 'update'], 
            [['first_name', 'last_name'], 'string', 'max' => 100],
            [['email', 'password_hash'], 'string', 'max' => 255], 
            [['phone_number'], 'string', 'max' => 20],
            [['created_at', 'updated_at'], 'safe'],
            [['role_id'], 'in', 'range' => ['client', 'admin', 'trainer'], 'on' => 'admin'],
            [['role_id'], 'default', 'value' => 'client'], 
            [['role_id'], 'string', 'max' => 20], 
            [['role_id'], 'safe'],
            [['email'], 'email'],
            [['email'], 'unique'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли должны совпадать'],
            ['password', 'string', 'min' => 6, 'tooShort' => 'Пароль должен быть не менее 6 символов'],
            ['phone_number', 'match', 'pattern' => '/^\+?[0-9\s-]+$/', 'message' => 'Неверный формат номера телефона.'],
        ];
    }

     public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['first_name', 'last_name', 'email', 'password', 'phone_number', 'role_id', 'password_repeat']; // Include password and repeat
        $scenarios['update'] = ['first_name', 'last_name', 'email', 'phone_number', 'role_id'];//  No password here
            return $scenarios;
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Роль',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'email' => 'Email',
            'password' => 'Пароль',
            'phone_number' => 'Телефон',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
                $this->auth_key = bin2hex(random_bytes(32));
                Yii::info("beforeSave: auth_key после генерации: " . $this->auth_key . ", role_id: " . $this->role_id, 'registration');
            }
            return true;
        }
        return false;
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }


    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function getRole()
    {
            Yii::info("getRole() вызван для пользователя ID: " . $this->id, 'debug');
        if (Yii::$app->session->has('role') && Yii::$app->session->get('__role_id') === $this->id) {
            Yii::info("Роль получена из сессии: " . Yii::$app->session->get('role'), 'debug');
            return Yii::$app->session->get('role');
        } else {
            Yii::info("Роль отсутствует в сессии или устарела. Обновление из БД...", 'debug');
            $user = self::findOne($this->id);
             Yii::info("Роль из базы данных: " . $user->role_id, 'debug');
            Yii::$app->session->set('role', $user->role_id);
            Yii::$app->session->set('__role_id', $this->id);
            return $user->role_id;
        }
    }

        /**
     * Gets query for [[UserSchedules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserSchedules()
    {
        return $this->hasMany(UserSchedule::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Schedules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchedules()
    {
        return $this->hasMany(Schedule::class, ['id' => 'schedule_id'])->via('userSchedules');
    }

    /**
     * Gets query for [[TrainerSchedules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrainerSchedules()
    {
        return $this->hasMany(Schedule::class, ['trainer_id' => 'id']);
    }
}