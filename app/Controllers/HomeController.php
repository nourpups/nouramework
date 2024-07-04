<?php

namespace App\Controllers;

use App\Services\Rule34;
use Nouracea\Nouramework\Http\Controller\AbstractController;
use Nouracea\Nouramework\Http\Response;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly Rule34 $rule34,
    ) {}

    public function index(): Response
    {
        return $this->render('home', [
            'greeting' => $this->rule34->greeting(),
        ]);
    }
}
