<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap-reboot.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-grid.css">

</head>
<body>
<?php
$wimage = "";
$fimg = "";
$path1 = "images1/"; // задаем путь до сканируемой папки с изображениями
$path2 = "images2/";
$path3 = "images3/";
function add_path($path)
{
    return function ($img) use ($path) {
        return $path . $img;
    };
}

function generate_images($images, $template)
{
    uasort($images, function ($a, $b) use ($template) {
        $infoA = pathinfo($a);
        $infoB = pathinfo($b);
        return array_search($infoA['filename'], $template) <=> array_search($infoB['filename'], $template);
    });
    $images_string = "";
    foreach ($images as $image) { // делаем проход по массиву
        $images_string .= "<img src='" . htmlspecialchars(urlencode($image)) . "' alt='" . $image . "' />";
    }
    return $images_string;
}

$images1 = array_map(add_path($path1), scandir($path1));
$images2 = array_map(add_path($path2), scandir($path2));
$images3 = array_map(add_path($path3), scandir($path3));

$images = array_merge($images1, $images2, $images3);

$template1 = [14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1, 0];
$template2 = [0, 1, 2, 3, 4, 5, 6, 7, 10, 14, 13, 12, 11, 10, 9, 8];
$template3 = [0, 1, 2, 3, 4, 9, 8, 7, 6, 5, 10, 11, 12, 13, 14];
$template4 = [14, 13, 12, 11, 10, 9, 8, 0, 1, 2, 3, 4, 5, 6, 7];
$template5 = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];


$device1 = "";
$device2 = "";
$device3 = "";
$device4 = "";
$device5 = "";
if ($images !== false) { // если нет ошибок при сканировании
    $images = preg_grep("/\.(?:png|gif|jpe?g)$/i", $images); // через регулярку создаем массив только изображений
    if (is_array($images)) { // если изображения найдены

        $device1 = generate_images($images, $template1);
        $device2 = generate_images($images, $template2);
        $device3 = generate_images($images, $template3);
        $device4 = generate_images($images, $template4);
        $device5 = generate_images($images, $template5);

        echo "<div class='d-block d-sm-none'>" . $device1 . "</div>";
        echo "<div class='d-none d-sm-block d-md-none'>" . $device2 . "</div>";
        echo "<div class='d-none d-md-block d-lg-none'>" . $device3 . "</div>";
        echo "<div class='d-none d-lg-block d-xl-none'>" . $device4 . "</div>";
        echo "<div class='d-none d-xl-block'>" . $device5 . "</div>";

    } else { // иначе, если нет изображений
        echo "<div style='text-align:center'>Не обнаружено изображений в директории!</div>\n";
    }
} else { // иначе, если директория пуста или произошла ошибка
    echo "<div style='text-align:center'>Директория пуста или произошла ошибка при сканировании.</div>";
}

php ?>
</body>
</html>