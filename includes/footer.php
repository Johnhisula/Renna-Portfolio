    <!-- ===================================================================
         FOOTER
    ==================================================================== -->
    <footer id="footer" class="footer-section">
        <div class="container">
            <!-- Footer Top — Social + Quick Links -->
            <div class="row gy-4 mb-5">
                <!-- Brand Column -->
                <div class="col-lg-4">
                    <a href="#top" class="footer-brand d-inline-block mb-3">
                        Renna<span class="brand-accent">.</span>
                    </a>
                    <p class="footer-tagline">
                        Transforming raw data into meaningful insights with passion and precision.
                    </p>
                    <!-- Social Icons -->
                    <div class="footer-socials">
                        <a href="https://github.com/" target="_blank" rel="noopener" aria-label="GitHub" class="social-icon">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="https://linkedin.com/" target="_blank" rel="noopener" aria-label="LinkedIn" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://twitter.com/" target="_blank" rel="noopener" aria-label="Twitter / X" class="social-icon">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                        <a href="https://kaggle.com/" target="_blank" rel="noopener" aria-label="Kaggle" class="social-icon">
                            <i class="fab fa-kaggle"></i>
                        </a>
                        <a href="mailto:hello@renna.dev" aria-label="Email" class="social-icon">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-4">
                    <h6 class="footer-heading">Navigate</h6>
                    <ul class="footer-links">
                        <li><a href="#about">About</a></li>
                        <li><a href="#skills">Skills</a></li>
                        <li><a href="#projects">Projects</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>

                <!-- Focus Areas -->
                <div class="col-lg-3 col-md-4">
                    <h6 class="footer-heading">Focus Areas</h6>
                    <ul class="footer-links">
                        <li><a href="#projects">Data Analysis</a></li>
                        <li><a href="#projects">Dashboard Design</a></li>
                        <li><a href="#projects">Data Visualization</a></li>
                        <li><a href="#projects">SQL &amp; Databases</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-3 col-md-4">
                    <h6 class="footer-heading">Get in Touch</h6>
                    <ul class="footer-links footer-contact">
                        <li>
                            <i class="fas fa-envelope me-2"></i>
                            <a href="mailto:estandartefaye@gmail.com">estandartefaye@gmail.com</a>
                        </li>
                        <li>
                            <i class="fas fa-map-marker-alt me-2"></i>
                            Panabo City, Philippines
                        </li>
                        <li>
                            <i class="fas fa-clock me-2"></i>
                            Open for opportunities
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="footer-divider">

            <!-- Footer Bottom — Copyright -->
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="footer-copy mb-0">
                        &copy; <?php echo date('Y'); ?> Renna. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="footer-copy mb-0">
                        Designed & built with <i class="fas fa-heart text-danger"></i> & data
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- ===================================================================
         CERTIFICATE MODAL LIGHTBOX
         =================================================================== -->
    <div class="modal fade" id="certModal" tabindex="-1" aria-labelledby="certModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="background-color: var(--clr-bg-card); border: 1px solid var(--clr-border);">
                <div class="modal-header border-0 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="modal-title" id="certModalLabel" style="color: var(--clr-text-heading); font-family: var(--font-heading); font-weight: 700;">Certificate View</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="filter: invert(1); opacity: 0.8;"></button>
                </div>
                <div class="modal-body text-center p-3">
                    <img id="certModalImage" src="" alt="Certificate Image" class="img-fluid rounded" style="max-height: 80vh; object-fit: contain; box-shadow: var(--shadow-card);">
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Back to Top Button ===== -->
    <button id="backToTop" class="back-to-top" aria-label="Back to top">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- ===== Bootstrap 5 JS Bundle (CDN) ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>

    <!-- ===== Custom Scripts ===== -->
    <script src="assets/js/main.js"></script>
</body>
</html>
