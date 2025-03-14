-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 02-08-2024 a las 05:35:06
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `academia`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `SP_ACTUIALIZAR_ASISTENCIAS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ACTUIALIZAR_ASISTENCIAS` (IN `P` TEXT, IN `S` TEXT)   BEGIN
    UPDATE asistencias
    SET
        asistencias.dia = P,
        asistencias.asistencia = S,
        asistencias.fecha = CURDATE();
END$$

DROP PROCEDURE IF EXISTS `SP_COMBO_DOCENTES_HORARIOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_COMBO_DOCENTES_HORARIOS` ()   SELECT
	docentes.ID, 
	CONCAT(docentes.nombre_docente, ' ', docentes.apellidos_docente) AS docente, 
	docentes.id_usu
FROM
	docentes$$

DROP PROCEDURE IF EXISTS `SP_COMBO_ESTUDIANTE_LISTAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_COMBO_ESTUDIANTE_LISTAR` (IN `IDDOC` INT, IN `IDASIG` INT, IN `IDGRADO` INT)   SELECT
estudiantes.ID,
CONCAT_WS(' ', estudiantes.nombre_estudiante,estudiantes.apellidos_estudiante) AS Estudiantes


FROM
estudiantes
INNER JOIN grados ON estudiantes.id_grado = grados.ID
INNER JOIN calificaciones ON calificaciones.id_estudiante = estudiantes.ID
INNER JOIN deatlles_cursos ON deatlles_cursos.id_aula = grados.ID
INNER JOIN cursos ON deatlles_cursos.id_curso = cursos.ID
INNER JOIN docentes ON deatlles_cursos.id_docente = docentes.ID

WHERE deatlles_cursos.id_docente = IDDOC AND deatlles_cursos.id_aula = IDGRADO AND deatlles_cursos.id_curso = IDASIG$$

DROP PROCEDURE IF EXISTS `SP_CONTADOR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CONTADOR` ()   SELECT 
    (SELECT COUNT(*) FROM usuario) As contar_usuario, 
    (SELECT COUNT(*) FROM docentes) AS contar_docente,
		(SELECT COUNT(*) FROM estudiantes) AS contar_estudiantes,
		(SELECT COUNT(*) FROM cursos) AS contar_cursos
	FROM DUAL$$

DROP PROCEDURE IF EXISTS `SP_CONTADOR_ASISTENCIAS_ESPECIFICAS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CONTADOR_ASISTENCIAS_ESPECIFICAS` (IN `IDES` INT, IN `IDCURSO` INT)   SELECT
    estudiantes.ID,
    asistencias.ID as id_asistencia,
    CONCAT_WS(' ', estudiantes.nombre_estudiante, estudiantes.apellidos_estudiante) AS Estudiante,
    IFNULL(
        CASE
            WHEN SUM(CASE WHEN detalles_sistencias.asistencia = 'NO ASISTIÓ' THEN 1 ELSE 0 END) = '(N/A)'
            THEN 0
            ELSE SUM(CASE WHEN detalles_sistencias.asistencia = 'NO ASISTIÓ' THEN 1 ELSE 0 END)
        END,
        0
    ) AS Total_No_Asistencias
FROM
    detalles_sistencias
INNER JOIN asistencias ON detalles_sistencias.id_asistencia = asistencias.ID
INNER JOIN deatlles_cursos ON detalles_sistencias.id_docente = deatlles_cursos.id_docente AND asistencias.id_grupo = deatlles_cursos.ID
INNER JOIN estudiantes ON asistencias.id_estudiante = estudiantes.ID
INNER JOIN docentes ON deatlles_cursos.id_docente = docentes.ID
WHERE
    asistencias.id_estudiante = IDES
    AND deatlles_cursos.id_curso = IDCURSO 
GROUP BY
    estudiantes.ID, asistencias.ID, Estudiante$$

DROP PROCEDURE IF EXISTS `SP_CONTADOR_ASISTENCIAS_GENERALES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CONTADOR_ASISTENCIAS_GENERALES` (IN `IDCURSO` INT, IN `IDGRADO` INT, IN `IDUSU` INT)   SELECT 
  (SELECT COUNT(*) FROM detalles_sistencias WHERE asistencia = 'NO ASISTIÓ') AS asistencias 
FROM DUAL$$

DROP PROCEDURE IF EXISTS `SP_EDITAR_ASIGNACION_CLASES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EDITAR_ASIGNACION_CLASES` (IN `IDCLASS` INT, IN `URL` VARCHAR(255), IN `FC` DATE)   UPDATE clases SET

clases.link = URL,
clases.fecha = FC

WHERE clases.ID = IDCLASS$$

DROP PROCEDURE IF EXISTS `SP_EDITAR_CARPETA_MATERIAL`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EDITAR_CARPETA_MATERIAL` (IN `id_usuario_param` INT, IN `titulo_carpeta_param` TEXT, IN `id_carpeta_param` INT)   BEGIN
    DECLARE carpeta_existente INT DEFAULT 0;

    -- Verificar si ya existe una carpeta con el mismo título para el usuario dado, excluyendo la carpeta que se está editando
    SELECT COUNT(*) INTO carpeta_existente 
    FROM material 
    WHERE id_docente = id_usuario_param 
    AND titulo = titulo_carpeta_param 
    AND ID <> id_carpeta_param;

    IF carpeta_existente > 0 THEN
        -- Ya existe una carpeta con el mismo título para el usuario dado
        SELECT -1 AS result;
    ELSE
        -- Se verifica si la carpeta que se está editando pertenece al usuario
        SET @pertenece_usuario = (SELECT COUNT(*) FROM material WHERE id_docente = id_usuario_param AND ID = id_carpeta_param);
        
        IF @pertenece_usuario > 0 THEN
            -- La carpeta pertenece al usuario, se puede editar
            UPDATE material 
            SET titulo = titulo_carpeta_param 
            WHERE ID = id_carpeta_param;
            SELECT 1 AS result;
        ELSE
            -- La carpeta no pertenece al usuario
            SELECT 0 AS result;
        END IF;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_EDITAR_FORO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EDITAR_FORO` (IN `ID_DOCENTE` INT, IN `ID_GRUPO` INT, IN `ID_FORO` INT, IN `TEMA_FORO` VARCHAR(255), IN `DESCRIPCION_FORO` TEXT)   BEGIN
    UPDATE foro
    SET
        foro.id_docente = ID_DOCENTE,
        foro.id_grupo = ID_GRUPO,
        foro.titulo = TEMA_FORO,
        foro.descripcion = DESCRIPCION_FORO
    WHERE foro.ID = ID_FORO;
END$$

DROP PROCEDURE IF EXISTS `SP_EDITAR_HORARIO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EDITAR_HORARIO` (IN `p_id_horario` INT, IN `p_bloque_1` TEXT, IN `p_bloque_2` TEXT, IN `p_bloque_3` TEXT, IN `p_bloque_4` TEXT, IN `p_bloque_5` TEXT, IN `p_bloque_6` TEXT, IN `p_lunes_1` INT, IN `p_lunes_2` INT, IN `p_lunes_3` INT, IN `p_lunes_4` INT, IN `p_lunes_5` INT, IN `p_lunes_6` INT, IN `p_martes_1` INT, IN `p_martes_2` INT, IN `p_martes_3` INT, IN `p_martes_4` INT, IN `p_martes_5` INT, IN `p_martes_6` INT, IN `p_miercoles_1` INT, IN `p_miercoles_2` INT, IN `p_miercoles_3` INT, IN `p_miercoles_4` INT, IN `p_miercoles_5` INT, IN `p_miercoles_6` INT, IN `p_jueves_1` INT, IN `p_jueves_2` INT, IN `p_jueves_3` INT, IN `p_jueves_4` INT, IN `p_jueves_5` INT, IN `p_jueves_6` INT, IN `p_viernes_1` INT, IN `p_viernes_2` INT, IN `p_viernes_3` INT, IN `p_viernes_4` INT, IN `p_viernes_5` INT, IN `p_viernes_6` INT)   BEGIN
    UPDATE horarios
    SET
        bloque_1 = p_bloque_1,
        bloque_2 = p_bloque_2,
        bloque_3 = p_bloque_3,
        bloque_4 = p_bloque_4,
        bloque_5 = p_bloque_5,
        bloque_6 = p_bloque_6,
        lunes_1 = p_lunes_1,
        lunes_2 = p_lunes_2,
        lunes_3 = p_lunes_3,
        lunes_4 = p_lunes_4,
        lunes_5 = p_lunes_5,
        lunes_6 = p_lunes_6,
        martes_1 = p_martes_1,
        martes_2 = p_martes_2,
        martes_3 = p_martes_3,
        martes_4 = p_martes_4,
        martes_5 = p_martes_5,
        martes_6 = p_martes_6,
        miercoles_1 = p_miercoles_1,
        miercoles_2 = p_miercoles_2,
        miercoles_3 = p_miercoles_3,
        miercoles_4 = p_miercoles_4,
        miercoles_5 = p_miercoles_5,
        miercoles_6 = p_miercoles_6,
        jueves_1 = p_jueves_1,
        jueves_2 = p_jueves_2,
        jueves_3 = p_jueves_3,
        jueves_4 = p_jueves_4,
        jueves_5 = p_jueves_5,
        jueves_6 = p_jueves_6,
        viernes_1 = p_viernes_1,
        viernes_2 = p_viernes_2,
        viernes_3 = p_viernes_3,
        viernes_4 = p_viernes_4,
        viernes_5 = p_viernes_5,
        viernes_6 = p_viernes_6
    WHERE horarios.ID = p_id_horario;
END$$

DROP PROCEDURE IF EXISTS `SP_EDITAR_HORARIO_DOCENTE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EDITAR_HORARIO_DOCENTE` (IN `p_id_horario` INT, IN `p_bloque_1` TEXT, IN `p_bloque_2` TEXT, IN `p_bloque_3` TEXT, IN `p_bloque_4` TEXT, IN `p_bloque_5` TEXT, IN `p_bloque_6` TEXT, IN `p_lunes_1` TEXT, IN `p_lunes_2` TEXT, IN `p_lunes_3` TEXT, IN `p_lunes_4` TEXT, IN `p_lunes_5` TEXT, IN `p_lunes_6` TEXT, IN `p_martes_1` TEXT, IN `p_martes_2` TEXT, IN `p_martes_3` TEXT, IN `p_martes_4` TEXT, IN `p_martes_5` TEXT, IN `p_martes_6` TEXT, IN `p_miercoles_1` TEXT, IN `p_miercoles_2` TEXT, IN `p_miercoles_3` TEXT, IN `p_miercoles_4` TEXT, IN `p_miercoles_5` TEXT, IN `p_miercoles_6` TEXT, IN `p_jueves_1` TEXT, IN `p_jueves_2` TEXT, IN `p_jueves_3` TEXT, IN `p_jueves_4` TEXT, IN `p_jueves_5` TEXT, IN `p_jueves_6` TEXT, IN `p_viernes_1` TEXT, IN `p_viernes_2` TEXT, IN `p_viernes_3` TEXT, IN `p_viernes_4` TEXT, IN `p_viernes_5` TEXT, IN `p_viernes_6` TEXT, IN `p_grado_lunes_1` TEXT, IN `p_grado_lunes_2` TEXT, IN `p_grado_lunes_3` TEXT, IN `p_grado_lunes_4` TEXT, IN `p_grado_lunes_5` TEXT, IN `p_grado_lunes_6` TEXT, IN `p_grado_martes_1` TEXT, IN `p_grado_martes_2` TEXT, IN `p_grado_martes_3` TEXT, IN `p_grado_martes_4` TEXT, IN `p_grado_martes_5` TEXT, IN `p_grado_martes_6` TEXT, IN `p_grado_miercoles_1` TEXT, IN `p_grado_miercoles_2` TEXT, IN `p_grado_miercoles_3` TEXT, IN `p_grado_miercoles_4` TEXT, IN `p_grado_miercoles_5` TEXT, IN `p_grado_miercoles_6` TEXT, IN `p_grado_jueves_1` TEXT, IN `p_grado_jueves_2` TEXT, IN `p_grado_jueves_3` TEXT, IN `p_grado_jueves_4` TEXT, IN `p_grado_jueves_5` TEXT, IN `p_grado_jueves_6` TEXT, IN `p_grado_viernes_1` TEXT, IN `p_grado_viernes_2` TEXT, IN `p_grado_viernes_3` TEXT, IN `p_grado_viernes_4` TEXT, IN `p_grado_viernes_5` TEXT, IN `p_grado_viernes_6` TEXT)   BEGIN
    UPDATE horarios_docentes
    SET
        bloque_1 = p_bloque_1,
        bloque_2 = p_bloque_2,
        bloque_3 = p_bloque_3,
        bloque_4 = p_bloque_4,
        bloque_5 = p_bloque_5,
        bloque_6 = p_bloque_6,
        lunes_1 = p_lunes_1,
        lunes_2 = p_lunes_2,
        lunes_3 = p_lunes_3,
        lunes_4 = p_lunes_4,
        lunes_5 = p_lunes_5,
        lunes_6 = p_lunes_6,
        martes_1 = p_martes_1,
        martes_2 = p_martes_2,
        martes_3 = p_martes_3,
        martes_4 = p_martes_4,
        martes_5 = p_martes_5,
        martes_6 = p_martes_6,
        miercoles_1 = p_miercoles_1,
        miercoles_2 = p_miercoles_2,
        miercoles_3 = p_miercoles_3,
        miercoles_4 = p_miercoles_4,
        miercoles_5 = p_miercoles_5,
        miercoles_6 = p_miercoles_6,
        jueves_1 = p_jueves_1,
        jueves_2 = p_jueves_2,
        jueves_3 = p_jueves_3,
        jueves_4 = p_jueves_4,
        jueves_5 = p_jueves_5,
        jueves_6 = p_jueves_6,
        viernes_1 = p_viernes_1,
        viernes_2 = p_viernes_2,
        viernes_3 = p_viernes_3,
        viernes_4 = p_viernes_4,
        viernes_5 = p_viernes_5,
        viernes_6 = p_viernes_6,
        grado_lunes_1 = p_grado_lunes_1,
        grado_lunes_2 = p_grado_lunes_2,
        grado_lunes_3 = p_grado_lunes_3,
        grado_lunes_4 = p_grado_lunes_4,
        grado_lunes_5 = p_grado_lunes_5,
        grado_lunes_6 = p_grado_lunes_6,
        grado_martes_1 = p_grado_martes_1,
        grado_martes_2 = p_grado_martes_2,
        grado_martes_3 = p_grado_martes_3,
        grado_martes_4 = p_grado_martes_4,
        grado_martes_5 = p_grado_martes_5,
        grado_martes_6 = p_grado_martes_6,
        grado_miercoles_1 = p_grado_miercoles_1,
        grado_miercoles_2 = p_grado_miercoles_2,
        grado_miercoles_3 = p_grado_miercoles_3,
        grado_miercoles_4 = p_grado_miercoles_4,
        grado_miercoles_5 = p_grado_miercoles_5,
        grado_miercoles_6 = p_grado_miercoles_6,
        grado_jueves_1 = p_grado_jueves_1,
        grado_jueves_2 = p_grado_jueves_2,
        grado_jueves_3 = p_grado_jueves_3,
        grado_jueves_4 = p_grado_jueves_4,
        grado_jueves_5 = p_grado_jueves_5,
        grado_jueves_6 = p_grado_jueves_6,
        grado_viernes_1 = p_grado_viernes_1,
        grado_viernes_2 = p_grado_viernes_2,
        grado_viernes_3 = p_grado_viernes_3,
        grado_viernes_4 = p_grado_viernes_4,
        grado_viernes_5 = p_grado_viernes_5,
        grado_viernes_6 = p_grado_viernes_6
    WHERE horarios_docentes.ID = p_id_horario;
END$$

DROP PROCEDURE IF EXISTS `SP_EDITAR_LINK`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EDITAR_LINK` (IN `IDLINK` INT, IN `LINKN` TEXT, IN `IDGRUP` INT, IN `FECHA` TEXT)   UPDATE clases SET 

clases.link = LINKN ,
clases.id_grupo = IDGRUP,
clases.fecha = FECHA

WHERE clases.ID = IDLINK$$

DROP PROCEDURE IF EXISTS `SP_EDITAR_MATERIAL_ARCHIVO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EDITAR_MATERIAL_ARCHIVO` (IN `TITULOMATERIAL` TEXT, IN `IDMATERIAL` INT, IN `URL` VARCHAR(255))   BEGIN
    UPDATE detalles_material 
    SET titulo = TITULOMATERIAL, archivo = URL 
    WHERE ID = IDMATERIAL;
END$$

DROP PROCEDURE IF EXISTS `SP_EDITAR_RESPUESTA`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EDITAR_RESPUESTA` (IN `IDCOM` INT, IN `RESP` TEXT)   UPDATE comentarios SET 

comentarios.respuesta = RESP,
comentarios.status = 'RESPONDIDO'

WHERE comentarios.ID = IDCOM$$

DROP PROCEDURE IF EXISTS `SP_EDITAR_RESPUESTA_DOCENTE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EDITAR_RESPUESTA_DOCENTE` (IN `IDCOM` INT, IN `RESP` TEXT)   UPDATE comentarios_asuntos SET 

comentarios_asuntos.respuesta = RESP,
comentarios_asuntos.estado = 'RESPONDIDO'

WHERE comentarios_asuntos.ID = IDCOM$$

DROP PROCEDURE IF EXISTS `SP_EDITAR_RESPUESTA_ES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EDITAR_RESPUESTA_ES` (IN `IDCOM` INT, IN `RESP` TEXT)   BEGIN
    UPDATE comentarios 
    SET 
        comentarios.comentarios = RESP
    WHERE 
        comentarios.ID = IDCOM;
END$$

DROP PROCEDURE IF EXISTS `SP_EDITAR_RESPUESTA_ES_ASUNTO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EDITAR_RESPUESTA_ES_ASUNTO` (IN `IDCOM` INT, IN `RESP` TEXT)   BEGIN
    UPDATE comentarios_asuntos
    SET 
        comentarios_asuntos.comentario = RESP
    WHERE 
        comentarios_asuntos.ID = IDCOM;
END$$

DROP PROCEDURE IF EXISTS `SP_ELIMINAR_COMENTARIO_FORO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ELIMINAR_COMENTARIO_FORO` (IN `id_comentario` INT)   BEGIN
    DELETE FROM detalles_foro WHERE ID = id_comentario;
END$$

DROP PROCEDURE IF EXISTS `SP_ELIMINAR_COMENTARIO_FORO_RESPUESTA`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ELIMINAR_COMENTARIO_FORO_RESPUESTA` (IN `id_comentario` INT)   BEGIN
    DELETE FROM detalles_foro_respuesta WHERE ID = id_comentario;
END$$

DROP PROCEDURE IF EXISTS `SP_ELIMINAR_MATERIAL_ARCHIVO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ELIMINAR_MATERIAL_ARCHIVO` (IN `id_material` INT)   BEGIN
    DELETE FROM detalles_material WHERE ID = id_material;
END$$

DROP PROCEDURE IF EXISTS `SP_INTENTO_USUARIO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_INTENTO_USUARIO` (IN `USUARIO` VARCHAR(50))   BEGIN
DECLARE INTENTO INT;
SET @INTENTO:=(SELECT usu_intento FROM usuario WHERE usu_nombre=USUARIO);
IF @INTENTO = 2 THEN
SELECT @INTENTO;
ELSE
UPDATE usuario SET
usu_intento=@INTENTO+1
WHERE usu_nombre=USUARIO;
SELECT @INTENTO;
END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_LISTARS_DOCENTES_COMENTARIOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTARS_DOCENTES_COMENTARIOS` (IN `IDGROUP` INT, IN `IDDOC` INT, IN `IDDES` INT)   SELECT
comentarios.ID,
talleres.titulo,
CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) as docentes,
comentarios.comentarios,
comentarios.respuesta,
comentarios.`status` as Estado,
comentarios.fecha
FROM
comentarios
INNER JOIN talleres ON comentarios.id_taller = talleres.ID
INNER JOIN estudiantes ON comentarios.id_estudiante = estudiantes.id_usu
INNER JOIN deatlles_cursos ON talleres.id_grupo = deatlles_cursos.ID
INNER JOIN cursos ON deatlles_cursos.id_curso = cursos.ID
INNER JOIN grados ON estudiantes.id_grado = grados.ID
INNER JOIN docentes ON talleres.id_docente = docentes.ID AND deatlles_cursos.id_docente = docentes.ID


WHERE deatlles_cursos.ID = IDGROUP AND deatlles_cursos.id_docente = IDDOC AND estudiantes.id_usu = IDDES$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_ASIGNACION_CLASES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_ASIGNACION_CLASES` (IN `IDUSU` INT, IN `IDGROUP` INT)   SELECT
clases.ID,
clases.link,
clases.fecha,
clases.estado,
CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) AS docente, 
clases.id_grupo

FROM
clases
INNER JOIN deatlles_cursos ON clases.id_docente = deatlles_cursos.id_docente AND clases.id_grupo = deatlles_cursos.ID
INNER JOIN docentes ON deatlles_cursos.id_docente = docentes.ID


WHERE deatlles_cursos.ID = IDGROUP AND docentes.id_usu = IDUSU$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_ASIGNACION_ESTUDIANTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_ASIGNACION_ESTUDIANTES` (IN `IDGROUP` INT, IN `IDDOC` INT)   SELECT
detalles_calificaciones.ID,
CONCAT_WS(' ',cursos.nombre,'  --  ',grados.aula) as grupo,
CONCAT_WS('  ',docentes.nombre_docente,docentes.apellidos_docente) as docente,
CONCAT_WS(' ',estudiantes.nombre_estudiante,estudiantes.apellidos_estudiante) as estudiantes

FROM
detalles_calificaciones
INNER JOIN calificaciones ON detalles_calificaciones.id_claificaciones = calificaciones.ID
INNER JOIN deatlles_cursos ON detalles_calificaciones.id_docente = deatlles_cursos.id_docente AND detalles_calificaciones.id_grupo = deatlles_cursos.ID
INNER JOIN docentes ON deatlles_cursos.id_docente = docentes.ID
INNER JOIN estudiantes ON calificaciones.id_estudiante = estudiantes.ID
INNER JOIN cursos ON deatlles_cursos.id_curso = cursos.ID
INNER JOIN grados ON deatlles_cursos.id_aula = grados.ID AND estudiantes.id_grado = grados.ID

WHERE deatlles_cursos.ID = IDGROUP AND deatlles_cursos.id_docente = IDDOC$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_ASISTENCIAS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_ASISTENCIAS` (IN `IDCURSO` INT, IN `IDGRADO` INT, IN `IDUSU` INT, IN `IDGROUP` INT)   SELECT
estudiantes.ID,
asistencias.ID as id_asistencia,
CONCAT_WS(' ',estudiantes.nombre_estudiante,estudiantes.apellidos_estudiante) AS Estudiante,
asistencias.asistencia,
asistencias.dia,
asistencias.fecha,
asistencias.id_grupo,
docentes.ID as id_docente
FROM
estudiantes
INNER JOIN grados ON estudiantes.id_grado = grados.ID
INNER JOIN deatlles_cursos ON deatlles_cursos.id_aula = grados.ID
INNER JOIN calificaciones ON calificaciones.id_estudiante = estudiantes.ID
INNER JOIN docentes ON deatlles_cursos.id_docente = docentes.ID
INNER JOIN asistencias ON asistencias.id_estudiante = estudiantes.ID

WHERE deatlles_cursos.id_curso  = IDCURSO AND deatlles_cursos.id_aula = IDGRADO AND docentes.id_usu = IDUSU AND asistencias.id_grupo = IDGROUP$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_ASUNTOS_DOCENTE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_ASUNTOS_DOCENTE` (IN `IDUSU` INT)   SELECT
	comentarios_asuntos.ID, 
	comentarios_asuntos.id_docente, 
	comentarios_asuntos.id_estudiante, 
	comentarios_asuntos.asunto, 
	comentarios_asuntos.comentario, 
	comentarios_asuntos.respuesta, 
	comentarios_asuntos.estado, 
	comentarios_asuntos.fecha, 
	CONCAT(estudiantes.nombre_estudiante, ' ', estudiantes.apellidos_estudiante) AS estudiante, 
	CONCAT(docentes.nombre_docente, ' ', docentes.apellidos_docente) AS docente, 
	usuario_docente.foto AS fotodocente,
	usuario_estudiante.foto AS fotoestudiante
FROM
	comentarios_asuntos
	INNER JOIN
	estudiantes
	ON 
		comentarios_asuntos.id_estudiante = estudiantes.id_usu
	INNER JOIN
	docentes
	ON 
		comentarios_asuntos.id_docente = docentes.id_usu
	INNER JOIN
	usuario AS usuario_docente
	ON 
		docentes.id_usu = usuario_docente.ID
	INNER JOIN
	usuario AS usuario_estudiante
	ON 
		estudiantes.id_usu = usuario_estudiante.ID
WHERE
	comentarios_asuntos.id_docente = IDUSU$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_ASUNTOS_ESTUDIANTE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_ASUNTOS_ESTUDIANTE` (IN `IDUSU` INT)   SELECT
	comentarios_asuntos.ID, 
	comentarios_asuntos.id_docente, 
	comentarios_asuntos.id_estudiante, 
	comentarios_asuntos.asunto, 
	comentarios_asuntos.comentario, 
	comentarios_asuntos.respuesta, 
	comentarios_asuntos.estado, 
	comentarios_asuntos.fecha, 
	CONCAT(estudiantes.nombre_estudiante, ' ', estudiantes.apellidos_estudiante) AS estudiante, 
	CONCAT(docentes.nombre_docente, ' ', docentes.apellidos_docente) AS docente, 
	usuario_docente.foto AS fotodocente,
	usuario_estudiante.foto AS fotoestudiante
FROM
	comentarios_asuntos
	INNER JOIN
	estudiantes
	ON 
		comentarios_asuntos.id_estudiante = estudiantes.id_usu
	INNER JOIN
	docentes
	ON 
		comentarios_asuntos.id_docente = docentes.id_usu
	INNER JOIN
	usuario AS usuario_docente
	ON 
		docentes.id_usu = usuario_docente.ID
	INNER JOIN
	usuario AS usuario_estudiante
	ON 
		estudiantes.id_usu = usuario_estudiante.ID
WHERE
	comentarios_asuntos.id_estudiante = IDUSU$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_CALIFICACIONES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_CALIFICACIONES` (IN `IDCURSO` INT, IN `IDGRADO` INT, IN `IDUSU` INT, IN `IDGROUP` INT, IN `IDDOC` INT)   SELECT
	detalles_calificaciones.ID, 
	CONCAT_WS(' ',estudiantes.nombre_estudiante,estudiantes.apellidos_estudiante) AS Estudiante, 
	detalles_calificaciones.nota_1 AS primera_nota, 
	detalles_calificaciones.nota_2 AS segunda_nota, 
	detalles_calificaciones.nota_3 AS tercera_nota, 
	detalles_calificaciones.nota_4 AS cuarta_nota, 
	detalles_calificaciones.nota_def, 
	calificaciones.id_estudiante, 
	CONCAT_WS(' ',docentes.nombre_docente, docentes.apellidos_docente) AS docente, 
	cursos.nombre, 
	grados.aula
