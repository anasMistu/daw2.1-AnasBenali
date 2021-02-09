window.onload = inicializaciones;
var tablaCategorias;
// TODO ¿Útil para mantener un control de eliminaciones, etc.?     var categorias;



function inicializaciones() {
    tablaCategorias = document.getElementById("tablaCategorias");
    document.getElementById('submitCrearCategoria').addEventListener('click', clickCrearCategoria)

    cargarTodasLasCategorias();
}
//document.getElementById("submitCrearCategoria").addEventListener("click",clickCrearCategoria)
function cargarTodasLasCategorias() {
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var categorias = JSON.parse(this.responseText);

            for (var i=0; i<categorias.length; i++) {
                insertarCategoria(categorias[i]);
            }
        }
    };

    request.open("GET", "CategoriaObtenerTodas.php");
    request.send();
}

function clickCrearCategoria() {
    var nombreCategoria=document.getElementById("nombre").value;
    //alert(nombreCategoria);
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var categorias = JSON.parse(this.responseText);

            for (var i=0; i<categorias.length; i++) {
                insertarCategoria(categorias[i]);
            }
        }
    };

    request.open("GET", "CategoriaCrear.php?nombre="+nombreCategoria,true);
    request.send();

}

function insertarCategoria(categoria) {
    // TODO Que la categoría se inserte en el lugar que le corresponda según un orden alfabético.
    // Usar esto: https://www.w3schools.com/jsref/met_node_insertbefore.asp

    var tr = document.createElement("tr");
    var td = document.createElement("td");
    var a = document.createElement("a");
    var aEliminar = document.createElement("a");
    var trEliminar = document.createElement("tr");
   // var tdEliminar=document.createElement("td");
    a.setAttribute("href","CategoriaFicha.php?id=" + categoria.id);
    aEliminar.setAttribute("href","CategoriaEliminar.php?id=" + categoria.id);

    var textoContenido = document.createTextNode(categoria.nombre);
    var textoContenidoEliminar = document.createTextNode("(X)");

    a.appendChild(textoContenido);
    td.appendChild(a);
    tr.appendChild(td);
    //aEliminar.appendChild(textoContenidoEliminar);
   // td.appendChild(aEliminar);
    //trEliminar.appendChild(td);
    tablaCategorias.appendChild(tr)
   // tablaCategorias.appendChild(trEliminar);

}

function eliminarCategoria(id) {
    // TODO Pendiente de hacer.
}

function modificarCategoria(categoria) {
    // TODO Pendiente de hacer.
}

// TODO Actualizar lo local si actualizan el servidor. Poner timestamp de modificación en la tabla y pedir categoriaObtenerModificadasDesde(timestamp)