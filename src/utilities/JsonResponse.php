<?php

namespace App\utilities;

use App\interfaces\Response;

class JsonResponse implements Response{

  public function parseArray($data){
    
    $json = [];

    foreach ($data as $user) {
      $arr = [
        "id" => $user->getId(),
        "firstName" => $user->getPerson()->getFirstName(),
        "lastName" => $user->getPerson()->getLastName(),
        "phone" => $user->getPerson()->getPhone(),
        "status" => $user->getPerson()->getStatus(),
        "updatedAt" => $user->getPerson()->getUpdatedAt()->format('Y-m-d H:i:s'),
        "role" => $user->getPerson()->getRole()->getName(),
      ];
      if($user->getPerson()->getRole()->getName() === "Patient"){
        $arr['insureNumber'] = $user->getInsureNumber();
        $arr['address'] = $user->getAddress();
        $arr['dob'] = $user->getDob();
        $arr['personContact'] = [
          "fistName" => $user->getPersonContact()->getFirstName(),
          "lastName" => $user->getPersonContact()->getLastName(),
          "phone" => $user->getPersonContact()->getPhone(),
          "address" => $user->getPersonContact()->getAddress(),
        ];
      }else{
        $arr["email"] = $user->getEmail();
      }
      $json[] = $arr;
    }
    return $json;
  }

  
  public function parseOne($user)
  {
      $arr = [
        "id" => $user->getId(),
        "firstName" => $user->getPerson()->getFirstName(),
        "lastName" => $user->getPerson()->getLastName(),
        "phone" => $user->getPerson()->getPhone(),
        "status" => $user->getPerson()->getStatus(),
        "updatedAt" => $user->getPerson()->getUpdatedAt()->format('Y-m-d H:i:s'),
        "role" => $user->getPerson()->getRole()->getName(),
      ];
      if($user->getPerson()->getRole()->getName() === "Patient"){
        $arr['insureNumber'] = $user->getInsureNumber();
        $arr['address'] = $user->getAddress();
        $arr['dob'] = $user->getDob();
        $arr['personContact'] = [
          "fistName" => $user->getPersonContact()->getFirstName(),
          "lastName" => $user->getPersonContact()->getLastName(),
          "phone" => $user->getPersonContact()->getPhone(),
          "address" => $user->getPersonContact()->getAddress(),
        ];
      }else{
        $arr["email"] = $user->getEmail();
      }
      return $arr;
  }
}