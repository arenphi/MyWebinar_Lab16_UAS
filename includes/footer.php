<footer class="footer-mobile" id="footer-mobile">
   <nav class="footer__nav container">
      <ul class="footer__list">
         <li class="footer__item">
            <a href="beranda" class="footer__link">
               <i class="ri-home-5-line"></i>
               <span>Beranda</span>
            </a>
         </li>

         
         <li class="footer__item">
            <a href="/mywebinar/diskusi" class="footer__link">
               <i class="ri-chat-3-line"></i>
               <span>Diskusi</span>
            </a>
         </li>

         <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
   <li>
      <a href="admin" class="nav__link">Dashboard Admin</a>
   </li>
<?php endif; ?>
         
         <?php if(isset($_SESSION['id_user'])): ?>
         <li class="footer__item">
            <a href="#" class="footer__link footer__add-btn" id="open-modal">
               <i class="ri-add-circle-fill" style="color: #f5f5f5; font-size: 1.8rem;"></i>
               <span>Buat</span>
            </a>
         </li>
         <?php endif; ?>


   <?php if(isset($_SESSION['id_user'])): ?>
   <li>
      <a href="profil" class="footer__link">
         <img src="uploads/profil/<?= $foto_profil ?>" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover;">
         <span style="color: #f5f5f5;">Profil</span>
      </a>
   </li>
   <?php else: ?>
   <li>
      <a href="login" class="footer__link">
         <i class="ri-user-line"></i>
         <span>Login</span>
      </a>
   </li>
   <?php endif; ?>
</ul>
      </div>
   </nav>
</footer>