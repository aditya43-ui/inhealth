<div class="control-group">
        <?php echo CHtml::label("Cari ".$modAsuransiPasien->getAttributeLabel('nopeserta')." <span class='required'>*</span> <i class=\"icon-search\" onclick=\"getAsuransiNoKartu($('#".CHtml::activeId($modAsuransiPasien,"nopeserta")."').val());\", style=\"cursor:pointer;\" rel='tooltip' title='klik untuk mengecek peserta'></i>", 'nopeserta', array('class'=>'control-label'))?>
        <div class="controls">
            <?php 
                $this->widget('MyJuiAutoComplete', array(
                                'model'=>$modAsuransiPasien,
                                'attribute'=>'nopeserta',
                                'source'=>'js: function(request, response) {
                                                var penjamin_id = $("#'.CHtml::activeId($model,'penjamin_id').'").val();
                                                var pasien_id = $("#'.CHtml::activeId($modPasien,'pasien_id').'").val();
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
                                            $("#'.CHtml::activeId($modAsuransiPasien,'asuransipasien_id').'").val(ui.item.asuransipasien_id);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'nokartuasuransi').'").val(ui.item.nokartuasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'namapemilikasuransi').'").val(ui.item.namapemilikasuransi);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'jenispeserta_id').'").val(ui.item.jenispeserta_id);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'nomorpokokperusahaan').'").val(ui.item.nomorpokokperusahaan);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'namaperusahaan').'").val(ui.item.namaperusahaan);
                                            $("#'.CHtml::activeId($modAsuransiPasien,'kelastanggunganasuransi_id').'").val(ui.item.kelastanggunganasuransi_id);
                                            return false;
                                        }',
                                ),
                                'htmlOptions'=>array('placeholder'=>'No. Peserta','rel'=>'tooltip','title'=>'No. Peserta',
                                    'onkeyup'=>"return $(this).focusNextInputField(event)",
                                    'onblur'=>"",
                                    'class'=>'numbers-only span3'),
                            )); 
            ?>
            <?php echo $form->error($modAsuransiPasien,'nopeserta'); ?>                        
            <?php echo $form->hiddenField($modAsuransiPasien,'asuransipasien_id',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>10)); ?>
        </div>
