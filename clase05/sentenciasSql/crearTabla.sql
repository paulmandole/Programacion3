/*crear una tabla con primary key auto incremental campos no nulos */
CREATE TABLE ventas_pizzas(
 	id int not null AUTO_INCREMENT,
    numero_pedido int not null,
    fecha date not null,
    email varchar(255) not null,
    sabor varchar(255) not null,
    tipo varchar(255) not null,
	cantidad int not null,
    PRIMARY KEY (id) 
);
/*moficar*/
alter TABLE ventas_pizzas
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000;