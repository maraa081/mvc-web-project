<footer class="footer" id="contact">
    <div class="container">

        <div class="footer-top">
            <div class="footer-item">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                    <circle cx="20" cy="20" r="18" fill="#1a5f3d"/>
                    <path d="M12 18h16l-2 8H14l-2-8z" fill="white"/>
                </svg>
                <span>Car Rental</span>
            </div>

            <div class="footer-item">
                <div class="footer-icon green"></div>
                <div>
                    <div class="footer-label">Adresse</div>
                    <div class="footer-value">Paris, 75016</div>
                </div>
            </div>

            <div class="footer-item">
                <div class="footer-icon green"></div>
                <div>
                    <div class="footer-label">Email</div>
                    <div class="footer-value">contact@vtcrentium</div>
                </div>
            </div>

            <div class="footer-item">
                <div class="footer-icon green"></div>
                <div>
                    <div class="footer-label">Phone</div>
                    <div class="footer-value">+33 6 16 18 95 35</div>
                </div>
            </div>
        </div>

        <div class="footer-bottom-grid">
            <div>
                <p class="footer-description">
                    Chaque détail a été conçu pour allier confort et fluidité.
                </p>

                <div class="social-links">
                    <a href="#" class="social-icon">f</a>
                    <a href="#" class="social-icon">in</a>
                    <a href="#" class="social-icon">@</a>
                    <a href="#" class="social-icon">yt</a>
                </div>
            </div>

            <div class="footer-links">
                <h4>Useful links</h4>
                <ul>
                    <li><a href="<?= BASE_URL ?>/public/index.php?page=about">À propos</a></li>
                    <li><a href="<?= BASE_URL ?>/public/index.php?page=contact">Contact</a></li>
                    <li><a href="<?= BASE_URL ?>/public/index.php?page=blog">Blog</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>Vehicles</h4>
                <ul>
                    <li><a href="<?= BASE_URL ?>/public/index.php?page=vehicles">Berline</a></li>
                    <li><a href="<?= BASE_URL ?>/public/index.php?page=vehicles">Sportcar</a></li>
                    <li><a href="<?= BASE_URL ?>/public/index.php?page=vehicles">SUV</a></li>
                </ul>
            </div>
        </div>

        <div class="copyright">
            © Copyright VTC Rentium 2025
        </div>
    </div>
</footer>

<script src="<?= BASE_URL ?>/assets/js/home.js"></script>

<?php if (!empty($pageJs)): ?>
    <?php foreach ($pageJs as $js): ?>
        <script src="<?= BASE_URL ?>/assets/js/<?= $js ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
