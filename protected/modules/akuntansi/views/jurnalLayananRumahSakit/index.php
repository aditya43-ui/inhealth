<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Transaksi <b>Jurnal Layanan Rumah Sakit</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Transaksi Jurnal Layanan Rumah Sakit'
        );
        ?>

        <?php $this->renderPartial($this->path_view . '_tabMenu', array()); ?>

        <iframe id="frame" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
    </div>
</div>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array()); ?>