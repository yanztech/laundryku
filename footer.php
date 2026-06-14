</main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const currentUrl = window.location.href;
    const links = document.querySelectorAll('.sidebar .nav-link');
    links.forEach(link => {
        if (currentUrl.includes(link.getAttribute('href'))) {
            link.classList.add('active');
        }
    });
</script>
</body>
</html>