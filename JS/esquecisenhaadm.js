function validarprimeiro(theForm){
    var CPF = esquecisenhaadm.txtCPF;
    var login = esquecisenhaadm.txtLogin;
    if (CPF.value == ""){
        alert("CPF não informado!");
        CPF.focus();
        return false;
    };
    if (login.value == ""){
        alert("Login não informado!");
        login.focus();
        return false;
    };
    return true;
}