<?php

/** @var yii\web\View $this */

use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $scheduleData array */
/* @var $days array */
/* @var $registeredSchedulesIds array */

AppAsset::register($this);

$this->registerCssFile(
    Url::to('@web/css/schedule_style.css'),
    [
        'appendTimestamp' => true,
    ]
);

$times = ['10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];
?>

<div class="schedule-common">
    <div class="schedule-header-days-common">
        <div class="schedule-header-but-prev">
            <button onclick="changeWeek(-1)"><img src="<?= Yii::$app->request->baseUrl ?>/images/Arrow 2.svg"></button>
        </div>
        <div class="schedule-header-days">
            <?php foreach ($days as $day): ?>
                <div class="schedule-header-day">
                    <?= Html::encode($day['label']) ?> (<?= (new \DateTime($day['date']))->format('d.m') ?>)
                </div>
            <?php endforeach; ?>
        </div>
        <div class="schedule-header-but-next">
            <button onclick="changeWeek(1)"><img src="<?= Yii::$app->request->baseUrl ?>/images/Arrow 1.svg"></button>
        </div>
    </div>
    <div class="schedule-header-time-common">
        <?php foreach ($times as $timeIndex => $time): ?>
            <div class="schedule-header-time-<?= $timeIndex + 1 ?>-common">
                <div class="schedule-header-time-<?= $timeIndex + 1 ?>">
                    <?= Html::encode($time) ?>
                </div>
                <div class="schedule-main-<?= $timeIndex + 1 ?>-common">
                    <?php foreach ($days as $dayIndex => $day): ?>
                        <?php
                        $schedule = isset($scheduleData[$day['label']][$time]) ? $scheduleData[$day['label']][$time] : null;
                        $cellClass = "schedule-main-time-" . ($timeIndex + 1) . "-day-" . ($dayIndex + 1);
                        ?>
                        <div id="schedule-main-<?= $timeIndex + 1 ?>" class="<?= $cellClass ?>">
                            <?php if ($schedule): ?>
                                <?php
                                $isRegistered = isset($registeredSchedulesIds) && is_array($registeredSchedulesIds) && in_array($schedule->id, $registeredSchedulesIds) ? true : false;
                                ?>
                                <div class="event">
                                    <div class="event-color"></div>
                                    <div class="event-info">
                                        <?php if ($schedule && $schedule->start_time && $schedule->end_time): ?>
                                            <?php
                                            $timeZone = new \DateTimeZone('Europe/Moscow');
                                            $startTime = new \DateTime($schedule->start_time);
                                            $startTime->setTimezone($timeZone);
                                            $endTime = new \DateTime($schedule->end_time);
                                            $endTime->setTimezone($timeZone);
                                            ?>
                                            <div class="time"><?= $startTime->format('H:i') ?> - <?= $endTime->format('H:i') ?></div>
                                        <?php endif; ?>
                                        <?php if ($schedule && $schedule->trainingProgram): ?>
                                            <div class="event-name"><?= Html::encode($schedule->trainingProgram->name) ?></div>
                                        <?php endif; ?>
                                        <?php if ($schedule && $schedule->trainer): ?>
                                            <div class="trainer-name">
                                                <?= Html::encode($schedule->trainer->first_name . ' ' . $schedule->trainer->last_name) ?>
                                            </div>
                                        <?php endif; ?>
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
    </div>
</div>