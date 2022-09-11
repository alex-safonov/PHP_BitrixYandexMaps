<?

$arFields = Array(
    'ID'=>'offices',
    'SECTIONS'=>'Y',
    'IN_RSS'=>'N',
    'SORT'=>100,
    'LANG'=>Array(
      'ru'=>Array(
            'NAME'=>'Офисы',
            'SECTION_NAME'=>'Регионы офисов',
            'ELEMENT_NAME'=>'Офис'
            ),
    'en'=>Array(
            'NAME'=>'Offices',
            'SECTION_NAME'=>'Office regions',
            'ELEMENT_NAME'=>'Office'
            )        
        )
    );

$obBlocktype = new CIBlockType;
$DB->StartTransaction();
$res = $obBlocktype->Add($arFields);
if(!$res)
{
   $DB->Rollback();
   echo 'Error: '.$obBlocktype->LAST_ERROR.'<br>';
}
else
   $DB->Commit();

 


$ib = new CIBlock;

$IBLOCK_TYPE = "offices"; // Тип инфоблока
$SITE_ID = "s1"; // ID сайта

$arFields = Array(
  "ACTIVE" => "Y",
  "NAME" => "Офисы",
  "CODE" => "offices",
  "IBLOCK_TYPE_ID" => $IBLOCK_TYPE,
  "SITE_ID" => $SITE_ID,
  "SORT" => "100",
  "FIELDS" => array(
    "DETAIL_TEXT_TYPE" => array(      // Тип детального описания
      "DEFAULT_VALUE" => "html",
      ),
    "SECTION_DESCRIPTION_TYPE" => array(
      "DEFAULT_VALUE" => "html",
      ),
    "IBLOCK_SECTION" => array(         // Привязка к разделам (сделаем офисы по Регионам), делаем необязательной, но зависит от задачи
      "IS_REQUIRED" => "N",
      ),            
    "LOG_SECTION_ADD" => array("IS_REQUIRED" => "Y"), // Вкладка "Журнал событий", пишем всё
    "LOG_SECTION_EDIT" => array("IS_REQUIRED" => "Y"),
    "LOG_SECTION_DELETE" => array("IS_REQUIRED" => "Y"),
    "LOG_ELEMENT_ADD" => array("IS_REQUIRED" => "Y"),
    "LOG_ELEMENT_EDIT" => array("IS_REQUIRED" => "Y"),
    "LOG_ELEMENT_DELETE" => array("IS_REQUIRED" => "Y"),
  ),

  // Шаблоны страниц на будущее, пробрасываем пути для ЧПУ
  "LIST_PAGE_URL" => "#SITE_DIR#/offices/",
  "SECTION_PAGE_URL" => "#SITE_DIR#/offices/#SECTION_CODE#/",
  "DETAIL_PAGE_URL" => "#SITE_DIR#/offices/#ELEMENT_CODE#/",         

  "INDEX_SECTION" => "Y", // Два параметра для модуля поиска
  "INDEX_ELEMENT" => "Y",

  "VERSION" => 1, // Храним в общей таблице, можно сделать и свою

  "ELEMENT_NAME" => "Офис", // Наименование элементов и разделов
  "ELEMENTS_NAME" => "Офисы",
  "ELEMENT_ADD" => "Добавить Офис",
  "ELEMENT_EDIT" => "Изменить Офис",
  "ELEMENT_DELETE" => "Удалить Офис",
  "SECTION_NAME" => "Регион",
  "SECTIONS_NAME" => "Регионы",
  "SECTION_ADD" => "Добавить Регион",
  "SECTION_EDIT" => "Изменить Регион",
  "SECTION_DELETE" => "Удалить Регион",
);

$ID = $ib->Add($arFields);
if ($ID > 0)
{
  echo 'Инфоблок "Офисы" успешно создан <br />';
}
else
{
  echo 'Ошибка создания инфоблока "Офисы" <br />';
  return false;
};


// Добавляем свойства

$ibp = new CIBlockProperty;

