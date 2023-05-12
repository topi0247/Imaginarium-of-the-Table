<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<!-- 3rd -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
<script src="<?php echo $dir; ?>js/3rd/spotlight.bundle.js"></script>
<script src="<?php echo $dir; ?>js/3rd/sha256.js"></script>
<!-- script -->
<script src="<?php echo $dir; ?>js/script.js"></script>
<?php echo isset($is_novel) || isset($is_preview) ? '<script src="' . $dir . 'js/novel.js"></script>' : ''; ?>
<?php echo isset($is_index_post) ? '<script src="' . $dir . 'js/post.js"></script>' : ''; ?>
<?php echo isset($is_setting) ? '<script src="' . $dir . 'js/usersetting.js"></script>' : ''; ?>