<?php
$realtime = !isset($_GET['sukses']) ? 'realtime' : '';
?>

<?php echo $form->hiddenField($model, 'pendaftaran_id', array('readonly' => true, 'class' => 'span3')); ?>
<?php echo $form->hiddenField($model, 'jadwalhemodialisa_id', array('readonly' => true, 'class' => 'span3')); ?>

<?php // echo $form->textFieldRow($model,'tgl_pendaftaran',array('readonly'=>true,'class'=>'span3 realtime', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
?>
<?php
if (Yii::app()->user->getState('tgltransaksimundur')) {
?>
    <div class="control-group">
        <?php echo CHtml::Label('Tgl. Pendaftaran <span class="required">*</span> ', 'tgl_pendaftaran', array('rel' => 'tooltip', 'title' => 'Klik untuk set Realtime', 'class' => 'control-label', 'onclick' => '$("#PPPendaftaranT_tgl_pendaftaran").addClass("realtime");', 'style' => ' cursor: pointer;')) ?>
        <div class="controls">
            <?php
            $model->tgl_pendaftaran = (!empty($model->tgl_pendaftaran) ? date("d/m/Y H:i:s", strtotime($model->tgl_pendaftaran)) : date("d/m/Y H:i:s"));
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tgl_pendaftaran',
                'mode' => 'datetime',
                'options' => array(
                    'showOn' => false,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('class' => 'span3 dtPicker3 ' . $realtime, 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => '$(this).removeClass("realtime")'),
            ));
            ?>
        </div>
    </div>
<?php
} else {
    echo $form->textFieldRow($model, 'tgl_pendaftaran', array('readonly' => true, 'class' => 'span3 realtime', 'onkeyup' => "return $(this).focusNextInputField(event);"));
}
?>
<div class="control-group">
    <?php echo CHtml::label('Shift <span class="required">*</span>', 'shift_id', array('class' => 'control-label required')) ?> 
    <div class='controls'>
        <?php
        echo $form->dropDownList($model, 'shift_id', CHtml::listData(ShiftHdM::model()->findAllByAttributes(array('shift_hd_aktif' => true)), 'shift_hd_id', 'shift_hd_nama'), array('empty' => '-- Pilih --',
            'onkeypress' => "return $(this).focusNextInputField(event)",
            'class' => 'span3 required',
        ));
        ?>
    </div>
