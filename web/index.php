<?php

require("../myframework/App.php");

new App;

/*DB::insert("link, hash, hits", ':link, :hash, :hits', [
    'link' => 'http://ololo.lo/sdgjsfklsdjgldfkgjsdlkjksdlkgjdfklgslksdfgkldfglsmsdl;fmsd;klgs',
    'hash' => '123456',
    'hits' => 1
]);*/

require_once "../protected/LinkModel.php";

$test = new LinkModel();

$test->findById(5);

$test->link = 'no more links!!!';

echo $test->link;

$test->save();

var_dump($test);