</div>
<?php echo $form->textFieldRow($modAsuransiPasien,'nokartuasuransi',array('placeholder'=>'Nomor Kartu Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<?php echo $form->textFieldRow($modAsuransiPasien,'namapemilikasuransi',array('placeholder'=>'Nama Lengkap Pemilik Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<div class="control-group">
    <?php echo $form->labelEx($modAsuransiPasien,'jenispeserta_id', array('class'=>'control-label')) ?>
    <div class="controls">
    <?php echo $form->dropDownList($modAsuransiPasien,'jenispeserta_id', CHtml::listData($modAsuransiPasien->getJenisPesertaItems(), 'jenispeserta_id', 'jenispeserta_nama'), 
                                      array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                                            )); ?>

        <?php echo $form->error($modAsuransiPasien, 'jenispeserta_id'); ?>
    </div>
</div>
<?php //echo $form->textFieldRow($modAsuransiPasien,'nomorpokokperusahaan',array('placeholder'=>'Nomor Pokok Perusahaan','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
<?php echo $form->dropDownListRow($modAsuransiPasien,'kelastanggunganasuransi_id', CHtml::listData(RJPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('disabled'=>true,'empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<?php //echo $form->textFieldRow($modAsuransiPasien,'namaperusahaan',array('placeholder'=>'Nama Perusahaan Asuransi','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>

<div class="control-group">
    <?php echo $form->labelEx($modRujukanBpjs,'asalrujukan_id', array('class'=>'control-label')) ?>
    <div class="controls">
    <?php echo $form->dropDownList($modRujukanBpjs,'asalrujukan_id', CHtml::listData($modRujukanBpjs->getAsalRujukanItems(), 'asalrujukan_id', 'asalrujukan_nama'), 
                                      array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                                            'ajax'=>array('type'=>'POST',
                                                          'url'=>Yii::app()->createUrl('ActionDynamic/GetRujukanDari',array('encode'=>false,'namaModel'=>'PPRujukanbpjsT')),
                                                          'update'=>'#'.CHtml::activeId($modRujukanBpjs, 'rujukandari_id'),),
                                            'onchange'=>"clearRujukan();",)); ?>
        <?php /*RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                                        array('class' => 'btn btn-danger','onclick'=>"{addAsalRujukan(); $('#dialogAddAsalRujukan').dialog('open');}",
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
                                    'class'=>'numbers-only span3'),
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
                                          array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setNamaPerujuk();')); ?>
        <?php /*RND-666 >> echo CHtml::htmlButton('<i class="icon-plus-sign icon-white"></i>', 
                                        array('class' => 'btn btn-danger','onclick'=>"{addRujukanDari(); $('#dialogAddRujukanDari').dialog('open');}",
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
                                'htmlOptions'=>array('placeholder'=>'Pilih tanggal konfirmasi', 'class'=>'dtPicker3 datetimemask span3','onkeyup'=>"return $(this).focusNextInputField(event)",),
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
                                //'bricket'=>false,
                                // 'json_url'=>$this->createUrl('AutocompleteDiagnosaRujukan'),
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
                                //'bricket'=>false,
                                // 'json_url'=>$this->createUrl('AutocompleteDiagnosaRujukan'),
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

<div class="control-group">
    <div class="controls">
         <?php //echo $form->checkBox($modAsuransiPasien,'status_konfirmasi', array('onkeyup'=>"return $(this).focusNextInputField(event)",'checked'=>false)); ?><!--<label> Telah Dikonfirmasi</label>-->
        <?php //echo $form->error($modAsuransiPasien, 'status_konfirmasi'); ?>
    </div>
</div>
<div class="control-group">
    <?php //echo $form->labelEx($modAsuransiPasien,'tgl_konfirmasi', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php   
//             $modAsuransiPasien->tgl_konfirmasi = (!empty($modAsuransiPasien->tgl_konfirmasi) ? date("d/m/Y H:i:s",strtotime($modAsuransiPasien->tgl_konfirmasi)) : null);
//             $this->widget('MyDateTimePicker',array(
//                             'model'=>$modAsuransiPasien,
//                             'attribute'=>'tgl_konfirmasi',
//                             'mode'=>'datetime',
//                             'options'=> array(
// //                                    'dateFormat'=>Params::DATE_FORMAT,
//                                 'showOn' => false,
//                                 'maxDate' => 'd',
//                             ),
//                             'htmlOptions'=>array('placeholder'=>'Pilih tanggal konfirmasi', 'class'=>'dtPicker3 datetimemask span3','onkeyup'=>"return $(this).focusNextInputField(event)",),
//         )); ?>
        <?php //echo $form->error($modAsuransiPasien, 'tgl_konfirmasi'); ?>
    </div>
</div>
<?php 
    if (Yii::app()->user->getState('isbridging')) { 
?>
<?php echo $form->hiddenField($modSep,'sep_id', array('placeholder'=>'','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<!--<div class="control-group">
    <?php echo $form->labelEx($modSep,'tglsep', array('class'=>'control-label')) ?>
    <div class="controls">
        <?php   
            $modSep->tglsep = (!empty($modSep->tglsep) ? date("d/m/Y H:i:s",strtotime($modSep->tglsep)) : null);
            $this->widget('MyDateTimePicker',array(
                            'model'=>$modSep,
                            'attribute'=>'tglsep',
                            'mode'=>'datetime',
                            'options'=> array(
//                                    'dateFormat'=>Params::DATE_FORMAT,
                                'showOn' => false,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions'=>array('placeholder'=>'Pilih tanggal konfirmasi', 'class'=>'dtPicker3 datetimemask span3','onkeyup'=>"return $(this).focusNextInputField(event)",),
        )); ?>
        <?php echo $form->error($modSep, 'tglsep'); ?>
    </div>
</div>-->
<?php //echo $form->textFieldRow($modSep,'nosep', array('placeholder'=>'','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<?php echo $form->textFieldRow($modSep,'ppkrujukan', array('placeholder'=>'','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<?php //echo $form->hiddenField($modSep,'ppkpelayanan', array('placeholder'=>'','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<?php //echo $form->dropDownListRow($modSep,'jnspelayanan',LookupM::getItems('jenispelayanan'), array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setNamaPerujuk();')); ?>
<?php echo $form->textAreaRow($modSep,'catatansep', array('placeholder'=>'','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
<?php } ?>


<br>
<?php
    // echo CHtml::link(Yii::t('mds', '{icon} Verifikasi SEP', array('{icon}'=>'<i class="icon-form-check icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Klik tombol untuk memverifikasi data bpjs','class'=>'btn btn-info pull-right','onclick'=>"verifikasiBpjs($(this));",));
?>
<?php
    // echo CHtml::link(Yii::t('mds', '{icon} Terverifikasi', array('{icon}'=>'<i class="icon-form-check icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Data SEP sudah Terverifikasi','class'=>'btn btn-info pull-right verified', 'style'=>'display:none', 'disabled'=>true,));
?>