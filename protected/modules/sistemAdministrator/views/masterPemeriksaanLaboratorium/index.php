<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-layer-group"></i> Master <b>Pemeriksaan Laboratorium</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Master Pemeriksaan Laboratorium',
        );
        ?>

        <?php $this->renderPartial($this->path_view . '_tabMenu', array()); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array()); ?>

        <iframe class="biru" id="frame" src="" width='100%' frameborder="0"></iframe>
    </div>
</div>