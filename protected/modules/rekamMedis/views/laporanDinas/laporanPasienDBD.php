<?php
$this->breadcrumbs = array(
    'Laporan Pasien DBD',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('tableLaporan', {
            data: $(this).serialize()
    });
    return false;
});
");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Pasien DBD</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'type' => 'horizontal',
                    'id' => 'searchLaporan',
                    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
                ));
                ?>

                <?php
                $tahun = date('Y');
                $arrTahun = array();

                while ($tahun > 2016) {
                    $arrTahun[$tahun] = $tahun;
                    $tahun--;
                } ?>

                <div class="row">
                    <div class="col-sm-6">
                        <?php echo $form->dropDownListRow($model, 'tahun', $arrTahun, array('class' => 'form-control span3')); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->dropDownListRow($model, 'bulan', Params::getBulan2(), array('class' => 'form-control span3')); ?>
                    </div>
                </div>

                <div class="form-actions">
                    <?php echo CHtml::htmlButton('<i class="entypo-search"></i> Cari', array(
                        'title' => 'Cari', 'type' => 'submit', 'class' => 'btn btn-danger',
                    )); ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                        )
                    ); ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>

        <?php echo $this->renderPartial($this->path_view . '_tabMenu', array(), true); ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien DBD</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial('_tabelPasienDBD', array('model' => $model), true); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            $urlPrint = $this->createUrl('printLaporanPasienDBD');

            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            //echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="entypo-chart-area"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'GRAFIK\')'));
            $content = $this->renderPartial('tips/tips2', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<script>
    function print(caraPrint) {
        window.open("<?php echo $urlPrint; ?>/" + $('#searchLaporan').serialize() + "&caraPrint=" + caraPrint, "", 'location=_new, width=900px, scrollbars=yes');
    }
</script>