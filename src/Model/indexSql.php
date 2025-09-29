<?php
// Consultas SQL para estadísticas del index

const SQL_CANTIDAD_ALUMNOS = "SELECT COUNT(*) as total FROM usuario WHERE id_rol = 1 AND habilitado = 1 AND cancelado = 0";
const SQL_CANTIDAD_PROFESORES = "SELECT COUNT(*) as total FROM usuario WHERE id_rol = 2 AND habilitado = 1 AND cancelado = 0";
const SQL_CANTIDAD_CARRERAS = "SELECT COUNT(*) as total FROM carrera WHERE habilitado = 1 AND cancelado = 0";
