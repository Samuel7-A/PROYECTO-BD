
INSERT INTO CLIENTES (
  C_DNI, C_NOMBRE, C_APELLIDO, C_DIRECCION, C_TELEFONO, C_CORREO, C_ESTADOCIVIL
) VALUES 
  ('12345678', 'Juan', 'Pérez', 'Av. Lima 123', '987654321', 'juan@gmail.com', 'soltero'),
  ('22345678', 'Juan2', 'Pérez2', 'Av. Lima 123', '987654321', 'juan2@gmail.com', 'soltero');

INSERT INTO CUENTAS (
  C_DNI, TIPOCUENTA, FECHACREACION, MONTO, MONEDATIPO
) VALUES
  ('12345678', 'Ahorros', '2023-05-12', 0.00, 'soles')
  ('22345678', 'Ahorros', '2023-05-12', 0.00, 'dolares');

INSERT INTO SUCURSALES (
    SUCURSAL_NOMBRE, SUCURSAL_DIRECCION, SUCURSAL_TELEFONO
) VALUES
    ('Sucursal Central', 'Av. Principal 123, Lima', '987654321'),
    ('Sucursal Norte', 'Calle Los Olivos 456, Trujillo', '912345678');

INSERT INTO EMPLEADOS (
    E_ID, E_CLAVE, E_NOMBRE, E_APELLIDO, E_CARGO, E_SUCURSAL, E_FECHA_CONTRATACION
) VALUES
    ('EMP001', '3333', 'Joel Fernando', 'Medina Lizana', 'Cajero', 1, '2025-05-12'),
    ('EMP002', '4444', 'Samuel Jeremy', 'Torres Ayala', 'Asistente de atención', 1, '2025-05-20'),
    ('EMP003', '5555', 'Cesar Augusto', 'Uscuvilca Zarasi', 'Jefe de área', 2, '2025-03-05');

INSERT INTO TARJETA (
  TARJETA_ID, CLAVETARJETA, C_DNI, TIPOTARJETA_ID, TIPOTARJETA_NOMBRE, TARJETA_ESTADO, TARJETA_MARCA
) VALUES
  (1234567891234567,'2222', '12345678', 1, 'Débito', 'activa', 'Visa')
  (2234567891234567,'4444', '22345678', 1, 'Débito', 'activa', 'Visa');

INSERT INTO INTENTOSFALLIDOS (
  TARJETA_ID, FECHAINTENTO
) VALUES
  (1234567891234567, '2024-07-12');
