<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
foreach($arResult["ITEMS"] as $i=>$arItem) {
	if (is_array($arItem["DETAIL_PICTURE"])) {
                $ratio = $arItem["DETAIL_PICTURE"]["WIDTH"] / $arItem["DETAIL_PICTURE"]["HEIGHT"];
		$width = 250;
		$height = round($width / $ratio);
		$img = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"], array("width" => $width, "height" => $height), BX_RESIZE_IMAGE_EXACT);
		$arResult["ITEMS"][$i]["DETAIL_PICTURE"]["SRC"] = $img["src"];
		$arResult["ITEMS"][$i]["DETAIL_PICTURE"]["WIDTH"] = $width;
		$arResult["ITEMS"][$i]["DETAIL_PICTURE"]["HEIGHT"] = $height;
	}
}
?>