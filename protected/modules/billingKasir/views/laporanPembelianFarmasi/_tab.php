<div class="panel-heading">
    <div class="panel-title">
        <i class="fas fa-chart-bar"></i> Grafik
    </div>
</div>
<div class="panel-body">
    <?php
    $this->widget('bootstrap.widgets.BootMenu', array(
        'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
        'stacked' => false, // whether this is a stacked menu
        'items' => array(
            array('label' => 'Batang', 'url' => '', 'itemOptions' => array('onclick' => 'setType(this);', 'type' => 'batang')),
            array('label' => 'Pie', 'url' => '', 'itemOptions' => array('onclick' => 'setType(this);', 'type' => 'pie')),
            array('label' => 'Garis', 'url' => '', 'itemOptions' => array('onclick' => 'setType(this);', 'type' => 'garis')),
        ),
    ));
    ?>
    <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
    </iframe>
</div>