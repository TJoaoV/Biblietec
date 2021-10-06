function validaradm(theForm){
    var usuario = login.txtusuario;
    var senha = login.txtsenha;
    if (usuario.value == ""){
        alert("Usuário não informado!");
        usuario.focus();
        return false;
    } else {
        if (senha.value == ""){
            alert("Senha não informada!");
            senha.focus();
            return false;
        } else {
            return true;
        }
    }
}