<div class="footer pb-5">
    <!-- <script src="js/main.js"></script> -->
    <script>
        $(document).ready(function() {
            // console.log('document ready admin footer');
            document.querySelectorAll(".nav-link").forEach((link) => {
                if (link.href === window.location.href) {
                    link.classList.add("active");
                    link.setAttribute("aria-current", "page");
                }
            });
        });
    </script>
</div>
</div>

</body>

</html>