<?php
/**
 * @var $modelLink LinkModel
 */
?>
<div class="response">
    <h2><?=$modelLink->link?> => <?=$modelLink->getShort()?></h2>
    <p>Теперь вы можете поделиться новой, более короткой и удобной ссылкой!</p>
    <p>Эта <a href="<?=$modelLink->hash?>">короткая ссылка</a> сработает 5 раз.</p>
</div>