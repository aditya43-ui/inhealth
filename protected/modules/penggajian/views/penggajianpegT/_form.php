<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js',  CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js',  CClientScript::POS_END); ?>
<?php

$konfsy = KonfigsystemK::model()->find();
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gjpenggajianpeg-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
));
?>
<?php
if (isset($_GET['sukses']))
    // echo '<div id="yw0"><div class="alert alert-block alert-success"><a class="close" data-dismiss="alert">×</a><b>Berhasil!</b> Data berhasil disimpan.</div></div>';
?>
<!--	<p class="help-block"></p>-->
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Data <b>Pegawai</b>
        </div>
    </div>
    <div class="panel-body">
        <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->
        <?php //echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
        ?>
        <?php $this->renderPartial($this->path_view . '_pegawai', array('model' => $modPegawai, 'form' => $form)); ?>
        <?php echo $form->errorSummary($model); ?>
    </div>
</div>

<?php //echo $form->textFieldRow($model,'pegawai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  
?>
<?php //echo $form->textFieldRow($model,'tglpenggajian',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-money-bill"></i> Penggajian
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'tglpenggajian', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        $model->tglpenggajian = MyFormatter::formatDateTimeForUser($model->tglpenggajian);

                        //	echo $form->textField($model, 'tglpenggajian', array('readonly'=>true, 'class'=>'realtime'));

                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglpenggajian',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3 dtPicker3',
                            ),
                        ));

                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($model, 'Periode Gaji', array('class' => 'control-label inline')); ?>
                    <div class="controls">
                        <?php
                        // var_dump($model->attributes); die;

                        $this->widget('MyMonthPicker', array(
                            'model' => $model,
                            'attribute' => 'periodegaji',
                            'options' => array(
                                'dateFormat' => Params::MONTH_FORMAT,
                                'yearRange' => "-100y:+0y",
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'class' => "span2 periode_gaji",
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'onchange' => 'getTanggalPeriode(); setKomponenGaji(null);',
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Tgl. Periode Gaji', '', array('class' => 'control-label inline')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('tglgaji_awal', '', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => TRUE)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Metode PPh 21 <span class="required">*</span>', 'metode_pph_21', array('class' => 'control-label inline required')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'pajak_id'); ?>
                        <?php echo $form->dropDownList($model, 'metode_pph_21', LookupM::getItemsUrutan('metode_pph_21'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => TRUE)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Status Pengajuan Gaji <span class="required">*</span>', 'metode_pph_21', array('class' => 'control-label inline required')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'statuspengajuan', LookupM::getItemsUrutan('statuspengajuan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->label($model, 'Nomor Penggajian', array('class' => 'control-label inline')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'nopenggajian', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        <?php echo $form->textField($model, 'no_temp', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => TRUE)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($model, 'Total Hari Kerja', array('class' => 'control-label inline')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'harikerja', array('style' => 'text-align: right;', 'class' => 'span1 numbers-Only harikerja', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true, 'onkeyup' => 'hitungHariKerjaUntukTunjanganTidakTetap();')); ?>
                    </div>
                    <?php echo $form->label($model, 'Alpa', array('class' => 'control-label', 'style' => 'width: 30px;')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'harialpa', array('style' => 'text-align: right;', 'class' => 'span1 numbers-Only harialpa', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true, 'onkeyup' => 'hitungHariKerjaUntukTunjanganTidakTetap();')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <!--<?php echo CHtml::label("", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                    </div>-->
                    <?php echo CHtml::label('Cuti', 'totalcuti', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'totalcuti', array('style' => 'text-align: right;', 'class' => 'span1 numbers-Only totalcuti', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                    </div>
                    <?php echo CHtml::label('Izin', 'totalizin', array('class' => 'control-label', 'style' => 'width: 30px;')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'totalizin', array('style' => 'text-align: right;', 'class' => 'span1 numbers-Only totalizin', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                    </div>
                    <?php echo CHtml::label('Sakit', 'totalsakit', array('class' => 'control-label', 'style' => 'width: 30px;')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'totalsakit', array('style' => 'text-align: right;', 'class' => 'span1 numbers-Only totalsakit', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Sampai dengan', '', array('class' => 'control-label inline')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('tglgaji_akhir', '', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => TRUE)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($model, 'Total Kehadiran', array('class' => 'control-label inline')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'harihadir', array('style' => 'text-align: right;', 'class' => 'span1 numbers-Only harihadir', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true, 'onkeyup' => 'hitungHariKerjaUntukTunjanganTidakTetap();')); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <!--<table class='table'>-->
                <table class="table table-bordered table-striped table-condensed" id="komponen_gaji">
                    <thead>
                        <tr>
                            <th>Deskripsi</th>
                            <th width="50">Qty</th>
                            <th width="100">Satuan</th>
                            <th width="100">Gaji</th>
                            <th width="100">Potongan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php /*
					$modKomponen = KomponengajiM::model()->findAll('komponengaji_aktif = true order by ispotongan IS TRUE ASC, nourutgaji');
					if (count((array)$modKomponen > 0)) {
						foreach ($modKomponen as $i => $v) {
							?>
							<tr>
								<td>
								<?php echo $v->komponengaji_nama; ?>
								</td>
								<?php
								echo ($v->ispotongan == false) ? "<td>" . $form->textField($komponen, "komponengaji_id[" . $v->komponengaji_id . "]", array('value' => 0, 'class' => 'span2 integer2 gaji pph', 'onblur' => 'setGaji(); hitungpph();')) . "</td><td></td>" : "<td></td><td>" . $form->textField($komponen, "komponengaji_id[" . $v->komponengaji_id . "]", array('class' => 'span2 integer2 potongan', 'onblur' => 'setPotongan();', 'value' => 0)) . "</td>";
								?>
							</tr>
						<?php
						}
					}*/
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="text-align: right" colspan="3">Total</th>
                            <th><?php echo $form->textField($model, 'totalterima', array('style' => 'text-align: right; ', 'class' => 'span2 integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> </th>
                            <th><?php echo $form->textField($model, 'totalpotongan', array('style' => 'text-align: right; ', 'class' => 'span2 integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<?php //echo $form->textFieldRow($model,'mengetahui',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100));  
?>
<div class="panel panel-success">
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <?php echo $form->textFieldRow($model, 'totalpajak', array('class' => 'span2 integer2', 'onblur' => 'setPenerimaanBersih();', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'potongan_lainlain', array('class' => 'span2 integer2', 'onblur' => 'setPenerimaanBersih();', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'pengurangan', array('class' => 'span2 integer2', 'onblur' => 'setPenerimaanBersih();', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'penambahan', array('class' => 'span2 integer2', 'onblur' => 'setPenerimaanBersih();', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group" id="thr_potong_pajak">
                    <?php echo CHtml::label('THR Sudah Dipotong Pajak', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'thr_potong_pajak', array('class' => 'span2 integer2', 'onblur' => 'setPenerimaanBersih();', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'penerimaanbersih', array('class' => 'span2 integer2', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($model, 'keterangan', array('placeholder' => 'Keterangan', 'rows' => 3, 'cols' => 20, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'mengetahui', array('class' => 'control-label', 'label' => 'Mengetahui (RS)')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'mengetahui_id', array('readonly' => true)) ?>
                        <?php
                        if (!empty($model->mengetahui_id)) {
                            echo $form->textField($model, 'mengetahui', array('readonly' => true));
                        } else {
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                //                                        'name'=>'namapegawai',
                                'attribute' => 'mengetahui',
                                'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 4,
                                    'focus' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($model, 'mengetahui') . '").val(ui.item.nama_pegawai);
                                            return false;
                                        }',
                                    'select' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($model, 'mengetahui') . '").val(ui.item.nama_pegawai);
                                                                                $("#' . CHtml::activeId($model, 'mengetahui_id') . '").val(ui.item.pegawai_id);
                                            return false;
                                        }',
                                ),
                                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 '),
                                'tombolDialog' => array('idDialog' => 'dialogPegawai2', 'idTombol' => 'tombolPasienDialog'),
                            ));
                        }
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'mengetahuipt', array('class' => 'control-label', 'label' => 'Mengetahui (PT)')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'mengetahuipt_id', array('readonly' => true)) ?>
                        <?php
                        if (!empty($model->mengetahuipt_id)) {
                            echo $form->textField($model, 'mengetahuipt', array('readonly' => true));
                        } else {

                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                //                                        'name'=>'namapegawai',
                                'attribute' => 'mengetahuipt',
                                'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 4,
                                    'focus' => 'js:function( event, ui ) {
                                        $("#' . CHtml::activeId($model, 'mengetahui') . '").val(ui.item.nama_pegawai);
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {
                                        $("#' . CHtml::activeId($model, 'mengetahui') . '").val(ui.item.nama_pegawai);
                                                                            $("#' . CHtml::activeId($model, 'mengetahui_id') . '").val(ui.item.pegawai_id);
                                        return false;
                                    }',
                                ),
                                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 '),
                                'tombolDialog' => array('idDialog' => 'dialogPegawai4', 'idTombol' => 'tombolMengetahuiPTDialog'),
                            ));
                        }
                        ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($model,'menyetujui',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); 
                ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'menyetujui', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'menyetujui_id', array('readonly' => true)) ?>
                        <?php
                        if (!empty($model->menyetujui_id)) {
                            echo $form->textField($model, 'menyetujui', array('readonly' => true));
                        } else {
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                //                                        'name'=>'namapegawai',
                                'attribute' => 'menyetujui',
                                'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat'),
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'minLength' => 4,
                                    'focus' => 'js:function( event, ui ) {
										$("#' . CHtml::activeId($model, 'menyetujui') . '").val(ui.item.nama_pegawai);
										return false;
									}',
                                    'select' => 'js:function( event, ui ) {
										$("#' . CHtml::activeId($model, 'menyetujui') . '").val(ui.item.nama_pegawai);
                                                                                $("#' . CHtml::activeId($model, 'menyetujui_id') . '").val(ui.item.pegawai_id);
										return false;
									}',
                                ),
                                'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 '),
                                'tombolDialog' => array('idDialog' => 'dialogPegawai3', 'idTombol' => 'tombolPasienDialog'),
                            ));
                        }
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($model, 'is_bayarbulanan', array('class' => 'control-label inline', 'label' => 'Apakah dibayar bulanan')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'is_bayarbulanan', array(0 => 'Tidak', 1 => 'Ya'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => false)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Jenis Bukti Potong</label>
                    <div class="controls">
                        <?php echo CHtml::textField('jenis_bukti_potong', '', array(
                            'readonly' => true,
                            'class' => 'span2',
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($model, 'tarif', array('class' => 'control-label inline')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model, 'tarif', array('class' => 'span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => false)); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Perhitungan PPh 21 <span id="tipe_pegawai"></span>
                        </div>
                    </div>
                    <div class="panel-body" id="form-pph21">
                        <?php
                        echo $this->renderPartial(
                            $this->path_view . '_perhitunganPph21',
                            array(
                                'form' => $form,
                                'model' => $model,
                            ),
                            true
                        );
                        ?>
                    </div>
                </div>
                <div class="panel panel-default" id="panel-pajakthr">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Perhitungan Pajak Atas THR
                        </div>
                    </div>
                    <div class="panel-body" id="form-pajakthr">
                        <?php
                        echo $this->renderPartial(
                            $this->path_view . '_perhitunganPajakThr',
                            array(
                                'form' => $form,
                                'model' => $model,
                            ),
                            true
                        );
                        ?>
                    </div>
                </div>
                <?php /*
					$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
						'id' => 'form-pajakthr',
						'content' => array(
							'content-pajakthr' => array(
								'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan Perhitungan Pajak Atas THR')) . '<b>Perhitungan Pajak Atas THR</b>',
								'isi' => $this->renderPartial($this->path_view. '_perhitunganPajakThr', array(
									'form' => $form,
									'model' => $model,
									), true
								),
								'active' => false,
							),
						),
					));
                                 *
                                 */
                ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
    if (isset($_GET['id'])) {
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => 'disabled'));
    } else {
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    }
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl($this->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl($this->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])) . '";}); return false;'
        )
    ); ?>
    <?php
    if (isset($_GET['id'])) {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Slip Gaji', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Formulir Pajak', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printFormulir(\'PRINT\')'));
    } else {
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Slip Gaji', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), array('class' => 'btn btn-info', 'disabled' => 'disabled'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Formulir Pajak', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), array('class' => 'btn btn-info', 'disabled' => 'disabled'));
    }
    ?>
    <?php
    $tips = array(
        '0' => 'waktutime',
        '1' => 'autocomplete-search',
        '2' => 'simpan',
        '3' => 'ulang',
        '4' => 'print',
        '5' => 'status_print',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'create', 'content' => $content));
    ?>
</div>
<?php
if (isset($_GET['id'])) {
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/Print&id=' . $model->penggajianpeg_id . '&pegawai_id=' . $modPegawai->pegawai_id);
    $urlPrintFormulir = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/formulir&penggajianpeg_id=' . $model->penggajianpeg_id);
?>
    <script type="text/javascript">
        function print(caraPrint) {
            window.open("<?php echo $urlPrint ?>" + $('#search').serialize() + "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
        }

        function printFormulir(caraPrint) {
            window.open("<?php echo $urlPrintFormulir ?>" + $('#search').serialize() + "&caraPrint=" + caraPrint, "", 'location=_new, width=900px');
        }
    </script>
<?php } ?>
<?php $this->endWidget(); ?>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>

<?php Yii::app()->clientScript->registerScript('onheadfunction', '
//    function setGaji(){
//        var totalGaji = 0;
//        $(".gaji").each(function(){
//            value =  unformatNumber($(this).val());
//            if (value > 0){
//                totalGaji += value;
//            }
//        });
//        $("#' . CHtml::activeId($model, 'totalterima') . '").val(formatNumber(totalGaji));
//
//    }
    function setPotongan(){
        var totalPotongan = 0;
        $(".potongan").each(function(){
        value = unformatNumber($(this).val());
            if (jQuery.isNumeric(value)){
                totalPotongan += value;
            }
        });
        $("#' . CHtml::activeId($model, 'totalpotongan') . '").val(formatNumber(totalPotongan));
    }
    function setHarga(){
        var pajak = unformatNumber($("#' . CHtml::activeId($model, 'totalpajak') . '").val());
        var gaji = unformatNumber($("#' . CHtml::activeId($model, 'totalterima') . '").val());
        var potongan_lainlain = unformatNumber($("#' . CHtml::activeId($model, 'potongan_lainlain') . '").val());
        var potongan = unformatNumber($("#' . CHtml::activeId($model, 'totalpotongan') . '").val()) + potongan_lainlain;
        var pengurangan = unformatNumber($("#' . CHtml::activeId($model, 'pengurangan') . '").val());
        value = (gaji - (potongan)) - pengurangan;

//        if (jQuery.isNumeric(value)){
//            $("#' . CHtml::activeId($model, 'penerimaanbersih') . '").val(formatNumber(value));
//        }
    }
', CClientScript::POS_HEAD); ?>

<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai4',
    'options' => array(
        'title' => 'Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new GJRegistrasifingerprint();
$modPegawai->jabatan_id = Params::JABATAN_ID_KASI_PERSONALIA;
if (isset($_GET['GJRegistrasifingerprint']))
    $modPegawai->attributes = $_GET['GJRegistrasifingerprint'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai5-m-grid',
    'dataProvider' => $modPegawai->search(),
    //    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#' . CHtml::activeId($model, 'mengetahuipt') . '\").val(\"$data->nama_pegawai\");
                                                      $(\"#' . CHtml::activeId($model, 'mengetahuipt_id') . '\").val(\"$data->pegawai_id\");
                                                      $(\"#dialogPegawai4\").dialog(\"close\");
                                                      return false;
                                            "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            //            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class'=>'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            //            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class'=>'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            //            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --'))
        ),
        //'tempatlahir_pegawai',
        //'tgl_lahirpegawai',
        //'jeniskelamin',
        //'statusperkawinan',
        //'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . ' $(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });'
        . '}',
));

$this->endWidget();
?>
<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai2',
    'options' => array(
        'title' => 'Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new GJRegistrasifingerprint();
$modPegawai->jabatan_id = Params::JABATAN_ID_DIREKTUR;
if (isset($_GET['GJRegistrasifingerprint']))
    $modPegawai->attributes = $_GET['GJRegistrasifingerprint'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai4-m-grid',
    'dataProvider' => $modPegawai->search(),
    //    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#' . CHtml::activeId($model, 'mengetahui') . '\").val(\"$data->nama_pegawai\");
                                                      $(\"#' . CHtml::activeId($model, 'mengetahui_id') . '\").val(\"$data->pegawai_id\");
                                                      $(\"#dialogPegawai2\").dialog(\"close\");
                                                      return false;
                                            "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            //            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class'=>'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            //            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class'=>'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            //            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --'))
        ),
        //'tempatlahir_pegawai',
        //'tgl_lahirpegawai',
        //'jeniskelamin',
        //'statusperkawinan',
        //'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . ' $(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });'
        . '}',
));

$this->endWidget();
?>
<?php
/**
 * Dialog untuk nama Pegawai
 */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai3',
    'options' => array(
        'title' => 'Pegawai Menyetujui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai = new GJRegistrasifingerprint();
$modPegawai->jabatan_id = Params::JABATAN_ID_DIREKTUR_RS;
if (isset($_GET['GJRegistrasifingerprint']))
    $modPegawai->attributes = $_GET['GJRegistrasifingerprint'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai5-m-grid',
    'dataProvider' => $modPegawai->search(),
    //    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                                        "id" => "selectPegawai",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#' . CHtml::activeId($model, 'menyetujui') . '\").val(\"$data->nama_pegawai\");
                                                      $(\"#' . CHtml::activeId($model, 'menyetujui_id') . '\").val(\"$data->pegawai_id\");
                                                      $(\"#dialogPegawai3\").dialog(\"close\");
                                                      return false;
                                            "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
            //            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class'=>'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
            //            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class'=>'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
            //            'filter' => Chtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --'))
        ),
        //'tempatlahir_pegawai',
        //'tgl_lahirpegawai',
        //'jeniskelamin',
        //'statusperkawinan',
        //'alamat_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . ' $(".numbers-only").keyup(function() {
        setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
        setHurufsOnly(this);
        });'
        . '}',
));

$this->endWidget();
?>
<script>
    var is_pegawai_tetap = 0;
    var is_pegawai_tetap_thr = 0;
    var bulan_pertama = 0;
    var bulan_selisih = 0;
    var bulan_lama_kerja = 0;

    function hitungHariKerjaUntukTunjanganTidakTetap() {
        var harikerja = $(".harikerja").val();

        $("#komponen_gaji tbody tr").each(function() {
            if ($(this).find(".unit").val() == "HARI") {
                $(this).find(".qty").val(harikerja);
            }
        });

        hitungGaji();
    }

    function hitungGaji() {
        var qty = 0;
        var satuan = 0;

        $("#komponen_gaji tbody tr").each(function() {
            qty = parseFloat(unformatNumber($(this).find(".qty").val()));
            satuan = parseFloat(unformatNumber($(this).find(".satuan").val()));

            if ($(this).attr('data-kode') == 'TT' || $(this).attr('data-kode') == 'TM') {
                if ($(this).find(".unit").val() == "BULAN") {
                    satuan = (satuan * parseInt($(".harihadir").val()));
                }
            }

            $(this).find(".subtotal").val(formatNumber(qty * satuan));

            var subtotalsebelum = parseFloat(unformatNumber($(this).find(".subtotal").val()));
            var penguranganKeterlambatan = parseFloat(unformatNumber($(this).find(".subtotalketerlambatan").val()));
            $(this).find(".subtotal").val(formatNumber(subtotalsebelum - penguranganKeterlambatan));
        });
        hitungBonusPegawai();
        // hitungTunjangan_BPJS_Naker();
        setTunjanganMakanTransport();
        // hitungKeterlambatan();
        hitungTunjangan();

        setGaji();
        setPotongan();
        setBruto();

        if (is_pegawai_tetap == 0) {
            hitungpphTidakTetap();
        } else {
            hitungpph();
        }
        /*
        setPtkpThr();
        setBulanPertamaGajiThr();
        */

        //       $("#komponen_gaji tbody tr").each(function() {
        //
        //        });
    }

    function hitungTunjangan() {
        var gapok = parseFloat(unformatNumber($("#PenggajiankompT_1_jumlah").val()));
        var tunjangan_tetap = 0;
        $(".tunjangan_tetap").each(function() {
            var v = parseFloat(unformatNumber($(this).val()));
            tunjangan_tetap += v;
        });

        var total_gapokjabatan = gapok + tunjangan_tetap;

        $(".row_komponen[data-kode='PTJP'] .qty").val(1);
        $(".row_komponen[data-kode='PTJHT'] .qty").val(1);
        $(".row_komponen[data-kode='PTBK'] .qty").val(1);
        $(".row_komponen[data-kode='TBKSHT'] .qty").val(1);
        $(".row_komponen[data-kode='TJHT'] .qty").val(1);
        $(".row_komponen[data-kode='TJP'] .qty").val(1);
        $(".row_komponen[data-kode='JKM'] .qty").val(1);
        $(".row_komponen[data-kode='JKK'] .qty").val(1);
        $(".row_komponen[data-kode='PJKK'] .qty").val(1);
        $(".row_komponen[data-kode='PJKM'] .qty").val(1);
        $(".row_komponen[data-kode='TBK'] .qty").val(1);

        $(".row_komponen[data-kode='PTJP'] .satuan, .row_komponen[data-kode='PTJP'] .subtotal").val(formatNumber(total_gapokjabatan * 0.0200));
        $(".row_komponen[data-kode='PTJHT'] .satuan, .row_komponen[data-kode='PTJHT'] .subtotal").val(formatNumber(total_gapokjabatan * 0.0370));
        $(".row_komponen[data-kode='PTBK'] .satuan, .row_komponen[data-kode='PTBK'] .subtotal").val(formatNumber(total_gapokjabatan * 0.0400));
        $(".row_komponen[data-kode='TBKSHT'] .satuan, .row_komponen[data-kode='TBKSHT'] .subtotal").val(formatNumber(total_gapokjabatan * 0.0400));
        $(".row_komponen[data-kode='TJHT'] .satuan, .row_komponen[data-kode='TJHT'] .subtotal").val(formatNumber(total_gapokjabatan * 0.0370));
        $(".row_komponen[data-kode='TJP'] .satuan, .row_komponen[data-kode='TJP'] .subtotal").val(formatNumber(total_gapokjabatan * 0.0200));
        $(".row_komponen[data-kode='JKM'] .satuan, .row_komponen[data-kode='JKM'] .subtotal").val(formatNumber(total_gapokjabatan * 0.0030));
        $(".row_komponen[data-kode='JKK'] .satuan, .row_komponen[data-kode='JKK'] .subtotal").val(formatNumber(total_gapokjabatan * 0.0024));
        $(".row_komponen[data-kode='PJKK'] .satuan, .row_komponen[data-kode='PJKK'] .subtotal").val(formatNumber(total_gapokjabatan * 0.0024));
        $(".row_komponen[data-kode='PJKM'] .satuan, .row_komponen[data-kode='PJKM'] .subtotal").val(formatNumber(total_gapokjabatan * 0.0030));
        $(".row_komponen[data-kode='TBK'] .satuan, .row_komponen[data-kode='TBK'] .subtotal").val(formatNumber(total_gapokjabatan * 0.0100));

        setGaji();
        setPotongan();
    }

    function hitungBonusPegawai() {
        var qty_bonus = $("#PenggajiankompT_103_qty").val();
        var fungsional = parseFloat(unformatNumber($("#PenggajiankompT_4_jumlah").val()));
        var jabatan = parseFloat(unformatNumber($("#PenggajiankompT_2_jumlah").val()));
        var gapok = parseFloat(unformatNumber($("#PenggajiankompT_1_jumlah").val()));

        if (qty_bonus != undefined) {
            var total = qty_bonus * (gapok + (fungsional + jabatan));
            $('#PenggajiankompT_103_satuan').val(formatNumber(total));
            $('#PenggajiankompT_103_jumlah').val(formatNumber(total));
        }

    }

    function setFokusBonus() {
        $('#PenggajiankompT_103_satuan').focus();
    }

    function hitungTunjanganPPH() {
        var jlmpph = parseFloat(unformatNumber($("#pphpersen21komponen").val()));
        var jlmpphtahun = parseFloat(unformatNumber($("#pphpersenkomponen").val()));
        //        $('#PenggajiankompT_96_satuan').val(formatNumber(jlmpph));
        //        $('#PenggajiankompT_96_jumlah').val(formatNumber(jlmpph));

        pphkomponentahun = (jlmpph * 12);
        pphtahun = pphkomponentahun - jlmpphtahun;
        nilaipphtahun = jlmpphtahun - pphtahun;
        //        $('#GJPenggajianpegT_pphpersen').val(formatNumber(nilaipphtahun));
        $('#GJPenggajianpegT_pphpersen').val(formatNumber(jlmpphtahun));
        //        $('#GJPenggajianpegT_pph21').val(formatNumber(nilaipphtahun/12));
        $('#GJPenggajianpegT_pph21').val(formatNumber(jlmpphtahun));

        <?php if (!empty($konfsy->ispajakgajipegawai) && $konfsy->ispajakgajipegawai) { ?>
            $('#GJPenggajianpegT_totalpajak').val(formatNumber(jlmpphtahun));
        <?php } else { ?>
            $('#GJPenggajianpegT_totalpajak').val(0);
        <?php } ?>
        $('#PenggajiankompT_96_satuan').val(formatNumber(jlmpphtahun));
        $('#PenggajiankompT_96_jumlah').val(formatNumber(jlmpphtahun));

        var thr_pph21 = parseFloat(unformatNumber($('#thr_pph21').val()));
        var pph21thr = (jlmpphtahun) - thr_pph21;
        $('#thr_pph21_atasthr').val(formatNumber(pph21thr));

    }

    function konfirmasi() {
        location.reload();
    }

    function setPenerimaanBersih() {
        var totalterima = parseFloat(unformatNumber($("#GJPenggajianpegT_totalterima").val()));
        var tunjanganPph = parseFloat(unformatNumber($("#PenggajiankompT_96_satuan").val()));
        var pengurangan = parseFloat(unformatNumber($("#GJPenggajianpegT_pengurangan").val()));
        var penambahan = parseFloat(unformatNumber($("#GJPenggajianpegT_penambahan").val()));
        var potLainlain = parseFloat(unformatNumber($("#GJPenggajianpegT_potongan_lainlain").val()));
        var potongan = parseFloat(unformatNumber($("#GJPenggajianpegT_totalpotongan").val()));
        var thr_didapat = parseFloat(unformatNumber($("#GJPenggajianpegT_thr_potong_pajak").val()));
        var total_pajak = parseFloat(unformatNumber($("#GJPenggajianpegT_totalpajak").val()));

        var penerimaan = (totalterima -
            tunjanganPph -
            pengurangan -
            potLainlain -
            potongan -
            total_pajak +
            penambahan
        ); // + thr_didapat;
        $("#GJPenggajianpegT_penerimaanbersih").val(formatNumber(penerimaan));
    }

    function setBruto() {
        var gapok = parseFloat(unformatNumber($(".row_komponen[data-kode='GP'] .subtotal").val()));
        // var jabatan = parseFloat(unformatNumber($("#PenggajiankompT_2_jumlah").val()));

        var tunjangan_tetap = 0;
        $(".tunjangan_tetap").each(function() {
            var v = parseFloat(unformatNumber($(this).val()));
            tunjangan_tetap += v;
        });

        var biaya_pensiun = (gapok + tunjangan_tetap) * 0.01;
        var hari_tua = (gapok + tunjangan_tetap) * 0.02;
        var total_pensiun_jht = 0;

        $(".row_komponen[data-kode='JHT'] .satuan, .row_komponen[data-kode='JHT'] .subtotal").val(0);
        $(".row_komponen[data-kode='JP'] .satuan, .row_komponen[data-kode='JP'] .subtotal").val(0);

        if ($(".row_komponen[data-kode='JHT'] .subtotal").length > 0) {
            total_pensiun_jht += hari_tua;
            $(".row_komponen[data-kode='JHT'] .satuan, .row_komponen[data-kode='JHT'] .subtotal").val(formatNumber(hari_tua));
        }
        if ($(".row_komponen[data-kode='JP'] .subtotal").length > 0) {
            total_pensiun_jht += biaya_pensiun;
            $(".row_komponen[data-kode='JP'] .satuan, .row_komponen[data-kode='JP'] .subtotal").val(formatNumber(biaya_pensiun));
        }

        if (total_pensiun_jht > 200000) {
            total_pensiun_jht = 200000;
        }

        var honor = parseFloat(unformatNumber($(".row_komponen[data-kode='HNR'] .subtotal").val()));

        var premi_haritua = parseFloat(unformatNumber($(".row_komponen[data-kode='JHT'] .subtotal").val()));
        var premi_kecelakaan = parseFloat(unformatNumber($(".row_komponen[data-kode='JKK'] .subtotal").val()));
        var premi_kematian = parseFloat(unformatNumber($(".row_komponen[data-kode='JKM'] .subtotal").val()));
        var premi_pensiun = parseFloat(unformatNumber($(".row_komponen[data-kode='JP'] .subtotal").val()));
        var premi_bpjs = parseFloat(unformatNumber($(".row_komponen[data-kode='TBK'] .subtotal").val()));
        // penambahan baru
        var premi_bpjs_ksht = parseFloat(unformatNumber($(".row_komponen[data-kode='TBKSHT'] .subtotal").val()));
        var premi_jht = parseFloat(unformatNumber($(".row_komponen[data-kode='TJHT'] .subtotal").val()));

        var premi_total = premi_haritua + premi_kecelakaan + premi_kematian + premi_pensiun + premi_bpjs + premi_bpjs_ksht + premi_jht;

        var penerimaan_tantiem = parseFloat(unformatNumber($(".row_komponen[data-kode='TNTM'] .subtotal").val()));
        var penerimaan_bonus = parseFloat(unformatNumber($(".row_komponen[data-kode='BNS'] .subtotal").val()));
        var penerimaan_thr = parseFloat(unformatNumber($(".row_komponen[data-kode='THR'] .subtotal").val()));
        var penerimaan_gtf = parseFloat(unformatNumber($(".row_komponen[data-kode='GTF'] .subtotal").val()));
        var penerimaan_jsp = parseFloat(unformatNumber($(".row_komponen[data-kode='JSP'] .subtotal").val()));

        var tunjangan_makan = parseFloat(unformatNumber($(".row_komponen[data-kode='TM'] .subtotal").val()));
        var tunjangan_transport = parseFloat(unformatNumber($(".row_komponen[data-kode='TT'] .subtotal").val()));

        var penerimaan_natura = tunjangan_makan + tunjangan_transport;
        var penerimaan_tantiem_bonus = penerimaan_tantiem + penerimaan_bonus + penerimaan_thr + penerimaan_gtf + penerimaan_jsp;

        var netto_sebelumnya = parseFloat(unformatNumber($("#GJPenggajianpegT_netto_masasebelumnya").val()));

        var total_bruto = gapok + tunjangan_tetap + premi_total + penerimaan_natura + penerimaan_tantiem_bonus;

        var biaya_jabatan = (is_pegawai_tetap == 0) ? 0 : (total_bruto * 0.05);
        biaya_jabatan = biaya_jabatan > 500000 ? 500000 : biaya_jabatan;


        // biaya_pensiun = biaya_pensiun > 200000 ? 200000 : total_pensiun_jht;

        var netto = total_bruto - (biaya_jabatan + total_pensiun_jht);
        var netto12 = (netto + netto_sebelumnya) * bulan_selisih;

        var ptkp = parseFloat(unformatNumber($("#GJPenggajianpegT_ptkp").val()));
        var pkp = ptkp > netto12 ? 0 : netto12 - ptkp;

        var pkp = Math.floor(pkp / 1000) * 1000;

        if (is_pegawai_tetap == 0) {
            $("#GJPenggajianpegT_biayajabatan").parents('.control-group').hide();
        } else {
            $("#GJPenggajianpegT_biayajabatan").parents('.control-group').show();

        }

        $("#GJPenggajianpegT_gajipokok").val(formatNumber(gapok));
        $("#GJPenggajianpegT_tunjangantetap").val(formatNumber(tunjangan_tetap));
        $("#GJPenggajianpegT_honorarium").val(formatNumber(honor));
        $("#GJPenggajianpegT_premiasuransi").val(formatNumber(premi_total));
        $("#tunjanganmakan").val(formatNumber(penerimaan_natura));
        $("#tunjangantransportasi").val(formatNumber(penerimaan_tantiem_bonus));
        $("#GJPenggajianpegT_gajipph").val(formatNumber(total_bruto));
        $("#GJPenggajianpegT_biayajabatan").val(formatNumber(biaya_jabatan));
        $("#GJPenggajianpegT_iuranpensiun").val(formatNumber(total_pensiun_jht));
        $("#GJPenggajianpegT_penerimaanpph").val(formatNumber(netto));
        $("#netto_tahun").val(formatNumber(netto12));
        $("#GJPenggajianpegT_pkp").val(formatNumber(pkp));

        setGaji();
        setPotongan();

        // hitung biaya jabatan/pensiun

    }

    function setGaji() {
        var totalGaji = 0;
        $(".gaji").each(function() {
            value = unformatNumber($(this).val());
            //value = value.replace(/(\d+),(?=\d{3}(\D|$))/g, "$1");
            if (value > 0) {
                totalGaji += parseInt(value);
            }
        });

        $("#<?php echo CHtml::activeId($model, 'totalterima') ?>").val(formatNumber(totalGaji));

        // setBruto();
        setPenerimaanBersih();
    }

    function hitungpphTidakTetap() {
        var hari_kerja = parseFloat($("#GJPenggajianpegT_harikerja").val());
        var bruto = parseFloat(unformatNumber($("#GJPenggajianpegT_gajipph").val()));
        var pkp = parseFloat(unformatNumber($("#GJPenggajianpegT_pkp").val()));
        var bruto_hari = hari_kerja == 0 ? 0 : bruto / hari_kerja;
        var pph = 0;

        if (bruto <= 4500000) {
            if (bruto_hari <= 450000) {
                pph = 0;
            } else {
                pph = (bruto - 450000) * 0.05;
            }
        } else {
            if (bruto > 10200000) {
                hitungpph();
                return false;
            } else {
                pph = pkp * 0.05;
            }
        }

        console.log("Hasil PPh", hari_kerja, bruto, bruto_hari, pkp, pph);

        $('#GJPenggajianpegT_pphpersen, #GJPenggajianpegT_pph21terutang, #GJPenggajianpegT_pph21telahdipotong').val(formatNumber(pph));
        $('#GJPenggajianpegT_pph21').val(formatNumber(pph / bulan_selisih));

        <?php if (!empty($konfsy->ispajakgajipegawai) && $konfsy->ispajakgajipegawai) { ?>
            $('#GJPenggajianpegT_totalpajak').val(formatNumber(pph / bulan_selisih));
        <?php } else { ?>
            $('#GJPenggajianpegT_totalpajak').val(0);
        <?php } ?>

        setPenerimaanBersih();
        if ($(".row_komponen[data-kode='THR'] .subtotal").length > 0) {
            setPerhitunganPajakTHR();
        }
        //setPtkpThr();
    }

    function hitungThrTidakTetap() {
        var gapok = parseFloat(unformatNumber($(".row_komponen[data-kode='GP'] .subtotal").val()));
        var tetap = parseFloat(unformatNumber($("#GJPenggajianpegT_tunjangantetap").val()));

        $(".row_komponen[data-kode='THR'] .satuan, .row_komponen[data-kode='THR'] .subtotal").val(formatNumber((bulan_lama_kerja * (gapok + tetap)) / 12));
    }

    function hitungpph() {
        var pkp = parseFloat(unformatNumber($("#GJPenggajianpegT_pkp").val()));

        $.post('<?php echo $this->createUrl('AmbilPph'); ?>', {
            pkp: pkp
        }, function(data) {
            // $('#PenggajiankompT_komponengaji_id_10').val(data.jmltunjangan);
            // $('#harikerja').val(data.jmlhadir);
            // setTunjanganHarian();
            // var persen = data.percent / 100;
            var persenpertahun = data.nilai;
            var persenperbulan = persenpertahun / bulan_selisih;
            var pembulatan = Math.round(persenperbulan * Math.pow(10, 0)) / Math.pow(10, 0);
            $('#GJPenggajianpegT_pphpersen, #GJPenggajianpegT_pph21terutang, #GJPenggajianpegT_pph21telahdipotong').val(formatNumber(persenpertahun));
            $('#GJPenggajianpegT_pph21').val(formatNumber(persenperbulan));

            <?php if (!empty($konfsy->ispajakgajipegawai) && $konfsy->ispajakgajipegawai) { ?>
                $('#GJPenggajianpegT_totalpajak').val(formatNumber(persenperbulan));
            <?php } else { ?>
                $('#GJPenggajianpegT_totalpajak').val(0);
            <?php } ?>

            setPenerimaanBersih();
            if ($(".row_komponen[data-kode='THR'] .subtotal").length > 0) {
                setPerhitunganPajakTHR();
            }
            //setPtkpThr();
        }, 'json');

        //        setPotongan();

    }

    function hitungThrTetap() {
        var gapok = parseFloat(unformatNumber($(".row_komponen[data-kode='GP'] .subtotal").val()));
        var tetap = parseFloat(unformatNumber($("#GJPenggajianpegT_tunjangantetap").val()));

        $(".row_komponen[data-kode='THR'] .satuan, .row_komponen[data-kode='THR'] .subtotal").val(formatNumber(gapok + tetap));
    }

    /*
    function hitungKeterlambatan(){
        var var_pegawai_id = $("#pegawai_id").val();
        var periodegaji = $("#GJPenggajianpegT_periodegaji").val();
        var hrg_satuan = parseFloat(unformatNumber($('#PenggajiankompT_74_satuan').val()));
        var jmlPotongan = 0;
        var potongan15 = 0;
        var potongan60 = 0;
        var jumlahawal = parseFloat(unformatNumber($('#PenggajiankompT_74_jumlah').val()));
        $.post('<?php echo $this->createUrl('HitungKeterlambatan'); ?>', {pegawai_id: var_pegawai_id, periodegaji: periodegaji}, function (data) {

            if(data.lama15 != 0){
                potongan15 = data.lama15 * (0.5 * hrg_satuan);
            }

            if(data.lama60 != 0){
                potongan60 = data.lama60 * hrg_satuan;
            }

            jmlPotongan = jumlahawal - (potongan15 + potongan60);

            $('#PenggajiankompT_74_jumlah').val(formatNumber(jmlPotongan));
//            setGaji();

        }, 'json');

    }
    */

    function hitungTunjangan_BPJS_Naker() {
        var bpjs_kerja_JHT = parseFloat(unformatNumber($("#PenggajiankompT_100_satuan").val()));
        var bpjs_kerja_JKK = parseFloat(unformatNumber($("#PenggajiankompT_97_satuan").val()));
        var bpjs_kerja_JK = parseFloat(unformatNumber($("#PenggajiankompT_98_satuan").val()));
        var bpjs_kerja_JP = parseFloat(unformatNumber($("#PenggajiankompT_99_satuan").val()));
        var total = bpjs_kerja_JHT + bpjs_kerja_JKK + bpjs_kerja_JK + bpjs_kerja_JP;
        $("#PenggajiankompT_94_satuan").val(formatNumber(total));
    }


    function setPinjamanKoperasi(pegawai_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetPinjamanKoperasi'); ?>',
            data: {
                pegawai_id: pegawai_id
            },
            dataType: "json",
            success: function(data) {
                if (data.status = "ada") {
                    $('#PenggajiankompT_komponengaji_id_25').val(data.jmlcicilan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setKomponenGaji(pegawai_id) {

        var var_pegawai_id = $("#pegawai_id").val();
        var var_periode = $(".periode_gaji").val();
        var tglgaji_awal = $("#tglgaji_awal").val();
        var tglgaji_akhir = $("#tglgaji_akhir").val();
        if (var_pegawai_id.trim() == "") return false;

        var nama = $("#GJPegawaiM_nama_pegawai").val();

        $("#GJPenggajianpegT_keterangan").val("PENGAJUAN GAJI PEGAWAI PERIODE " + (var_periode.toUpperCase())); //(nama.toUpperCase()) + " - " + (var_periode.toUpperCase())

        console.log(var_pegawai_id, var_periode);

        $('#komponen_gaji').find("tbody").empty();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetKomponenGaji'); ?>',
            data: {
                pegawai_id: var_pegawai_id,
                periode: var_periode
            },
            dataType: "json",
            success: function(data) {
                clearInputan();
                if (data.sukses == 1) {

                    if (data.sudah_ada == 1) {
                        myAlert(data.sudah_ada_msg);
                        return false;
                    }

                    // set pegawai tetap
                    is_pegawai_tetap = data.is_tetap;
                    is_pegawai_tetap_thr = data.is_tetap_thr;
                    bulan_pertama = data.bulan_pertama;
                    bulan_selisih = (bulan_pertama != 0) ? (12 - bulan_pertama + 1) : 12;
                    bulan_lama_kerja = data.bulan_lama_kerja > 12 ? 12 : data.bulan_lama_kerja;
                    $("#blnpertamagaji").val(data.bulan_pertama);

                    $("#tipe_pegawai").text(is_pegawai_tetap == 1 ? '(Pegawai Tetap dan Kontrak)' : '(Pegawai Tidak Tetap)');

                    var tr = $('#komponen_gaji').find("tbody > tr");

                    $('#komponen_gaji').find("tbody").html(data.row);

                    $("#komponen_gaji .integer2").maskMoney({
                        "symbol": "",
                        "defaultZero": true,
                        "allowZero": true,
                        "decimal": ",",
                        "thousands": ".",
                        "precision": 0
                    });

                    $(".harikerja").val(data.harikerja);
                    $(".harialpa").val(data.alpa);
                    $(".harihadir").val(data.hadir);
                    $(".totalcuti").val(data.cuti);
                    $(".totalizin").val(data.izin);
                    $(".totalsakit").val(data.sakit);
                    $("#GJPenggajianpegT_ptkp").val(formatNumber(data.ptkp));

                    cekInputTHR();

                    hitungHariKerjaUntukTunjanganTidakTetap();

                    /*
					setGaji();
                    setPotongan();
					// setPinjamanKoperasi(var_pegawai_id);
					// setPtkp(var_pegawai_id);

					//hitungHariKerjaUntukTunjanganTidakTetap();
                    */

                } else {
                    myAlert(data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function cekInputTHR() {
        if ($(".row_komponen[data-kode='THR'] .subtotal").length == 0) {
            $("#form-pajakthr :input").prop('disabled', true);
            $("#panel-pajakthr").hide();
        } else {
            $("#form-pajakthr :input").prop('disabled', false);
            $("#panel-pajakthr").show();
        }
    }

    function setTunjanganMakanTransport() {
        var kom_tunjanganmakan = $('#PenggajiankompT_5_jumlah').val();
        var kom_tunjangantransport = $('#PenggajiankompT_74_jumlah').val();
        if (typeof kom_tunjanganmakan != "undefined") {
            $('#tunjanganmakan').val(kom_tunjanganmakan);
        }
        if (typeof kom_tunjanganmakan != "undefined") {
            $('#tunjangantransportasi').val(kom_tunjangantransport);
        }
    }

    function getTanggalPeriode() {
        var var_periode = $(".periode_gaji").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetTanggalPeriode'); ?>',
            data: {
                periode: var_periode
            },
            dataType: "json",
            success: function(data) {

                $('#tglgaji_awal').val(data.tgl_awal);
                $('#tglgaji_akhir').val(data.tgl_akhir);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setPtkpThr() {
        var pegawai_id = $('#pegawai_id').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetPtkpNew'); ?>',
            data: {
                pegawai_id: pegawai_id
            },
            dataType: "json",
            success: function(data) {
                if (data.status = "ada") {
                    $('#thr_ptkp').val(formatNumber(data.ptkp));
                    if (bulan_pertama > 0) {
                        setPerhitunganPajakTHR();
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setBulanPertamaGajiThr() {
        var pegawai_id = $('#pegawai_id').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetPertamaGaji'); ?>',
            data: {
                pegawai_id: pegawai_id
            },
            dataType: "json",
            success: function(data) {
                if (data.bulan > 0) {
                    $('#blnpertamagaji').val(data.bulan);
                    setPerhitunganPajakTHR();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setPerhitunganPajakTHR() {

        //    if (is_pegawai_tetap_thr == 1) {
        //        hitungThrTetap();
        //    } else {
        //        hitungThrTidakTetap();
        //    }


        var gaji_pokok = parseFloat(unformatNumber($("#GJPenggajianpegT_gajipokok").val()));
        var tunj_fungsional = parseFloat(unformatNumber($("#GJPenggajianpegT_tunjangantetap").val()));
        var tunj_jabatan = parseFloat(unformatNumber($("#PenggajiankompT_2_jumlah").val()));
        var thr = parseFloat(unformatNumber($(".row_komponen[data-kode='THR'] .subtotal").val()));

        //    var bruto = ((gaji_pokok+tunj_fungsional+tunj_jabatan)*12) + thr;
        //     var bruto = (gaji_pokok+tunj_fungsional+tunj_jabatan) + thr;
        var bruto = (gaji_pokok + tunj_fungsional) * bulan_selisih;
        var total_gaji_thr = bruto + thr;
        var biaya_jabatan = total_gaji_thr * 0.05;

        if (biaya_jabatan > 6000000) {
            biaya_jabatan = 6000000;
        }

        var total_netto = total_gaji_thr - biaya_jabatan;
        var ptkp = parseFloat(unformatNumber($("#GJPenggajianpegT_ptkp").val()));
        var pkp = total_netto - ptkp;

        if (pkp < 0) {
            pkp = 0;
        }

        $("#thr_gajipokok").val(formatNumber(gaji_pokok));
        $("#thr_tunj_fungsional").val(formatNumber(tunj_fungsional));
        // $("#thr_tunj_jabatan").val(formatNumber(tunj_jabatan));
        $("#thr_bruto").val(formatNumber(bruto));
        $("#thr_thr").val(formatNumber(thr));
        $("#thr_total_gaji_thr").val(formatNumber(total_gaji_thr));
        $("#thr_biaya_jabatan").val(formatNumber(biaya_jabatan));
        $("#thr_neto").val(formatNumber(total_netto));

        $("#thr_ptkp").val(formatNumber(ptkp));
        $("#thr_pkp").val(formatNumber(pkp));


        $.post('<?php echo $this->createUrl('AmbilPph'); ?>', {
            pkp: pkp
        }, function(data) {

            var persenpertahun = data.nilai;
            var persenperbulan = persenpertahun / bulan_selisih;
            var pph21gajipertahun = parseFloat(unformatNumber($("#GJPenggajianpegT_pphpersen").val()));

            var pph21thrpertahun = persenpertahun - pph21gajipertahun;

            if (pph21thrpertahun < 0) pph21thrpertahun = 0;

            $("#thr_pph21").val(formatNumber(persenpertahun));
            $("#thr_pph21_atasgaji").val(formatNumber(pph21gajipertahun));
            $("#thr_pph21_atasthr").val(formatNumber(pph21thrpertahun));
            $("#thr_pph21_ygdidapat").val(formatNumber(thr - pph21thrpertahun));
            $("#GJPenggajianpegT_thr_potong_pajak").val(formatNumber(thr - pph21thrpertahun));
            // $("#GJPenggajianpegT_totalpajak").val(formatNumber(pph21thrpertahun + pph21gajipertahun));

            /*
            var persen = data.percent / 100;
            var persenpertahun = persen * pkp;
            var persenperbulan = persenpertahun / bulan_selisih;
//            var pembulatan = Math.round(persenperbulan * Math.pow(10, 0)) / Math.pow(10, 0);
            $('#pphpersenkomponenTHR').val(formatNumber(persenpertahun));
            $('#pphpersen21komponenTHR').val(formatNumber(persenperbulan));

//            pphkomponentahun = (persenperbulan*12);
//            pphtahun = pphkomponentahun - persenpertahun;
//            nilaipphtahun = persenpertahun - pphtahun;
            $('#thr_pph21').val(formatNumber(persenpertahun));

            var pph21tahun = parseFloat(unformatNumber($('#GJPenggajianpegT_pph21').val()));
            var pph21thr = pph21tahun - persenpertahun;
            $('#thr_pph21_atasthr').val(formatNumber(pph21thr));
            if(pph21thr < 0){
                pph21thr = persenpertahun - pph21tahun;
            }
            $('#thr_pph21_ygdidapat').val(formatNumber(thr - pph21thr));

            //RSPMC-1356
            var kom_thr = $('#PenggajiankompT_101_jumlah').val();
            if (typeof kom_thr != "undefined"){
                $('#content-pajakthr').removeClass('hidden');
                $('#thr_potong_pajak').removeClass('hidden');
                $('#GJPenggajianpegT_thr_potong_pajak').val(formatNumber(thr - pph21thr));
            }
            else{
                $('#content-pajakthr').addClass('hidden');
                $('#thr_potong_pajak').addClass('hidden');
                $('#GJPenggajianpegT_thr_potong_pajak').val(formatNumber(0));
            }
            */

            setPenerimaanBersih();
        }, 'json');

    }

    function clearInputan() {
        $('#GJPenggajianpegT_gajipokok').val(0);
        $('#GJPenggajianpegT_tunjangantetap').val(0);
        $('#GJPenggajianpegT_premiasuransi').val(0);
        $('#tunjanganmakan').val(0);
        $('#tunjangantransportasi').val(0);
        $('#GJPenggajianpegT_gajipph').val(0);
        $('#GJPenggajianpegT_persentasepph21').val(0);
        $('#GJPenggajianpegT_biayajabatan').val(0);
        $('#GJPenggajianpegT_iuranpensiun').val(0);
        $('#GJPenggajianpegT_jaminanpensiun').val(0);
        $('#GJPenggajianpegT_bpjskesehatan').val(0);
        $('#GJPenggajianpegT_penerimaanpph').val(0);
        $('#GJPenggajianpegT_ptkp').val(0);
        $('#GJPenggajianpegT_pkp').val(0);
        $('#pphpersenkomponen').val(0);
        $('#pphpersen21komponen').val(0);
        $('#GJPenggajianpegT_pphpersen').val(0);
        $('#GJPenggajianpegT_pph21').val(0);
        $('#GJPenggajianpegT_totalpajak').val(0);
        $('#GJPenggajianpegT_potongan_lainlain').val(0);
        $('#GJPenggajianpegT_pengurangan').val(0);
        $('#GJPenggajianpegT_thr_potong_pajak').val(0);
        $('#GJPenggajianpegT_penerimaanbersih').val(0);
        $('#GJPenggajianpegT_totalterima').val(0);
        $('#GJPenggajianpegT_totalpotongan').val(0);

        $('#PenggajiankompT_96_satuan').val(0);
    }

    $(document).ready(function() {
        getTanggalPeriode();
        cekInputTHR();
    });
</script>