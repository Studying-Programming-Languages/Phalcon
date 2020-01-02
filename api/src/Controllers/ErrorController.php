<?php

namespace App\Phalcon\Controllers;

use Phalcon\Mvc\Micro;

class ErrorController extends Micro
{
    /**
     * Error 404 (page not found)
     * @return html page error
     */
    public function page404Action()
    {
        $this->response->setContentType("application/json", "UTF-8");
        $this->response->setRawHeader("HTTP/1.1 404 Not Found");
        $this->response->setStatusCode(404, "Not Found");
        $this->response->setJsonContent(
            array(
                'status'  => '404',
                'message' => 'service not found or unavailable',
                'data'    => '',
            ),
            JSON_PRETTY_PRINT
        );

        return $this->response;
    }
}