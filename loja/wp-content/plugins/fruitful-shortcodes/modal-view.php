<style>

</style>
<div class="ffst-modal modal version">
    <form action="#" id="ffst-modal-form">
        <h1><?php echo __('Choose plugin version:', 'ff_shortcodes'); ?></h1>
        <div class="ffst-modal__content">
            <div class="ff-versions">
                <div class="ff-version" data-version="old">
                    <img src="<?php echo FF_SC_PLUGIN_URL; ?>assets/images/shortcodes.png">
                    <h2><?php echo __('Fruitful Shortcodes', 'ff_shortcodes'); ?></h2>
                </div>
                <div class="ff-version" data-version="new">
                    <img src="<?php echo FF_SC_PLUGIN_URL; ?>assets/images/shortcodes-2.png">
                    <h2><?php echo __('Fruitful Shortcodes 2.0', 'ff_shortcodes'); ?><br/><span><?php echo __('( New version )', 'ff_shortcodes'); ?></span></h2>
                </div>
            </div>
            <span class="ff-notice">* <?php echo __('You will be able to change plugin version on settings page later', 'ff_shortcodes'); ?></span>
        </div>
        <button type="button" class="notice-dismiss"></button>
    </form>
</div>