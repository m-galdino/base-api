<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function getMessageError(\Exception $e) {
        return array (
                'line' => $e->getLine(),
                'menssage' => $e->getMessage()
            );
    }
}
