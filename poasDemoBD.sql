-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-11-2025 a las 07:50:58
-- Versión del servidor: 5.5.44
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `poas`
--

DELIMITER $$
--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `mes` (`fecha` DATE, `locale` VARCHAR(10)) RETURNS VARCHAR(20) CHARSET utf8 DETERMINISTIC READS SQL DATA BEGIN
    DECLARE month_name VARCHAR(20);
    
    IF locale = 'es_ES' THEN
        SET month_name = CASE MONTH(fecha)
            WHEN 1 THEN 'Enero'
            WHEN 2 THEN 'Febrero'
            WHEN 3 THEN 'Marzo'
            WHEN 4 THEN 'Abril'
            WHEN 5 THEN 'Mayo'
            WHEN 6 THEN 'Junio'
            WHEN 7 THEN 'Julio'
            WHEN 8 THEN 'Agosto'
            WHEN 9 THEN 'Septiembre'
            WHEN 10 THEN 'Octubre'
            WHEN 11 THEN 'Noviembre'
            WHEN 12 THEN 'Diciembre'
        END;
    ELSE
        SET month_name = MONTHNAME(fecha);
    END IF;
    
    RETURN month_name;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `academicdegrees`
--

CREATE TABLE `academicdegrees` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(50) NOT NULL,
  `ABBREVIATION` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `academicdegrees`
--

