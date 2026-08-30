<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-calculator"></i> Kalkulator Infus dan Dosis Obat
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial($this->path_view . '_tab', array()); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array()); ?>

        <iframe id="frame" class="biru" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
    </div>
</div>