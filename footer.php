<!-- footer  -->
<?php include_once('views/layout/footer.php'); ?>

<!-- script code -->
<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>
<script>
// for passing base url to script js
const BASE_URL = "<?php echo $base_url; ?>";
const year = new Date().getFullYear();
document.getElementById("year").innerHTML = year;
</script>
<script src="<?php echo $base_url ?>/assets/javaScript/script.js"></script>
</body>

</html>