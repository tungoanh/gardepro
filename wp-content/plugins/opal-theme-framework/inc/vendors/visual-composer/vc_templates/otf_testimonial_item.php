<?php
$atts = shortcode_atts(array(
    'name'       => '',
    'website'    => '#',
    'job'        => '',
    'photo'      => '',
    'image_size' => 'thumbnail',
), $atts, 'otf_testimonial_item');
extract($atts);
$thumb_size = otf_get_image_size($image_size);
$thumbnail = wpb_resize($photo, null, $thumb_size[0], $thumb_size[1], true);
?>
<div class="item testimonial column-item">
    <div class="content"><?php echo apply_filters('the_content', $content); ?></div>
    <div class="author">
        <div class="author-content">
            <?php if($thumbnail['url']): ?>
                <img src="<?php echo esc_url($thumbnail['url']) ?>" width="<?php echo esc_attr($thumbnail['width']); ?>" height="<?php echo esc_attr($thumbnail['height']); ?>" alt="<?php echo esc_attr($name) ?>">
            <?php endif; ?>
            <div class="title-box">
                <a href="<?php echo esc_url($website); ?>" title="<?php esc_attr($name); ?>"
                   target="_blank">
                    <?php echo esc_html($name) ?>
                </a>
                <div class="job">
                    <?php echo esc_html($job); ?>
                </div>
            </div>
        </div>
    </div>
</div>
