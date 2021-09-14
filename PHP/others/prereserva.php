<?php
    include_once("../conexao.php");
    $idlivro= $_POST['idlivro'];
    $alunorm= $_POST['alunorm'];
    $produtossql1 = "SELECT * FROM corpo_emprestimo WHERE alu_rm='$alunorm'";
    $resultado_produtos1 = mysqli_query($conn, $produtossql1);
    $quantidade_rows =  $resultado_produtos1->num_rows;
    $produtossql2 = "SELECT * FROM preemprestimo WHERE alu_rm='$alunorm'";
    $resultado_produtos2 = mysqli_query($conn, $produtossql2);
    $quantidade_row2 =  $resultado_produtos2->num_rows;
    if($quantidade_rows != 3){
        $conta_disponivel = 3 - $quantidade_rows - $quantidade_row2;
        if($conta_disponivel != 0){
            $data = date('Y/m/d');
            $produtossql1 = "INSERT INTO preemprestimo(liv_codi, alu_rm, pre_data) 
                            VALUES ('$idlivro','$alunorm', '$data');";
            $resultado_produtos1 = mysqli_query($conn, $produtossql1);
            if($conta_disponivel == 1){
                echo "Livro adicionado no carrinho porém, você não pode pegar mais nenhum livro, apenas este. Devolva os pendentes a escola para liberar mais vagas de empréstimos!";
            } else {
                $vara = $conta_disponivel-1;
                echo "Livro adicionado no carrinho! Você pode pegar mais ". $vara. " livros!";
            };
        } else {
            echo "Você não pode pegar mais livros, somente os que estão no carrinho! Devolva os pendentes para liberar mais vagas de empréstimos!";
        };
    };
    if($quantidade_rows == 3) {
        echo "Você não pode pegar mais livros! Devolva os pendentes para liberar mais vagas de empréstimos!";
    };
    
?>