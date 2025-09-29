<?php
class EstadisticasController {
    // Devuelve la cantidad de alumnos (id_rol = 1)
    public static function getCantidadAlumnos($conn) {
        $sql = "SELECT COUNT(*) as total FROM usuario WHERE id_rol = 1 AND habilitado = 1 AND cancelado = 0";
        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            return (int)$row['total'];
        }
        return 0;
    }

    // Devuelve la cantidad de profesores (id_rol = 2)
    public static function getCantidadProfesores($conn) {
        $sql = "SELECT COUNT(*) as total FROM usuario WHERE id_rol = 2 AND habilitado = 1 AND cancelado = 0";
        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            return (int)$row['total'];
        }
        return 0;
    }

    // Devuelve la cantidad de carreras
    public static function getCantidadCarreras($conn) {
        $sql = "SELECT COUNT(*) as total FROM carrera WHERE habilitado = 1 AND cancelado = 0";
        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            return (int)$row['total'];
        }
        return 0;
    }
}
