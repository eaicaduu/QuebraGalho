<div class="align-items-center d-none d-xl-flex bg-white">
  <button class="btn btn-white mx-2" type="button" id="prevCat"><i class="bi bi-caret-left"></i></button>

  <div class="flex-grow-1 overflow-hidden">
    <div class="d-flex flex-nowrap" id="categoriasWrapper"
      style="overflow-x: auto; scroll-behavior: smooth; scrollbar-width: none;">
      <?php foreach ($categorias as $categoria): ?>
        <a class="nav-link flex-shrink-0 me-4 text-dark position-relative"
          href="categoria.php?categoria=<?= urlencode($categoria['id']) ?>"
          style="padding-bottom: 5px; overflow: hidden;">
          <?= htmlspecialchars($categoria['nome']) ?>
          <span class="underline bg-warning"></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>

  <button class="btn btn-white mx-2" type="button" id="nextCat"><i class="bi bi-caret-right"></i></button>
</div>