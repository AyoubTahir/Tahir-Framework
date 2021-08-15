<?php

declare(strict_types=1);

namespace Tahir\App\Controllers;

use Tahir\App\Models\UsersModel;
use Tahir\Core\Main\Controller;

class HomeController extends Controller
{
    protected $um;

    public function __construct()
    {
        parent::__construct();
        $this->um = new UsersModel();
    }

    public function index()
    {
        echo 'tttttttttt';
        
        
        $this->render('client/home/index.html', [
            'users' => $this->um->All()
        ]);
    }

    public function show($id,$iid)
    {
        var_dump($this->um->findOneById((int)$id));
        
    }

    public function store($request){
        var_dump($request);
        echo 'storeeeee';
    }

}