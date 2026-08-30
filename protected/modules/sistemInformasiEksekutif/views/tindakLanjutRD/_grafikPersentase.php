<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Grafik <b>Tindak Lanjut IGD</b> <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-book icon-white"></i> Cetak Grafik')), array('class' => 'btn btn-success', 'type' => 'button', 'onclick' => 'printGrafik(\'garis\')')); ?>
        </div>
    </div>
    <div class="panel-body up">
        <canvas id="grafik-batang-tindakan"></canvas>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Grafik <b>Persentasi Tindak Lanjut IGD</b> <?php echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-book icon-white"></i> Cetak Grafik')), array('class' => 'btn btn-success', 'type' => 'button', 'onclick' => 'printGrafik(\'pie\')')); ?>
        </div>
    </div>
    <div class="panel-body">
        <center>
            <div class="col-sm-8">
                <canvas id="grafik-pie-tindakan" style="text-align: center"></canvas>
            </div>
        </center>
    </div>
</div>