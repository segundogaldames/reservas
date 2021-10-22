function eliminarRol() {
    let eliminar = confirm('¿Desea eliminar el rol');
    let form = document.form;

    if (eliminar) {
        form.submit();
    }else{
        window.location = "../roles/";
    }
}

function validaForm(){
    let form = document.form;

    if (form.nombre.value.length < 4) {
        alert('Ingrese el nombre del rol, con al menos 4 caracteres');
        form.nombre.value = '';
        form.nombre.focus();
        return false;
    }

    form.submit();
}