<?php
// Importar el archivo de conexión a la base de datos
require_once("../conexion.php");

// Decodificar los datos JSON recibidos en la solicitud
$data = json_decode(file_get_contents("php://input"), true);

// Definir la clase Usuario, que extiende la clase Conexion
class Usuario extends Conexion {

    // Método para realizar el inicio de sesión
    public function login($correo, $pass) {
        $db = parent::connect(); // Obtener una conexión a la base de datos
        parent::set_names(); // Establecer el conjunto de caracteres
        // Consulta SQL para verificar las credenciales de inicio de sesión
        $sql = "SELECT COUNT(idusuarios) existe, idusuarios FROM usuarios WHERE correo = ? AND pass = ?;";
        $sql = $db->prepare($sql);
        $sql->bindValue(1, $correo);
        $sql->bindValue(2, $pass);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_OBJ);

        // Crear un array para almacenar los resultados
        $Array = [];
        foreach ($resultado as $d) {
            $Array[] = [
                'existe' => (int)$d->existe,
                'idusuarios' => (int)$d->idusuarios
            ];
        }
        // Si el usuario existe, obtener los permisos
        if ($Array[0]['existe']) {
            $sql = "SELECT p.editar, p.crear, p.borrar, p.leer, e.entity FROM `permisos` p JOIN entity e ON p.entity_identity = e.identity WHERE usuarios_idusuarios = ?";
            $sql = $db->prepare($sql);
            $sql->bindValue(1, $Array[0]['idusuarios']);
            $sql->execute();
            $resultado2 = $sql->fetchAll(PDO::FETCH_OBJ);
            $Array2 = [];
            foreach ($resultado2 as $d) {
                $Array2[] = [
                    'entity' => $d->entity,
                    'editar' => (int)$d->editar,
                    'crear' => (int)$d->crear,
                    'borrar' => (int)$d->borrar,
                    'leer' => (int)$d->leer,
                ];
            }
        }
        
        $Array[0]['permisos'] = $Array2;
        // Devolver el resultado en formato JSON
        return $Array;
    }

    // Método para obtener datos de mascotas por ID de mascotas
    public function get_alumno_x_id($idmascotas) {
        $db = parent::connect();
        parent::set_names();
        $sql = "SELECT * FROM mascotas WHERE idmascotas = ?;";
        $sql = $db->prepare($sql);
        $sql->bindValue(1, $idmascotas);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    // Método para obtener una lista de mascotas
    public function traerUsuarios() {
        $db = parent::connect();
        parent::set_names();
        $sql = "SELECT idusuarios, nombre, apellidoP, apellidoM, correo, pass FROM usuarios;";
        $sql = $db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    // Método para obtener una lista de mascotas
    public function get_mascota() {
        $db = parent::connect();
        parent::set_names();
        $sql = "SELECT idmascotas, nombreMascota, edadMascota, causa FROM mascotas;";
        $sql = $db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    // Método para obtener una lista de todas las mascotas
    public function get_alumno() {
        $db = parent::connect();
        parent::set_names();
        $sql = "SELECT * FROM `mascotas`;";
        $sql = $db->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_OBJ);
        $Array = [];
        foreach ($resultado as $d) {
            $Array[] = [
                'idmascotas' => (int)$d->idmascotas,
                'nombreMascota' => $d->nombreMascota,
                'edadMascotas' => (int)$d->edadMascotas,
                'causa' => $d->causa,
            ];
        }
        return $Array;
    }

    // Método para editar una mascota
    public function editarActividad($idmascotas, $nombreMascota, $edadMascota, $causa) {
        $db = parent::connect();
        parent::set_names();
        $sql = "UPDATE `mascotas` SET `nombreMascota`='$nombreMascota',`edadMascota`='$edadMascota',`causa`='$causa' WHERE `idmascotas` = $idmascotas;";
        $sql = $db->prepare($sql);
        $resultado['estatus'] = $sql->execute();
        return $resultado;
    }

    // Método para obtener una mascota por ID
    public function get_actividad_x_id($idmascotas) {
        $db = parent::connect();
        parent::set_names();
        $sql = "SELECT * FROM mascotas WHERE idmascotas = ?;";
        $sql = $db->prepare($sql);
        $sql->bindValue(1, $idmascotas);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    // Método para obtener la contraseña de un usuario por correo
    public function get_pass($correo) {
        $db = parent::connect();
        parent::set_names();
        $sql = "SELECT pass FROM usuarios WHERE correo = ?;";
        $sql = $db->prepare($sql);
        $sql->bindValue(1, $correo);
        $sql->execute();
        $query = $sql->fetch(PDO::FETCH_OBJ);
        return $query;
    }

    // Método para agregar un nuevo usuario
    public function agregarUsuario($nombre, $apellidoP, $apellidoM, $correo, $pass) {
        $link = parent::connect();
        parent::set_names();
        $sql = "INSERT INTO `usuarios`(`nombre`, `apellidoP`, `apellidoM`, `correo`, `pass`) VALUES (?,?,?,?,?)";
        $sql = $link->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $apellidoP);
        $sql->bindValue(3, $apellidoM);
        $sql->bindValue(4, $correo);
        $sql->bindValue(5, $pass);

        try {
            $result['status'] = $sql->execute();
        } catch (PDOException $e) {
            $result['code'] = $e->getCode();
        } finally {
            return $result;
        }
    }

    // Método para agregar una nueva mascota
    public function agregarMascota($nombre, $edad, $causa) {
        $link = parent::connect();
        parent::set_names();
        $sql = "INSERT INTO `mascotas`(`nombreMascota`, `edadMascota`, `causa`) VALUES (?,?,?);";
        $sql = $link->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $edad);
        $sql->bindValue(3, $causa);
        $resultado['estatus'] = $sql->execute();
        $lastInsertId = $link->lastInsertId();
        if ($lastInsertId != "0") {
            $resultado['id'] = (int)$lastInsertId;
        }
        return $resultado;
    }

    // Método para obtener una lista de mascotas
    public function get_mascotas() {
        $db = parent::connect();
        parent::set_names();
        $sql = "SELECT * FROM mascotas WHERE idmascotas >= 0";
        $sql = $db->prepare($sql);
        $sql->execute();
        $resultado = $sql->fetchAll(PDO::FETCH_OBJ);
        $Array = [];
        foreach ($resultado as $d) {
            $Array[] = [
                'idmascotas'    => (int)$d->idmascotas,
                'nombreMascota' => $d->nombreMascota,
                'edadMascota'   => (int)$d->edadMascota,
                'causa'         => $d->causa,
            ];
        }
        return $Array;
    }

    // Método para eliminar una actividad de una mascota
    public function deleteActividad($idmascota) {
        $db = parent::connect();
        parent::set_names();
        $sql = "DELETE FROM `mascotas` WHERE idmascotas = ?;";
        $sql = $db->prepare($sql);
        $sql->bindValue(1, $idmascota);

        try {
            $result['status'] = $sql->execute();
        } catch (PDOException $e) {
            $result['code'] = $e->getCode();
        } finally {
            return $result;
        }
    }
}
?>
