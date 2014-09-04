<?php
include_once 'make_merchants.php';

$mapping = ['emitent', 'tech', 'chrono', 'filling', 'didntget', 'refund', 'monthly', 'wrong', 'others'];

function echo_td($val, $name) {
    //$name = !$name ? $val : $name;
    printf("<td> <input type='text' name='%s' value='%s'></td> \n", $name, $val);
}
?>

<html>
<head>
    <title>ChronoStat</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div id="content">
    <form method="POST" action="process_form.php">
        <table>
            <thead>
            <tr>
                <!--            <td>Decline Эмитент</td>-->
                <!--            <td>Decline Тех.причина</td>-->
                <!--            <td>Decline ChronoMethod</td>-->
                <!--            <td>Затруднение в заполнении платежки</td>-->
                <!--            <td>Не получил товар/услугу</td>-->
                <!--            <td>Возврат средств</td>-->
                <!--            <td>Ежемесячный платеж</td>-->
                <!--            <td>Ошибочный перевод</td>-->
                <!--            <td>Другое</td>-->
                <!--            <td>Фирма</td>-->
                <!--            <td>Общий процент</td>-->
                <?php
                foreach($mapping as $d) {
                    echo "<td>{$d}</td>";
                }
                ?>
            </tr>
            </thead>

            <tbody>
            <?php
            foreach ($merchants as $merchant) {
                echo '<tr>';
                for ($i = 0; $i < count($mapping); $i++) {
                    echo_td($merchant -> declines[$mapping[$i]], $merchant -> name . '_' . $i);
                }
                echo_td($merchant -> name, $merchant -> name . '_name');
                echo_td($merchant -> percent, $merchant -> name . '_percent');
                echo '</tr>';
            }
            ?>
            </tbody>

        </table>

        <input type="submit">
    </form>
    // Do forms.
</div>
</body>

</html>
