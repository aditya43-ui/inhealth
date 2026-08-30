<?php
$this->breadcrumbs = array(
    'Informasi Pasien Batal Periksa',
);
$arrMenu = array();
$this->menu = $arrMenu;
Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();				
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
        ");
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-users"></i> Informasi <b>Pasien Batal Periksa</b>
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
                <?php $this->renderPartial('_search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pasien Batal Periksa</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                Yii::app()->clientScript->registerScript('search', "
						$('.search-button').click(function(){
							$('.search-form').toggle();
							return false;
						});
						$('#search').submit(function(){
							$.fn.yiiGridView.update('daftarpasien-v-grid', {
								data: $(this).serialize()
							});
							return false;
						});
						");
                ?>
                <div class="block-tabel">
                    <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'daftarpasien-v-grid',
                        'dataProvider' => $model->searchInformasiBatalPeriksa(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'columns' => array(
                            array(
                                'header' => 'Tanggal Pendaftaran',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->pendaftaran->tgl_pendaftaran)',
                            ),
                            array(
                                'header' => 'No. Pendaftaran',
                                'type' => 'raw',
                                'value' => 'isset($data->pendaftaran->no_pendaftaran)?$data->pendaftaran->no_pendaftaran :"-"',
                            ),
                            array(
                                'header' => 'No. Rekam Medik',
                                'type' => 'raw',
                                'value' => 'isset($data->pasien->no_rekam_medik)?$data->pasien->no_rekam_medik :"-"',
                            ),
                            array(
                                'header' => 'Nama Pasien',
                                'type' => 'raw',
                                'value' => '$data->pasien->nama_pasien',
                            ),
                            array(
                                'header' => 'Tanggal Pembatalan',
                                'type' => 'raw',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tglbatal)',
                            ),
                            array(
                                'header' => 'Keterangan Batal',
                                'name' => 'keterangan_batal',
                                'type' => 'raw',
                                'value' => '$data->keterangan_batal',
                            ),
                            array(
                                'header' => 'No. Masuk Penunjang',
                                'type' => 'raw',
                                'value' => '($data->pasienmasukpenunjang_id)?$data->pasienmasukpenunjang->no_masukpenunjang : "-"',
                            ),
                            array(
                                'header' => 'Tanggal Masuk Penunjang',
                                'type' => 'raw',
                                'value' => '($data->pasienmasukpenunjang_id)? MyFormatter::formatDateTimeForUser($data->pasienmasukpenunjang->tglmasukpenunjang): "-"',
                            ),
                            array(
                                'header' => 'Dibatalkan Oleh',
                                'type' => 'raw',
                                'value' => '$data->createLoginpemakai->nama_pemakai',
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</div>