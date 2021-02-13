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
            insertarCategoria(categorias);
        }
    };
    request.open("GET", "CategoriaCrear.php?nombre="+nombreCategoria,true);
    request.send();
    document.getElementById("nombre").value="";

}

function insertarCategoria(categoria) {
    var tr = document.createElement("tr");
    tr.setAttribute("id", "catDom"+categoria.id);//Darle un id al tr
    var tdNombre = document.createElement("td");
    var inputNombre = document.createElement("input");

    var tdEliminar = document.createElement("td");
    var btnEliminar = document.createElement("button");

    inputNombre.setAttribute("type","text");
    btnEliminar.setAttribute("id","catEliminar"+categoria.id);
    inputNombre.setAttribute("id","CatModificar"+categoria.id);

    var textoContenidoEliminar = document.createTextNode("(X)");

    /*Insertar el enlace*/
    inputNombre.value=categoria.nombre;//poner texto para el enlace
    inputNombre.readOnly=true;
    tdNombre.appendChild(inputNombre);//insertarlo en el td
    tdNombre.addEventListener("dblclick",cabiarInput)
    tdNombre.addEventListener("focusout",modificarCategoria);

    tr.appendChild(tdNombre);//inserttar el td en el tr
    btnEliminar.addEventListener("click", eliminarCategoria);
    btnEliminar.appendChild(textoContenidoEliminar);
    tdEliminar.appendChild(btnEliminar);
    tr.appendChild(tdEliminar);

    tablaCategorias.appendChild(tr)


}

function eliminarCategoria(e) {
   var idCategoria=e.target.id.substring(11,e.target.id.length+1);// extraer el id de la categoria
   //alert(idCategoria);
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {
            //alert(this.responseText);
            if(this.responseText==1){
                alert("Se ha borrado correctamente");
            }else{
                alert("Ha occurido algun error");
            }
            document.getElementById("catDom"+idCategoria).remove();
        }
    };

    request.open("GET", "CategoriaEliminar.php?id="+idCategoria,true);
    request.send();
}

function cabiarInput(e){
   // var idCategoria=e.target.id.substring(12,e.target.id.length+1);// extraer el id de la categoria
    document.getElementById(e.target.id).readOnly=false;
    //alert(idCategoria);
}

function modificarCategoria(e) {
    var idCategoria=e.target.id.substring(12,e.target.id.length+1);// extraer el id de la categoria
    var input=document.getElementById(e.target.id);
    var nombre=input.value;
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(this.responseText==1){
                alert("SE ha guardado");
            }else{
                alert("NOOOOOOOOOOOOOOOOOOO");
            }
            input.value=nombre;
        }
    };
    var url="CategoriaGuardar.php?id="+idCategoria+"&nombre="+nombre;
   // alert(url);
    request.open("GET", url,true);
    request.send();

}

// TODO Actualizar lo local si actualizan el servidor. Poner timestamp de modificación en la tabla y pedir categoriaObtenerModificadasDesde(timestamp)