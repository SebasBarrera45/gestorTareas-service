<?php
// Importar la clase Usuario desde el archivo "usuario.php"
require_once("../models/usuario.php");
// Crear una instancia de la clase Usuario
$modelos = new Usuario();

// Decodificar el cuerpo JSON de la solicitud
$body = json_decode(file_get_contents("php://input"), true);

// Determinar la opción proporcionada en la solicitud GET
switch ($_GET["option"]) {

    case "login";
        // Llamar al método "login" en la instancia de Usuario con los datos del cuerpo
        $datos = $modelos->login($body['correo'], $body['pass']);
        // Devolver los datos como respuesta en formato JSON
        echo json_encode($datos);
        break;

    case "agregarUsuario";
        // Llamar al método "agregarUsuario" en la instancia de Usuario con los datos del cuerpo
        $datos = $modelos->agregarUsuario($body['nombre'], $body['apellidoP'], $body['apellidoM'], $body['correo'], $body['pass']);
        // Devolver los datos como respuesta en formato JSON
        echo json_encode($datos);
        break;

    case "traerMascotas";
        // Llamar al método "get_mascotas" en la instancia de Usuario
        $datos = $modelos->get_mascotas();
        // Devolver los datos como respuesta en formato JSON
        echo json_encode($datos);
        break;

    case "get_pass";
        // Llamar al método "get_pass" en la instancia de Usuario con el correo del cuerpo
        $datos = $modelos->get_pass($body['correo']);
        // Devolver los datos como respuesta en formato JSON
        echo json_encode($datos);
        break;

    case "get_alumno_x_id";
        // Llamar al método "get_alumno_x_id" en la instancia de Usuario con el ID de mascotas del cuerpo
        $datos = $modelos->get_alumno_x_id($body["idmascotas"]);
        // Devolver los datos como respuesta en formato JSON
        echo json_encode($datos);
        break;

    case "traerMascota";
        // Llamar al método "get_mascota" en la instancia de Usuario
        $datos = $modelos->get_mascota();
        // Devolver los datos como respuesta en formato JSON
        echo json_encode($datos);
        break;

    case "traerUsuarios";
        // Llamar al método "traerUsuarios" en la instancia de Usuario
        $datos = $modelos->traerUsuarios();
        // Devolver los datos como respuesta en formato JSON
        echo json_encode($datos);
        break;

    case "agregarMascota";
        // Llamar al método "agregarMascota" en la instancia de Usuario con los datos del cuerpo
        $datos = $modelos->agregarMascota($body['nombre'], $body['edad'], $body['causa']);
        // Devolver los datos como respuesta en formato JSON
        echo json_encode($datos);
        break;

    case "editarActividad";
        // Llamar al método "editarActividad" en la instancia de Usuario con los datos del cuerpo
        $datos = $modelos->editarActividad($body['idmascotas'], $body['nombre'], $body['edad'], $body['causa']);
        // Devolver los datos como respuesta en formato JSON
        echo json_encode($datos);
        break;

    case "get_actividad_x_id";
        // Llamar al método "get_actividad_x_id" en la instancia de Usuario con el ID de mascotas del cuerpo
        $datos = $modelos->get_actividad_x_id($body['idmascotas']);
        // Devolver los datos como respuesta en formato JSON
        echo json_encode($datos);
        break;

    case "deleteActividad";
        // Llamar al método "deleteActividad" en la instancia de Usuario con el ID de mascotas del cuerpo
        $datos = $modelos->deleteActividad($body['idmascotas']);
        // Devolver los datos como respuesta en formato JSON
        echo json_encode($datos);
        break;

    // Las opciones comentadas no están actualmente en uso y pueden eliminarse o descomentarse según sea necesario.
}
?>
