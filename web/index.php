<?php

require("../protected/App.php");

new App;

DB::insert("link, hash, hits", '\':link\', \':hash\', :hits', [
    'link' => 'http://ololo.lo/sdgjsfklsdjgldfkgjsdlkjksdlkgjdfklgslksdfgkldfglsmsdl;fmsd;klgs',
    'hash' => '123456',
    'hits' => 1
]);