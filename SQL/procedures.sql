
-- Creacion de los procedures, aqui empiezan

-- Procedure para registrar intento fallido y bloquear si hay 3

CREATE PROCEDURE ValidarEmpleadoPorID (
    IN p_E_ID VARCHAR(10),
    IN p_clave VARCHAR(10)
)
BEGIN
    SELECT * FROM EMPLEADOS
    WHERE 
        E_ID = p_E_ID
        AND E_CLAVE = p_clave;
END //

DELIMITER ;

-- PROCEDURE DE LOS CASOS

-- CASO 3: REGISTRO DE EVENTOS DEL CADA CLIENTE (FRONT EMPLEADO)
DELIMITER //

CREATE PROCEDURE ObtenerEventosCliente(IN cliente_id CHAR(8))
BEGIN
    SELECT 
        EVENTO_ID,
        C_DNI,
        FECHAEVENTO,
        EVENTOTIPO,
        MONTO_ANTIGUO,
        MONTO_NUEVO,
        Estado_Antiguo,
        Estado_Nuevo
    FROM CUENTAEVENTO
    WHERE C_DNI = cliente_id;
END //

DELIMITER ;


DELIMITER $$

CREATE PROCEDURE RegistrarIntentoFallido(IN p_tarjeta_id VARCHAR(16))
BEGIN
    DECLARE intentos INT;
    DECLARE estado_actual VARCHAR(20);

    -- Etiqueta para permitir salir del bloque
    bloque: BEGIN

        -- Obtener el estado actual de la tarjeta
        SELECT TARJETA_ESTADO INTO estado_actual
        FROM TARJETA
        WHERE TARJETA_ID = p_tarjeta_id;

        -- Si la tarjeta ya está bloqueada, salir del procedimiento
        IF estado_actual = 'bloqueada' THEN
            SELECT 0 AS intentos_restantes; -- o algún mensaje especial
            LEAVE bloque;
        END IF;

        -- Insertar intento fallido con la fecha de hoy
        INSERT INTO INTENTOSFALLIDOS (TARJETA_ID, FECHAINTENTO)
        VALUES (p_tarjeta_id, CURDATE());

        -- Contar cuántos intentos tiene esa tarjeta hoy
        SELECT COUNT(*) INTO intentos
        FROM INTENTOSFALLIDOS
        WHERE TARJETA_ID = p_tarjeta_id AND FECHAINTENTO = CURDATE();

        -- Si son 3 o más, bloquear tarjeta
        IF intentos >= 3 THEN
            UPDATE TARJETA
            SET TARJETA_ESTADO = 'bloqueada'
            WHERE TARJETA_ID = p_tarjeta_id;
        END IF;

        -- Mostrar cuántos intentos quedan
        SELECT GREATEST(3 - intentos, 0) AS intentos_restantes;

    END bloque;
END $$

DELIMITER ;