FROM
	detalles_calificaciones
	INNER JOIN
	calificaciones
	ON 
		detalles_calificaciones.id_claificaciones = calificaciones.ID
	INNER JOIN
	estudiantes
	ON 
		calificaciones.id_estudiante = estudiantes.ID
	INNER JOIN
	deatlles_cursos
	ON 
		detalles_calificaciones.id_docente = deatlles_cursos.id_docente AND
		detalles_calificaciones.id_grupo = deatlles_cursos.ID
	INNER JOIN
	docentes
	ON 
		detalles_calificaciones.id_docente = docentes.ID
	INNER JOIN
	cursos
	ON 
		deatlles_cursos.id_curso = cursos.ID
	INNER JOIN
	grados
	ON 
		deatlles_cursos.id_aula = grados.ID

WHERE deatlles_cursos.id_curso = IDCURSO AND deatlles_cursos.id_aula = IDGRADO AND detalles_calificaciones.id_grupo = IDGROUP AND deatlles_cursos.id_docente = IDDOC AND docentes.id_usu = IDUSU$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_CARPETAS_MATERIALES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_CARPETAS_MATERIALES` (IN `IDUSUARIO` INT)   SELECT
material.ID,
	material.titulo
	
FROM
	material
	WHERE
	
	material.id_docente = IDUSUARIO$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_CHAT_DIRECTO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_CHAT_DIRECTO` (IN `IDCHAT` INT)   SELECT
    detalles_chat.ID,
    detalles_chat.Id_chat,
    detalles_chat.id_comentario, 
		CASE
        WHEN estudiantes.id_usu IS NOT NULL THEN CONCAT(estudiantes.nombre_estudiante, ' ', estudiantes.apellidos_estudiante)
        WHEN docentes.id_usu IS NOT NULL THEN CONCAT(docentes.nombre_docente, ' ', docentes.apellidos_docente)
        ELSE 'Nombre Desconocido'
    END AS nombre,
    usuario.foto, 
    detalles_chat.Comentario, 
    detalles_chat.Fecha, 
    detalles_chat.Estado,
	  detalles_chat.archivo
FROM
    detalles_chat
INNER JOIN
    usuario
ON 
    detalles_chat.id_comentario = usuario.ID
LEFT JOIN
    estudiantes
ON 
    estudiantes.id_usu = usuario.ID
LEFT JOIN
    docentes
ON 
    docentes.id_usu = usuario.ID
		
				WHERE detalles_chat.Id_chat = IDCHAT$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_CHAT_ESTUDIANTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_CHAT_ESTUDIANTES` (IN `IDUSUARIO` INT)   SELECT
    chat.ID,
    chat.id_principal AS id_principal,
    chat.id_segundario AS id_segundario,
    CONCAT(
        CASE
            WHEN estudiantes_principal.id_usu IS NOT NULL THEN CONCAT(estudiantes_principal.nombre_estudiante, ' ', estudiantes_principal.apellidos_estudiante)
            WHEN docentes_principal.id_usu IS NOT NULL THEN CONCAT(docentes_principal.nombre_docente, ' ', docentes_principal.apellidos_docente)
        END
    ) AS nombre_usuario_principal,
    CONCAT(
        CASE
            WHEN estudiantes_segundario.id_usu IS NOT NULL THEN CONCAT(estudiantes_segundario.nombre_estudiante, ' ', estudiantes_segundario.apellidos_estudiante)
            WHEN docentes_segundario.id_usu IS NOT NULL THEN CONCAT(docentes_segundario.nombre_docente, ' ', docentes_segundario.apellidos_docente)
        END
    ) AS nombre_usuario_secundario,
    usuario_principal.foto AS foto_usuario_principal,
    usuario_segundario.foto AS foto_usuario_secundario
FROM
    chat
LEFT JOIN
    docentes AS docentes_principal ON chat.id_principal = docentes_principal.id_usu
LEFT JOIN
    estudiantes AS estudiantes_principal ON chat.id_principal = estudiantes_principal.id_usu
LEFT JOIN
    docentes AS docentes_segundario ON chat.id_segundario = docentes_segundario.id_usu
LEFT JOIN
    estudiantes AS estudiantes_segundario ON chat.id_segundario = estudiantes_segundario.id_usu
LEFT JOIN
    usuario AS usuario_principal ON usuario_principal.ID = chat.id_principal
LEFT JOIN
    usuario AS usuario_segundario ON usuario_segundario.ID = chat.id_segundario
WHERE
    chat.id_principal = IDUSUARIO OR chat.id_segundario = IDUSUARIO$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_CHAT_INTEGRANTES_DOCENTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_CHAT_INTEGRANTES_DOCENTES` (IN `IDUSUARIO` INT)   SELECT
    CASE
        WHEN estudiantes.id_usu IS NOT NULL THEN CONCAT(estudiantes.nombre_estudiante, ' ', estudiantes.apellidos_estudiante)
        WHEN docentes.id_usu IS NOT NULL THEN CONCAT(docentes.nombre_docente, ' ', docentes.apellidos_docente)
        ELSE 'Nombre Desconocido'
    END AS nombre,
	usuario.foto AS foto_usuario, 
	usuario.ID AS id_usuario, 
	rol.rol_nombre
FROM
	usuario
	INNER JOIN
	rol
	ON 
		usuario.id_rol = rol.ID
	LEFT JOIN
	docentes
	ON 
		docentes.id_usu = usuario.ID
	LEFT JOIN
	estudiantes
	ON 
		estudiantes.id_usu = usuario.ID
	LEFT JOIN
	detalles_calificaciones
	ON 
		(
			estudiantes.ID = detalles_calificaciones.id_claificaciones OR
			docentes.ID = detalles_calificaciones.id_docente
		)
LEFT JOIN 
    docentes doc_validacion 
ON 
    doc_validacion.id_usu = IDUSUARIO
WHERE
	(detalles_calificaciones.id_claificaciones IS NOT NULL OR detalles_calificaciones.id_docente IS NOT NULL)
    AND (doc_validacion.id_usu IS NOT NULL OR estudiantes.id_usu IS NOT NULL)
GROUP BY
	usuario.ID
HAVING COUNT(doc_validacion.id_usu) > 0$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_CHAT_INTEGRANTES_ESTUDIANTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_CHAT_INTEGRANTES_ESTUDIANTES` (IN `IDUSUARIO` INT)   SELECT
    CASE
        WHEN estudiantes.id_usu IS NOT NULL THEN CONCAT(estudiantes.nombre_estudiante, ' ', estudiantes.apellidos_estudiante)
        WHEN docentes.id_usu IS NOT NULL THEN CONCAT(docentes.nombre_docente, ' ', docentes.apellidos_docente)
        ELSE 'Nombre Desconocido'
    END AS nombre,
	usuario.foto AS foto_usuario, 
	usuario.ID AS id_usuario, 
	rol.rol_nombre
FROM
	usuario
	INNER JOIN
	rol
	ON 
		usuario.id_rol = rol.ID
	LEFT JOIN
	docentes
	ON 
		docentes.id_usu = usuario.ID
	LEFT JOIN
	estudiantes
	ON 
		estudiantes.id_usu = usuario.ID
	LEFT JOIN
	detalles_calificaciones
	ON 
		(
			estudiantes.ID = detalles_calificaciones.id_claificaciones OR
			docentes.ID = detalles_calificaciones.id_docente
		)
LEFT JOIN 
    estudiantes est_validacion 
ON 
    est_validacion.id_usu = IDUSUARIO
WHERE
	(detalles_calificaciones.id_claificaciones IS NOT NULL OR detalles_calificaciones.id_docente IS NOT NULL)
    AND (est_validacion.id_usu IS NOT NULL OR docentes.id_usu IS NOT NULL)
GROUP BY
	usuario.ID
HAVING COUNT(est_validacion.id_usu) > 0$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_CHAT_NOTIFICACIONES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_CHAT_NOTIFICACIONES` (IN `IDUSUARIO` INT)   SELECT
    detalles_chat.id_comentario, 
    detalles_chat.Comentario, 
    detalles_chat.Fecha, 
    detalles_chat.Estado, 
    CASE
        WHEN estudiantes.id_usu IS NOT NULL THEN CONCAT(estudiantes.nombre_estudiante, ' ', estudiantes.apellidos_estudiante)
        WHEN docentes.id_usu IS NOT NULL THEN CONCAT(docentes.nombre_docente, ' ', docentes.apellidos_docente)
        ELSE 'Nombre Desconocido'
    END AS nombre,
    usuario.foto,
		detalles_chat.archivo
FROM
    chat
INNER JOIN
    detalles_chat ON chat.ID = detalles_chat.Id_chat
INNER JOIN
    usuario ON detalles_chat.id_comentario = usuario.ID
LEFT JOIN
    estudiantes ON usuario.ID = estudiantes.id_usu
LEFT JOIN
    docentes ON usuario.ID = docentes.id_usu
WHERE
    (chat.id_principal = IDUSUARIO OR chat.id_segundario = IDUSUARIO)
    AND detalles_chat.id_comentario != IDUSUARIO
    AND detalles_chat.Estado != 'VISTO'
ORDER BY
    detalles_chat.Fecha DESC$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_ASIGNATURAS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_ASIGNATURAS` ()   SELECT
cursos.ID,
cursos.nombre
FROM
cursos
WHERE `status` = 'ACTIVO'$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_CALIFICACIONES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_CALIFICACIONES` (IN `IDES` INT)   SELECT
calificaciones.ID
FROM
calificaciones
INNER JOIN estudiantes ON calificaciones.id_estudiante = estudiantes.ID

WHERE estudiantes.ID = IDES$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_CURSOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_CURSOS` ()   SELECT
cursos.ID,
cursos.nombre
FROM
cursos
WHERE `status` = 'ACTIVO'$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_CURSOS_DOCENTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_CURSOS_DOCENTES` ()   SELECT
    cursos.ID,
    cursos.nombre
FROM
    cursos
WHERE cursos.status = 'ACTIVO'
UNION

SELECT
    0 AS ID,
    'SIN ASIGNACIÓN' AS nombre$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_DOCENTE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_DOCENTE` ()   SELECT
docentes.ID,
CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) as docente
 
FROM
docentes
INNER JOIN usuario ON docentes.id_usu = usuario.ID

WHERE usuario.usu_estatus = 'ACTIVO'$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_DOCENTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_DOCENTES` (IN `IDDOC` INT)   SELECT
docentes.ID
FROM
docentes
INNER JOIN usuario ON docentes.id_usu = usuario.ID$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_DOCENTES_COMENTARIOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_DOCENTES_COMENTARIOS` (IN `IDUSU` INT)   SELECT DISTINCT
    CONCAT(docentes.nombre_docente, ' ', docentes.apellidos_docente) AS docente,
    docentes.id_usu
FROM
    detalles_calificaciones
INNER JOIN
    deatlles_cursos
ON 
    detalles_calificaciones.id_grupo = deatlles_cursos.ID AND
    detalles_calificaciones.id_docente = deatlles_cursos.id_docente
INNER JOIN
    docentes
ON 
    docentes.ID = deatlles_cursos.id_docente
INNER JOIN
    grados
ON 
    deatlles_cursos.id_aula = grados.ID
INNER JOIN
    estudiantes
ON 
    estudiantes.id_grado = grados.ID
WHERE
    estudiantes.id_usu = IDUSU$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_DOCENTE_VERIFITY`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_DOCENTE_VERIFITY` (IN `IDES` INT)   SELECT
	detalles_calificaciones.id_docente, 
	CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) AS Docente, 
	deatlles_cursos.ID, 
	docentes.id_usu
FROM
	detalles_calificaciones
	INNER JOIN
	docentes
	ON 
		detalles_calificaciones.id_docente = docentes.ID
	INNER JOIN
	calificaciones
	ON 
		detalles_calificaciones.id_claificaciones = calificaciones.ID
	INNER JOIN
	estudiantes
	ON 
		calificaciones.id_estudiante = estudiantes.ID
	INNER JOIN
	deatlles_cursos
	ON 
		deatlles_cursos.id_docente = docentes.ID
WHERE estudiantes.id_usu = IDES  OR docentes.id_usu = IDES LIMIT 1$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_DOCENTE_VERIFITY_CALIFICACIONES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_DOCENTE_VERIFITY_CALIFICACIONES` (IN `IDDOC` INT)   SELECT
detalles_calificaciones.id_docente,
CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) AS Docente,
docentes.id_usu
FROM
detalles_calificaciones
INNER JOIN docentes ON detalles_calificaciones.id_docente = docentes.ID
INNER JOIN calificaciones ON detalles_calificaciones.id_claificaciones = calificaciones.ID
INNER JOIN estudiantes ON calificaciones.id_estudiante = estudiantes.ID


WHERE docentes.id_usu = IDDOC$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_ESTUDIANTE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_ESTUDIANTE` (IN `IDASIG` INT, IN `IDA` INT, IN `IDDOC` INT)   SELECT
estudiantes.ID,
CONCAT_WS(' ',estudiantes.nombre_estudiante,estudiantes.apellidos_estudiante) AS Estudiante
 
FROM
estudiantes
INNER JOIN grados ON estudiantes.id_grado = grados.ID
INNER JOIN deatlles_cursos ON deatlles_cursos.id_aula = grados.ID
INNER JOIN cursos ON deatlles_cursos.id_curso = cursos.ID$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_ESTUDIANTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_ESTUDIANTES` (IN `IDCURSO` INT, IN `IDGRADO` INT, IN `IDUSU` INT)   SELECT
estudiantes.ID,
CONCAT_WS(' ',estudiantes.nombre_estudiante,estudiantes.apellidos_estudiante) as Estudiante
 
FROM
estudiantes
INNER JOIN grados ON estudiantes.id_grado = grados.ID
INNER JOIN deatlles_cursos ON deatlles_cursos.id_aula = grados.ID
INNER JOIN calificaciones ON calificaciones.id_estudiante = estudiantes.ID
INNER JOIN docentes ON deatlles_cursos.id_docente = docentes.ID

WHERE docentes.id_usu = IDUSU AND deatlles_cursos.id_aula = IDGRADO AND deatlles_cursos.id_curso = IDCURSO$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_ESTUDIANTE_VERIFITY`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_ESTUDIANTE_VERIFITY` (IN `IDES` INT)   SELECT
	calificaciones.id_estudiante, 
	estudiantes.id_usu
FROM
	calificaciones
	INNER JOIN
	estudiantes
	ON 
		calificaciones.id_estudiante = estudiantes.ID
WHERE
	estudiantes.id_usu = IDES$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_GRADO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_GRADO` ()   SELECT
grados.ID,
grados.aula
FROM
grados

WHERE `status`= 'ACTIVO'$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_GRADOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_GRADOS` (IN `IDUSO` INT, IN `IDGROUP` INT)   SELECT
deatlles_cursos.id_aula,
grados.aula
FROM
deatlles_cursos
INNER JOIN docentes ON deatlles_cursos.id_docente = docentes.ID
INNER JOIN usuario ON docentes.id_usu = usuario.ID
INNER JOIN grados ON deatlles_cursos.id_aula = grados.ID AND deatlles_cursos.ID = IDGROUP$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_GRADO_DOCENTE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_GRADO_DOCENTE` ()   SELECT
    ID,
    aula
FROM (
    SELECT
        0 AS ID,
        'SIN ASIGNACIÓN' AS aula,
        0 AS orden
    UNION
    SELECT
        grados.ID,
        grados.aula,
        1 AS orden
    FROM
        grados
    WHERE
        `status` = 'ACTIVO'
) AS listado
ORDER BY
    orden, ID$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_GRUPO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_GRUPO` (IN `USU` INT, IN `IDASIG` INT)   SELECT
deatlles_cursos.id_curso,
cursos.nombre
FROM
deatlles_cursos
INNER JOIN cursos ON deatlles_cursos.id_curso = cursos.ID
INNER JOIN docentes ON deatlles_cursos.id_docente = docentes.ID
INNER JOIN usuario ON docentes.id_usu = usuario.ID

WHERE  docentes.id_usu =  USU AND deatlles_cursos.ID = IDASIG$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_GRUPOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_GRUPOS` (IN `USU` INT)   SELECT
deatlles_cursos.ID,
cursos.nombre,
grados.aula
FROM
deatlles_cursos
INNER JOIN cursos ON deatlles_cursos.id_curso = cursos.ID
INNER JOIN grados ON deatlles_cursos.id_aula = grados.ID
INNER JOIN docentes ON deatlles_cursos.id_docente = docentes.ID
INNER JOIN usuario ON docentes.id_usu = usuario.ID

WHERE  deatlles_cursos.id_docente =  USU$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_MATERIA`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_MATERIA` (IN `IDES` INT)   SELECT
deatlles_cursos.ID,
cursos.nombre,
CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) AS Docente,
grados.aula,
docentes.ID AS ID_DOC, 
docentes.id_usu
FROM
deatlles_cursos
INNER JOIN cursos ON deatlles_cursos.id_curso = cursos.ID
INNER JOIN docentes ON deatlles_cursos.id_docente = docentes.ID
INNER JOIN grados ON deatlles_cursos.id_aula = grados.ID
INNER JOIN estudiantes ON estudiantes.id_grado = deatlles_cursos.id_aula

WHERE estudiantes.id_usu = IDES  AND cursos.`status` = 'ACTIVO'$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_MIS_GRUPOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_MIS_GRUPOS` (IN `IDDOC` INT)   SELECT
deatlles_cursos.ID,
cursos.nombre,
grados.aula
FROM
deatlles_cursos
INNER JOIN cursos ON deatlles_cursos.id_curso = cursos.ID
INNER JOIN grados ON deatlles_cursos.id_aula = grados.ID
INNER JOIN docentes ON deatlles_cursos.id_docente = docentes.ID

WHERE docentes.id_usu = IDDOC$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_ROL`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_ROL` ()   SELECT DISTINCT
    rol.ID, 
    rol.rol_nombre
FROM
    rol$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMBO_TALLER_VERIFITY`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMBO_TALLER_VERIFITY` (IN `IDUSU` INT, IN `IDGROUP` INT)   SELECT
talleres.ID
FROM
talleres
INNER JOIN docentes ON talleres.id_docente = docentes.ID

WHERE docentes.id_usu = IDUSU AND talleres.id_grupo = IDGROUP$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_COMENTARIOS_ESTUDIANTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_COMENTARIOS_ESTUDIANTES` (IN `IDDOC` INT, IN `IDDES` INT)   SELECT
comentarios.ID,
talleres.titulo,
CONCAT_WS(' ',estudiantes.nombre_estudiante,estudiantes.apellidos_estudiante) as estudiantes,
comentarios.comentarios,
comentarios.respuesta,
comentarios.`status` as Estado,
comentarios.fecha
FROM
comentarios
INNER JOIN talleres ON comentarios.id_taller = talleres.ID
INNER JOIN estudiantes ON comentarios.id_estudiante = estudiantes.id_usu
INNER JOIN deatlles_cursos ON talleres.id_grupo = deatlles_cursos.ID
INNER JOIN cursos ON deatlles_cursos.id_curso = cursos.ID
INNER JOIN grados ON estudiantes.id_grado = grados.ID
INNER JOIN docentes ON talleres.id_docente = docentes.ID AND deatlles_cursos.id_docente = docentes.ID


WHERE deatlles_cursos.id_docente = IDDOC AND docentes.id_usu = IDDES$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_CURSOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_CURSOS` ()   SELECT
    ID,
    nombre,
    `status`
FROM
    cursos
WHERE
    ID != 0$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_DATOS_DOCENTE_MATERIALES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_DATOS_DOCENTE_MATERIALES` (IN `IDUSUARIO` INT)   SELECT
	cursos.nombre, 
    CONCAT(docentes.nombre_docente, ' ', docentes.apellidos_docente) AS docente,
	usuario.foto
FROM
	cursos
	INNER JOIN
	deatlles_cursos
	ON 
		cursos.ID = deatlles_cursos.id_curso
	INNER JOIN
	docentes
	ON 
		docentes.ID = deatlles_cursos.id_docente
	INNER JOIN
	usuario
	ON 
		docentes.id_usu = usuario.ID
		WHERE
		docentes.id_usu = IDUSUARIO$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_DETALLES_ASISTENCIAS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_DETALLES_ASISTENCIAS` (IN `IDCURSO` INT, IN `IDGRADO` INT, IN `IDUSU` INT, IN `IDES` DATE)   SELECT
    estudiantes.ID,
    asistencias.ID AS id_asistencia,
    CONCAT_WS(' ', estudiantes.nombre_estudiante, estudiantes.apellidos_estudiante) AS Estudiante,
    detalles_sistencias.asistencia,
    detalles_sistencias.dia,
    detalles_sistencias.fecha,
    SUM(CASE WHEN detalles_sistencias.asistencia = 'NO ASISTIÓ' THEN 1 ELSE 0 END) AS Total_No_Asistencias
FROM
    detalles_sistencias
INNER JOIN asistencias ON detalles_sistencias.id_asistencia = asistencias.ID
INNER JOIN deatlles_cursos ON detalles_sistencias.id_docente = deatlles_cursos.id_docente AND asistencias.id_grupo = deatlles_cursos.ID
INNER JOIN estudiantes ON asistencias.id_estudiante = estudiantes.ID
INNER JOIN docentes ON deatlles_cursos.id_docente = docentes.ID
WHERE
    detalles_sistencias.fecha = IDES
    AND docentes.id_usu = IDUSU
    AND deatlles_cursos.id_aula = IDGRADO
    AND deatlles_cursos.id_curso = IDCURSO
GROUP BY
    estudiantes.ID,
    asistencias.ID,
    Estudiante,
    detalles_sistencias.asistencia,
    detalles_sistencias.dia,
    detalles_sistencias.fecha$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_DETALLES_ASISTENCIAS_ESTUDIANTE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_DETALLES_ASISTENCIAS_ESTUDIANTE` (IN `IDES` INT, IN `IDCURSO` INT)   SELECT
estudiantes.ID,
asistencias.ID as id_asistencia,
CONCAT_WS(' ',estudiantes.nombre_estudiante,estudiantes.apellidos_estudiante) AS Estudiante,
detalles_sistencias.asistencia,
detalles_sistencias.dia,
detalles_sistencias.fecha
FROM
detalles_sistencias
INNER JOIN asistencias ON detalles_sistencias.id_asistencia = asistencias.ID
INNER JOIN deatlles_cursos ON detalles_sistencias.id_docente = deatlles_cursos.id_docente AND asistencias.id_grupo = deatlles_cursos.ID
INNER JOIN estudiantes ON asistencias.id_estudiante = estudiantes.ID
INNER JOIN
	docentes
	ON 
		deatlles_cursos.id_docente = docentes.ID


WHERE asistencias.id_estudiante = IDES AND deatlles_cursos.id_curso = IDCURSO$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_DETALLES_CURSOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_DETALLES_CURSOS` ()   BEGIN
DECLARE CANTIDAD int;
SET @CANTIDAD:=0;
SELECT
@CANTIDAD:=@CANTIDAD+1 AS Posicion,
deatlles_cursos.ID,
grados.aula,
CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) as docente,
cursos.nombre,
deatlles_cursos.fecha_asignacion,
cursos.`status`,
deatlles_cursos.id_aula,
deatlles_cursos.id_curso,
deatlles_cursos.id_docente

FROM
deatlles_cursos
INNER JOIN docentes ON deatlles_cursos.id_docente = docentes.ID
INNER JOIN cursos ON deatlles_cursos.id_curso = cursos.ID
INNER JOIN grados ON deatlles_cursos.id_aula = grados.ID;

END$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_DOCENTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_DOCENTES` ()   SELECT
docentes.ID,
CONCAT_WS(' ',nombre_docente,apellidos_docente) AS docente,
docentes.nombre_docente,
docentes.apellidos_docente,
docentes.fecha_nacimiento,
docentes.telefono,
docentes.nm_documento,
docentes.ID,
usuario.usu_sexo,
usuario.usu_estatus,
usuario.usu_email,
usuario.usu_nombre,
usuario.ID as id_usu
FROM
docentes
INNER JOIN usuario ON docentes.id_usu = usuario.ID$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_DOCENTES_COMENTARIOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_DOCENTES_COMENTARIOS` (IN `IDDOC` INT, IN `IDDES` INT)   SELECT
comentarios.ID,
talleres.titulo,
CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) AS Docente,
comentarios.comentarios,
comentarios.respuesta,
comentarios.`status` as Estado,
comentarios.fecha
FROM
comentarios
INNER JOIN talleres ON comentarios.id_taller = talleres.ID
INNER JOIN estudiantes ON comentarios.id_estudiante = estudiantes.ID
INNER JOIN deatlles_cursos ON talleres.id_grupo = deatlles_cursos.ID
INNER JOIN cursos ON deatlles_cursos.id_curso = cursos.ID
INNER JOIN grados ON estudiantes.id_grado = grados.ID
INNER JOIN docentes ON talleres.id_docente = docentes.ID AND deatlles_cursos.id_docente = docentes.ID

WHERE estudiantes.ID = IDDOC$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_ESTUDIANTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_ESTUDIANTES` ()   SELECT
	estudiantes.ID, 
	estudiantes.nombre_estudiante, 
	estudiantes.apellidos_estudiante,
	CONCAT(' ',nombre_estudiante,' ',apellidos_estudiante) AS estudiante, 
	estudiantes.telefono, 
	estudiantes.nm_documento, 
	estudiantes.fecha_nacimiento, 
	grados.aula,
	usuario.ID as id_usu,
	usuario.usu_email,
	usuario.usu_nombre,
	usuario.usu_estatus,
	usuario.usu_sexo,
	grados.ID as id_grado
	FROM
	estudiantes
	INNER JOIN
	grados
	ON 
	estudiantes.id_grado = grados.ID
	INNER JOIN
	usuario
	ON
	estudiantes.id_usu = usuario.ID$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_ESTUDIANTE_COMENTARIOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_ESTUDIANTE_COMENTARIOS` (IN `IDGROUP` INT, IN `IDDOC` INT, IN `IDDES` INT)   SELECT
    comentarios.ID, 
    talleres.titulo, 
		  CONCAT_WS(' ', docentes.nombre_docente, docentes.apellidos_docente) AS docentes,

    comentarios.comentarios, 
    comentarios.respuesta, 
    comentarios.`status` AS Estado, 
    comentarios.fecha, 
		
	    CONCAT_WS(' ', estudiantes.nombre_estudiante, estudiantes.apellidos_estudiante) AS alumnos, 
    usuario_docente.foto AS fotodocente,
    usuario_estudiante.foto AS fotoestudiante
FROM
    comentarios
INNER JOIN
    talleres ON comentarios.id_taller = talleres.ID
INNER JOIN
    estudiantes ON comentarios.id_estudiante = estudiantes.id_usu
INNER JOIN
    deatlles_cursos ON talleres.id_grupo = deatlles_cursos.ID
INNER JOIN
    cursos ON deatlles_cursos.id_curso = cursos.ID
INNER JOIN
    grados ON estudiantes.id_grado = grados.ID
INNER JOIN
    docentes ON talleres.id_docente = docentes.ID AND deatlles_cursos.id_docente = docentes.ID
INNER JOIN
    usuario AS usuario_docente ON docentes.id_usu = usuario_docente.ID
INNER JOIN
    usuario AS usuario_estudiante ON estudiantes.id_usu = usuario_estudiante.ID
WHERE deatlles_cursos.ID = IDGROUP AND deatlles_cursos.id_docente = IDDOC AND estudiantes.id_usu = IDDES$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_FECHA_ASISTENCIAS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_FECHA_ASISTENCIAS` ()   SELECT
asistencias.fecha
FROM
asistencias
LIMIT 1$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_FORO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_FORO` (IN `IDGRUP` INT, IN `IDCUR` INT, IN `IDDOC` INT)   SELECT
	foro.ID, 
		foro.id_docente, 
	foro.id_grupo, 
	foro.titulo, 
	foro.descripcion, 
	foro.foro_estado, 
	foro.fecha, 
	CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) AS nombre, 
	 DATE_FORMAT(foro.fecha_foro, '%Y-%m-%d %h:%i:%s %p') AS fecha_foro,

	usuario.foto,
	 (
        SELECT 
            COUNT(*) 
        FROM 
            detalles_foro 
        WHERE 
            detalles_foro.id_grupo = IDGRUP
    ) AS comentarios
