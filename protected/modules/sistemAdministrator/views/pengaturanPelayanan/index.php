<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Pengaturan <b>Paket Pelayanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Paket Pelayanan' => array('index'),
            'Pengaturan',
        );
        $arrMenu = array();
        $this->menu = $arrMenu;
        ?>

        <?php $this->renderPartial('_tabMenu', array()); ?>
        <?php $this->renderPartial('_jsFunctions', array()); ?>

        <iframe class="biru" id="frame" src="" frameborder="0" style="overflow-y:scroll" width="100%" height="100%" onresize="javascript:resizeIframe(this);" onload="javascript:resizeIframe(this);"></iframe>
    </div>
</div>