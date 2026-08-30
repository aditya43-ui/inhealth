<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Informasi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Laporan Informasi' => array('index'),
        );
        ?>
        <?php $this->renderPartial('_tabMenu', array()); ?>
        <?php $this->renderPartial('_jsFunctions', array()); ?>

        <iframe class="biru" id="frame" src="" width='100%' frameborder="0"></iframe>
    </div>
</div>