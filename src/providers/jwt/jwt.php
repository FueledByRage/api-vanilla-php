<?php

class JWT{
    function provider($arrayHeader, $arrayPayload){
        $header = json_encode($arrayHeader);
        $payload = json_encode($arrayPayload);
        
        $header = base64_encode($header);
        $payload = base64_encode($payload);
        
        $sign = $this->getSign($header, $payload);
        $sign = base64_encode($sign);
        
        $token = $header . '.' . $payload . '.' . $sign;

        return $token;
    }
    function decript($jwt){
        try{
            $explodedJWT = explode('.', $jwt);
            $header = $explodedJWT[0];
            $payload = $explodedJWT[1]; 

            $sign = $this->getSign($header, $payload);
    
            return  json_decode(base64_decode($payload));
        }catch(\throwable $exception){
            throw new Exception('Error decripting token.',406);
        }
    }
    private function getSign($header, $payload){
        $key = 'Um silencio de três partes';
        $sign = hash_hmac('sha256', $header . '.' . $payload, $key, true); 
        return $sign;
    }
}

