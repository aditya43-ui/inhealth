    <?php
    Yii::app()->clientScript->registerScript('search', "
$('#pengirimanlinen-info-search').submit(function(){
	$('#informasipengirimanlinen-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasipengirimanlinen-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
    ?>
    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-info-circled"></i> Informasi <b>Pengiriman Linen</b>
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
                    <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-credit-card"></i> Tabel <b>Pengiriman Linen</b>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                    <?php
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'informasipengirimanlinen-grid',
                        'dataProvider' => $model->searchInformasi(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'No. Pengiriman',
                                'type' => 'raw',
                                'value' => '$data->nopengirimanlinen',
                            ),
                            array(
                                'header' => 'Tanggal Pengiriman',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tglpengirimanlinen)',
                            ),
                            array(
                                'header' => 'Instalasi',
                                'type' => 'raw',
                                'value' => '$data->ruangan->instalasi->instalasi_nama',
                            ),
                            array(
                                'header' => 'Ruangan',
                                'type' => 'raw',
                                'value' => '$data->ruangan->ruangan_nama',
                            ),
                            array(
                                'name' => 'keterangan_pengiriman',
                                'type' => 'raw',
                                'value' => '$data->keterangan_pengiriman',
                            ),
                            array(
                                'header' => 'Status',
                                'name' => 'issudahditerima',
                                'type' => 'raw',
                                'value' => '($data->issudahditerima==1)? "Sudah Diterima" : "Belum Diterima"',
                            ),
                            array(
                                'header' => 'Lihat Detail',
                                'type' => 'raw',
                                'value' => 'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/laundry/informasiPengirimanLinen/detail",array("id"=>$data->pengirimanlinen_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Pengiriman Linen Linen", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));', 'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            ),
                            array(
                                'header' => 'Terima Linen',
                                'type' => 'raw',
                                'value' => '(($data->tglterimalinen != "") ? MyFormatter::formatDateTimeForUser($data->tglterimalinen) : CHtml::link("<i class=\'icon-form-check\'></i> ", "javascript:void(0);" ,array("rel"=>"tooltip","title"=>"Klik untuk Menerima Linen", "onclick"=>"setStatus($data->pengirimanlinen_id);", )));',
                                'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    //========= Dialog untuk Melihat detail Pemakaian Barang =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id' => 'dialogDetail',
        'options' => array(
            'title' => 'Detail Pengiriman Linen',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'height' => 500,
            'resizable' => false,
        ),
    ));
    echo '<iframe src="" name="frameDetail" style="width: 100%; height: 98%;"></iframe>';
    $this->endWidget();
    ?>
    <script type="text/javascript">
        function setStatus(pengirimanlinen_id) {
            window.parent.myConfirm(' Apakah akan menerima linen? ', 'Perhatian!', function(r) {
                if (r) {
                    $.post('<?php echo $this->createUrl('ubahStatusTerima'); ?>', {
                        pengirimanlinen_id: pengirimanlinen_id
                    }, function(data) {
                        if (data.pesan == 'ok') {
                            $.fn.yiiGridView.update('informasipengirimanlinen-grid');
                        } else {
                            myAlert('Data Gagal Diubah!');
                        }
                    }, 'json');
                }
                //        else{
                //            preventDefault();
                //        }
            });
        }
    </script>