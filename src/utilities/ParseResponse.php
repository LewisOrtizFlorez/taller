<?php

namespace App\utilities;
use App\interfaces\Response;

class ParseResponse{
  public function parseArray($data, Response $response){
      return $response->parseArray($data);
  }
  public function parseOne($data, Response $response){
      return $response->parseOne($data);
  }
}

?>