<?php
/**
 * @var $content string
 * @var $siteName
 * @var $title
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=isset($title) ? $title : $siteName?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Делает короткие временные ссылки.">
    <link rel="stylesheet" href="/frontend/style.css">
    <script src="/frontend/jquery-3.2.1.min.js"></script>
    <script src="/frontend/main.js"></script>
</head>
<body>
<div id="header">
    <h1><a href="/" class="sitename" rel="nofollow"><?=$siteName?></a></h1>
</div>
<div id="js-alert"></div>
<?=$content?>
</body>
</html>