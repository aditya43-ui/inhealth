<?php

/**
 *       - digunakan untuk menampilkan data dari view infopengajuanpetty_v
 *       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *       @website	<piindonesia.co.id>
 */
$this->breadcrumbs = array(
    'Informasi Petty Cash' => array('informasi'),
    'Informasi',
);
Yii::app()->clientScript->registerScript('search', "
$('#kpinfohukumanpoinpeg-v-search').submit(function(){
    $.fn.yiiGridView.update('kpinfohukumanpoinpeg-v-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Petty Cash</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian</i>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_searchInfo', array('model' => $model)) ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Petty Cash</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial($this->path_view . '_tableInfo', array('model' => $model)) ?>
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