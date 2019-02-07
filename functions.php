<?php
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

/**
 * Функция для форматирование суммы и добавления к ней знака рубля
 *
 * Функция округляет, форматирует число с разделением на группы по три цифры и затем добавляет знак рубля
 *
 * @param string|float|integer $price_value - цена товара указанная в объявлении
 * @return string
 */
function price_format ($price_value){
    $price_value=ceil($price_value);
    if($price_value>1000) {
        $price_value=number_format($price_value,0,'',' ');
    }
    $price_value=$price_value.'<b class="rub">р</b>';
    return $price_value;
}
?>