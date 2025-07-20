
-- Creacion de los triggers, aqui empiezan


-- TRIGGERS DEL empleado.php
-- Trigger para reconocer una transaccion y guardarla en la tabla CUENTAEVENTO
DELIMITER //

CREATE TRIGGER registrar_evento_deposito
AFTER INSERT ON TRANSACCIONES
FOR EACH ROW
BEGIN
    DECLARE monto_anterior DECIMAL(10,2);
    DECLARE monto_nuevo DECIMAL(10,2);

    -- Obtener el monto anterior de la cuenta
    SELECT MONTO INTO monto_anterior
    FROM CUENTAS
    WHERE C_DNI = NEW.C_DNI;

    -- Actualizar el monto en la cuenta
    UPDATE CUENTAS
    SET MONTO = MONTO + NEW.TRANSACCION_MONTO
    WHERE C_DNI = NEW.C_DNI;

    -- Obtener el nuevo monto después de actualizar
    SELECT MONTO INTO monto_nuevo
    FROM CUENTAS
    WHERE C_DNI = NEW.C_DNI;

    -- Insertar evento en CUENTAEVENTO solo si es un DEPÓSITO
    IF NEW.TRANSACCION_TIPO = 'deposito' THEN
        INSERT INTO CUENTAEVENTO (
            C_DNI,
            FECHAEVENTO,
            EVENTOTIPO,
            MONTO_ANTIGUO,
            MONTO_NUEVO,
            Estado_Antiguo,
            Estado_Nuevo
        )
        VALUES (
            NEW.C_DNI,
            NEW.TRANSACCION_FECHA,
            'deposito',
            monto_anterior,
            monto_nuevo,
            NULL,
            NULL
        );
    END IF;
END;
//

DELIMITER ;

-- 
DELIMITER $$
CREATE TRIGGER registrar_evento_estado_tarjeta
AFTER UPDATE ON TARJETA
FOR EACH ROW
BEGIN
    IF NEW.TARJETA_ESTADO = 'bloqueada' AND OLD.TARJETA_ESTADO != 'bloqueada' THEN
        INSERT INTO CUENTAEVENTO (
            C_DNI,
            FECHAEVENTO,
            EVENTOTIPO,
            MONTO_ANTIGUO,
            MONTO_NUEVO,
            Estado_Antiguo,
            Estado_Nuevo
        )
        VALUES (
            NEW.C_DNI,
            NOW(),
            'bloqueo de tarjeta',
            NULL,
            NULL,
            OLD.TARJETA_ESTADO,
            NEW.TARJETA_ESTADO
        );
    END IF;
END$$
DELIMITER ;
