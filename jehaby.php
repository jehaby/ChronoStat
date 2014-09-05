<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

echo (('string'));


echo $_SERVER['PHP_SELF'] . '<br><br>';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $f = fopen('files/f.txt', 'r+');
    foreach ($_POST as $p) {
        fwrite($f, $p . "\n");
    }
    fclose($f);
}

$f = fopen('files/f.txt', 'r');
$lines = [];

if ($f) {
    while (($buffer = fgets($f, 4096)) !== false) {
        if ($buffer = trim($buffer))
            $lines[] = $buffer;
    }
    if (!feof($f)) {
        echo "Error: unexpected fgets() fail\n";
    }
}
fclose($f);
?>

<html>
<body>

<form method="POST">
    <?php
    foreach ($lines as $line) {
        echo "<p><input type='text' value='$line' name='$line'></p>";
    }
    echo "<p><input type='submit' value='Ok'></p>";
    ?>
</form>


</body>

</html>



<?php