FROM
	foro
	INNER JOIN
	deatlles_cursos
	ON 
		foro.id_grupo = deatlles_cursos.ID
	INNER JOIN
	docentes
	ON 
		deatlles_cursos.id_docente = docentes.ID
	INNER JOIN
	usuario
	ON 
		docentes.id_usu = usuario.ID
WHERE
	deatlles_cursos.ID = IDGRUP AND
	deatlles_cursos.id_aula = IDCUR AND
	docentes.id_usu = IDDOC$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_FORO_COMENTARIOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_FORO_COMENTARIOS` (IN `IDGRUP` INT, IN `IDFOR` INT)   SELECT
    foro.ID, 
    detalles_foro.id_foro, 
    detalles_foro.id_grupo, 
    usuario.foto, 
    detalles_foro.comentario, 
    detalles_foro.fecha, 
    detalles_foro.id_comentario, 
    CASE
        WHEN estudiantes.id_usu IS NOT NULL THEN CONCAT(estudiantes.nombre_estudiante, ' ', estudiantes.apellidos_estudiante)
        WHEN docentes.id_usu IS NOT NULL THEN CONCAT(docentes.nombre_docente, ' ', docentes.apellidos_docente)
        ELSE 'Nombre Desconocido'
    END AS nombre,
		(
        SELECT 
            COUNT(*) 
        FROM 
            detalles_foro 
        WHERE 
            detalles_foro.id_foro = IDFOR
    ) AS comentarios,
		detalles_foro.ID AS id_comentario_us
FROM
    foro
INNER JOIN
    detalles_foro
ON 
    foro.ID = detalles_foro.id_foro
INNER JOIN
    usuario
ON 
    detalles_foro.id_comentario = usuario.ID
LEFT JOIN
    estudiantes
ON 
    estudiantes.id_usu = usuario.ID
LEFT JOIN
    docentes
ON 
     docentes.id_usu = usuario.ID 
WHERE
    detalles_foro.id_grupo = IDGRUP AND
		detalles_foro.id_foro = IDFOR$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_FORO_COMENTARIOS_RESPUESTAS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_FORO_COMENTARIOS_RESPUESTAS` (IN `IDFOR` INT, IN `IDPRINCIPAL` INT)   SELECT
	CASE
		WHEN estudiante.id_usu IS NOT NULL THEN CONCAT(estudiante.nombre_estudiante, ' ', estudiante.apellidos_estudiante)
		WHEN docente.id_usu IS NOT NULL THEN CONCAT(docente.nombre_docente, ' ', docente.apellidos_docente)
		ELSE 'Nombre Desconocido'
	END AS nombre,
	
	CASE
		WHEN responde_estudiante.id_usu IS NOT NULL THEN CONCAT(responde_estudiante.nombre_estudiante, ' ', responde_estudiante.apellidos_estudiante)
		WHEN responde_docente.id_usu IS NOT NULL THEN CONCAT(responde_docente.nombre_docente, ' ', responde_docente.apellidos_docente)
		ELSE 'Nombre Desconocido'
	END AS responde_a,
	
	detalles_foro_respuesta.comentario_respuesta, 
	usuario.foto, 
	detalles_foro_respuesta.fecha_respuesta, 
	detalles_foro_respuesta.id_foro, 
	detalles_foro_respuesta.id_comentario_principal, 
	detalles_foro_respuesta.id_respuesta, 
	detalles_foro_respuesta.ID AS id_comentario_us,
	detalles_foro_respuesta.id_responde_a AS reponde_a_id
FROM
	detalles_foro_respuesta
	INNER JOIN usuario
		ON detalles_foro_respuesta.id_respuesta = usuario.ID
	LEFT JOIN estudiantes AS estudiante
		ON usuario.ID = estudiante.id_usu
	LEFT JOIN docentes AS docente
		ON usuario.ID = docente.id_usu
	LEFT JOIN usuario AS responde_usuario
		ON detalles_foro_respuesta.id_responde_a = responde_usuario.ID
	LEFT JOIN estudiantes AS responde_estudiante
		ON responde_usuario.ID = responde_estudiante.id_usu
	LEFT JOIN docentes AS responde_docente
		ON responde_usuario.ID = responde_docente.id_usu
	INNER JOIN foro
		ON detalles_foro_respuesta.id_foro = foro.ID
WHERE
		detalles_foro_respuesta.id_foro = IDFOR AND
	detalles_foro_respuesta.id_comentario_principal = IDPRINCIPAL$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_GRABACIONES_CLASES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_GRABACIONES_CLASES` (IN `IDGROUP` INT, IN `IDUSU` INT)   SELECT
	grabaciones.ID, 
	grabaciones.fecha, 
	grabaciones.titulo, 
	grabaciones.detalles, 
	grabaciones.url AS video, 
	CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) AS docente, 
	cursos.nombre AS Materia, 
	grados.aula AS grado, 
	deatlles_cursos.ID AS id_grupo, 
	usuario.foto
FROM
	grabaciones
	INNER JOIN
	deatlles_cursos
	ON 
		grabaciones.id_grupo = deatlles_cursos.ID
	INNER JOIN
	grados
	ON 
		deatlles_cursos.id_aula = grados.ID
	INNER JOIN
	cursos
	ON 
		deatlles_cursos.id_curso = cursos.ID
	INNER JOIN
	docentes
	ON 
		deatlles_cursos.id_docente = docentes.ID
	INNER JOIN
	estudiantes
	ON 
		estudiantes.id_grado = grados.ID
	INNER JOIN
	usuario
	ON 
		docentes.id_usu = usuario.ID


WHERE deatlles_cursos.ID = IDGROUP AND estudiantes.id_usu = IDUSU$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_GRUPO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_GRUPO` (IN `IDCURSO` INT, IN `IDGRADO` INT, IN `IDUSU` INT)   SELECT
	estudiantes.ID, 
	CONCAT_WS(' ',estudiantes.nombre_estudiante,estudiantes.apellidos_estudiante) AS Estudiante, 
	grados.aula, 
	cursos.nombre, 
	usuario.foto
FROM
	detalles_calificaciones
	INNER JOIN
	estudiantes
	ON 
		detalles_calificaciones.id_claificaciones = estudiantes.ID
	INNER JOIN
	deatlles_cursos
	ON 
		detalles_calificaciones.id_grupo = deatlles_cursos.ID
	INNER JOIN
	cursos
	ON 
		deatlles_cursos.id_curso = cursos.ID
	INNER JOIN
	grados
	ON 
		estudiantes.id_grado = grados.ID
	INNER JOIN
	usuario
	ON 
		estudiantes.id_usu = usuario.ID
	INNER JOIN
	docentes
	ON 
		deatlles_cursos.id_docente = docentes.ID
WHERE
	deatlles_cursos.id_curso = IDCURSO AND
	deatlles_cursos.id_aula = IDGRADO AND
	docentes.id_usu = IDUSU$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_GRUPO_ESTUDIANTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_GRUPO_ESTUDIANTES` (IN `IDCURSO` INT, IN `IDGRADO` INT, IN `IDUSU` INT)   SELECT
    estudiantes.ID, 
    CONCAT_WS(' ', estudiantes.nombre_estudiante, estudiantes.apellidos_estudiante) AS Estudiante, 
    grados.aula, 
    cursos.nombre, 
    CONCAT_WS(' ', docentes.nombre_docente, docentes.apellidos_docente) AS Docente, 
    usuario_estudiante.foto AS FotoEstudiante,
   
    usuario_docente.foto AS FotoDocente
FROM
    detalles_calificaciones
INNER JOIN
    estudiantes
ON 
    detalles_calificaciones.id_claificaciones = estudiantes.ID
INNER JOIN
    deatlles_cursos
ON 
    detalles_calificaciones.id_grupo = deatlles_cursos.id_curso
INNER JOIN
    grados
ON 
    estudiantes.id_grado = grados.ID
INNER JOIN
    docentes
ON 
    detalles_calificaciones.id_docente = docentes.ID
INNER JOIN
    cursos
ON 
    deatlles_cursos.id_curso = cursos.ID
INNER JOIN
    usuario AS usuario_estudiante
ON 
    estudiantes.id_usu = usuario_estudiante.ID
INNER JOIN
    usuario AS usuario_docente
ON 
    docentes.id_usu = usuario_docente.ID
WHERE
    detalles_calificaciones.id_grupo = IDCURSO AND
    deatlles_cursos.id_aula = IDGRADO AND
    deatlles_cursos.id_docente = IDUSU$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_GRUPO_ESTUDIANTES2`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_GRUPO_ESTUDIANTES2` (IN `IDCURSO` INT, IN `IDGRADO` INT)   SELECT
    estudiantes.ID, 
    CONCAT_WS(' ', estudiantes.nombre_estudiante, estudiantes.apellidos_estudiante) AS Estudiante, 
    grados.aula, 
    cursos.nombre, 
    CONCAT_WS(' ', docentes.nombre_docente, docentes.apellidos_docente) AS Docente, 
    usuario.foto AS FotoEstudiante, 
    usuario_docente.foto AS FotoDocente
FROM
    deatlles_cursos
    INNER JOIN
    detalles_calificaciones
    ON 
        deatlles_cursos.ID = detalles_calificaciones.id_grupo
    INNER JOIN
    docentes
    ON 
        deatlles_cursos.id_docente = docentes.ID
    INNER JOIN
    estudiantes
    ON 
        detalles_calificaciones.id_claificaciones = estudiantes.ID
    INNER JOIN
    grados
    ON 
        deatlles_cursos.id_aula = grados.ID
    INNER JOIN
    cursos
    ON 
        deatlles_cursos.id_curso = cursos.ID
    INNER JOIN
    usuario
    ON 
        estudiantes.id_usu = usuario.ID
    INNER JOIN
    usuario AS usuario_docente
    ON 
        docentes.id_usu = usuario_docente.ID
WHERE
    deatlles_cursos.ID = IDCURSO AND
    deatlles_cursos.id_aula = IDGRADO$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_GRUPO_VERIFICAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_GRUPO_VERIFICAR` (IN `IDGROUP` INT)   SELECT
deatlles_cursos.ID,
deatlles_cursos.id_curso,
deatlles_cursos.id_docente,
deatlles_cursos.id_aula
FROM
deatlles_cursos

WHERE deatlles_cursos.ID =  IDGROUP$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_HORARIOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_HORARIOS` ()   SELECT
	horarios.ID, 
	grados.aula, 
	horarios.bloque_1, 
	horarios.bloque_2, 
	horarios.bloque_3, 
	horarios.bloque_4, 
	horarios.bloque_5, 
	horarios.bloque_6, 
	lunes_1.nombre AS lunes_1, 
	lunes_2.nombre AS lunes_2, 
	lunes_3.nombre AS lunes_3, 
	lunes_4.nombre AS lunes_4, 
	lunes_5.nombre AS lunes_5, 
	lunes_6.nombre AS lunes_6, 
	martes_1.nombre AS martes_1, 
	martes_2.nombre AS martes_2, 
	martes_3.nombre AS martes_3, 
	martes_4.nombre AS martes_4, 
	martes_5.nombre AS martes_5, 
	martes_6.nombre AS martes_6, 
	miercoles_1.nombre AS miercoles_1, 
	miercoles_2.nombre AS miercoles_2, 
	miercoles_3.nombre AS miercoles_3, 
	miercoles_4.nombre AS miercoles_4, 
	miercoles_5.nombre AS miercoles_5, 
	miercoles_6.nombre AS miercoles_6, 
	jueves_1.nombre AS jueves_1, 
	jueves_2.nombre AS jueves_2, 
	jueves_3.nombre AS jueves_3, 
	jueves_4.nombre AS jueves_4, 
	jueves_5.nombre AS jueves_5, 
	jueves_6.nombre AS jueves_6, 
	viernes_1.nombre AS viernes_1, 
	viernes_2.nombre AS viernes_2, 
	viernes_3.nombre AS viernes_3, 
	viernes_4.nombre AS viernes_4, 
	viernes_5.nombre AS viernes_5, 
	viernes_6.nombre AS viernes_6, 
	grados.ID AS id_grado, 
 lunes_1.ID AS id_lunes_1,
    lunes_2.ID AS id_lunes_2,
    lunes_3.ID AS id_lunes_3,
    lunes_4.ID AS id_lunes_4,
    lunes_5.ID AS id_lunes_5,
    lunes_6.ID AS id_lunes_6,
    martes_1.ID AS id_martes_1,
    martes_2.ID AS id_martes_2,
    martes_3.ID AS id_martes_3,
    martes_4.ID AS id_martes_4,
    martes_5.ID AS id_martes_5,
    martes_6.ID AS id_martes_6,
    miercoles_1.ID AS id_miercoles_1,
    miercoles_2.ID AS id_miercoles_2,
    miercoles_3.ID AS id_miercoles_3,
    miercoles_4.ID AS id_miercoles_4,
    miercoles_5.ID AS id_miercoles_5,
    miercoles_6.ID AS id_miercoles_6,
    jueves_1.ID AS id_jueves_1,
    jueves_2.ID AS id_jueves_2,
    jueves_3.ID AS id_jueves_3,
    jueves_4.ID AS id_jueves_4,
    jueves_5.ID AS id_jueves_5,
    jueves_6.ID AS id_jueves_6,
    viernes_1.ID AS id_viernes_1,
    viernes_2.ID AS id_viernes_2,
    viernes_3.ID AS id_viernes_3,
    viernes_4.ID AS id_viernes_4,
    viernes_5.ID AS id_viernes_5,
    viernes_6.ID AS id_viernes_6
FROM
	horarios
	INNER JOIN
	cursos AS lunes_1
	ON 
		horarios.lunes_1 = lunes_1.ID
	INNER JOIN
	cursos AS lunes_2
	ON 
		horarios.lunes_2 = lunes_2.ID
	INNER JOIN
	cursos AS lunes_3
	ON 
		horarios.lunes_3 = lunes_3.ID
	INNER JOIN
	cursos AS lunes_4
	ON 
		horarios.lunes_4 = lunes_4.ID
	INNER JOIN
	cursos AS lunes_5
	ON 
		horarios.lunes_5 = lunes_5.ID
	INNER JOIN
	cursos AS lunes_6
	ON 
		horarios.lunes_6 = lunes_6.ID
	INNER JOIN
	cursos AS martes_1
	ON 
		horarios.martes_1 = martes_1.ID
	INNER JOIN
	cursos AS martes_2
	ON 
		horarios.martes_2 = martes_2.ID
	INNER JOIN
	cursos AS martes_3
	ON 
		horarios.martes_3 = martes_3.ID
	INNER JOIN
	cursos AS martes_4
	ON 
		horarios.martes_4 = martes_4.ID
	INNER JOIN
	cursos AS martes_5
	ON 
		horarios.martes_5 = martes_5.ID
	INNER JOIN
	cursos AS martes_6
	ON 
		horarios.martes_6 = martes_6.ID
	INNER JOIN
	cursos AS miercoles_1
	ON 
		horarios.miercoles_1 = miercoles_1.ID
	INNER JOIN
	cursos AS miercoles_2
	ON 
		horarios.miercoles_2 = miercoles_2.ID
	INNER JOIN
	cursos AS miercoles_3
	ON 
		horarios.miercoles_3 = miercoles_3.ID
	INNER JOIN
	cursos AS miercoles_4
	ON 
		horarios.miercoles_4 = miercoles_4.ID
	INNER JOIN
	cursos AS miercoles_5
	ON 
		horarios.miercoles_5 = miercoles_5.ID
	INNER JOIN
	cursos AS miercoles_6
	ON 
		horarios.miercoles_6 = miercoles_6.ID
	INNER JOIN
	cursos AS jueves_1
	ON 
		horarios.jueves_1 = jueves_1.ID
	INNER JOIN
	cursos AS jueves_2
	ON 
		horarios.jueves_2 = jueves_2.ID
	INNER JOIN
	cursos AS jueves_3
	ON 
		horarios.jueves_3 = jueves_3.ID
	INNER JOIN
	cursos AS jueves_4
	ON 
		horarios.jueves_4 = jueves_4.ID
	INNER JOIN
	cursos AS jueves_5
	ON 
		horarios.jueves_5 = jueves_5.ID
	INNER JOIN
	cursos AS jueves_6
	ON 
		horarios.jueves_6 = jueves_6.ID
	INNER JOIN
	cursos AS viernes_1
	ON 
		horarios.viernes_1 = viernes_1.ID
	INNER JOIN
	cursos AS viernes_2
	ON 
		horarios.viernes_2 = viernes_2.ID
	INNER JOIN
	cursos AS viernes_3
	ON 
		horarios.viernes_3 = viernes_3.ID
	INNER JOIN
	cursos AS viernes_4
	ON 
		horarios.viernes_4 = viernes_4.ID
	INNER JOIN
	cursos AS viernes_5
	ON 
		horarios.viernes_5 = viernes_5.ID
	INNER JOIN
	cursos AS viernes_6
	ON 
		horarios.viernes_6 = viernes_6.ID
	INNER JOIN
	grados
	ON 
		horarios.id_curso = grados.ID$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_HORARIOS_DOCENTE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_HORARIOS_DOCENTE` ()   SELECT
	CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) AS docente,
	horarios_docentes.*
FROM
	horarios_docentes
	INNER JOIN
	docentes
	ON 
		horarios_docentes.id_docente = docentes.id_usu$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_HORARIO_DOCENTE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_HORARIO_DOCENTE` (IN `IDUSUARIO` INT)   SELECT
	horarios_docentes.*, 
CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) AS docente
FROM
	docentes
	INNER JOIN
	horarios_docentes
	ON 
		docentes.id_usu = horarios_docentes.id_docente
				WHERE
	docentes.id_usu = IDUSUARIO$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_HORARIO_ESTUDIANTE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_HORARIO_ESTUDIANTE` (IN `IDUSUARIO` INT)   SELECT
	horarios.ID, 
	grados.aula, 
	horarios.bloque_1, 
	horarios.bloque_2, 
	horarios.bloque_3, 
	horarios.bloque_4, 
	horarios.bloque_5, 
	horarios.bloque_6, 
	lunes_1.nombre AS lunes_1, 
	lunes_2.nombre AS lunes_2, 
	lunes_3.nombre AS lunes_3, 
	lunes_4.nombre AS lunes_4, 
	lunes_5.nombre AS lunes_5, 
	lunes_6.nombre AS lunes_6, 
	martes_1.nombre AS martes_1, 
	martes_2.nombre AS martes_2, 
	martes_3.nombre AS martes_3, 
	martes_4.nombre AS martes_4, 
	martes_5.nombre AS martes_5, 
	martes_6.nombre AS martes_6, 
	miercoles_1.nombre AS miercoles_1, 
	miercoles_2.nombre AS miercoles_2, 
	miercoles_3.nombre AS miercoles_3, 
	miercoles_4.nombre AS miercoles_4, 
	miercoles_5.nombre AS miercoles_5, 
	miercoles_6.nombre AS miercoles_6, 
	jueves_1.nombre AS jueves_1, 
	jueves_2.nombre AS jueves_2, 
	jueves_3.nombre AS jueves_3, 
	jueves_4.nombre AS jueves_4, 
	jueves_5.nombre AS jueves_5, 
	jueves_6.nombre AS jueves_6, 
	viernes_1.nombre AS viernes_1, 
	viernes_2.nombre AS viernes_2, 
	viernes_3.nombre AS viernes_3, 
	viernes_4.nombre AS viernes_4, 
	viernes_5.nombre AS viernes_5, 
	viernes_6.nombre AS viernes_6
FROM
	horarios
	INNER JOIN
	cursos AS lunes_1
	ON 
		horarios.lunes_1 = lunes_1.ID
	INNER JOIN
	cursos AS lunes_2
	ON 
		horarios.lunes_2 = lunes_2.ID
	INNER JOIN
	cursos AS lunes_3
	ON 
		horarios.lunes_3 = lunes_3.ID
	INNER JOIN
	cursos AS lunes_4
	ON 
		horarios.lunes_4 = lunes_4.ID
	INNER JOIN
	cursos AS lunes_5
	ON 
		horarios.lunes_5 = lunes_5.ID
	INNER JOIN
	cursos AS lunes_6
	ON 
		horarios.lunes_6 = lunes_6.ID
	INNER JOIN
	cursos AS martes_1
	ON 
		horarios.martes_1 = martes_1.ID
	INNER JOIN
	cursos AS martes_2
	ON 
		horarios.martes_2 = martes_2.ID
	INNER JOIN
	cursos AS martes_3
	ON 
		horarios.martes_3 = martes_3.ID
	INNER JOIN
	cursos AS martes_4
	ON 
		horarios.martes_4 = martes_4.ID
	INNER JOIN
	cursos AS martes_5
	ON 
		horarios.martes_5 = martes_5.ID
	INNER JOIN
	cursos AS martes_6
	ON 
		horarios.martes_6 = martes_6.ID
	INNER JOIN
	cursos AS miercoles_1
	ON 
		horarios.miercoles_1 = miercoles_1.ID
	INNER JOIN
	cursos AS miercoles_2
	ON 
		horarios.miercoles_2 = miercoles_2.ID
	INNER JOIN
	cursos AS miercoles_3
	ON 
		horarios.miercoles_3 = miercoles_3.ID
	INNER JOIN
	cursos AS miercoles_4
	ON 
		horarios.miercoles_4 = miercoles_4.ID
	INNER JOIN
	cursos AS miercoles_5
	ON 
		horarios.miercoles_5 = miercoles_5.ID
	INNER JOIN
	cursos AS miercoles_6
	ON 
		horarios.miercoles_6 = miercoles_6.ID
	INNER JOIN
	cursos AS jueves_1
	ON 
		horarios.jueves_1 = jueves_1.ID
	INNER JOIN
	cursos AS jueves_2
	ON 
		horarios.jueves_2 = jueves_2.ID
	INNER JOIN
	cursos AS jueves_3
	ON 
		horarios.jueves_3 = jueves_3.ID
	INNER JOIN
	cursos AS jueves_4
	ON 
		horarios.jueves_4 = jueves_4.ID
	INNER JOIN
	cursos AS jueves_5
	ON 
		horarios.jueves_5 = jueves_5.ID
	INNER JOIN
	cursos AS jueves_6
	ON 
		horarios.jueves_6 = jueves_6.ID
	INNER JOIN
	cursos AS viernes_1
	ON 
		horarios.viernes_1 = viernes_1.ID
	INNER JOIN
	cursos AS viernes_2
	ON 
		horarios.viernes_2 = viernes_2.ID
	INNER JOIN
	cursos AS viernes_3
	ON 
		horarios.viernes_3 = viernes_3.ID
	INNER JOIN
	cursos AS viernes_4
	ON 
		horarios.viernes_4 = viernes_4.ID
	INNER JOIN
	cursos AS viernes_5
	ON 
		horarios.viernes_5 = viernes_5.ID
	INNER JOIN
	cursos AS viernes_6
	ON 
		horarios.viernes_6 = viernes_6.ID
	INNER JOIN
	grados
	ON 
		horarios.id_curso = grados.ID
	INNER JOIN
	estudiantes
	ON 
		grados.ID = estudiantes.id_grado
WHERE
	estudiantes.id_usu = IDUSUARIO$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_MATERIALES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_MATERIALES` (IN `IDMATERIAL` INT)   SELECT
	detalles_material.ID,
	detalles_material.id_material,
	detalles_material.titulo, 
	detalles_material.estado, 
	detalles_material.archivo

FROM
	detalles_material
	WHERE
	detalles_material.id_material = IDMATERIAL$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_NOTAS_ADMIN`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_NOTAS_ADMIN` ()   SELECT
	detalles_calificaciones.ID, 
	CONCAT_WS(' ',estudiantes.nombre_estudiante,estudiantes.apellidos_estudiante) AS Estudiante, 
	CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) AS Docente, 
	cursos.nombre, 
	grados.aula, 
	detalles_calificaciones.nota_1, 
	detalles_calificaciones.nota_2, 
	detalles_calificaciones.nota_3, 
	detalles_calificaciones.nota_4, 
	detalles_calificaciones.nota_def
FROM
	detalles_calificaciones
	INNER JOIN
	estudiantes
	ON 
		detalles_calificaciones.id_claificaciones = estudiantes.ID
	INNER JOIN
	docentes
	ON 
		detalles_calificaciones.id_docente = docentes.ID
	INNER JOIN
	cursos
	INNER JOIN
	grados
	ON 
		estudiantes.id_grado = grados.ID
	INNER JOIN
	deatlles_cursos
	ON 
		detalles_calificaciones.id_grupo = deatlles_cursos.ID AND
		grados.ID = deatlles_cursos.id_aula AND
		cursos.ID = deatlles_cursos.id_curso AND
		detalles_calificaciones.id_docente = deatlles_cursos.id_docente AND
		docentes.ID = deatlles_cursos.id_docente$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_NOTAS_ESTUDIANTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_NOTAS_ESTUDIANTES` (IN `IDUSU` INT, IN `IDGROUP` INT, IN `IDDOC` INT)   SELECT
	detalles_calificaciones.ID, 
	detalles_calificaciones.nota_1 AS primera_nota, 
	detalles_calificaciones.nota_2 AS segunda_nota, 
	detalles_calificaciones.nota_3 AS tercera_nota, 
	detalles_calificaciones.nota_4 AS cuarta_nota, 
	detalles_calificaciones.nota_def, 
	calificaciones.id_estudiante, 
CONCAT(estudiantes.nombre_estudiante, ' ', estudiantes.apellidos_estudiante) AS estudiante,
	cursos.nombre, 
	grados.aula
FROM
	detalles_calificaciones
	INNER JOIN
	calificaciones
	ON 
		detalles_calificaciones.id_claificaciones = calificaciones.ID
	INNER JOIN
	estudiantes
	ON 
		calificaciones.id_estudiante = estudiantes.ID
	INNER JOIN
	deatlles_cursos
	ON 
		detalles_calificaciones.id_docente = deatlles_cursos.id_docente AND
		detalles_calificaciones.id_grupo = deatlles_cursos.ID
	INNER JOIN
	cursos
	ON 
		deatlles_cursos.id_curso = cursos.ID
	INNER JOIN
	grados
	ON 
		deatlles_cursos.id_aula = grados.ID
WHERE  detalles_calificaciones.id_grupo = IDGROUP AND deatlles_cursos.id_docente = IDDOC AND estudiantes.id_usu = IDUSU$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_NOTIFICACIONES_COMENTARIOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_NOTIFICACIONES_COMENTARIOS` (IN `IDDOC` INT)   SELECT
CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) AS docentes,
usuario.foto,
notificaciones.fecha,
notificaciones.leilo
FROM
notificaciones
INNER JOIN deatlles_cursos ON notificaciones.id_grupo = deatlles_cursos.ID
INNER JOIN docentes ON deatlles_cursos.id_docente = docentes.ID
INNER JOIN usuario ON docentes.id_usu = usuario.ID


WHERE  deatlles_cursos.id_docente = IDDOC AND notificaciones.leilo = "NO"$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_REGISTRO_CLASES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_REGISTRO_CLASES` (IN `ID_USUARIO` INT, IN `ID_GRADO` INT, IN `IDGROUP` INT, IN `ID_ASING` INT)   SELECT
	grabaciones.ID, 
	grabaciones.fecha, 
	grabaciones.titulo, 
	grabaciones.detalles, 
	grabaciones.url AS video, 
	CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) AS docente, 
	cursos.nombre AS Materia, 
	grados.aula AS grado, 
	deatlles_cursos.ID AS id_grupo, 
	usuario.foto