</div> 
<div class='control-group'>
    <?php echo CHtml::label("Ruangan <span class='required'>*</span>", CHtml::activeId($model, 'ruangan_id'), array('class' => 'control-label required')) ?>
    <div class='controls'>
        <?php // echo $form->dropDownList($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAll('instalasi_id in ('.Params::INSTALASI_ID_HD.','.Params::INSTALASI_ID_HD_GA.') AND ruangan_aktif IS TRUE'), 'ruangan_id', 'ruangan_nama') ,
        echo $form->dropDownList(
            $model,
            'ruangan_id',
            CHtml::listData($model->getRuanganHD(), 'ruangan_id', 'ruangan_nama'),
            array(
                'empty' => '-- Pilih --',
                'onchange' => "setDropdownDokter(this.value);setDropdownJeniskasuspenyakit(this.value);setDropDownKelasPelayanan(this.value);setKarcis();setAntrianRuangan()",
                'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('SetDropdownKamarKosong', array('encode' => false, 'namaModel' => get_class($model))),
                    'update' => '#' . CHtml::activeId($model, 'kamarruangan_id')
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
<?php echo $form->dropDownListRow($model, 'kelaspelayanan_id', CHtml::listData($model->getKelasPelayananItems($model->ruangan_id), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => "setKarcis();updateKamarRuangan(this.value, true)", 'class' => 'span3')); ?>
<!-- <div class="control-group">
    <?php // echo CHtml::label("Lantai <span class='required'>*</span>", 'lantai_hd', array('class' => 'control-label')) ?> 
    <div class='controls'>
        <?php
     //   echo $form->dropDownList($model, 'lantai_hd', CHtml::listData(LookupM::model()->findAll("lookup_type = 'lantai_ruangan_hd' AND lookup_aktif IS TRUE"), 'lookup_name', 'lookup_name'), array('empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'onchange' => "updateKamarByKelasLantai(true)", 
     //   ));
        ?>
    </div>
</div>-->
<div class="control-group">
    <?php  echo CHtml::label('Bed <span class="required">*</span>', 'kamarruangan_id', array('class' => 'control-label')) ?> 
    <div class='controls'>
        <?php
        echo $form->dropDownList($model, 'kamarruangan_id', !empty($model->ruangan_id) ? CHtml::listData(KamarruanganM::model()->findAllByAttributes(array('ruangan_id' => $model->ruangan_id, 'kamarruangan_status' => true)), 'kamarruangan_id', 'KamarDanTempatTidur') : array(), array('empty' => '-- Pilih --',
            'onkeypress' => "return $(this).focusNextInputField(event)",
            'class' => 'span3 required',
        ));
         ?>
    </div>
</div> 
<!-- <div class="control-group">
    <?php // echo CHtml::label('Jenis Tindakan <span class="required">*</span>', 'jenis_tindakan', array('class' => 'control-label')) ?>
    <div class='controls'>
        <?php // echo $form->dropDownList($model, 'jeniskasuspenyakit_id', CHtml::listData($model->getJenisKasusPenyakitItems($model->ruangan_id), 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'), array('onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required')); ?>
    </div>
</div> -->

<div class="control-group">
    <label for="PPPendaftaranT_pegawai_id" class="control-label required">
        DPJP <span class="required">*</span>
        <?php echo
        CHtml::link(
            "<i class='icon-dokpoli'></i>",
            'javascript:void(0)',
            array(
                "rel" => "tooltip",
                "title" => "Klik untuk Melihat Jadwal Dokter",
                "onclick" => "setRuanganJadwalDokter(); $('#jadwalDokter').dialog('open');return true;"
            )
        );
        ?>
  </label>
    <div class="controls">
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'model' => $model,
            'attribute' => 'nama_pegawai',
            'source' => 'js: function(request, response) {
									var ruangan_id = $("#' . CHtml::activeId($model, 'ruangan_id') . '").val();
								   $.ajax({
									   url: "' . $this->createUrl('AutocompleteDokter') . '",
									   dataType: "json",
									   data: {
										   nama_pegawai: request.term,
										   ruangan_id: ruangan_id,
									   },
									   success: function (data) {
											   response(data);
									   }
								   })
								}',
            'options' => array(
                'minLength' => 2,
                'focus' => 'js:function( event, ui ) {
								 $(this).val( "");
								 return false;
							 }',
                'select' => 'js:function( event, ui ) {
								$(this).val(ui.item.value);
								$("#' . CHtml::activeId($model, 'pegawai_id') . '").val(ui.item.pegawai_id);
								$("#' . CHtml::activeId($model, 'nama_pegawai') . '").val(ui.item.nama_pegawai);
								setAntrianDokter();
								return false;
							}',
            ),
            'tombolDialog' => array('idDialog' => 'dialogDokter', 'jsFunction' => 'cekDokter()'),
            'htmlOptions' => array(
                'class' => 'span3', 'placeholder' => 'Nama Dokter', 'rel' => 'tooltip', 'title' => 'Ketik Nama Dokter',
                'onkeyup' => "return $(this).focusNextInputField(event)",
                'onblur' => "",
            ),
        ));
        ?>
        <?php echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
        <?php // echo $form->dropDownList($model,'pegawai_id', CHtml::listData($model->getDokterItems($model->ruangan_id), 'pegawai_id', 'nama_pegawai') ,array('onchange'=>'setAntrianDokter();','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); --RND-6869 
        ?>
        <?php // echo CHtml::textField('max-antrian-dokter',0, array('rel'=>'tooltip','title'=>'Maksimum Antrian Dokter','readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:25px;','value'=>0)); 
        ?>
    </div>
    <!--<div class="checkbox inline">
                <?php // echo $form->checkBox($model,'kirim_sms_dokter', array('onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik jika ingin kirim SMS Notif pendaftaran ke Dokter')); 
                ?>
        </div>-->
