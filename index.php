<?php
include_once 'make_merchants.php';
$mapping = ['emitent', 'tech', 'chrono', 'filling', 'didntget', 'refund', 'monthly', 'wrong', 'others'];

function echo_td($str) {
    echo '<td>' . $str . '</td>';
}
?>


<html>
<head>
    <title>ChronoStat</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div id="content">
    <table>
        <thead>
        <tr>
            <td>Decline Эмитент</td>
            <td>Decline Тех.причина</td>
            <td>Decline ChronoMethod</td>
            <td>Затруднение в заполнении платежки</td>
            <td>Не получил товар/услугу</td>
            <td>Возврат средств</td>
            <td>Ежемесячный платеж</td>
            <td>Ошибочный перевод</td>
            <td>Другое</td>
            <td>Фирма</td>
            <td>Общий процент</td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($merchants as $merchant) {
            echo '<tr>';
            for ($i = 0; $i < count($mapping); $i++) {
                echo_td($merchant -> declines[$mapping[$i]]);
            }
            echo_td($merchant -> name);
            echo_td($merchant -> percent);
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>

</div>
</body>

</html>
