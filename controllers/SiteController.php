<?php

namespace app\controllers;

use app\models\MembershipType;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\Trainer;
use app\models\NotFoundHttpException;
use app\models\Schedule;
use app\models\UserSchedule;
use yii\helpers\ArrayHelper;



class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::info('Пользователь успешно вошел', 'login');
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout(false);
        Yii::$app->session->remove('role');
        Yii::$app->session->remove('__role');
        Yii::$app->session->remove('__role_id');
        Yii::$app->response->cookies->remove('_identity');

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionAdministration()
    {
        return $this->render('administration');
    }

    public function actionRegistration()
    {
        $model = new User();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::info("actionRegistration: Данные загружены из POST", 'registration');
                if ($model->validate()) {
                    $model->role_id = 'client';
                    Yii::info("actionRegistration: role_id перед сохранением: " . $model->role_id, 'registration');
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Регистрация прошла успешно!');
                        return $this->redirect(['site/index']);
                    } else {
                        Yii::error("Ошибка при сохранении пользователя: " . print_r($model->getErrors(), true) . '\nSQL:' . $model->getLastSql(), 'registration');
                        Yii::$app->session->setFlash('error', 'Ошибка при регистрации.');
                    }
                } else {
                    Yii::error("Ошибка валидации: " . print_r($model->getErrors(), true), 'registration');
                    Yii::$app->session->setFlash('error', 'Ошибка при валидации.');
                }
            } else {
                Yii::error("Не удалось загрузить данные из POST запроса.", 'registration');
                Yii::$app->session->setFlash('error', 'Не удалось загрузить данные.');
            }
        }

        return $this->render('registration', [
            'model' => $model,
        ]);
    }

    public function actionProfile()
    {
        $userId = Yii::$app->user->id;
        $user = User::findOne($userId);

        if (!$user) {
            throw new NotFoundHttpException('User not found.');
        }

        $isTrainer = ($user->role_id === 'trainer');
        $trainer = null;

        if ($isTrainer) {
            $trainer = Trainer::findOne($userId);
            if (!$trainer) {
                $trainer = new Trainer(['user_id' => $userId]);
            }
        }

        if (Yii::$app->request->isPost) {
            if ($isTrainer) {
                if ($trainer->load(Yii::$app->request->post())) {
                    if ($trainer->save()) {
                        Yii::$app->session->setFlash('success', 'Информация о тренере успешно сохранена.');
                        return $this->refresh();
                    } else {
                        Yii::$app->session->setFlash('error', 'Ошибка при сохранении информации о тренере.');
                    }
                }
            } else {
                Yii::$app->session->setFlash('error', 'У вас нет прав для редактирования информации о тренере.');
            }
        }

        return $this->render('profile', [
            'user' => $user,
            'isTrainer' => $isTrainer,
            'trainer' => $trainer,
        ]);
    }

    public function actionSchedule()
    {
        $userId = Yii::$app->user->id;
        $user = User::findOne($userId);

        if (!$user) {
            throw new NotFoundHttpException('User not found.');
        }

        $weekStart = Yii::$app->request->get('weekStart');
        $schedules = [];

        if ($user->role_id === 'trainer') {
            $schedules = Schedule::find()
                ->where(['trainer_id' => $userId])
                ->orderBy(['start_time' => SORT_ASC])
                ->all();
        } else {
            $schedules = Schedule::find()
                ->innerJoin('user_schedule', 'schedule.id = user_schedule.schedule_id')
                ->where(['user_schedule.user_id' => $userId])
                ->orderBy(['start_time' => SORT_ASC])
                ->all();

            $registeredScheduleIds = UserSchedule::find()
                ->select(['schedule_id'])
                ->where(['user_id' => $userId])
                ->column();
        }

        $data = $this->groupSchedulesByDayAndTime($schedules, $weekStart);
        $trainersList = [];
        $trainers = User::find()->where(['role_id' => 'trainer'])->all();
        $trainersList = ArrayHelper::map($trainers, 'id', function ($trainer) {
            return $trainer->first_name . ' ' . $trainer->last_name;
        });

        return $this->render('schedule', [
            'user' => $user,
            'scheduleData' => $data['scheduleData'],
            'days' => $data['days'],
            'trainersList' => $trainersList,
            'registeredSchedulesIds' => $registeredScheduleIds,
        ]);
    }

    public function actionAllSchedules()
    {
        $userId = Yii::$app->user->id;
        $weekStart = Yii::$app->request->get('weekStart');
        $schedules = Schedule::find()
            ->orderBy(['start_time' => SORT_ASC])
            ->all();

        $registeredScheduleIds = UserSchedule::find()
            ->select(['schedule_id'])
            ->where(['user_id' => $userId])
            ->column();

        $data = $this->groupSchedulesByDayAndTime($schedules, $weekStart);

        return $this->render('schedule', [
            'scheduleData' => $data['scheduleData'],
            'days' => $data['days'],
            'registeredSchedulesIds' => $registeredScheduleIds,
        ]);
    }

    public function actionPartialSchedule()
    {
        $userId = Yii::$app->user->id;
        $weekStart = Yii::$app->request->get('weekStart');
        $schedules = [];

        $user = User::findOne($userId);
        if (!$user) {
            throw new NotFoundHttpException('User not found.');
        }

        if ($user->role_id === 'trainer') {
            $schedules = Schedule::find()
                ->where(['trainer_id' => $userId])
                ->orderBy(['start_time' => SORT_ASC])
                ->all();
        } else {
            $schedules = Schedule::find()
                ->innerJoin('user_schedule', 'schedule.id = user_schedule.schedule_id')
                ->where(['user_schedule.user_id' => $userId])
                ->orderBy(['start_time' => SORT_ASC])
                ->all();

            $registeredScheduleIds = UserSchedule::find()
                ->select(['schedule_id'])
                ->where(['user_id' => $userId])
                ->column();
        }

        $data = $this->groupSchedulesByDayAndTime($schedules, $weekStart);

        return $this->renderPartial('partial_schedule', [
            'scheduleData' => $data['scheduleData'],
            'days' => $data['days'],
            'registeredSchedulesIds' => isset($registeredScheduleIds) ? $registeredScheduleIds : [],
            'weekStart' => $weekStart,
        ]);
    }

    private function groupSchedulesByDayAndTime($schedules, $weekStart = null)
    {
        $scheduleData = [];
        $days = [];
        $times = ['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];

        $currentDate = $weekStart ? new \DateTime($weekStart, new \DateTimeZone('Europe/Moscow')) : new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
        $currentWeekDay = (int)$currentDate->format('N');
        $startOfWeek = clone $currentDate;
        $startOfWeek->modify('-' . ($currentWeekDay - 1) . ' days');

        for ($i = 0; $i < 7; $i++) {
            $day = clone $startOfWeek;
            $day->modify("+$i days");
            $days[] = [
                'label' => ['ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ', 'ВС'][$i],
                'date' => $day->format('Y-m-d'),
            ];
        }

        foreach ($days as $day) {
            $scheduleData[$day['label']] = [];
            foreach ($times as $time) {
                $scheduleData[$day['label']][$time] = null;
            }
        }

        foreach ($schedules as $schedule) {
            $timeZone = new \DateTimeZone('Europe/Moscow');
            $date = new \DateTime($schedule->start_time, $timeZone);
            $startTime = $date->format('H:i');
            $scheduleDate = $date->format('Y-m-d');
            $dayOfWeek = date('D', $date->getTimestamp());
            $dayOfWeek = strtoupper(substr($dayOfWeek, 0, 2));

            $dayMap = [
                'MO' => 'ПН',
                'TU' => 'ВТ',
                'WE' => 'СР',
                'TH' => 'ЧТ',
                'FR' => 'ПТ',
                'SA' => 'СБ',
                'SU' => 'ВС',
            ];
            $dayOfWeek = isset($dayMap[$dayOfWeek]) ? $dayMap[$dayOfWeek] : null;

            if ($dayOfWeek && in_array($startTime, $times)) {
                foreach ($days as $day) {
                    if ($day['label'] === $dayOfWeek && $day['date'] === $scheduleDate) {
                        $scheduleData[$dayOfWeek][$startTime] = $schedule;
                    }
                }
            }
        }

        return [
            'scheduleData' => $scheduleData,
            'days' => $days,
        ];
    }

    public function actionRegisterForTraining()
    {
        $scheduleId = Yii::$app->request->post('schedule_id');
        $userId = Yii::$app->user->id;

        if ($scheduleId && $userId) {
            $userSchedule = new UserSchedule();
            $userSchedule->user_id = $userId;
            $userSchedule->schedule_id = $scheduleId;

            if ($userSchedule->save()) {
                Yii::$app->session->setFlash('success', 'Вы успешно записались на тренировку.');
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при записи на тренировку.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Некорректные данные.');
        }

        return $this->redirect(['site/schedule']);
    }

    public function actionMemberships()
    {
        $membeshipTypes = MembershipType::find()->all();

        return $this->render('memberships', ['membershipTypes' => $membeshipTypes,]);
    }
}
