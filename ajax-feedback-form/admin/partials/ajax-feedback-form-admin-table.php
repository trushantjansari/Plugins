<form id="email-sent-list" method="get">

    <input type="hidden" name="page" value="<?php echo $_REQUEST['page']; ?>" />
    <input type="hidden" name="order" value="<?php echo $_REQUEST['order']; ?>" />
    <input type="hidden" name="orderby" value="<?php echo $_REQUEST['orderby']; ?>" />

    <div id="ts-history-table" style="">
        <?php
        wp_nonce_field( 'ajax-custom-list-nonce', '_ajax_custom_list_nonce' );
        ?>
    </div>

</form>
<div class="wrap">
    <div id="icon-users" class="icon32"></div>
    <h2>Feedback List Page</h2>
    <?php $this->feedback_data->display(); ?>
</div>