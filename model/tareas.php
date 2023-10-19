<?php
require_once("../conexion.php");
$data = json_decode(file_get_contents("php://input"), true);

class Usuario extends Conexion {
    
    public function traerTarea_x_id($id) {
        $db = parent::connect();
        parent::set_names();
        $sql = "SELECT * FROM tarea WHERE id = ?;";
        $sql = $db->prepare($sql);
        $sql->bindValue(1, $id);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function traerTarea() {
        $db = parent::connect();
        parent::set_names();
        $sql = "SELECT id, titulo, descripcion, fecha FROM tarea;";
        $sql = $db->prepare($sql);
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function editarTarea($id, $titulo, $descripcion, $fecha) {
        $db = parent::connect();
        parent::set_names();
        $sql = "UPDATE `tarea` SET `titulo`='$titulo',`descripcion`='$descripcion',`fecha`='$fecha' WHERE `id` = $id;";
        $sql = $db->prepare($sql);
        $resultado['estatus'] = $sql->execute();
        return $resultado;
    }

    public function agregarTarea($titulo, $descripcion, $fecha) {
        $link = parent::connect();
        parent::set_names();
        $sql = "INSERT INTO `usuarios`(`titulo`, `descripcion`, `fecha`) VALUES (?,?,?)";
        $sql = $link->prepare($sql);
        $sql->bindValue(1, $titulo);
        $sql->bindValue(2, $descripcion);
        $sql->bindValue(3, $fecha);

        try {
            $result['status'] = $sql->execute();
        } catch (PDOException $e) {
            $result['code'] = $e->getCode();
        } finally {
            return $result;
        }
    }

    // Método para eliminar una actividad de una mascota
    public function deleteTarea($id) {
        $db = parent::connect();
        parent::set_names();
        $sql = "DELETE FROM `tarea` WHERE id = ?;";
        $sql = $db->prepare($sql);
        $sql->bindValue(1, $id);
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
