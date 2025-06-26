<?php
/** @var yii\web\View $this */
use yii\helpers\Url;
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Json;
/* @var $user app\models\User */
/* @var $scheduleData array */
/* @var $trainersList array */
/* @var $registeredSchedulesIds array */
$this->title = 'Расписание';

AppAsset::register($this);

$this->registerCssFile(
    Url::to('@web/css/schedule_style.css'),
    [
        'appendTimastamp' => true,
    ]
);

$days = ['ПН', 'ВТ', 'СР', 'ЧТ', 'ПТ', 'СБ', 'ВС'];
$times = ['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];

?>

<body>
    <a href="#x" class="overlay" id="win1"></a>
    <div class="popup">

        <div class="head">
            <a class="close" title="Закрыть" href="#close"></a>
            <h1>ВЫБЕРИТЕ ГОРОД</h1>
        </div>
        <div class="listc">
            <div class="city1">
                <p>БЕЛОГОРОД</p>
            </div>
            <div class="city2">
                <p>ВОРОНЕЖ</p>
            </div>
            <div class="city3">
                <p>МОСКВА</p>
            </div>
            <div class="city4">
                <p>РОСТОВ-НА-ДОНУ</p>
            </div>
            <div class="city5">
                <p>КРАСНОДАР</p>
            </div>
            <div class="city6">
                <p>ЧЕЛЯБИНСК</p>
            </div>
            <div class="city6">
                <p>СТАВРОПОЛЬ</p>
            </div>
            <div class="city7">
                <p>ПЯТИГОРСК</p>
            </div>
        </div>
    </div>


    <header class="header">
        <a href="index" class="back"><img src="<?= Yii::$app->request->baseUrl ?>/images/LOGO.png"></a>
        <a class="bt1" href="#win1">
            <p><b>Выбрать клуб</b></p>
        </a>
        <nav>
            <a href="<?= Url::to(['site/index']) ?>">Главная</a>
            <?php echo Html::a(
                'Расписание',
                ['site/schedule'],
                ['class' => 'btn btn-primary']
            );
            ?>
            <a id="link4" href="Index2.html">Фитнес-гид</a>
            <?php
            if (!Yii::$app->user->isGuest && Yii::$app->user->identity !== null && Yii::$app->user->identity->getRole() === 'admin'):
                Yii::info("Роль пользователя: " . Yii::$app->user->identity->getRole(), 'debug'); ?>
                <a href="<?= Url::to(['user/index']) ?>" class="link-admin">Администрирование</a>
            <?php endif; ?>
            <?php if (Yii::$app->user->isGuest): ?>
                <a class="link-reg" href="<?= Url::to(['site/registration']) ?>">Зарегистрироваться</a>
                </a>
                <a class="link-login" href="<?= Url::to(['site/login']) ?>">Войти</a>
            <?php else: ?>
                <a class="link-profile"
                    href="<?= Url::to(['site/profile']) ?>"><?= Html::encode(Yii::$app->user->identity->first_name . ' ' . Yii::$app->user->identity->last_name) ?>
                </a>
                <?php
                echo Html::beginForm(['/site/logout'], 'post', ['class' => 'logout-form']);
                echo Html::submitButton(
                    'Выход',
                    ['class' => 'btn btn-link logout', 'id' => 'btn-logout']
                );
                echo Html::endForm();
                ?>
                </div>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <div class="heading">
            <h1>Расписание тренировок</h1>
            <div class="schedule-buttons">
                <div class="schedule-bt1">
                    <?= Html::a('Мое расписание', ['site/schedule'], ['class' => 'btn btn-primary']) ?>
                </div>
                <div class="schedule-bt2">
                    <?= Html::a('Общее расписание', ['site/all-schedules'], ['class' => 'btn btn-secondary']) ?>
                </div>
            </div>
        </div>
        <!-- <div class="sort-common">
            <div class="sort-left">
                <div class="sort-trainer">
                    <select>
                        <option value="" disabled="true" selected="true">Тренер</option>
                        <?php if (is_array($trainersList)): ?>
                            <?php foreach ($trainersList as $id => $name): ?>
                                <option value="<?= $id ?>"><?= Html::encode($name) ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value=''>Нет тренеров</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="sort-date">
                    <select>
                        <option value="" disabled="true" selected="true">Дата</option>
                    </select>
                </div>
            </div>
            <div class="sort-right">
                <div class="sort-week">
                    <button class="sort-week-but">
                        <div class="sort-week-but-img">
                            <img src="">
                        </div>
                        <div class="sort-week-but-text">Неделя</div>
                    </button>
                </div>
                <div class="sort-day">
                    <button class="sort-day-but">
                        <div class="sort-day-but-img">
                            <img src="">
                        </div>
                        <div class="sort-day-but-text">День</div>
                    </button>
                </div>
            </div>
        </div> -->
        <hr class="line-head">
        </hr>
        <div class="schedule-outer-common">
            <div class="schedule-common">
                <div class="schedule-header-days-common">
                    <div class="schedule-header-but-prev"><button><img
                                src="<?= Yii::$app->request->baseUrl ?>/images/Arrow 2.svg"></button></div>
                    <div class="schedule-header-days">
                        <?php foreach ($days as $day): ?>
                            <div class="schedule-header-day">
                                <?= Html::encode($day) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="schedule-header-but-next"><button><img
                                src="<?= Yii::$app->request->baseUrl ?>/images/Arrow 1.svg"></button></div>
                </div>
                <div class="schedule-header-time-common">
                    <?php // if (!empty($scheduleData)): ?>
                    <?php foreach ($times as $timeIndex => $time): ?>
                        <div class="schedule-header-time-<?= $timeIndex + 1 ?>-common">
                            <div class="schedule-header-time-<?= $timeIndex + 1 ?>">
                                <?= Html::encode($time) ?>
                            </div>
                            <div class="schedule-main-<?= $timeIndex + 1 ?>-common">
                                <?php foreach ($days as $dayIndex => $day): ?>
                                    <?php
                                    $schedule = isset($scheduleData[$day][$time]) ? $scheduleData[$day][$time] : null;
                                    $cellClass = "schedule-main-time-" . ($timeIndex + 1) . "-day-" . ($dayIndex + 1);

                                    ?>
                                    <div id="schedule-main-<?= $timeIndex + 1 ?>" class="<?= $cellClass ?>">
                                        <?php if ($schedule): ?>
                                            <?php
                                            Yii::info("Before check Registered Schedule IDs in schedule.php", 'schedule');
                                            Yii::info("Registered Schedule IDs in schedule.php: " . print_r($registeredSchedulesIds, true), 'schedule');
                                            Yii::info("Schedule ID: " . $schedule->id, 'schedule');
                                            $isRegistered = isset($registeredSchedulesIds) && is_array($registeredSchedulesIds) && in_array($schedule->id, $registeredSchedulesIds) ? true : false;
                                            Yii::info("Is Registered: " . $isRegistered, 'schedule');
                                            ?>
                                            <div class="event">
                                                <div class="event-color"></div>
                                                <div class="event-info">
                                                    <?php if ($schedule && $schedule->start_time && $schedule->end_time): ?>
                                                        <?php
                                                        $timeZone = new \DateTimeZone('Europe/Moscow'); // Укажите вашу таймзону
                                                        $startTime = new \DateTime($schedule->start_time);
                                                        $startTime->setTimezone($timeZone);
                                                        $endTime = new \DateTime($schedule->end_time);
                                                        $endTime->setTimezone($timeZone);
                                                        ?>
                                                        <div class="time"><?= $startTime->format('H:i') ?> -
                                                            <?= $endTime->format('H:i') ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if ($schedule && $schedule->trainingProgram): ?>
                                                        <div class="event-name"><?= Html::encode($schedule->trainingProgram->name) ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <?php if ($schedule && $schedule->trainer): ?>
                                                        <div class="trainer-name">
                                                            <?= Html::encode($schedule->trainer->first_name . ' ' . $schedule->trainer->last_name) ?>
                                                        </div>
                                                    <?php endif; ?>

                                                    <!-- Добавляем форму для записи -->
                                                    <?php if (Yii::$app->user->identity->role_id === 'client' && !$isRegistered): ?>
                                                        <?= Html::beginForm(['site/register-for-training'], 'post') ?>
                                                        <?= Html::hiddenInput('schedule_id', $schedule->id) ?>
                                                        <?= Html::submitButton('Записаться', ['class' => 'btn-btn-primary']) ?>
                                                        <?= Html::endForm() ?>
                                                    <?php endif; ?>
                                                    <?php if ($isRegistered): ?>
                                                        <p class="already-registered">Вы уже записаны</p>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php //else: ?>
                    <!-- <p>Нет данных для отображения.</p> -->
                    <?php //endif; ?>
                </div>
            </div>
        </div>
    </main>
    <hr class="line-footer">
    <footer>
        <div class="all">
            <div class="inf">
                <p>ФЕДЕРАЛЬНАЯ СЕТЬ ФИТНЕС-КЛУБОВ БОМОНД</p>
                <button class="bt5">Заказать звонок</button>
            </div>
            <div class="links">
                <a href="#">Найти свой зал</a>
                <a href="#">Начать тренировки</a>
                <a href="#">Узнать о компании</a>
                <a href="#">Фитнес для детей</a>
                <a href="#">Фитнес-гид</a>
                <a href="#">Фитнес-онлайн</a>
            </div>
        </div>
        <div class="undertext">
            <p>© БОМОНД 2011-2023 | Все права защищены.
                ООО "БОМОНД" Адрес: 188689, Ленинrрадская область, Всеволожский район, город Кудрово, ул.
                Ленинградская
                (Новый Оккервиль мкр) дом 1, помещение 2-Н
                Копирование материалов данного сайта без разрешения правообладателя запрещено.</p>
        </div>
    </footer>
</body>