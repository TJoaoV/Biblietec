function validar(theForm){
    var cpf = login.txtCPF;
    var senha = login.txtsenha;
    if (cpf.value == ""){
        alert("CPF não informado!");
        cpf.focus();
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