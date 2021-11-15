<?php
    date_default_timezone_set('America/Sao_Paulo'); 
    $datadehoje = date('Y-m-d');
    
    session_start();
    try{
        $idRecebido = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    } catch (Exception $e){
    };
    $nome = $_SESSION['nome'];
    $login = $_SESSION['usuario'];
    $usuarioadm = $_SESSION['id'];
    $permi = $_SESSION['permissao'];
    require("conexao.php");
    $sql = "SELECT * FROM corpo_emprestimo WHERE emp_devo='NÃO Devolvido' and cor_pego=0";
    $resultado = mysqli_query($conn, $sql);
    $sql2 = "SELECT * FROM corpo_emprestimo WHERE emp_devo='NÃO Devolvido' and cor_pego=1";
    $resultado2 = mysqli_query($conn, $sql2);
    $resultado3 = mysqli_query($conn, $sql2);
    $sql4 = "SELECT * FROM corpo_emprestimo WHERE emp_devo='Devolvido'";
    $resultado4 = mysqli_query($conn, $sql4);
    $sql5 = "SELECT * FROM livros";
    $resultado5 = mysqli_query($conn, $sql5);
    $sql6 = "SELECT * FROM categoria";
    $resultado6 = mysqli_query($conn, $sql6);
    $sql7 = "SELECT * FROM alunos";
    $resultado7 = mysqli_query($conn, $sql7);
    $sql8 = "SELECT * FROM cursos";
    $resultado8 = mysqli_query($conn, $sql8);
    $sql9 = "SELECT * FROM usuario WHERE usu_logi='$login'";
    $resultado9 = mysqli_query($conn, $sql9);
    $sql10 = "SELECT * FROM categoria";
    $resultado10 = mysqli_query($conn, $sql10);
    $sql11 = "SELECT * FROM categoria";
    $resultado11 = mysqli_query($conn, $sql11);
    $sql12 = "SELECT * FROM cursos";
    $resultado12 = mysqli_query($conn, $sql12);
    $sql13 = "SELECT * FROM usuario";
    $resultado13 = mysqli_query($conn, $sql13);
    $resultado9_ = mysqli_fetch_assoc($resultado9);
?>
<html lang="pt">

