<?php

/**
 *       - digunakan untuk menampilkan data dari view infopengajuanpetty_v
 *       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *       @website	<piindonesia.co.id>
 */
$this->breadcrumbs = array(
    'Informasi Pengisian Saldo Awal' => array('informasi'),
    'Informasi',
);
Yii::app()->clientScript->registerScript('search', "
$('#pengisiansaldoawal-v-search').submit(function(){
    $.fn.yiiGridView.update('pengisiansaldoawal-v-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Informasi <b>Pengisian Saldo Awal</b></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel Pengisian Saldo Awal</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_table', array('model' => $model)) ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Pencarian</div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_search', array('model' => $model)) ?>
            </div>
        </div>
    </div>
</div>
<?php // echo $this->renderPartial($this->path_view.'js._jsFunctionsInfo', array('model'=>$model)) 
?>
<?php // echo $this->renderPartial($this->path_view.'dialog._dialogDetail', array('model'=>$model)) 
?>
<?php // echo $this->renderPartial($this->path_view.'dialog._dialogApprove', array('model'=>$model)) 
?>