INSERT INTO `academicdegrees` (`ID`, `NAME`, `ABBREVIATION`) VALUES
(1, 'Licenciado', 'Lic.'),
(2, 'Ingeniero', 'Ing.'),
(3, 'Maestro', 'Mtro.'),
(4, 'Doctor', 'Dr.'),
(5, 'Arquitecto', 'Arq.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actionlines`
--

CREATE TABLE `actionlines` (
  `ID` int(11) NOT NULL,
  `NUMBER` varchar(10) NOT NULL,
  `NAME` varchar(200) NOT NULL,
  `PDIAXIS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `actionlines`
--

INSERT INTO `actionlines` (`ID`, `NUMBER`, `NAME`, `PDIAXIS`) VALUES
(1, '1.1', 'Fortalecimiento de Programas Educativos', 1),
(2, '1.2', 'Actualización de Planes de Estudio', 1),
(3, '2.1', 'Desarrollo de Proyectos de Investigación', 2),
(4, '3.1', 'Vinculación con el Sector Productivo', 3),
(5, '4.1', 'Modernización de la Infraestructura', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `AREACODE` varchar(10) NOT NULL,
  `NAME` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `areas`
--

INSERT INTO `areas` (`AREACODE`, `NAME`) VALUES
('ACAD', 'Académica'),
('ADM', 'Administrativa'),
('EXT', 'Extensión Universitaria'),
('FIN', 'Financiera'),
('INV', 'Investigación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `budgetconcepts`
--

CREATE TABLE `budgetconcepts` (
  `ID` int(11) NOT NULL,
  `CONCEPT` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `budgetconcepts`
--

INSERT INTO `budgetconcepts` (`ID`, `CONCEPT`) VALUES
(1, 'Materiales de Oficina'),
(2, 'Equipo de Cómputo'),
(3, 'Mobiliario'),
(4, 'Servicios Profesionales'),
(5, 'Capacitación'),
(6, 'Viáticos'),
(7, 'Material Didáctico'),
(8, 'Equipo de Laboratorio'),
(9, 'Software');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `derivatedareas`
--

CREATE TABLE `derivatedareas` (
  `CODE` varchar(10) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `SUBAREA` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `derivatedareas`
--

INSERT INTO `derivatedareas` (`CODE`, `NAME`, `SUBAREA`) VALUES
('DEPT-CIV', 'Departamento de Civil', 'ACAD-01'),
('DEPT-PSI', 'Departamento de Psicología', 'ACAD-02'),
('DEPT-SIS', 'Departamento de Sistemas', 'ACAD-01'),
('LAB-QUIM', 'Laboratorio de Química', 'INV-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evidences`
--

CREATE TABLE `evidences` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `evidences`
--

INSERT INTO `evidences` (`ID`, `NAME`) VALUES
(1, 'Factura'),
(2, 'Recibo'),
(3, 'Cotización'),
(4, 'Reporte'),
(5, 'Fotografía'),
(6, 'Constancia'),
(7, 'Lista de asistencia');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `getareasandsubareas`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `getareasandsubareas` (
`AREA_CODE` varchar(10)
,`AREA_NAME` varchar(100)
,`SUBAREA_CODE` varchar(10)
,`SUBAREA_NAME` varchar(100)
,`DERIVATED_AREA_CODE` varchar(10)
,`DERIVATED_AREA_NAME` varchar(100)
,`TYPE` varchar(9)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pdiaxis`
--

CREATE TABLE `pdiaxis` (
  `ID` int(11) NOT NULL,
  `AXISNAME` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pdiaxis`
--

INSERT INTO `pdiaxis` (`ID`, `AXISNAME`) VALUES
(1, 'Excelencia Académica'),
(2, 'Investigación e Innovación'),
(3, 'Vinculación y Responsabilidad Social'),
(4, 'Gestión y Gobierno Universitario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pdiprojects`
--

CREATE TABLE `pdiprojects` (
  `ID` int(11) NOT NULL,
  `NUMBER` varchar(10) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `ACTIONLINE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pdiprojects`
--

INSERT INTO `pdiprojects` (`ID`, `NUMBER`, `DESCRIPTION`, `ACTIONLINE`) VALUES
(1, 'P001', 'Actualización del Laboratorio de Computación', 1),
(2, 'P002', 'Revisión del Plan de Estudios de Ingeniería en Sistemas', 2),
(3, 'P003', 'Investigación en Energías Renovables', 3),
(4, 'P004', 'Convenios con Empresas Locales para Prácticas Profesionales', 4),
(5, 'P005', 'Renovación de Equipo de Cómputo Administrativo', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `poaconcepts`
--

CREATE TABLE `poaconcepts` (
  `ID` int(11) NOT NULL,
  `POA` int(11) NOT NULL,
  `CONCEPT` varchar(500) NOT NULL,
  `BUDGETCONCEPT` int(11) NOT NULL,
  `AMOUNT` decimal(10,2) NOT NULL,
  `UNIT` int(11) NOT NULL,
  `UNITPRICE` decimal(10,2) NOT NULL,
  `EVIDENCE` int(11) NOT NULL,
  `EXECUTION_MONTHS` varchar(100) NOT NULL,
  `OTHER_EVIDENCE` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `poaconcepts`
--

INSERT INTO `poaconcepts` (`ID`, `POA`, `CONCEPT`, `BUDGETCONCEPT`, `AMOUNT`, `UNIT`, `UNITPRICE`, `EVIDENCE`, `EXECUTION_MONTHS`, `OTHER_EVIDENCE`) VALUES
(1, 1, 'Computadoras de escritorio Core i7, 16GB RAM, SSD 512GB', 2, 25.00, 1, 18500.00, 1, 'Enero-Febrero', NULL),
(2, 1, 'Impresoras láser multifuncionales a color', 2, 3.00, 1, 8500.00, 1, 'Marzo', NULL),
(3, 1, 'Licencias de software AutoCAD 2025', 9, 25.00, 1, 8500.00, 1, 'Abril', NULL),
(4, 1, 'Sillas ergonómicas para laboratorio', 3, 30.00, 1, 2200.00, 1, 'Mayo', NULL),
(5, 2, 'Paneles solares para experimentación', 8, 10.00, 1, 4500.00, 1, 'Febrero-Marzo', NULL),
(6, 2, 'Equipo de medición y análisis energético', 8, 2.00, 1, 35000.00, 1, 'Abril', NULL),
(7, 2, 'Viáticos para congreso internacional de energías renovables', 6, 3.00, 7, 18000.00, 2, 'Julio', NULL),
(8, 2, 'Publicación en revista científica indexada', 4, 2.00, 1, 12000.00, 4, 'Octubre', NULL),
(9, 2, 'Material bibliográfico especializado', 7, 20.00, 1, 950.00, 1, 'Marzo', NULL),
(10, 3, 'Organización de feria de empleo y prácticas profesionales', 4, 1.00, 8, 45000.00, 7, 'Junio', NULL),
(11, 3, 'Material promocional institucional (folletos, banners)', 1, 1500.00, 1, 35.00, 3, 'Febrero', NULL),
(12, 3, 'Viáticos para visitas a empresas asociadas', 6, 20.00, 5, 850.00, 2, 'Abril-Mayo', NULL),
(13, 3, 'Reunión de vinculación con cámaras empresariales', 4, 1.00, 8, 15000.00, 7, 'Agosto', NULL),
(14, 4, 'Honorarios de instructor especializado en sistemas ERP', 4, 1.00, 5, 40000.00, 4, 'Febrero-Marzo', NULL),
(15, 4, 'Material de trabajo y manuales de capacitación', 1, 40.00, 1, 380.00, 6, 'Febrero', NULL),
(16, 4, 'Constancias y diplomas de participación', 7, 35.00, 1, 120.00, 6, 'Abril', NULL),
(17, 8, 'CURSOS DE PROGRAMACIÓN DE PHP', 5, 2.00, 9, 385.00, 2, 'Noviembre-Diciembre', NULL),
(18, 9, 'CURSOS DE PROGRAMACIÓN', 5, 1.00, 9, 235.00, 6, 'Noviembre-Diciembre', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `poas`
--

CREATE TABLE `poas` (
  `ID` int(11) NOT NULL,
  `USER` int(11) NOT NULL,
  `STATUS` int(11) NOT NULL DEFAULT '1',
  `GENERALDESCRIPTION` text NOT NULL,
  `PRODUCTIONDATE` date NOT NULL,
  `PRODUCTIONHOUR` time NOT NULL,
  `FISCALYEAR` int(11) NOT NULL,
  `STARTDATE` date NOT NULL,
  `ENDDATE` date NOT NULL,
  `MINORAREA` varchar(10) NOT NULL,
  `SPENDTYPE` varchar(50) NOT NULL,
  `PDIPROJECT` int(11) NOT NULL,
  `OBSERVATIONS` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `poas`
--

INSERT INTO `poas` (`ID`, `USER`, `STATUS`, `GENERALDESCRIPTION`, `PRODUCTIONDATE`, `PRODUCTIONHOUR`, `FISCALYEAR`, `STARTDATE`, `ENDDATE`, `MINORAREA`, `SPENDTYPE`, `PDIPROJECT`, `OBSERVATIONS`) VALUES
(1, 1, 1, 'Actualización completa del laboratorio de computación con equipos de última generación', '2024-10-15', '10:30:00', 2025, '2025-01-15', '2025-06-15', 'ACAD-01', 'Equipamiento', 1, 'Incluye instalación y configuración de todos los equipos'),
(2, 4, 2, 'Proyecto de investigación sobre aplicaciones de energía solar en zonas urbanas', '2024-10-18', '14:20:00', 2025, '2025-02-01', '2025-11-30', 'INV-01', 'Investigación', 3, 'Colaboración con universidad internacional'),
(3, 5, 1, 'Programa de vinculación empresarial para prácticas profesionales y bolsa de trabajo', '2024-10-20', '09:15:00', 2025, '2025-03-01', '2025-08-31', 'EXT-01', 'Vinculación', 4, 'Meta: 50 estudiantes colocados en prácticas'),
(4, 2, 4, 'Capacitación en nuevo sistema de gestión administrativa para personal', '2024-10-22', '11:45:00', 2025, '2025-02-15', '2025-04-15', 'ADM-01', 'Capacitación', 5, 'Capacitación escalonada por departamentos'),
(8, 1, 1, 'TEST DE POAS', '2025-11-03', '06:00:23', 2026, '2025-11-03', '2025-12-19', 'DEPT-SIS', 'estratégico', 3, 'DESARROLLO DE PROYECTOS DE SOFTWARE PARA LA INSTITUCIÓN'),
(9, 1, 1, 'TEST 2', '2025-11-03', '08:00:06', 2026, '2025-11-03', '2025-12-24', 'DEPT-SIS', 'estratégico', 1, 'TEST DE POAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profiles`
--

CREATE TABLE `profiles` (
  `ID` int(11) NOT NULL,
  `PROFILENAME` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `profiles`
--

INSERT INTO `profiles` (`ID`, `PROFILENAME`) VALUES
(1, 'Auxiliar'),
(2, 'Director'),
(3, 'Financiero'),
(4, 'Coordinador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `status`
--

CREATE TABLE `status` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `status`
--

INSERT INTO `status` (`ID`, `NAME`) VALUES
(1, 'En espera'),
(2, 'Aprobado'),
(3, 'Rechazado'),
(4, 'En revisión'),
(5, 'Devuelto para correcciones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subareas`
--

CREATE TABLE `subareas` (
  `SUBAREACODE` varchar(10) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `AREA` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `subareas`
--

INSERT INTO `subareas` (`SUBAREACODE`, `NAME`, `AREA`) VALUES
('ACAD-01', 'División de Ingenierías', 'ACAD'),
('ACAD-02', 'División de Ciencias Sociales', 'ACAD'),
('ADM-01', 'Recursos Humanos', 'ADM'),
('ADM-02', 'Servicios Escolares', 'ADM'),
('EXT-01', 'Vinculación', 'EXT'),
('FIN-01', 'Contabilidad', 'FIN'),
('FIN-02', 'Presupuestos', 'FIN'),
('INV-01', 'Investigación Básica', 'INV');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subareas_user`
--

CREATE TABLE `subareas_user` (
  `ID` int(11) NOT NULL,
  `USER` int(11) NOT NULL,
  `SUBAREACODE` varchar(10) DEFAULT NULL,
  `DERIVATEDAREACODE` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `subareas_user`
--

INSERT INTO `subareas_user` (`ID`, `USER`, `SUBAREACODE`, `DERIVATEDAREACODE`) VALUES
(1, 1, 'ACAD-01', NULL),
(2, 1, NULL, 'DEPT-SIS'),
(3, 2, 'ADM-01', NULL),
(4, 3, 'FIN-01', NULL),
(5, 4, 'INV-01', NULL),
(6, 4, NULL, 'LAB-QUIM'),
(7, 5, 'EXT-01', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `units`
--

CREATE TABLE `units` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(50) NOT NULL,
  `ABBREVIATION` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `units`
--

INSERT INTO `units` (`ID`, `NAME`, `ABBREVIATION`) VALUES
(1, 'Pieza', 'pz'),
(2, 'Metro', 'm'),
(3, 'Litros', 'lt'),
(4, 'Kilogramo', 'kg'),
(5, 'Hora', 'hr'),
(6, 'Día', 'dia'),
(7, 'Persona', 'pers'),
(8, 'Servicio', 'serv'),
(9, 'Curso', 'curso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `REALNAME` varchar(100) NOT NULL,
  `ACADEMICDEGREE` int(11) DEFAULT NULL,
  `SUBAREA` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`ID`, `USERNAME`, `PASSWORD`, `REALNAME`, `ACADEMICDEGREE`, `SUBAREA`) VALUES
(1, 'jperez', '123', 'Juan Pérez García', 2, 'ACAD-01'),
(2, 'mgarcia', '123', 'María García López', 3, 'ADM-01'),
(3, 'rlopez', '123', 'Roberto López Martínez', 4, 'FIN-01'),
(4, 'amartinez', '123', 'Ana Martínez Sánchez', 1, 'INV-01'),
(5, 'csanchez', '123', 'Carlos Sánchez Ramírez', 2, 'EXT-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_permissions`
--

CREATE TABLE `users_permissions` (
  `USER` int(11) NOT NULL,
  `PERMISSION` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users_permissions`
--

INSERT INTO `users_permissions` (`USER`, `PERMISSION`) VALUES
(1, 1),
(2, 1),
(4, 1),
(5, 1),
(1, 2),
(3, 3),
(5, 4);

-- --------------------------------------------------------

--
-- Estructura para la vista `getareasandsubareas`
--
DROP TABLE IF EXISTS `getareasandsubareas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `getareasandsubareas`  AS SELECT `a`.`AREACODE` AS `AREA_CODE`, `a`.`NAME` AS `AREA_NAME`, `s`.`SUBAREACODE` AS `SUBAREA_CODE`, `s`.`NAME` AS `SUBAREA_NAME`, NULL AS `DERIVATED_AREA_CODE`, NULL AS `DERIVATED_AREA_NAME`, 'SUBAREA' AS `TYPE` FROM (`areas` `a` join `subareas` `s` on((`a`.`AREACODE` = `s`.`AREA`)))union select `a`.`AREACODE` AS `AREA_CODE`,`a`.`NAME` AS `AREA_NAME`,`s`.`SUBAREACODE` AS `SUBAREA_CODE`,`s`.`NAME` AS `SUBAREA_NAME`,`d`.`CODE` AS `DERIVATED_AREA_CODE`,`d`.`NAME` AS `DERIVATED_AREA_NAME`,'DERIVATED' AS `TYPE` from ((`areas` `a` join `subareas` `s` on((`a`.`AREACODE` = `s`.`AREA`))) join `derivatedareas` `d` on((`s`.`SUBAREACODE` = `d`.`SUBAREA`)))  ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `academicdegrees`
--
ALTER TABLE `academicdegrees`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `actionlines`
--
ALTER TABLE `actionlines`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `PDIAXIS` (`PDIAXIS`);

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`AREACODE`);

--
-- Indices de la tabla `budgetconcepts`
--
ALTER TABLE `budgetconcepts`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `derivatedareas`
--
ALTER TABLE `derivatedareas`
  ADD PRIMARY KEY (`CODE`),
  ADD KEY `SUBAREA` (`SUBAREA`);

--
-- Indices de la tabla `evidences`
--
ALTER TABLE `evidences`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `pdiaxis`
--
ALTER TABLE `pdiaxis`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `pdiprojects`
--
ALTER TABLE `pdiprojects`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ACTIONLINE` (`ACTIONLINE`);

--
-- Indices de la tabla `poaconcepts`
--
ALTER TABLE `poaconcepts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `POA` (`POA`),
  ADD KEY `BUDGETCONCEPT` (`BUDGETCONCEPT`),
  ADD KEY `UNIT` (`UNIT`),
  ADD KEY `EVIDENCE` (`EVIDENCE`);

--
-- Indices de la tabla `poas`
--
ALTER TABLE `poas`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `USER` (`USER`),
  ADD KEY `STATUS` (`STATUS`),
  ADD KEY `MINORAREA` (`MINORAREA`),
  ADD KEY `PDIPROJECT` (`PDIPROJECT`);

--
-- Indices de la tabla `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `subareas`
--
ALTER TABLE `subareas`
  ADD PRIMARY KEY (`SUBAREACODE`),
  ADD KEY `AREA` (`AREA`);

--
-- Indices de la tabla `subareas_user`
--
ALTER TABLE `subareas_user`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `USER` (`USER`),
  ADD KEY `SUBAREACODE` (`SUBAREACODE`),
  ADD KEY `DERIVATEDAREACODE` (`DERIVATEDAREACODE`);

--
-- Indices de la tabla `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `USERNAME` (`USERNAME`),
  ADD KEY `ACADEMICDEGREE` (`ACADEMICDEGREE`),
  ADD KEY `SUBAREA` (`SUBAREA`);

--
-- Indices de la tabla `users_permissions`
--
ALTER TABLE `users_permissions`
  ADD PRIMARY KEY (`USER`,`PERMISSION`),
  ADD KEY `PERMISSION` (`PERMISSION`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `academicdegrees`
--
ALTER TABLE `academicdegrees`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `actionlines`
--
ALTER TABLE `actionlines`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `budgetconcepts`
--
ALTER TABLE `budgetconcepts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `evidences`
--
ALTER TABLE `evidences`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `pdiaxis`
--
ALTER TABLE `pdiaxis`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pdiprojects`
--
ALTER TABLE `pdiprojects`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `poaconcepts`
--
ALTER TABLE `poaconcepts`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `poas`
--
ALTER TABLE `poas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `profiles`
--
ALTER TABLE `profiles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `status`
--
ALTER TABLE `status`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `subareas_user`
--
ALTER TABLE `subareas_user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `units`
--
ALTER TABLE `units`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actionlines`
--
ALTER TABLE `actionlines`
  ADD CONSTRAINT `ACTIONLINES_ibfk_1` FOREIGN KEY (`PDIAXIS`) REFERENCES `pdiaxis` (`ID`);

--
-- Filtros para la tabla `derivatedareas`
--
ALTER TABLE `derivatedareas`
  ADD CONSTRAINT `DERIVATEDAREAS_ibfk_1` FOREIGN KEY (`SUBAREA`) REFERENCES `subareas` (`SUBAREACODE`);

--
-- Filtros para la tabla `pdiprojects`
--
ALTER TABLE `pdiprojects`
  ADD CONSTRAINT `PDIPROJECTS_ibfk_1` FOREIGN KEY (`ACTIONLINE`) REFERENCES `actionlines` (`ID`);

--
-- Filtros para la tabla `poaconcepts`
--
ALTER TABLE `poaconcepts`
  ADD CONSTRAINT `POACONCEPTS_ibfk_1` FOREIGN KEY (`POA`) REFERENCES `poas` (`ID`),
  ADD CONSTRAINT `POACONCEPTS_ibfk_2` FOREIGN KEY (`BUDGETCONCEPT`) REFERENCES `budgetconcepts` (`ID`),
  ADD CONSTRAINT `POACONCEPTS_ibfk_3` FOREIGN KEY (`UNIT`) REFERENCES `units` (`ID`),
  ADD CONSTRAINT `POACONCEPTS_ibfk_4` FOREIGN KEY (`EVIDENCE`) REFERENCES `evidences` (`ID`);

--
-- Filtros para la tabla `poas`
--
ALTER TABLE `poas`
  ADD CONSTRAINT `POAS_ibfk_1` FOREIGN KEY (`USER`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `POAS_ibfk_2` FOREIGN KEY (`STATUS`) REFERENCES `status` (`ID`),
  ADD CONSTRAINT `POAS_ibfk_4` FOREIGN KEY (`PDIPROJECT`) REFERENCES `pdiprojects` (`ID`);

--
-- Filtros para la tabla `subareas`
--
ALTER TABLE `subareas`
  ADD CONSTRAINT `SUBAREAS_ibfk_1` FOREIGN KEY (`AREA`) REFERENCES `areas` (`AREACODE`);

--
-- Filtros para la tabla `subareas_user`
--
ALTER TABLE `subareas_user`
  ADD CONSTRAINT `SUBAREAS_USER_ibfk_1` FOREIGN KEY (`USER`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `SUBAREAS_USER_ibfk_2` FOREIGN KEY (`SUBAREACODE`) REFERENCES `subareas` (`SUBAREACODE`),
  ADD CONSTRAINT `SUBAREAS_USER_ibfk_3` FOREIGN KEY (`DERIVATEDAREACODE`) REFERENCES `derivatedareas` (`CODE`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `USERS_ibfk_1` FOREIGN KEY (`ACADEMICDEGREE`) REFERENCES `academicdegrees` (`ID`),
  ADD CONSTRAINT `USERS_ibfk_2` FOREIGN KEY (`SUBAREA`) REFERENCES `subareas` (`SUBAREACODE`);

--
-- Filtros para la tabla `users_permissions`
--
ALTER TABLE `users_permissions`
  ADD CONSTRAINT `USERS_PERMISSIONS_ibfk_1` FOREIGN KEY (`USER`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `USERS_PERMISSIONS_ibfk_2` FOREIGN KEY (`PERMISSION`) REFERENCES `profiles` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
