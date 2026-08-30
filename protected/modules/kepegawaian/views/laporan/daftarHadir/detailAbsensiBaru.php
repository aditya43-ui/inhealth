<?php
$j = JabatanM::model()->findByPk(Params::JABATAN_ID_KASI_PERSONALIA);

$jabAkses = array(
    'jabatan_id' => Yii::app()->user->getState('jabatan_id'),
    'jabatan_nama' => (!empty($j)) ? $j->jabatan_nama : null,
);
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-file-contract"></i> Detail <b>Informasi Pegawai</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget(
            'ext.bootstrap.widgets.BootActiveForm',
            array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
                'id' => 'frmpresensi-t',
                'type' => 'horizontal',
            )
        );
        Yii::app()->clientScript->registerScript('search', "
			$('#frmpresensi-t').submit(function(){
					$.fn.yiiGridView.update('lapegawai-d-grid', {
						data: $(this).serialize()
					});
					return false;
			});
		");

        ?>


        <?php /*
    <tr>
         <td>                        
           
            <div class="control-group">
                <?php echo $form->labelEx($model, 'tglpresensi', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tglpresensi',
                            'mode'=>'datetime',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate'=>'d',
                            ),
                            'htmlOptions'=>array(
                                'readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'class'=>'dtPicker3',
                            ),
                        ));
                    ?> 
                </div>
            </div>
            
            <div class="control-group">
                <?php echo $form->labelEx($model, 'tglpresensi_akhir', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tglpresensi_akhir',
                            'mode'=>'datetime',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                                'maxDate'=>'d',
                            ),
                            'htmlOptions'=>array(
                                'readonly'=>true,
                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                'class'=>'dtPicker3',
                            ),
                        ));
                    ?>
                </div>
            </div>            
            
        </td>
    </tr>
    <tr>
        <td style="text-align: center;">
            <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), "#", array('class' => 'btn btn-default','onclick'=>'if(!confirm("'.Yii::t('mds','Do You want to cancel?').'")){return false;}else{window.location.reload();}')); ?>
            </div>
        </td>
    </tr> */ ?>

        <div class="row">
            <div class="col-sm-6">
                <?php echo $form->hiddenField($model, 'tglpresensi', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->hiddenField($model, 'tglpresensi_akhir', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->textFieldRow($modPegawai, 'nofingerprint', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->textFieldRow($modPegawai, 'kelompokpegawai_id', array('readonly' => true, 'value' => $modPegawai->kelompokpegawai->kelompokpegawai_nama, 'class' => 'span3')); ?>
                <?php echo $form->textFieldRow($modPegawai, 'jabatan_id', array('readonly' => true, 'value' => ($modPegawai->jabatan_id === null) ? '' : $modPegawai->jabatan->jabatan_nama, 'class' => 'span3')); ?>
                <?php echo $form->textFieldRow($modPegawai, 'nomorindukpegawai', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->textFieldRow($modPegawai, 'nama_pegawai', array('readonly' => true, 'class' => 'span3')); ?>
                <?php //echo $form->textFieldRow($modPegawai,'shift_id',array('readonly'=>true, 'class'=>'span3', 'value'=>isset($modPegawai->shift_id)?$modPegawai->shift->shift_nama:'-')); 
                ?>
                <?php //echo $form->textAreaRow($modPegawai,'alamat_pegawai',array('readonly'=>true,'class'=>'span3')); 
                ?>
                <?php //echo $form->textFieldRow($modPegawai,'unit_perusahaan',array('readonly'=>true,'class'=>'span3')); 
                ?>
            </div>
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($modPegawai, 'hadir', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->textFieldRow($modPegawai, 'izin', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->textFieldRow($modPegawai, 'sakit', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->textFieldRow($modPegawai, 'dinas', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->textFieldRow($modPegawai, 'alpha', array('readonly' => true, 'class' => 'span3')); ?>
                <?php echo $form->textFieldRow($modPegawai, 'cuti', array('readonly' => true, 'class' => 'span3')); ?>
                <?php //echo $form->textFieldRow($modPegawai,'rerata_jam_masuk',array('readonly'=>true,'class'=>'span3')); 
                ?>
                <?php //echo $form->textFieldRow($modPegawai,'rerata_jam_keluar',array('readonly'=>true,'class'=>'span3')); 
                ?>

            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Detail Presensi</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
            'id' => 'laporanpresensi-t-grid',
            'dataProvider' => $model->searchInfoTable(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
            'mergeHeaders' => array(
                array(
                    'name' => '<p style="margin: 0; text-align: center;">Jam</p>',
                    'start' => '3',
                    'end' => '6',
                ),
            ),
            'columns' => array(
                array(
                    'header' => 'No.',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                array(
                    'header' => 'Tgl. Presensi',
                    'value' => function ($data) {
                        return MyFormatter::formatDateTimeForUser($data['tglpresensi']);
                    }
                ),
                array(
                    'header' => 'Shift Kerja',
                    'type' => 'raw',
                    'value' => function ($data) {
                        if (!empty($data['shift_id'])) {
                            return $data['shift_nama'] . '/<br>' . $data['shift_jamawal'] . '-' . $data['shift_jamakhir'];
                        }
                    }
                ),
                array(
                    'header' => 'Masuk',
                    'value' => '$data["jamscan_masuk"]'
                ),
                array(
                    'header' => 'Keluar',
                    'value' => '$data["jamscan_keluar"]'
                ),
                array(
                    'header' => 'Datang',
                    'value' => '$data["jamscan_datang"]'
                ),
                array(
                    'header' => 'Pulang',
                    'value' => '$data["jamscan_pulang"]'
                ),
                array(
                    'header' => 'Terlambat',
                    'value' => function ($data) {
                        if (!empty($data['terlambat_mnt']) || $data['terlambat_mnt'] > 0) {
                            return $data['terlambat_mnt'] . 'm';
                        }
                        /*if ($data['verifikasi'] != true){
						 if (!empty($data['shift_id']) && !empty($data['jamscan_masuk'])){
							 if ($data['shift_jamawal'] < $data['shift_jamakhir']){
								if ($data['verifikasi'] != true){
									$shiftawal = date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['shift_jamawal'];
									$shiftawal = strtotime(date('Y-m-d H:i:s', strtotime($shiftawal.' '.Params::PRESENSI_AWAL_TERLAMBAT)));

									$scantawal = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamscan_masuk']);
								}else{
									//$shiftawal = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamkerjamasuk']);
									$shiftawal = date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamkerjamasuk'];
									$shiftawal = strtotime(date('Y-m-d H:i:s', strtotime($shiftawal.' '.Params::PRESENSI_AWAL_TERLAMBAT)));

									$scantawal = strtotime(date('Y-m-d', strtotime($data['tglpresensi'])).' '.$data['jamscan_masuk']);
								}

								 $jam = round(round(abs($shiftawal - $scantawal ) / 60,2));

								 if ($data['jamscan_masuk'] > $data['shift_jamawal']){
									 if ($jam > 0){															
										 return $jam.'m';																
									 }
								 }
							 }
						 }
					 }else{
						 return $data['terlambat_mnt'].'m';
					 }*/
                    },
                    'htmlOptions' => array('style' => 'text-align:right;')
                ),
                array(
                    'header' => 'Pulang Awal',
                    'value' => function ($data) {
                        if (!empty($data['pulangawal_mnt']) || $data['pulangawal_mnt'] > 0) {
                            return $data['pulangawal_mnt'] . 'm';
                        }
                        /*if ($data['verifikasi'] != true){
						 if (!empty($data['shift_id'] && !empty($data['jamscan_pulang']))){
							 if ($data['shift_jamawal'] < $data['shift_jamakhir']){
								 if ($data['verifikasi'] != true){
									 $shiftakhir = strtotime(date('Y-m-d').' '.$data['shift_jamakhir']);
									 $scantakhir = strtotime(date('Y-m-d').' '.$data['jamscan_pulang']);
								 }else{
									 $shiftakhir = strtotime(date('Y-m-d').' '.$data['jamkerjapulang']);
									 $scantakhir = strtotime(date('Y-m-d').' '.$data['jamscan_pulang']);
								 }

								 $jam = round(round(abs($scantakhir - $shiftakhir) / 60,2));

								 if ($data['jamscan_pulang'] < $data['shift_jamakhir']){
									 if ($jam > 0){															
										 return $jam.'m';																																														
									 }
								 }
							 }
						 }
					 }else{
						 return $data['pulangawal_mnt'].'m';
					 }*/
                    },
                    'htmlOptions' => array('style' => 'text-align:right;')
                ),
                array(
                    'header' => 'Status Kehadiran',
                    'type' => 'raw',
                    'value' => function ($data) use ($jabAkses) {
                        $data['jabatanuser_id'] = $jabAkses['jabatan_id'];
                        $data['jabatanuser_nama'] = $jabAkses['jabatan_nama'];

                        if ($data['verifikasi'] != true) {
                            if (!empty($data['jamscan_masuk'])) {
                                if (!empty($data['shift_id'])) {
                                    if ($data['verifikasi'] == true) {
                                        $jamkerja = date("H:i:s", strtotime($data['jamkerjamasuk'] . ' +1 hours'));
                                    } else {
                                        $jamkerja = date("H:i:s", strtotime($data['shift_jamawal'] . ' +1 hours'));
                                    }

                                    if ($data['jamscan_masuk'] < $jamkerja) {
                                        return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_HADIR, true, $data);
                                    }

                                    //var_dump($data['jamscan_masuk']);
                                    //var_dump($jamkerja);

                                    if ($data['jamscan_masuk'] > $jamkerja) {
                                        return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_ALPHA, true, $data);
                                    }
                                } else {
                                    return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_HADIR, true, $data);
                                }
                            }

                            if (!empty($data['jamscan_pulang'])) {
                                return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_ALPHA, true, $data);
                            }

                            return Params::getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_ALPHA, true, $data);
                        } else {
                            return  Params::getWarnaKehadiran($data['statuskehadiran_nama'], true, $data);
                        }
                    },
                ),
                array(
                    'header' => 'Keterangan',
                    'type' => 'raw',
                    'value' => function ($data) {
                        if ($data['keterangan'] != '') {
                            return $data['keterangan'];
                        }

                        if (!empty($data['shift_id'])) {
                            $pesan = 'Tidak ada';
                            if (empty($data['jamscan_masuk'])) {
                                $pesan .= ' jam masuk ';
                            }

                            if (empty($data['jamscan_pulang'])) {
                                if ($pesan == 'Tidak ada') {
                                    if ($data['tglpresensi'] . ' ' . $data['shift_jamakhir'] <= date('Y-m-d H:i:s')) {
                                        $pesan .= ' jam pulang ';
                                    }
                                } else {
                                    if ($data['tglpresensi'] . ' ' . $data['shift_jamakhir'] <= date('Y-m-d H:i:s')) {
                                        $pesan .= ' dan jam pulang ';
                                    }
                                }
                            }

                            if ($pesan != 'Tidak ada') {
                                return "<span style='color:#aa0808'>" . $pesan . "</span>";
                            }
                        } else {
                            return "<span style='color:#aa0808'>Shift belum di set</span>";
                        }
                    }
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
        ));

        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));

        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl(
            $module . '/' . $controller . '/printDetailLaporanPresensi',
            array(
                'id' => $modPegawai->pegawai_id
            )
        );

        $js = <<< JSCRIPT
function print(caraPrint)
{
    var urlDate = "&tglpresensi=" + $("#frmpresensi-t").find('input[name$="[tglpresensi]"]').val() + "&" + "tglpresensi_akhir=" + $("#frmpresensi-t").find('input[name$="[tglpresensi_akhir]"]').val();
    window.open("${urlPrint}&caraPrint="+caraPrint+urlDate,"",'location=_new, width=900px');
}
JSCRIPT;
        Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
        ?>
    </div>
</div>