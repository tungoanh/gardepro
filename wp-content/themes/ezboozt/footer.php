</div><!-- #content -->
</div><!-- .site-content-contain -->
<footer id="colophon" class="site-footer" role="contentinfo">
    <?php
    if (ezboozt_is_footer_builder()) {
        ezboozt_the_footer_builder();
    } else {
        get_template_part('template-parts/footer');
    }
    ?>
</footer><!-- #colophon -->
</div><!-- #page -->
<?php do_action('opal_end_wrapper') ?>
</div><!-- end.opal-wrapper-->
<?php wp_footer(); ?>
</body>
</html>