</div>
<div class="control-group">
    <label for="PPPendaftaranT_ppjp_id" class="control-label">
        PPJP
  </label>
    <div class="controls">
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'model' => $model,
            'attribute' => 'nama_ppjp',
            'source' => 'js: function(request, response) {
                                                        var ruangan_id = $("#' . CHtml::activeId($model, 'ruangan_id') . '").val();
                                                   $.ajax({
                                                           url: "' . $this->createUrl('AutocompletePPJP') . '",
                                                           dataType: "json",
                                                           data: {
                                                                   nama_pegawai: request.term,
                                                                   ruangan_id: ruangan_id,
                                                           },
                                                           success: function (data) {
                                                                           response(data);
                                                           }
                                                   })
                                                }',
            'options' => array(
                'minLength' => 3,
                'focus' => 'js:function( event, ui ) {
                                                 $(this).val( "");
                                                 return false;
                                         }',
                'select' => 'js:function( event, ui ) {
                                                $(this).val(ui.item.value);
                                                $("#' . CHtml::activeId($model, 'ppjp_id') . '").val(ui.item.pegawai_id);
                                                $("#' . CHtml::activeId($model, 'nama_ppjp') . '").val(ui.item.nama_pegawai);
                                                setAntrianDokter();
                                                return false;
                                        }',
            ),
            'tombolDialog' => array('idDialog' => 'dialogPpjp', 'jsFunction' => 'cekPpjp()'),
            'htmlOptions' => array(
                'class' => 'span3', 'placeholder' => 'Nama PPJP', 'rel' => 'tooltip', 'title' => 'Ketik Nama PPJP',
                'onkeyup' => "return $(this).focusNextInputField(event)",
                'onblur' => "",
            ),
        ));
        ?>
        <?php echo $form->hiddenField($model, 'ppjp_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
    </div>
</div>
<div class="control-group carabayar">
    <?php echo $form->labelEx($model, 'carabayar_id', array('class' => 'control-label ')) ?>
    <div class="controls">
        <?php echo $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
            'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('pendaftaranRawatJalan/SetDropdownPenjaminPasien', array('encode' => false, 'namaModel' => get_class($model))),
                //                                                        'update'=>'#'.CHtml::activeId($model, 'penjamin_id'),  //DIHIDE KARENA DIGANTIKAN DENGAN 'success'
                'success' => 'function(data){$("#' . CHtml::activeId($model, "penjamin_id") . '").html(data);setKarcis();}',
            ),
            'onchange' => 'setFormAsuransi(this.value);',
            'class' => 'span3',
        )); ?>
    </div>
    <div class="controls cekBPJS hidden">
        <?php echo $form->checkBox($model,'is_bpjs_manual', array('onchange'=>'bpjsManual(this)', 'uncheckedvalue' => 0)); ?>
    </div>
</div>

