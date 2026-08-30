<div class="white-container">
    <legend class="rim2">Informasi Stok <bObat Alkes Pasien</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php
     $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
     $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai

    Yii::app()->clientScript->registerScript('cari wew', "
    $('#daftarPasien-form').submit(function(){
            $('#daftarPasien-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('daftarPasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel Stok <b>Obat Alkes Pasien</b></h6>
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'daftarPasien-grid',
            'dataProvider'=>$model->searchRI(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                                    array(
                                            'header'=>'No.',
                                            'value' => '($this->grid->dataProvider->pagination) ? 
                                                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                            : ($row+1)',
                                            'type'=>'raw',
                                            'htmlOptions'=>array('style'=>'text-align:right;'),
                                    ),
                    array(
                       'header'=>'Tanggal Pendaftaran',
                        'type'=>'raw',
                        'value'=>'$data->tgl_pendaftaran'
                    ),
                    array(
                       'header'=>'No. Pendaftaran',
                        'type'=>'raw',
                        'value'=>'$data->no_pendaftaran',
                    ),
                    array(
                       'header'=>'No. Rekam Medik',
                        'type'=>'raw',
                        'value'=>'$data->no_rekam_medik',
                    ),
                    array(
                       'header'=>'Nama Pasien',
                        'type'=>'raw',
                        'value'=>'$data->nama_pasien',
                    ),
                                    'instalasi_id',
                                    'pendaftaran_id',
                                    'pasienadmisi_id',
                    array(
                        'name'=>'Stok Obat Alkes',
                        'type'=>'raw',
                        'value'=>'CHtml::link("<i class=\'icon-list-brown\'></i> ", Yii::app()->controller->createUrl("/prescribingControl/InformasiStokObatAlkesPasien/StokObat", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id,"frame"=>true)), array("target"=>"frameStok", "onclick"=>"$(\'#dialogStokObat\').dialog(\'open\');", "rel"=>"tooltip","title"=>"Klik untuk stok obat alkes"))',
                                            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                    ),
                    array(
                        'name'=>'Detail Stok Obat',
                        'type'=>'raw',
                        'value'=>'CHtml::link("<i class=\'icon-list\'></i> ", Yii::app()->controller->createUrl("/prescribingControl/InformasiStokObatAlkesPasien/DetailStok", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"pasienadmisi_id"=>$data->pasienadmisi_id,"frame"=>true)), array("target"=>"frameDetailStok", "onclick"=>"$(\'#dialogDetailStok\').dialog(\'open\');", "rel"=>"tooltip","title"=>"Klik untuk detail stok obat alkes"))',
                                            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                    ),
                ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        ?>
    </div>
    <?php echo $this->renderPartial('_formPencarian', array('model'=>$model,'format'=>$format)); ?>
</div>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogStokObat',
    'options' => array(
        'title' => 'Stok Obat Alkes Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<iframe name='frameStok' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetailStok',
    'options' => array(
        'title' => 'Detail Stok Obat Alkes Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<iframe name='frameDetailStok' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>