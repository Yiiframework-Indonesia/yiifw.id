<?php
use app\widgets\Panel;
?>
<div class="row">
    
    <div class="col-md-12 col-xs-12">
        <?php
        Panel::begin(
            [
                'header' => 'Events',
                'icon' => 'cog',
            ]
        )
        ?>
        <p>Halaman utama event.</p>
        <?php Panel::end() ?>
    </div>
</div>