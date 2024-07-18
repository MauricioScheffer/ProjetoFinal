<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}
include_once 'config/config.php';
include_once 'classes/Post.php';
include_once 'classes/Curtida.php';
include_once 'classes/Usuario.php';
include_once 'classes/Seguidor.php';

$usuario = new Usuario($db);
$dados_usuario = $usuario->lerPorId($_SESSION['usuario_id']);
$admin = $dados_usuario['adm'];
$idUsuario = $dados_usuario['id'];
$postagem = new Post($db);
$curtida = new Curtida($db);

if ($_GET['tipo'] === 'seguidor') {
    $idUsuario = $_GET['idUsuario'];
    $postagens = $postagem->lerPorSeguidor($idUsuario);
} elseif ($_GET['tipo'] === 'todas') {
    $postagens = $postagem->ler("");
}

// Inicializa o buffer de saída
ob_start();

// Monta a saída HTML das postagens
while ($post = $postagens->fetch(PDO::FETCH_ASSOC)) {
    // Obtendo dados do usuário da postagem
    $usuarioPostagem = $usuario->lerPorId($post['idUsuario']);
    $jaCurtiu = $curtida->jaCurtiu($post['id'], $_SESSION['usuario_id']);
    $totalCurtidas = $curtida->contarCurtidas($post['id']);
    $curtidas = $curtida->obterCurtidas($post['id']);

    // Montagem da estrutura HTML da postagem
    ?>
    <div class="feeds" id="post-<?php echo $post['id']; ?>">
        <!-- Publicação -->
        <div class="feed">
            <div class="head">
                <div class="user">
                    <div class="profile-photo">
                        <a href="perfil.php?id=<?php echo $usuarioPostagem['id']; ?>">
                            <?php echo "<img src='{$usuarioPostagem['foto']}' />"; ?>
                        </a>
                    </div>
                    <div class="ingo">
                        <h3><?php echo $usuarioPostagem['nome']; ?></h3>
                        <small><?php echo $post['titulo']; ?></small>
                    </div>
                </div>

                <a class="edit-item">
                    <?php if ($admin || $_SESSION['usuario_id'] == $usuarioPostagem['id']) : ?>
                        <a class="links" href="editarPostagem.php?postagem=<?php echo $post['id']; ?>"><span><i class="fa-regular fa-pen-to-square"></i>Editar</span></a>
                        <a class="links" href="deletarPostagem.php?postagem=<?php echo $post['id']; ?>"><span><i class="fa-regular fa-trash-can"></i>Deletar</span></a>
                    <?php endif; ?>
                </a>
            </div>

            <div class="photo">
                <?php echo "<img src='{$post['imagem']}' />"; ?>
            </div>

            <div class="action-buttons">
                <div class="interaction-buttons">
                    <button onclick="likePost(<?php echo $post['id']; ?>, '<?php echo $jaCurtiu ? 'descurtir' : 'curtir'; ?>')">
                        <i class="<?php echo $jaCurtiu ? 'fa-solid fa-heart' : 'fa-regular fa-heart'; ?>"></i>
                    </button>
                </div>
                <div class="bookmark">
                    <span><i class="fa-regular fa-bookmark"></i></span>
                </div>
            </div>

            <div class="liked-by">
                <?php foreach ($curtidas as $curtidor) : ?>
                    <span><img src="<?php echo $curtidor['foto']; ?>" alt=""></span>
                <?php endforeach; ?>
                <p><b><?php echo $totalCurtidas; ?> pessoa(s) curtiram isso</b></p>
            </div>

            <div class="caption">
                <p><b><?php echo $usuarioPostagem['nome']; ?></b> <?php echo $post['descricao']; ?></p>
            </div>
            <a href="comentario.php?postagem=<?php echo $post['id']; ?>">
                <div class="comments text-muted">Ver todos os comentários</div>
            </a>
        </div>
    </div>
    <?php
}

// Captura o conteúdo do buffer de saída
$html = ob_get_clean();

// Retorna a saída HTML
echo $html;
?>
