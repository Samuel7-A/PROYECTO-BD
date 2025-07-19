
-- Creacion de los procedures, aqui empiezan

-- PROCEDURE PARA EL LOGIN DEL EMPLEADO
DELIMITER //

CREATE PROCEDURE ValidarEmpleadoLogin (
    IN nombreCompleto VARCHAR(100),
    IN claveAcceso VARCHAR(10)
)
BEGIN
    SELECT * FROM EMPLEADOS
    WHERE 
        CONCAT(E_NOMBRE, ' ', E_APELLIDO) = nombreCompleto
        AND E_CLAVE = claveAcceso;
END //

DELIMITER ;
