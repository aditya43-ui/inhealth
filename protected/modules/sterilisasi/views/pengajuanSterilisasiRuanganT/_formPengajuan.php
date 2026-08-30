<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pengajuansterlilisasi_tgl', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $model->pengajuansterlilisasi_tgl = !empty($model->pengajuansterlilisasi_tgl) ? $format->formatDateTimeForUser($model->pengajuansterlilisasi_tgl) : date('d M Y');
                /*$this->widget('MyDateTimePicker', array(
					'model' => $model,
					'attribute' => 'pengajuansterlilisasi_tgl',
					'mode' => 'date',
					'options' => array(
						'dateFormat' => Params::DATE_FORMAT,
//						'maxDate' => 'd',
					),
					'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
				));*/
                echo $form->textField($model, 'pengajuansterlilisasi_tgl', array('class' => 'span4', 'readonly' => TRUE));
                $model->pengajuansterlilisasi_tgl = !empty($model->pengajuansterlilisasi_tgl) ? $format->formatDateTimeForDb($model->pengajuansterlilisasi_tgl) : date('Y-m-d');
                ?>
                <?php echo $form->error($model, 'pengajuansterlilisasi_tgl'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'pengajuansterlilisasi_no', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>
        <?php
        if ($ruangan_id == $ruangan_cssd) {
        ?>
            <div class="control-group">
                <?php echo CHtml::label('Instalasi <span class="required">*</span>', 'Instalasi', array('class' => 'control-label required')) ?>
                <div class="controls">
                    <?php /*echo $form->dropDownList($model,'instalasi_id', CHtml::listData(InstalasiM::model()->findAll(),'instalasi_id','instalasi_nama'),
					array('class'=>'span4','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
							'ajax'=>array('type'=>'POST',
										'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
										'update'=>"#".CHtml::activeId($model, 'ruangan_id'),
							)));*/
                    $instalasinama = Yii::app()->user->getState('instalasi_nama');
                    $instalasiId = Yii::app()->user->getState('instalasi_id');
                    echo CHtml::hiddenField('instalasi_id', $instalasiId, array('readonly' => true, 'class' => 'span4', 'value' => $instalasinama, 'onkeyup' => "return $(this).focusNextInputField(event);"));
                    echo CHtml::TextField('instalasi_nama', $instalasinama, array('readonly' => true, 'class' => 'span4', 'value' => $instalasinama, 'onkeyup' => "return $(this).focusNextInputField(event);"));

                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label('Ruangan <span class="required">*</span>', 'Ruangan', array('class' => 'control-label inline required')) ?>
                <div class="controls">
                    <?php
                    //echo $form->dropDownList($model,'ruangan_id',CHtml::listData(RuanganM::model()->findAll(),'ruangan_id','ruangan_nama'),array('class'=>'span4','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);")); 
                    $ruanganNama = Yii::app()->user->getState('ruangan_nama');
                    $ruanganId = Yii::app()->user->getState('ruangan_id');
                    //var_dump($ruanganId);die();
                    echo CHtml::hiddenField('ruangan_id', $ruanganId, array('readonly' => true, 'class' => 'span4', 'value' => $ruanganId, 'onkeyup' => "return $(this).focusNextInputField(event);"));
                    echo CHtml::TextField('ruangan_nama', $ruanganNama, array('readonly' => true, 'class' => 'span4', 'value' => $ruanganNama, 'onkeyup' => "return $(this).focusNextInputField(event);"));

                    ?>
                </div>
            </div>
        <?php } ?>
        <?php echo $form->textAreaRow($model, 'pengajuansterlilisasi_ket', array('rows' => 3, 'cols' => 100, 'placeholder' => 'Keterangan Pengajuan', 'class' => 'span4 autogrow', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>

    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pegpengajuan_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegpengajuan_id', array('readonly' => true)); ?>
                <?php echo $form->textField($model, 'pegawaimengajukan_nama', array('class' => 'span4 required', 'readonly' => true)); ?>
                <?php
                /*$this->widget('MyJuiAutoComplete', array(
					'model'=>$model,
					'attribute' => 'pegawaimengajukan_nama',
					'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawaiMengajukan') . '",
										   dataType: "json",
										   data: {
											   term: request.term,
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
					'options' => array(
						'showAnim' => 'fold',
						'minLength' => 3,
						'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
						'select' => 'js:function( event, ui ) {
							$("#'.Chtml::activeId($model, 'pegpengajuan_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
					),
					'htmlOptions' => array(
                                                'placeholder'=>'Nama Pegawai yang Mengajukan',
						'class'=>'pegawaimengajukan_nama',
						'onkeyup'=>"return $(this).focusNextInputField(event)",
						'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($model, 'pegpengajuan_id') . '").val(""); '
					),
					'tombolDialog' => array('idDialog' => 'dialogPegawaiMengajukan'),
				));*/
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'pegmengetahui_id', array('class' => 'control-label', 'label' => 'Pegawai yang Mengetahui')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegmengetahui_id', array('readonly' => true)); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pegawaimengetahui_nama',
                    'source' => 'js: function(request, response) {
									   $.ajax({
										   url: "' . $this->createUrl('AutocompletePegawaiMengetahui') . '",
										   dataType: "json",
										   data: {
											   term: request.term,
										   },
										   success: function (data) {
												   response(data);
										   }
									   })
									}',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 3,
                        'focus' => 'js:function( event, ui ) {
							$(this).val( ui.item.label);
							return false;
						}',
                        'select' => 'js:function( event, ui ) {
							$("#' . Chtml::activeId($model, 'pegmengetahui_id') . '").val(ui.item.pegawai_id); 
							return false;
						}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Pegawai yang Mengetahui',
                        'class' => 'span4 pegawaimengetahui_nama',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'pegmengetahui_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui'),
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php
//========= Dialog buat cari data Pegawai Mengajukan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengajukan',
    'options' => array(
        'title' => 'Pencarian Pegawai Mengajukan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'zIndex' => 1002,
        'resizable' => true,
    ),
));

