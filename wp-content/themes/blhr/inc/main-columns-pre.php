<?php
    $sizeMainRow = 12;
    if (is_active_sidebar('sidebar-left')) $sizeMainRow -= 3;
    if (is_active_sidebar('sidebar-right')) $sizeMainRow -= 3;
?>
<?php if (is_active_sidebar('sidebar-left')): ?>
    <div id="sidebar-left" class="col-md-3">
        <?php dynamic_sidebar('sidebar-left'); ?>
    </div>
<?php endif; ?>
<div id="site-main" class="col-md-<?php echo $sizeMainRow ?>">
