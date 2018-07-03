<?php if (!wp_is_mobile()): ?>
    <div class="site-header-desktop d-none d-md-block">
        <?php
        if (ezboozt_is_header_builder() ){
            ezboozt_the_header_builder();
        } else{
            get_template_part( 'template-parts/header/default' );
        }
        ?>
    </div>
<?php endif; ?>
<div class="site-header-mobile  <?php if (!wp_is_mobile()): echo 'd-md-none'; endif; ?> ">
    <?php
    get_template_part( 'template-parts/header-mobile/main' );
    ?>
</div>
