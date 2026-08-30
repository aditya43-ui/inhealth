<?php
$this->breadcrumbs = array(
    'Informasi Pemakaian Mobil Jenazah',
);
$arrMenu = array();
$this->menu = $arrMenu;
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pemakaian Mobil Jenazah</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $.fn.yiiGridView.update('pemakaianambulans-t-grid', {
            data: $(this).serialize()
        });
        return false;
    });
    ");
        ?>
        <?php $this->renderPartial('_searchPemakaian', array('model' => $model, 'format' => $format)); ?>
        <div class='panel panel-success'>
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pemakaian Mobil Jenazah</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'pemakaianambulans-t-grid',
                    'dataProvider' => $model->searchPemakaian(),
                    //'filter'=>$modPemakaian,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
                    'columns' => array(
                        'no_rekam_medik',
                        'pemakai_nama',
                        'nama_pasien',
                        'tempattujuan',
                        'alamattujuan',
                        array(
                            'header' => 'No. Handphone/<br>Telepon',
                            'value' => '$data->nomobile." / ".$data->notelepon',
                        ),
                        array(
                            'header' => $model->getAttributeLabel('supir_id'),
                            'value' => '$data->supir_nama',
                        ),
                        array(
                            'header' => 'Paramedis',
                            'value' => '(isset($data->paramedis1_nama) ? $data->paramedis1_nama : "")." / ".(isset($data->paramedis2_nama) ? $data->paramedis2_nama : "")',
                        ),
                        array(
                            'header' => 'KM Awal/<br>KM Akhir',
                            'value' => 'number_format($data->kmawal)."/".number_format($data->kmakhir)',
                            'filter' => false,
                        ),
                        array(
                            'name' => 'jumlahkm',
                            'value' => 'number_format($data->jumlahkm)',
                        ),
                        array(
                            'name' => 'tarifperkm',
                            'header' => 'Tarif/KM',
                            'value' => 'number_format($data->tarifperkm)',
                        ),
                        array(
                            'name' => 'totaltarifambulans',
                            'header' => 'Total Tarif Mobil Jenazah (Rp)',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                            'value' => 'number_format($data->totaltarifambulans)',
                        ),
                        array(
                            'name' => 'tglkembaliambulans',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglkembaliambulans)',
                        ),
                        array(
                            'header' => 'Lihat Detail',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("' . Yii::app()->controller->id . '/view",array("pemakaianambulans_id"=>$data->pemakaianambulans_id)),
                                        array("target"=>"iframepemakaian", "onclick"=>"$(\"#detail-pemakaian\").dialog(\"open\");",
                                                "class"=>"btn-small"))',
                        ),
                        array(
                            'header' => 'Batal Pakai',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'type' => 'raw',
                            'value' => 'CHtml::Link("<i class=\"icon-form-silang\"></i>","javascript:void(0)",
                                        array("onclick"=>"batalPakai(\'$data->pemakaianambulans_id\',\'$data->pesanambulans_t\')",
                                                "class"=>"btn-small"))',
                        )
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function batalPakai(pemakaian_id, pemesanan_id) {
        myConfirm("Anda yakin akan membatalkan pemakaian ambulans?", "Perhatian!", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('batalPakai'); ?>', {
                    pemakaian_id: pemakaian_id,
                    pemesanan_id: pemesanan_id
                }, function(data) {
                    if (data.status == 'berhasil') {
                        $.fn.yiiGridView.update('pemakaianambulans-t-grid', {
                            data: $(this).serialize()
                        });
                        myAlert('Data berhasil dibatalkan');
                        return false;
                    } else {
                        myAlert('Data gagal disimpan')
                    }
                }, 'json');
            }
        });
    }
</script>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'detail-pemakaian',
    'options' => array(
        'title' => 'Detail Pemakaian Mobil Jenazah',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 800,
        'height' => 400,
        'resizable' => false,
    ),
)); ?>
<iframe src="" name="iframepemakaian" style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget(); ?>