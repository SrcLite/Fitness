<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\assets\AppAsset;
use yii\widgets\Pjax;
use yii\helpers\Url;
/**  @var  Yii\web\View $this */
/**  @var  app\models\UserSearch $searchModel */
/**  @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;

AppAsset::register($this);

$this->registerCssFile(
    Url::to('@web/css/user_index_style.css'),
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
        <?php echo Html::a(
            'Расписание',
            ['site/schedule'],
            ['class' => 'btn btn-primary']
        );
        ?>
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
<div class="user-index">

    <h1>Пользователи</h1>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'first_name',
            'last_name',
            'email:email',
            'phone_number',
            //'created_at',
            //'updated_at',
            //'password_hash',
            //'auth_key',
            [
                'attribute' => 'role_id',
                'filter' => ['admin' => 'Admin', 'client' => 'Client', 'trainer' => 'Trainer'], // Фильтр по ролям
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>