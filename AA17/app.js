// va a escuchar el evento de carga de la pagina 
window.addEventListener('load', ()=>{
    cargarProductos();
});
//funcion asincrona que lee el archivo json 
async function cargarProductos(){
    try {
        //se hace la peticion al archivo json
        //realizar peticiones HTTP de forma asíncrona y 
        // pausar la ejecución de la función hasta obtener la respuesta del servidor
        const response = await fetch('productos.json');
        // aca lo convertimos la respuesta del json 
        const productos= await response.json();
        //llamamos a la funcion que dibuja las tarjetas que bueno robamos jaja
        mostrarProductos(productos);
     } catch (error){
        console.error('error en la carga de productos', error);
     }
        

}
// funcion para renderizar los productos en forma de tarjetas 
function mostrarProductos(listarProductos){
    //seleccionamos el contenedor del HTML
    const contenedor= document.querySelector('#contenedor-productos');
    // por las dudas limpiamos con inner
    contenedor.innerHTML= ' ';
    // recorremos cada producto del json
    listarProductos.forEach(producto => {
        // necesitariamos un div para la tarjeta asi que 
        const tarjeta =document.createElement('div');

        // ahora aplicamos el css que despues enbellecemos 
        tarjeta.classList.add('tarjeta-producto');
        //ahora se intersecta el contenido del producto
        tarjeta.innerHTML= `
            <img src="${producto.imagen}" alt="${producto.nombre}">
            <h3>${producto.nombre}</h3>
            <p>$${producto.precio}</p>
        `;
        //por ultimo agregamos la tarjeta al contenedor principal 

        contenedor.appendChild(tarjeta);

        
    });
}