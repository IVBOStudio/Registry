<?php
?>
<?php
function check_mobile_device()
{
    $mobile_agent_array = array('ipad', 'iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'cellphone', 'opera mobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser');
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
// var_dump($agent);exit;
    foreach ($mobile_agent_array as $value) {
        if (strpos($agent, $value) !== false) return true;
    }
    return false;
}

$debug = false;
$mobile = true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IBS | Industrial Burning System</title>
    <?php
    if (!$debug) {
        if (check_mobile_device()) {
            echo '<link href="css/stylesMobile.css" rel="stylesheet" type="text/css">';
        } else {
            echo '<link href="css/styles.css" rel="stylesheet" type="text/css">';
        }
    }
    if ($debug) {
        if ($mobile) {
            print '<link href="css/stylesMobile.css" rel="stylesheet" type="text/css">';
        } else {
            print '<link href="css/styles.css" rel="stylesheet" type="text/css">';
        }
    }
    ?>
    <meta name="Keywords"
          content="IBS, Industrial, Burning, System, gorealka, промышленные горелки, промышленное оборудование, поставки">
    <meta name="Description" content="IBS. Поставка промышленного оборудования по России. +? (495) 611 00 62">
    <meta property="og:title" content="IBS | Industrial Burning System">
    <meta property="og:type" content="article"/>
    <meta property="og:url" content="#">
    <meta property="og:image" content="#"/>
    <meta property="og:site_name" content="IBS"/>
    <meta property="og:description" content="IBS. Поставка промышленного оборудования по России. +? (495) 611 00 62">
    <meta name="robots" content="nofollow">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,500" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">
</head>
<body>

<form class="authForm" enctype="multipart/form-data" action="../engine/login.php" method="POST">
    <input type="text" name="login" placeholder="Логин">
    <input type="password" name="password" placeholder="Пароль">
    <input type="hidden" name="admin" value="1">
    <input type="submit" value="Войти">
</form>

</body>
</html>
