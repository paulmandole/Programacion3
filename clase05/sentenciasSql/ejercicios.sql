/*1.*/
SELECT * FROM usuario ORDER BY nombre,apellido
/*2*/
select * from productos where tipo = 'liquido';
/*el like compara caracter por caracter de un string puedo usar like o = dependiendo */
/*3  between no s da un rango es como hacer el and*/
SELECT * FROM ventas WHERE ventas.cantidad BETWEEN 6 and 10;
/*4*/
select sum(cantidad) from ventas;
/*5*/
select * from venta order by fecha_de_venta asc limit 3;
/*6. Mostrar los nombres del usuario y los nombres de los productos de cada venta.*/
SELECT ventas.id,productos.nombre,usuarios.nombre FROM ventas INNER JOIN productos on ventas.id_producto = productos.id INNER join usuarios on ventas.id_usuario = usuarios.id;

/*7 Indicar el monto (cantidad * precio) por cada una de las ventas.*/
select ventas.cantidad*productos.precio FROM ventas INNER join productos on ventas.id_producto = productos.id;
/*8. Obtener la cantidad total del producto 1003 vendido por el usuario 1004.*/
SELECT sum(cantidad) from ventas WHERE id_producto = 1003 and id_usuario = 1004;
/*9. Obtener todos los números de los productos vendidos por algún usuario de avellaneda*/
SELECT ventas.id_producto from ventas INNER join usuarios on ventas.id_usuario = usuarios.id WHERE localidad= 'Avellaneda';

/*10.Obtener los datos completos de los usuarios cuyos nombres contengan la letra ‘u’*/
SELECT * from usuarios where nombre like '%u%';
/*11. Traer las ventas entre junio del 2020 y febrero 2021.*/
SELECT * from ventas where fecha_de_venta >'2020-6-01' and fecha_de_venta <'2021-1-1';

/*12. Obtener los usuarios registrados antes del 2021.*/
SELECT * from usuarios where fecha_de_registro < '2021-01-01';

/*13.Agregar el producto llamado ‘Chocolate’, de tipo Sólido y con un precio de 25,35.*/
/*insert INTO productos(codigo_de_barra, nombre,tipo, stock, precio,fecha_de_creacion,fecha_de_modificacion)
values(779311,'Chocolate','solido',25.35,10,'2022-09-21','2022-09-21');*/
/*14.Insertar un nuevo usuario
insert INTO usuarios(nombre,apellido,clave,mail,fecha_de_registro,localidad)values('Paul','Mandole','babilonia2','paulmandole@gmail.com','2022-09-21','caballito');*/

/*15.Cambiar los precios de los productos de tipo sólido a 66,60.*/
UPDATE productos set precio = 66.60 where tipo = 'solido';

/*16.Cambiar el stock a 0 de todos los productos cuyas cantidades de stock sean menores
a 20 inclusive.*/
update productos set stock = 0 where stock <=20;
/*17.Eliminar el producto número 1010.*/
DELETE from productos where id = 1010;
/*18.Eliminar a todos los usuarios que no han vendido productos. el exist espera un subconsulta al igual q el in*/
DELETE FROM usuarios
WHERE usuarios.id NOT IN (SELECT ventas.id_usuario FROM ventas)

SELECT * from productos;


/*update de varios campos ejm*/
update usuarios set nombre = :nombre,clave = :clave where id = :id