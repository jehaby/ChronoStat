<?php
/**
 * Created by PhpStorm.
 * User: urf
 * Date: 9/4/14
 * Time: 6:39 PM
 */

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

include 'Merchant.php';

$merchants =  unserialize($_POST['merchants']);
$mapping =  unserialize($_POST['mapping']);
$new_merchant = new Merchant('', '', []);

foreach ($_POST as $k => $v) {    // it should be terribly ineffective
    if ($pos = strpos($k, '_')) {
        $m_name = strtok($k, '_');
        $m_second_field = strtok('_');

        if ($m_name != 'adding') {
            if (strlen($m_second_field) == 1) { // update percent of current decline
                $merchants[$m_name] -> declines[$mapping[$m_second_field]] = $v;
            } elseif ($m_second_field == 'name' && $v != $m_name) {//update name
                if (!$v) {  // delete record if empty string
                    unset($merchants[$m_name]);
                } else {  // else update
                    $merchants[$v] = $merchants[$m_name];
                    $merchants[$v] -> name = $v;
                    unset($merchants[$m_name]);
                }
            } elseif ($m_second_field == 'percent') { // update percent
                $merchants[$m_name] -> percent = $v;
            }
        } else {
            if (strlen($m_second_field) == 1) {
                $new_merchant -> declines[$mapping[$m_second_field]] = $v;
            } elseif ($m_second_field == 'name') {
                $new_merchant -> name = $v;
            } elseif ($m_second_field == 'percent') {
                $new_merchant -> percent = $v;
            }
        }
    }
}

if ($new_merchant -> name) {
    $merchants[$new_merchant -> name] = $new_merchant;
}

print_r($merchants);

?>

<form method="POST" action="index.php" >
    <input type="hidden" name="merchants" value="<?php echo htmlentities(serialize($merchants)); ?>">
    <input type="submit">
</form>