$arFields = Array(
  "NAME" => "Название офиса", // Делаем свойство Название офиса, и, казалось бы излишне дублируем; сделал для возможности в одном из полей использовать короткое наименование: 'Газпромнефть-Цифровые Решения, Московский филиал, Научный 17' и 'ГПН-ЦР, Москва'
  "ACTIVE" => "Y",
  "SORT" => 100, // Для сортировки
  "CODE" => "OFFICE_NAME",
  "PROPERTY_TYPE" => "S", // Делаем тип - Строка
  "ROW_COUNT" => 1,
  "COL_COUNT" => 60,
  "IBLOCK_ID" => $ID
 );

$propId = $ibp->Add($arFields);
if ($propId > 0)
{
  $arFields["ID"] = $propId;
  $arCommonProps[$arFields["CODE"]] = $arFields;
  echo 'Добавлено свойство '.$arFields["NAME"].'<br />';
}
else
  echo 'Ошибка добавления свойства '.$arFields["NAME"].'<br />';

$arFields = Array(
  "NAME" => "Телефон",
  "ACTIVE" => "Y",
  "SORT" => 110, // Для сортировки
  "CODE" => "OFFICE_PHONE",
  "PROPERTY_TYPE" => "S", // Делаем тип - Строка
  "ROW_COUNT" => 1,
  "COL_COUNT" => 60,
  "IBLOCK_ID" => $ID
 );

$propId = $ibp->Add($arFields);
if ($propId > 0)
{
  $arFields["ID"] = $propId;
  $arCommonProps[$arFields["CODE"]] = $arFields;
  echo 'Добавлено свойство '.$arFields["NAME"].'<br />';
}
else
  echo 'Ошибка добавления свойства '.$arFields["NAME"].'<br />';

$arFields = Array(
  "NAME" => "Email",
  "ACTIVE" => "Y",
  "SORT" => 120, // Для сортировки
  "CODE" => "OFFICE_EMAIL",
  "PROPERTY_TYPE" => "S", // Делаем тип - Строка
  "ROW_COUNT" => 1,
  "COL_COUNT" => 60,
  "IBLOCK_ID" => $ID
 );

$propId = $ibp->Add($arFields);
if ($propId > 0)
{
  $arFields["ID"] = $propId;
  $arCommonProps[$arFields["CODE"]] = $arFields;
  echo 'Добавлено свойство '.$arFields["NAME"].'<br />';
}
else
  echo 'Ошибка добавления свойства '.$arFields["NAME"].'<br />';

$arFields = Array(
  "NAME" => "Координаты",
  "ACTIVE" => "Y",
  "SORT" => 130, // Для сортировки
  "CODE" => "OFFICE_COORDINATES",
  "PROPERTY_TYPE" => "S", // Делаем тип - Строка. Для API Яндекс карт нужны параметры широты и долготы, можно было бы делать два числовых поля, но так как мы будем передавать в формате '55.654142, 37.555885' оставим строку и положимся на профессионализм контент-менеджера
  "ROW_COUNT" => 1,
  "COL_COUNT" => 60,
  "IBLOCK_ID" => $ID
 );

$propId = $ibp->Add($arFields);
if ($propId > 0)
{
  $arFields["ID"] = $propId;
  $arCommonProps[$arFields["CODE"]] = $arFields;
  echo 'Добавлено свойство '.$arFields["NAME"].'<br />';
}
else
  echo 'Ошибка добавления свойства '.$arFields["NAME"].'<br />';

$arFields = Array(
  "NAME" => "Город",
  "ACTIVE" => "Y",
  "SORT" => 140, // Для сортировки
  "CODE" => "OFFICE_CITY",
  "PROPERTY_TYPE" => "S", // Делаем тип - Строка
  "ROW_COUNT" => 1,
  "COL_COUNT" => 60,
  "IBLOCK_ID" => $ID
 );

$propId = $ibp->Add($arFields);
if ($propId > 0)
{
  $arFields["ID"] = $propId;
  $arCommonProps[$arFields["CODE"]] = $arFields;
  echo 'Добавлено свойство '.$arFields["NAME"].'<br />';
}
else
  echo 'Ошибка добавления свойства '.$arFields["NAME"].'<br />';
?>