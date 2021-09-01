function validarprimeiro(theForm){
    var senhaatual = alterarsenha.txtsenhaatual;
    var senha1 = alterarsenha.txtsenha1;
    var senha2 = alterarsenha.txtsenha2;
    if (senhaatual.value == ""){
        alert("Senha Atual não informada!");
        rm.focus();
        return false;
    };
    if (senha1.value == ""){
        alert("Senha não informada!");
        senha1.focus();
        return false;
    };
    if (senha2.value == ""){
        alert("Senha não digitada novamente!");
        senha2.focus();
        return false;
    };
    if (senha1.value != senha2.value){
        alert("As senhas não conferem!");
        senha1.focus();
        return false;
    };
    return true;
}