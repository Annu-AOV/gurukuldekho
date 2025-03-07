</div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
    <div class="container">
        <p class="mb-0">© 2025 Admin Panel. All Rights Reserved.</p>
    </div>
</footer>


<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>


<!-- Custom JS for Sidebar Toggle -->
<script>
    document.getElementById("menu-toggle").addEventListener("click", function () {
        document.getElementById("sidebar-wrapper").classList.toggle("toggled");
    });
</script>


<!-- password show or hide option js -->
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
        const toggleButton = this;

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleButton.textContent = 'Hide';
        } else {
            passwordField.type = 'password';
            toggleButton.textContent = 'Show';
        }
    });
</script>

</body>

</html>