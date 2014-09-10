<?php
//error_reporting(E_ALL);
//ini_set('display_errors', TRUE);
//ini_set('display_startup_errors', TRUE);
include 'Merchant.php';

if ( ($_SERVER['REQUEST_METHOD'] == 'POST') && (array_key_exists('merchants', $_POST))) {
    $merchants = unserialize($_POST['merchants']);
} else {
    include_once 'make_merchants.php';
}

$mapping = ['emitent', 'tech', 'chrono', 'filling', 'didntget', 'refund', 'monthly', 'wrong', 'others'];

function echo_td($val, $name) {
    printf("<td> <input type='text' name='%s' value='%s'></td> \n", $name, $val);
}
?>

<html>
<head>
    <title>ChronoStat</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="files/styles.css" type="text/css">
</head>
<body>
<div id="content">
    <form method="POST" action="process_form.php">
        <table>
            <thead>
            <tr>
                <?php
                foreach($mapping as $d) {
                    echo "<td>{$d}</td>";
                }
                echo "<td>Percent Total</td>";
                echo "<td>Merchant name</td>";
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
                echo_td($merchant -> percent, $merchant -> name . '_percent');
                echo_td($merchant -> name, $merchant -> name . '_name');
                echo '</tr>';
            }

            echo '<tr>';  // last row for adding record
            for ($i = 0; $i < count($mapping); $i++) {
                echo_td('', "adding_{$i}");
            }
            echo_td('', "adding_percent");
            echo_td('', "adding_name");
            echo '</tr>';
            ?>
            </tbody>

        </table>
        <input type='hidden' name='merchants' value="<?php echo htmlentities(serialize($merchants)); ?>">
        <input type='hidden' name='mapping' value="<?php echo htmlentities(serialize($mapping)); ?>">
        <input type="submit" value="Обновить правила">
    </form>
    <?php
    $filenames = ["make_merchants.php", "make_xml.php", "output_xls.php"];
    foreach($filenames as $filename) { ?>
        <p><form action="<?php echo $filename?>" method="POST">
            <input type="hidden" name="use_merchantsxml" value="1">
            <input type='hidden' name='merchants' value="<?php echo htmlentities(serialize($merchants)); ?>">
            <?php if ($filename === "output_xls.php") echo '<input type="text" name="total_calls">'?>
            <input type="submit" value="<?php echo $filename?>">
        </form></p>
    <?php } ?>
</div>
</body>

</html>
