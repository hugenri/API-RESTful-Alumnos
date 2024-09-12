<?php

require_once 'src/config/Database.php';
require_once 'src/controllers/AuthController.php';
require_once 'src/controllers/AlumnoController.php';

$database = new Database();
$db = $database->getConnection();

$authController = new AuthController($db);
$alumnoController = new AlumnoController($db);

$requestMethod = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

$headers = apache_request_headers();

if ($uri[2] == 'register' && $requestMethod == 'POST') {
    // Procesar registro
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data['email'];
    $password = $data['password'];
    echo json_encode($authController->register($email, $password));
} elseif ($uri[2] == 'login' && $requestMethod == 'POST') {
    // Procesar login
    $data = json_decode(file_get_contents("php://input"), true);
    $email = $data['email'];
    $password = $data['password'];
    echo json_encode($authController->login($email, $password));
} elseif ($uri[2] == 'alumnos' && $requestMethod == 'GET') {
    // Obtener lista de alumnos
    $alumnoController->getAlumnos($headers);
} elseif ($uri[2] == 'alumnos' && $requestMethod == 'POST') {
    // Agregar un nuevo alumno
    $data = json_decode(file_get_contents("php://input"), true);
    echo json_encode($alumnoController->addAlumno($headers, $data));
}elseif ($uri[2] == 'alumnos' && $requestMethod == 'PUT') {
    // Actualizar un alumno existente
    $data = json_decode(file_get_contents("php://input"), true);
    echo json_encode($alumnoController->updateAlumno($headers, $data));
} elseif ($uri[2] == 'alumnos' && $requestMethod == 'DELETE') {
    // Eliminar un alumno existente
    $data = json_decode(file_get_contents("php://input"), true);
    echo json_encode($alumnoController->deleteAlumno($headers, $data));
}else {
    // Ruta no encontrada
    http_response_code(404);
    echo json_encode(array("message" => "Ruta no encontrada."));
}

