<?php
/**
 * @var $modelLink LinkModel
 */
?>
<div class="response">
    <h2><?=$modelLink->getShort()?></h2>
    <span class="smaller calm"> Вместо <?=$modelLink->link?></span>
    <p class="small">Теперь вы можете поделиться новой, более короткой и удобной ссылкой!</p>
    <p class="small">Эта <a href="<?=$modelLink->hash?>">короткая ссылка</a> сработает 5 раз.</p>
</div>