 <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
     <div class="container">
         <button class="btn btn-link text-decoration-none text-white me-3 p-0" onclick="history.back()">
             <i class="bi bi-arrow-left-circle" style="font-size: 1.5rem;"></i>
         </button>
         <a class="navbar-brand" href="#">Quebra Galho - Admin</a>
         <div class="collapse navbar-collapse justify-content-end">
             <ul class="navbar-nav">
                 <li class="nav-item me-3">
                     <span class="nav-link text-white">
                         <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['admin']); ?>
                     </span>
                 </li>
                 <li class="nav-item">
                     <a class="btn btn-danger" href="../logout.php">
                         <i class="bi bi-box-arrow-right"></i> Sair
                     </a>
                 </li>
             </ul>
         </div>
     </div>
 </nav>