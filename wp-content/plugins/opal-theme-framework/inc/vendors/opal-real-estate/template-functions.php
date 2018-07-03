<?php

function otf_realestate_template_property_single_tabs() {
    /**
     * @var $property OpalRealEstate_Property
     */
    global $property;
    echo '
<div class="col-12">
    <nav class="opal-tab-nav single-property-tabs">
            <ul>
                <li class="active"><a href="#property-description">' . esc_html__( "Description", 'opal-theme-framework' ) . '</a></li>';
        if ($property->enable_google_map()){
            echo '<li><a href="#property-map-section">' . esc_html__( "Map", 'opal-theme-framework' ) . '</a></li>';
        }
        if ($property->enable_facilities()){
            echo '<li><a href="#property-facilities, #property-amenities">' . esc_html__( "Facilities", 'opal-theme-framework' ) . '</a></li>';
        }
        if ($property->enable_360_virtual()){
            echo '<li><a href="#property-360-virtual">' . esc_html__( "360 Virtual Tour", 'opal-theme-framework' ) . '</a></li>';
        }
        if ($property->enable_attachments()){
            echo '<li><a href="#property-attachments">' . esc_html__( "Attachments", 'opal-theme-framework' ) . '</a></li>';
        }
        if ($property->enable_floor_plans()){
            echo '<li><a href="#property-floor-plans">' . esc_html__( "Floor Plans", 'opal-theme-framework' ) . '</a></li>';
        }
        if ($property->enable_video()){
            echo '<li><a href="#property-video">' . esc_html__( "Video", 'opal-theme-framework' ) . '</a></li>';
        }
        echo '
            </ul>
    </nav>
</div>
';
}

function otf_realestate_template_property_single_navigation() {
    /**
     * @var $property OpalRealEstate_Property
     */
    global $property;
    echo '
<nav class="opal-tab-nav single-property-tabs">
    <div class="inner">
        <div class="container">
            <ul class="justify-content-around">
                <li><a href="#property-description">' . esc_html__( "Description", 'opal-theme-framework' ) . '</a></li>';
    if ($property->enable_facilities()){
        echo '<li><a href="#property-facilities">' . esc_html__( "Facilities", 'opal-theme-framework' ) . '</a></li>';
    }
    if ($property->enable_360_virtual()){
        echo '<li><a href="#property-360-virtual">' . esc_html__( "360 Virtual Tour", 'opal-theme-framework' ) . '</a></li>';
    }
    if ($property->enable_attachments()){
        echo '<li><a href="#property-attachments">' . esc_html__( "Attachments", 'opal-theme-framework' ) . '</a></li>';
    }
    if ($property->enable_floor_plans()){
        echo '<li><a href="#property-floor-plans">' . esc_html__( "Floor Plans", 'opal-theme-framework' ) . '</a></li>';
    }
    if ($property->enable_video()){
        echo '<li><a href="#property-video">' . esc_html__( "Video", 'opal-theme-framework' ) . '</a></li>';
    }
    echo '
            </ul>
        </div>
    </div>
</nav>
';
}

function otf_realestate_template_single_property_header_search() {
    if (!ore_is_property()){
        return;
    }
    ?>
    <div class="header-property-search layout-search toggle">
        <div class="container">
            <?php ore_get_template( 'search/toggle' ); ?>
        </div>
    </div>
    <?php
}
