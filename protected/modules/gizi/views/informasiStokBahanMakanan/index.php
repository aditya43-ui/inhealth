<?php
$this->breadcrumbs = array(
    'Informasi Stok Bahan Makanan',
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Stok Bahan Makanan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('gzstokbahanmakanan-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        ?>
        <?php $this->renderPartial('_search', array('model' => $model,)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Stok Bahan Makanan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
                    'id' => 'gzstokbahanmakanan-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                    'mergeHeaders' => array(
                        array(
                            'name' => '<center>Kondisi Bahan Makanan</center>',
                            'start' => 5,
                            'end' => 6,
                        ),
                    ),
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'type' => 'raw',
                            'value' => '$row+1',
                        ),
                        array(
                            'header' => 'Kelompok Bahan Makanan',
                            'type' => 'raw',
                            'value' => '$data->kelbahanmakanan',
                        ),
                        array(
                            'header' => 'Nama Bahan Makanan',
                            'type' => 'raw',
                            'value' => '$data->namabahanmakanan',
                        ),
                        array(
                            'header' => 'Minimal Stok',
                            'type' => 'raw',
                            'value' => '$data->jmlminimal',
                        ),
                        array(
                            'header' => 'Tanggal Kadaluarsa',
                            'type' => 'raw',
                            'value' => '(!empty($data->tglkadaluarsabahan)? MyFormatter::formatDateTimeForUser($data->tglkadaluarsabahan): "")',
                        ),
                        array(
                            'header' => 'Baik',
                            'type' => 'raw',
                            'value' => '(round($data->qtystok_baik * 100) / 100)." ".$data->satuanbahan',
                        ),
                        array(
                            'header' => 'Rusak',
                            'type' => 'raw',
                            'value' => '(round($data->qtystok_rusak * 100) / 100)." ".$data->satuanbahan',
                        ),
                        array(
                            'header' => 'Jumlah Bahan Makanan',
                            'type' => 'raw',
                            'value' => '(round($data->qtystok * 100) / 100)." ".$data->satuanbahan',
                        ),
                        array(
                            'header' => 'Rincian',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("rincian",array("id"=>$data->bahanmakanan_id,"frame"=>true)),array("id"=>"$data->bahanmakanan_id","target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Rincian Stok Bahan Makanan", "onclick"=>"$(\'#dialogDetail\').dialog(\'open\')"));',
                            'htmlOptions' => array('style' => 'text-align: center; width:40px'),
                            'headerHtmlOptions' => array('style' => 'text-align:center;')
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
//========= Dialog untuk Melihat detail Pengajuan Bahan Makanan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Rincian Stok Bahan Makanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 600,
        'resizable' => false,
    ),
));
echo '<iframe src="" name="frameDetail" width="100%" height="600">
</iframe>';
$this->endWidget();
?>