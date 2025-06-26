<?php

/** @var yii\web\View $this */

use yii\helpers\Url;
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User; // Укажите правильный namespace для вашей модели User

$this->title = 'Регистрация';

AppAsset::register($this);

$this->registerCssFile(
    Url::to('@web/css/registration_style.css'),
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

<main>
    <h1 class="reg-head">Регистрация</h1>

    <?php $form = ActiveForm::begin([
        'id' => 'registration-form',
        'options' => ['class' => 'reg-common'], // Add a class to the form element for styling
        'fieldConfig' => [
            'template' => "{input}\n{error}", // Customize the layout to display input and error below
            'labelOptions' => ['class' => ''], // Remove label styles
            'inputOptions' => ['class' => ''], // Remove input styles
            'errorOptions' => ['class' => 'help-block'], // Remove error styles
        ],
    ]); ?>

    <?=$form->field($model, 'email')->textInput(['placeholder' => 'Электронная почта'])?>
    <?= $form->field($model, 'first_name')->textInput(['placeholder' => 'Имя']) ?>
    <?= $form->field($model, 'last_name')->textInput(['placeholder' => 'Фамилия']) ?>
    <?= $form->field($model, 'phone_number')->textInput(['placeholder' => 'Телефон']) ?>
    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль']) ?>
    <?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => 'Подтверждение пароля']) ?>

    <div class="reg-but">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'reg-but-conf']) ?>
    </div>

    <div class="log">
        <?= Html::a('Войти', ['login'], ['class' => 'log-link']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</main>