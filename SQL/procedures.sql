
-- Creacion de los procedures, aqui empiezan

-- Procedure para registrar intento fallido y bloquear si hay 3

DELIMITER $$

CREATE PROCEDURE RegistrarIntentoFallido(IN p_tarjeta_id INT)
BEGIN
    DECLARE intentos INT;

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
END $$

DELIMITER ;

