<?php
require_once('functions.php');
require_once('init.php');
require_once './vendor/autoload.php';

$sql_completed_lots="SELECT * FROM lots
WHERE lots.win_user_id IS NULL AND lots.date_end<=CURRENT_DATE() AND lots.id IN (SELECT DISTINCT rates.id_lot FROM rates)";
$result_completed_lots = mysqli_query($con, $sql_completed_lots);
$completed_lots=object_in_array($result_completed_lots, $con);

if (!empty($completed_lots)){
    $transport = new Swift_SmtpTransport("phpdemo.ru", 25);
    $transport->setUsername("keks@phpdemo.ru");
    $transport->setPassword("htmlacademy");

    $mailer = new Swift_Mailer($transport);

    $logger = new Swift_Plugins_Loggers_ArrayLogger();
    $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));
    foreach ($completed_lots as $key => $value){
        $id_lot=$value['id'];
        $sql_win_rate="SELECT rates.id_user, rates.id_lot, rates.sum_price, lots.title FROM rates
    JOIN lots ON rates.id_lot=lots.id
    WHERE rates.id_lot=$id_lot
    ORDER BY rates.sum_price DESC";
        $result_win_rate = mysqli_query($con, $sql_win_rate) or die("Ошибка " . mysqli_error($con));;
        $win_rate=mysqli_fetch_assoc($result_win_rate);

        $win_user_id=$win_rate['id_user'];
        $win_lot_id=$win_rate['id_lot'];
        $query ="UPDATE lots SET win_user_id='$win_user_id' WHERE id=$win_lot_id";
        $result = mysqli_query($con, $query) or die("Ошибка " . mysqli_error($con));

        $sql_win_user="SELECT * FROM users WHERE id=$win_user_id";
        $result_win_user = mysqli_query($con, $sql_win_user);
        $win_user=mysqli_fetch_assoc($result_win_user);


        $message = new Swift_Message();
        $message->setSubject("Ваша ставка победила");
        $message->setFrom(['keks@phpdemo.ru' => 'yeticave']);
        $message->setTo($win_user['email']);

        $msg_content = include_template('email.php', ['win_rate' => $win_rate, 'win_user'=>$win_user]);
        $message->setBody($msg_content, 'text/html');

        $result = $mailer->send($message);

        if (!$result) {
             $logger->dump();
        }
    }
}

