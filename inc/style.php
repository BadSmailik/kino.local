<?php
set_time_limit(0); // убираем ограничение по времени выполнения скрипта
ob_implicit_flush();

function random_string($length)
{ // функция генерации рандомной строки
    $chars = "abcdefghijklmnopqrstuvwxyz1234567890"; // символы из которых генерируем
    $numChars = strlen($chars); // Определяем длину $chars
    $string = ''; // задаем пустую переменную
    for ($i = 0; $i < $length; $i++) { // Собираем строку
        $string .= substr($chars, rand(1, $numChars) - 1, 1);
    }
    return $string; // Возвращаем готовую строку
}

function get_http_response_code($url)
{ // функция проверки http кода
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}

if (!file_exists('lightshot_images')) { // создаем директорию куда сохранять картинки, если отсутствует
    mkdir('lightshot_images', 0777);
}

$options = array(
    'http' => array(
        'method' => "GET",
        'header' => "Accept-language: en\r\n" . "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n"
    )
);
$context = stream_context_create($options);

while (1) {
    $randstring = random_string(5); // генерируем рандомную сроку
    $htmldata = file_get_contents('https://prnt.sc/m' . $randstring, false, $context); // подставляем рандомную строку и получаем код страницы
    preg_match_all('/<meta name=\"twitter:image:src\" content=\"(.*?)\"\/>/is', $htmldata, $img_url); // парсим регуляркой url картинки
    if (strlen($img_url[1][0]) > 1) { // проверяем длину полученной строки, если больше 1 - картинка по этому адресу есть
        $imgs = str_replace('//st.prntscr', 'https://st.prntscr', $img_url[1][0]);
        $localname = array_pop(explode('/', $img_url[1][0])); // разбиваем строку в массив и извлекаем последний элемент массива (т.е. imagename.png)
        $localpath = "./lightshot_images/" . $localname; // определяем куда будет сохраняться картинка локально.
        if (get_http_response_code($imgs) != "200") {
            echo "<span style='color:red;display:block;margin-bottom:10px;font-size:14px;'>404. По адресу " . $imgs . " картинки больше нет :(</span>";
        } else {
            file_put_contents($localpath, file_get_contents($imgs, false, $context)); // скачиваем, можно было бы реализовать через curl, но на мой взгляд это проще и быстрее
            echo "<span style='color:green;display:block;margin-bottom:10px;font-size:14px;'>Сохранение - " . $localname . " , url - http://prntscr.com/m" . $randstring . " , скачиваем с " . $imgs . "</span>";
        }
    } else {
        echo "<span style='color:red;display:block;margin-bottom:10px;font-size:14px;'>По адресу http://prntscr.com/m" . $randstring . " нет картинки</span>";
    }
}