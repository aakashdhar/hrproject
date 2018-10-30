<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $data = [];
    protected $title = '';

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        $this->data['title'] = $this->title;
    }

    protected function getData($key = null) {
        if(!empty($key)) {
            return $this->data[$key];
        }
        return $this->data;
    }

    protected function setData($data) {
        $this->data = $data;
    }
    protected function addData($key, $value) {
        $this->data[$key] = $value;
    }

    protected function addArray($arr) {
        $this->data = array_merge($this->data, $arr);
    }

    protected function getView($name, $data = null) {
        $data = isset($data) ? $data : $this->getData();
        return view($name, $data);
    }

}