FROM
	grabaciones
	INNER JOIN
	deatlles_cursos
	ON 
		grabaciones.id_grupo = deatlles_cursos.ID
	INNER JOIN
	grados
	ON 
		deatlles_cursos.id_aula = grados.ID
	INNER JOIN
	cursos
	ON 
		deatlles_cursos.id_curso = cursos.ID
	INNER JOIN
	docentes
	ON 
		deatlles_cursos.id_docente = docentes.ID
	INNER JOIN
	usuario
	ON 
		docentes.id_usu = usuario.ID


WHERE docentes.id_usu = ID_USUARIO AND deatlles_cursos.id_aula = ID_GRADO AND deatlles_cursos.id_aula = ID_ASING AND deatlles_cursos.ID = IDGROUP$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_RESPUESTAS_COMENTARIOS_ESTUDIANTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_RESPUESTAS_COMENTARIOS_ESTUDIANTES` (IN `IDGRU` INT, IN `IDPROF` INT, IN `IDUSU` INT)   SELECT
    comentarios.ID, 
    talleres.titulo, 
    CONCAT_WS(' ', estudiantes.nombre_estudiante, estudiantes.apellidos_estudiante) AS alumnos, 
    comentarios.comentarios, 
    comentarios.respuesta, 
    comentarios.`status` AS Estado, 
    comentarios.fecha, 
    deatlles_cursos.ID AS id_grupo, 
    CONCAT_WS(' ', docentes.nombre_docente, docentes.apellidos_docente) AS docente,
    usuario_docente.foto AS fotodocente,
    usuario_estudiante.foto AS fotoestudiante
FROM
    comentarios
INNER JOIN
    talleres ON comentarios.id_taller = talleres.ID
INNER JOIN
    estudiantes ON comentarios.id_estudiante = estudiantes.id_usu
INNER JOIN
    deatlles_cursos ON talleres.id_grupo = deatlles_cursos.ID
INNER JOIN
    cursos ON deatlles_cursos.id_curso = cursos.ID
INNER JOIN
    grados ON estudiantes.id_grado = grados.ID
INNER JOIN
    docentes ON talleres.id_docente = docentes.ID AND deatlles_cursos.id_docente = docentes.ID
INNER JOIN
    usuario AS usuario_docente ON docentes.id_usu = usuario_docente.ID
INNER JOIN
    usuario AS usuario_estudiante ON estudiantes.id_usu = usuario_estudiante.ID
WHERE
  deatlles_cursos.ID = IDGRU AND
	deatlles_cursos.id_docente = IDPROF AND
	docentes.id_usu = IDUSU$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_TALLERES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_TALLERES` (IN `IDCUR` INT, IN `IDGRAP` INT, IN `IDDOC` INT)   SELECT
	talleres.ID, 
	talleres.titulo, 
	talleres.descripcion, 
	talleres.archivo, 
	talleres.fecha, 
	grados.aula, 
	talleres.estado AS Estado, 
	cursos.nombre, 
	CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) AS docente, 
	usuario.foto,
	talleres.id_grupo
FROM
	talleres
	INNER JOIN
	deatlles_cursos
	ON 
		talleres.id_grupo = deatlles_cursos.ID
	INNER JOIN
	cursos
	ON 
		deatlles_cursos.id_curso = cursos.ID
	INNER JOIN
	grados
	ON 
		deatlles_cursos.id_aula = grados.ID
	INNER JOIN
	docentes
	ON 
		talleres.id_docente = docentes.ID
	INNER JOIN
	usuario
	ON 
		docentes.id_usu = usuario.ID
WHERE deatlles_cursos.id_curso  = IDCUR AND deatlles_cursos.id_aula = IDGRAP AND docentes.id_usu = IDDOC$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_TALLERES_ENTREGADOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_TALLERES_ENTREGADOS` (IN `IDGROUP` INT, IN `IDTR` INT, IN `IDUSU` INT)   SELECT
	detalles_talleres.ID, 
	talleres.titulo, 
	talleres.estado, 
	detalles_talleres.archivo, 
	detalles_talleres.fecha, 
	CONCAT_WS(' ',estudiantes.nombre_estudiante,estudiantes.apellidos_estudiante) AS Estudiante, 
	talleres.ID AS id_taller, 
	detalles_talleres.nota, 
	usuario.foto, 
	cursos.nombre, 
	grados.aula, 
	detalles_talleres.nota_docente
FROM
	detalles_talleres
	INNER JOIN
	talleres
	ON 
		detalles_talleres.id_taller = talleres.ID
	INNER JOIN
	deatlles_cursos
	ON 
		talleres.id_grupo = deatlles_cursos.ID
	INNER JOIN
	docentes
	ON 
		talleres.id_docente = docentes.ID
	INNER JOIN
	estudiantes
	ON 
		detalles_talleres.id_estudiante = estudiantes.ID
	INNER JOIN
	usuario
	ON 
		estudiantes.id_usu = usuario.ID
	INNER JOIN
	cursos
	ON 
		deatlles_cursos.id_curso = cursos.ID
	INNER JOIN
	grados
	ON 
		deatlles_cursos.id_aula = grados.ID
WHERE docentes.id_usu = IDUSU AND deatlles_cursos.ID = IDGROUP$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_TALLERES_ENTREGADOS_ESTUDIANTE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_TALLERES_ENTREGADOS_ESTUDIANTE` (IN `IDUSU` INT, IN `IDGROUP` INT)   SELECT
	detalles_talleres.ID, 
	talleres.titulo, 
	talleres.estado, 
	detalles_talleres.archivo, 
	detalles_talleres.fecha, 
	CONCAT_WS(' ',estudiantes.nombre_estudiante,estudiantes.apellidos_estudiante) AS Estudiante, 
	talleres.ID AS id_taller, 
	detalles_talleres.nota, 
	usuario.foto, 
	cursos.nombre, 
	grados.aula, 
	detalles_talleres.nota_docente
FROM
	detalles_talleres
	INNER JOIN
	talleres
	ON 
		detalles_talleres.id_taller = talleres.ID
	INNER JOIN
	deatlles_cursos
	ON 
		talleres.id_grupo = deatlles_cursos.ID
	INNER JOIN
	docentes
	ON 
		talleres.id_docente = docentes.ID
	INNER JOIN
	estudiantes
	ON 
		detalles_talleres.id_estudiante = estudiantes.ID
	INNER JOIN
	usuario
	ON 
		estudiantes.id_usu = usuario.ID
	INNER JOIN
	cursos
	ON 
		deatlles_cursos.id_curso = cursos.ID
	INNER JOIN
	grados
	ON 
		deatlles_cursos.id_aula = grados.ID
WHERE estudiantes.id_usu = IDUSU AND deatlles_cursos.ID = IDGROUP$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_TALLERES_ESTUDIANTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_TALLERES_ESTUDIANTES` (IN `IDGROUP` INT, IN `IDDOC` INT, IN `IDDES` INT)   SELECT
	talleres.ID, 
	talleres.titulo, 
	talleres.descripcion, 
	talleres.archivo, 
	talleres.fecha, 
	grados.aula, 
	talleres.estado AS Estado, 
	cursos.nombre, 
	estudiantes.ID AS id_estudiante, 
	CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) AS docente, 
	usuario.foto
FROM
	talleres
	INNER JOIN
	deatlles_cursos
	ON 
		talleres.id_grupo = deatlles_cursos.ID
	INNER JOIN
	cursos
	ON 
		deatlles_cursos.id_curso = cursos.ID
	INNER JOIN
	grados
	ON 
		deatlles_cursos.id_aula = grados.ID
	INNER JOIN
	estudiantes
	ON 
		estudiantes.id_grado = grados.ID
	INNER JOIN
	docentes
	ON 
		deatlles_cursos.id_docente = docentes.ID
	INNER JOIN
	usuario
	ON 
		docentes.id_usu = usuario.ID

WHERE  deatlles_cursos.ID = IDGROUP AND deatlles_cursos.id_docente = IDDOC AND estudiantes.ID = IDDES$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_USUARIO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_USUARIO` ()   BEGIN
DECLARE CANTIDAD int;
	SET @CANTIDAD:=0;
  SELECT 
    @CANTIDAD:=@CANTIDAD+1 AS Posicion,
    subquery.ID, 
    subquery.usu_nombre, 
    subquery.usu_email, 
    subquery.usu_sexo, 
    subquery.usu_estatus,
    subquery.id_rol,
    subquery.rol_nombre,
    subquery.foto
  FROM (
    SELECT DISTINCT
      usuario.ID, 
      usuario.usu_nombre, 
      usuario.usu_email, 
      usuario.usu_sexo, 
      usuario.usu_estatus,
      usuario.id_rol,
      rol.rol_nombre,
      usuario.foto
    FROM
      usuario
    INNER JOIN rol ON usuario.id_rol = rol.ID
  ) AS subquery;
END$$

DROP PROCEDURE IF EXISTS `SP_LISTAR_VIDEOCONFERENCIAS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_LISTAR_VIDEOCONFERENCIAS` (IN `IDGROUP` INT, IN `IDUSU` INT)   SELECT
clases.ID,
clases.link,
clases.fecha,
clases.estado,
CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) AS docente
FROM
clases
INNER JOIN deatlles_cursos ON clases.id_docente = deatlles_cursos.id_docente AND clases.id_grupo = deatlles_cursos.ID
INNER JOIN docentes ON deatlles_cursos.id_docente = docentes.ID
INNER JOIN grados ON deatlles_cursos.id_aula = grados.ID
INNER JOIN estudiantes ON estudiantes.id_grado = grados.ID

WHERE estudiantes.id_usu = IDUSU  AND deatlles_cursos.ID = IDGROUP$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_ASISTENCIAS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_ASISTENCIAS` (IN `IDASI` INT, IN `D` TEXT, IN `A` TEXT, IN `IDGROUP` INT)   UPDATE asistencias SET
asistencias.dia = D,
asistencias.asistencia = A,
asistencias.fecha = CURDATE()


WHERE asistencias.ID = IDASI AND asistencias.id_grupo = IDGROUP$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_CALIFICACIONES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_CALIFICACIONES` (IN `IDCAL` INT, IN `NOTA1` FLOAT, IN `NOTA2` FLOAT, IN `NOTA3` FLOAT, IN `NOTA4` FLOAT)   UPDATE detalles_calificaciones SET
detalles_calificaciones.nota_1 = NOTA1,
detalles_calificaciones.nota_2 = NOTA2,
detalles_calificaciones.nota_3 = NOTA3,
detalles_calificaciones.nota_4 = NOTA4,
detalles_calificaciones.nota_def = NOTA1 * 0.25 + NOTA2  * 0.25 + NOTA3 * 0.25 + NOTA4 * 0.25


WHERE detalles_calificaciones.ID = IDCAL$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_CHAT_ABIERTO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_CHAT_ABIERTO` (IN `id_chat_abierto` INT)   BEGIN
    DECLARE estado_actual VARCHAR(50);

    -- Obtener el estado actual del chat
    SELECT Estado INTO estado_actual FROM detalles_chat WHERE ID = id_chat_abierto;

    -- Verificar si el estado actual es 'VISTO'
    IF estado_actual = 'VISTO' THEN
        SELECT -1 AS result; -- Devolver -1 como resultado si el estado es 'VISTO'
    ELSE
        -- Actualizar el estado del chat a 'ABIERTO'
        UPDATE detalles_chat SET Estado = 'ABIERTO' WHERE ID = id_chat_abierto;

        -- Devolver 1 como resultado para indicar que se realizó la modificación con éxito
        SELECT 1 AS result;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_CHAT_VISTO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_CHAT_VISTO` (IN `id_chat_visto` INT)   BEGIN
    DECLARE estado_actual VARCHAR(50);

    -- Obtener el estado actual del chat
    SELECT Estado INTO estado_actual FROM detalles_chat WHERE ID = id_chat_visto;

    -- Verificar si el estado actual es 'ABIERTO'
    IF estado_actual = 'ABIERTO' THEN
        SELECT -1 AS result; -- Devolver -1 como resultado si el estado es 'ABIERTO'
    ELSE
        -- Actualizar el estado del chat a 'VISTO'
        UPDATE detalles_chat SET Estado = 'VISTO' WHERE ID = id_chat_visto;

        -- Devolver 1 como resultado para indicar que se realizó la modificación con éxito
        SELECT 1 AS result;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_ClASES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_ClASES` (IN `IDCLAS` INT, IN `IDDOC` INT, IN `TITTLE` VARCHAR(100), IN `DES` TEXT, IN `IDGROUP` INT, IN `RUTA` VARCHAR(255))   UPDATE grabaciones SET
grabaciones.id_docentes = IDDOC,
grabaciones.titulo = TITTLE,
grabaciones.detalles = DES,
grabaciones.id_grupo = IDGROUP,
grabaciones.url = RUTA


WHERE grabaciones.ID = IDCLAS$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_COMENTARIO_FORO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_COMENTARIO_FORO` (IN `IDCOMENTARIO` INT, IN `COMENTARIO` TEXT)   BEGIN
    UPDATE detalles_foro
    SET 
        detalles_foro.comentario = COMENTARIO
    WHERE 
        detalles_foro.ID = IDCOMENTARIO;
END$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_COMENTARIO_FORO_RESPUESTA`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_COMENTARIO_FORO_RESPUESTA` (IN `IDCOMENTARIO` INT, IN `COMENTARIO` TEXT)   BEGIN
    UPDATE detalles_foro_respuesta
    SET 
        detalles_foro_respuesta.comentario_respuesta = COMENTARIO
    WHERE 
        detalles_foro_respuesta.ID = IDCOMENTARIO;
END$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_CONTRA_USUARIO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_CONTRA_USUARIO` (IN `IDUSUARIO` INT, IN `CONTRA` VARCHAR(250))   UPDATE usuario SET
usuario.usu_contrasena=CONTRA
WHERE usuario.ID=IDUSUARIO$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_DATOS_USUARIO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_DATOS_USUARIO` (IN `IDUSUARIO` INT, IN `SEXO` CHAR(10), IN `IDROL` INT, IN `EMAIL` VARCHAR(250))   UPDATE usuario SET
usu_sexo=SEXO,
id_rol=IDROL,
usu_email=EMAIL
WHERE ID=IDUSUARIO$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_DOCENTE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_DOCENTE` (IN `IDDOCENTE` INT, IN `IDUSUARIO` INT, IN `NOMBRE` VARCHAR(50), IN `APELLIDO` VARCHAR(50), IN `DOCUMENTOACTUAL` CHAR(10), IN `DOCUMENTONUEVO` CHAR(10), IN `TELEFONO` CHAR(11), IN `FECHA` DATE, IN `EMAIL` VARCHAR(250), IN `SEXO` CHAR(2))   BEGIN
if DOCUMENTOACTUAL = DOCUMENTONUEVO THEN
 UPDATE usuario SET
 usu_email=EMAIL,
 usu_sexo=SEXO
 WHERE ID=IDUSUARIO;
 UPDATE docentes SET
 nombre_docente=NOMBRE,
 apellidos_docente=APELLIDO,
 nm_documento=DOCUMENTOACTUAL,
 telefono=TELEFONO,
 fecha_nacimiento=FECHA
 WHERE ID=IDDOCENTE;
 SELECT 1;
ELSE
   SET @CANTIDADDO:=(SELECT COUNT(*) FROM docentes WHERE nm_documento=DOCUMENTONUEVO);
	 IF @CANTIDADDO = 0 THEN
  UPDATE usuario SET
  usu_email=EMAIL,
  usu_sexo=SEXO
  WHERE ID=IDUSUARIO;
  UPDATE docentes SET
  nombre_docente=NOMBRE,
  apellidos_docente=APELLIDO,
  nm_documento=DOCUMENTONUEVO,
  telefono=TELEFONO,
  fecha_nacimiento=FECHA

  WHERE ID=IDDOCENTE;
 SELECT 1;
 ELSE
 SELECT 2;
  END IF;
 END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_ESTADO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_ESTADO` (IN `IDCLASS` INT, IN `STATUS` CHAR(10))   UPDATE clases SET 

clases.estado = STATUS

WHERE clases.ID = IDCLASS$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_ESTADO_FECHAS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_ESTADO_FECHAS` (IN `ID_TALLER` INT, IN `FC` DATE)   UPDATE talleres SET
talleres.Fecha = FC,
talleres.estado = 'ACTIVO'

WHERE talleres.ID = ID_TALLER$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_ESTADO_FECHAS_FORO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_ESTADO_FECHAS_FORO` (IN `ID_FORO` INT, IN `FC` DATE)   UPDATE foro SET
foro.fecha = FC,
foro.foro_estado = 'ACTIVO'

WHERE foro.ID = ID_FORO$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_ESTADO_FORO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_ESTADO_FORO` ()   UPDATE foro SET

foro.foro_estado = 'INACTIVO'

WHERE foro.fecha < CURDATE()$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_ESTADO_LINK`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_ESTADO_LINK` ()   UPDATE clases SET

clases.estado = 'INACTIVO'

WHERE clases.fecha < CURDATE()$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_ESTADO_MATERIAL`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_ESTADO_MATERIAL` ()   BEGIN
    UPDATE detalles_material SET
    detalles_material.estado = ''
    WHERE detalles_material.fecha < DATE_SUB(CURDATE(), INTERVAL 7 DAY);
END$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_ESTADO_TALLER`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_ESTADO_TALLER` ()   UPDATE talleres SET

talleres.estado = 'INACTIVO'

WHERE talleres.Fecha < CURDATE()$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_ESTATUS_USUARIO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_ESTATUS_USUARIO` (IN `IDUSUARIO` INT, IN `ESTATUS` VARCHAR(50))   UPDATE usuario SET
usu_estatus=ESTATUS,
usu_intento=0
WHERE ID = IDUSUARIO$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_ESTUDIANTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_ESTUDIANTES` (IN `IDESTUDIANTE` INT, IN `IDUSUARIO` INT, IN `NOMBRE` VARCHAR(50), IN `APELLIDO` VARCHAR(50), IN `DOCUMENTOACTUAL` CHAR(10), IN `DOCUMENTONUEVO` CHAR(10), IN `TELEFONO` CHAR(11), IN `FECHA` DATE, IN `EMAIL` VARCHAR(250), IN `SEXO` CHAR(2), IN `GRADO` INT)   BEGIN
if DOCUMENTOACTUAL = DOCUMENTONUEVO THEN
 UPDATE usuario SET
 usu_email=EMAIL,
 usu_sexo=SEXO
 WHERE ID=IDUSUARIO;
 UPDATE estudiantes SET
 nombre_estudiante=NOMBRE,
 apellidos_estudiante=APELLIDO,
 nm_documento=DOCUMENTOACTUAL,
 telefono=TELEFONO,
 fecha_nacimiento=FECHA,
	id_grado = GRADO
 WHERE ID=IDESTUDIANTE;
 SELECT 1;
ELSE
   SET @CANTIDADDO:=(SELECT COUNT(*) FROM estudiantes WHERE nm_documento=DOCUMENTONUEVO);
	 IF @CANTIDADDO = 0 THEN
  UPDATE usuario SET
  usu_email=EMAIL,
  usu_sexo=SEXO
  WHERE ID=IDUSUARIO;
  UPDATE estudiantes SET
  nombre_estudiante=NOMBRE,
 apellidos_estudiante=APELLIDO,
  nm_documento=DOCUMENTONUEVO,
  telefono=TELEFONO,
  fecha_nacimiento=FECHA

  WHERE ID=IDESTUDIANTE;
 SELECT 1;
 ELSE
 SELECT 2;
  END IF;
 END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_GRUPOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_GRUPOS` (IN `IDD` INT, IN `IDDOC` INT, IN `IDASING` INT, IN `IDAULA` INT)   BEGIN
DECLARE CANTIDAD INT;
DECLARE CANTIDAD1 INT;
SET @CANTIDAD:=(SELECT COUNT(*) FROM deatlles_cursos WHERE id_curso = IDASING AND id_aula = IDAULA AND id_docente = IDDOC);
IF @CANTIDAD = 0 THEN
SET @CANTIDAD1:=(SELECT COUNT(*) FROM deatlles_cursos WHERE id_curso = IDASING AND id_aula = IDAULA );
IF @CANTIDAD1 = 0 THEN
UPDATE deatlles_cursos SET
deatlles_cursos.id_curso = IDASING,
deatlles_cursos.id_docente = IDDOC,
deatlles_cursos.id_aula = IDAULA
WHERE ID = IDD;
SELECT 1;
ELSE
SELECT 2;
END IF; 
ELSE
SELECT 2;
END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_REGISTRAR_ASISTENCIAS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_REGISTRAR_ASISTENCIAS` (IN `IDASI` INT, IN `IDOC` INT, IN `IDGROUP` INT, IN `D` TEXT, IN `A` TEXT)   BEGIN
    DECLARE CANTIDAD INT;
    
    -- Modificar la asistencia existente
    UPDATE asistencias 
    SET
        asistencias.dia = D,
        asistencias.asistencia = A,
        asistencias.fecha = CURDATE()
    WHERE asistencias.ID = IDASI AND asistencias.id_grupo = IDGROUP;
    
    -- Verificar si la asistencia ya está registrada para este docente
    SET @CANTIDAD:=(SELECT COUNT(*) FROM detalles_sistencias 
                    WHERE id_asistencia = IDASI AND id_docente= IDOC 
                    AND asistencia = A AND dia = D AND fecha = CURDATE());
    
    -- Si no está registrada, la insertamos
    IF @CANTIDAD = 0 THEN
        INSERT INTO detalles_sistencias(id_asistencia, id_docente, asistencia, dia, fecha) 
        VALUES (IDASI, IDOC, A, D, CURDATE());
        SELECT 1;
    ELSE
        SELECT 2;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_STATUS_ASIGNATURA`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_STATUS_ASIGNATURA` (IN `IDAS` INT, IN `ESTADO` VARCHAR(50))   UPDATE cursos SET
status = ESTADO
WHERE ID = IDAS$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_TALLER`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_TALLER` (IN `IDTA` INT, IN `IDDOC` INT, IN `NOMBRE` VARCHAR(50), IN `DES` TEXT, IN `IDGROUP` INT, IN `RUTA` VARCHAR(255))   UPDATE talleres SET
talleres.id_docente = IDDOC,
talleres.titulo = NOMBRE,
talleres.descripcion = DES,
talleres.id_grupo = IDGROUP,
talleres.archivo = RUTA

WHERE talleres.ID = IDTA$$

DROP PROCEDURE IF EXISTS `SP_MODIFICAR_USUARIO_FOTO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_MODIFICAR_USUARIO_FOTO` (IN `IDUSU` INT, IN `RUTA` VARCHAR(255))   UPDATE usuario set
foto=RUTA
where ID=IDUSU$$

DROP PROCEDURE IF EXISTS `SP_NUEVA_CARPETA_MATERIAL`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_NUEVA_CARPETA_MATERIAL` (IN `id_usuario_param` INT, IN `titulo_carpeta_param` TEXT)   BEGIN
    DECLARE carpeta_existente INT DEFAULT 0;
    
    -- Verificar si ya existe una carpeta con el mismo título para el usuario dado
    SELECT COUNT(*) INTO carpeta_existente 
    FROM material 
    WHERE id_docente = id_usuario_param AND titulo = titulo_carpeta_param;
    
    IF carpeta_existente > 0 THEN
        -- Ya existe una carpeta con el mismo título para el usuario dado
        SELECT -1 AS result;
    ELSE
        -- Se puede registrar la nueva carpeta
        INSERT INTO material (id_docente, titulo) VALUES (id_usuario_param, titulo_carpeta_param);
        SELECT 1 AS result;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_ASIGNACION_CLASES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_ASIGNACION_CLASES` (IN `IDDOC` INT, IN `IDGROUP` INT, IN `URL` VARCHAR(255), IN `FC` DATE)   INSERT INTO clases(id_docente,id_grupo,link,fecha,estado) VALUES (IDDOC,IDGROUP,URL,FC,'ACTIVO')$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_ASIGNATURAS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_ASIGNATURAS` (IN `NOM` VARCHAR(50))   BEGIN
DECLARE CANTIDAD INT;
SET @CANTIDAD:=(SELECT COUNT(*) FROM cursos WHERE nombre = BINARY NOM);
IF @CANTIDAD=0 THEN
   INSERT INTO cursos(nombre,status) VALUES (NOM,'ACTIVO');
	 SELECT 1;
 ELSE
	 SELECT 2;
END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_ASISTENCIAS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_ASISTENCIAS` (IN `IDASI` INT, IN `IDOC` INT, IN `D` TEXT, IN `A` TEXT)   BEGIN
    DECLARE CANTIDAD INT;
    SET CANTIDAD := (SELECT COUNT(*) FROM detalles_sistencias WHERE id_asistencia = IDASI AND id_docente = IDOC AND asistencia = A AND dia = D AND fecha = CURDATE());
    
    IF CANTIDAD = 0 THEN
        INSERT INTO detalles_sistencias(id_asistencia, id_docente, asistencia, dia, fecha) VALUES (IDASI, IDOC, A, D, CURDATE());
        SELECT 1;
    ELSE
        SELECT 2;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_CLASES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_CLASES` (IN `FC` DATE, IN `IDGROUP` INT, IN `IDDOC` INT, IN `TITTLE` VARCHAR(100), IN `DES` TEXT, IN `RUTA` VARCHAR(255))   BEGIN
DECLARE CANTIDAD INT;

SET @CANTIDAD:=(SELECT COUNT(*) FROM grabaciones WHERE titulo = TITTLE );
IF @CANTIDAD = 0 THEN
INSERT INTO grabaciones(titulo,fecha,detalles,id_grupo,id_docentes,url) VALUES (TITTLE , FC, DES,IDGROUP,IDDOC,RUTA);
SELECT 1;
ELSE
SELECT 2;

END IF;

END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_COMENTARIO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_COMENTARIO` (IN `IDTA` INT, IN `IDUSU` INT, IN `COM` TEXT)   INSERT INTO comentarios(id_taller, id_estudiante, comentarios ,status,fecha) VALUES (IDTA, IDUSU, COM,'NO RESPONDIDO',CURDATE())$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_COMENTARIO_ASUNTO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_COMENTARIO_ASUNTO` (IN `IDDOC` INT, IN `IDUSU` INT, IN `ASUNTO` TEXT, IN `COMENTARIO` TEXT)   INSERT INTO comentarios_asuntos(id_docente,id_estudiante,asunto,comentario,estado,fecha) VALUES (IDDOC, IDUSU,ASUNTO,COMENTARIO,'NO RESPONDIDO',CURDATE())$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_COMENTARIO_FORO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_COMENTARIO_FORO` (IN `id_foro` INT, IN `id_grupo` INT, IN `id_docente` INT, IN `comentario` TEXT)   BEGIN
    INSERT INTO detalles_foro (id_foro, id_grupo, id_comentario, comentario, fecha)
    VALUES (id_foro, id_grupo, id_docente, comentario, CURRENT_DATE());
END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_COMENTARIO_FORO_RESPUESTA`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_COMENTARIO_FORO_RESPUESTA` (IN `id_foro` INT, IN `id_respuesta` INT, IN `id_comentario_principal` INT, IN `comentario_respuesta` TEXT, IN `responder` INT)   BEGIN
    INSERT INTO detalles_foro_respuesta (id_foro, id_respuesta, id_comentario_principal, comentario_respuesta, fecha_respuesta,id_responde_a)
    VALUES (id_foro, id_respuesta, id_comentario_principal, comentario_respuesta, CURRENT_DATE(), responder);
END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_DOCENTE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_DOCENTE` (IN `NOMBRES` VARCHAR(50), IN `APELLIDOS` VARCHAR(50), IN `DOCUMENTO` CHAR(10), IN `TELEFONO` CHAR(11), IN `FECHA` DATE, IN `USUARIO` VARCHAR(50), IN `CONTRA` TEXT, IN `EMAIL` VARCHAR(250), IN `SEXO` CHAR(2))   BEGIN
DECLARE CANTIDAD INT;
DECLARE CANTIDADDO INT;
SET @CANTIDAD:=(SELECT COUNT(*) FROM usuario WHERE usu_nombre=USUARIO AND usu_email = EMAIL);
IF @CANTIDAD = 0 THEN
   SET @CANTIDADDO:=(SELECT COUNT(*) FROM docentes WHERE nm_documento=DOCUMENTO);
	 IF @CANTIDADDO = 0 THEN
