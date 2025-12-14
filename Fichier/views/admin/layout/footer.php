</div> <!-- content-scrollable -->
</main>
</div> <!-- app-container -->

<?php if (!empty($pageJs)): ?>
    <?php foreach ($pageJs as $js): ?>
        <script src="<?= BASE_URL ?>/assets/js/<?= $js ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>
