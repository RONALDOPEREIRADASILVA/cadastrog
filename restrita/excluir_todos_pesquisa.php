<?php
include "conecxao.php";

$pesquisa = $_GET['pesquisa'];
$pesquisa = mysqli_real_escape_string($conn, $pesquisa);

$sql = "DELETE FROM tabela_de_gastos WHERE nome LIKE '%$pesquisa%'";
mysqli_query($conn, $sql);

header("Location: pesquisa.php?busca=" . urlencode($pesquisa));
exit();
?>