INSERT INTO usuario(usu_nombre,usu_contrasena,usu_sexo,id_rol,usu_estatus,usu_email,usu_intento,foto) VALUES (USUARIO,CONTRA,SEXO,2,'ACTIVO',EMAIL,0,'controlador\usuario\foto\default.png');
 INSERT INTO docentes(nombre_docente,apellidos_docente,fecha_nacimiento,telefono,nm_documento,id_usu) VALUES (NOMBRES,APELLIDOS,FECHA,TELEFONO,DOCUMENTO,(SELECT MAX(ID) FROM usuario));
  SELECT 1;
  ELSE
    SELECT 2;
  END IF;
ELSE
  SELECT 2;
END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_ESTUDIANTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_ESTUDIANTES` (IN `DOCUMENTO` CHAR(10), IN `NOMBRE` VARCHAR(50), IN `APE` VARCHAR(50), IN `FECHA` DATE, IN `TELE` CHAR(10), IN `SEXO` CHAR(10), IN `EMAIL` VARCHAR(255), IN `GRADO` INT, IN `USU` VARCHAR(50), IN `CONTRA` VARCHAR(255))   BEGIN
DECLARE CANTIDAD INT;
DECLARE CANTIDADDE INT;
SET @CANTIDAD:=(SELECT COUNT(*) FROM usuario WHERE usu_nombre=USU AND usu_email = EMAIL);
IF @CANTIDAD = 0 THEN
   SET @CANTIDADDE:=(SELECT COUNT(*) FROM estudiantes WHERE nm_documento=DOCUMENTO);
	 IF @CANTIDADDE = 0 THEN
INSERT INTO usuario(usu_nombre,usu_contrasena,usu_sexo,id_rol,usu_estatus,usu_email,usu_intento,foto) VALUES (USU,CONTRA,SEXO,3,'ACTIVO',EMAIL,0,'controlador\usuario\foto\default.png');
 INSERT INTO estudiantes(nombre_estudiante,apellidos_estudiante,fecha_nacimiento,telefono,nm_documento,id_grado,id_usu) VALUES (NOMBRE,APE,FECHA,TELE,DOCUMENTO,GRADO,(SELECT MAX(ID) FROM usuario));
INSERT INTO calificaciones(id_estudiante) VALUES ((SELECT MAX(ID) FROM estudiantes)); 
 SELECT 1;
  ELSE
    SELECT 2;
  END IF;
ELSE
  SELECT 2;
END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_ESTUDIANTES_GRUPOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_ESTUDIANTES_GRUPOS` (IN `IDCAL` INT, IN `IDDOC` INT, IN `IDGROUP` INT)   BEGIN
DECLARE CANTIDAD INT;

SET @CANTIDAD:=(SELECT COUNT(*) FROM  detalles_calificaciones WHERE id_claificaciones = IDCAL AND id_docente = IDDOC AND id_grupo = IDGROUP);
IF @CANTIDAD = 0 THEN
INSERT INTO detalles_calificaciones(id_claificaciones,id_docente,id_grupo,nota_1,nota_2,nota_3,nota_4,nota_def) VALUES (IDCAL,IDDOC,IDGROUP,0,0,0,0,0); 
 INSERT INTO asistencias(id_estudiante, id_grupo,asistencia,dia,fecha) VALUES (IDCAL, IDGROUP,'','',CURDATE());
SELECT 1;
ELSE
SELECT 2;

END IF;


END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_FORO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_FORO` (IN `IDPRO` INT, IN `IDGRADO` INT, IN `DT` DATE, IN `SUBT` VARCHAR(255), IN `DESCP` TEXT)   BEGIN
    DECLARE formatted_datetime VARCHAR(255);
    SET formatted_datetime = CONCAT(DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i:%s'), ' ', DATE_FORMAT(NOW(), '%p'));

    INSERT INTO foro (id_docente, id_grupo, fecha, titulo, descripcion, fecha_foro, foro_estado)
    VALUES (IDPRO, IDGRADO, DT, SUBT, DESCP, formatted_datetime, 'ACTIVO');
END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_GRUPO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_GRUPO` (IN `IDDOC` INT, IN `IDASIG` INT, IN `IDGRUOP` INT)   BEGIN
DECLARE CANTIDAD INT;

SET @CANTIDAD:=(SELECT COUNT(*) FROM deatlles_cursos WHERE id_curso = BINARY IDASIG AND id_docente = BINARY IDDOC AND  id_aula = BINARY  IDGRUOP);
IF @CANTIDAD=0 THEN

INSERT INTO deatlles_cursos(id_docente,id_curso,id_aula,fecha_asignacion) VALUES (IDDOC,IDASIG,IDGRUOP,CURDATE());

SELECT 1;

ELSE


SELECT 2;

END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_HORARIO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_HORARIO` (IN `grado_param` INT, IN `bloque_1_param` TEXT, IN `bloque_2_param` TEXT, IN `bloque_3_param` TEXT, IN `bloque_4_param` TEXT, IN `bloque_5_param` TEXT, IN `bloque_6_param` TEXT, IN `lunes_1_param` INT, IN `lunes_2_param` INT, IN `lunes_3_param` INT, IN `lunes_4_param` INT, IN `lunes_5_param` INT, IN `lunes_6_param` INT, IN `martes_1_param` INT, IN `martes_2_param` INT, IN `martes_3_param` INT, IN `martes_4_param` INT, IN `martes_5_param` INT, IN `martes_6_param` INT, IN `miercoles_1_param` INT, IN `miercoles_2_param` INT, IN `miercoles_3_param` INT, IN `miercoles_4_param` INT, IN `miercoles_5_param` INT, IN `miercoles_6_param` INT, IN `jueves_1_param` INT, IN `jueves_2_param` INT, IN `jueves_3_param` INT, IN `jueves_4_param` INT, IN `jueves_5_param` INT, IN `jueves_6_param` INT, IN `viernes_1_param` INT, IN `viernes_2_param` INT, IN `viernes_3_param` INT, IN `viernes_4_param` INT, IN `viernes_5_param` INT, IN `viernes_6_param` INT)   BEGIN
    DECLARE id_exist INT DEFAULT 0;
    
    -- Verificar si el id_curso ya existe
    SELECT COUNT(*) INTO id_exist FROM horarios WHERE id_curso = grado_param;
    
    IF id_exist > 0 THEN
        -- El id_curso ya existe, no se puede registrar
        SELECT -1 AS result;
    ELSE
        -- El id_curso no existe, se puede registrar el horario
        INSERT INTO horarios (
            id_curso,
            bloque_1, bloque_2, bloque_3, bloque_4, bloque_5, bloque_6,
            lunes_1, lunes_2, lunes_3, lunes_4, lunes_5, lunes_6,
            martes_1, martes_2, martes_3, martes_4, martes_5, martes_6,
            miercoles_1, miercoles_2, miercoles_3, miercoles_4, miercoles_5, miercoles_6,
            jueves_1, jueves_2, jueves_3, jueves_4, jueves_5, jueves_6,
            viernes_1, viernes_2, viernes_3, viernes_4, viernes_5, viernes_6
        )
        VALUES (
            grado_param,
            bloque_1_param, bloque_2_param, bloque_3_param, bloque_4_param, bloque_5_param, bloque_6_param,
            lunes_1_param, lunes_2_param, lunes_3_param, lunes_4_param, lunes_5_param, lunes_6_param,
            martes_1_param, martes_2_param, martes_3_param, martes_4_param, martes_5_param, martes_6_param,
            miercoles_1_param, miercoles_2_param, miercoles_3_param, miercoles_4_param, miercoles_5_param, miercoles_6_param,
            jueves_1_param, jueves_2_param, jueves_3_param, jueves_4_param, jueves_5_param, jueves_6_param,
            viernes_1_param, viernes_2_param, viernes_3_param, viernes_4_param, viernes_5_param, viernes_6_param
        );
        
        SELECT 1 AS result;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_HORARIO_DOCENTE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_HORARIO_DOCENTE` (IN `id_docente_param` INT, IN `bloque_1_param` TEXT, IN `bloque_2_param` TEXT, IN `bloque_3_param` TEXT, IN `bloque_4_param` TEXT, IN `bloque_5_param` TEXT, IN `bloque_6_param` TEXT, IN `lunes_1_param` TEXT, IN `lunes_2_param` TEXT, IN `lunes_3_param` TEXT, IN `lunes_4_param` TEXT, IN `lunes_5_param` TEXT, IN `lunes_6_param` TEXT, IN `martes_1_param` TEXT, IN `martes_2_param` TEXT, IN `martes_3_param` TEXT, IN `martes_4_param` TEXT, IN `martes_5_param` TEXT, IN `martes_6_param` TEXT, IN `miercoles_1_param` TEXT, IN `miercoles_2_param` TEXT, IN `miercoles_3_param` TEXT, IN `miercoles_4_param` TEXT, IN `miercoles_5_param` TEXT, IN `miercoles_6_param` TEXT, IN `jueves_1_param` TEXT, IN `jueves_2_param` TEXT, IN `jueves_3_param` TEXT, IN `jueves_4_param` TEXT, IN `jueves_5_param` TEXT, IN `jueves_6_param` TEXT, IN `viernes_1_param` TEXT, IN `viernes_2_param` TEXT, IN `viernes_3_param` TEXT, IN `viernes_4_param` TEXT, IN `viernes_5_param` TEXT, IN `viernes_6_param` TEXT, IN `grado_lunes_1_param` TEXT, IN `grado_lunes_2_param` TEXT, IN `grado_lunes_3_param` TEXT, IN `grado_lunes_4_param` TEXT, IN `grado_lunes_5_param` TEXT, IN `grado_lunes_6_param` TEXT, IN `grado_martes_1_param` TEXT, IN `grado_martes_2_param` TEXT, IN `grado_martes_3_param` TEXT, IN `grado_martes_4_param` TEXT, IN `grado_martes_5_param` TEXT, IN `grado_martes_6_param` TEXT, IN `grado_miercoles_1_param` TEXT, IN `grado_miercoles_2_param` TEXT, IN `grado_miercoles_3_param` TEXT, IN `grado_miercoles_4_param` TEXT, IN `grado_miercoles_5_param` TEXT, IN `grado_miercoles_6_param` TEXT, IN `grado_jueves_1_param` TEXT, IN `grado_jueves_2_param` TEXT, IN `grado_jueves_3_param` TEXT, IN `grado_jueves_4_param` TEXT, IN `grado_jueves_5_param` TEXT, IN `grado_jueves_6_param` TEXT, IN `grado_viernes_1_param` TEXT, IN `grado_viernes_2_param` TEXT, IN `grado_viernes_3_param` TEXT, IN `grado_viernes_4_param` TEXT, IN `grado_viernes_5_param` TEXT, IN `grado_viernes_6_param` TEXT)   BEGIN
    DECLARE id_exist INT DEFAULT 0;

    -- Verificar si el id_docente ya existe
    SELECT COUNT(*) INTO id_exist FROM horarios_docentes WHERE id_docente = id_docente_param;

    IF id_exist > 0 THEN
        -- El id_docente ya existe, no se puede registrar
        SELECT -1 AS result;
    ELSE
        -- El id_docente no existe, se puede registrar el horario
        INSERT INTO horarios_docentes (
    id_docente,
    bloque_1, bloque_2, bloque_3, bloque_4, bloque_5, bloque_6,
    lunes_1, lunes_2, lunes_3, lunes_4, lunes_5, lunes_6,
    martes_1, martes_2, martes_3, martes_4, martes_5, martes_6,
    miercoles_1, miercoles_2, miercoles_3, miercoles_4, miercoles_5, miercoles_6,
    jueves_1, jueves_2, jueves_3, jueves_4, jueves_5, jueves_6,
    viernes_1, viernes_2, viernes_3, viernes_4, viernes_5, viernes_6,
    grado_lunes_1, grado_lunes_2, grado_lunes_3, grado_lunes_4, grado_lunes_5, grado_lunes_6,
    grado_martes_1, grado_martes_2, grado_martes_3, grado_martes_4, grado_martes_5, grado_martes_6,
    grado_miercoles_1, grado_miercoles_2, grado_miercoles_3, grado_miercoles_4, grado_miercoles_5, grado_miercoles_6,
    grado_jueves_1, grado_jueves_2, grado_jueves_3, grado_jueves_4, grado_jueves_5, grado_jueves_6,
    grado_viernes_1, grado_viernes_2, grado_viernes_3, grado_viernes_4, grado_viernes_5, grado_viernes_6
) VALUES (
            id_docente_param,
            bloque_1_param, bloque_2_param, bloque_3_param, bloque_4_param, bloque_5_param, bloque_6_param,
            lunes_1_param, lunes_2_param, lunes_3_param, lunes_4_param, lunes_5_param, lunes_6_param,
            martes_1_param, martes_2_param, martes_3_param, martes_4_param, martes_5_param, martes_6_param,
            miercoles_1_param, miercoles_2_param, miercoles_3_param, miercoles_4_param, miercoles_5_param, miercoles_6_param,
            jueves_1_param, jueves_2_param, jueves_3_param, jueves_4_param, jueves_5_param, jueves_6_param,
            viernes_1_param, viernes_2_param, viernes_3_param, viernes_4_param, viernes_5_param, viernes_6_param,
            grado_lunes_1_param, grado_lunes_2_param, grado_lunes_3_param, grado_lunes_4_param, grado_lunes_5_param, grado_lunes_6_param,
            grado_martes_1_param, grado_martes_2_param, grado_martes_3_param, grado_martes_4_param, grado_martes_5_param, grado_martes_6_param,
            grado_miercoles_1_param, grado_miercoles_2_param, grado_miercoles_3_param, grado_miercoles_4_param, grado_miercoles_5_param, grado_miercoles_6_param,
            grado_jueves_1_param, grado_jueves_2_param, grado_jueves_3_param, grado_jueves_4_param, grado_jueves_5_param, grado_jueves_6_param,
            grado_viernes_1_param, grado_viernes_2_param, grado_viernes_3_param, grado_viernes_4_param, grado_viernes_5_param, grado_viernes_6_param
        );
        
        SELECT 1 AS result;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_NOTA`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_NOTA` (IN `IDTALLER` INT, IN `NOTA` TEXT)   BEGIN
    UPDATE detalles_talleres
    SET nota_docente = NOTA
    WHERE ID = IDTALLER;
END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_NUEVO_CHAT`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_NUEVO_CHAT` (IN `id_usuario_param` INT, IN `id_chat_nuevo_param` INT)   BEGIN
    DECLARE existe_chat INT DEFAULT 0;
    
    -- Verificar si ambos usuarios ya están registrados juntos en alguna fila
    SELECT COUNT(*) INTO existe_chat 
    FROM chat 
    WHERE (id_principal = id_usuario_param AND id_segundario = id_chat_nuevo_param)
    OR (id_principal = id_chat_nuevo_param AND id_segundario = id_usuario_param);
    
    IF existe_chat > 0 THEN
        -- Ambos usuarios ya están registrados en el chat, no se puede registrar
        SELECT -1 AS result;
    ELSE
        -- Se puede registrar el nuevo chat
        INSERT INTO chat (id_principal, id_segundario) VALUES (id_usuario_param, id_chat_nuevo_param);
        SELECT 1 AS result;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_RESPUESTA_CHAT`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_RESPUESTA_CHAT` (IN `id_chat` INT, IN `id_usuario` INT, IN `comentario` TEXT)   BEGIN
    INSERT INTO detalles_chat (Id_chat, id_comentario, Comentario, Fecha, Estado)
    VALUES (id_chat, id_usuario, comentario, CURRENT_TIMESTAMP(), 'NO VISTO');
END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR_USUARIO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR_USUARIO` (IN `USU` VARCHAR(20), IN `CONTRA` VARCHAR(250), IN `SEXO` CHAR(10), IN `ROL` INT, IN `EMAIL` VARCHAR(250), IN `RUTA` VARCHAR(255))   BEGIN
DECLARE CANTIDAD INT;
SET @CANTIDAD:=(SELECT COUNT(*) FROM usuario WHERE usu_nombre= BINARY USU);
IF @CANTIDAD=0 THEN
   INSERT INTO usuario(usu_nombre,usu_contrasena,usu_sexo,id_rol,usu_estatus,usu_email,usu_intento,foto) VALUES (USU,CONTRA,SEXO,ROL,'ACTIVO',EMAIL,0,RUTA);
	 SELECT 1;
 ELSE
	 SELECT 2;
END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_RESGISTRAR_CHAT_ARCHIVO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RESGISTRAR_CHAT_ARCHIVO` (IN `id_chat` INT, IN `comentario` TEXT, IN `id_usuario` INT, IN `URL` VARCHAR(255))   BEGIN
    INSERT INTO detalles_chat (Id_chat, id_comentario, Comentario, Fecha, Estado,archivo)
    VALUES (id_chat, id_usuario, comentario, CURRENT_TIMESTAMP(), 'NO VISTO',URL);
END$$

DROP PROCEDURE IF EXISTS `SP_RESGISTRAR_ENTREGAR_TALLER`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RESGISTRAR_ENTREGAR_TALLER` (IN `IDTLR` INT, IN `IDES` INT, IN `URL` VARCHAR(255), IN `NOTA` TEXT)   BEGIN
    -- Insertar en la tabla detalles_talleres
    INSERT INTO detalles_talleres(id_taller, id_estudiante, archivo, nota, fecha, estado_taller) VALUES (IDTLR, IDES, URL, NOTA, CURDATE(),'ENTREGADO');

   
END$$

DROP PROCEDURE IF EXISTS `SP_RESGISTRAR_MATERIAL_ARCHIVO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RESGISTRAR_MATERIAL_ARCHIVO` (IN `TITULOMATERIAL` TEXT, IN `IDMATERIAL` INT, IN `URL` VARCHAR(255))   BEGIN
    INSERT INTO detalles_material (titulo,id_material,archivo,estado,fecha)
    VALUES (TITULOMATERIAL,IDMATERIAL,URL,'NUEVO',CURDATE());
END$$

DROP PROCEDURE IF EXISTS `SP_RESGISTRAR_NUEVO_TALLER`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RESGISTRAR_NUEVO_TALLER` (IN `IDPRO` INT, IN `SUBT` VARCHAR(50), IN `DESCP` TEXT, IN `DT` DATE, IN `IDGRADO` INT, IN `URL` VARCHAR(255))   INSERT INTO talleres(id_docente,titulo,descripcion,Fecha,id_grupo,archivo,estado,taller_estado) VALUES (IDPRO,SUBT,DESCP,DT,IDGRADO,URL,'ACTIVO','NO ENTREGADO')$$

DROP PROCEDURE IF EXISTS `SP_RESTABLECER_CONTRA`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_RESTABLECER_CONTRA` (IN `EMAIL` VARCHAR(250), IN `CONTRA` VARCHAR(250))   BEGIN
DECLARE CANTIDAD INT;
SET @CANTIDAD:=(SELECT COUNT(*) FROM usuario WHERE usuario.usu_email=EMAIL);
IF @CANTIDAD>0 THEN
   UPDATE usuario SET
   usuario.usu_contrasena=CONTRA,
    usuario.usu_estatus = 'ACTIVO',
	 usuario.usu_intento=0
   WHERE usuario.usu_email=EMAIL;
   SELECT 1;
ELSE
   SELECT 2;
END IF;
END$$

DROP PROCEDURE IF EXISTS `SP_TRAER_DATOS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_TRAER_DATOS` ()   SELECT
deatlles_cursos.ID,
deatlles_cursos.id_curso,
deatlles_cursos.id_docente,
deatlles_cursos.id_aula
FROM
deatlles_cursos$$

DROP PROCEDURE IF EXISTS `SP_TRAER_NOTIFICACIONES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_TRAER_NOTIFICACIONES` (IN `IDUSU` INT)   SELECT
talleres.titulo,
talleres.Fecha,
CONCAT_WS(' ',docentes.nombre_docente,docentes.apellidos_docente) AS docentes,
talleres.archivo,
grados.aula,
talleres.estado
FROM
talleres
INNER JOIN deatlles_cursos ON talleres.id_grupo = deatlles_cursos.ID
INNER JOIN docentes ON talleres.id_docente = docentes.ID AND deatlles_cursos.id_docente = docentes.ID
INNER JOIN usuario ON docentes.id_usu = usuario.ID
INNER JOIN grados ON deatlles_cursos.id_aula = grados.ID

WHERE usuario.ID = IDUSU  AND grados.`status` = 'ACTIVO'  ORDER BY talleres.Fecha ASC$$

DROP PROCEDURE IF EXISTS `SP_TRAER_NOTIFICACIONES_ESTUDIANTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_TRAER_NOTIFICACIONES_ESTUDIANTES` (IN `IDUSU` INT)   SELECT
		talleres.titulo, 
		talleres.Fecha, 
		CONCAT_WS(' ', docentes.nombre_docente, docentes.apellidos_docente) AS docentes, 
		talleres.archivo, 
		grados.aula, 
		talleres.estado,
		CASE
			WHEN COUNT(detalles_talleres.id_taller) > 1 THEN 'ENTREGADO-REENVIADO'
			ELSE COALESCE(detalles_talleres.estado_taller, 'NO ENTREGADO')
		END AS estado_taller, 
		estudiantes.id_usu AS id_usuario
		
	FROM
		talleres
		INNER JOIN
		deatlles_cursos
		ON 
			talleres.id_grupo = deatlles_cursos.ID
		INNER JOIN
		docentes
		ON 
			talleres.id_docente = docentes.ID AND
			deatlles_cursos.id_docente = docentes.ID
		INNER JOIN
		usuario
		ON 
			docentes.id_usu = usuario.ID
		INNER JOIN
		grados
		ON 
			deatlles_cursos.id_aula = grados.ID
		INNER JOIN
		estudiantes
		ON 
			estudiantes.id_grado = grados.ID
		LEFT JOIN
		detalles_talleres
		ON 
			talleres.ID = detalles_talleres.id_taller AND
			estudiantes.id_usu = detalles_talleres.id_estudiante
	WHERE
		estudiantes.id_usu = IDUSU AND
		grados.status = 'ACTIVO'
	GROUP BY
		talleres.titulo, 
		talleres.Fecha, 
		CONCAT_WS(' ', docentes.nombre_docente, docentes.apellidos_docente), 
		talleres.archivo, 
		grados.aula,
		talleres.estado,
		detalles_talleres.estado_taller,
		estudiantes.id_usu
	ORDER BY
		talleres.Fecha DESC$$

DROP PROCEDURE IF EXISTS `SP_TRAER_NOTIFICACIONES_FORO_DOCENTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_TRAER_NOTIFICACIONES_FORO_DOCENTES` (IN `IDUSUARIO` INT)   SELECT DISTINCT
    foro.titulo, 
    foro.foro_estado, 
    foro.fecha,  
    grados.aula
FROM
    foro
INNER JOIN
    docentes
ON 
    foro.id_docente = docentes.id_usu
INNER JOIN
    deatlles_cursos
ON 
    docentes.ID = deatlles_cursos.id_docente
INNER JOIN
    grados
ON 
    deatlles_cursos.id_aula = grados.ID
INNER JOIN
    estudiantes
ON 
    grados.ID = estudiantes.id_grado
WHERE
    docentes.id_usu = IDUSUARIO$$

DROP PROCEDURE IF EXISTS `SP_TRAER_NOTIFICACIONES_FORO_ESTUDIANTES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_TRAER_NOTIFICACIONES_FORO_ESTUDIANTES` (IN `IDUSUARIO` INT)   SELECT DISTINCT
    foro.titulo, 
    foro.foro_estado, 
    foro.fecha, 
    CONCAT(docentes.nombre_docente, ' ', docentes.apellidos_docente) AS nombre, 
    grados.aula
FROM
    foro
INNER JOIN
    docentes
ON 
    foro.id_docente = docentes.id_usu
INNER JOIN
    deatlles_cursos
ON 
    docentes.ID = deatlles_cursos.id_docente
INNER JOIN
    grados
ON 
    deatlles_cursos.id_aula = grados.ID
INNER JOIN
    estudiantes
ON 
    grados.ID = estudiantes.id_grado
WHERE
    estudiantes.id_usu = IDUSUARIO$$

DROP PROCEDURE IF EXISTS `SP_VERIFICAR_USUARIO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_VERIFICAR_USUARIO` (IN `USU` VARCHAR(50))   BEGIN
    SELECT
        usuario.ID, 
        usuario.usu_nombre, 
        usuario.usu_contrasena, 
        usuario.usu_sexo, 
        usuario.usu_email, 
        usuario.usu_estatus, 
        usuario.id_rol, 
        rol.rol_nombre, 
        rol.ID, 
        usuario.usu_intento, 
        usuario.foto, 
        COALESCE(CONCAT(estudiantes.nombre_estudiante, ' ', estudiantes.apellidos_estudiante), CONCAT(docentes.nombre_docente, ' ', docentes.apellidos_docente)) AS nombre_completo
    FROM
        usuario
    INNER JOIN
        rol
    ON 
        usuario.id_rol = rol.ID
    LEFT JOIN
        estudiantes
    ON 
        usuario.ID = estudiantes.id_usu
    LEFT JOIN
        docentes
    ON 
        usuario.ID = docentes.id_usu
    WHERE
        usuario.usu_nombre = BINARY USU;
END$$

DROP PROCEDURE IF EXISTS `_Navicat_Temp_Stored_Proc`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `_Navicat_Temp_Stored_Proc` (IN `FC` DATE)   UPDATE talleres SET

talleres.`status` = 'INACTIVO'

WHERE talleres.Fecha <= FC$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

DROP TABLE IF EXISTS `asistencias`;
CREATE TABLE IF NOT EXISTS `asistencias` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_estudiante` int DEFAULT NULL,
  `id_grupo` int DEFAULT NULL,
  `asistencia` enum('ASISTIÓ','NO ASISTIÓ') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `dia` enum('LUNES','MARTES','MIÉRCOLES','JUEVES','VIERNES','SÁBADO','DOMINGO') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_estudiante` (`id_estudiante`),
  KEY `id_grupo` (`id_grupo`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencias`
--

