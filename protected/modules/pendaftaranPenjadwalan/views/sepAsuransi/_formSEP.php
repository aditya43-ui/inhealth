<div class="span6">
    <div class="control-group">
        <?php echo CHtml::label("Cari " . $model->getAttributeLabel('no peserta') . " <span class='required'>*</span> <i class=\"icon-search\" onclick=\"getAsuransiNoKartu($('#" . CHtml::activeId($model, "nopeserta") . "').val());\", style=\"cursor:pointer;\" rel='tooltip' title='klik untuk mengecek peserta'></i>", 'nopeserta', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'nopeserta',
                'source' => 'js: function(request, response) {
                                                var penjamin_id = $("#' . CHtml::activeId($model, 'penjamin_id') . '").val();
                                                var pasien_id = $("#' . CHtml::activeId($model, 'pasien_id') . '").val();
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompleteAsuransi') . '",
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
                'options' => array(
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                             $(this).val( "");
                                             return false;
                                         }',
                    'select' => 'js:function( event, ui ) {
                                            $(this).val(ui.item.value);
                                            $("#' . CHtml::activeId($model, 'asuransipasien_id') . '").val(ui.item.asuransipasien_id);
                                            $("#' . CHtml::activeId($model, 'nopeserta') . '").val(ui.item.nopeserta);
                                            $("#' . CHtml::activeId($model, 'nokartuasuransi') . '").val(ui.item.nokartuasuransi);
                                            $("#' . CHtml::activeId($model, 'namapemilikasuransi') . '").val(ui.item.namapemilikasuransi);
                                            $("#' . CHtml::activeId($model, 'jenispeserta_id') . '").val(ui.item.jenispeserta_id);
                                            $("#' . CHtml::activeId($model, 'nomorpokokperusahaan') . '").val(ui.item.nomorpokokperusahaan);
                                            $("#' . CHtml::activeId($model, 'namaperusahaan') . '").val(ui.item.namaperusahaan);
                                            $("#' . CHtml::activeId($model, 'kelastanggungan_id') . '").val(ui.item.kelastanggungan_id);
                                            $("#' . CHtml::activeId($model, 'klsrawat') . '").val(ui.item.kelastanggungan_id);
                                            return false;
                                        }',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Ketik No. Peserta', 'rel' => 'tooltip', 'title' => 'Ketik No. Peserta',
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'onblur' => "",
                    'class' => 'numbers-only'
                ),
            ));
            ?>
            <?php echo $form->error($model, 'nopeserta'); ?>
            <?php echo $form->hiddenField($model, 'asuransipasien_id', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo CHtml::label("Cari " . $model->getAttributeLabel('nokartuasuransi') . " <span class='required'>*</span>", 'nokartuasuransi', array('class' => 'control-label required')) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $model,
                'attribute' => 'nokartuasuransi',
                'source' => 'js: function(request, response) {
                                                var penjamin_id = $("#' . CHtml::activeId($model, 'penjamin_id') . '").val();
                                                var pasien_id = $("#' . CHtml::activeId($model, 'pasien_id') . '").val();
                                               $.ajax({
                                                   url: "' . $this->createUrl('AutocompleteAsuransiKartu') . '",
                                                   dataType: "json",
                                                   data: {
                                                       nokartuasuransi: request.term,
                                                       penjamin_id: penjamin_id,
                                                       pasien_id: pasien_id,
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
                                            $("#' . CHtml::activeId($model, 'asuransipasien_id') . '").val(ui.item.asuransipasien_id);
                                            $("#' . CHtml::activeId($model, 'nopeserta') . '").val(ui.item.nopeserta);
                                            $("#' . CHtml::activeId($model, 'nokartuasuransi') . '").val(ui.item.nokartuasuransi);
                                            $("#' . CHtml::activeId($model, 'namapemilikasuransi') . '").val(ui.item.namapemilikasuransi);
                                            $("#' . CHtml::activeId($model, 'jenispeserta_id') . '").val(ui.item.jenispeserta_id);
                                            $("#' . CHtml::activeId($model, 'nomorpokokperusahaan') . '").val(ui.item.nomorpokokperusahaan);
                                            $("#' . CHtml::activeId($model, 'namaperusahaan') . '").val(ui.item.namaperusahaan);
                                            $("#' . CHtml::activeId($model, 'kelastanggungan_id') . '").val(ui.item.kelastanggungan_id);
                                            $("#' . CHtml::activeId($model, 'klsrawat') . '").val(ui.item.kelastanggungan_id);
                                            getAsuransiNoKartu(ui.item.nokartuasuransi);
                                            setAsuransiLama();
                                            return false;
                                        }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogAsuransiBpjs', 'jsFunction' => 'cekAsuransiBpjs()'),
                'htmlOptions' => array(
                    'placeholder' => 'Ketik No. Kartu Asuransi Bpjs', 'rel' => 'tooltip', 'title' => 'Ketik No. Peserta',
                    'onkeyup' => "; return $(this).focusNextInputField(event)",
                    //                                    'onblur'=>"if($(this).val()=='') setAsuransiBaru(); else setAsuransiLama('',this.value)",
                    'class' => 'numbers-only'
                ),
            ));
            ?>
            <?php echo $form->error($model, 'nokartuasuransi'); ?>
        </div>
    </div>

    <?php echo $form->textFieldRow($modAsuransiPasien, 'namapemilikasuransi', array('placeholder' => 'Nama Lengkap Pemilik Asuransi', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>

    <div class="control-group ">
        <?php echo $form->labelEx($modAsuransiPasien, 'jenispeserta_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList(
                $modAsuransiPasien,
                'jenispeserta_id',
                CHtml::listData($model->getJenisPesertaItems(), 'jenispeserta_id', 'jenispeserta_nama'),
                array(
                    'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                )
            ); ?>
            <?php echo $form->error($modAsuransiPasien, 'jenispeserta_id'); ?>
        </div>
    </div>

    <div class="control-group ">
        <?php echo $form->labelEx($model, 'Kelas Pelayanan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model, 'kelastanggungan_id', CHtml::listData(ARSepT::model()->getKelasTanggunganItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('disabled' => true, 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <?php echo $form->hiddenField($model, 'klsrawat', array()); ?>
    <div class="control-group ">
        <?php echo $form->labelEx($modRujukanBpjs, 'asalrujukan_id', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList(
                $modRujukanBpjs,
                'asalrujukan_id',
                CHtml::listData($modRujukanBpjs->getAsalRujukanItems(), 'asalrujukan_id', 'asalrujukan_nama'),
                array(
                    'class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)",
                    'ajax' => array(
                        'type' => 'POST',
                        'url' => $this->createUrl('GetRujukanDari', array('encode' => false, 'namaModel' => 'ARRujukanbpjsT')),
                        'update' => '#' . CHtml::activeId($modRujukanBpjs, 'rujukandari_id'),
                    ),
                    'onchange' => "clearRujukanBpjs();",
                )
            ); ?>
            <?php echo $form->error($modRujukanBpjs, 'asalrujukan_id'); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo CHtml::label("Cari " . $modRujukanBpjs->getAttributeLabel('no_rujukan') . " <span class='required'>*</span> <i class=\"icon-search\" onclick=\"getRujukanNoRujukan($('#" . CHtml::activeId($modRujukanBpjs, "no_rujukan") . "').val());\", style=\"cursor:pointer;\" rel=\"tooltip\" title=\"klik untuk mengecek rujukan\"></i>", 'no_rujukan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'model' => $modRujukanBpjs,
                'attribute' => 'no_rujukan',
                'options' => array(
                    'focus' => 'js:function( event, ui ) {
											 $(this).val("");
											 return false;
										 }',
                ),
                'htmlOptions' => array(
                    'placeholder' => 'Ketik Nomor Rujukan',

                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    'onblur' => "",
                ),
            ));
            ?>
            <?php echo $form->error($modRujukanBpjs, 'no_rujukan'); ?>
        </div>
    </div>

    <div class="control-group ">
        <?php echo $form->labelEx($modRujukanBpjs, 'rujukandari_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->dropDownList(
                $modRujukanBpjs,
                'rujukandari_id',
                CHtml::listData($modRujukanBpjs->getRujukanDariItems($modRujukanBpjs->asalrujukan_id), 'rujukandari_id', 'namaperujuk'),
                array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)", 'onchange' => 'setNamaPerujukBpjs();')
            ); ?>
            <?php echo $form->error($modRujukanBpjs, 'rujukandari_id'); ?>
        </div>
    </div>

    <?php echo $form->textFieldRow($modRujukanBpjs, 'nama_perujuk', array('placeholder' => 'Nama Lengkap Perujuk', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>

    <div class="control-group ">
        <label class="control-label required" for="ARRujukanbpjsT_tanggal_rujukan">
            Tanggal Rujukan
            <span class="required">*</span>
        </label>
        <div class="controls">
            <?php
            $modRujukanBpjs->tanggal_rujukan = (!empty($modRujukanBpjs->tanggal_rujukan) ? date("d/m/Y H:i:s", strtotime($modRujukanBpjs->tanggal_rujukan)) : null);
            $this->widget('MyDateTimePicker', array(
                'model' => $modRujukanBpjs,
                'attribute' => 'tanggal_rujukan',
                'mode' => 'datetime',
                'options' => array(
                    //                                    'dateFormat'=>Params::DATE_FORMAT,
                    'showOn' => false,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('class' => 'dtPicker3 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)",),
            )); ?>

            <?php echo $form->error($modRujukanBpjs, 'tanggal_rujukan'); ?>
        </div>
    </div>

    <div class="control-group ">
        <label for="ARRujukanbpjsT_kddiagnosa_rujukan" class="control-label">Kode Diagnosa Rujukan <font color="red">*</font><i class="icon-search" onclick="$('#dialogDiagnosa').dialog('open')" , style="cursor:pointer;" rel='tooltip' title='klik untuk mencari diagnosa rujukan'></i> </label>
        <div class="controls">
            <?php
            $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                'model' => $modRujukanBpjs,
                'attribute' => 'kddiagnosa_rujukan',
                'data' => explode(',', $modRujukanBpjs->kddiagnosa_rujukan),
                'debugMode' => true,
                'options' => array(
                    //'bricket'=>false,
                    // 'json_url'=>$this->createUrl('AutocompleteDiagnosaRujukan'),
                    'addontab' => true,
                    'maxitems' => 10,
                    'input_min_size' => 0,
                    'cache' => true,
                    'newel' => true,
                    'addoncomma' => true,
                    'select_all_text' => "",
                    'autoFocus' => true,
                ),
                'htmlOptions' => array('id' => 'diagnosaRujukanKodeBpjs'),
            ));
            ?>
            <?php echo $form->error($modRujukanBpjs, 'kddiagnosa_rujukan'); ?>
        </div>
    </div>

    <div class="control-group ">
        <label for="ARRujukanbpjsT_diagnosa_rujukan" class="control-label">Diagnosa Rujukan <font color="red">*</font></label>
        <div class="controls">
            <?php
            $this->widget('application.extensions.FCBKcomplete.FCBKcomplete', array(
                'model' => $modRujukanBpjs,
                'attribute' => 'diagnosa_rujukan',
                'data' => explode(',', $modRujukanBpjs->diagnosa_rujukan),
                'debugMode' => true,
                'options' => array(
                    //'bricket'=>false,
                    // 'json_url'=>$this->createUrl('AutocompleteDiagnosaRujukan'),
                    'addontab' => true,
                    'maxitems' => 10,
                    'input_min_size' => 0,
                    'cache' => true,
                    'newel' => true,
                    'addoncomma' => true,
                    'select_all_text' => "",
                    'autoFocus' => true,
                ),
                'htmlOptions' => array('id' => 'diagnosaRujukanBpjs'),
            ));
            ?>
            <?php echo $form->error($modRujukanBpjs, 'diagnosa_rujukan'); ?>
        </div>
    </div>


</div>
<div class="span6">
    <?php
    if (Yii::app()->user->getState('isbridging')) {
    ?>
        <?php echo $form->hiddenField($model, 'sep_id', array('placeholder' => '', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <!-- <div class="control-group ">
		<?php echo $form->labelEx($model, 'tglsep', array('class' => 'control-label')) ?>
		<div class="controls">
			<?php
            $model->tglsep = (!empty($model->tglsep) ? date("d/m/Y H:i:s", strtotime($model->tglsep)) : null);
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tglsep',
                'mode' => 'datetime',
                'options' => array(
                    //                                    'dateFormat'=>Params::DATE_FORMAT,
                    'showOn' => false,
                    'maxDate' => 'd',
                ),
                'htmlOptions' => array('class' => 'dtPicker3 datetimemask', 'onkeyup' => "return $(this).focusNextInputField(event)",),
            )); ?>
			<?php echo $form->error($model, 'tglsep'); ?>
		</div>
	</div> -->
        <div class="control-group ">
            <label class="control-label">
                <?php echo CHtml::checkBox('isSepManual', '', array('onchange' => 'setSEP(this)')); ?>
                No. SEP
                <!-- <span class="required">*</span> -->
            </label>
            <div class="controls">
                <?php echo $form->textField($model, 'nosep', array('placeholder' => 'No. SEP Manual / Otomatis', 'class' => 'span3 nosep', 'disabled' => 'disabled', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->error($model, 'nosep'); ?>
            </div>
        </div>
        <?php //echo $form->textFieldRow($model,'nosep', array('placeholder'=>'','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); 
        ?>
        <?php echo $form->textFieldRow($model, 'ppkrujukan', array('placeholder' => '', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
        <?php //echo $form->hiddenField($model,'ppkpelayanan', array('placeholder'=>'','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); 
        ?>
        <?php //echo $form->dropDownListRow($model,'jnspelayanan',LookupM::getItems('jenispelayanan'), array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onchange'=>'setNamaPerujuk();')); 
        ?>
        <?php echo $form->textAreaRow($model, 'catatansep', array('placeholder' => '', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)")); ?>
    <?php } ?>

    <?php echo $form->textFieldRow($model, 'ppkpelayanan', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
    <?php echo $form->dropDownListRow($model, 'jnspelayanan',  LookupM::getItems('jenispelayanan'), array('empty' => '--Pilih--', 'class' => 'span3')); ?>
    <?php echo $form->dropDownListRow($model, 'politujuan', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true and instalasi_id = ' . Params::INSTALASI_ID_RJ . ' order by ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'), array('empty' => '--Pilih--', 'class' => 'span3')); ?>
    <div class="control-group">
        <?php echo $form->labelEx($model, 'tglpulang', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php
            $model->tglpulang = (!empty($model->tglpulang) ? date("d/m/Y", strtotime($model->tglpulang)) : null);
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'tglpulang',
                'mode' => 'datetime',
                'options' => array(
                    //                                            'dateFormat'=>Params::DATE_FORMAT,
                    'showOn' => false,
                    'maxDate' => 'd',
                    'yearRange' => "-150:+0",
                ),
                'htmlOptions' => array(
                    'placeholder' => '00/00/0000 00:00:00', 'class' => 'dtPicker2 datetime', 'onkeyup' => "return $(this).focusNextInputField(event)"
                ),
            )); ?>
        </div>
    </div>
</div>