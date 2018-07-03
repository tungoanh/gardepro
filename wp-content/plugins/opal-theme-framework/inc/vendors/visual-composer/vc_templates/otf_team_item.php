<?php
$atts = shortcode_atts(array(
    'name'       => '',
    'photo'      => '',
    'image_size' => 'full',
    'job'        => '',
    'social'     => '',
), $atts, 'otf_team_item');
extract($atts);
$values = array();
$thumb_size = otf_get_image_size($image_size);
$thumbnail = wpb_resize($photo, null, $thumb_size[0], $thumb_size[1], true);
if (function_exists('vc_param_group_parse_atts')) {
    $values = (array)vc_param_group_parse_atts($social);
}
?>

<div class="item team column-item">
    <div class="team-wrapper">
        <div class="avatar">
            <img src="<?php echo esc_url($thumbnail['url']) ?>" width="<?php echo esc_attr($thumbnail['width']); ?>"
                 height="<?php echo esc_attr($thumbnail['height']); ?>" alt="<?php echo esc_attr($name) ?>">
        </div>
        <div class="team-content">
            <div class="team-meta">
                <h4><?php echo esc_html($name) ?></h4>
                <div class="job">
                    <?php echo esc_html($job); ?>
                </div>
                <div class="content-desc">
                    <?php echo apply_filters('the_content', $content); ?>
                </div>
            </div>
            <div class="social">
                <?php foreach ($values as $data): ?>
                    <?php echo '<a href="' . esc_html($data['link']) . '" title="' . esc_html($data['link']) . '"></a>' ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>