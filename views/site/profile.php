<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\assets\AppAsset;
use app\models\Trainer; // Add this line

/** @var  yii\web\View $this */
/**  @var  app\models\User $user */
/** @var $isTrainer bool */
/** @var  app\models\Trainer $trainer */

$this->title = 'Profile';
$this->params['breadcrumbs'][] = $this->title;

AppAsset::register($this);

$this->registerCssFile(
    Url::to('@web/css/profile_style.css'),
    [
        'appendTimestamp' => true,
    ]
);
?>

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
        <a id="link4" href="">Абонементы</a>
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

<div class="profile-index">
    <h1>Профиль</h1>
    <div class="user-info">
        <h2>Информация о пользователе</h2>
        <p><strong>Имя:</strong> <?= Html::encode($user->first_name) ?></p>
        <p><strong>Фамилия:</strong> <?= Html::encode($user->last_name) ?></p>
        <p><strong>Email:</strong> <?= Html::encode($user->email) ?></p>
        <p><strong>Роль:</strong> <?= Html::encode($user->role_id) ?></p>
    </div>

    <?php if ($user->role_id === 'trainer'): ?>
        <div class="trainer-info">
            <h2>Информация о тренере</h2>

            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success">
                    <?= Yii::$app->session->getFlash('success') ?>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-danger">
                    <?= Yii::$app->session->getFlash('error') ?>
                </div>
            <?php endif; ?>

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($trainer, 'bio')->textarea(['rows' => 6, 'class' => 'trainer-bio-textarea']) ?>

            <?= $form->field($trainer, 'specializations')->textInput(['maxlength' => true, 'class' => 'trainer-specializations-input']) ?>

            <?= $form->field($trainer, 'certifications')->textInput(['maxlength' => true, 'class' => 'trainer-certifications-input']) ?>

            <?= $form->field($trainer, 'experience_years')->textInput(['type' => 'number', 'class' => 'trainer-experience-years-input']) ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success trainer-save-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    <?php endif; ?>

    <?php if ($user->role_id === 'client'): ?>
        <div class="trainer-list">
            <h2>Список тренеров</h2>
            <p>Здесь будет список тренеров.</p>
        </div>
    <?php endif; ?>

    <div class="subscriptions">
        <h2>Купленные абонементы</h2>
        <p>Здесь будет информация об абонементах.</p>
    </div>
</div>