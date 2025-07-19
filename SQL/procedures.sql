
-- Creacion de los procedures, aqui empiezan

-- PROCEDURE PARA EL LOGIN DEL EMPLEADO
DELIMITER //

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

CREATE PROCEDURE ObtenerEventosCliente(IN cliente_id INT)
BEGIN
    SELECT 
        c.EVENTO_ID,
        c.C_DNI,
        c.FECHAEVENTO,
        c.EVENTOTIPO,
        c.MONTO_ANTIGUO,
        c.MONTO_NUEVO,
        c.Estado_Antiguo,
        c.Estado_Nuevo,
        c.Autor_Evento
    FROM 
        CUENTAEVENTO c
    INNER JOIN CLIENTE cl ON cl.ID = cliente_id
    WHERE 
        cl.ID = cliente_id;
END //

DELIMITER ;


