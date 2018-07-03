<?php
if (!defined('ABSPATH')) {
    die('-1');
}

//Shortcode: [otf_pricing el_class=""]
$atts = shortcode_atts(array(
    'title'       => '',
    'subtitle'    => '',
    'style'       => 'style-1',
    'price'       => '$99',
    'per'         => '/month',
    'attributes'  => '',
    'show_button' => true,
    'text_button' => 'Get Started',
    'btn_link'    => true,
    'recommend'   => true,
    'link_config' => 'customize',
    'membership'  => '',
    'el_class'    => '',
), $atts, 'otf_pricing');
extract($atts);

$class = $values = array();
$class[] = $style;
if ($recommend) {
    $class[] = ' recommend';
} else {
    $class[] = '';
}
$class = implode('', array_filter($class));
if (function_exists('vc_param_group_parse_atts')) {
    $values = (array)vc_param_group_parse_atts($attributes);
}

//parse link
$data_link = array();
$link = ('||' === $btn_link) ? '' : $btn_link;
$link = ezboozt_build_link($link);
$use_link = false;

if (strlen($link['url']) > 0) {
    $use_link = true;
    $a_href = $link['url'];
    $a_title = $link['title'];
    $a_target = $link['target'];
    $a_rel = $link['rel'];
}

if ($use_link) {

    $data_link[] = 'href="' . trim($a_href) . '"';
    $data_link[] = 'title="' . esc_attr(trim($a_title)) . '"';
    if (!empty($a_target)) {
        $data_link[] = 'target="' . esc_attr(trim($a_target)) . '"';
    }
    if (!empty($a_rel)) {
        $data_link[] = 'rel="' . esc_attr(trim($a_rel)) . '"';
    }
    if (empty($text_button)) {
        $text_button = $a_title;
    }

    if ($recommend) {
        $data_link[] = 'class="button-primary ' . esc_attr($class) . '"';
    } else {
        $data_link[] = 'class="button-secondary ' . esc_attr($class) . '"';
    }
}
$data_link = implode(' ', $data_link);
?>

<div class="otf-pricing rounded <?php echo esc_attr($el_class); ?> <?php echo esc_attr($class) ?>">
    <div class="pricing-header text-center">
        <?php if ($recommend): ?>
            <span class="recommend d-inline-block rounded recommend-text">
                <?php esc_html_e('Recommend', 'ezboozt'); ?>
            </span>
        <?php endif; ?>

        <?php if ($title): ?>
            <h6 class="title">
                <?php echo esc_html($title); ?>
            </h6>
        <?php endif; ?>

        <?php if ($subtitle): ?>
            <span class="subtitle">
            <?php echo esc_html($subtitle); ?>
        </span>
        <?php endif; ?>
        <?php if ($price): ?>
            <div class="price">
                <?php echo esc_html($price); ?>
            </div>
        <?php endif; ?>

        <?php if ($per): ?>
            <div class="per">
                <?php echo esc_html($per); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="pricing-info">
        <ul class="list-inline p-0 m-0">
            <?php foreach ($values as $data): ?>
                <?php $active = (isset($data['active']) && $data['active']) ? 'active' : ''; ?>
                <li class="<?php echo esc_attr($active); ?>">
                    <i class="fa fa-check-circle-o" aria-hidden="true"></i><?php echo esc_html($data['label']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="pricing-footer text-center">
        <?php
        if ($link_config === 'membership'):
            if ($recommend) {
                $el_class = 'button-primary ' . esc_attr($class);
            } else {
                $el_class = 'button-secondary ' . esc_attr($class);
            }
            echo ezboozt_do_shortcode('owm_button_checkout', array('id' => $membership, 'label' => $text_button, 'el_class' => $el_class));
        elseif ($use_link): ?>
            <a <?php echo trim($data_link); ?>><?php echo esc_html($text_button); ?></a>
        <?php endif; ?>
    </div>

</div>
