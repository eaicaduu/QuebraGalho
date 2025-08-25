<div class="card mb-2 
    <?php 
        if($n['tipo'] === 'erro') echo 'border-danger text-bg-danger';
        elseif($n['tipo'] === 'aviso') echo 'border-warning text-bg-warning';
        else echo 'border-info text-bg-info';
    ?>
" style="max-width: 100%; cursor: pointer;"
    onclick="window.location.href='notificações/marcar_lida.php?produto_id=<?= isset($n['produto_id']) ? $n['produto_id'] : '' ?>'">
    <div class="card-body d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0 d-flex align-items-center gap-2">
            <?php 
                if($n['tipo'] === 'erro') echo '<i class="bi bi-exclamation-triangle-fill"></i> Erro';
                elseif($n['tipo'] === 'aviso') echo '<i class="bi bi-exclamation-circle-fill"></i> Aviso';
                else echo '<i class="bi bi-info-circle-fill"></i> Informação';
            ?>
        </h5>
        <span class="card-text mb-0"><?php echo htmlspecialchars($n['mensagem']); ?></span>
    </div>
</div>
