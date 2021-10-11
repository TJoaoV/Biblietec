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
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <title>Biblietec - Administração</title>
    <?php include('imports.php'); ?>
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
            //btnNome();
        };
        if (idrecebidoreload == "99") {
            //validarfinalizacao();
        };
        // document.querySelector("#btnProcurar").addEventListener("click", e => {
        //     btnProcurar();
        // });
        // document.querySelector("#btnEmprestimos").addEventListener("click", e => {
        //     btnEmprestimos();
        //     EmpEmProgresso();
        // });
        // document.querySelector("#btnCarrinho").addEventListener("click", e => {
        //     //btnCarrinho();         
        // });
        // document.querySelector("#btnContinuarEmprestimo").addEventListener("click", e => {
        //     btnContinuarEmprestimo();
        // });
    });

    function alterarCadAlunos(){
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
            `<h3 class="corpoTitle"> Procurar Livros </h3><br>
            <hr class="hrTitle"><br>
            <p class="corpoText"><b>Selecione o Livro que deseja editar!</b></p>
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
                        <label><b> Código do Aluno: </b></label>
                        <input type='text' id='txtCodi' readonly value='` + dados.codigo + `'> <br>
                        <label><b> RM: </b></label>
                        <input type='number' id='txtRM' value='` + dados.rm + `'> <br>
                        <label><b> Nome: </b></label>
                        <input type='text' id='txtNome' value='` + dados.nome + `'><br>
                        <label><b> CPF: </b></label>
                        <input type='text' id='txtCPF' value='` + dados.cpf + `'><br>
                        <label><b> Telefone: </b></label>
                        <input type='number' id='txtTelefone'value='`+ dados.telefone +`'><br>
                        <label><b> Celular: </b></label>
                        <input type='number'id='txtCelular'value='`+ dados.celular + `'><br>
                        <label><b> Email: </b></label>
                        <input type='email' id='txtEmail' value='` + dados.email + `'><br>
                        <label><b> Data de Nascimento: </b></label>
                        <input type='date' id='txtDtNascimento' value='` + dados.datanascimento + `'><br>
                        <label><b> Curso: </b></label> <label> Curso Antigo </label>
                        <input type='text' id='txtCursoAntigo' readoly size="50" name='` + dados.cursoid + `' value='` + dados.cursonome + `'><br>
                        <label> Selecione o novo curso </label>
                        <?php
                            echo "<select id='selectCursoNovo' name='selectCursoNovo'>";
                            echo "<option value='-'> Selecione o Novo Curso </option>";
                            while ($exibircur = mysqli_fetch_assoc($resultado8)) {
                                echo "<option value='$exibircur[cur_codi]'> $exibircur[cur_nome] - Duração $exibircur[cur_dura] - Período $exibircur[cur_peri]</option>";
                            };
                            echo "</select>";
                        ?><br>
                        <label><b> Situação Senha: </b></label>
                        <label>`+ dados.senharedefinida + ` (1: Redefinição Solicitada/Pendente, 2: Senha normal)</label> <br>
                        <div class='alinharmeio'>
                        <input class='botVerm pointer' type='button' onClick ='edicaoaluno(` + dados.codigo + `)' value=' Salvar Alterações ' id='btnSalvarAlteracoesAluno'><br>
                        <input class='botVerm pointer' type='button' onClick ='redefinirsenhaaluno(` + dados.codigo + `, `+codigoadm+`)' value=' Redefinir Senha ' id='btnRedefinirSenha'><br>
                        </div>
                        </div>`;
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        }
    };

    function redefinirsenhaaluno(idaluno, usuarioadm){
        var senha = prompt("Digite sua senha para confirmação:");
        if (senha!=null)
        {
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

    function edicaoaluno(idaluno){
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

    function btnConfigLivros(){
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main1').innerHTML =
            `<h3 class="corpoTitle"> Procurar Livros </h3><br>
            <hr class="hrTitle"><br>
            <p class="corpoText"><b>Selecione o Livro que deseja editar!</b></p>
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
        document.getElementById('main3').innerHTML = `
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

    function adicionarlivro(){
        document.getElementById('main2').innerHTML = "";
        document.getElementById('main3').innerHTML = "";
        document.getElementById('main1').innerHTML = `
            <h3 class="corpoTitle"> Adicionar Livro </h3><br>
            <hr class="hrTitle"><br>
            <p class="corpoText"><b>Preencha as informações abaixo para adicionar!</b></p>
            <form method='POST' name='addlivro' onsubmit="return validaraddlivro(this);">
            <label><b> Título do Livro: </b></label>
            <input type='text' id='txtTituloADD'> <br>
            <label><b> Autor: </b></label>
            <input type='text' id='txtAutorADD'><br>
            <label><b> Editora: </b></label>
            <input type='text' id='txtEditoraADD'><br>
            <label><b> Categoria: </b></label>
            <?php
                echo "<select id='categorialivroADD' name='categorialivro'>";
                echo "<option value='-'> Selecione a Categoria </option>";
                while ($exibircat = mysqli_fetch_assoc($resultado6)) {
                    echo "<option value='$exibircat[cat_codi]'> $exibircat[cat_nome]</option>";
                };
                echo "</select>";
            ?><br>
            <label><b> Sinopse: </b></label>
            <textarea id='txtSinopseADD'></textarea><br>
            <label><b> Quantidade Total: </b></label>
            <input  type='number' id='txtQtdtotalADD'><br>
            <label><b> Quantidade Disponivel: </b></label>
            <input  type='number' id='txtQtddispADD'><br>
            <input type='submit' value='enviar'>
        `;
    };
    
    function adicionarLivroBD(){
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
                        <label><b> Código do Livro: </b></label>
                        <input type='text' readonly value='` + dados.codigo + `'> <br>
                        <label><b> Título do Livro: </b></label>
                        <input type='text' readonly value='` + dados.nome + `'> <br>
                        <label><b> Autor: </b></label>
                        <input type='text' readonly value='` + dados.autor + `'><br>
                        <label><b> Editora: </b></label>
                        <input type='text' id='txtEditora' value='` + dados.editora + `'><br>
                        <label><b> Categoria: </b></label> <label> Antiga Categoria: </label>
                        <input type='text' id='txtCategoria' name='` + dados.catid + `' value='` + dados.categoria + `'>
                        <?php
                            echo "<select id='categorialivro' name='categorialivro'>";
                            echo "<option value='-'> Selecione a Nova Categoria </option>";
                            while ($exibircat = mysqli_fetch_assoc($resultado6)) {
                                echo "<option value='$exibircat[cat_codi]'> $exibircat[cat_nome]</option>";
                            };
                            echo "</select>";
                        ?><br>
                        <label><b> Sinopse: </b></label>
                        <textarea id='txtSinopse'>` + dados.sinopse + `</textarea><br>
                        <label><b> Quantidade Total: </b></label>
                        <input type='text' id='txtQtdtotal' value='` + dados.qtdtotal + `'><br>
                        <label><b> Quantidade Disponivel: </b></label>
                        <input type='text' id='txtQtddisp' value='` + dados.qtddisp + `'><br>
                        <div class='alinharmeio'>
                        <input class='botVerm pointer' type='button' onClick ='edicaoLivro(` + dados.codigo + `)' value=' Salvar Alterações ' id='btnSalvarAlteracoesLivros'><br>
                        <input class='botVerm pointer' type='button' onClick ='excluirLivro(` + dados.codigo + `)' value=' Excluir Livro ' id='btnExcluirLivro'><br>
                        </div>
                        </div>`;
                },
                error: function(jqXHR, textStatus) {
                    console.log('error ' + textStatus + " " + jqXHR);
                }
            });
        }
    };

    function excluirLivro(idlivro){
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

    function edicaoLivro(idlivro){
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
                    <li id="entLi"><a onClick="ParaEntregar()"> Para Entregar </a></li>
                    <li id="proLi"><a onClick="EmProgresso()"> Em Progresso </a></li>
                    <li id="atrLi"><a onClick="EmAtraso()"> Devolução em Atraso </a></li>
                    <li id="devLi"><a onClick="Devolvido()"> Devolvidos </a></li>
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

    function entregar_livro(codigoemprestimo, usuariocodigo){
        var senha = prompt("Digite sua senha para confirmação:");
        if (senha!=null)
        {
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

    function devolver_livro(codigoemprestimo, usuariocodigo){
        var senha = prompt("Digite sua senha para confirmação:");
        if (senha!=null)
        {
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
        <p> Seja bem vindo a parte Administrativa do Biblietec!!</p>
        <p> Aqui vicê poderá gerenciar os empréstimos, cadastros e todas funcionalidades do sistema!!</p>
        <p> Abaixo temos um breve tutorial, para ajudar a se ambientar, ok?</p>
        <p> Clicando na nossa logo, você será redirecionado para esta tela, idependente de qual estiver</p>
        <p> Caso você clique no seu próprio nome, irá para a página de configurações do seu perfil</p>
        <p> Consultar Empréstimos - Para consultar os empréstimos em aberto para entrega, em atraso e devolvidos</p>
        <p> Cadastrar/Alterar Livros - É possível Cadastrar e Alterar os livros no sistema</p>
        <p> Alterar Cadastro Aluno - Você pode alterar o cadastro dos alunos, tais como nome, RM, etc</p>
        <p> Cadastrar Categoria/Curso - Aqui você cadastra as categorias dos livros e os cursos disponíveis na escola</p>
        <p> Sair - Volta para a página de login</p>`;
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
        <a tabindex="1" href='home.php?id=4'><?php echo $nome ?></a><br>
        <hr class='full'>
        <?php echo '<a tabindex="2" href="home_adm.php?id=1" class="btnsidenav" id="btnProcurar">Consultar Empréstimos</a>' ?>
        <hr>
        <?php echo '<a tabindex="3" href="home_adm.php?id=2" class="btnsidenav" id="btnEmprestimos">Cadastrar/Alterar Livros</a>' ?>
        <hr>
        <?php echo '<a tabindex="4" href="home_adm.php?id=3" class="btnsidenav" id="btnCarrinho">Alterar Cadastro Aluno</a>' ?>
        <hr>
        <?php echo '<a tabindex="5" href="home_adm.php?id=4" class="btnsidenav" id="btnEmprestimos">Cadastrar Categoria/Curso</a>' ?>
        <hr>
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