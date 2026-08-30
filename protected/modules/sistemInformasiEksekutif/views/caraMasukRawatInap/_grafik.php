<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Grafik <b>Rawat Inap Berdasarkan Cara Masuk</b> <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak Grafik', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'print("garis")')); ?> </div>
    </div>
    <div class="panel-body up">
        <canvas id="grafik-garis-caramasuk"></canvas>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Grafik <b>Prosentase Rawat Inap Berdasarkan Cara Masuk</b> <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak Grafik', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'print("pie")')); ?> </div>
    </div>
    <div class="panel-body up">
        <canvas id="grafik-pie-caramasuk"></canvas>
    </div>
</div>