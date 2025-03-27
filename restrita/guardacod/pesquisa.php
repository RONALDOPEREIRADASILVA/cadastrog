<!doctype html>
<html lang="pt-br">

<head>
    <title>Pesquisa</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="style2.css">

</head>

<body>
    <header>
    </header>
    <?php
    include "conecxao.php";

    $pesquisa = $_POST['busca'] ?? '';
    $pesquisa = mysqli_real_escape_string($conn, $pesquisa);

    // O formulário agora está fora do bloco condicional
    ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Pesquisar Gastos</h1>
                <nav class="navbar navbar-light">
                    <form class="form-inline" action="pesquisa.php" method="post">
                        <input class="form-control mr-sm-2" type="search" placeholder="Pesquisar" aria-label="Pesquisar" name="busca" autofocus>
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Pesquisar</button>
                    </form>
                </nav>
                <?php
                if (!empty($pesquisa)) {
                    $sql = "SELECT * FROM tabela_de_gastos WHERE nome LIKE '%$pesquisa%'";
                    $dados = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($dados) > 0) {
                        $total = 0;
                        ?>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Foto</th>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Tipo de Gasto</th>
                                    <th scope="col">Data</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Ações</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($linha = mysqli_fetch_assoc($dados)) {
                                    $idpessoa = $linha['idpessoa'];
                                    $nome = $linha['nome'];
                                    $tipogastos = $linha['tipogastos'];
                                    $data = $linha['data'];
                                    $valor = $linha['valor'];
                                    $foto = $linha['foto'];
                                    $lista_foto = "minha_classe_padrao";
                                    $mostra_foto = $foto ? "<img src='img/$foto' class='$lista_foto'>" : '';

                                    echo "<tr>
                                            <th>$mostra_foto</th>
                                            <th>$idpessoa</th>
                                            <td>$nome</td>
                                            <td>$tipogastos</td>
                                            <td>$data</td>
                                            <td>$valor</td>
                                            <td>
                                                <a href='cadastro_edit.php?id=$idpessoa' class='btn btn-success btn-sm'>Editar</a>
                                                <a href='#' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#confirma' onclick='pegar_dados($idpessoa, \"$nome\")'>Excluir</a>
                                            </td>
                                        </tr>";
                                    $total += $valor;
                                }
                                ?>
                            </tbody>
                        </table>
                        <p>Total: <?php echo number_format($total, 2, ',', '.'); ?></p>
                        <?php
                    } else {
                        echo "<p>Nenhum resultado encontrado para '$pesquisa'.</p>";
                    }
                } else {
                    echo "<p>Por favor, digite um termo de pesquisa.</p>";
                }
                ?>
                <a href="index.php" class="btn btn-info">Voltar para o Início</a>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirma" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirmação de exclusão</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="excluir_script.php" method="POST">
                        <p>Deseja realmente excluir <b><span id="nome_pessoa"></span></b>?</p>
                        <input type="hidden" name="nome" id="nome_pessoa_1" value="">
                        <input type="hidden" name="id" id="idpessoa" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                    <input type="submit" class="btn btn-danger" value="Sim">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function pegar_dados(id, nome) {
            document.getElementById('nome_pessoa').textContent = nome;
            document.getElementById('nome_pessoa_1').value = nome;
            document.getElementById('idpessoa').value = id;
        }
    </script>

    <footer>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>