<?php

require_once 'src/models/Alumno.php';
require_once 'src/helpers/JWT.php';

class AlumnoController {
    private $conn;
    private $jwt;

    public function __construct($db) {
        $this->conn = $db;
        $this->jwt = new JWTHandler();
    }

    private function authenticate($headers) {
        //var_dump($headers['Authorization']);
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode(array("message" => "Token no proporcionado."));
            exit();
        }
    
        $token = trim(str_replace("Bearer", "", $headers['Authorization']));
       // var_dump("Token extraído: " . $token);
    
        try {
            $decoded = $this->jwt->decode($token);
          //  var_dump("Token decodificado: ", $decoded);
            if ($decoded === null || !isset($decoded['data'])) {
                throw new Exception("Token inválido o sin datos.");
            }
            return $decoded['data'];
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(array("message" => "Token inválido. Detalles: " . $e->getMessage()));
            exit();
        }
    }
    
    
    public function getAlumnos($headers) {
        // Autenticar el usuario usando JWT
        $authResult = $this->authenticate($headers);
        if (isset($authResult->message)) {
            http_response_code(401);
            return ["message" => $authResult->message];
        }
        $alumno = new Alumno($this->conn);
        $stmt = $alumno->read();

        $alumnos_arr = array();
        $alumnos_arr["records"] = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $alumno_item = array(
                "id" => $id,
                "nombre" => $nombre,
                "apellido" => $apellido,
                "email" => $email,
                "creado" => $creado
            );
            array_push($alumnos_arr["records"], $alumno_item);
        }

        http_response_code(200);
        echo json_encode($alumnos_arr);
    }

    public function addAlumno($headers, $data) {
        // Autenticar el usuario usando JWT
        $authResult = $this->authenticate($headers);
        if (isset($authResult->message)) {
            http_response_code(401);
            return ["message" => $authResult->message];
        }

        // Validar datos del alumno
        if (empty($data['nombre']) || empty($data['apellido']) || empty($data['email'])) {
            http_response_code(400);
            return ["message" => "Datos incompletos"];
        }

        // Insertar el nuevo alumno en la base de datos
        $query = "INSERT INTO alumnos (nombre, apellido, email) VALUES (:nombre, :apellido, :email)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nombre", $data['nombre']);
        $stmt->bindParam(":apellido", $data['apellido']);
        $stmt->bindParam(":email", $data['email']);

        if ($stmt->execute()) {
            http_response_code(201);
            return ["message" => "Alumno creado exitosamente"];
        } else {
            http_response_code(500);
            return ["message" => "Error al crear el alumno"];
        }
    }

    public function updateAlumno($headers, $data) {
        // Autenticar el usuario usando JWT
        $authResult = $this->authenticate($headers);
        if (isset($authResult->message)) {
            http_response_code(401);
            return ["message" => $authResult->message];
        }
    
        // Validar datos del alumno
        if (empty($data['id']) || empty($data['nombre']) || empty($data['apellido']) || empty($data['email'])) {
            http_response_code(400);
            return ["message" => "Datos incompletos"];
        }
    
        // Actualizar el alumno en la base de datos
        $query = "UPDATE alumnos SET nombre = :nombre, apellido = :apellido, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $data['id']);
        $stmt->bindParam(":nombre", $data['nombre']);
        $stmt->bindParam(":apellido", $data['apellido']);
        $stmt->bindParam(":email", $data['email']);
    
        if ($stmt->execute()) {
            http_response_code(200);
            return ["message" => "Alumno actualizado exitosamente"];
        } else {
            http_response_code(500);
            return ["message" => "Error al actualizar el alumno"];
        }
    }
public function deleteAlumno($headers, $data) {
    // Autenticar el usuario usando JWT
    $authResult = $this->authenticate($headers);
    if (isset($authResult->message)) {
        http_response_code(401);
        return ["message" => $authResult->message];
    }

    // Validar ID del alumno
    if (empty($data['id'])) {
        http_response_code(400);
        return ["message" => "ID del alumno no proporcionado"];
    }

    // Eliminar el alumno de la base de datos
    $query = "DELETE FROM alumnos WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $data['id']);

    if ($stmt->execute()) {
        http_response_code(200);
        return ["message" => "Alumno eliminado exitosamente"];
    } else {
        http_response_code(500);
        return ["message" => "Error al eliminar el alumno"];
    }
}
    

}
