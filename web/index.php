<?php

require("../myframework/App.php");



require_once "../protected/LinkModel.php";

$test = new LinkModel();

$test->findById(4);



$test::render("../protected/MainView.php");


//$test->save();