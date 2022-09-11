<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

Bitrix\Main\Page\Asset::getInstance()->addJs("https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=181be006-59b4-46dd-8fb9-9b5ab1f1d650");
?>

<div id="header"><span>Временный header</span></div>

<div id="map"></div>

<div id="footer">Временный footer</div>

<script type="text/javascript">

ymaps.ready(function () {

    var myMap = new ymaps.Map('map', {
            center: [55.751574, 37.573856],
            zoom: 4
        }),

        <?foreach($arResult["ITEMS"] as $arItem):?>

        myPlacemarkWithContent = new ymaps.Placemark([<?=$arItem['PROPERTIES']['OFFICE_COORDINATES']['VALUE']?>], {
            hintContent: '<?=$arItem['PROPERTIES']['OFFICE_NAME']['VALUE']?>',
            balloonContentHeader: '<p class="baloon balloonContentHeader"><?=$arItem['PROPERTIES']['OFFICE_NAME']['VALUE']?></p>',
			balloonContentBody: '<p class="baloon"><img src="<?=$arItem['DETAIL_PICTURE']['SRC']?>"></p>' +
			  '<p class="baloon">Телефон: <?=$arItem['PROPERTIES']['OFFICE_PHONE']['VALUE']?></p>' +
			  '<p class="baloon">Email: <?=$arItem['PROPERTIES']['OFFICE_EMAIL']['VALUE']?></p>',

			balloonContentFooter: '<p class="baloon">Местоположение: <?=$arItem['PROPERTIES']['OFFICE_CITY']['VALUE']?></p>',
            iconContent: ''  
        }, {
            
            iconLayout: 'default#imageWithContent', // указываю тип макета - будем делать свою метку, ниже даю ссылку на изображение
            iconImageHref: '/local/components/gpn/offices.list/templates/offices/images/gpn.png',
            iconImageSize: [36, 36], // задаю размеры метки.
            iconImageOffset: [-18, -18], // левого верхнего угла иконки относительно
            // точки привязки
        });
   		myMap.geoObjects.add(myPlacemarkWithContent);

   		<?endforeach;?>

    myMap.controls.remove("mapTools") // удаляем лишние элементы управления картой
	    .remove("typeSelector")
	    .remove("searchControl")
	    .remove("trafficControl");

    myMap.setBounds(myMap.geoObjects.getBounds(),{checkZoomRange:true, zoomMargin:30}); // автоматическое зумирование, чтобы все метки на карте влезли
});
</script>