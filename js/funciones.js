function eliminarRol(rol) {
    let eliminar = confirm('¿Esta seguro de eliminar el rol?');

    if (eliminar) {
        window.location = "../roles/delete.php?rol=" + rol;
    }else{
        window.location = "../roles/";
    }
}