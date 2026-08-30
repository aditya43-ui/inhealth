<?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly' => true, 'class' => 'span3')); ?>
<div class="col-sm-6">
    <?php
    if (Yii::app()->user->getState('tgltransaksimundur')) {
    ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'tgl_pendaftaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->tgl_pendaftaran = (!empty($model->tgl_pendaftaran) ? date("d/m/Y H:i:s", strtotime($model->tgl_pendaftaran)) : date("d/m/Y H:i:s"));
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_pendaftaran',
                    'mode' => 'datetime',
                    'options' => array(
                        'showOn' => false,
                        //'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('class' => 'dtPicker3 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
            </div>
        </div>
    <?php
    } else {
        echo $form->textFieldRow($model, 'tgl_pendaftaran', array('readonly' => true, 'class' => 'span3 realtime', 'onkeyup' => "return $(this).focusNextInputField(event);"));
    }
    ?>
    <div class='control-group'>
        <?php echo CHtml::label("Poliklinik <span class='required'>*</span>", CHtml::activeId($model, 'ruangan_id'), array('class' => 'control-label required')) ?>
        <div class='controls'>
            <?php echo $form->dropDownList(
                $model,
                'ruangan_id',
                CHtml::listData($model->getRuanganMcuItems(Params::INSTALASI_ID_RJ), 'ruangan_id', 'ruangan_nama'),
                array(
                    'empty' => '-- Pilih --',
                    'onchange' => "setDropdownDokter(this.value);setDropdownJeniskasuspenyakit(this.value);setKarcis();setAntrianRuangan()",
                    'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('SetDropdownKelasPelayanan', array('encode' => false, 'namaModel' => get_class($model))),
                        'update' => '#' . CHtml::activeId($model, 'kelaspelayanan_id')
                    ),
                )
            ); ?>
            <div class="checkbox inline">
                <i class="icon-home" style="margin:0" rel="tooltip" title="Ceklis jika Kunjungan Rumah"></i>
                <?php echo $form->checkBox($model, 'kunjunganrumah', array('onkeyup' => "return $(this).focusNextInputField(event)")); ?>
                <?php // echo CHtml::activeLabel($model, 'kunjunganrumah'); 
                ?>
            </div><?php echo CHtml::textField('max-antrian-ruangan', 0, array('rel' => 'tooltip', 'title' => 'Maksimum Antrian Ruangan', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:25px;',)); ?>
        </div>
    </div>
    <?php echo $form->dropDownListRow($model, 'jeniskasuspenyakit_id', CHtml::listData($model->getJenisKasusPenyakitItems($model->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
    <?php echo $form->dropDownListRow($model, 'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "setKarcis()", 'class' => 'span3')); ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'pegawai_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'pegawai_id', CHtml::listData($model->getDokterItems($model->ruangan_id), 'pegawai_id', 'nama_pegawai'), array('onchange' => 'setAntrianDokter();', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
            <?php echo CHtml::textField('max-antrian-dokter', 0, array('rel' => 'tooltip', 'title' => 'Maksimum Antrian Dokter', 'readonly' => true, 'onkeyup' => "return $(this).focusNextInputField(event)", 'style' => 'width:25px;', 'value' => 0)); ?>
        </div>
    </div>

    <?php echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
        'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
        'ajax' => array(
            'type' => 'POST',
            'url' => $this->createUrl('SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
            //                                                        'update'=>'#'.CHtml::activeId($model, 'penjamin_id'),  //DIHIDE KARENA DIGANTIKAN DENGAN 'success'
            'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data); setKarcis();}',
        ),
        'onchange' => 'setFormAsuransi(this.value); ',
        'class' => 'span3',
    )); ?>
    <?php echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onchange' => 'setKarcis(); ', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
        'id' => 'form-asuransi',
        'content' => array(
            'content-asuransi' => array(
                'header' => '<b>Asuransi Baru</span></b>',
                'isi' => $this->renderPartial($this->path_view_mcu . '_formAsuransi', array(
                    'form' => $form,
                    'model' => $model,
                    'modPasien' => $modPasien,
                    'modAsuransiPasien' => $modAsuransiPasien,
                ), true),
                'active' => false,
            ),
        ),
        'htmlOptions' => array('style' => (($model->is_bpjs) ? 'display:none' : '')),
    )); ?>
    <?php echo $form->hiddenField($model, 'is_bpjs', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
        'id' => 'form-bpjs',
        'content' => array(
            'content-bpjs' => array(
                'header' => '<b>BPJS</b>',
                'isi' => $this->renderPartial($this->path_view_mcu . '_formAsuransiBpjs', array(
                    'form' => $form,
                    'model' => $model,
                    'modPasien' => $modPasien,
                    'modRujukanBpjs' => $modRujukanBpjs,
                    'modAsuransiPasien' => $modAsuransiPasienBpjs,
                    'modSep' => $modSep,
                ), true),
                'active' => $model->is_bpjs,
            ),
        ),
        'htmlOptions' => array('style' => (($model->is_bpjs) ? '' : 'display:none')),
    )); ?>
</div>
<div class="col-sm-6">
    <?php echo $form->hiddenField($modRujukanKeluar, 'is_pasienrujukankeluar', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
        'id' => 'form-rujukan-keluar',
        'content' => array(
            'content-rujukan-keluar' => array(
                'header' => '<b>Rujukan Ke Luar</b>',
                'isi' => $this->renderPartial($this->path_view . '_formRujukan', array(
                    'form' => $form,
                    'model' => $model,
                    'modRujukanKeluar' => $modRujukanKeluar,
                ), true),
                'active' => $modRujukanKeluar->is_pasienrujukankeluar,
            ),
        ),
    )); ?>
</div>