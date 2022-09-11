<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog.php");

class officesIDs 
{
    // Необходимо указать свойтва на вашем проекте:

	protected $iBlockOfficesID = 48; // указываем ID инфоблока Офисы, который был создан
	protected $officeName = 381;	// указываем ID свойства элемента инфоблока Название офиса
	protected $officePhone = 382; // указываем ID свойства элемента инфоблока Телефон
	protected $officeEmail = 383; // указываем ID свойства элемента инфоблока Email
	protected $officeCoordinates = 384; // указываем ID свойства элемента инфоблока Координаты
	protected $officeCity = 385;	// указываем ID свойства элемента инфоблока Город
}

class offices extends officesIDs
{
    // определяем свойства для офиса
    public $fullname; // свойство Полное имя офиса
    public $name; // свойство Имя офиса
    public $phone; // свойство Телефон офиса
    public $email; // свойство Email офиса
    public $coordinates; // свойство Координаты офиса
    public $city; // свойство Местоположение/Город офиса
     
    // хотел сделать через конструктор, но из-за того, что в свойствах фигурируют запятые и были ошибки с количеством передаваемых значений - решил упростить и отказаться от конструктора
    // function __construct($value1, $value2, $value3, $value4, $value5, $value6) {
    //   $this->fullname = $value1;
    //   $this->name = $value2;
    //   $this->phone = $value3;
    //   $this->email = $value4;
    //   $this->coordinates = $value5;
    //   $this->city = $value6;
    // }
     
    // метод, который добавляет Офис в инфоблок
    function addOffice($foto) {

		$el = new CIBlockElement;

	    $PROP = array();
	    $PROP[$this->officeName] = $this->name;  // свойство элемента инфоблока Название офиса
	    $PROP[$this->officePhone] = $this->phone;  // свойство элемента инфоблока Телефон
	    $PROP[$this->officeEmail] = $this->email;  // свойство элемента инфоблока Email
	    $PROP[$this->officeCoordinates] = $this->coordinates;  // свойство элемента инфоблока Координаты
	    $PROP[$this->officeCity] = $this->city;  // свойство элемента инфоблока Город

	    $arLoadProductArray = Array(
	      "IBLOCK_SECTION_ID" => false, // элемент лежит в корне раздела
	      "IBLOCK_ID"      => $this->iBlockOfficesID, // ID инфоблока
	      "PROPERTY_VALUES"=> $PROP, // массив свойств элемента инфоблока 
	      "NAME"           => $this->fullname, // свойство элемента инфоблока Полное название офиса 
	      "ACTIVE"         => "Y", // активен
	      "DETAIL_PICTURE" => CFile::MakeFileArray("images/".$foto.".jpg"),
	      );

	    // print_r($_SERVER["DOCUMENT_ROOT"]);

	    if($PRODUCT_ID = $el->Add($arLoadProductArray))
	      echo "Новый офис создан, ID: ".$PRODUCT_ID;
	    else
	      echo "Error: ".$el->LAST_ERROR;
    }
  }

$row = 1; // этот параметр для фотографии офиса
if (($handle = fopen("offices.csv", "r")) !== FALSE) { // считываем данные из файла
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

        $office = new offices(); // создаём экземпляр класса

        $office->fullname = $data[0];
		$office->name = $data[1];
		$office->phone = $data[2];
		$office->email = $data[3];
		$office->coordinates = $data[4];
		$office->city = $data[5];
        
        echo "<pre>";
        echo "Создаём новый офис:<br />";
		print_r($office->fullname); // выводим данные на экран для удобства
		echo "</pre>";

		$office->addOffice($row);
		$row++;
    }
    fclose($handle); // закрываем файл
};
?>