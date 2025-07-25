<?php

namespace App\Controllers;
use App\Core\Abstract\AbstractController;

class CompteController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
       
        
    }
    public function index()
    {
        $this->render("client/compte/index");
    }

}