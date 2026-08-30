<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Kirim Pesan
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            // 'Sapendidikan Ms'=>array('index'),
            'Manage',
        );
        ?>
        <?php $this->renderPartial($this->path_view . '_tabMenu', array()); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array()); ?>
        <iframe class="biru" id="frame" src="" frameborder="0" style="overflow-y:scroll" width="100%" height="100%" onresize="javascript:resizeIframe(this);" onload="javascript:resizeIframe(this);"></iframe>
    </div>
</div>