<head>
    <title>Biblietec - Administração</title>
    <?php include('imports.php'); ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript" src="../JS/home_adm.js"></script>
    <script>
    window.addEventListener("load", () => {
        var idrecebidoreload = document.getElementById('variavelid').value;
        if (idrecebidoreload == "") {
            carregou();
        };
        if (idrecebidoreload == "1") {
            btnEmprestimos()
        };
        if (idrecebidoreload == "2") {
            btnConfigLivros();
        };
        if (idrecebidoreload == "3") {
            alterarCadAlunos();
        };
        if (idrecebidoreload == "4") {
            btnNome();
        };
        if (idrecebidoreload == "5") {
            btnEmprestimos();
            ParaEntregar();
        };
        if (idrecebidoreload == "6") {
            btnEmprestimos();
            EmProgresso();
        };
        if (idrecebidoreload == "7") {
            btnEmprestimos();
            EmAtraso();
        };
        if (idrecebidoreload == "8") {
            btnEmprestimos();
            Devolvido();
        };
        if (idrecebidoreload == "9") {
            btnCategoria();
        };
        if (idrecebidoreload == "10") {
            btnCurso();
        };
        if (idrecebidoreload == "11") {
            btnUsuario();
        };
    });

    function btnUsuario() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
            `<h3 class="corpoTitle"> Procurar Usuário </h3><br>
            <hr class="hrTitle"><br>
            <input class="form-control pesquisa corpoInputtxt" type="text" id="inlineFormInputGroup" placeholder="Digite o Usuário aqui!" >
            <table>
            <ul class="lista" style="list-style-type:none;  ">
            <?php 
                while ($exibir15 = mysqli_fetch_assoc($resultado13)) {
                    $exibir16 = strtolower($exibir15['usu_nome']);
                    echo "<li class='listaOpcao pointer' onClick='VerUsuario($exibir15[usu_codi])' nome='$exibir16' id='$exibir15[usu_codi]'> $exibir15[usu_nome]</li>";
                }
            ?>
            </ul>
            </table>`;
        document.getElementById('main3').innerHTML =
            `
            <input class='botVerm pointer' type='button' onClick ='adicionarUsuario()' value=' Adicionar Usuário ' id='btnAddUsuario'><br>`;
        // FUNÇÃO DE "PESQUISA" NA PÁGINA HOME > PROCURAR
        pesquisa_input = document.querySelectorAll(".pesquisa");
        for (i in pesquisa_input) {
            pesquisa_input[i].onkeyup = function(e) {
                document.getElementById('main2').innerHTML = "";
                reg = new RegExp(this.value.toLowerCase(), "g");
                lis = this.parentElement.querySelector(".lista");
                //console.log(lis);
                for (j of lis.children) {
                    if (!j.getAttribute("nome").match(reg))
                        j.style.display = "none";
                    else
                        j.removeAttribute("style");
                };
            };
        };
    };

    function adicionarUsuario() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main3').innerHTML = "";
        document.getElementById('main1').innerHTML = `
            <h3 class="corpoTitle"> Adicionar Usuário </h3><br>
            <hr class="hrTitle"><br>
            <p class="corpoText"><b>Preencha as informações abaixo para adicionar</b></p>
            <div class="corpoCadastro">
            <input class='botVerm pointer' type='button' onClick ='btnUsuario()' value=' Voltar ' id='btnVoltarUsuario'><br>
            <form method='POST' name='addUsuario' onsubmit="return validaraddusuario(this);">
                <br>
                <h3> Nome: </h3>
                <input type='text' id='txtNomeUsuADD' maxlength="100" placeholder='Digite o Nome'> <br>
                <h3> Login: </h3>
                <input type='text' id='txtLoginADD' maxlength="50" placeholder='Digite o Login'><br>
                <h3> CPF: </h3>
                <input type='text' id='txtCPFADD' maxlength="11" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder='Digite o CPF (Somente Números)'><br>
                <h3> Endereço: </h3>
                <input type='text' id='txtEndeADD' maxlength="100" placeholder='Digite o Endereço'><br>
                <h3> Data de Nascimento: </h3>
                <input type='date' id='txtDtnaADD'><br>
                <h3> Telefone: </h3>
                <input type='text' id='txtTeleADD' maxlength="10" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder='Digite o Telefone (Somente Números)'><br>
                <h3> Celular: </h3>
                <input type='text' id='txtCeluADD' maxlength="11" onkeypress="return event.charCode >= 48 && event.charCode <= 57" placeholder='Digite o Celular (Somente Números)'><br>
                <h3> E-mail: </h3>
                <input type='email' id='txtEmailADD' maxlength="150" placeholder='Digite o E-mail'><br>
                <h3> Permissão: </h3>
                <select id='selectPermissaoADD' name='selectPermissaoADD'>
                    <option value='-'> Selecione a Permissão </option>
                    <option value='Administrador'> Administrador </option>
                    <option value='Bibliotecario'> Bibliotecário </option>
                </select>
                <h3> Ativo: </h3>
                <select id='selectAtivoADD' name='selectAtivoADD'>
                    <option value='1'> Ativo </option>
                    <option value='0'> Inativo </option>
                </select>
                <input class='botVerm pointer' type='submit' value='Adicionar Usuário'>
            </form>
            </div>
        `;
    };

    function adicionarUsuarioBD() {
        var nomeUsuADD = document.getElementById('txtNomeUsuADD').value;
        var loginADD = document.getElementById('txtLoginADD').value;
        var cpfUsuADD = document.getElementById('txtCPFADD').value;
        var endeADD = document.getElementById('txtEndeADD').value;
        var dtnaADD = document.getElementById('txtDtnaADD').value;
        var teleADD = document.getElementById('txtTeleADD').value;
        var celuADD = document.getElementById('txtCeluADD').value;
        var emailADD = document.getElementById('txtEmailADD').value;
        var permiADD = document.getElementById('selectPermissaoADD').value;
        var ativoADD = document.getElementById('selectAtivoADD').value;
        $.ajax({
            url: 'others/adicionarusuario_adm.php',
            type: 'POST',
            data: {
                nomeUsuADD: nomeUsuADD,
                loginADD: loginADD,
                cpfUsuADD: cpfUsuADD,
                endeADD: endeADD,
                dtnaADD: dtnaADD,
                teleADD: teleADD,
                celuADD: celuADD,
                emailADD: emailADD,
                permiADD: permiADD,
                ativoADD: ativoADD
            },
            success: function(retornoUsu) {
                alert(retornoUsu);
            },
            error: function(jqXHR, textStatus) {
                console.log('error ' + textStatus + " " + jqXHR);
            }
        });
    };

    function VerUsuario(id) {
        var codigoadm = document.getElementById('codigoadm').value;
        document.getElementById('main3').innerHTML = "";
        var idUsuario = id;
        if (idUsuario == "-") {
            document.getElementById('main2').innerHTML = "";
            alert("Selecione um Usuário!");
        } else {
            $.ajax({
                url: 'others/verusuario_adm.php',
                dataType: 'json',
                type: 'POST',
                data: {
                    idUsuario: idUsuario
                },
                success: function(dados) {
                    document.getElementById('main2').innerHTML =
                        `<div class="result">
                        <hr class='hrMain'>
                        <div class="corpoCadastro"> <br>
                        <input class='botVerm pointer' type='button' onClick ='btnUsuario()' value=' Voltar ' id='btnVoltarLivro'><br>
                        <h3> Código do Usuário: </h3>
                        <input type='text' id='txtCodiUsuario' readonly value='` + dados.codigo + `'> <br>
                        <h3> Nome: </h3>
                        <input type='text' id='txtNomeUsuario' maxlength="100" value='` + dados.nome + `'><br>
                        <h3> Login: </h3>
                        <input type='text' id='txtLoginUsuario' maxlength="50"  value='` + dados.login + `'><br>
                        <h3> CPF: </h3>
                        <input type='text' id='txtCPFUsuario' value='` + dados.cpf + `' readonly><br>
                        <h3> Endereço: </h3>
                        <input type='text' id='txtEndeUsuario' maxlength="100" value='` + dados.endereco + `'><br>
                        <h3> Data de Nascimento: </h3>
                        <input type='date' id='txtDtNaUsuario' value='` + dados.dtna +
                        `' readonly><br>
                        <h3> Telefone: </h3>
                        <input type='text' id='txtTelefoneUsuario' onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10" value='` +
                        dados
                        .telefone +
                        `'><br>
                        <h3> Celular: </h3>
                        <input type='text' id='txtCelularUsuario' onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="11" value='` +
                        dados.celular + `'><br>
                        <h3> E-mail: </h3>
                        <input type='text' id='txtEmailUsuario' maxlength="150" value='` + dados.email + `'><br>
                        <h3> Permissão Antiga: </h3>
                        <input type='text' id='txtPermiOLDUsuario' value='` + dados.permissao + `' readonly><br>
                        <h3> Permissão Nova: </h3>
                        <select id='selectPermiNova' name='selectPermiNova'>
                            <option value='-'> Selecione a Nova Permissão </option>
                            <option value='Administrador'> Administrador </option>
                            <option value='Bibliotecario'> Bibliotecário </option>
                        </select>
                        <h3> Situação Senha: </h3>
                        <input type='text' id='txtSenhaUsuario' value='` + dados.senha + `' readonly><br>
                        <h3> Status Antigo: </h3>
                        <input type='text' id='txtSituacaoOLDUsuario' value='` + dados.situacao + `' readonly><br>
                        <h3> Status Novo: </h3>
                        <select id='selectSituacaoUsuario' name='selectSituacaoUsuario'>
                            <option value='-'> Selecione o Novo Status do Usuário </option>
                            <option value='1'> Usuário Ativo </option>
                            <option value='0'> Usuário Inativo </option>
                        </select>
                        <input class='botVerm pointer' type='button' onClick ='redefinirsenhausuario(` + dados.codigo + `, <?php echo $usuarioadm?>)' value=' Redefinir Senha ' id='btnRedefinirSenhaUsuario'><br>
                        <input class='botVerm pointer' type='button' onClick ='edicaousuario(` + dados.codigo + `)' value=' Salvar Alterações ' id='btnSalvarAlteracoesUsuario'><br>
                        </div>
                        </div>`;
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        }
    };

    function redefinirsenhausuario(idUsuario, usuarioadm) {
        var senha = prompt("Digite sua senha para confirmação:");
        if (senha != null) {
            $.ajax({
                url: 'others/redefinirsenhaUsuario_adm.php',
                type: 'POST',
                data: {
                    idUsuario: idUsuario,
                    usuarioadm: usuarioadm,
                    senha: senha
                },
                success: function(retorno) {
                    alert(retorno);
                    document.location.reload(true);
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        };
    }

    function edicaousuario(codigo) {
        var codigoUsu = document.getElementById('txtCodiUsuario').value;
        var nomeUsu = document.getElementById('txtNomeUsuario').value;
        var loginUsu = document.getElementById('txtLoginUsuario').value;
        var endeUsu = document.getElementById('txtEndeUsuario').value;
        var teleUsu = document.getElementById('txtTelefoneUsuario').value;
        var celuUsu = document.getElementById('txtCelularUsuario').value;
        var emailUsu = document.getElementById('txtEmailUsuario').value;
        var permiOLDUsu = document.getElementById('txtPermiOLDUsuario').value;
        var permiNEWUsu = document.getElementById('selectPermiNova').value;
        var situacaoOLDUsu = document.getElementById('txtSituacaoOLDUsuario').value;
        var situacaoNEWUsu = document.getElementById('selectSituacaoUsuario').value;
        $.ajax({
            url: 'others/edicaoUsuario_adm.php',
            type: 'POST',
            data: {
                codigoUsu: codigoUsu,
                nomeUsu: nomeUsu,
                loginUsu: loginUsu,
                endeUsu: endeUsu,
                teleUsu: teleUsu,
                celuUsu: celuUsu,
                emailUsu: emailUsu,
                permiOLDUsu: permiOLDUsu,
                permiNEWUsu: permiNEWUsu,
                situacaoOLDUsu: situacaoOLDUsu,
                situacaoNEWUsu: situacaoNEWUsu
            },
            success: function(dadosretorno) {
                alert(dadosretorno);
                document.location.reload(true);
            },
            error: function(jqXHR, textStatus) {
                console.log('error ' + textStatus + " " + jqXHR);
            }
        });
    };

    function btnCurso() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
            `<h3 class="corpoTitle"> Procurar Curso </h3><br>
            <hr class="hrTitle"><br>
            <input class="form-control pesquisa corpoInputtxt" type="text" id="inlineFormInputGroup" placeholder="Digite o Curso aqui!" >
            <table>
            <ul class="lista" style="list-style-type:none;  ">
            <?php 
                while ($exibir13 = mysqli_fetch_assoc($resultado12)) {
                    $exibir14 = strtolower($exibir13['cur_nome']);
                    echo "<li class='listaOpcao pointer' onClick='VerCurso($exibir13[cur_codi])' nome='$exibir14' id='$exibir13[cur_codi]'> $exibir13[cur_nome]</li>";
                }
            ?>
            </ul>
            </table>`;
        document.getElementById('main3').innerHTML =
            `
            <input class='botVerm pointer' type='button' onClick ='adicionarCurso()' value=' Adicionar Curso ' id='btnAddCurso'><br>`;
        // FUNÇÃO DE "PESQUISA" NA PÁGINA HOME > PROCURAR
        pesquisa_input = document.querySelectorAll(".pesquisa");
        for (i in pesquisa_input) {
            pesquisa_input[i].onkeyup = function(e) {
                document.getElementById('main2').innerHTML = "";
                reg = new RegExp(this.value.toLowerCase(), "g");
                lis = this.parentElement.querySelector(".lista");
                //console.log(lis);
                for (j of lis.children) {
                    if (!j.getAttribute("nome").match(reg))
                        j.style.display = "none";
                    else
                        j.removeAttribute("style");
                };
            };
        };
    };

    function adicionarCurso() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main3').innerHTML = "";
        document.getElementById('main1').innerHTML = `
            <h3 class="corpoTitle"> Adicionar Curso </h3><br>
            <hr class="hrTitle"><br>
            <p class="corpoText"><b>Preencha as informações abaixo para adicionar</b></p>
            <div class="corpoCadastro">
            <input class='botVerm pointer' type='button' onClick ='btnCurso()' value=' Voltar ' id='btnVoltarLivro'><br>
            <form method='POST' name='addCurso' onsubmit="return validaraddcurso(this);">
                <br>
                <h3> Nome do Curso: </h3>
                <input type='text' id='txtNomeADD' maxlength="100" placeholder="Digite o Nome do Curso"> <br>
                <h3> Duração: </h3>
                <input type='text' id='txtDuracaoADD' maxlength="20" placeholder="Digite a Duração do Curso"><br>
                <h3> Período: </h3>
                <select id='selectPeriodoADD' name='selectPeriodoADD'>
                    <option value='-'> Selecione o Período </option>
                    <option value='INTEGRAL'> INTEGRAL </option>
                    <option value='MANHA'> MANHA </option>
                    <option value='TARDE'> TARDE </option>
                    <option value='NOITE'> NOITE </option>
                </select>
                <input class='botVerm pointer' type='submit' value='Adicionar Curso'>
            </form>
            </div>
        `;
    };

    function adicionarCursoBD() {
        var nomeADD = document.getElementById('txtNomeADD').value;
        var duracaoADD = document.getElementById('txtDuracaoADD').value;
        var periodoADD = document.getElementById('selectPeriodoADD').value;
        $.ajax({
            url: 'others/adicionarcurso_adm.php',
            type: 'POST',
            data: {
                nomeADD: nomeADD,
                duracaoADD: duracaoADD,
                periodoADD: periodoADD
            },
            success: function(retornoCurso) {
                alert(retornoCurso);
                document.location.reload(true);
            },
            error: function(jqXHR, textStatus) {
                console.log('error ' + textStatus + " " + jqXHR);
            }
        });
    };

    function VerCurso(id) {
        var codigoadm = document.getElementById('codigoadm').value;
        document.getElementById('main3').innerHTML = "";
        var idCurso = id;
        if (idCurso == "-") {
            document.getElementById('main2').innerHTML = "";
            alert("Selecione um Curso!");
        } else {
            $.ajax({
                url: 'others/vercurso_adm.php',
                dataType: 'json',
                type: 'POST',
                data: {
                    idCurso: idCurso
                },
                success: function(dados) {
                    document.getElementById('main2').innerHTML =
                        `<div class="result">
                        <hr class='hrMain'>
                        <div class="corpoCadastro"> <br>
                        <input class='botVerm pointer' type='button' onClick ='btnCurso()' value=' Voltar ' id='btnVoltarLivro'><br>
                        <h3> Código do Curso: </h3>
                        <input type='text' id='txtCodiCurso' readonly value='` + dados.codigo + `'> <br>
                        <h3> Nome: </h3>
                        <input type='text' id='txtNomeCurso' maxlength="100"  value='` + dados.nome + `'><br>
                        <h3> Duração: </h3>
                        <input type='text' id='txtDuracaoCurso' maxlength="20" value='` + dados.duracao + `'><br>
                        <h3> Período Antigo: </h3>
                        <input type='text' id='txtPeriodoAntigoCurso' value='` + dados.periodo + `' readonly><br>
                        <h3> Período Novo: </h3>
                        <select id='selectPeriodoNovo' name='selectPeriodoNovo'>
                            <option value='-'> Selecione o Novo Período </option>
                            <option value='INTEGRAL'> INTEGRAL </option>
                            <option value='MANHA'> MANHA </option>
                            <option value='TARDE'> TARDE </option>
                            <option value='NOITE'> NOITE </option>
                        </select>
                        <br>
                        <input class='botVerm pointer' type='button' onClick ='edicaocurso(` + dados.codigo + `)' value=' Salvar Alterações ' id='btnSalvarAlteracoesCurso'><br>
                        </div>
                        </div>`;
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        }
    };

    function edicaocurso(codigo) {
        var codi = document.getElementById('txtCodiCurso').value;
        var newnomec = document.getElementById('txtNomeCurso').value;
        var newduracao = document.getElementById('txtDuracaoCurso').value;
        var oldperiodo = document.getElementById('txtPeriodoAntigoCurso').value;
        var newperiodo = document.getElementById('selectPeriodoNovo').value;
        $.ajax({
            url: 'others/edicaoCurso_adm.php',
            type: 'POST',
            data: {
                codi: codi,
                newnomec: newnomec,
                newduracao: newduracao,
                oldperiodo: oldperiodo,
                newperiodo: newperiodo
            },
            success: function(dadosretorno) {
                alert(dadosretorno);
                document.location.reload(true);
            },
            error: function(jqXHR, textStatus) {
                console.log('error ' + textStatus + " " + jqXHR);
            }
        });
    };

    function btnCategoria() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
            `<h3 class="corpoTitle"> Procurar Categoria </h3><br>
            <hr class="hrTitle"><br>
            <input class="form-control pesquisa corpoInputtxt" type="text" id="inlineFormInputGroup" placeholder="Digite a Categoria aqui!" >
            <table>
            <ul class="lista" style="list-style-type:none;  ">
            <?php 
                while ($exibir11 = mysqli_fetch_assoc($resultado11)) {
                    $exibir12 = strtolower($exibir11['cat_nome']);
                    echo "<li class='listaOpcao pointer' onClick='VerCategoria($exibir11[cat_codi])' nome='$exibir12' id='$exibir11[cat_codi]'> $exibir11[cat_nome]</li>";
                }
            ?>
            </ul>
            </table>`;
        document.getElementById('main3').innerHTML =
            `
            <input class='botVerm pointer' type='button' onClick ='adicionarCategoria()' value=' Adicionar Categoria ' id='btnAddCategoria'><br>`;
        // FUNÇÃO DE "PESQUISA" NA PÁGINA HOME > PROCURAR
        pesquisa_input = document.querySelectorAll(".pesquisa");
        for (i in pesquisa_input) {
            pesquisa_input[i].onkeyup = function(e) {
                document.getElementById('main2').innerHTML = "";
                reg = new RegExp(this.value.toLowerCase(), "g");
                lis = this.parentElement.querySelector(".lista");
                //console.log(lis);
                for (j of lis.children) {
                    if (!j.getAttribute("nome").match(reg))
                        j.style.display = "none";
                    else
                        j.removeAttribute("style");
                };
            };
        };
    };

    function adicionarCategoria() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main3').innerHTML = "";
        document.getElementById('main1').innerHTML = `
            <h3 class="corpoTitle"> Adicionar Categoria </h3><br>
            <hr class="hrTitle"><br>
            <p class="corpoText"><b>Preencha as informações abaixo para adicionar</b></p>
            <div class="corpoCadastro">
            <input class='botVerm pointer' type='button' onClick ='btnCategoria()' value=' Voltar ' id='btnVoltarLivro'><br>
            <form method='POST' name='addCategoria' onsubmit="return validaraddcategoria(this);">
                <br>
                <h3> Nome da Categoria: </h3>
                <input type='text' id='txtCateADD' maxlength="60" placeholder="Digite o nome da Categoria"> <br>
                <input class='botVerm pointer' type='submit' value='Adicionar Categoria'>
            </form>
            </div>
        `;
    };

    function adicionarCategoriaBD() {
        var categoriaADD = document.getElementById('txtCateADD').value;
        $.ajax({
            url: 'others/adicionarcategoria_adm.php',
            type: 'POST',
            data: {
                categoriaADD: categoriaADD
            },
            success: function(retornoCategoria) {
                alert(retornoCategoria);
                document.location.reload(true);
            },
            error: function(jqXHR, textStatus) {
                console.log('error ' + textStatus + " " + jqXHR);
            }
        });
    };

    function VerCategoria(id) {
        var codigoadm = document.getElementById('codigoadm').value;
        document.getElementById('main3').innerHTML = "";
        var idCategoria = id;
        if (idCategoria == "-") {
            document.getElementById('main2').innerHTML = "";
            alert("Selecione uma Categoria!");
        } else {
            $.ajax({
                url: 'others/vercategoria_adm.php',
                dataType: 'json',
                type: 'POST',
                data: {
                    idCategoria: idCategoria
                },
                success: function(dados) {
                    document.getElementById('main2').innerHTML =
                        `<div class="result">
                        <hr class='hrMain'>
                        <div class="corpoCadastro"> <br>
                        <input class='botVerm pointer' type='button' onClick ='btnCategoria()' value=' Voltar ' id='btnVoltarLivro'><br>
                        <h3> Código da Categoria: </h3>
                        <input type='text' id='txtCodiCat' readonly value='` + dados.codigo + `'> <br>
                        <h3> Nome: </h3>
                        <input type='text' id='txtNomeCat' maxlength="60" value='` + dados.nome + `'><br>
                        <input class='botVerm pointer' type='button' onClick ='edicaocategoria(` + dados.codigo + `)' value=' Salvar Alterações ' id='btnSalvarAlteracoesAluno'><br>
                        </div>
                        </div>`;
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        }
    };

    function edicaocategoria(codigo) {
        var codi = document.getElementById('txtCodiCat').value;
        var newnomec = document.getElementById('txtNomeCat').value;
        $.ajax({
            url: 'others/edicaoCategoria_adm.php',
            type: 'POST',
            data: {
                codi: codi,
                newnomec: newnomec,
            },
            success: function(dadosretorno) {
                alert(dadosretorno);
                document.location.reload(true);
            },
            error: function(jqXHR, textStatus) {
                console.log('error ' + textStatus + " " + jqXHR);
            }
        });
    };

    function atualizarsenha(usuarioadm) {
        var senhaantiga = document.getElementById('senhaantiga').value;
        var senhanova1 = document.getElementById('senhanova1').value;
        var senhanova2 = document.getElementById('senhanova2').value;
        if (senhaantiga == "") {
            alert("Senha antiga não preenchida!");
            senhaantiga.focus();
        } else if (senhanova1 == "") {
            alert("Nova senha não preenchida!");
            senhanova1.focus();
        } else if (senhanova2 == "") {
            alert("Confirmação de senha não preenchido!");
            senhanova2.focus();
        } else if (senhanova2 != senhanova1) {
            alert("As senhas não coincidem!");
        } else {
            $.ajax({
                url: 'others/alterarsenhaadm_config.php',
                type: 'POST',
                data: {
                    usuarioadm: usuarioadm,
                    senhaantiga: senhaantiga,
                    senhanova1: senhanova1,
                    senhanova2: senhanova2,
                },
                success: function(retornomudancasenha) {
                    alert(retornomudancasenha);
                    document.location.reload(true);
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        };
    };

    function atualizarcadastro(usuario_adm) {
        var newnome = document.getElementById('nomenovo').value;
        var newusuario = document.getElementById('usuarionovo').value;
        var newtelefone = document.getElementById('telefonenovo').value;
        var newcelular = document.getElementById('celularnovo').value;
        var newemail = document.getElementById('emailnovo').value;
        var newendereco = document.getElementById('endereconovo').value;
        if (newtelefone && newcelular == "") {
            alert('Preencher pelo menos um telefone!');
        } else if (newemail == "") {
            alert('Preencher email!');
            newemail.focus();
        } else if (newusuario == "") {
            alert('Preencher o usuário!');
            newcurso.focus();
        } else if (newnome == "") {
            alert('Preencher o nome!');
            newnome.focus();
        } else if (newendereco == "") {
            alert('Preencher o endereço!');
            newendereco.focus();
        } else {
            $.ajax({
                url: 'others/atualizarcadastroadm.php',
                type: 'POST',
                data: {
                    usuario_adm: usuario_adm,
                    newnome: newnome,
                    newusuario: newusuario,
                    newtelefone: newtelefone,
                    newcelular: newcelular,
                    newemail: newemail,
                    newendereco: newendereco
                },
                success: function(retornoatualização) {
                    alert(retornoatualização);
                    document.location.reload(true);
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        }
    };

    function btnNome() {
        document.getElementById('main3').innerHTML = "";
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML = `
        <h3 class="corpoTitle"> Configurações </h3><br>
        <hr class="hrTitle"><br>
        <div class="corpoCadastro">
        <br>
            <h3> Nome: </h3>
            <input type='text' id='nomenovo' value='<?php echo $resultado9_['usu_nome']?>' >
            <h3> CPF: </h3>
            <input type='text' value='<?php echo $resultado9_['usu_cpf']?>' readonly disabled>
            <?php
                $ano= substr($resultado9_['usu_dtna'], 0,4);
                $mes= substr($resultado9_['usu_dtna'], 5,2);
                $dia= substr($resultado9_['usu_dtna'], 8,2);
            ?>
            <h3> Data de Nascimento: </h3>
            <input type='text' value='<?php echo $dia."/".$mes."/".$ano?>' readonly disabled><br>
            <h3> Usuário: </h3>
            <input type='text' id='usuarionovo' value='<?php echo $resultado9_['usu_logi']?>'>
            <h3> Telefone: </h3>
            <input type='text' id='telefonenovo' maxlength="10" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value='<?php echo $resultado9_['usu_tele']?>'>
            <h3> Celular: </h3>
            <input type='text' id='celularnovo' maxlength="11" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value='<?php echo $resultado9_['usu_celu']?>'>
            <h3> Email: </h3>
            <input type='email' id='emailnovo' value='<?php echo $resultado9_['usu_emai']?>'>
            <h3> Endereço: </h3>
            <input type='text' id='endereconovo' value='<?php echo $resultado9_['usu_ende']?>'>
            <?php
                echo "<br><br> <input class='botVerm pointer' type='button' href='home.php' onclick='atualizarcadastro($usuarioadm)' value='Salvar Alterações'>";
            ?><br><br>
            <hr class="hrMain" style="width: 90%;">
            <h2> Alterar Senha </h2>
            <h3> Senha Antiga: </h3>
            <input type='password' id='senhaantiga' maxlength="150" placeholder="Digite sua senha antiga"'>
            <h3> Senha Nova: </h3>
            <input type='password' id='senhanova1' maxlength="150" placeholder="Digite sua nova senha"'>
            <h3> Confirmação Senha Nova: </h3>
            <input type='password' id='senhanova2' maxlength="150" placeholder="Digite sua nova senha novamente"'>
            <?php echo "<br><br> <input class='botVerm pointer' type='button' href='home_adm.php' onclick='atualizarsenha($usuarioadm)' value='Alterar Senha'>"; ?>
            <br>`;
    };

    function alterarCadAlunos() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
            `<h3 class="corpoTitle"> Procurar Alunos </h3><br>
            <hr class="hrTitle"><br>
            <input class="form-control pesquisa corpoInputtxt" type="text" id="inlineFormInputGroup" placeholder="Digite o nome aqui!" >
            <table>
            <ul class="lista" style="list-style-type:none;  ">
            <?php 
                while ($exibir5 = mysqli_fetch_assoc($resultado7)) {
                    $exibir6 = strtolower($exibir5['alu_nome']);
                    echo "<li class='listaOpcao pointer' onClick='VerAluno($exibir5[alu_codi])' nome='$exibir6' id='$exibir5[alu_codi]'> $exibir5[alu_nome]</li>";
                }
            ?>
            </ul>
            </table>`;
        document.getElementById('main3').innerHTML = "";
        // FUNÇÃO DE "PESQUISA" NA PÁGINA HOME > PROCURAR
        pesquisa_input = document.querySelectorAll(".pesquisa");
        for (i in pesquisa_input) {
            pesquisa_input[i].onkeyup = function(e) {
                document.getElementById('main2').innerHTML = "";
                reg = new RegExp(this.value.toLowerCase(), "g");
                lis = this.parentElement.querySelector(".lista");
                //console.log(lis);
                for (j of lis.children) {
                    if (!j.getAttribute("nome").match(reg))
                        j.style.display = "none";
                    else
                        j.removeAttribute("style");
                };
            };
        };
    };

    function VerAluno(id) {
        var codigoadm = document.getElementById('codigoadm').value;
        document.getElementById('main3').innerHTML = "";
        var idaluno = id;
        if (idaluno == "-") {
            document.getElementById('main2').innerHTML = "";
            alert("Selecione um Aluno!");
        } else {
            $.ajax({
                url: 'others/veraluno_adm.php',
                dataType: 'json',
                type: 'POST',
                data: {
                    idaluno: idaluno
                },
                success: function(dados) {
                    document.getElementById('main2').innerHTML =
                        `<div class="result">
                        <hr class='hrMain'>
                        <div class="corpoCadastro"> <br>
                        <input class='botVerm pointer' type='button' onClick ='alterarCadAlunos()' value=' Voltar ' id='btnVoltarLivro'><br>
                        <h3> Código do Aluno: </h3>
                        <input type='text' id='txtCodi' readonly value='` + dados.codigo +
                        `'> <br>
                        <h3> RM: </h3>
                        <input type='text' id='txtRM' onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="11" value='` +
                        dados.rm + `'> <br>
                        <h3> Nome: </h3>
                        <input type='text' id='txtNome' maxlength="100" value='` + dados.nome + `'><br>
                        <h3> CPF: </h3>
                        <input type='text' id='txtCPF' readonly value='` + dados.cpf +
                        `'><br>
                        <h3> Telefone: </h3>
                        <input type='text' id='txtTelefone' onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10" value='` +
                        dados.telefone +
                        `'><br>
                        <h3> Celular: </h3>
                        <input type='text'id='txtCelular' onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="11" value='` +
                        dados.celular + `'><br>
                        <h3> Email: </h3>
                        <input type='email' id='txtEmail' maxlength="150" value='` + dados.email + `'><br>
                        <h3> Data de Nascimento: </h3>
                        <input type='date' id='txtDtNascimento' value='` + dados.datanascimento + `'><br>
                        <h3> Antigo Curso: </h3>
                        <input type='text' id='txtCursoAntigo' disabled readoly size="50" name='` + dados.cursoid +
                        `' value='` + dados.cursonome + `'><br>
                        <h3> Novo Curso: </h3>
                        <?php
                            echo "<select id='selectCursoNovo' name='selectCursoNovo'>";
                            echo "<option value='-'> Selecione o Novo Curso </option>";
                            while ($exibircur = mysqli_fetch_assoc($resultado8)) {
                                echo "<option value='$exibircur[cur_codi]'> $exibircur[cur_nome] - Duração $exibircur[cur_dura] - Período $exibircur[cur_peri]</option>";
                            };
                            echo "</select>";
                        ?><br>
                        <h3> Situação Senha: </h3>
                        <input type='text' id='txtSitSenha' value='` + dados.senharedefinida + `' disabled>
                        <span style="padding: 10%; font-size: 1rem;">(0: Senha normal | 1: Redefinição Solicitada/Pendente)</span> <br>
                        <input class='botVerm pointer' type='button' onClick ='edicaoaluno(` + dados.codigo + `)' value=' Salvar Alterações ' id='btnSalvarAlteracoesAluno'><br>
                        <input class='botVerm pointer' type='button' onClick ='redefinirsenhaaluno(` + dados.codigo +
                        `, ` + codigoadm + `)' value=' Redefinir Senha ' id='btnRedefinirSenha'><br>
                        </div>
                        </div>`;
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        }
    };

    function redefinirsenhaaluno(idaluno, usuarioadm) {
        var senha = prompt("Digite sua senha para confirmação:");
        if (senha != null) {
            $.ajax({
                url: 'others/redefinirsenhaAluno_adm.php',
                type: 'POST',
                data: {
                    idaluno: idaluno,
                    usuarioadm: usuarioadm,
                    senha: senha
                },
                success: function(retorno) {
                    alert(retorno);
                    document.location.reload(true);
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        };
    };

    function edicaoaluno(idaluno) {
        var codi = document.getElementById('txtCodi').value;
        var newrm = document.getElementById('txtRM').value;
        var newnome = document.getElementById('txtNome').value;
        var newcpf = document.getElementById('txtCPF').value;
        var newtelefone = document.getElementById('txtTelefone').value;
        var newcelular = document.getElementById('txtCelular').value;
        var newemail = document.getElementById('txtEmail').value;
        var newdtnas = document.getElementById('txtDtNascimento').value;
        var oldcurso = document.getElementById('txtCursoAntigo').name;
        var newcurso = document.getElementById('selectCursoNovo').value;
        $.ajax({
            url: 'others/edicaoAluno_adm.php',
            type: 'POST',
            data: {
                codi: codi,
                newrm: newrm,
                newnome: newnome,
                newcpf: newcpf,
                newtelefone: newtelefone,
                newcelular: newcelular,
                newemail: newemail,
                newdtnas: newdtnas,
                oldcurso: oldcurso,
                newcurso: newcurso
            },
            success: function(dadosretorno) {
                alert(dadosretorno);
                document.location.reload(true);
            },
            error: function(jqXHR, textStatus) {
                console.log('error ' + textStatus + " " + jqXHR);
            }
        });
    };

    function btnConfigLivros() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
            `<h3 class="corpoTitle"> Procurar Livros </h3><br>
            <hr class="hrTitle"><br>
            <input class="form-control pesquisa corpoInputtxt" type="text" id="inlineFormInputGroup" placeholder="Digite o nome aqui!" >
            <table>
            <ul class="lista" style="list-style-type:none;  ">
            <?php 
                while ($exibir3 = mysqli_fetch_assoc($resultado5)) {
                    $exibir4 = strtolower($exibir3['liv_titu']);
                    echo "<li class='listaOpcao pointer' onClick='VerLivro($exibir3[liv_codi])' nome='$exibir4' id='$exibir3[liv_codi]'> $exibir3[liv_titu]</li>";
                }
            ?>
            </ul>
            </table>`;
        document.getElementById('main3').innerHTML =
            `
        <input class='botVerm pointer' type='button' onClick ='adicionarlivro()' value=' Adicionar Livro ' id='btnSalvarAlteracoesLivros'><br>`;
        // FUNÇÃO DE "PESQUISA" NA PÁGINA HOME > PROCURAR
        pesquisa_input = document.querySelectorAll(".pesquisa");
        for (i in pesquisa_input) {
            pesquisa_input[i].onkeyup = function(e) {
                document.getElementById('main2').innerHTML = "";
                reg = new RegExp(this.value.toLowerCase(), "g");
                lis = this.parentElement.querySelector(".lista");
                //console.log(lis);
                for (j of lis.children) {
                    if (!j.getAttribute("nome").match(reg))
                        j.style.display = "none";
                    else
                        j.removeAttribute("style");
                };
            };
        };
    };

    function adicionarlivro() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main3').innerHTML = "";
        document.getElementById('main1').innerHTML = `
            <h3 class="corpoTitle"> Adicionar Livro </h3><br>
            <hr class="hrTitle"><br>
            <p class="corpoText"><b>Preencha as informações abaixo para adicionar</b></p>
            <div class="corpoCadastro">
            <form method='POST' name='addlivro' onsubmit="return validaraddlivro(this);">
            <br>
            <input class='botVerm pointer' type='button' onClick ='btnConfigLivros()' value=' Voltar ' id='btnVoltarLivro'><br>
            <h3> Título do Livro: </h3>
            <input type='text' maxlength="100" id='txtTituloADD' placeholder="Digite o Nome do livro"> <br>
            <h3> Autor: </h3>
            <input type='text' maxlength="100" id='txtAutorADD' placeholder="Digite o Autor do livro"><br>
            <h3> Editora: </h3>
            <input type='text' maxlength="80" id='txtEditoraADD' placeholder="Digite a Editora do livro"><br>
            <h3> Categoria: </h3>
            <?php
                echo "<select id='categorialivroADD' name='categorialivro'>";
                echo "<option value='-'> Selecione a Categoria </option>";
                while ($exibircat = mysqli_fetch_assoc($resultado6)) {
                    echo "<option value='$exibircat[cat_codi]'> $exibircat[cat_nome]</option>";
                };
                echo "</select>";
            ?><br>
            <h3> Sinopse: </h3>
            <textarea maxlength="900" id='txtSinopseADD' placeholder="Digite a Sinopse do livro"></textarea><br>
            <h3> Quantidade Total: </h3>
            <input type='text' maxlength="100" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id='txtQtdtotalADD' placeholder="Digite a Quantidade Total de Livros"><br>
            <h3> Quantidade Disponivel: </h3>
            <input type='text' maxlength="100" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id='txtQtddispADD' placeholder="Digite a Quantidade Disponivel de Livros"><br>
            <input class='botVerm pointer' type='submit' value='Adicionar Livro'>
            </div>
        `;
    };

    function adicionarLivroBD() {
        var titulo = document.getElementById('txtTituloADD').value;
        var autor = document.getElementById('txtAutorADD').value;
        var editora = document.getElementById('txtEditoraADD').value;
        var categoria = document.getElementById('categorialivroADD').value;
        var sinopse = document.getElementById('txtSinopseADD').value;
        var qtdtotal = document.getElementById('txtQtdtotalADD').value;
        var qtddisp = document.getElementById('txtQtddispADD').value;
        $.ajax({
            url: 'others/adicionarlivro_adm.php',
            type: 'POST',
            data: {
                titulo: titulo,
                autor: autor,
                editora: editora,
                categoria: categoria,
                sinopse: sinopse,
                qtdtotal: qtdtotal,
                qtddisp: qtddisp
            },
            success: function(retorno) {
                alert(retorno);
                document.location.reload(true);
            },
            error: function(jqXHR, textStatus) {
                console.log('error ' + textStatus + " " + jqXHR);
            }
        });
    };

    function VerLivro(id) {
        document.getElementById('main3').innerHTML = ""
        var idlivro = id;
        if (idlivro == "-") {
            document.getElementById('main2').innerHTML = "";
            alert("Selecione um livro!");
        } else {
            $.ajax({
                url: 'others/verlivro.php',
                dataType: 'json',
                type: 'POST',
                data: {
                    idlivro: idlivro,
                    tabela: 'livros'
                },
                success: function(dados) {
                    document.getElementById('main2').innerHTML =
                        `<div class="result">
                            <hr class='hrMain'>
                            <div class="corpoCadastro">
                            <br>
                                <input class='botVerm pointer' type='button' onClick ='btnConfigLivros()' value=' Voltar ' id='btnVoltarLivro'><br>
                                <h3> Código do Livro: </h3>
                                    <input type='text' readonly value='` + dados.codigo + `'> <br>
                                <h3> Título do Livro: </h3>
                                    <input type='text' readonly value='` + dados.nome + `'> <br>
                                <h3> Autor: </h3>
                                    <input type='text' readonly value='` + dados.autor + `'><br>
                                <h3> Editora: </h3>
                                    <input type='text' id='txtEditora' maxlength="80" value='` + dados.editora + `'><br>
                                
                                <h3> Antiga Categoria: </h3>
                                    <input type='text' id='txtCategoria' name='` + dados.catid + `' value='` + dados
                        .categoria + `' disabled>
                                <h3> Nova Categoria: </h3> 
                                <?php
                                    echo "<select id='categorialivro' name='categorialivro'>";
                                    echo "<option value='-'> Selecione a Nova Categoria </option>";
                                    while ($exibircat = mysqli_fetch_assoc($resultado10)) {
                                        echo "<option value='$exibircat[cat_codi]'> $exibircat[cat_nome]</option>";
                                    };
                                    echo "</select>";
                                ?><br>
                                <h3> Sinopse: </h3>
                                    <textarea id='txtSinopse' maxlength="900" rows="6">` + dados.sinopse +
                        `</textarea><br>
                                <h3> Quantidade Total: </h3>
                                    <input type='text' id='txtQtdtotal' onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="100" value='` +
                        dados.qtdtotal +
                        `'><br>
                                <h3> Quantidade Disponivel: </h3>
                                    <input type='text' id='txtQtddisp' onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="100" value='` +
                        dados.qtddisp + `'><br>
                                    <input class='botVerm pointer' type='button' onClick ='edicaoLivro(` + dados
                        .codigo + `)' value=' Salvar Alterações ' id='btnSalvarAlteracoesLivros'><br>
                                    <input class='botVerm pointer' type='button' onClick ='excluirLivro(` + dados
                        .codigo + `)' value=' Excluir Livro ' id='btnExcluirLivro'><br>
                            </div>
                        </div>`;
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        }
    };

    function excluirLivro(idlivro) {
        $.ajax({
            url: 'others/excluirlivro_adm.php',
            type: 'POST',
            data: {
                idlivro: idlivro
            },
            success: function(dadosretorno) {
                alert(dadosretorno);
                document.location.reload(true);
            },
            error: function(jqXHR, textStatus) {
                console.log('error ' + textStatus + " " + jqXHR);
            }
        });
    };

    function edicaoLivro(idlivro) {
        var neweditora = document.getElementById('txtEditora').value;
        var oldcategoria = document.getElementById('txtCategoria').name;
        var newcategoria = document.getElementById('categorialivro').value;
        var newsinopse = document.getElementById('txtSinopse').value;
        var newqtdtotal = document.getElementById('txtQtdtotal').value;
        var newqtddisp = document.getElementById('txtQtddisp').value;
        $.ajax({
            url: 'others/edicaoLivro_adm.php',
            type: 'POST',
            data: {
                neweditora: neweditora,
                oldcategoria: oldcategoria,
                newcategoria: newcategoria,
                newsinopse: newsinopse,
                newqtdtotal: newqtdtotal,
                newqtddisp: newqtddisp,
                idlivro: idlivro
            },
            success: function(dadosretorno) {
                alert(dadosretorno);
                document.location.reload(true);
            },
            error: function(jqXHR, textStatus) {
                console.log('error ' + textStatus + " " + jqXHR);
            }
        });

    };

    function btnEmprestimos() {
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
            `<h3 class="corpoTitle"> Empréstimos </h3><br>
            <hr class="hrTitle"><br>
            <div class="horNav">
                <ul>
                    <li id="entLi"><a href="home_adm.php?id=5"> Para Entregar </a></li>
                    <li id="proLi"><a href="home_adm.php?id=6"> Em Progresso </a></li>
                    <li id="atrLi"><a href="home_adm.php?id=7"> Devolução em Atraso </a></li>
                    <li id="devLi"><a href="home_adm.php?id=8"> Devolvidos </a></li>
                </ul>
            </div>`;
        ParaEntregar();
        document.getElementById("entLi").classList.add('navActive');
        document.getElementById("proLi").classList.remove('navActive');
        document.getElementById("atrLi").classList.remove('navActive');
        document.getElementById("devLi").classList.remove('navActive');
    };

    function ParaEntregar() {
        document.getElementById('main2').innerHTML = `
        <div class="empTableDiv">
            <table>
                <tr>
                    <th style="width:5%;">RM</th>
                    <th style="width:40%;">Titulo Livro</th>
                    <th style="width:23%;">Aluno</th>
                    <th style="width:17%;">Previsão Devolução</th>
                    <th style="width:7,5%;">Entregar</th>
                    <th style="width:7,5%;">Excluir</th>
                </tr>
                <?php     
                    while ($resultadoemprestimos = mysqli_fetch_assoc($resultado)) {
                        $sql_buscatitulo = "SELECT * FROM livros WHERE liv_codi = $resultadoemprestimos[liv_codi]";
                        $resultado_buscatitulo = mysqli_query($conn, $sql_buscatitulo);
                        $exibir_buscatitulo = mysqli_fetch_assoc($resultado_buscatitulo);
                        $sql_buscaaluno = "SELECT * FROM alunos WHERE alu_rm = $resultadoemprestimos[alu_rm]";
                        $resultado_buscaaluno = mysqli_query($conn, $sql_buscaaluno);
                        $exibir_buscaaluno = mysqli_fetch_assoc($resultado_buscaaluno);
                        echo "<tr>";
                        echo "<td nome='1' id='1'> $exibir_buscaaluno[alu_rm]</td>";
                        echo "<td nome='1' id='1'> $exibir_buscatitulo[liv_titu]</td>";
                        echo "<td nome='1' id='1'> $exibir_buscaaluno[alu_nome]</td>";
                        $ano= substr($resultadoemprestimos['emp_dtde'], 0,4);
                        $mes= substr($resultadoemprestimos['emp_dtde'], 5,2);
                        $dia= substr($resultadoemprestimos['emp_dtde'], 8,2);
                        echo "<td nome='1' id='1'> $dia/$mes/$ano </td>";
                        echo "<td>
                        <a class='btnsidenav' id='$resultadoemprestimos[cor_codi]' onclick='entregar_livro($resultadoemprestimos[cor_codi], $usuarioadm)'>
                        <img src=../img/botao_entregar.png width='20px' height='20px'>
                        </a></td>";
                        echo "<td>
                        <a class='btnsidenav' id='$resultadoemprestimos[cor_codi]' onclick='excluir_livro($resultadoemprestimos[cor_codi], $resultadoemprestimos[liv_codi])'>
                        <img src=../img/botao_excluir.png width='20px' height='20px'>
                        </a></td>";
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
        `;
        document.getElementById("entLi").classList.add('navActive');
        document.getElementById("proLi").classList.remove('navActive');
        document.getElementById("atrLi").classList.remove('navActive');
        document.getElementById("devLi").classList.remove('navActive');
    };

    function entregar_livro(codigoemprestimo, usuariocodigo) {
        var senha = prompt("Digite sua senha para confirmação:");
        if (senha != null) {
            $.ajax({
                url: 'others/entregarlivro_adm.php',
                type: 'POST',
                data: {
                    codigoemprestimo: codigoemprestimo,
                    usuariocodigo: usuariocodigo,
                    senha: senha
                },
                success: function(retorno) {
                    alert(retorno);
                    document.location.reload(true);
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        }
    };

    function Devolvido() {
        document.getElementById('main2').innerHTML = `
        <div class="empTableDiv">
            <table>
                <tr>
                    <th style="width:5%;">RM</th>
                    <th style="width:40%;">Titulo Livro</th>
                    <th style="width:23%;">Aluno</th>
                    <th style="width:15%;">Data Entrega</th>
                    <th style="width:15%;">Data Devolução</th>
                    <th style="width:17%;">Previsão Devolução</th>
                </tr>
                <?php     
                    while ($dev = mysqli_fetch_assoc($resultado4)) {
                        $sql_dev1 = "SELECT * FROM livros WHERE liv_codi = $dev[liv_codi]";
                        $resultado_dev1 = mysqli_query($conn, $sql_dev1);
                        $exibir_dev1 = mysqli_fetch_assoc($resultado_dev1);
                        $sql_dev2 = "SELECT * FROM alunos WHERE alu_rm = $dev[alu_rm]";
                        $resultado_dev2 = mysqli_query($conn, $sql_dev2);
                        $exibir_dev2 = mysqli_fetch_assoc($resultado_dev2);
                        echo "<tr>";
                        echo "<td nome='1' id='1'> $dev[alu_rm]</td>";
                        echo "<td nome='1' id='1'> $exibir_dev1[liv_titu]</td>";
                        echo "<td nome='1' id='1'> $exibir_dev2[alu_nome]</td>";
                        $ano= substr($dev['cor_dten'], 0,4);
                        $mes= substr($dev['cor_dten'], 5,2);
                        $dia= substr($dev['cor_dten'], 8,2);
                        echo "<td nome='1' id='1'> $dia/$mes/$ano </td>";
                        $ano2= substr($dev['cor_dtde'], 0,4);
                        $mes2= substr($dev['cor_dtde'], 5,2);
                        $dia2= substr($dev['cor_dtde'], 8,2);
                        if(strtotime($dev['cor_dtde']) > strtotime($dev['emp_dtde'])){
                            echo "<td nome='1' id='1' style='color:red'> $dia2/$mes2/$ano2 </td>";
                        } else {
                            echo "<td nome='1' id='1'> $dia2/$mes2/$ano2 </td>";
                        }
                        $ano3= substr($dev['emp_dtde'], 0,4);
                        $mes3= substr($dev['emp_dtde'], 5,2);
                        $dia3= substr($dev['emp_dtde'], 8,2);
                        if(strtotime($dev['cor_dtde']) > strtotime($dev['emp_dtde'])){
                            echo "<td nome='1' id='1' style='color:red'> $dia3/$mes3/$ano3 </td>";
                        } else {
                            echo "<td nome='1' id='1'> $dia3/$mes3/$ano3 </td>";
                        }
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
        `;
        document.getElementById("devLi").classList.add('navActive');
        document.getElementById("proLi").classList.remove('navActive');
        document.getElementById("atrLi").classList.remove('navActive');
        document.getElementById("entLi").classList.remove('navActive');
    };

    function EmProgresso() {
        document.getElementById('main2').innerHTML = `
        <div class="empTableDiv">
            <table>
                <tr>
                    <th style="width:5%;">RM</th>
                    <th style="width:40%;">Titulo Livro</th>
                    <th style="width:23%;">Aluno</th>
                    <th style="width:17%;">Previsão Devolução</th>
                    <th style="width:15%;">Devolver</th>
                </tr>
                <?php     
                    while ($exibirprogresso = mysqli_fetch_assoc($resultado3)) {
                        if(strtotime($datadehoje) <= strtotime($exibirprogresso['emp_dtde'])){
                            $sql_pro1 = "SELECT * FROM livros WHERE liv_codi = $exibirprogresso[liv_codi]";
                            $resultado_sql1 = mysqli_query($conn, $sql_pro1);
                            $exibir_pro1 = mysqli_fetch_assoc($resultado_sql1);
                            $sql_pro2 = "SELECT * FROM alunos WHERE alu_rm = $exibirprogresso[alu_rm]";
                            $resultado_sql2 = mysqli_query($conn, $sql_pro2);
                            $exibir_pro2 = mysqli_fetch_assoc($resultado_sql2);
                            echo "<tr>";
                            echo "<td nome='1' id='1'> $exibirprogresso[alu_rm]</td>";
                            echo "<td nome='1' id='1'> $exibir_pro1[liv_titu]</td>";
                            echo "<td nome='1' id='1'> $exibir_pro2[alu_nome]</td>";
                            $ano= substr($exibirprogresso['emp_dtde'], 0,4);
                            $mes= substr($exibirprogresso['emp_dtde'], 5,2);
                            $dia= substr($exibirprogresso['emp_dtde'], 8,2);
                            echo "<td nome='1' id='1'> $dia/$mes/$ano </td>";
                            echo "<td><a class='btnsidenav' id='$exibirprogresso[emp_codi]' onclick='devolver_livro($exibirprogresso[cor_codi], $usuarioadm)'><img src=../img/botao_devolver.png width='20px' height='20px'></a></td>";
                            echo "</tr>";
                        };
                    };
                ?>
            </table>
        </div>
        `;
        document.getElementById("proLi").classList.add('navActive');
        document.getElementById("entLi").classList.remove('navActive');
        document.getElementById("atrLi").classList.remove('navActive');
        document.getElementById("devLi").classList.remove('navActive');
    };

    function devolver_livro(codigoemprestimo, usuariocodigo) {
        var senha = prompt("Digite sua senha para confirmação:");
        if (senha != null) {
            $.ajax({
                url: 'others/devolverlivro_adm.php',
                type: 'POST',
                data: {
                    codigoemprestimo: codigoemprestimo,
                    usuariocodigo: usuariocodigo,
                    senha: senha
                },
                success: function(msgretorno) {
                    alert(msgretorno);
                    document.location.reload(true);
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        }
    };

    function devolver_livro2(codigoemprestimo, usuariocodigo) {
        var senha = prompt("Digite sua senha para confirmação:");
        if (senha != null) {
            $.ajax({
                url: 'others/devolverlivro_adm.php',
                type: 'POST',
                data: {
                    codigoemprestimo: codigoemprestimo,
                    usuariocodigo: usuariocodigo,
                    senha: senha
                },
                success: function(msgretorno) {
                    alert(msgretorno);
                    window.location.href = "home_adm.php?id=6";
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        }
    };

    function EmAtraso() {
        document.getElementById('main2').innerHTML = `
        <div class="empTableDiv">
            <table>
                <tr>
                    <th style="width:5%;">RM</th>
                    <th style="width:40%;">Titulo Livro</th>
                    <th style="width:23%;">Aluno</th>
                    <th style="width:17%;">Previsão Devolução</th>
                    <th style="width:15%;">Devolver</th>
                </tr>
                <?php 
                    
                    while ($exibir2 = mysqli_fetch_assoc($resultado2)) {
                        $contadordias = 0;
                        $ano= substr($exibir2['emp_dtde'], 0,4);
                        $mes= substr($exibir2['emp_dtde'], 5,2);
                        $dia= substr($exibir2['emp_dtde'], 8,2);
                        $ano_hoje= substr($datadehoje, 0,4);
                        $mes_hoje= substr($datadehoje, 5,2);
                        $dia_hoje= substr($datadehoje, 8,2);
                        if(strtotime($datadehoje) > strtotime($exibir2['emp_dtde'])){
                            $sql_ano = "SELECT * FROM livros WHERE liv_codi = $exibir2[liv_codi]";
                            $resultado_ano = mysqli_query($conn, $sql_ano);
                            $exibir_ano = mysqli_fetch_assoc($resultado_ano);
                            $sql_ano2 = "SELECT * FROM emprestimo WHERE emp_codi = $exibir2[emp_codi]";
                            $resultado_ano2 = mysqli_query($conn, $sql_ano2);
                            $exibir_ano2 = mysqli_fetch_assoc($resultado_ano2);
                            $sql_ano3 = "SELECT * FROM alunos WHERE alu_rm = $exibir2[alu_rm]";
                            $resultado_ano3 = mysqli_query($conn, $sql_ano3);
                            $exibir_ano3 = mysqli_fetch_assoc($resultado_ano3);
                            echo "<tr>";
                            echo "<td nome='1' id='1'> $exibir2[alu_rm]</td>";
                            echo "<td nome='1' id='1'> $exibir_ano[liv_titu]</td>";
                            echo "<td nome='1' id='1'> $exibir_ano3[alu_nome]</td>";
                            $ano= substr($exibir2['emp_dtde'], 0,4);
                            $mes= substr($exibir2['emp_dtde'], 5,2);
                            $dia= substr($exibir2['emp_dtde'], 8,2);
                            echo "<td nome='1' id='1'> $dia/$mes/$ano </td>";
                            echo "<td><a class='btnsidenav' id='$exibir2[cor_codi]' onclick='devolver_livro($exibir2[cor_codi], $usuarioadm)'><img src=../img/botao_devolver.png width='20px' height='20px'></a></td>";
                            echo "</tr>";
                        };
                    };
                ?>
            </table>
        </div>
        `;
        document.getElementById("atrLi").classList.add('navActive');
        document.getElementById("entLi").classList.remove('navActive');
        document.getElementById("proLi").classList.remove('navActive');
        document.getElementById("devLi").classList.remove('navActive');
    };

    function excluir_livro(idemprestimo, idlivro) {
        $.ajax({
            url: 'others/excluiremprestimo_adm.php',
            type: 'POST',
            data: {
                idemprestimo: idemprestimo,
                idlivro: idlivro
            },
            success: function(dados) {
                alert(dados);
                document.location.reload(true);
            },
            error: function(jqXHR, textStatus) {
                console.log('error ' + textStatus + " " + jqXHR);
            }
        });
    }

    function carregou() {
        document.getElementById('main1').innerHTML = `
        <h3 class="corpoTitle"> Introdução </h3><br>
        <hr class="hrTitle"><br>
        <div class="corpoCadastro" style="width: 95%;">
            <div class="alinharmeio">
                <p class="intTitle"><b>Intuito</b></p>
                    <p> O objetivo é que será possível gerenciar os empréstimos, cadastros e <br> todas funcionalidades do sistema.</p>
                <p class="intTitle"><b>Guia</b></p>
            </div>
            <ul class="intLista">
                <li><p><b> Nome: </b>Ao clicar no seu próprio nome, irá para a página de configurações do seu perfil.</p></li>
                <li><p><b> Consultar Empréstimos: </b>Para consultar os empréstimos abertos para entrega, em atraso e devolvidos.</p></li>
                <li><p><b> Cadastrar/Alterar Livros: </b>Onde é possível cadastrar e Alterar os livros no sistema.</p></li>
                <li><p><b> Alterar Cadastro Aluno: </b>Para alterar o cadastro dos alunos, tais como nome, RM etc.</p></li>
                <li><p><b> Alterar/Cadastrar Categoria: </b>Onde é possível cadastrar e alterar as categorias dos livros.</p></li>
                <li><p><b> Alterar/Cadastrar Curso: </b>Onde é possível cadastrar e alterar os cursos da escola.</p></li>
                <li><p><b> Sair: </b>Volta para a página de login.</p></li>
            </ul>
        </div>`;
    };
    </script>

</head>

<body>
    <div class="sidenav">
        <input hidden type='text' id='datahoje' value='<?php echo date('Y-m-d');?>'>
        <input hidden type='text' id='loginadm' value='<?php echo $login;?>'>
        <input hidden type='text' id='codigoadm' value='<?php echo $usuarioadm;?>'>
        <input hidden type='date' id='dataemprestimo' value='<?php echo date('Y-m-d');?>'>
        <a href='home_adm.php'>
            <h1 tabindex="0" class='titulo' style='text-align: center;'><span class="cor1">Bibli</span><span
                    class="cor2">e</span><span class="cor3">tec</span></h1>
        </a>
        <hr class='full'>
        <a tabindex="1" href='home_adm.php?id=4'><?php echo $nome ?></a><br>
        <a tabindex="1"><?php echo $permi ?></a><br>
        <hr class='full'>
        <?php echo '<a tabindex="2" href="home_adm.php?id=1" class="btnsidenav" id="btnEmprestimo">Consultar Empréstimos</a>' ?>
        <hr>
        <?php echo '<a tabindex="3" href="home_adm.php?id=2" class="btnsidenav" id="btnAlterarCadastrarLivro">Cadastrar/Alterar Livros</a>' ?>
        <hr>
        <?php echo '<a tabindex="4" href="home_adm.php?id=3" class="btnsidenav" id="btnCadastrarAluno">Alterar Cadastro Aluno</a>' ?>
        <hr>
        <?php echo '<a tabindex="5" href="home_adm.php?id=9" class="btnsidenav" id="btnCadastrarAlterarCategoria">Cadastrar/Alterar Categoria</a>' ?>
        <hr>
        <?php echo '<a tabindex="6" href="home_adm.php?id=10" class="btnsidenav" id="btnCadastrarAlterarCurso">Cadastrar/Alterar Curso</a>' ?>
        <hr>
        <?php if ($permi == "Administrador"){
            echo '<a tabindex="6" href="home_adm.php?id=11" class="btnsidenav" id="btnCadastrarAlterarUsuarioADM">Cadastrar/Alterar Usuário</a>';
            echo '<hr>';}
        ?>

        <a tabindex="6" class="btnsidenav" style="text-decoration:none;" href='loginadministracao.php'
            id='btnSair'>Sair</a>
    </div>
    <div class="corpoMain" id='main1'>
        <input hidden type='text' id='variavelid' value='<?php echo $idRecebido ?>'>
        <!-- FUNÇÃO DOS BOTÕES -->
        <!-- NÃO APAGAR! -->
    </div>
    <div class="corpoMain" id='main2' style='overflow-y: hidden;'>
        <input hidden type='date' id='livro1'><br>
        <input hidden type='date' id='livro2'><br>
        <input hidden type='date' id='livro3'><br>
        <!-- SOBRE O LIVRO -->
        <!-- NÃO APAGAR! -->
    </div>
    <div class="corpoMain" id='main3'>
        <!-- EXTRA - NÃO APAGAR -->
    </div>
</body>

</html>