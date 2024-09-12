<?php

require_once 'src/helpers/JWT.php';

class AuthController {
    private $conn;
    private $jwt;

    public function __construct($db) {
        $this->conn = $db;
        $this->jwt = new JWTHandler();
    }

    public function login($email, $password) {
        $query = "SELECT id, email, password FROM usuarios WHERE email = :email LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $token = $this->jwt->encode(["id" => $user['id'], "email" => $user['email']]);
            return array("token" => $token);
        } else {
            http_response_code(401);
            return array("message" => "Autenticación fallida.");
        }
    }

    public function register($email, $password) {
        // Comprobar si el email ya existe
        $query = "SELECT id FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            http_response_code(400);
            return array("message" => "El email ya está en uso.");
        }
    
        // Hashear la contraseña
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
        // Insertar el nuevo usuario
        $query = "INSERT INTO usuarios (email, password) VALUES (:email, :password)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashedPassword);
    
        if ($stmt->execute()) {
            return array("message" => "Registro exitoso.");
        } else {
            http_response_code(500);
            return array("message" => "Error al registrar el usuario.");
        }
    }
    
}
