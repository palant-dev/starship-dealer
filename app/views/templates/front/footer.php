    </div> <!-- Close container from header -->

    <footer class="bg-dark mt-5">
        <div class="container py-5">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <h5 class="text-white mb-3"><i class="bi bi-rocket-takeoff me-2"></i>Starship Dealer</h5>
                    <p class="text-white-50">Exploring the frontiers of style across the galaxy. Your portal to extraordinary fashion discoveries.</p>
                </div>
                <div class="col-lg-4">
                    <h5 class="text-white mb-3"><i class="bi bi-star me-2"></i>Navigation</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?php echo URLROOT; ?>/" class="text-white-50 text-decoration-none hover-bright">Home Base</a></li>
                        <li class="mb-2"><a href="<?php echo URLROOT; ?>/products" class="text-white-50 text-decoration-none hover-bright">Space Collection</a></li>
                        <li class="mb-2"><a href="<?php echo URLROOT; ?>/cart" class="text-white-50 text-decoration-none hover-bright">Cargo Bay</a></li>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h5 class="text-white mb-3"><i class="bi bi-broadcast me-2"></i>Contact Command</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2 text-white-50"><i class="bi bi-envelope-fill me-2"></i>transmission@starshipdealer.com</li>
                        <li class="mb-2 text-white-50"><i class="bi bi-telephone-fill me-2"></i>+1 (888) STARSHIP</li>
                        <li class="mb-2 text-white-50"><i class="bi bi-geo-alt-fill me-2"></i>Sector 7G, Fashion Galaxy</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 border-secondary">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <small class="text-white-50">&copy; <?php echo date('Y'); ?> Starship Deaker. All rights reserved across the universe.</small>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <a href="#" class="text-white-50 text-decoration-none me-3 hover-bright"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white-50 text-decoration-none me-3 hover-bright"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="text-white-50 text-decoration-none me-3 hover-bright"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white-50 text-decoration-none hover-bright"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateSearch(event) {
            const searchInput = event.target.querySelector('input[name="q"]');
            return searchInput.value.trim() !== '';
        }
    </script>
</body>
</html>