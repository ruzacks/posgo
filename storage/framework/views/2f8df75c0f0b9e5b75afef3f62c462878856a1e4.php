<footer class="dash-footer">
    <div class="footer-wrapper">
        <div class="py-1">
            <span class="text-muted"><?php echo e(__('Copyright')); ?> 
                <?php echo e(env('FOOTER_TEXT') ? env('FOOTER_TEXT') : Utility::getValByName('footer_text')); ?>

                <?php echo e(date('Y')); ?></span>
        </div>
    </div>
</footer>
<?php /**PATH D:\xampp8\htdocs\posgo\resources\views/footer.blade.php ENDPATH**/ ?>