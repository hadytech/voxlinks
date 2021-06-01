<?php


namespace ReviewX\Controllers;


abstract class Controller
{
    /**
     * Response
     *
     * @param [type] $data
     * @param integer $statusCode
     * @return void
     */
    public function response($data, $statusCode = 200)
    {
        wp_send_json($data, $statusCode);
    }
}