INSERT INTO `asistencias` (`ID`, `id_estudiante`, `id_grupo`, `asistencia`, `dia`, `fecha`) VALUES
(1, 3, 1, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(2, 1, 3, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(5, 2, 3, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(24, 5, 3, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(25, 1, 2, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(27, 1, 1, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(30, 4, 3, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(31, 7, 2, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(32, 4, 2, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(33, 2, 1, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(34, 4, 1, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(35, 5, 1, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(36, 7, 1, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(37, 8, 1, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(38, 6, 1, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(39, 2, 2, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(40, 3, 2, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(41, 5, 2, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(42, 6, 2, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(43, 8, 2, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(44, 3, 3, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(45, 6, 3, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(46, 7, 3, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(47, 8, 3, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(48, 4, 4, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(49, 1, 4, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(50, 2, 4, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(51, 3, 4, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(52, 5, 4, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(53, 6, 4, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(54, 7, 4, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(55, 8, 4, 'NO ASISTIÓ', 'VIERNES', '2024-08-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

DROP TABLE IF EXISTS `calificaciones`;
CREATE TABLE IF NOT EXISTS `calificaciones` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_estudiante` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_estudiante` (`id_estudiante`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calificaciones`
--

INSERT INTO `calificaciones` (`ID`, `id_estudiante`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat`
--

DROP TABLE IF EXISTS `chat`;
CREATE TABLE IF NOT EXISTS `chat` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_principal` int DEFAULT NULL,
  `id_segundario` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_principal` (`id_principal`),
  KEY `id_segundario` (`id_segundario`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf32;

--
-- Volcado de datos para la tabla `chat`
--

INSERT INTO `chat` (`ID`, `id_principal`, `id_segundario`) VALUES
(2, 4, 2),
(4, 5, 4),
(5, 5, 5),
(7, 4, 26),
(8, 4, 6),
(9, 2, 5),
(10, 6, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

DROP TABLE IF EXISTS `clases`;
CREATE TABLE IF NOT EXISTS `clases` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_docente` int DEFAULT NULL,
  `id_grupo` int DEFAULT NULL,
  `estado` enum('ACTIVO','INACTIVO') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_docente` (`id_docente`),
  KEY `id_grupo` (`id_grupo`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clases`
--

INSERT INTO `clases` (`ID`, `link`, `id_docente`, `id_grupo`, `estado`, `fecha`) VALUES
(1, 'https://meet.jit.si/vpaas-magic-cookie-c2891bbdaedf4d58aaf01898d2d3651cpx7I8j', 6, 3, 'INACTIVO', '2023-12-20'),
(8, 'https://meet.jit.si/vpaas-magic-cookie-c2891bbdaedf4d58aaf01898d2d3651cpx7I8j', 6, 3, 'INACTIVO', '2024-01-18'),
(9, 'https://meet.jit.si/vpaas-magic-cookie-c2891bbdaedf4d58aaf01898d2d3651cIqmh5x', 6, 3, 'INACTIVO', '2024-02-14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
CREATE TABLE IF NOT EXISTS `comentarios` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_taller` int NOT NULL,
  `id_estudiante` int NOT NULL,
  `comentarios` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `respuesta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `status` enum('RESPONDIDO','NO RESPONDIDO') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_foro` (`id_taller`),
  KEY `id_estudiante` (`id_estudiante`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`ID`, `id_taller`, `id_estudiante`, `comentarios`, `respuesta`, `status`, `fecha`) VALUES
(3, 2, 1, 'Hola profesor, espero que esté bien. Quería informarle que ya he entregado el taller sobre el sistema inmunológico. Sin embargo, debo admitir que hubo algunas partes que me resultaron un poco confusas. Me gustaría pedirle si en la próxima videoconferencia podríamos repasar un poco el tema del taller y aclarar algunas dudas que tengo. Creo que me ayudaría mucho para comprender mejor el contenido. ¿Sería posible?', '\r\n\r\n\r\nHola, gracias por tu mensaje y por informarme que has entregado el taller sobre el sistema inmunológico. Me alegra que estés trabajando en ello.\r\n\r\nPor supuesto, entiendo que a veces los temas pueden resultar un poco complicados. Estaré más que feliz de dedicar tiempo en nuestra próxima videoconferencia para repasar el contenido del taller y aclarar todas las dudas que tengas. Es importante que entiendas bien este tema, ya que es fundamental para el curso.\r\n\r\nPor favor, prepárate con las preguntas o temas específicos que deseas abordar, y así podremos aprovechar al máximo nuestro tiempo juntos. Estoy aquí para ayudarte a comprender y aprender.\r\n\r\nGracias por tu interés y compromiso en mejorar tu comprensión del sistema inmunológico. Nos vemos en la próxima clase virtual.', 'RESPONDIDO', '2023-12-11'),
(4, 2, 1, 'no entendi nada', 'olili', 'RESPONDIDO', '2023-12-11'),
(5, 2, 1, 'no entendi nada', 'dfdggddg', 'RESPONDIDO', '2023-12-11'),
(6, 3, 4, 'dcd', 'ggg', 'RESPONDIDO', '2024-01-17'),
(7, 1, 4, 'hola profe', 'hola carlos', 'RESPONDIDO', '2024-01-17'),
(8, 11, 4, 'Hola profesor, espero que esté bien. Quería disculparme por no haber entregado el taller de ortografía a tiempo. La fecha límite se me pasó por completo entre otras tareas y estoy realmente apenado. ¿Habría alguna posibilidad de que me otorgara un poco más de tiempo para completarlo? Realmente quiero hacerlo bien y sé que con un poco más de tiempo puedo entregar un trabajo de calidad. Gracias de antemano por su consideración.', '\r\nHola, gracias por informarme sobre la situación. Lamento que hayas tenido problemas para cumplir con la fecha límite del taller. Entiendo que a veces las cosas se nos acumulan y el tiempo vuela.\r\n\r\nEn esta ocasión, dado que varios estudiantes también se han visto afectados y no lograron entregar a tiempo, he decidido extender el plazo para todos ustedes. Tendrán una semana adicional para completar el taller de ortografía.\r\n\r\nAprovechen este tiempo extra para revisar con calma y asegurarse de que estén satisfechos con su trabajo. Si tienes alguna otra pregunta o necesitas ayuda, no dudes en escribirme. Estoy aquí para apoyarte en tu aprendizaje.\r\n\r\nGracias por tu mensaje y tu compromiso con el curso.', 'RESPONDIDO', '2024-01-18'),
(9, 11, 5, 'Hola profe, ¿hay mas plazo?', 'Hola, el tiempo ya se paso', 'RESPONDIDO', '2024-02-26'),
(11, 3, 4, 'gggggfrfrf', NULL, 'NO RESPONDIDO', '2024-03-18'),
(12, 11, 4, '333', '2222', 'RESPONDIDO', '2024-03-18'),
(13, 11, 4, 'gato', NULL, 'NO RESPONDIDO', '2024-03-18'),
(14, 11, 4, 'gato', 'ghhhh', 'RESPONDIDO', '2024-03-18'),
(17, 11, 5, 'Hola, profe no entendí muy bien', NULL, 'NO RESPONDIDO', '2024-01-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios_asuntos`
--

DROP TABLE IF EXISTS `comentarios_asuntos`;
CREATE TABLE IF NOT EXISTS `comentarios_asuntos` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_docente` int DEFAULT NULL,
  `id_estudiante` int DEFAULT NULL,
  `asunto` text CHARACTER SET utf32 COLLATE utf32_general_ci,
  `comentario` text,
  `respuesta` text,
  `estado` enum('RESPONDIDO','NO RESPONDIDO') DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_docente` (`id_docente`),
  KEY `id_estudiante` (`id_estudiante`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf32;

--
-- Volcado de datos para la tabla `comentarios_asuntos`
--

INSERT INTO `comentarios_asuntos` (`ID`, `id_docente`, `id_estudiante`, `asunto`, `comentario`, `respuesta`, `estado`, `fecha`) VALUES
(1, 2, 4, 'consulta', 'prueba', NULL, 'NO RESPONDIDO', '2024-04-11'),
(2, 2, 5, 'consulta2', 'prueba2', NULL, 'NO RESPONDIDO', '2024-04-11'),
(3, 2, 4, '2222', '1111', '222', 'RESPONDIDO', '2024-04-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

DROP TABLE IF EXISTS `cursos`;
CREATE TABLE IF NOT EXISTS `cursos` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('ACTIVO','INACTIVO') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_docente` (`nombre`),
  KEY `id_estudiante` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`ID`, `nombre`, `status`) VALUES
(0, 'SIN ASIGNACIÓN', 'ACTIVO'),
(1, 'MATEMATICAS', 'ACTIVO'),
(2, 'ESPAÑOL', 'ACTIVO'),
(3, 'NATURALES', 'ACTIVO'),
(4, 'SOCIALES', 'ACTIVO'),
(5, 'EDUCACIÓN FISICA', 'ACTIVO'),
(6, 'ARTISTICAS', 'ACTIVO'),
(7, 'ALGEBRA', 'ACTIVO'),
(8, 'QUIMICA', 'ACTIVO'),
(9, 'TRIGONOMETRÍA', 'ACTIVO'),
(10, 'INFORMATICA', 'ACTIVO'),
(11, 'FILOSOFIA', 'ACTIVO'),
(12, 'RELIGION', 'ACTIVO'),
(14, 'INGLES', 'ACTIVO'),
(15, 'EMPRENDIMIENTO', 'ACTIVO'),
(16, 'HISTORIA', 'ACTIVO'),
(17, 'GEOGRAFÍA', 'ACTIVO'),
(18, 'ÉTICA', 'ACTIVO'),
(19, 'AFROCOLOMBIANA', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deatlles_cursos`
--

DROP TABLE IF EXISTS `deatlles_cursos`;
CREATE TABLE IF NOT EXISTS `deatlles_cursos` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_curso` int NOT NULL,
  `id_docente` int NOT NULL,
  `id_aula` int NOT NULL,
  `fecha_asignacion` date DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `deatlles_cursos_ibfk_2` (`id_docente`),
  KEY `deatlles_cursos_ibfk_1` (`id_curso`),
  KEY `id_aula` (`id_aula`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `deatlles_cursos`
--

INSERT INTO `deatlles_cursos` (`ID`, `id_curso`, `id_docente`, `id_aula`, `fecha_asignacion`) VALUES
(1, 1, 6, 1, '2023-11-09'),
(2, 2, 6, 1, '2023-11-19'),
(3, 3, 6, 1, '2023-12-05'),
(4, 14, 2, 1, '2024-05-19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_calificaciones`
--

DROP TABLE IF EXISTS `detalles_calificaciones`;
CREATE TABLE IF NOT EXISTS `detalles_calificaciones` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_claificaciones` int DEFAULT NULL,
  `id_docente` int DEFAULT NULL,
  `id_grupo` int DEFAULT NULL,
  `nota_1` float NOT NULL,
  `nota_2` float NOT NULL,
  `nota_3` float NOT NULL,
  `nota_4` float NOT NULL,
  `nota_def` float NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_claificaciones` (`id_claificaciones`),
  KEY `id_docente` (`id_docente`),
  KEY `id_grupo` (`id_grupo`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_calificaciones`
--

INSERT INTO `detalles_calificaciones` (`ID`, `id_claificaciones`, `id_docente`, `id_grupo`, `nota_1`, `nota_2`, `nota_3`, `nota_4`, `nota_def`) VALUES
(1, 3, 6, 1, 3, 4, 3, 2.5, 3.125),
(2, 1, 6, 3, 4, 5, 3, 4.2, 4.05),
(3, 2, 6, 3, 3, 4, 4, 3, 3.5),
(4, 5, 6, 3, 5, 4.5, 4, 3, 4.125),
(5, 1, 6, 2, 4, 4, 3, 4.5, 3.875),
(21, 1, 6, 1, 4.5, 2.5, 3.5, 3.8, 3.575),
(24, 4, 6, 3, 3, 4.5, 4, 3.5, 3.75),
(25, 7, 6, 2, 4.5, 4, 3.5, 4.2, 4.05),
(26, 4, 6, 2, 2, 3, 2.5, 4, 2.875),
(27, 2, 6, 1, 3, 4.7, 3.9, 4, 3.9),
(28, 4, 6, 1, 3.4, 3.6, 4.1, 3, 3.525),
(29, 5, 6, 1, 4.6, 4, 4.1, 3, 3.925),
(30, 7, 6, 1, 3.2, 3.1, 3.5, 4.5, 3.575),
(31, 8, 6, 1, 2.8, 3.5, 2.5, 2.5, 2.825),
(32, 6, 6, 1, 4.6, 4.9, 5, 4.1, 4.65),
(33, 2, 6, 2, 2.8, 2.3, 4.5, 3.1, 3.175),
(34, 3, 6, 2, 4, 3.5, 4.5, 3.1, 3.775),
(35, 5, 6, 2, 3.9, 0, 0, 0, 0.975),
(36, 6, 6, 2, 0, 0, 0, 0, 0),
(37, 8, 6, 2, 0, 0, 0, 0, 0),
(38, 3, 6, 3, 0, 0, 0, 0, 0),
(39, 6, 6, 3, 0, 0, 0, 0, 0),
(40, 7, 6, 3, 0, 0, 0, 0, 0),
(41, 8, 6, 3, 0, 0, 0, 0, 0),
(42, 4, 2, 4, 0, 0, 0, 0, 0),
(43, 1, 2, 4, 0, 0, 0, 0, 0),
(44, 2, 2, 4, 0, 0, 0, 0, 0),
(45, 3, 2, 4, 0, 0, 0, 0, 0),
(46, 5, 2, 4, 0, 0, 0, 0, 0),
(47, 6, 2, 4, 0, 0, 0, 0, 0),
(48, 7, 2, 4, 0, 0, 0, 0, 0),
(49, 8, 2, 4, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_chat`
--

DROP TABLE IF EXISTS `detalles_chat`;
CREATE TABLE IF NOT EXISTS `detalles_chat` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Id_chat` int DEFAULT NULL,
  `id_comentario` int DEFAULT NULL,
  `Comentario` text,
  `Fecha` datetime DEFAULT NULL,
  `Estado` enum('ABIERTO','NO VISTO','VISTO') CHARACTER SET utf32 COLLATE utf32_general_ci DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Id_chat` (`Id_chat`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf32;

--
-- Volcado de datos para la tabla `detalles_chat`
--

INSERT INTO `detalles_chat` (`ID`, `Id_chat`, `id_comentario`, `Comentario`, `Fecha`, `Estado`, `archivo`) VALUES
(1, 4, 4, 'Hola amigo', '2024-04-21 20:12:15', 'VISTO', NULL),
(2, 4, 5, 'Hola amigo, ¿como estas?', '2024-04-21 20:13:21', 'VISTO', NULL),
(3, 2, 4, 'Hola', '2024-04-24 15:11:13', 'VISTO', NULL),
(6, 2, 2, 'Hola Carlos', '2024-04-24 15:15:03', 'VISTO', NULL),
(7, 2, 4, 'Profe, tengo dudas sobre el taller de la células', '2024-04-24 15:16:30', 'VISTO', NULL),
(8, 2, 2, 'Si, ¿dime que quieres saber?', '2024-04-24 15:19:13', 'VISTO', NULL),
(9, 2, 4, '¿Cual es la diferencia entre la celula vegetal y animal?', '2024-04-24 15:32:26', 'VISTO', NULL),
(10, 2, 2, 'Pared celular: Las células vegetales tienen una pared celular de celulosa que les proporciona soporte, mientras que las células animales carecen de ella.\nCloroplastos: Presentes solo en células vegetales, los cloroplastos realizan la fotosíntesis.\nVacuolas: Las células vegetales tienen grandes vacuolas para almacenar agua y nutrientes, mientras que las células animales tienen vacuolas más pequeñas o ninguna.\nForma y tamaño: Las células vegetales son generalmente más grandes y tienen formas más definidas que las células animales.\nCentríolos y lisosomas: Presentes en células animales, pero raras en células vegetales, los centríolos ayudan en la división celular, mientras que los lisosomas digieren materiales celulares.', '2024-04-24 15:38:13', 'VISTO', NULL),
(11, 2, 4, 'Gracias profe', '2024-04-24 15:41:38', 'VISTO', NULL),
(12, 2, 2, 'De nada Carlos', '2024-04-24 15:53:55', 'VISTO', NULL),
(13, 2, 4, 'Profe, tengo mas dudas', '2024-04-24 15:55:05', 'VISTO', NULL),
(14, 2, 2, 'Si, Carlos', '2024-04-24 15:58:40', 'VISTO', NULL),
(15, 9, 2, 'Hola jose', '2024-04-24 18:56:32', 'NO VISTO', NULL),
(16, 9, 5, 'Hola profe', '2024-04-24 18:59:27', 'VISTO', NULL),
(17, 9, 2, 'Te escribo para decirte que en español sacaste como nota definitiva 3.175', '2024-04-24 19:07:14', 'VISTO', NULL),
(18, 9, 2, 'Es una nota muy baja y quiero que mejores', '2024-04-24 19:07:31', 'VISTO', NULL),
(19, 10, 6, 'Hola', '2024-04-26 21:09:56', 'VISTO', NULL),
(20, 8, 6, 'Hola Carlos', '2024-04-26 21:10:33', 'VISTO', NULL),
(21, 4, 4, 'Estoy bien amigo', '2024-04-27 11:10:54', 'VISTO', NULL),
(22, 4, 5, 'hola', '2024-04-27 15:38:11', 'VISTO', NULL),
(23, 4, 5, 'Hola Hola', '2024-04-27 15:44:14', 'VISTO', NULL),
(24, 4, 4, 'hola hola hola', '2024-04-27 15:49:52', 'VISTO', NULL),
(30, 4, 4, '4444444', '2024-05-07 19:01:25', 'VISTO', 'controlador/chat/archivo/jnihp_7520241683.pdf'),
(31, 4, 4, 'ddd', '2024-05-07 19:01:59', 'VISTO', 'controlador/chat/archivo/oswfss_752024158.jpg'),
(33, 4, 4, 'prueba 3', '2024-05-07 21:55:57', 'VISTO', 'controlador/chat/archivo/qk9fc_75202455751.jpg'),
(36, 2, 4, 'prueba imagen', '2024-05-08 13:25:47', 'VISTO', 'controlador/chat/archivo/qllu0a_85202425484.jpg'),
(37, 4, 4, 'prueba gif', '2024-05-09 14:51:16', 'VISTO', 'controlador/chat/archivo/t5e908_95202451563.gif'),
(38, 4, 4, 'prueba', '2024-05-09 15:49:57', 'VISTO', 'controlador/chat/archivo/49c0lg_95202449626.png'),
(39, 8, 4, 'Hola Yuliana', '2024-05-12 12:12:21', 'NO VISTO', NULL),
(65, 2, 2, 'hola', '2024-05-13 19:31:12', 'VISTO', NULL),
(66, 2, 2, 'hola', '2024-05-13 19:31:28', 'VISTO', NULL),
(67, 2, 2, '', '2024-05-13 19:32:08', 'VISTO', 'controlador/chat/archivo/a18jgo_135202432655.png'),
(68, 2, 2, '', '2024-05-13 20:09:40', 'VISTO', 'controlador/chat/archivo/qj38o_13520249661.pdf'),
(69, 2, 2, 'HOLA', '2024-05-13 20:11:17', 'VISTO', NULL),
(70, 2, 2, 'HOLA2', '2024-05-13 20:11:30', 'VISTO', NULL),
(71, 4, 4, '', '2024-05-20 09:58:34', 'NO VISTO', 'controlador/chat/archivo/nzprvo_205202458439.jpg'),
(72, 2, 4, 'hola', '2024-05-28 11:51:14', 'VISTO', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_comentarios`
--

DROP TABLE IF EXISTS `detalles_comentarios`;
CREATE TABLE IF NOT EXISTS `detalles_comentarios` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_comentario` int NOT NULL,
  `id_docente` int NOT NULL,
  `respuesta` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_comentario` (`id_comentario`),
  KEY `id_docente` (`id_docente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_foro`
--

DROP TABLE IF EXISTS `detalles_foro`;
CREATE TABLE IF NOT EXISTS `detalles_foro` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_foro` int NOT NULL,
  `id_grupo` int NOT NULL,
  `id_comentario` int NOT NULL,
  `comentario` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_foro` (`id_foro`),
  KEY `id_comentario` (`id_comentario`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_foro`
--

INSERT INTO `detalles_foro` (`ID`, `id_foro`, `id_grupo`, `id_comentario`, `comentario`, `fecha`) VALUES
(1, 1, 3, 4, 'Hola a todos,\nPara mí, lo más intrigante de la célula animal es su capacidad para realizar una variedad de funciones especializadas, como las contracciones musculares o la transmisión de impulsos nerviosos. Respecto a la célula vegetal, creo que su papel en la fotosíntesis y la producción de oxígeno es esencial para mantener el equilibrio en nuestros ecosistemas. En cuanto a sus beneficios, pienso que entender estas células puede llevar a avances en medicina y agricultura, como el desarrollo de tratamientos y cultivos más eficientes. ¡Saludos!', '2024-03-14'),
(2, 1, 3, 5, 'Hola a todos,\r\nLo que más me intriga de la célula animal es su diversidad estructural, desde las células musculares hasta las células nerviosas con sus prolongaciones y conexiones tan especializadas. En cuanto a la célula vegetal, destaco su habilidad para producir su propio alimento mediante la fotosíntesis y su contribución vital a la cadena alimentaria. Creo firmemente que el estudio de estas células puede abrir puertas a avances en medicina regenerativa y técnicas agrícolas más sostenibles.\r\n¡Un saludo a todos!', '2024-03-01'),
(6, 2, 2, 4, 'Hola a todos,\r\nPara mí, la importancia de la gramática en español radica en su capacidad para estructurar nuestras ideas de manera clara y coherente. Sin las reglas gramaticales, nuestras palabras podrían perder su significado o ser malinterpretadas. Además, una gramática sólida nos ayuda a transmitir nuestras ideas con precisión y a mejorar nuestra comunicación en general.\r\n¡Saludos!', '2024-03-13'),
(7, 2, 2, 5, 'Hola compañeros,\r\nCoincido con lo que mencionó mi compañero. La gramática en español es como el marco que sostiene nuestras palabras, asegurando que nuestras expresiones sean comprensibles y efectivas. Es el pilar de una comunicación exitosa, tanto en la escritura como en la conversación, y nos permite expresarnos con claridad y elegancia.\r\n¡Un saludo a todos!', '2024-03-21'),
(8, 2, 2, 7, 'Hola a todos,\r\nAñadiría que la gramática en español también nos permite apreciar la riqueza y la belleza del idioma. Cuando entendemos y aplicamos las reglas gramaticales, podemos jugar con las palabras de manera creativa y utilizar recursos lingüísticos para enriquecer nuestros escritos y discursos. Así, la gramática no solo es una herramienta práctica, sino también una puerta hacia la expresión artística y el disfrute del español.\r\n¡Saludos cordiales!', '2024-03-11'),
(9, 1, 3, 2, '¡Felicidades, estudiantes! Sus respuestas muestran una comprensión profunda y un aprecio por la complejidad y la importancia de las células vegetales y animales en nuestro mundo. Es fascinante ver cómo cada uno destaca aspectos clave de estas células y reconoce su papel fundamental en los ecosistemas y en los avances científicos. Sigamos explorando juntos este fascinante tema y aprovechando nuestras reflexiones para enriquecer nuestro conocimiento. ¡Gracias por sus valiosas contribuciones al foro!', '2024-03-17'),
(10, 2, 2, 2, '¡Excelentes respuestas, estudiantes! Han captado perfectamente la importancia crucial de la gramática en español. Es fundamental para la claridad, la coherencia y la efectividad en nuestras comunicaciones escritas y orales. Sigamos valorando y aplicando estas reglas gramaticales para mejorar nuestra habilidad de expresión en el idioma español. ¡Gracias por sus valiosas contribuciones al foro!', '2024-03-17'),
(33, 3, 1, 2, 'ohohoh, ohohoho, ohohohoc', '2024-03-25'),
(46, 3, 1, 4, 'ddddd', '2024-03-26'),
(54, 5, 2, 2, 'hola', '2024-04-04'),
(69, 3, 1, 4, 'ddd', '2024-04-10'),
(75, 5, 2, 5, 'hola a todos', '2024-04-16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_foro_respuesta`
--

DROP TABLE IF EXISTS `detalles_foro_respuesta`;
CREATE TABLE IF NOT EXISTS `detalles_foro_respuesta` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_foro` int NOT NULL,
  `id_respuesta` int NOT NULL,
  `id_comentario_principal` int NOT NULL,
  `comentario_respuesta` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `fecha_respuesta` date DEFAULT NULL,
  `reponde_a` int DEFAULT NULL,
  `id_responde_a` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_comentario_principal` (`id_comentario_principal`),
  KEY `id_foro_respuesta` (`id_foro`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `detalles_foro_respuesta`
--

INSERT INTO `detalles_foro_respuesta` (`ID`, `id_foro`, `id_respuesta`, `id_comentario_principal`, `comentario_respuesta`, `fecha_respuesta`, `reponde_a`, `id_responde_a`) VALUES
(1, 1, 5, 1, '¡Hola! Estoy totalmente de acuerdo contigo. La versatilidad de las células animales para llevar a cabo diversas funciones es realmente fascinante. Además, la importancia de las células vegetales en la fotosíntesis y la producción de oxígeno es fundamental para todos los seres vivos en la Tierra. Creo que entender a fondo estas células puede abrir puertas a descubrimientos increíbles en diferentes campos científicos. ¿Alguien más tiene algo que agregar a esta interesante discusión? ¡Saludos!', '2024-04-05', 4, 4),
(2, 1, 2, 1, 'Quiero felicitar especialmente a José Parra Martínez por su excelente contribución a nuestra discusión sobre las células animales y vegetales. José, tus puntos sobre las funciones especializadas de las células animales y la importancia de las células vegetales en la fotosíntesis son realmente perspicaces y bien expresados.', '2024-04-06', 5, 5),
(3, 1, 2, 2, 'agrego', '2024-04-07', 5, 2),
(6, 1, 2, 2, 'ddd', '2024-04-09', NULL, 5),
(8, 3, 2, 46, 'ssssddd', '2024-04-09', NULL, 4),
(9, 1, 2, 2, 'sss', '2024-04-09', NULL, 5),
(12, 3, 2, 46, 'ssss', '2024-04-09', NULL, 4),
(13, 3, 2, 46, 'saa', '2024-04-09', NULL, 4),
(14, 3, 2, 46, 'agrego2dddeee', '2024-04-09', NULL, 2),
(15, 3, 2, 33, 'prueba', '2024-04-09', NULL, 2),
(16, 3, 2, 33, 'prDD', '2024-04-09', NULL, 2),
(21, 3, 4, 69, 'dddsss', '2024-04-10', NULL, 4),
(22, 5, 4, 54, 'Hola profesor', '2024-04-11', NULL, 2),
(24, 5, 2, 54, 'hola carlos', '2024-04-16', NULL, 4),
(25, 5, 2, 54, 's', '2024-04-16', NULL, 2),
(26, 5, 5, 54, 'hola profe', '2024-04-16', NULL, 2),
(28, 1, 4, 1, 'Gracias compañero 22', '2024-05-27', NULL, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_material`
--

DROP TABLE IF EXISTS `detalles_material`;
CREATE TABLE IF NOT EXISTS `detalles_material` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_material` int NOT NULL,
  `titulo` text,
  `estado` enum('NUEVO','') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT '',
  `archivo` varchar(255) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_material` (`id_material`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `detalles_material`
--

INSERT INTO `detalles_material` (`ID`, `id_material`, `titulo`, `estado`, `archivo`, `fecha`) VALUES
(1, 1, 'Ortografía', '', 'controlador/material/archivo/Ortografía283202445844.pdf', '2024-05-08'),
(2, 1, 'Singular, Plural y Tercera Persona', '', 'controlador/material/archivo/Actividad_ Singular, Plural y Tercera Persona 28320245110.pdf', '2024-05-19'),
(6, 1, 'titulo222', '', 'controlador/material/archivo/l7jk9nm_125202456514.pdf', '2024-05-19'),
(7, 1, 'PRUEBA ', '', 'controlador/material/archivo/28q9gk_12520242010.pdf', '2024-05-18'),
(23, 8, 'Verbo to be', '', 'controlador/material/archivo/ersd9s_19520245185.pdf', '2024-05-19'),
(24, 6, 'Notas', '', 'controlador/material/archivo/mwdn99_295202444891.xlsx', '2024-05-29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_sistencias`
--

DROP TABLE IF EXISTS `detalles_sistencias`;
CREATE TABLE IF NOT EXISTS `detalles_sistencias` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_asistencia` int NOT NULL,
  `id_docente` int DEFAULT NULL,
  `asistencia` enum('ASISTIÓ','NO ASISTIÓ') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `dia` enum('LUNES','MARTES','MIÉRCOLES','JUEVES','VIERNES') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `detalles_sistencias_ibfk_2` (`id_asistencia`),
  KEY `id_docente` (`id_docente`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_sistencias`
--

INSERT INTO `detalles_sistencias` (`ID`, `id_asistencia`, `id_docente`, `asistencia`, `dia`, `fecha`) VALUES
(30, 2, 6, 'NO ASISTIÓ', 'VIERNES', '2024-01-19'),
(31, 5, 6, 'ASISTIÓ', 'LUNES', '2024-01-19'),
(33, 5, 6, 'ASISTIÓ', 'LUNES', '2024-01-18'),
(36, 2, 6, 'ASISTIÓ', 'LUNES', '2024-01-22'),
(37, 2, 6, 'NO ASISTIÓ', 'MARTES', '2024-01-23'),
(38, 25, 6, 'ASISTIÓ', 'MARTES', '2024-01-20'),
(39, 27, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-01-20'),
(40, 24, 6, 'NO ASISTIÓ', 'MARTES', '2024-01-20'),
(42, 24, 6, 'ASISTIÓ', 'MARTES', '2024-01-20'),
(43, 24, 6, 'NO ASISTIÓ', 'MIÉRCOLES', '2024-01-20'),
(44, 30, 6, 'NO ASISTIÓ', 'MARTES', '2024-01-20'),
(45, 1, 6, 'ASISTIÓ', 'LUNES', '2024-01-27'),
(46, 30, 6, 'NO ASISTIÓ', 'MIÉRCOLES', '2024-01-27'),
(47, 2, 6, 'ASISTIÓ', 'LUNES', '2024-01-29'),
(48, 2, 6, 'ASISTIÓ', 'MARTES', '2024-01-30'),
(49, 5, 6, 'ASISTIÓ', 'LUNES', '2024-01-29'),
(50, 24, 6, 'NO ASISTIÓ', 'LUNES', '2024-01-29'),
(51, 30, 6, 'ASISTIÓ', 'LUNES', '2024-01-29'),
(52, 5, 6, 'ASISTIÓ', 'MARTES', '2024-01-30'),
(53, 24, 6, 'NO ASISTIÓ', 'MARTES', '2024-01-30'),
(54, 30, 6, 'ASISTIÓ', 'MARTES', '2024-01-30'),
(55, 32, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-01-31'),
(56, 1, 6, 'ASISTIÓ', 'MARTES', '2024-02-27'),
(57, 27, 6, 'ASISTIÓ', 'JUEVES', '2024-02-29'),
(58, 27, 6, 'NO ASISTIÓ', 'JUEVES', '2024-02-29'),
(59, 27, 6, 'ASISTIÓ', 'MARTES', '2024-02-29'),
(60, 1, 6, 'ASISTIÓ', 'MARTES', '2024-02-29'),
(61, 1, 6, 'NO ASISTIÓ', 'MARTES', '2024-02-29'),
(62, 1, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-02-29'),
(63, 27, 6, 'NO ASISTIÓ', 'VIERNES', '2024-02-29'),
(64, 1, 6, 'ASISTIÓ', 'VIERNES', '2024-02-29'),
(65, 31, 6, 'ASISTIÓ', 'LUNES', '2024-02-29'),
(66, 1, 6, 'ASISTIÓ', 'JUEVES', '2024-02-29'),
(67, 25, 6, 'ASISTIÓ', 'LUNES', '2024-02-29'),
(68, 25, 6, 'NO ASISTIÓ', 'LUNES', '2024-02-29'),
(70, 5, 6, 'NO ASISTIÓ', 'LUNES', '2024-02-29'),
(72, 27, 6, 'ASISTIÓ', 'VIERNES', '2024-02-29'),
(76, 27, 6, 'NO ASISTIÓ', 'MARTES', '2024-02-29'),
(77, 27, 6, 'NO ASISTIÓ', 'MARTES', '2024-02-29'),
(78, 27, 6, 'NO ASISTIÓ', 'MARTES', '2024-02-29'),
(79, 1, 6, 'ASISTIÓ', 'LUNES', '2024-02-29'),
(80, 32, 6, 'NO ASISTIÓ', 'MIÉRCOLES', '2024-02-29'),
(81, 32, 6, 'NO ASISTIÓ', 'LUNES', '2024-02-29'),
(82, 32, 6, 'NO ASISTIÓ', 'VIERNES', '2024-02-29'),
(83, 27, 6, 'ASISTIÓ', 'VIERNES', '2024-03-01'),
(84, 1, 6, 'NO ASISTIÓ', 'VIERNES', '2024-03-01'),
(85, 1, 6, 'ASISTIÓ', 'VIERNES', '2024-03-01'),
(86, 27, 6, '', '', '2024-03-01'),
(87, 30, 6, 'NO ASISTIÓ', 'LUNES', '2024-03-30'),
(88, 32, 6, 'NO ASISTIÓ', 'LUNES', '2024-03-30'),
(89, 1, 6, 'ASISTIÓ', 'LUNES', '2024-02-12'),
(90, 27, 6, 'ASISTIÓ', 'LUNES', '2024-02-12'),
(91, 33, 6, 'ASISTIÓ', 'LUNES', '2024-02-12'),
(92, 34, 6, 'ASISTIÓ', 'LUNES', '2024-02-12'),
(93, 35, 6, 'ASISTIÓ', 'LUNES', '2024-02-12'),
(94, 36, 6, 'ASISTIÓ', 'LUNES', '2024-02-12'),
(95, 37, 6, 'ASISTIÓ', 'LUNES', '2024-02-12'),
(96, 38, 6, 'ASISTIÓ', 'LUNES', '2024-02-12'),
(97, 1, 6, 'ASISTIÓ', 'JUEVES', '2024-04-04'),
(121, 1, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(122, 34, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(123, 27, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(124, 37, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(125, 38, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(126, 33, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(127, 36, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(128, 35, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(129, 25, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(130, 31, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(131, 39, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(132, 40, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(133, 42, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(134, 41, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(135, 32, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(136, 43, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(137, 2, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(138, 5, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(139, 24, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(140, 44, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(141, 30, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(142, 47, 6, 'NO ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(143, 45, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(144, 46, 6, 'NO ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(145, 35, 6, 'NO ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(146, 34, 6, 'NO ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(147, 37, 6, 'NO ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(148, 36, 6, 'NO ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(149, 38, 6, 'NO ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(150, 33, 6, 'NO ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(151, 27, 6, 'NO ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(152, 1, 6, 'NO ASISTIÓ', 'MIÉRCOLES', '2024-04-10'),
(153, 35, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-05-29'),
(154, 37, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-05-29'),
(155, 38, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-05-29'),
(156, 33, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-05-29'),
(157, 34, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-05-29'),
(158, 1, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-05-29'),
(159, 27, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-05-29'),
(160, 36, 6, 'ASISTIÓ', 'MIÉRCOLES', '2024-05-29'),
(161, 34, 6, 'ASISTIÓ', 'JUEVES', '2024-05-30'),
(162, 35, 6, 'ASISTIÓ', 'JUEVES', '2024-05-30'),
(163, 27, 6, 'ASISTIÓ', 'JUEVES', '2024-05-30'),
(164, 33, 6, 'ASISTIÓ', 'JUEVES', '2024-05-30'),
(165, 36, 6, 'ASISTIÓ', 'JUEVES', '2024-05-30'),
(166, 38, 6, 'NO ASISTIÓ', 'JUEVES', '2024-05-30'),
(167, 1, 6, 'NO ASISTIÓ', 'JUEVES', '2024-05-30'),
(168, 37, 6, 'ASISTIÓ', 'JUEVES', '2024-05-30'),
(169, 36, 6, 'NO ASISTIÓ', 'VIERNES', '2024-06-07'),
(170, 38, 6, 'ASISTIÓ', 'VIERNES', '2024-06-07'),
(171, 27, 6, 'ASISTIÓ', 'VIERNES', '2024-06-07'),
(172, 35, 6, 'ASISTIÓ', 'VIERNES', '2024-06-07'),
(173, 33, 6, 'ASISTIÓ', 'VIERNES', '2024-06-07'),
(174, 37, 6, 'ASISTIÓ', 'VIERNES', '2024-06-07'),
(175, 1, 6, 'ASISTIÓ', 'VIERNES', '2024-06-07'),
(176, 34, 6, 'ASISTIÓ', 'VIERNES', '2024-06-07'),
(177, 35, 6, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(178, 27, 6, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(179, 34, 6, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(180, 33, 6, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(181, 1, 6, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(182, 36, 6, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(183, 37, 6, 'NO ASISTIÓ', 'VIERNES', '2024-08-02'),
(184, 38, 6, 'NO ASISTIÓ', 'VIERNES', '2024-08-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_talleres`
--

DROP TABLE IF EXISTS `detalles_talleres`;
CREATE TABLE IF NOT EXISTS `detalles_talleres` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_taller` int NOT NULL,
  `id_estudiante` int NOT NULL,
  `archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` date DEFAULT NULL,
  `estado_taller` enum('ENTREGADO','NO ENTREGADO') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nota` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `nota_docente` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`ID`),
  KEY `id_estudiante` (`id_estudiante`),
  KEY `id_taller` (`id_taller`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalles_talleres`
--

INSERT INTO `detalles_talleres` (`ID`, `id_taller`, `id_estudiante`, `archivo`, `fecha`, `estado_taller`, `nota`, `nota_docente`) VALUES
(3, 1, 4, 'controlador/talleres/archivo/Solicitud niveles de ingles.pdf', '2023-12-17', 'ENTREGADO', 'prueba', 'si'),
(40, 3, 4, 'controlador/talleres/archivo/cromosoma181202444148.pdf', '2024-01-18', 'ENTREGADO', 'prueba', 'si'),
(56, 2, 4, 'controlador/talleres/archivo/sistema inmulogico19120246958.pdf', '2024-01-19', 'ENTREGADO', 'prueba', 'si'),
(57, 3, 4, 'controlador/talleres/archivo/cromosoma191202418345.pdf', '2024-01-19', 'ENTREGADO', 'prueba', 'si'),
(58, 1, 4, 'controlador/talleres/archivo/celula191202419343.pdf', '2024-01-19', 'ENTREGADO', 'prueba', 'si'),
(59, 3, 4, 'controlador/talleres/archivo/cromosoma191202434777.pdf', '2024-01-19', 'ENTREGADO', 'prueba', 'si'),
(60, 11, 5, 'controlador/talleres/archivo/Ortografia13202433590.pdf', '2024-03-01', 'ENTREGADO', 'prueba', 'si'),
(62, 4, 5, 'controlador/talleres/archivo/esqueleto humano13202438794.pdf', '2024-03-01', 'ENTREGADO', 'prueba', 'si'),
(63, 4, 5, 'controlador/talleres/archivo/esqueleto humano13202457771.pdf', '2024-03-01', 'ENTREGADO', 'prueba', 'dddd'),
(64, 11, 4, 'controlador/talleres/archivo/Ortografia93202429806.pdf', '2024-03-09', 'ENTREGADO', 'prueba', ''),
(65, 4, 4, 'controlador/talleres/archivo/esqueleto humano93202438104.pdf', '2024-03-09', 'ENTREGADO', 'prueba', 'Hola, mandaste un archivo incorrecto, reenviamelo'),
(70, 12, 4, 'controlador/talleres/archivo/Actividad_ Singular_ Plural y Tercera Persona 293202436941.pdf', '2024-03-29', 'ENTREGADO', '', '¡Hola Carlos Mena Ramirez! ¡Felicidades por tus respuestas! ¡Tienes 7 respuestas correctas! Sin embargo, siempre hay oportunidad de aprender más. A continuación, te daré algunas observaciones para que sigas mejorando:\n\nSingular: El pájaro canta en la mañana.\n\nRespuesta: A) Singular\nPlural: Las flores son hermosas en primavera.\n\nRespuesta: B) Plural\nSingular: Mi hermana lee cuentos todas las noches.\n\nRespuesta: A) Singular\nPlural: Los estudiantes estudian para el examen.\n\nRespuesta: B) Plural\nSingular: El perro ladra cuando ve a un extraño.\n\nRespuesta: A) Singular\nPlural: Los amigos van al cine los viernes.\n\nRespuesta: B) Plural\nSingular: Mi abuelo cocina deliciosos pasteles.\n\nRespuesta: A) Singular\nPlural: Las abejas trabajan duro para hacer miel.\n\nRespuesta: B) Plural\nSingular: El libro está en la mesa.\n\nRespuesta: A) Singular\nPlural: Los niños tienen juguetes nuevos.\n\nRespuesta: B) Plural\n'),
(71, 1, 4, 'controlador/talleres/archivo/celula29320249585.pdf', '2024-03-29', 'ENTREGADO', 'gato', 'ok'),
(72, 12, 4, 'controlador/talleres/archivo/Actividad_ Singular_ Plural y Tercera Persona 7520248484.pdf', '2024-05-07', 'ENTREGADO', 'ssss', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

DROP TABLE IF EXISTS `docentes`;
CREATE TABLE IF NOT EXISTS `docentes` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nombre_docente` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos_docente` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `telefono` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nm_documento` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_usu` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_usu` (`id_usu`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`ID`, `nombre_docente`, `apellidos_docente`, `fecha_nacimiento`, `telefono`, `nm_documento`, `id_usu`) VALUES
(1, 'miguel', 'gonzales martinez', '1990-08-03', '3124545', '54514554', 23),
(2, 'Yurani', 'MosqueraMena', '1895-12-12', '554664333', '64664433', 3),
(4, 'juan', 'ruiz urtado', '2023-07-16', '3124555', '107745', 21),
(5, 'pedro', 'pascual ', '1992-09-05', '3124555', '1077451', 22),
(6, 'Cristian', 'Blandon', '1997-07-16', '311456', '123456', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

DROP TABLE IF EXISTS `estudiantes`;
CREATE TABLE IF NOT EXISTS `estudiantes` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `nombre_estudiante` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `apellidos_estudiante` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nm_documento` char(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `id_grado` int NOT NULL,
  `id_usu` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_usu` (`id_usu`),
  KEY `nombre` (`nombre_estudiante`),
  KEY `id_grado` (`id_grado`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`ID`, `nombre_estudiante`, `apellidos_estudiante`, `telefono`, `nm_documento`, `fecha_nacimiento`, `id_grado`, `id_usu`) VALUES
(1, 'Kevin', 'José Mena', '3345544', '323232233', '2010-06-11', 1, 10),
(2, 'Jose', 'Parra Martinez', '32155444', '54554233', '2013-07-13', 1, 5),
(3, 'Yuliana María', 'Mosquera Mena', '5454534', '54543443', '2013-01-22', 1, 6),
(4, 'Carlos', 'Mena Ramirez', '5466644', '6464644', '2012-05-03', 1, 4),
(5, 'Yesica Tatiana', 'Córdoba', '64665544', '545455333', '2010-06-15', 1, 8),
(6, 'Roberto', 'Lagarejo Chavez', '64544444', '545434434', '2012-12-03', 1, 9),
(7, 'Luisa', 'Natalia Pérez', '54546544', '5485444', '2010-06-02', 1, 7),
(8, 'Camilo', 'Andrés Sánchez', '3124555', '10774544', '2011-07-21', 1, 26);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foro`
--

DROP TABLE IF EXISTS `foro`;
CREATE TABLE IF NOT EXISTS `foro` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_docente` int NOT NULL,
  `id_grupo` int NOT NULL,
  `titulo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `descripcion` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci,
  `foro_estado` enum('ACTIVO','INACTIVO') CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `fecha` date NOT NULL,
  `fecha_foro` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`),
  KEY `id_grupo` (`id_grupo`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `foro`
--

INSERT INTO `foro` (`ID`, `id_docente`, `id_grupo`, `titulo`, `descripcion`, `foro_estado`, `fecha`, `fecha_foro`) VALUES
(1, 2, 3, 'Célula Vegetal y Animal', 'Hola a todos, En este foro, nos enfocaremos en las células vegetales y animales. ¿Qué les parece más fascinante de la célula animal? ¿Y qué opinan sobre las funciones clave de la célula vegetal en nuestros ecosistemas? Además, ¿cómo creen que el estudio de estas células puede beneficiar la medicina, la agricultura y la conservación del medio ambiente? ¡Espero sus participaciones!', 'INACTIVO', '2024-06-13', '2024-08-02 00:27:30'),
(2, 2, 2, 'Importancia de la Gramática en Español', 'Buenos días, clase. \n\nHoy vamos a adentrarnos en un tema fundamental: la importancia de la gramática en nuestro idioma español. ¿Alguien puede comentar por qué es crucial entender y aplicar las reglas gramaticales en nuestras comunicaciones escritas y orales? La gramática no solo nos brinda las herramientas para estructurar nuestras ideas de manera clara y coherente, sino que también nos permite transmitir con precisión nuestras intenciones. \n\nEs el marco que sostiene el significado de nuestras palabras, asegurando que nuestras expresiones sean efectivas y comprensibles para quienes nos escuchan o leen. Así que, ¿quiénes desean compartir cómo la gramática influye en nuestra capacidad para comunicarnos de manera efectiva en español?', 'INACTIVO', '2024-05-24', '2024-05-27 19:46:18'),
(3, 2, 1, 'm2CCC', 'mm2CCC', 'INACTIVO', '2024-06-18', '2024-08-02 00:27:30'),
(4, 2, 1, 'r22', 'rr22', 'INACTIVO', '2024-03-29', '2024-03-30 15:12:23'),
(5, 2, 2, 'Uso adecuado del singular, plural y tercera persona', '¡Saludos a todos!\n\nHoy quiero iniciar una discusión muy importante sobre el uso correcto del singular, plural y la tercera persona en nuestros escritos. Como saben, estos elementos gramaticales son fundamentales para la claridad y coherencia en la comunicación escrita.\n\nAquí está la pregunta para todos ustedes:\n\nPregunta: ¿Cuál es la importancia de utilizar correctamente el singular, el plural y la tercera persona en textos académicos o profesionales? ¿Qué diferencias claves destacarías entre cada uno de estos usos y cómo pueden influir en la comprensión del lector?\n\n¡Espero sus participaciones y reflexiones para enriquecer nuestro conocimiento en este aspecto fundamental del lenguaje escrito!', 'INACTIVO', '2024-04-17', '2024-04-18 15:59:01'),
(27, 3, 4, 'Comparando el Verbo To Be en Inglés y Español: Perspectivas y Ejemplos', '¡Estimados estudiantes!\n\nEn este foro, los invito a explorar las diferencias y similitudes entre el verbo &quot;to be&quot; en inglés y sus equivalentes en español. Como saben, entender estas diferencias es esencial para dominar el uso correcto del verbo y comunicarse eficazmente en ambos idiomas.\n\nPor favor, participen compartiendo ejemplos y sus opiniones sobre cómo el verbo &quot;to be&quot; se utiliza en distintos contextos en comparación con el español. Aquí hay algunas preguntas para guiar su participación:\n\n¿Cuáles son las principales diferencias gramaticales entre el verbo &quot;to be&quot; en inglés y sus equivalentes en español?\n\n¿Cómo se forman las oraciones afirmativas, negativas e interrogativas con el verbo &quot;to be&quot; en inglés en comparación con el español?\n\n¿Hay alguna diferencia en el uso cotidiano del verbo &quot;to be&quot; en inglés y sus equivalentes en español? Por ejemplo, ¿se utilizan de manera diferente en situaciones formales e informales?\n\n¿Cuál creen que es la dificultad principal al aprender a utilizar el verbo &quot;to be&quot; en inglés para los hispanohablantes?\n\nCompartan ejemplos concretos que ilustren las diferencias en el uso del verbo &quot;to be&quot; entre los dos idiomas.\n\nEspero con interés sus contribuciones y discusiones en este foro. ¡No duden en interactuar y aprender unos de otros!', 'INACTIVO', '2024-05-22', '2024-05-23 13:32:42'),
(28, 3, 4, '#&quot;1&#039;', '1', 'INACTIVO', '2024-06-19', '2024-08-02 00:27:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grabaciones`
--

DROP TABLE IF EXISTS `grabaciones`;
CREATE TABLE IF NOT EXISTS `grabaciones` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fecha` date NOT NULL,
  `detalles` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_grupo` int DEFAULT NULL,
  `id_docentes` int NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_grupo` (`id_grupo`),
  KEY `id_docentes` (`id_docentes`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grabaciones`
--

INSERT INTO `grabaciones` (`ID`, `titulo`, `fecha`, `detalles`, `id_grupo`, `id_docentes`, `url`) VALUES
(113, 'Las Cuatro Operaciones Fundamentales de la Matemática', '2024-03-24', 'En esta sesión de matemáticas, nos sumergimos en los pilares esenciales de la aritmética y su importancia en la comprensión numérica. Desde las operaciones básicas de división y multiplicación hasta la representación gráfica de rectas en el plano, exploramos cómo estos conceptos fundamentales no solo fortalecen nuestras habilidades de cálculo, sino que también enriquecen nuestra percepción del mundo cuantitativo que nos rodea. Únete a nosotros mientras desentrañamos los secretos de la matemática y su impacto en nuestro día a día. ¡Descubre cómo la suma, la división, la multiplicación y la recta son los cimientos de nuestro razonamiento numérico!', 1, 6, 'controlador/clases/videos/fff24320244517703.webm'),
(114, 'dd', '2024-03-24', 'dd', 3, 6, 'controlador/clases/videos/dd2432024455933.webm'),
(115, 'Dominando la Gramática en Español: Fundamentos y Relevancia', '2024-03-06', 'En esta clase, se examinó a fondo la gramática en español y su relevancia en la comunicación. Desde los detalles de los tiempos verbales hasta la estructura de las oraciones, se revisaron las reglas que dan forma al idioma. A través de ejemplos y análisis, se demostró cómo una comprensión sólida de la gramática mejora la expresión y la comprensión del español. Esta sesión ofreció una visión de la importancia esencial de la gramática en la lengua española.\n\n\n\n\n\n', 2, 6, 'controlador/clases/videos/sss2432024514343.webm'),
(116, 'Explorando el Lenguaje: Plural, Singular y Tercera Persona', '2024-03-12', 'En esta clase no solo hemos aprendido las diferencias fundamentales entre el plural, el singular y la tercera persona, sino también cómo estas formas simples de expresión tienen el poder de transformar completamente el significado y la profundidad de nuestras ideas y relatos. ¡Espero que hayan disfrutado tanto como yo al sumergirnos en las maravillas del lenguaje!', 2, 6, 'controlador/clases/videos/ss24320245938200.webm');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grados`
--

DROP TABLE IF EXISTS `grados`;
CREATE TABLE IF NOT EXISTS `grados` (
  `ID` int NOT NULL,
  `aula` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('ACTIVO','INACTIVO') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `grados`
--

INSERT INTO `grados` (`ID`, `aula`, `status`) VALUES
(1, '6A', 'ACTIVO'),
(2, '6B', 'ACTIVO'),
(3, '6C', 'ACTIVO'),
(4, '7A', 'ACTIVO'),
(5, '7B', 'ACTIVO'),
(6, '7C', 'ACTIVO'),
(7, '8A', 'ACTIVO'),
(8, '8B', 'ACTIVO'),
(9, '8C', 'ACTIVO'),
(10, '9A', 'ACTIVO'),
(11, '9B', 'ACTIVO'),
(12, '9C', 'ACTIVO'),
(13, '10A', 'ACTIVO'),
(14, '10B', 'ACTIVO'),
(15, '11A', 'ACTIVO'),
(16, '11B', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_curso` int DEFAULT NULL,
  `bloque_1` text CHARACTER SET utf32 COLLATE utf32_general_ci,
  `bloque_2` text CHARACTER SET utf32 COLLATE utf32_general_ci,
  `bloque_3` text CHARACTER SET utf32 COLLATE utf32_general_ci,
  `bloque_4` text CHARACTER SET utf32 COLLATE utf32_general_ci,
  `bloque_5` text CHARACTER SET utf32 COLLATE utf32_general_ci,
  `bloque_6` text CHARACTER SET utf32 COLLATE utf32_general_ci,
  `lunes_1` int DEFAULT NULL,
  `lunes_2` int DEFAULT NULL,
  `lunes_3` int DEFAULT NULL,
  `lunes_4` int DEFAULT NULL,
  `lunes_5` int DEFAULT NULL,
  `lunes_6` int DEFAULT NULL,
  `martes_1` int DEFAULT NULL,
  `martes_2` int DEFAULT NULL,
  `martes_3` int DEFAULT NULL,
  `martes_4` int DEFAULT NULL,
  `martes_5` int DEFAULT NULL,
  `martes_6` int DEFAULT NULL,
  `miercoles_1` int DEFAULT NULL,
  `miercoles_2` int DEFAULT NULL,
  `miercoles_3` int DEFAULT NULL,
  `miercoles_4` int DEFAULT NULL,
  `miercoles_5` int DEFAULT NULL,
  `miercoles_6` int DEFAULT NULL,
  `jueves_1` int DEFAULT NULL,
  `jueves_2` int DEFAULT NULL,
  `jueves_3` int DEFAULT NULL,
  `jueves_4` int DEFAULT NULL,
  `jueves_5` int DEFAULT NULL,
  `jueves_6` int DEFAULT NULL,
  `viernes_1` int DEFAULT NULL,
  `viernes_2` int DEFAULT NULL,
  `viernes_3` int DEFAULT NULL,
  `viernes_4` int DEFAULT NULL,
  `viernes_5` int DEFAULT NULL,
  `viernes_6` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_curso` (`id_curso`),
  KEY `lunes_1` (`lunes_1`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horarios`
--

INSERT INTO `horarios` (`ID`, `id_curso`, `bloque_1`, `bloque_2`, `bloque_3`, `bloque_4`, `bloque_5`, `bloque_6`, `lunes_1`, `lunes_2`, `lunes_3`, `lunes_4`, `lunes_5`, `lunes_6`, `martes_1`, `martes_2`, `martes_3`, `martes_4`, `martes_5`, `martes_6`, `miercoles_1`, `miercoles_2`, `miercoles_3`, `miercoles_4`, `miercoles_5`, `miercoles_6`, `jueves_1`, `jueves_2`, `jueves_3`, `jueves_4`, `jueves_5`, `jueves_6`, `viernes_1`, `viernes_2`, `viernes_3`, `viernes_4`, `viernes_5`, `viernes_6`) VALUES
(1, 1, '12:05 PM - 1:00 PM', '1:00 PM - 1:55 PM', '2:15 PM - 3:10 PM', '3:10 PM - 4:05 PM', '4:15 PM - 5:10 PM', '5:10 PM - 6:05 PM', 14, 15, 2, 2, 1, 17, 5, 5, 3, 3, 2, 18, 19, 12, 1, 1, 6, 6, 3, 3, 1, 1, 2, 2, 10, 10, 16, 16, 14, 14),
(2, 2, '12:05 PM - 1:00 PM', '1:00 PM - 1:55 PM', '2:15 PM - 3:10 PM', '3:10 PM - 4:05 PM', '4:15 PM - 5:10 PM', '5:10 PM - 6:05 PM', 17, 12, 3, 3, 2, 2, 18, 15, 14, 14, 1, 1, 6, 6, 3, 3, 10, 10, 1, 14, 2, 2, 16, 16, 5, 5, 1, 1, 2, 19),
(7, 3, '12:05 PM - 1:00 PM', '1:00 PM - 1:55 PM', '2:15 PM - 3:10 PM', '3:10 PM - 4:05 PM', '4:15 PM - 5:10 PM', '5:10 PM - 6:05 PM', 6, 6, 15, 2, 2, 14, 2, 17, 1, 19, 3, 3, 1, 1, 10, 10, 16, 16, 18, 12, 3, 3, 5, 5, 14, 14, 2, 2, 1, 1),
(8, 4, '12:05 PM - 1:00 PM', '1:00 PM - 1:55 PM', '2:15 PM - 3:10 PM', '3:10 PM - 4:05 PM', '4:15 PM - 5:10 PM', '5:10 PM - 6:05 PM', 15, 2, 14, 1, 1, 12, 1, 1, 5, 5, 3, 3, 10, 10, 14, 14, 6, 6, 1, 17, 2, 2, 3, 3, 18, 19, 16, 16, 2, 2),
(9, 5, '12:05 PM - 1:00 PM', '1:00 PM - 1:55 PM', '2:15 PM - 3:10 PM', '3:10 PM - 4:05 PM', '4:15 PM - 5:10 PM', '5:10 PM - 6:05 PM', 10, 10, 1, 1, 3, 3, 14, 14, 2, 2, 6, 6, 2, 2, 16, 16, 1, 1, 19, 18, 3, 3, 1, 14, 12, 15, 5, 5, 17, 2),
(10, 6, '12:05 PM - 1:00 PM', '1:00 PM - 1:55 PM', '2:15 PM - 3:10 PM', '3:10 PM - 4:05 PM', '4:15 PM - 5:10 PM', '5:10 PM - 6:05 PM', 1, 1, 18, 14, 6, 6, 2, 2, 10, 10, 16, 16, 19, 15, 2, 2, 3, 3, 5, 5, 1, 1, 17, 12, 1, 2, 14, 14, 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios_docentes`
--

DROP TABLE IF EXISTS `horarios_docentes`;
CREATE TABLE IF NOT EXISTS `horarios_docentes` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_docente` int DEFAULT NULL,
  `bloque_1` text CHARACTER SET utf32 COLLATE utf32_general_ci,
  `bloque_2` text CHARACTER SET utf32 COLLATE utf32_general_ci,
  `bloque_3` text CHARACTER SET utf32 COLLATE utf32_general_ci,
  `bloque_4` text CHARACTER SET utf32 COLLATE utf32_general_ci,
  `bloque_5` text CHARACTER SET utf32 COLLATE utf32_general_ci,
  `bloque_6` text CHARACTER SET utf32 COLLATE utf32_general_ci,
  `lunes_1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `lunes_2` text COLLATE utf8mb4_general_ci,
  `lunes_3` text COLLATE utf8mb4_general_ci,
  `lunes_4` text COLLATE utf8mb4_general_ci,
  `lunes_5` text COLLATE utf8mb4_general_ci,
  `lunes_6` text COLLATE utf8mb4_general_ci,
  `martes_1` text COLLATE utf8mb4_general_ci,
  `martes_2` text COLLATE utf8mb4_general_ci,
  `martes_3` text COLLATE utf8mb4_general_ci,
  `martes_4` text COLLATE utf8mb4_general_ci,
  `martes_5` text COLLATE utf8mb4_general_ci,
  `martes_6` text COLLATE utf8mb4_general_ci,
  `miercoles_1` text COLLATE utf8mb4_general_ci,
  `miercoles_2` text COLLATE utf8mb4_general_ci,
  `miercoles_3` text COLLATE utf8mb4_general_ci,
  `miercoles_4` text COLLATE utf8mb4_general_ci,
  `miercoles_5` text COLLATE utf8mb4_general_ci,
  `miercoles_6` text COLLATE utf8mb4_general_ci,
  `jueves_1` text COLLATE utf8mb4_general_ci,
  `jueves_2` text COLLATE utf8mb4_general_ci,
  `jueves_3` text COLLATE utf8mb4_general_ci,
  `jueves_4` text COLLATE utf8mb4_general_ci,
  `jueves_5` text COLLATE utf8mb4_general_ci,
  `jueves_6` text COLLATE utf8mb4_general_ci,
  `viernes_1` text COLLATE utf8mb4_general_ci,
  `viernes_2` text COLLATE utf8mb4_general_ci,
  `viernes_3` text COLLATE utf8mb4_general_ci,
  `viernes_4` text COLLATE utf8mb4_general_ci,
  `viernes_5` text COLLATE utf8mb4_general_ci,
  `viernes_6` text COLLATE utf8mb4_general_ci,
  `grado_lunes_3` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_lunes_4` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_lunes_5` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_lunes_6` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_martes_1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_martes_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_martes_3` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_martes_4` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_martes_5` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_martes_6` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_miercoles_1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_miercoles_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_miercoles_3` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_miercoles_4` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_miercoles_5` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_miercoles_6` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_jueves_1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_jueves_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_jueves_3` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_jueves_4` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_jueves_5` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_jueves_6` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_viernes_1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_viernes_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_viernes_3` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_viernes_4` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_viernes_5` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_viernes_6` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_lunes_1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `grado_lunes_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`ID`),
  KEY `id_curso` (`id_docente`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horarios_docentes`
--

INSERT INTO `horarios_docentes` (`ID`, `id_docente`, `bloque_1`, `bloque_2`, `bloque_3`, `bloque_4`, `bloque_5`, `bloque_6`, `lunes_1`, `lunes_2`, `lunes_3`, `lunes_4`, `lunes_5`, `lunes_6`, `martes_1`, `martes_2`, `martes_3`, `martes_4`, `martes_5`, `martes_6`, `miercoles_1`, `miercoles_2`, `miercoles_3`, `miercoles_4`, `miercoles_5`, `miercoles_6`, `jueves_1`, `jueves_2`, `jueves_3`, `jueves_4`, `jueves_5`, `jueves_6`, `viernes_1`, `viernes_2`, `viernes_3`, `viernes_4`, `viernes_5`, `viernes_6`, `grado_lunes_3`, `grado_lunes_4`, `grado_lunes_5`, `grado_lunes_6`, `grado_martes_1`, `grado_martes_2`, `grado_martes_3`, `grado_martes_4`, `grado_martes_5`, `grado_martes_6`, `grado_miercoles_1`, `grado_miercoles_2`, `grado_miercoles_3`, `grado_miercoles_4`, `grado_miercoles_5`, `grado_miercoles_6`, `grado_jueves_1`, `grado_jueves_2`, `grado_jueves_3`, `grado_jueves_4`, `grado_jueves_5`, `grado_jueves_6`, `grado_viernes_1`, `grado_viernes_2`, `grado_viernes_3`, `grado_viernes_4`, `grado_viernes_5`, `grado_viernes_6`, `grado_lunes_1`, `grado_lunes_2`) VALUES
(2, 2, '12:05 PM - 1:00 PM', '1:00 PM - 1:55 PM', '2:15 PM - 3:10 PM', '3:10 PM - 4:05 PM', '4:15 PM - 5:10 PM', '5:10 PM - 6:05 PM', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'ESPAÑOL', 'ESPAÑOL', 'MATEMATICAS', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'NATURALES', 'NATURALES', 'ESPAÑOL', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'MATEMATICAS', 'MATEMATICAS', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'NATURALES', 'NATURALES', 'MATEMATICAS', 'MATEMATICAS', 'ESPAÑOL', 'ESPAÑOL', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', '6A', '6A', '6B', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', '6A', '6A', '6A', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', '6A', '6A', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', '6A', '6A', '6A', '6A', '6A', '6A', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN'),
(8, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 3, '12:05 PM - 1:00 PM', '1:00 PM - 1:55 PM', '2:15 PM - 3:10 PM', '3:10 PM - 4:05 PM', '4:15 PM - 5:10 PM', '5:10 PM - 6:05 PM', 'INGLES', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'INGLES', 'INGLES', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', 'SIN ASIGNACIÓN', '6A', '6A', '6A', 'SIN ASIGNACIÓN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `material`
--

DROP TABLE IF EXISTS `material`;
CREATE TABLE IF NOT EXISTS `material` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `id_docente` int DEFAULT NULL,
  `titulo` text,
  PRIMARY KEY (`ID`),
  KEY `id_docente` (`id_docente`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `material`
--

INSERT INTO `material` (`ID`, `id_docente`, `titulo`) VALUES
(1, 2, 'Material de apoyo Español'),
(5, 2, 'Material de apoyo Naturales'),
(6, 2, 'Documentos'),
(7, 2, 'prueba'),
(8, 3, 'Material de apoyo Verbo to be'),
(9, 2, 'software');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

DROP TABLE IF EXISTS `rol`;
CREATE TABLE IF NOT EXISTS `rol` (
  `ID` int NOT NULL,
  `rol_nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  KEY `ID` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`ID`, `rol_nombre`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'DOCENTE'),
(3, 'ALUMNO'),
(4, 'SECRETARIA'),
(1, 'ADMINISTRADOR'),
(2, 'DOCENTE'),
(3, 'ALUMNO'),
(4, 'SECRETARIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `talleres`
--

DROP TABLE IF EXISTS `talleres`;
CREATE TABLE IF NOT EXISTS `talleres` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Fecha` date NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `archivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` enum('ACTIVO','INACTIVO') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_grupo` int NOT NULL,
  `id_docente` int NOT NULL,
  `taller_estado` enum('ENTREGADO','NO ENTREGADO') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_grupo` (`id_grupo`),
  KEY `id_docente` (`id_docente`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `talleres`
--

INSERT INTO `talleres` (`ID`, `titulo`, `Fecha`, `descripcion`, `archivo`, `estado`, `id_grupo`, `id_docente`, `taller_estado`) VALUES
(1, 'celula', '2023-12-18', 'explica que es la celula', 'controlador/talleres/archivo/CIENCIAS-N°6_5°A-B.pdf', 'INACTIVO', 3, 6, 'ENTREGADO'),
(2, 'sistema inmulogico', '2023-12-20', 'sistema inmulogico', 'controlador/talleres/archivo/tecnologia informatica2411202313278.pdf', 'INACTIVO', 3, 6, 'NO ENTREGADO'),
(3, 'cromosoma', '2024-02-15', 'por que es importante el cromosoma', 'controlador/talleres/archivo/esqueleto humano18120240448.pdf', 'INACTIVO', 3, 6, 'ENTREGADO'),
(4, 'Esqueleto', '2024-02-29', 'fffdff', 'controlador/talleres/archivo/esqueleto humano18120240448.pdf', 'INACTIVO', 3, 6, 'ENTREGADO'),
(11, 'Ortografía', '2024-06-07', 'Espero que se encuentren bien. Les pido que por favor lean la siguiente historia y corrijan los errores ortográficos que encuentren en ella.\n\nAvía una ves en un bosque encantado un conejito muy curioso llamado Panchito. Un día mientra él jugava entre los arbustos descubrio una caverna misteriosa. &quot;¡Qué emocionante!&quot; pensó Panchito mientra él se adentrava en la oscuridad de la caverna. Allí encontró un tesorro brillante que parecía aber estado allí por siglos. &quot;¡Lo encontré!&quot; gritó Panchito emocionado agarrando el tesoro con sus pequeñas patas.\n\nDespués de salir de la caverna Panchito corrió asia su madriguera para mostrarle el tesoro a sus amigos. &quot;¡Miren lo que encontré!&quot; dijo Panchito con una sonrisa enorme mostrando la riquesa que había encontrado. Sus amigos los conejitos Saltarín y Peludito estaban asombrados. &quot;¡Increíble!&quot; exclamó Saltarín mientra él tocaba una piedra preciosa con admiración. Juntos los tres amigos celebraron su descubrimiento y planearon cómo usarían su nuevo tesorro para mejorar la vida en el bosque.', 'controlador/talleres/archivo/Ortografía283202445844.pdf', 'ACTIVO', 2, 6, 'ENTREGADO'),
(12, 'Actividad: Singular, Plural y Tercera Persona ', '2024-03-29', 'Actividad: Singular, Plural y Tercera Persona\r\n\r\nLee cada oración cuidadosamente e Identifica si la oración está en singular o plural y lige la Respuesta Correcta\r\n\r\nEjercicios:\r\n\r\nSingular: El pájaro canta en la mañana.\r\nA) Singular\r\nB) Plural\r\nC) Tercera Persona\r\n\r\nPlural: Las flores son hermosas en primavera.\r\nA) Singular\r\nB) Plural\r\nC) Tercera Persona\r\n\r\nSingular: Mi hermana lee cuentos todas las noches.\r\nA) Singular\r\nB) Plural\r\nC) Tercera Persona\r\n\r\nPlural: Los estudiantes estudian para el examen.\r\nA) Singular\r\nB) Plural\r\nC) Tercera Persona\r\n\r\nSingular: El perro ladra cuando ve a un extraño.\r\nA) Singular\r\nB) Plural\r\nC) Tercera Persona\r\n\r\nPlural: Los amigos van al cine los viernes.\r\nA) Singular\r\nB) Plural\r\nC) Tercera Persona\r\n\r\nSingular: Mi abuelo cocina deliciosos pasteles.\r\nA) Singular\r\nB) Plural\r\nC) Tercera Persona\r\n\r\nPlural: Las abejas trabajan duro para hacer miel.\r\nA) Singular\r\nB) Plural\r\nC) Tercera Persona\r\n\r\nSingular: El libro está en la mesa.\r\nA) Singular\r\nB) Plural\r\nC) Tercera Persona\r\n\r\nPlural: Los niños tienen juguetes nuevos.\r\nA) Singular\r\nB) Plural\r\nC) Tercera Persona', 'controlador/talleres/archivo/Actividad_ Singular, Plural y Tercera Persona 28320245110.pdf', 'INACTIVO', 2, 6, 'NO ENTREGADO'),
(16, 'Examen sorpresa', '2024-04-05', 'Háganlo ', 'controlador/talleres/archivo/Examen sorpresa44202452654.pdf', 'INACTIVO', 2, 6, 'NO ENTREGADO'),
(21, 'Dominando el Verbo To Be Ejercicios Prácticos para', '2024-06-06', 'En este taller interactivo, nos enfocaremos en el uso correcto del verbo &quot;to be&quot; en inglés, una de las bases fundamentales del idioma. A través de una serie de ejercicios prácticos, los participantes desarrollarán una comprensión sólida y confianza en su uso. La actividad principal consistirá en la creación de 40 ejemplos que abarcarán diversas formas y tiempos del verbo &quot;to be&quot;:\r\n\r\n10 ejemplos en presente afirmativo: Ejercicios que demuestren cómo formar oraciones afirmativas en presente utilizando &quot;am,&quot; &quot;is,&quot; y &quot;are&quot;.\r\n\r\n10 ejemplos en presente negativo: Ejercicios para practicar la formación de oraciones negativas en presente, usando &quot;am not,&quot; &quot;is not,&quot; y &quot;are not&quot;.\r\n\r\n10 ejemplos en pasado interrogativo: Práctica en la formación de preguntas en pasado utilizando &quot;was&quot; y &quot;were&quot;.\r\n\r\n10 ejemplos en pasado negativo: Ejercicios para aprender a formar oraciones negativas en pasado, utilizando &quot;was not&quot; y &quot;were not&quot;.', 'controlador/talleres/archivo/Dominando el Verbo To Be Ejercicios Prácticos para662024644.pdf', 'INACTIVO', 4, 2, 'NO ENTREGADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `usu_nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `usu_contrasena` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `usu_sexo` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `usu_email` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `usu_estatus` enum('ACTIVO','INACTIVO') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_rol` int NOT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `usu_intento` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `id_rol` (`id_rol`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`ID`, `usu_nombre`, `usu_contrasena`, `usu_sexo`, `usu_email`, `usu_estatus`, `id_rol`, `foto`, `usu_intento`) VALUES
(1, 'admin', '$2y$12$MAd/g0C4MAiUXYLo4.VHHeQCznSfItAMudrPjHimhmfNqNbgNaU0S', 'M', 'do@gmail.com', 'ACTIVO', 1, 'controlador/usuario/foto/admin108202334766.png', 0),
(2, 'docente', '$2y$12$MAd/g0C4MAiUXYLo4.VHHeQCznSfItAMudrPjHimhmfNqNbgNaU0S', 'M', 'docente@gmail.com', 'ACTIVO', 2, 'controlador/usuario/foto/docente20320249321.jpg', 1),
(3, 'docente1', '$2y$12$MAd/g0C4MAiUXYLo4.VHHeQCznSfItAMudrPjHimhmfNqNbgNaU0S', 'F', 'doc1@gmail.com', 'ACTIVO', 2, 'controlador/usuario/foto/docente19520246824.jpg', 0),
(4, 'alumno', '$2y$12$MAd/g0C4MAiUXYLo4.VHHeQCznSfItAMudrPjHimhmfNqNbgNaU0S', 'M', 'alumn@gmail.com', 'ACTIVO', 3, 'controlador/usuario/foto/alumno20320243329.jpg', 0),
(5, 'alumno1', '$2y$10$krFn6fqJfY5O1kaBq2gt0.uanA0AlOUKX8QEe8A3jAtCrCkO0/D62', 'M', 'cristianeiver2014@gmail.com', 'ACTIVO', 3, 'controlador/usuario/foto/alumno1303202420668.jpg', 0),
(6, 'alumno2', '$2y$12$MAd/g0C4MAiUXYLo4.VHHeQCznSfItAMudrPjHimhmfNqNbgNaU0S', 'F', 'alunmo1@gmailc.om', 'ACTIVO', 3, 'controlador/usuario/foto/alumno2303202417131.jpg', 0),
(7, 'alumno3', '$2y$12$MAd/g0C4MAiUXYLo4.VHHeQCznSfItAMudrPjHimhmfNqNbgNaU0S', 'F', 'cristianeyver2014@gmail.com', 'ACTIVO', 3, 'controlador\\usuario\\foto\\alumno30320243329.jpg', 0),
(8, 'alumno4', '$2y$12$MAd/g0C4MAiUXYLo4.VHHeQCznSfItAMudrPjHimhmfNqNbgNaU0S', 'F', 'alunmo1@gmailc.om', 'ACTIVO', 3, 'controlador/usuario/foto/alumno4303202438861.jpg', 0),
(9, 'alumno5', '$2y$12$MAd/g0C4MAiUXYLo4.VHHeQCznSfItAMudrPjHimhmfNqNbgNaU0S', 'M', 'alunmo1@gmailc.om', 'ACTIVO', 3, 'controlador\\usuario\\foto\\default.png', 0),
(10, 'alumno6', '$2y$12$MAd/g0C4MAiUXYLo4.VHHeQCznSfItAMudrPjHimhmfNqNbgNaU0S', 'M', 'alunmo1@gmailc.om', 'ACTIVO', 3, 'controlador/usuario/foto/alumno6303202422573.jpg', 0),
(11, 'alumno7', '$2y$12$MAd/g0C4MAiUXYLo4.VHHeQCznSfItAMudrPjHimhmfNqNbgNaU0S', 'M', 'alunmo1@gmailc.om', 'ACTIVO', 2, 'controlador\\usuario\\foto\\default.png', 0),
(12, 'alumno8', '$2y$12$MAd/g0C4MAiUXYLo4.VHHeQCznSfItAMudrPjHimhmfNqNbgNaU0S', 'M', 'alunmo1@gmailc.om', 'ACTIVO', 2, 'controlador\\usuario\\foto\\default.png', 0),
(13, 'alumno9', '$2y$12$MAd/g0C4MAiUXYLo4.VHHeQCznSfItAMudrPjHimhmfNqNbgNaU0S', 'M', 'alunmo1@gmailc.om', 'ACTIVO', 2, 'controlador\\usuario\\foto\\default.png', 0),
(14, 'alumno10', '$2y$12$MAd/g0C4MAiUXYLo4.VHHeQCznSfItAMudrPjHimhmfNqNbgNaU0S', 'M', 'alunmo1@gmailc.om', 'ACTIVO', 2, 'controlador\\usuario\\foto\\default.png', 0),
(21, 'juan', '$2y$10$ns1c/4XoURmPgzVBAIrRceWDKicG6RReS2c/qjsa8GP2neA6oxFi.', 'M', 'juan@gmail.com', 'ACTIVO', 2, 'controlador\\usuario\\foto\\default.png', 1),
(22, 'pedro123', '$2y$10$2dMEVYxlizS35XDt5LqqrO3P9NWMUCraCo1OkyKr9Mq6fabqJP7ru', 'M', 'juan1@gmail.com', 'ACTIVO', 2, 'controlador\\usuario\\foto\\default.png', 0),
(23, 'cristian', '$2y$10$ppAfrk4BbXVsSBGicl1KpOumnbqaL0HCcEOl0AgOclVigYuGhgQH6', 'M', 'cristian@gmail.com', 'ACTIVO', 2, 'controlador\\usuario\\foto\\default.png', 0),
(26, 'alumno15', '$2y$10$NNERn9UnL8uXNSpaVsX1/.cUtMbR6ZDnULI1x.xfvCeIo5XE/.B6W', 'M', 'cristian123@gmail.com', 'ACTIVO', 3, 'controlador/usuario/foto/alumno15303202441517.jpg', 0),
(31, 'luis', '$2y$10$Q7gftXm632y1ZDUKme0EbO6XwTiVRnB5D84Ba28jOCCjn99nlCN4S', 'M', 'luisito@gmail.com', 'ACTIVO', 3, 'controlador/usuario/foto/217202347287.jpg', 0),
(32, 'secretaria', '$2y$12$MAd/g0C4MAiUXYLo4.VHHeQCznSfItAMudrPjHimhmfNqNbgNaU0S', 'F', 'secretaria@gmail.com', 'ACTIVO', 4, 'controlador/usuario/foto/secretaria307202341463.png', 0),
(33, 'jose', '$2y$10$rZgN0Ent3JxeBZco3WOwPuf05H7QRuFIHlLsebMm4PFyPvm9XsCfW', 'F', 'maria@gmail.com', 'ACTIVO', 3, '', 0),
(35, 'profesor', '$2y$10$D5jtbpsJiqAq3SudhuOnR.UzJHtG3YZbO7d75baKSRVnB1T4FBIu.', 'M', 'profesor@gmail.com', 'ACTIVO', 2, 'controlador/usuario/foto/profesor169202354208.webp', 0);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD CONSTRAINT `asistencias_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`ID`),
  ADD CONSTRAINT `asistencias_ibfk_2` FOREIGN KEY (`id_grupo`) REFERENCES `deatlles_cursos` (`ID`);

--
-- Filtros para la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD CONSTRAINT `calificaciones_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`ID`);

--
-- Filtros para la tabla `clases`
--
ALTER TABLE `clases`
  ADD CONSTRAINT `clases_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `deatlles_cursos` (`id_docente`),
  ADD CONSTRAINT `clases_ibfk_2` FOREIGN KEY (`id_grupo`) REFERENCES `deatlles_cursos` (`ID`);

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_taller`) REFERENCES `talleres` (`ID`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`ID`);

--
-- Filtros para la tabla `comentarios_asuntos`
--
ALTER TABLE `comentarios_asuntos`
  ADD CONSTRAINT `comentarios_asuntos_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `docentes` (`id_usu`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `comentarios_asuntos_ibfk_2` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiantes` (`id_usu`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `deatlles_cursos`
--
ALTER TABLE `deatlles_cursos`
  ADD CONSTRAINT `deatlles_cursos_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`ID`),
  ADD CONSTRAINT `deatlles_cursos_ibfk_2` FOREIGN KEY (`id_docente`) REFERENCES `docentes` (`ID`),
  ADD CONSTRAINT `deatlles_cursos_ibfk_3` FOREIGN KEY (`id_aula`) REFERENCES `grados` (`ID`);

--
-- Filtros para la tabla `detalles_calificaciones`
--
ALTER TABLE `detalles_calificaciones`
  ADD CONSTRAINT `detalles_calificaciones_ibfk_1` FOREIGN KEY (`id_claificaciones`) REFERENCES `calificaciones` (`ID`),
  ADD CONSTRAINT `detalles_calificaciones_ibfk_2` FOREIGN KEY (`id_docente`) REFERENCES `deatlles_cursos` (`id_docente`),
  ADD CONSTRAINT `detalles_calificaciones_ibfk_3` FOREIGN KEY (`id_grupo`) REFERENCES `deatlles_cursos` (`ID`);

--
-- Filtros para la tabla `detalles_chat`
--
ALTER TABLE `detalles_chat`
  ADD CONSTRAINT `detalles_chat_ibfk_1` FOREIGN KEY (`Id_chat`) REFERENCES `chat` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `detalles_comentarios`
--
ALTER TABLE `detalles_comentarios`
  ADD CONSTRAINT `detalles_comentarios_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `deatlles_cursos` (`id_docente`),
  ADD CONSTRAINT `detalles_comentarios_ibfk_2` FOREIGN KEY (`id_comentario`) REFERENCES `comentarios` (`ID`);

--
-- Filtros para la tabla `detalles_foro`
--
ALTER TABLE `detalles_foro`
  ADD CONSTRAINT `detalles_foro_ibfk_1` FOREIGN KEY (`id_foro`) REFERENCES `foro` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `detalles_foro_respuesta`
--
ALTER TABLE `detalles_foro_respuesta`
  ADD CONSTRAINT `detalles_foro_respuesta_ibfk_1` FOREIGN KEY (`id_comentario_principal`) REFERENCES `detalles_foro` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `detalles_foro_respuesta_ibfk_2` FOREIGN KEY (`id_foro`) REFERENCES `foro` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `detalles_material`
--
ALTER TABLE `detalles_material`
  ADD CONSTRAINT `detalles_material_ibfk_1` FOREIGN KEY (`id_material`) REFERENCES `material` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `detalles_sistencias`
--
ALTER TABLE `detalles_sistencias`
  ADD CONSTRAINT `detalles_sistencias_ibfk_1` FOREIGN KEY (`id_asistencia`) REFERENCES `asistencias` (`ID`),
  ADD CONSTRAINT `detalles_sistencias_ibfk_2` FOREIGN KEY (`id_docente`) REFERENCES `deatlles_cursos` (`id_docente`);

--
-- Filtros para la tabla `detalles_talleres`
--
ALTER TABLE `detalles_talleres`
  ADD CONSTRAINT `detalles_talleres_ibfk_2` FOREIGN KEY (`id_estudiante`) REFERENCES `calificaciones` (`id_estudiante`),
  ADD CONSTRAINT `detalles_talleres_ibfk_3` FOREIGN KEY (`id_taller`) REFERENCES `talleres` (`ID`);

--
-- Filtros para la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD CONSTRAINT `docentes_ibfk_1` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`ID`);

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_ibfk_1` FOREIGN KEY (`id_grado`) REFERENCES `grados` (`ID`),
  ADD CONSTRAINT `estudiantes_ibfk_2` FOREIGN KEY (`id_usu`) REFERENCES `usuario` (`ID`);

--
-- Filtros para la tabla `grabaciones`
--
ALTER TABLE `grabaciones`
  ADD CONSTRAINT `grabaciones_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `deatlles_cursos` (`ID`),
  ADD CONSTRAINT `grabaciones_ibfk_2` FOREIGN KEY (`id_docentes`) REFERENCES `deatlles_cursos` (`id_docente`);

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `horarios_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `grados` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `material`
--
ALTER TABLE `material`
  ADD CONSTRAINT `material_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `docentes` (`id_usu`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `talleres`
--
ALTER TABLE `talleres`
  ADD CONSTRAINT `talleres_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `deatlles_cursos` (`ID`),
  ADD CONSTRAINT `talleres_ibfk_2` FOREIGN KEY (`id_docente`) REFERENCES `docentes` (`ID`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
