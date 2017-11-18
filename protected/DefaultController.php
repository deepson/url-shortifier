<?php

/**
 * Created by PhpStorm.
 * User: deepson
 * Date: 17.11.17
 * Time: 19:12
 *
 * NOTICE: For now this isn't true controller, since I'm not finished Controller class.
 */
class DefaultController extends Base
{
    private $str = '';
    function __construct()
    {
        $this->str = self::getPath();
        switch ($this->str) {
            case '':
                $this->actionIndex();
                break;
            case 'add':
                $link = false;
                if(isset($_GET['link'])) {
                    $link = $_GET['link'];
                }
                $this->actionAdd($link);
                break;
            case 'list':
                $this->actionList();
                break;
            default:
                $this->actionRef($this->str);
        }
    }

    public function actionIndex()
    {
        self::render('MainView');
    }

    public function actionAdd($link)
    {
        if(filter_var($link, FILTER_VALIDATE_URL) === false) {
            App::kill('','', "Ввод '$link' не является ссылкой. Возможно, вы забыли протокол", 500, '',true);
        }
        $link = LinkModel::createShort($link);
        self::renderPartial("ResponseView", ['modelLink' => $link]);
    }

    public function actionRef($hash)
    {
        $link = LinkModel::byHash($hash);
        if($link->isNew) {
            http_response_code ( 404);
            //echo "Нет такой ссылки.";
            App::kill('','', 'К сожалению, такой короткой ссылки я не знаю. Даже и не знаю, куда вас перенаправить...<br>', 404, 'Несуществующая ссылка');
            return;
        }
        if($link->hits < 5) {
            header("Location: $link->link");

        } else {
            http_response_code (404);
            App::kill( '','',"Ссылка просрочена. <br>", 404, 'Ссылка просрочена :(');
        }
        $link->hits++;
        $link->save();
    }
    public function actionList()
    {
        $lists = (new LinkModel())->findAll('',[], 'LinkModel');
        var_dump($lists);
    }
}

new DefaultController();