<?php echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onchange' => 'setKarcis();setFormAsuransiInhealth(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span3')); ?>
<div class="control-group ">
    <?php echo CHtml::Label('Rencana Selanjutnya', 'jadwalhemodialisa_tgl_ke', array('rel' => 'tooltip', 'title' => 'Klik untuk set Realtime', 'class' => 'control-label', 'style' => ' cursor: pointer;')) ?>
    <div class="controls">
        <?php
        $modJadwalHD->jadwalhemodialisa_tgl_ke = (!empty($modJadwalHD->jadwalhemodialisa_tgl_ke) ? date("d/m/Y", strtotime($modJadwalHD->jadwalhemodialisa_tgl_ke)) : date("d/m/Y"));
        $this->widget('MyDateTimePicker', array(
            'model' => $modJadwalHD,
            'attribute' => 'jadwalhemodialisa_tgl_ke',
            'mode' => 'date',
            'options' => array(
                'showOn' => false,
                'minDate' => 'd',
                'onSelect' => 'js:function(){setHari(); return false;}',
            ),
            'htmlOptions' => array('class' => 'span3 dtPicker3 ', 'onkeyup' => "return $(this).focusNextInputField(event)", ''),
        ));
        ?>
        <?php echo $form->hiddenField($modJadwalHD, 'jadwalhemodialisa_hari', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
    </div>
</div>
<div class="control-group">
    <?php echo CHtml::label('Shift Selanjutnya<span class="required">*</span>', 'shift_id', array('class' => 'control-label required')) ?> 
    <div class='controls'>
        <?php
        echo $form->dropDownList($modJadwalHD, 'shift_id', CHtml::listData(ShiftHdM::model()->findAllByAttributes(array('shift_hd_aktif' => true)), 'shift_hd_id', 'shift_hd_nama'), array('empty' => '-- Pilih --',
            'onkeypress' => "return $(this).focusNextInputField(event)",
            'class' => 'span3 required',
        ));
        ?>
    </div>
</div> 
<?php /*
    <div class="control-group cek_sep" style="display: none;">
            <?php echo CHtml::label('Briging SEP Langsung', '', array('class'=>'control-label'));?>
            <div class="controls">
                <?php echo $form->checkBox($model,'is_langsung_briging', array('onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Pilih jika akan create SEP saat pendaftaran','onclick'=>'setCreateSep(this);')); ?>
            </div>
        </div>
        <!--S-No Rujukan-->
        <div class="panel panel-success rujukan" style="display: none;" id="rujukan-nomor">
        <div class="control-group rujukan">
            <div class="control-label"><?php echo Chtml::label('Jenis Rujukan','jenis_rujukan',array('class'=>'control-label')); ?></div>
            <div class="controls form-inline">
                <?php 
                echo $form->radioButtonList($model,'jenis_rujukan',array("1"=>"PCare&nbsp;&nbsp;","2"=>"Rumah Sakit"), array('onkeyup'=>"return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
        <div class="control-group rujukan">
            <?php echo CHtml::label("No Rujukan BPJS <span class='required'>*</span>", 'no_rujukan', array('class'=>'control-label'))?>
            <div class="controls">
                <?php echo $form->textField($model,'no_rujukan',array('placeholder'=>'No Rujukan BPJS','class'=>'span3 all-caps required norujukan', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
            </div>
        </div>
        </div>
        <!--E-No Rujukan-->
     * 
     */ ?>
<?php // echo $form->dropDownListRow($model,'keadaanmasuk', LookupM::getItems('keadaanmasuk'),array('empty'=>'-- Pilih --',
//                                        'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); 
?>

<?php // echo $form->dropDownListRow($model,'transportasi', LookupM::getItems('transportasi'),array('empty'=>'-- Pilih --',
//                                    'onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3')); 
?>
<?php echo $form->textAreaRow($model, 'keterangan_pendaftaran', array('placeholder' => 'Catatan Khusus Pendaftaran', 'rows' => 2, 'cols' => 50, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>

<?php
//=============================== Dialog Jadwal Dokter =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'jadwalDokter',
        'options' => array(
            'title' => 'Jadwal Dokter Poliklinik',
            'autoOpen' => false,
            'width' => 840,
            'height' => 420,
            'resizable' => true,
        ),
    )
);

$format = new MyFormatter();
$modJadDok = new PPJadwaldokterM('search');
$modJadDok->unsetAttributes();
$modJadDok->jadwaldokter_hari = $format->getDayUser(date('w'));
if (isset($_GET['PPJadwaldokterM'])) {
    $modJadDok->attributes = $_GET['PPJadwaldokterM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rdjadwaldokter-m-grid',
    'dataProvider' => $modJadDok->search(),
    'filter' => $modJadDok,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
					"id" => "selectJadwalDokter",
					"onClick" => "
						setDokterJadwal(\"$data->pegawai_id\");

					"))',
        ),
        array(
            'name' => 'pegawai_id',
            'filter' => false,
            'value' => '(isset($data->pegawai->nama_pegawai) ? $data->pegawai->nama_pegawai : "")',
        ),
        'jadwaldokter_hari',
        'jadwaldokter_buka',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END Dialog Jadwal Dokter =======================================
?>