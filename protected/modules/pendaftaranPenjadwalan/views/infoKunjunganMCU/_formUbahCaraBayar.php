
<?php
$disabled = true;
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan!");
		$disabled = false;
    }
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php

$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
    'id'=>'ubahcarabayar-form',
    'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
        'htmlOptions'=>array(
            'onKeyPress'=>'return disableKeyPress(event)'
        ),
    )
);

?>

<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <?php echo CHtml::hiddenField('pendaftaran_id',$modPendaftaran->pendaftaran_id,array('readonly'=>true)); ?>
    <?php //echo $form->textFieldRow($model,'pendaftaran_id',array()); ?>
    <div class="control-group">
        <?php echo CHtml::label('No. Pendaftaran ', 'noPendaftaran', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::textField('noPendaftaran',$modPendaftaran->no_pendaftaran,array('readonly'=>true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Pasien', '', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::textField('namaPasien',$modPendaftaran->pasien->nama_pasien,array('readonly'=>true)); ?>
        </div>
    </div>
    <?php
        echo $form->dropDownListRow(
            $modPendaftaran,'carabayar_id',CHtml::listData(CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true), array('order'=>'carabayar_nama ASC')), 'carabayar_id', 'carabayar_nama'),
            array(
                'onchange'=>"listPenjamin(this.value);onClickAsuransi(this);setKelasTanggunganDrop();"
            )
        );
//		$data = KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true),array('order'=>'urutankelas'));
//		echo "<pre>";
//print_r(count((array)$data));
//exit;
    ?>
    <?php echo $form->dropDownListRow($model,'penjamin_id',array(), array('onchange'=>'setNamaPenjaminAsuransi(this);')); ?>
    <?php echo $form->textAreaRow($model,'alasanperubahan',array()); ?>

    <div id="divAsuransi">
        <?php echo $form->textFieldRow($modAsuransiPasien,'nokartuasuransi', array('disabled'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. Asuransi')); ?>
        <?php echo $form->textFieldRow($modAsuransiPasien,'namapemilikasuransi', array('disabled'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Nama Pemilik Asuransi')); ?>
        <?php echo $form->textFieldRow($modAsuransiPasien,'nomorpokokperusahaan', array('disabled'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'No. Pokok Perusahaan')); ?>
        <?php echo $form->textFieldRow($modAsuransiPasien,'namaperusahaan', array('disabled'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Nama Perusahaan'));?>
        <?php echo $form->dropDownListRow($modAsuransiPasien,'kelastanggunganasuransi_id', CHtml::listData($modPendaftaran->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('disabled'=>true,'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:120px;')); ?>
        <div class="control-group">
            <label class="control-label">Status Konfirmasi</label>
            <div class="controls">
        
                    <?php 
                    echo CHtml::activeRadioButton($modAsuransiPasien, 'status_konfirmasi', array(
                        'value'=>'SUDAH DIKONFIRMASI',
                        'uncheckValue'=>null,
                        'id'=>'konfirmasi_sudah',
                        'onchange'=>'$("#PPAsuransipasienM_tgl_konfirmasi").prop("disabled", false);',
                       // 'onchange'=>'switchOtomatis(this)',
                        'class'=>'rb_kon',
                        'checked'=>'checked',
                    ))."Sudah ";
                    echo CHtml::activeRadioButton($modAsuransiPasien, 'status_konfirmasi', array(
                        'value'=>'BELUM DIKONFIRMASI',
                        'uncheckValue'=>null,
                        'onchange'=>'$("#PPAsuransipasienM_tgl_konfirmasi").prop("disabled", true);',
                        'class'=>'rb_kon',
                        'id'=>'konfirmasi_sudah',
                        'checked'=>false,
                    ))."Belum ";
                    ?>
                 <?php //echo $form->checkBox($modAsuransiPasien,'status_konfirmasi', array('onkeypress'=>"return $(this).focusNextInputField(event)",'checked'=>false)); ?>
                <?php echo $form->error($modAsuransiPasien, 'tgl_konfirmasi'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo $form->labelEx($modAsuransiPasien,'tgl_konfirmasi', array('class'=>'control-label')) ?>
            <div class="controls">
                <?php   
                        $this->widget(
                            'MyDateTimePicker',array(
                                'model'=>$modAsuransiPasien,
                                'attribute'=>'tgl_konfirmasi',
                                'mode'=>'datetime',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array('readonly'=>true,'class'=>'span3 dtPicker3'),
                            )
                        );
                ?>
                <?php echo $form->error($modAsuransiPasien, 'tgl_konfirmasi'); ?>
            </div>
        </div>
    </div>

    <div id="divAsuransiBpjs" hidden>
        <div class="control-group">
                <?php echo CHtml::label("Cari ".$modAsuransiPasienBpjs->getAttributeLabel('nopeserta')." <span class='required'>*</span> <i class=\"icon-search\" onclick=\"getAsuransiNoKartu($('#".CHtml::activeId($modAsuransiPasienBpjs,"nopeserta")."').val());\", style=\"cursor:pointer;\" rel='tooltip' title='klik untuk mengecek peserta'></i>", 'nopeserta', array('class'=>'control-label'))?>
                <div class="controls">
                    <?php 
                        $this->widget('MyJuiAutoComplete', array(
                                        'model'=>$modAsuransiPasienBpjs,
                                        'attribute'=>'nopeserta',
                                        'source'=>'js: function(request, response) {
                                                        var penjamin_id = $("#'.CHtml::activeId($model,'penjamin_id').'").val();
                                                        var pasien_id = '.$modPendaftaran->pasien_id.';
                                                       $.ajax({
                                                           url: "'.$this->createUrl('AutocompleteAsuransi').'",
                                                           dataType: "json",
                                                           data: {
                                                               nopeserta: request.term,
                                                               penjamin_id: penjamin_id,
                                                               pasien_id: pasien_id,
                                                           },
                                                           success: function (data) {
                                                                   response(data);
                                                           }
                                                       })
                                                    }',
                                         'options'=>array(
                                               'minLength' => 3,
                                                'focus'=> 'js:function( event, ui ) {
                                                     $(this).val( "");
                                                     return false;
                                                 }',
                                               'select'=>'js:function( event, ui ) {
                                                    $(this).val(ui.item.value);
                                                    $("#'.CHtml::activeId($modAsuransiPasienBpjs,'asuransipasien_id').'").val(ui.item.asuransipasien_id);
                                                    $("#'.CHtml::activeId($modAsuransiPasienBpjs,'nokartuasuransi').'").val(ui.item.nokartuasuransi);
                                                    $("#'.CHtml::activeId($modAsuransiPasienBpjs,'namapemilikasuransi').'").val(ui.item.namapemilikasuransi);
                                                    $("#'.CHtml::activeId($modAsuransiPasienBpjs,'jenispeserta_id').'").val(ui.item.jenispeserta_id);
                                                    $("#'.CHtml::activeId($modAsuransiPasienBpjs,'nomorpokokperusahaan').'").val(ui.item.nomorpokokperusahaan);
                                                    $("#'.CHtml::activeId($modAsuransiPasienBpjs,'namaperusahaan').'").val(ui.item.namaperusahaan);
                                                    $("#'.CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id').'").val(ui.item.kelastanggunganasuransi_id);
                                                    return false;
                                                }',
                                        ),
                                        'htmlOptions'=>array('placeholder'=>'No. Peserta','rel'=>'tooltip','title'=>'No. Peserta',
                                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                                            'onblur'=>"",
                                            'class'=>'span3 numbers-only'),
                                    )); 
                    ?>
                    <?php echo $form->error($modAsuransiPasienBpjs,'nopeserta'); ?>                        
                    <?php echo $form->hiddenField($modAsuransiPasienBpjs,'asuransipasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
                </div>
        </div>
        <?php echo $form->textFieldRow($modAsuransiPasienBpjs,'nokartuasuransi',array('placeholder'=>'Nomor Kartu Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>13)); ?>
        <?php echo $form->textFieldRow($modAsuransiPasienBpjs,'namapemilikasuransi',array('placeholder'=>'Nama Lengkap Pemilik Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
        <div class="control-group">
            <?php echo $form->labelEx($modAsuransiPasienBpjs,'jenispeserta_id', array('class'=>'control-label')) ?>
            <div class="controls">
            <?php echo $form->dropDownList($modAsuransiPasienBpjs,'jenispeserta_id', CHtml::listData($modAsuransiPasien->getJenisPesertaItems(), 'jenispeserta_id', 'jenispeserta_nama'), 
                                              array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                                                    )); ?>

                <?php echo $form->error($modAsuransiPasienBpjs, 'jenispeserta_id'); ?>
            </div>
        </div>
        <?php //echo $form->textFieldRow($modAsuransiPasien,'nomorpokokperusahaan',array('placeholder'=>'Nomor Pokok Perusahaan','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
        <?php echo $form->dropDownListRow($modAsuransiPasienBpjs,'kelastanggunganasuransi_id', CHtml::listData(PPPendaftaranT::model()->getKelasTanggunganItems(), 'kelasbpjs_id', 'kelaspelayanan_nama') ,array('disabled'=>true,'empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <?php //echo $form->textFieldRow($modAsuransiPasien,'namaperusahaan',array('placeholder'=>'Nama Perusahaan Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>

        <div class="control-group">
            <?php echo $form->labelEx($modRujukanBpjs,'asalrujukan_id', array('class'=>'control-label')) ?>
            <div class="controls">
            <?php echo $form->dropDownList($modRujukanBpjs,'asalrujukan_id', CHtml::listData($modRujukanBpjs->getAsalRujukanItems(), 'asalrujukan_id', 'asalrujukan_nama'), 
                                              array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                                                    'ajax'=>array('type'=>'POST',
                                                                  'url'=>$this->createUrl('GetRujukanDari',array('encode'=>false,'namaModel'=>'PPRujukanbpjsT')),
                                                                  'update'=>'#'.CHtml::activeId($modRujukanBpjs, 'rujukandari_id'),),
                                                    'onchange'=>"clearRujukan();",)); ?>
                <?php /*RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                                                array('class'=>'btn btn-primary','onclick'=>"{addAsalRujukan(); $('#dialogAddAsalRujukan').dialog('open');}",
                                                      'id'=>'btnAddAsalRujukan','onkeyup'=>"return $(this).focusNextInputField(event)",
                                                      'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modRujukanBpjs->getAttributeLabel('asalrujukan_id'))) */?>
                <?php echo $form->error($modRujukanBpjs, 'asalrujukan_id'); ?>
            </div>
        </div>
        <div class="control-group">
                  <?php echo CHtml::label("Cari ".$modRujukanBpjs->getAttributeLabel('no_rujukan')." <span class='required'>*</span> <i class=\"icon-search\" onclick=\"getRujukanNoRujukan($('#".CHtml::activeId($modRujukanBpjs,"no_rujukan")."').val());\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek rujukan\"></i>", 'no_rujukan', array('class'=>'control-label'))?>
                <div class="controls">
                    <?php 
                        $this->widget('MyJuiAutoComplete', array(
                                        'model'=>$modRujukanBpjs,
                                        'attribute'=>'no_rujukan',
                                         'options'=>array(
                                                'focus'=> 'js:function( event, ui ) {
                                                     $(this).val("");
                                                     return false;
                                                 }',
                                        ),
                                        'htmlOptions'=>array('placeholder'=>'Nomor Rujukan',

                                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                                            'onblur'=>"",
                                            'class'=>'numbers-only'),
                                    )); 
                    ?>
                    <?php echo $form->error($modRujukanBpjs,'no_rujukan'); ?>                        
                </div>
        </div>

        <?php //echo $form->textFieldRow($modRujukanBpjs,'no_rujukan', array('placeholder'=>'Nomor Rujukan','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <div class="control-group">
            <?php echo $form->labelEx($modRujukanBpjs,'rujukandari_id', array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($modRujukanBpjs,'rujukandari_id',CHtml::listData($modRujukanBpjs->getRujukanDariItems($modRujukanBpjs->asalrujukan_id), 'rujukandari_id', 'namaperujuk'),
                                                  array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setNamaPerujuk(this);')); ?>
                <?php /*RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                                                array('class'=>'btn btn-primary','onclick'=>"{addRujukanDari(); $('#dialogAddRujukanDari').dialog('open');}",
                                                      'id'=>'btnAddRujukanDari','onkeyup'=>"return $(this).focusNextInputField(event)",
                                                      'rel'=>'tooltip','title'=>'Klik untuk menambah '.$modRujukanBpjs->getAttributeLabel('nama_perujuk'))) */?>
                <?php echo $form->error($modRujukanBpjs, 'rujukandari_id'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($modRujukanBpjs,'nama_perujuk', array('placeholder'=>'Nama Lengkap Perujuk','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>

        <div class="control-group">
            <label class="control-label required" for="PPRujukanbpjsT_tanggal_rujukan">
            Tanggal Rujukan
            <span class="required">*</span>
          </label>
            <div class="controls">
                <?php   
                         $modRujukanBpjs->tanggal_rujukan = (!empty($modRujukanBpjs->tanggal_rujukan) ? date("d/m/Y H:i:s",strtotime($modRujukanBpjs->tanggal_rujukan)) : null);
                        $this->widget('MyDateTimePicker',array(
                                        'model'=>$modRujukanBpjs,
                                        'attribute'=>'tanggal_rujukan',
                                        'mode'=>'datetime',
                                        'options'=> array(
        //                                    'dateFormat'=>Params::DATE_FORMAT,
                                            'showOn' => false,
                                            'maxDate' => 'd',
                                        ),
                                        'htmlOptions'=>array('class'=>'dtPicker3 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)",),
                )); ?>
                
                <?php echo $form->error($modRujukanBpjs, 'tanggal_rujukan'); ?>
            </div>
        </div>
        <div class="control-group">
                        <label for="PPRujukanbpjsT_kddiagnosa_rujukan" class="control-label">Kode Diagnosa Rujukan <i class="icon-search" onclick="$('#dialogDiagnosa').dialog('open')", style="cursor:pointer;" rel='tooltip' title='klik untuk mencari diagnosa rujukan'></i></label> 
                        <div class="controls">
                            <?php
                                $this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
                                    'model'=>$modRujukanBpjs,
                                    'attribute'=>'kddiagnosa_rujukan',
                                    'data'=> explode(',', $modRujukanBpjs->kddiagnosa_rujukan),   
                                    'debugMode'=>true,
                                    'options'=>array(
                                        'addontab'=> true, 
                                        'maxitems'=> 10,
                                        'input_min_size'=> 0,
                                        'cache'=> true,
                                        'newel'=> true,
                                        'addoncomma'=>true,
                                        'select_all_text'=> "", 
                                        'autoFocus'=>true,
                                    ),
                                    'htmlOptions'=>array('id'=>'diagnosaRujukanKodeBpjs'),
                                ));
                            ?>
                            <?php echo $form->error($modRujukanBpjs, 'kddiagnosa_rujukan'); ?>
                    </div>
        </div>
        <div class="control-group">
                        <label for="PPRujukanbpjsT_diagnosa_rujukan" class="control-label">Diagnosa Rujukan</label> 
                        <div class="controls">
                            <?php
                                $this->widget('application.extensions.FCBKcomplete.FCBKcomplete',array(
                                    'model'=>$modRujukanBpjs,
                                    'attribute'=>'diagnosa_rujukan',
                                    'data'=> explode(',', $modRujukanBpjs->diagnosa_rujukan),   
                                    'debugMode'=>true,
                                    'options'=>array(
                                        'addontab'=> true, 
                                        'maxitems'=> 10,
                                        'input_min_size'=> 0,
                                        'cache'=> true,
                                        'newel'=> true,
                                        'addoncomma'=>true,
                                        'select_all_text'=> "", 
                                        'autoFocus'=>true,
                                    ),
                                    'htmlOptions'=>array('id'=>'diagnosaRujukanBpjs'),
                                ));
                            ?>
                            <?php echo $form->error($modRujukanBpjs, 'diagnosa_rujukan'); ?>
                    </div>
        </div>
        <?php 
        if (Yii::app()->user->getState('isbridging')) { 
        ?>
        <?php echo $form->hiddenField($modSep,'sep_id', array('placeholder'=>'','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($modSep,'ppkrujukan', array('placeholder'=>'','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textAreaRow($modSep,'catatansep', array('placeholder'=>'','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <?php } ?>
    </div>
    <div class="form-actions">
        <?php
            //echo CHtml::htmlButton(
                //$model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
              //  array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)',)
            //).'&nbsp';
			 if(!isset($_GET['sukses'])){
				 		
				echo CHtml::htmlButton(
					$model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
					array('class'=>'btn btn-primary', 'type'=>'button','onKeypress'=>'return formSubmit(this,event)','onclick'=>'cekNoBPJS(this);', 'id'=>'btn_submit')
				).'&nbsp';
			 }else{
				 echo CHtml::htmlButton(
					$model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="entypo-check"></i>')) : Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
					array('class'=>'btn btn-primary', 'type'=>'button','onKeypress'=>'return formSubmit(this,event)', 'disabled'=>true)
				).'&nbsp';
			 }

            if(Yii::app()->user->getState('isbridging')){
                if (isset($modSep->sep_id)) {
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printSEP();return false",'disabled'=>FALSE  ));
                }else{
                    echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Belum memiliki No. SEP!','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
                }
            }else{
                echo CHtml::link(Yii::t('mds', '{icon} Print SEP', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Fitur Bridging tidak aktif!','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
            }
        ?>
    </div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    $('#UbahcarabayarR_alasanperubahan').focus();
	
function setNamaPenjaminAsuransi(obj) {
	var name = $(obj).find(":selected").html();
	$("#PPAsuransipasienM_namaperusahaan").val(name);
}	
	
function onClickAsuransi()
{
    var data = {
            2:'ada',
            3:'ada'
    };
    var cara_bayar = $("#<?php echo CHtml::activeId($modPendaftaran,'carabayar_id');?>").val();
    
	// console.log(data[cara_bayar]);	
	var cara_bayar_bpjs = <?php echo Params::CARABAYAR_ID_BPJS; ?>;
    if (cara_bayar == cara_bayar_bpjs) {
        <?php 
            if (Yii::app()->user->getState('isbridging')) { 
        ?>					
            $('#divAsuransiBpjs input').removeAttr('disabled');
            $('#divAsuransiBpjs select').removeAttr('disabled');
            $('#divAsuransiBpjs textarea').removeAttr('disabled');
            $('#divAsuransiBpjs').show();

            $('#divAsuransi').hide();
            $('#divAsuransi input').attr('disabled','true');
            $('#divAsuransi select').attr('disabled','true');
            $('#divAsuransi input:not(.rb_kon)').attr('value','');
            $('#divAsuransi select').attr('value','');

        <?php 
            }else{
        ?>
            $('#divAsuransiBpjs').hide();
            $('#divAsuransiBpjs input').attr('disabled','true');
            $('#divAsuransiBpjs select').attr('disabled','true');
            $('#divAsuransiBpjs textarea').attr('disabled','true');
            $('#divAsuransiBpjs input').attr('value','');
            $('#divAsuransiBpjs select').attr('value','');
            $('#divAsuransiBpjs textarea').attr('value','');
            $('#divAsuransi input').removeAttr('disabled');
            $('#divAsuransi select').removeAttr('disabled');
            $('#divAsuransi').show();
        <?php } ?>
    } else {
        if(data[cara_bayar] != 'ada')
        {
			// console.log("Kick");
            $('#divAsuransi').hide();
            $('#divAsuransi input').attr('disabled','true');
            $('#divAsuransi select').attr('disabled','true');
            $('#divAsuransi input:not(.rb_kon)').attr('value','');
            $('#divAsuransi select').attr('value','');

            $('#divAsuransiBpjs').hide();
            $('#divAsuransiBpjs input').attr('disabled','true');
            $('#divAsuransiBpjs select').attr('disabled','true');
            $('#divAsuransiBpjs textarea').attr('disabled','true');
            $('#divAsuransiBpjs input').attr('value','');
            $('#divAsuransiBpjs select').attr('value','');
            $('#divAsuransiBpjs textarea').attr('value','');
        }else{
            $('#divAsuransi input').removeAttr('disabled');
            $('#divAsuransi select').removeAttr('disabled');
            $('#divAsuransi').show();
            //if (cara_bayar == <?php echo Params::CARABAYAR_ID_JAMKESPA; ?>) {
            //    $("#PPAsuransipasienM_nokartuasuransi").val("<?php echo $modPendaftaran->pasien->no_rekam_medik; ?>");
            //    $("#PPAsuransipasienM_namapemilikasuransi").val("<?php echo $modPendaftaran->pasien->nama_pasien; ?>");
            //    $("#PPAsuransipasienM_kelastanggunganasuransi_id").val(<?php echo Params::KELASPELAYANAN_ID_KELAS_III; ?>);
            //}

            $('#divAsuransiBpjs').hide();
            $('#divAsuransiBpjs input').attr('disabled','true');
            $('#divAsuransiBpjs select').attr('disabled','true');
            $('#divAsuransiBpjs textarea').attr('disabled','true');
            $('#divAsuransiBpjs input').attr('value','');
            $('#divAsuransiBpjs select').attr('value','');
            $('#divAsuransiBpjs textarea').attr('value','');
        }
    }
    
}

listPenjamin($("#<?php echo CHtml::activeId($modPendaftaran,'carabayar_id');?>").val());
onClickAsuransi();
setKelasTanggunganDrop();
function listPenjamin(idCaraBayar)
{
    $.post("<?php echo $this->createUrl('getListPenjamin')?>", { idCaraBayar: idCaraBayar },
        function(data){
            $('#UbahcarabayarR_penjamin_id').html(data.listPenjamin);
			$('#PPAsuransipasienM_namapemilikasuransi').val($("#namaPasien").val());
			setNamaPenjaminAsuransi($('#UbahcarabayarR_penjamin_id'));
    }, "json");
}

function setDiagnosaBpjs(kode_diagnosa,nama_diagnosa){
   
  var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
  var randomId = '';
  for (var i = 0; i < 32; i++) {
      var rnum = Math.floor(Math.random() * chars.length);
      randomId += chars.substring(rnum, rnum + 1);
  }
    

  var op = '<option id="opt_'+randomId+'" class="selected" selected="selected" value="'+nama_diagnosa+'">'+nama_diagnosa+'</option>';
  var list = '<li id="pt_'+randomId+'" class="bit-box" rel="'+nama_diagnosa+'">'+nama_diagnosa+'<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
  var opKode = '<option id="opt_'+randomId+'" class="selected" selected="selected" value="'+kode_diagnosa+'">'+kode_diagnosa+'</option>';
  var listKode = '<li id="pt_'+randomId+'" class="bit-box" rel="'+kode_diagnosa+'">'+kode_diagnosa+'<a class="closebutton" href="#" onclick="removeItemDiagnosa($(this).parent().attr(\'id\')); return false;"></a></li>';
  var objSelect = $('select#diagnosaRujukanBpjs').parent().find('select');
  var objList = $('select#diagnosaRujukanBpjs').parent().find('ul li.bit-input');
  var objSelectKode = $('select#diagnosaRujukanKodeBpjs').parent().find('select');
  var objListKode = $('select#diagnosaRujukanKodeBpjs').parent().find('ul li.bit-input');

  objSelect.append(op);
  objList.before(list);
  objSelectKode.append(opKode);
  objListKode.before(listKode);

}

function getAsuransiNoKartu(isi)
{   
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
    if (isi=="") {myAlert('Isi data terlebih dahulu!'); return false;};
    var server = 'api.asterix.co.id/SepWebRest';
    var aksi = 1; // 1 untuk mencari data peserta berdasarkan Nomor Kartu
    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi + '&server=' + server,
        beforeSend: function(){
            $("#divAsuransiBpjs").addClass("animation-loading");
        },
        success: function(data){
            $("#divAsuransiBpjs").removeClass("animation-loading");
            var obj = JSON.parse(data);
            if(obj.response!=null){
              var peserta = obj.response.peserta;
              $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nopeserta') ?>").val(peserta.noKartu);
              $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'nokartuasuransi') ?>").val(peserta.noKartu);
              $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'namapemilikasuransi') ?>").val(peserta.nama);
              $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'jenispeserta_id') ?>").val(peserta.jenisPeserta.kdJenisPeserta);
                $("#<?php echo CHtml::activeId($modAsuransiPasienBpjs,'kelastanggunganasuransi_id') ?>").val(peserta.kelasTanggungan.kdKelas);
            }else{
              myAlert(obj.metaData.message);
            }
        },
        error: function(data){
            $("#divAsuransiBpjs").removeClass("animation-loading");
        }
    }
    
    if(typeof ajax_request !== 'undefined') 
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}
function clearRujukan()
{
    $('#<?php echo CHtml::activeId($modRujukanBpjs, 'rujukandari_id')?>').find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
    $('#<?php echo CHtml::activeId($modRujukanBpjs, 'nama_perujuk')?>').val('');
}
function getRujukanNoRujukan(isi)
{   
    if (<?php echo (Yii::app()->user->getState('isbridging')==TRUE)?1:0; ?>) {}else{myAlert('Fitur Bridging tidak aktif!'); return false;}
    if (isi=="") {myAlert('Isi data terlebih dahulu!'); return false;};
    var server = 'api.asterix.co.id/SepWebRest';
    var aksi = 3; // 3 untuk mencari data rujukan berdasarkan Nomor rujukan
    var setting = {
        url : "<?php echo $this->createUrl('bpjsInterface'); ?>",
        type : 'GET',
        dataType : 'html',
        data : 'param='+ aksi + '&query=' + isi + '&server=' + server,
        beforeSend: function(){
            $("#divAsuransiBpjs").addClass("animation-loading");
        },
        success: function(data){
            $("#divAsuransiBpjs").removeClass("animation-loading");
            var obj = JSON.parse(data);
            if(obj.response!=null){
              var rujukan = obj.response.item;
              var noKunjungan = rujukan.noKunjungan;
              var tglKunjungan = rujukan.tglKunjungan;
              var peserta = rujukan.peserta;    //array
              var provKunjungan = rujukan.provKunjungan;    //array
              var keluhan = rujukan.keluhan;
              var diagnosa = rujukan.diagnosa;    //array
              var catatan = rujukan.catatan;
              var pemFisikLain = rujukan.pemFisikLain;
              var provRujukan = rujukan.provRujukan;    //array
              var poliRujukan = rujukan.poliRujukan;    //array
              $("#<?php echo CHtml::activeId($modRujukanBpjs,'no_rujukan') ?>").val(noKunjungan);
              $("#<?php echo CHtml::activeId($modRujukanBpjs,'nama_perujuk') ?>").val(provRujukan.nmProvider);
              $("#<?php echo CHtml::activeId($modRujukanBpjs,'tanggal_rujukan') ?>").val(tglKunjungan);
              setDiagnosa(diagnosa.kdDiag,diagnosa.nmDiag);
            }else{
              myAlert(obj.metaData.message);
            }
        },
        error: function(data){
            $("#divAsuransiBpjs").removeClass("animation-loading");
        }
    }
    
    if(typeof ajax_request !== 'undefined') 
        ajax_request.abort();
    ajax_request = $.ajax(setting);
}

function printSEP(){
  window.open('<?php echo $this->createUrl('printSep',array('sep_id'=>$modSep->sep_id,'pendaftaran_id'=>$modPendaftaran->pendaftaran_id)); ?>','printwin','left=100,top=100,width=860,height=480');
}

function cekNoBPJS(obj){
	<?php if ( Yii::app()->user->getState('isbridging') == true) { ?>
		var nobpjs = $("#PPAsuransipasienbpjsM_nokartuasuransi").val();
	<?php }else{ ?>
		var nobpjs = $("#PPAsuransipasienM_nokartuasuransi").val();
	<?php } ?>
	var carabayar = $("#PPPendaftaranT_carabayar_id").val();
	var penjamin = $("#UbahcarabayarR_penjamin_id").val();
	
	//alert(penjamin);
	if (carabayar == <?php echo Params::CARABAYAR_ID_BPJS ?>){
		if (penjamin == <?php echo Params::PENJAMIN_ID_BPJS_KESEHATAN ?>){
			if (nobpjs.length != 13){
				myAlert("No. Kartu Asuransi BPJS tidak boleh lebih dan tidak boleh kurang dari sama dengan 13 karakter");
				return false;
			}else{
				$("#ubahcarabayar-form").submit();
				$("#btn_submit").prop('disabled', true);
			}
		}else if(penjamin == <?php echo Params::PENJAMIN_ID_BPJS_KETENAGAKERJAAN ?>){
			if (nobpjs.length < 7 || nobpjs.length > 13){
				myAlert("No. Kartu Asuransi BPJS Ketenagakerjaan tidak boleh kurang dari 7 dan lebih dari 13 karakter");
				return false;
			}else{
				$("#ubahcarabayar-form").submit();
				$("#btn_submit").prop('disabled', true);
			}
		}else{
			$("#ubahcarabayar-form").submit();
			$("#btn_submit").prop('disabled', true);
		}
	}else{
		$("#ubahcarabayar-form").submit();
		$("#btn_submit").prop('disabled', true);
	}
	
	return false;
}

function setKelasTanggunganDrop(){
	<?php
		$drop_kelasbpjs = CHtml::listData(PPPendaftaranT::model()->getKelasTanggunganItems(), 'kelasbpjs_id', 'kelaspelayanan_nama');
		
		$drop_bpjs = '';
		if (count((array)$drop_kelasbpjs)>0){
		
			if (count((array)$drop_kelasbpjs)>1){
				$drop_bpjs .= CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			}
			
			foreach($drop_kelasbpjs as $value=>$name)
			{
				$drop_bpjs .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
			}
		}
		
		$drop_kelas = CHtml::listData(PPPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama');
		$drop_asuran = '';
		
		if (count((array)$drop_kelas)>0){
			
			if (count((array)$drop_kelas)>1){
				$drop_asuran .= CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
			}
			
			foreach($drop_kelas as $value1=>$name1)
			{
				$drop_asuran .= CHtml::tag('option', array('value'=>$value1),CHtml::encode($name1),true);
			}
		}
	?>
	var dropdown_kelasbpjs = '<?php echo $drop_bpjs; ?>';
	var dropdown_kelas = '<?php echo $drop_asuran; ?>';
	
	
	var carabayar = $("#PPPendaftaranT_carabayar_id option:selected").val();

		
	if (carabayar == <?php echo Params::CARABAYAR_ID_BPJS ?>){
		$("#PPAsuransipasienM_nokartuasuransi").attr('maxlength',13);
		$("#PPAsuransipasienM_kelastanggunganasuransi_id").html(dropdown_kelasbpjs);
	}else{
		$("#PPAsuransipasienM_nokartuasuransi").attr('maxlength',24);
		$("#PPAsuransipasienM_kelastanggunganasuransi_id").html(dropdown_kelas);
	}
	
	
}

function setNamaPerujuk(obj){
	var text = $(obj).find(" option:selected ").text();
	
	$("#PPRujukanbpjsT_nama_perujuk").val(text);
}
</script>

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogDiagnosa',
        'options'=>array(
            'title'=>'Pencarian Diagnosa Rujukan',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>480,
            'height'=>480,
            'resizable'=>false,
        ),
    ));
    $modDiagnosa = new PPDiagnosaM('search');
    $modDiagnosa->unsetAttributes();
    if(isset($_GET['PPDiagnosaM'])) {
        $modDiagnosa->attributes = $_GET['PPDiagnosaM'];
    }
    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'diagnosa-m-grid',
            'dataProvider'=>$modDiagnosa->search(),
            'filter'=>$modDiagnosa,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "
                                                setDiagnosaBpjs(\"$data->diagnosa_kode\",\"$data->diagnosa_nama\");
                                            $(\"#dialogDiagnosa\").dialog(\"close\");
                                        "))',
                    ),
                    'diagnosa_kode',
                    'diagnosa_nama',
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
    $this->endWidget();

?>