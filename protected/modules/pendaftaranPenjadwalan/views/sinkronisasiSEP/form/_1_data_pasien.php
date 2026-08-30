<?php
$readonly = FALSE;
?>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <?php echo CHtml::label("Instalasi <font style=color:red;> * </font>", 'instalasi_id', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php
                if (!empty($model->pendaftaran_id)) {
                    echo CHtml::textField('instalasi_nama', $model->instalasi_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                } else {
                    echo CHtml::dropDownList('instalasi_id', $model->instalasi_id, CHtml::listData(ARInstalasiM::model()->getInstalasiPelayanans(), 'instalasi_id', 'instalasi_nama'), array('onchange' => 'setInfoPasienReset();refreshDialogInfoPasien();', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event)",));
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("No. Rekam Medik <font style=color:red;> * </font>", 'no_rekam_medik', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('pasien_id', $model->pasien_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php // echo CHtml::textField('no_rekam_medik',$model->no_rekam_medik,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                ?>
                <?php
                if ($readonly) {
                    echo CHtml::textField('no_rekam_medik', $model->no_rekam_medik, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => $readonly));
                } else {
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'no_rekam_medik',
                        'value' => $model->no_rekam_medik,
                        'source' => 'js: function(request, response) {
								   $.ajax({
									   url: "' . $this->createUrl('index') . '",
									   dataType: "json",
									   data: {
										   no_rekam_medik: request.term,
										   instalasi_id: $("#instalasi_id").val(),
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
								$(this).val( ui.item.value);
								setInfoPasien(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
								return false;
							}',
                        ),
                        'htmlOptions' => array(
                            'placeholder' => 'Ketik No. Rekam Medik', 'rel' => 'tooltip', 'title' => 'Ketik no. rekam medik untuk mencari data kunjungan',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'class' => 'numbers-only span3',
                        ),
                    ));
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Nama Pasien <font style=color:red;> * </font>", 'nama_pasien', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('namadepan', $model->namadepan, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                <?php
                if ($readonly) {
                    echo CHtml::textField('nama_pasien', $model->nama_pasien, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => $readonly));
                } else {
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'nama_pasien',
                        'value' => $model->nama_pasien,
                        'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('index') . '",
										   dataType: "json",
										   data: {
											   nama_pasien: request.term,
											   instalasi_id: $("#instalasi_id").val(),
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
									$(this).val( ui.item.value);
									setInfoPasien(ui.item.pendaftaran_id, ui.item.no_pendaftaran, ui.item.no_rekam_medik, ui.item.pasienadmisi_id);
									return false;
								}',
                        ),
                        'htmlOptions' => array(
                            'class' => 'span3', 'placeholder' => 'Ketik Nama Pasien', 'rel' => 'tooltip', 'title' => 'Ketik nama pasien untuk mencari data kunjungan',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                        ),
                    ));
                }
                ?>
            </div>
        </div>
        
    </div>
    <div class="span6">
        <div class="control-group no_pendaftaran">
            <?php echo CHtml::label("No. Pendaftaran <font style=color:red;> * </font>", 'no_pendaftaran', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php
                if ($readonly) {
                    echo CHtml::textField('no_pendaftaran', $model->no_pendaftaran, array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'readonly' => $readonly));
                } else {
                    echo CHtml::hiddenField('pendaftaran_id',$model->pendaftaran_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'no_pendaftaran',
                        'value' => $model->no_pendaftaran,
                        'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('index') . '",
										   dataType: "json",
										   data: {
											   no_pendaftaran: request.term,
											   instalasi_id: $("#instalasi_id").val(),
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
									$(this).val(ui.item.no_pendaftaran);
									setNomorDanCariRiwayatSEP(ui.item.pendaftaran_id, ui.item.nokartuasuransi);
									$("#dialogPasien").dialog("open");
                                    // setInfoPasien(ui.item.pendaftaran_id);
									return false;
								}',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogPasien','jsFunction'=>'$("#dialogPasien").dialog("open");refreshDialogInfoPasien();'),
                        'htmlOptions' => array(
                            'placeholder' => 'Ketik No. Pendaftaran', 'class' => 'span3 all-caps', 'rel' => 'tooltip', 'title' => 'Ketik no. pendaftaran / klik icon untuk mencari data kunjungan',
                            'onkeyup' => "return $(this).focusNextInputField(event)",                            
                        ),
                    ));
                }
                ?>
            </div>
        </div>
        
        <div class="control-group">
            <?php echo CHtml::label("Poliklinik / Ruangan", 'ruangan_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $ruangan_id = null;
                if (isset($model->ruangan_id)) {
                    $ruangan_id = $model->ruangan_id;
                }

                echo CHtml::hiddenField('ruangan_id', $ruangan_id, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);"));
                ?>
                <?php echo CHtml::textField('ruangan_nama', $model->ruangan_nama, array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            </div>
        </div>
        
    </div>
</div>

