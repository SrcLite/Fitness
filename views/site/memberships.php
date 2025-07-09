<?php 
/** @var yii\web\View $this */
use yii\helpers\Url;
use app\assets\AppAsset;
use yii\helpers\Html;
$this->title = 'Расписание';

AppAsset::register($this);

$this->registerCssFile(
    Url::to('@web/css/memberships_style.css')<
    [
        'appendTimestamp' => true,
    ]
    );

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
        <div class="head">
            <h1>Абонементы</h1>
            <hr>
        </div>
        <div class="list-main">
            <?php foreach ($membershipTypes as $membership): ?>
            <div class="month">
                <div class="month-name">
                    <?= Html::encode($membership->name)?>
                </div>
                <div class="month-info">
                    <div class="month-price">
                       <?=number_format($membership->price, 2, ',', ' ')?> руб.
                    </div>
                    <div class="month-buy-but">
                        <button>Купить</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</body>