<?php
namespace App\Controllers;

use \Zardak\Template;

class PageNotFound
{
    public static function index()
    {

    	$views_chain = array(
            '404',
            'base' => array(
                'title' => 'صفحه یافت نشد!',
            ),
        );
        $tpl = new Template($views_chain);
        $tpl->render();

        header("HTTP/1.0 404 Not Found");
        exit();
    }
}