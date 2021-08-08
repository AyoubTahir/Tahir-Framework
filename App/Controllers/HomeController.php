<?php

declare(strict_types=1);

namespace Tahir\App\Controllers;

use Tahir\App\Models\UsersModel;
use Tahir\Core\Main\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

    }

    public function index(){
        echo 'tttttttttt';
        $um = new UsersModel();
        
        $this->render('client/home/index.html', [
            'users' => $um->rawQuery('SELECT * FROM users')->rawGet()
        ]);
    }

    public function show($id,$iid){
        echo 'ffffff'.$id.$iid;
        
    }

    public function store($request){
        var_dump($request);
        echo 'storeeeee';
    }

}