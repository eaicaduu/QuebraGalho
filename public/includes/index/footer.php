<footer class="footer bg-transparent text-dark pt-5 pb-3 mt-4">
    <div class="container">
        <div class="row gy-4 align-items-start">
            <div class="col-md-6 text-center text-md-start">
                <img src="<?= $logo ?>" alt="Logo <?= $nomeEmpresa ?>" style="max-height: 60px;"
                    class="mb-3 pe-none">
                <h5 class="mb-2"><?= $nomeEmpresa ?></h5>
                <p><?= $descricaoEmpresa ?></p>
            </div>

            <div class="col-md-6 text-center text-md-start">
                <h5 class="mb-3">Contato</h5>

                <div class="d-flex flex-column flex-md-row align-items-center justify-content-center justify-content-md-start text-center text-md-start">
                    <?php if ($telefoneEmpresa): ?>
                        <a href="https://api.whatsapp.com/send?phone=<?= preg_replace('/\D/', '', $telefoneEmpresa) ?>" class="mb-1 text-decoration-none text-dark me-md-2">
                            <i class="bi bi-whatsapp"></i> <?= $telefoneEmpresa ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($telefoneSecundarioEmpresa): ?>
                        <a href="tel:<?= preg_replace('/\D/', '', $telefoneSecundarioEmpresa) ?>" class="mb-1 text-decoration-none text-dark">
                            <i class="bi bi-telephone-fill"></i> <?= $telefoneSecundarioEmpresa ?>
                        </a>
                    <?php endif; ?>
                </div>

                <?php if ($emailEmpresa): ?>
                    <a href="mailto:<?= $emailEmpresa ?>" class="d-block text-decoration-none text-dark">
                        <i class="bi bi-envelope-fill"></i> <?= $emailEmpresa ?>
                    </a>
                <?php endif; ?>

                <?php if ($enderecoEmpresa && $mapsEmpresa): ?>
                    <a href="<?= $mapsEmpresa ?>" target="_blank" class="d-block mb-1 text-decoration-none text-dark">
                        <i class="bi bi-geo-alt-fill"></i> <?= $enderecoEmpresa ?>
                    </a>
                <?php elseif ($enderecoEmpresa): ?>
                    <div class="d-block mb-1 text-dark">
                        <i class="bi bi-geo-alt-fill"></i> <?= $enderecoEmpresa ?>
                    </div>
                <?php endif; ?>
                <div class="mt-3">
                    <?php if ($facebook): ?>
                        <a href="<?= $facebook ?>" class="text-dark me-3 fs-5" target="_blank"><i class="bi bi-facebook"></i></a>
                    <?php endif; ?>
                    <?php if ($instagram): ?>
                        <a href="<?= $instagram ?>" class="text-dark me-3 fs-5" target="_blank"><i class="bi bi-instagram"></i></a>
                    <?php endif; ?>
                    <?php if ($whatsapp): ?>
                        <a href="https://api.whatsapp.com/send?phone=<?= preg_replace('/\D/', '', $whatsapp) ?>" class="text-dark me-3 fs-5" target="_blank">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="text-center small">
            &copy; <?= date('Y') ?> <?= $nomeEmpresa ?>. Todos os direitos reservados.
        </div>
    </div>
</footer>