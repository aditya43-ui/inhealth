<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Pengajuan Gaji' => Yii::app()->request->getUrlReferrer(),
    'Detail Penggajian Pegawai'
);

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapegawai-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
));
?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-file-contract"></i> Detail <b>Penggajian Pegawai</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                                ?></p>-->
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($modelpegawai, 'nomorindukpegawai', array('id' => 'NIP', 'onkeypress' => "if (event.keyCode == 13){setNip(this);}return $(this).focusNextInputField(event)", 'class' => 'span4', 'readonly' => TRUE)); ?>
                        <div class="control-group">
                            <?php echo CHtml::label('Nama', 'namapegawai', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->hiddenField($modelpegawai, 'pegawai_id', array('readonly' => true, 'id' => 'pegawai_id')) ?>
                                <?php echo $form->textField($modelpegawai, 'nama_pegawai', array('readonly' => true, 'class' => 'span4',)); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($modelpegawai, 'tempatlahir_pegawai', array('readonly' => true, 'id' => 'tempatlahir_pegawai', 'class' => 'span4',)); ?>
                        <?php echo $form->textFieldRow($modelpegawai, 'tgl_lahirpegawai', array('readonly' => true, 'id' => 'tgl_lahirpegawai', 'class' => 'span4',)); ?>
                        <?php echo $form->textFieldRow($modelpegawai, 'jeniskelamin', array('readonly' => true, 'id' => 'jeniskelamin', 'class' => 'span4',)); ?>
                        <?php echo $form->textFieldRow($modelpegawai, 'jabatan_nama', array('readonly' => true, 'id' => 'jabatan', 'class' => 'span4',)); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($model, 'no_rekening', array('readonly' => true, 'class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modelpegawai, 'norekening', array('readonly' => true, 'class' => 'span2', 'id' => 'norek')); ?>
                                <?php echo $form->textField($modelpegawai, 'banknorekening', array('readonly' => true, 'class' => 'span2', 'id' => 'banknorek', 'style' => 'width:70px;')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($modelpegawai, 'npwp', array('readonly' => true, 'id' => 'npwp', 'class' => 'span4',)); ?>
                        <div class="control-group">
                            <?php echo $form->labelEx($modelpegawai, 'No. Telepon Pegawai', array('readonly' => true, 'class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modelpegawai, 'notelp_pegawai', array('readonly' => true, 'id' => 'notelp', 'class' => 'span4')); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modelpegawai, 'No. Mobile Pegawai', array('readonly' => true, 'class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modelpegawai, 'nomobile_pegawai', array('readonly' => true, 'id' => 'nomobile', 'class' => 'span4', 'style' => 'width:70px;')); ?>
                            </div>
                        </div>
                        <?php echo $form->textFieldRow($modelpegawai, 'agama', array('readonly' => true, 'id' => 'agama', 'class' => 'span4',)); ?>
                        <?php echo $form->textAreaRow($modelpegawai, 'alamat_pegawai', array('readonly' => true, 'id' => 'alamat_pegawai', 'class' => 'span4',)); ?>
                        <?php
                        if (!empty($modelpegawai->photopegawai)) {
                            echo CHtml::image(Params::urlPegawaiTumbsDirectory() . 'kecil_' . $modelpegawai->photopegawai, 'Foto pasien', array('id' => 'photo_pasien', 'width' => 150));
                        } else {
                            echo CHtml::image(Params::urlPegawaiDirectory() . 'no_photo.jpeg', 'Photo Pegawai', array('id' => 'photo_pasien', 'width' => 150));
                        }
                        ?>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="fas fa-file"></i> Data <b>Penggajian Pegawai</b>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div style="overflow: auto">
                                    <table class='table'>
                                        <thead>
                                            <tr>
                                                <th>
                                                    Deskripsi
                                                </th>
                                                <th>
                                                    Gaji
                                                </th>
                                                <th>
                                                    Potongan
                                                </th>
                                            </tr>
                                        </thead>
                                        </tbody>
                                        <?php
                                        foreach ($kom as $item) :
                                            $komdat = KomponengajiM::model()->findByPk($item->komponengaji_id);
                                        ?>
                                            <tr>
                                                <td><?php echo $komdat->komponengaji_nama; ?></td>
                                                <td style="text-align: right;"><?php if (!$komdat->ispotongan) echo MyFormatter::formatNumberForPrint($item->jumlah, 2, true); ?></td>
                                                <td style="text-align: right;"><?php if ($komdat->ispotongan) echo MyFormatter::formatNumberForPrint($item->jumlah, 2, true); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tbody>
                                        <tfoot>
                                            <tr>
                                                <th style="text-align: right">
                                                    Total
                                                </th>
                                                <th>
                                                    <?php echo $form->textField($model, 'totalterima', array('class' => 'span2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>
                                                </th>
                                                <th>
                                                    <?php echo $form->textField($model, 'totalpotongan', array('class' => 'span2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'tglpenggajian', array('class' => 'control-label')); ?>
                                    <div class="controls">
                                        <?php $model->tglpenggajian = MyFormatter::formatDateTimeForUser($model->tglpenggajian); ?>
                                        <?php
                                        $this->widget('MyDateTimePicker', array(
                                            'model' => $model,
                                            'attribute' => 'tglpenggajian',
                                            'mode' => 'datetime',
                                            'options' => array(
                                                'dateFormat' => Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'class' => 'span3 dtPicker3',
                                            ),
                                        ));
                                        ?>
                                        <?php $model->tglpenggajian = MyFormatter::formatDateTimeForDb($model->tglpenggajian); ?>
                                    </div>
                                </div>
                                <?php echo $form->textFieldRow($model, 'nopenggajian', array('readonly' => TRUE, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                                <?php
                                $model->harialpa = (!empty($model->harialpa) ? $model->harialpa : 0);
                                $model->totalcuti = (!empty($model->totalcuti) ? $model->totalcuti : 0);
                                $model->totalizin = (!empty($model->totalizin) ? $model->totalizin : 0);
                                $model->totalsakit = (!empty($model->totalsakit) ? $model->totalsakit : 0);
                                ?>
                                <div class="control-group">
                                    <?php echo $form->label($model, 'Total Hari Kerja', array('class' => 'control-label inline')); ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'harikerja', array('style' => 'text-align: right;', 'class' => 'span1 numbers-Only harikerja', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <table style="width: 100%; border: none;">
                                            <tr>
                                                <td style="width: 120px;">
                                                    <?php echo CHtml::label('Alpa', '', array('class' => 'control-label inline', 'style' => 'width: 30px;')); ?>
                                                    <?php echo $form->textField($model, 'harialpa', array('style' => 'text-align: right;', 'class' => 'span1 numbers-Only harikerja', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                                                </td>
                                                <td>
                                                    <?php echo CHtml::label('Cuti', 'totalcuti', array('class' => 'control-label', 'style' => 'width: 30px;')); ?>
                                                    <?php echo $form->textField($model, 'totalcuti', array('style' => 'text-align: right;', 'class' => 'span1 numbers-Only totalcuti', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <?php echo CHtml::label('Izin', 'totalizin', array('class' => 'control-label', 'style' => 'width: 30px;')); ?>
                                                    <?php echo $form->textField($model, 'totalizin', array('style' => 'text-align: right;', 'class' => 'span1 numbers-Only totalizin', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                                                </td>
                                                <td>
                                                    <?php echo CHtml::label('Sakit', 'totalsakit', array('class' => 'control-label', 'style' => 'width: 30px;')); ?>
                                                    <?php echo $form->textField($model, 'totalsakit', array('style' => 'text-align: right;', 'class' => 'span1 numbers-Only totalsakit', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <?php echo $form->label($model, 'Total Kehadiran', array('class' => 'control-label inline')); ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'harihadir', array('style' => 'text-align: right;', 'class' => 'span1 numbers-Only harihadir', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo CHtml::label('Status Pengajuan Gaji', '', array('class' => 'control-label inline')); ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'statuspengajuan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                                    </div>
                                </div>
                                <?php if (!empty($model->statuspengajuan) && $model->statuspengajuan == 'prorate') { ?>
                                    <div class="control-group">
                                        <?php echo CHtml::label('Tanggl Berhenti', '', array('class' => 'control-label inline')); ?>
                                        <div class="controls">
                                            <?php
                                            $modelpegawai->tglberhenti = (!empty($modelpegawai->tglberhenti) ? MyFormatter::formatDateTimeForUser($modelpegawai->tglberhenti) : "");
                                            echo $form->textField($modelpegawai, 'tglberhenti', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true));
                                            ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php echo $form->textAreaRow($model, 'keterangan', array('readonly' => TRUE, 'rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                <?php echo $form->textFieldRow($model, 'totalpajak', array('readonly' => TRUE, 'class' => 'span3 numbersOnly', 'onblur' => 'setHarga();', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>
                                <?php echo $form->textFieldRow($model, 'potongan_lainlain', array('readonly' => TRUE, 'class' => 'span3 numbersOnly', 'onblur' => 'setHarga();', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>
                                <?php echo $form->textFieldRow($model, 'pengurangan', array('readonly' => TRUE, 'class' => 'span3 numbersOnly', 'onblur' => 'setHarga();', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>
                                <?php echo $form->textFieldRow($model, 'penambahan', array('readonly' => TRUE, 'class' => 'span3 numbersOnly', 'onblur' => 'setHarga();', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>
                                <?php echo $form->textFieldRow($model, 'penerimaanbersih', array('class' => 'span3 numbersOnly', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'mengetahui', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'id' => 'pegawai_id')) ?>
                                        <?php echo $form->textField($model, 'mengetahui', array('readonly' => true, 'class' => 'span3')); ?>
                                    </div>
                                </div>
                                <?php //echo $form->textFieldRow($model,'menyetujui',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100));  
                                ?>
                                <div class="control-group">
                                    <?php echo $form->labelEx($model, 'menyetujui', array('class' => 'control-label')) ?>
                                    <div class="controls">
                                        <?php echo $form->hiddenField($model, 'menyetujui', array('readonly' => true, 'id' => 'pegawai_id')); ?>
                                        <?php echo $form->textField($model, 'menyetujui', array('readonly' => true, 'class' => 'span3')); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Jenis Bukti Potong</label>
                                    <div class="controls">
                                        <?php
                                        echo CHtml::textField('jenis_bukti_potong', $modelpegawai->jenisBuktiPotong, array(
                                            'readonly' => true,
                                            'class' => 'span2',
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <?php echo $form->label($model, 'tarif', array('class' => 'control-label inline')); ?>
                                    <div class="controls">
                                        <?php
                                        $model->tarif = MyFormatter::formatNumberForPrint($model->tarif);
                                        echo $form->textField($model, 'tarif', array('readonly' => true, 'class' => 'span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));
                                        ?>
                                    </div>
                                </div>

                                <?php
                                if (isset($tandabuktikueluarT)) {
                                    $namaPenerima = "";
                                    $alamatPenerima = "";

                                    if ($tandabuktikueluarT->carabayarkeluar == "TUNAI") {
                                        $namaPenerima = "Penerima";
                                        $alamatPenerima = "Penerima";
                                    } else if ($tandabuktikueluarT->carabayarkeluar == "TRANSFER") {
                                        $namaPenerima = "Bank";
                                        $alamatPenerima = "Bank";
                                    }
                                ?>
                                    <div class="control-group">
                                        <?php echo CHtml::label('Jenis Penjamin', '', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php echo CHtml::textField('carabayar', $tandabuktikueluarT->carabayarkeluar, array('readonly' => true, 'class' => 'span3')); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <?php echo CHtml::label('Nama ' . $namaPenerima, '', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php echo CHtml::textField('namapenerima', $tandabuktikueluarT->namapenerima, array('readonly' => true, 'class' => 'span3')); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <?php echo CHtml::label('Alamat ' . $alamatPenerima, '', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php echo CHtml::textArea('alamatpenerima', $tandabuktikueluarT->alamatpenerima, array('readonly' => TRUE, 'rows' => 6, 'cols' => 50, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php
                    $this->widget('bootstrap.widgets.BootButtonGroup', array(
                        'type' => 'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                        'buttons' => array(
                            array('label' => 'Print', 'icon' => 'entypo-print', 'url' => '#', 'htmlOptions' => array('onclick' => 'print(\'PRINT\')')),
                            array('label' => '', 'items' => array(
                                array('label' => 'PDF', 'icon' => 'icon-book', 'url' => '', 'itemOptions' => array('onclick' => 'print(\'PDF\')')),
                                array('label' => 'EXCEL', 'icon' => 'icon-pdf', 'url' => '', 'itemOptions' => array('onclick' => 'print(\'EXCEL\')')),
                                array('label' => 'PRINT', 'icon' => 'entypo-print', 'url' => '', 'itemOptions' => array('onclick' => 'print(\'PRINT\')')),
                            )),
                        ),
                        //        'htmlOptions'=>array('class'=>'btn')
                    ));
                    ?>
                    <?php
                    $content = $this->renderPartial('penggajian.views.tips.detail_penggajian', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
                <?php
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print&id=' . $model->penggajianpeg_id . '&pegawai_id=' . $modelpegawai->pegawai_id);
                $js = <<< JSCRIPT
				function print(caraPrint){
					window.open("${urlPrint}"+$('#search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
				}
JSCRIPT;
                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                ?>
                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>