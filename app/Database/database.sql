CREATE DATABASE `proyecto-desarrollo` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

-- `proyecto-desarrollo`.asignacion_cursos definition

CREATE TABLE `asignacion_cursos` (
  `id_asignacion` int(11) NOT NULL AUTO_INCREMENT,
  `id_estudiante` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_seccion` int(11) DEFAULT NULL,
  `fecha_asignacion` date NOT NULL DEFAULT curdate(),
  `nota_primer_parcial` decimal(5,2) DEFAULT NULL,
  `nota_segundo_parcial` decimal(5,2) DEFAULT NULL,
  `nota_examen_final` decimal(5,2) DEFAULT NULL,
  `zona` decimal(5,2) DEFAULT NULL,
  `nota_final` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id_asignacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- `proyecto-desarrollo`.carreras definition

CREATE TABLE `carreras` (
  `id_carrera` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_carrera` varchar(100) NOT NULL,
  PRIMARY KEY (`id_carrera`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- `proyecto-desarrollo`.cursos definition

CREATE TABLE `cursos` (
  `id_curso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_curso` varchar(100) NOT NULL,
  `fk_id_semestre` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- `proyecto-desarrollo`.estudiantes definition

CREATE TABLE `estudiantes` (
  `id_estudiante` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `fotografia` longblob DEFAULT NULL,
  `fk_carrera_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_estudiante`),
  KEY `fk_carrera_id` (`fk_carrera_id`),
  CONSTRAINT `estudiantes_ibfk_1` FOREIGN KEY (`fk_carrera_id`) REFERENCES `carreras` (`id_carrera`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- `proyecto-desarrollo`.secciones definition

CREATE TABLE `secciones` (
  `id_seccion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_seccion` varchar(50) NOT NULL,
  PRIMARY KEY (`id_seccion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- `proyecto-desarrollo`.semestres definition

CREATE TABLE `semestres` (
  `id_semestre` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_semestre` varchar(20) NOT NULL,
  PRIMARY KEY (`id_semestre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;