document.addEventListener('DOMContentLoaded', () => {
  function redirecionarCategoria(select) {
    const categoria = select.value;
    if (categoria) {
      window.location.href = "categoria.php?categoria=" + encodeURIComponent(categoria);
    } else {
      window.location.href = "categoria.php";
    }
  }
  const wrapper = document.getElementById('categoriasWrapper');
  const prev = document.getElementById('prevCat');
  const next = document.getElementById('nextCat');

  if (!wrapper || !prev || !next) return;

  prev.addEventListener('click', () => {
    wrapper.scrollBy({ left: -150, behavior: 'smooth' });
  });

  next.addEventListener('click', () => {
    wrapper.scrollBy({ left: 150, behavior: 'smooth' });
  });

  prev.addEventListener('dblclick', () => {
    wrapper.scrollTo({ left: 0, behavior: 'smooth' });
  });

  next.addEventListener('dblclick', () => {
    wrapper.scrollTo({ left: wrapper.scrollWidth, behavior: 'smooth' });
  });

  let autoScroll = setInterval(() => {
    wrapper.scrollBy({ left: 5, behavior: 'smooth' });
  }, 10);

  wrapper.addEventListener('mouseenter', () => clearInterval(autoScroll));
  wrapper.addEventListener('mouseleave', () => {
    autoScroll = setInterval(() => {
      wrapper.scrollBy({ left: 5, behavior: 'smooth' });
    }, 10);
  });
});
