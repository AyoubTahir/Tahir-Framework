<?php

declare(strict_types=1);

namespace Tahir\App\Controllers;
use Tahir\App\Models\UsersModel;

class HomeController
{
    public function index(){
        echo 'tttttttttt';
    }

    public function show($id,$iid){
        echo 'ffffff'.$id.$iid;
        $um = new UsersModel();
        var_dump($um->rawQuery('SELECT * FROM users')->rawFirst());
    }

    public function store($request){
        var_dump($request);
        echo 'storeeeee';
    }

}