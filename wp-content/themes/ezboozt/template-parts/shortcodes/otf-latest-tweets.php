<?php
if (!defined( 'ABSPATH' )){
    die( '-1' );
}

//Shortcode: [otf_latest_tweets username="opalwordpress" number="" subtitle="" information="" btn_text="" btn_link="" el_class="" type=""]
$atts = shortcode_atts(array(
    'username' => 'opalwordpress',
    'number'   => '2',
    'height'   => '200',
    'width'    => '180',
    'style'    => 'light',
    'el_class' => '',
), $atts, 'otf_latest_tweets');
extract($atts);

$js = '<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>';
?>
<div class="widget-twitter block">
    <div class="block_content">
        <div id="opal-twitter-<?php echo esc_attr( $username ); ?>" class="opal-twitter">
            <a class="twitter-timeline" data-theme="<?php echo esc_attr($style);?>" data-width="<?php echo esc_attr( $width ); ?>" data-height="<?php echo esc_attr( $height ); ?>" data-tweet-limit="<?php echo esc_attr($number); ?>" href="https://twitter.com/<?php echo esc_attr( $username ); ?>"><?php esc_html_e('Tweets by @', 'ezboozt') ?><?php echo esc_html( $username ); ?></a>
            <?php print trim($js); ?>
        </div>
    </div>
</div>