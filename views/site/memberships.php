<?php

/** @var yii\web\View $this */

use yii\helpers\Url;
use app\assets\AppAsset;
use yii\helpers\Html;

$this->title = 'Расписание';

AppAsset::register($this);

$this->registerCssFile(
    Url::to('@web/css/memberships_style.css'),
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
            <a class="memberships" href="<?= Url::to(['site/memberships']) ?>">Абонементы </a>
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
        <div class="list-mems-main">
            <div class="list-mems">
                <?php foreach ($membershipTypes as $membership): ?>
                    <div class="type-of-mem" data-membership-id="<?= $membership->id ?>">
                        <div class="month-name">
                            <?= Html::encode($membership->name) ?>
                        </div>
                        <div class="month-info">
                            <div class="month-price">
                                <?= number_format($membership->price, 2, ',', ' ') ?> руб.
                            </div>
                            <div class="month-buy-but">
                                <button class="buy-but">Купить</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <?php if (!empty($membershipTypes)): ?>
        <?php foreach ($membershipTypes as $membership): ?>
            <div class="membership-detail-overlay" data-membership-id="<?= $membership->id ?>">
                <div class="membership-detail-content">
                    <h2 class="name-overlay"><?= Html::encode($membership->name) ?></h2>
                    <div class="main-info-overlay">
                        <h3 class="info-name-overlay">Цена:</h3>
                        <p class="info-overlay"><?= number_format($membership->price, 2, ',', ' ') ?> руб.</p>
                        <h3 class="info-name-overlay">Описание:</h3>
                        <p class="info-overlay"><?= Html::encode($membership->description) ?></p>
                        <h3 class="info-name-overlay">Групповые тренировки</h3>
                        <?php if ($membership->allowed_group_classes == 1): ?>
                            <p>Да</p>
                        <?php else: ?>
                            <p>Нет</p>
                        <?php endif; ?>
                        <div class="close-overlay">
                            <button class="close-detail-button">Закрыть</button>
                        </div>
                        <div class="buy-overlay">
                            <button class="buy-but-overlay">Купить</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="line2">
        <hr class="hor2" />
    </div>
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
                ООО "БОМОНД" Адрес: 188689, Ленинrрадская область, Всеволожский район, город Кудрово, ул. Ленинградская
                (Новый Оккервиль мкр) дом 1, помещение 2-Н
                Копирование материалов данного сайта без разрешения правообладателя запрещено.</p>
        </div>
    </footer>

    <?php
    $this->registerJs(
        "
        $('.type-of-mem').click(function() {
            var membershipId = $(this).data('membership-id');
            $('.membership-detail-overlay[data-membership-id=\"' + membershipId + '\"]').fadeIn();
        });

        $('.close-detail-button').click(function() {
            $('.membership-detail-overlay').fadeOut();
        });

        $('.membership-detail-overlay').hide(); // Initially hide all overlays

        "
    );
    ?>
</body>