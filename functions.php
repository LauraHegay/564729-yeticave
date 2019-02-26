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

/**
 * Функция для расчета времени до завершения лота
 *
 * Функция рассчитывает время оставшееся до завершения лота и выводит время в формате "чч:мм"
 *
 * нет параметров
 * @return string
 */
function lot_end_time(){
    date_default_timezone_set("Europe/Moscow");
    $time_midnight=strtotime("tomorrow midnight");
    $time_diff=($time_midnight-time());
    $hours=floor($time_diff/3600);
    $minutes=floor(($time_diff%3600)/60);
    return sprintf('%02d:%02d', $hours, $minutes);
};
/**
 * Функция преобразует объект результата, полученной из БД записи  в двумерный массив
 *
 * @param $result - объект результата
 * @param $con - ресурс соединения
 * @return array|null
 */

function object_in_array($result, $con){
    if (!$result) {
        $error = "Ошибка MySQL: " . mysqli_error($con);
        print $error;
    }
    else {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}


/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }
    return $stmt;
}

/**Функция для подключения к базе данных yeticave_db
 * @return mysqli
 */
function db_connection() {
    $con= mysqli_init();
    mysqli_options($con, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
    mysqli_real_connect($con, "localhost", "root", "", "yeticave_db");
    mysqli_set_charset($con, "utf8");
    return $con;
}
