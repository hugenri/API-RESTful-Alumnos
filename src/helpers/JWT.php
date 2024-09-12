<?php
require 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;  // Importa la clase Key


class JWTHandler {
    private $secret_key = "tu_clave_secreta";
    private $issuer = "localhost";

    public function encode($data) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;
        $payload = array(
            "iss" => $this->issuer,
            "iat" => $issuedAt,
            "exp" => $expirationTime,
            "data" => $data
        );

        return JWT::encode($payload, $this->secret_key, 'HS256');
    }

   
    
    public function decode($jwt) {
        try {
            $decoded = JWT::decode($jwt, new Key($this->secret_key, 'HS256'));
            return (array) $decoded;
        } catch (\Firebase\JWT\ExpiredException $e) {
            return ["error" => "Token expirado"];
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            return ["error" => "Firma inválida"];
        } catch (\Firebase\JWT\BeforeValidException $e) {
            return ["error" => "Token aún no es válido"];
        } catch (\DomainException $e) {
            return ["error" => "Datos incorrectos en el token"];
        } catch (Exception $e) {
            return ["error" => "Error desconocido: " . $e->getMessage()];
        }
    }

}
