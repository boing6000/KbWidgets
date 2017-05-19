<?php
/**
 * Created by PhpStorm.
 * User: boing
 * Date: 27/02/2017
 * Time: 21:06
 */

namespace Plugin\KbWidgets\Controllers;


use Ip\Response\Json;
use Plugin\KbCore\KbModel;

class Controller
{
    protected $action;
    protected $dataName = 'data';

    public function __construct()
    {
        if( ipRequest()->getPost('action') !== null ){
            $this->action = ipRequest()->getPost('action');
        }else{
            $this->action = ipRequest()->getQuery('action');
        }


        if (empty($this->action)) {
            $this->action = 'index';
        }
    }

    public function render()
    {
        $action = $this->action;
        if (method_exists($this, $action)) {
            return $this->$action();
        }

        return $this->json('404', true);
    }

    protected function decodePost($key = 'data')
    {
        return KbModel::decode(ipRequest()->getPost($key), true);
    }

    protected function parseData($data)
    {
        foreach ($data as $i => $item) {
            if ($item == 'true' || $item == 'false') {
                $data[$i] = $item === 'true' ? 1 : 0;
            }

            if($item === ''){
                $data[$i] = null;
            }
        }

        return $data;
    }

    protected function isLoggedIn()
    {
        return ipAdminId() != false;
    }

    public function json($data, $error = false, $total = 0)
    {
        $status = 'success';
        if (!empty($total)) {
            //$data['total'] = $total;
        }
        if ($error) {
            $status = 'error';
        } else {
            //$data = KbModel::encode($data);
            $data = ($data);
        }
        $res = [
            'status'        => $status,
            $this->dataName => $data,
            'total'         => $total
        ];

        return new Json($res);
    }
}