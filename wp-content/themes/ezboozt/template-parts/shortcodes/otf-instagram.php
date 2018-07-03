<?php
extract(shortcode_atts(array(
    'username'        => 'flickr',
    'number'          => 9,
    'size'            => 'medium',
    'target'          => '_self',
    'design'          => 'grid',
    'per_row'         => 3,
    'margin'          => '',
    'margin_carousel' => '',
    'hide_mask'       => 0,
), $atts, 'otf_instagram'));
$class = 'instagram-widget';
$padding = '';
$matches = preg_replace('/[^0-9]/', '', $margin);
$margin_carousel = preg_replace('/[^0-9]/', '', $margin_carousel);

echo '<div class="' . esc_attr($class) . '" >';
if ($username != '') {
    if (!empty($content)): ?>
        <div class="instagram-content">
            <div class="instagram-content-inner">
                <?php echo do_shortcode($content); ?>
            </div>
        </div>
    <?php endif;
    $media_array = otf_scrape_instagram($username, $number);
    if (is_wp_error($media_array)) {
        echo esc_html($media_array->get_error_message());
    } else {
        if ($design === 'grid') {
            echo '<div class="instagram-pics" data-opal-columns="' . esc_attr($per_row) . '" style="margin-right:-' . esc_attr($matches) . 'px">';
            $space = 'style="margin-right:' . esc_attr($matches) . 'px; margin-bottom:' . esc_attr($matches) . 'px "';
        } elseif ($design === 'carousel') {
            echo '<div class="instagram-pics owl-carousel" data-opal-carousel="true" data-dots="false" data-nav="false" data-items="' . esc_attr($per_row) . '" data-margin="' . esc_attr($margin_carousel) . '" data-loop="false">';
        }
        foreach ($media_array as $item) {
            $image = (!empty($item[$size])) ? $item[$size] : $item['thumbnail'];
            $result = '<div class="instagram-picture column-item">
                            <div class="wrapp-picture" '.$space.'>
                                <a href="' . esc_url($item['link']) . '" target="' . esc_attr($target) . '"></a>
                                    <img src="' . esc_url($image) . '" />';
            if ($hide_mask == 0) {
                $result .= '<div class="hover-mask">
                                        <span class="instagram-likes"><span class="icon icon-483"></span><span>' . otf_pretty_number($item['likes']) . '</span></span>
                                        <span class="instagram-comments"><span class="icon icon-286"></span><span>' . otf_pretty_number($item['comments']) . '</span></span>
                                    </div>';
            }
            $result .= '    
                            </div>
                        </div>';
            echo($result);
        }
        ?>
        </div>
        <?php
    }
}


echo '</div>';
