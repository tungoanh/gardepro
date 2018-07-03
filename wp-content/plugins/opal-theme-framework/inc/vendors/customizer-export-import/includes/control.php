<span class="customize-control-title">
	<?php _e( 'Export', 'opal-theme-framework' ); ?>
</span>
<span class="description customize-control-description">
	<?php _e( 'Click the button below to export the customization settings for this theme.', 'opal-theme-framework' ); ?>
</span>
<input type="button" class="button" name="cei-export-button" value="<?php esc_attr_e( 'Export', 'opal-theme-framework' ); ?>"/>
<div class="clearfix"></div>
<br>
<input type="button" class="button" name="cei-export-button-settings" value="<?php esc_attr_e( 'Export Settings', 'opal-theme-framework' ); ?>"/>
<input type="button" class="button" name="cei-export-button-full" value="<?php esc_attr_e( 'Export Full', 'opal-theme-framework' ); ?>"/>

<hr class="cei-hr"/>

<span class="customize-control-title">
	<?php _e( 'Import', 'opal-theme-framework' ); ?>
</span>
<span class="description customize-control-description">
	<?php _e( 'Upload a file to import customization settings for this theme.', 'opal-theme-framework' ); ?>
</span>
<div class="cei-import-controls">
    <input type="file" name="cei-import-file" class="cei-import-file"/>
    <label class="cei-import-images">
        <input type="checkbox" name="cei-import-images" value="1"/> <?php _e( 'Download and import image files?', 'opal-theme-framework' ); ?>
    </label>
    <?php wp_nonce_field( 'cei-importing', 'cei-import' ); ?>
</div>
<div class="cei-uploading"><?php _e( 'Uploading...', 'opal-theme-framework' ); ?></div>
<input type="button" class="button" name="cei-import-button" value="<?php esc_attr_e( 'Import', 'opal-theme-framework' ); ?>"/>