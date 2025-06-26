<?php

/** @var yii\web\View $this */

use yii\helpers\Url;
use app\assets\AppAsset;

use yii\helpers\Html;

$this->title = 'Главная страница';

AppAsset::register($this);

$this->registerCssFile(
    Url::to('@web/css/index_style.css'),
    [
        'appendTimestamp' => true,
    ]
)

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
    </div>
    <div class="vk">
        <img src="<?= Yii::$app->request->baseUrl ?>/images/IMG16.png">
    </div>
</header>
<div class="one">
    <h1 id="htext1">СПОРТИВНЫЙ КЛУБ "СИЛА ДОНА"</h1>
    <p id="text_1">СИЛА ДОНА - это комфортные тренажерные залы с европейским оборудованием последнего
        поколения, большой
        выбор
        групповых программ для взрослых и детей и квалифицированный тренерский состав. Мы делаем
        качественный
        фитнес доступным для всех, потому что хотим, чтобы каждый мог заниматься спортом и становиться
        здоровее
        с каждым днем.</p>
    <a class="bt3" href="#win1">
        <p>Адреса клубов</p>
    </a>
</div>
<div class="stat">
    <div>
        <h1 class="text1">13</h1>
        <p class="text2">лет работы</p>
    </div>
    <div>
        <h1 class="text1">22</h1>
        <p class="text2">города</p>
    </div>
    <div>
        <h1 class="text1">350 000</h1>
        <p class="text2">клиентов</p>
    </div>
    <div>
        <h1 class="text1">4.8</h1>
        <p class="text2">средняя оценка</p>
    </div>
</div>
<hr class="horizontal" />
<div class="htext2" id="uslugi">
    <h1>Услуги и основные тренировки</h1>
</div>
<div class="train">


    <div class="train2">
        <ul>
            <li>Функциональные тренировки</li>
            <li>Силовые тренировки</li>
            <li>Body&Mind тренировки</li>
            <li>Кардиотренировки</li>
            <li>Танцевальные тренировки</li>
            <li>Смешанные программы</li>
        </ul>
        <p>ГРУППОВЫЕ ТРЕНИРОВКИ</p>

    </div>
    <div class="train3">
        <ul>
            <li>Персональный тренинг</li>
            <li>Обучение техники упражнений</li>
            <li>Мотивация и поддержка</li>
            <li>Тренировки на результат</li>
            <li>Составление программ питания</li>
            <li>Индивидуальный подход</li>
        </ul>
        <p>ПЕРСОНАЛЬНЫЕ ТРЕНИРОВКИ</p>
    </div>
    <div class="train4">
        <ul>
            <li>Оздоровительные программы</li>
            <li>Комплексные фитнес-программы</li>
            <li>Секции единоборств и танцев</li>
            <li>Тренировки на атлетизм и выносливость</li>
            <li>Тренировки на координацию и ловкость</li>
            <li id="list"></li>
        </ul>
        <p>СПОРТ ДЛЯ ДЕТЕЙ</p>
    </div>
    <div class="train5">
        <ul>
            <li>Финская сауна</li>
            <li>Раздевалки с душевыми</li>
            <li>Солярий в раздевалках</li>
            <li>Фитнес-бар</li>
            <li>Косметологические услуги</li>
            <li>Магазин спортивных товаров</li>
        </ul>
        <p>ДОПОЛНИТЕЛЬНЫЕ УСЛУГИ</p>
    </div>
</div>

<div class="send">
    <h1>Оставьте заявку и мы вам перезвоним</h1>
    <form class="order">
        <div class="send1">
            <select class="city">
                <option selected value="s1">ул.Московская д.69 </option>
                <option value="s2">пр.Буденновский д.34</option>
                <option value="s3">ул. Тверская д.116</option>
                <option value="s4">ул. Богданова д.54</option>
            </select>
        </div>
        <div class="send2">
            <input type="tel" placeholder="+7-(___)-___-__-__" pattern="+7-[0-9]{}-[0-9]{3}-[0-9]{2}-[0-9]{2}">
        </div>
        <div class="send3">
            <input type="text" placeholder="Имя">
        </div>
    </form>
    <div class="btnsend">
        <button class="btsend">Отправить</button>
    </div>

</div>
<div class="out">
    <h1>КОМФОРТНЫЕ ЗОНЫ ДЛЯ ТРЕНИРОВОК</h1>
    <div id="area" class="area">
        <div class="area1">
            <p class="txt">Зоны занимают около 30% от общей площади и оснащены необходимым оборудованием для
                занятия спортом:
                - Беговые дорожки - Эллиптические тренажеры - Гребные тренажеры - Велотренажеры - Степперы.

            </p>

            <p class="h">КАРДИОЗОНЫ</p>

        </div>
        <div class="area2">

            <p class="txt">Зоны занимают около 20% от всего пространства, оборудованы современными
                хореографическими станками и инвентарем. Здесь проводятся занятия по следующим направлениям:
                - Body&Mind тренировки - Танцевальные тренировки - Аэробные тренировки.</p>
            <p class="h">АЭРОБНЫЕ ЗОНЫ</p>
        </div>
        <div class="area3">
            <p class="txt">Зоны занимают около 35% площади фитнес-клубов, оснащены нагружаемыми и грузоблочными
                тренажерами. Для удобства посетителей данные зоны разделены на подзоны. Сюда входят: - Зоны
                силовых тренажеров - Зоны свободных весов - Зоны РУСАП - Зоны Crossfit.</p>
            <p class="h">СИЛОВЫЕ ЗОНЫ</p>
        </div>
        <div class="area4">
            <p class="txt">Пространство занимает около 10% от всей площади клуба. Здесь вы сможете расслабиться
                после занятий спортом и отдохнуть. Сюда входят: СПА пространство - Кабинеты массажа - Кабинеты
                маникюра-педикюра и косметологии - Фитнес-кафе.</p>
            <p class="h">ЗОНЫ ОТДЫХА</p>
        </div>
    </div>
</div>
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