$modPegawaiMengajukan = new STPegawaiV('searchPegawaiMengajukan');
$modPegawaiMengajukan->unsetAttributes();
//$modPegawaiMengajukan->ruangan_id = Yii::app()->user->getState("ruangan_id");
if (isset($_GET['STPegawaiV'])) {
    $modPegawaiMengajukan->attributes = $_GET['STPegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengajukan-grid',
    'dataProvider' => $modPegawaiMengajukan->searchPegawaiMengajukan(),
    'filter' => $modPegawaiMengajukan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($model, 'pegpengajuan_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimengajukan_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengajukan\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawaiMengajukan, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Gelar Depan',
            'filter' =>  CHtml::activeTextField($modPegawaiMengajukan, 'gelardepan'),
            'value' => '$data->gelardepan',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengajukan, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Gelar Belakang',
            'filter' =>  CHtml::activeTextField($modPegawaiMengajukan, 'gelarbelakang_nama'),
            'value' => '$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Alamat Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengajukan, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengajukan dialog =============================
?>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiMengetahui',
    'options' => array(
        'title' => 'Pencarian Pegawai Mengetahui',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => true,
    ),
));

/*$modPegawaiMengetahui = new STPegawaiV('searchPegawaiMengetahui');
$modPegawaiMengetahui->unsetAttributes();
if(isset($_GET['STPegawaiV'])) {
    $modPegawaiMengetahui->attributes = $_GET['STPegawaiV'];
}*/
$modPegawaiMengetahui = new PegawairuanganV();
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['PegawairuanganV'])) {
    $modPegawaiMengetahui->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPegawaiMengetahui->search(),
    'filter' => $modPegawaiMengetahui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#' . CHtml::activeId($model, 'pegmengetahui_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'pegawaimengetahui_nama') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        /*array(
                    'header'=>'Gelar Depan',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelardepan'),
                    'value'=>'$data->gelardepan',
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->nama_pegawai',
                ),
                array(
                    'header'=>'Gelar Belakang',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'gelarbelakang_nama'),
                    'value'=>'$data->gelarbelakang_nama',
                ),*/
        array(
            'header' => 'Nama Pegawai',
            'filter' =>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
        /*
                array(
                    'header'=>'Alamat Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'alamat_pegawai'),
                    'value'=>'$data->alamat_pegawai',
                ),
                 */

        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'value' => function ($data) {
                $j = JabatanM::model()->findByPk($data->jabatan_id);

                if (!empty($j)) {
                    return $j->jabatan_nama;
                } else {
                    return '-';
                }
            },
            'filter' => Chtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --'))
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>