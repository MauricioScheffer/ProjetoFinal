$query .= "SELECT p.* FROM postagem p INNER JOIN seguidor ON p.idusu = idseguido ";
$query .= "WHERE seguidor = $idusu";