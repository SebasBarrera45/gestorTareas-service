<?php
// Importar la clase Usuario desde el archivo "usuario.php"
require_once("../models/usuario.php");
// Crear una instancia de la clase Usuario
$modelos = new Usuario();

// Decodificar el cuerpo JSON de la solicitud
$body = json_decode(file_get_contents("php://input"), true);

// Determinar la opción proporcionada en la solicitud GET
switch ($_GET["option"]) {

    case "agregarTarea":
        $datos = $modelos->agregarTarea($body['titulo'], $body['descripcion'], $body['fecha']);
        echo json_encode($datos);
        break;

    case "traerTarea":
        $datos = $modelos->traerTarea();
        echo json_encode($datos);
        break;

    case "traerTarea_x_id":
        $datos = $modelos->traerTarea_x_id($body["id"]);
        echo json_encode($datos);
        break;

    case "editarTarea":
        $datos = $modelos->editarTarea($body['id'], $body['titulo'], $body['descripcion'], $body['fecha']);
        echo json_encode($datos);
        break;

    case "deleteTarea":
        $datos = $modelos->deleteTarea($body['id']);
        echo json_encode($datos);
        break;

}
?>
