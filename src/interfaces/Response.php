<?php 

namespace App\interfaces;

interface Response{
    public function parseArray($data);
    public function parseOne($data);
}
?>