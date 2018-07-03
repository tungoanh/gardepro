<?php
$cssCode = '';
$width   = $bg_color = false;
$layout  = '1c';
if (is_singular('post')){
    $layout = get_theme_mod( 'otf_blog_single_layout', '2cr' );
    $width  = get_theme_mod( 'otf_blog_single_sidebar_width', 320 );
}else if (otf_is_blog_archive()){
    $layout = get_theme_mod( 'otf_blog_archive_layout', '2cr' );
    $width  = get_theme_mod( 'otf_blog_archive_sidebar_width', 320 );
} elseif (is_page()){
    $layout = otf_get_metabox( get_the_ID(), 'otf_layout', '1c' );
    $width  = otf_get_metabox( get_the_ID(), 'otf_sidebar_width', 320 );
}

$layout = apply_filters( 'otf_customize_layout_page', $layout );
$width  = apply_filters( 'otf_customize_sidebar_width', $width );


if ($width && '1c' != $layout){
    $cssCode .= <<<CSS
@media (min-width: 769px){
    body #secondary{
        flex: 0 0 {$width}px;
        max-width: {$width}px;
    }
    
    #primary{
        flex: 0 0 calc(100% - {$width}px);
        max-width: calc(100% - {$width}px);
    }
}

@media(max-width: 768px){
    #secondary, #primary{
        flex: 0 0 100%;
        max-width: 100%;
    }
    
    body.opal-content-layout-2cl #secondary{
        order: 2;
    }
}

CSS;
}

if ($bg_color){
    $cssCode .= <<<CSS
.site-content-contain{
    background-color: {$bg_color};
}
CSS;

}

return $cssCode;
