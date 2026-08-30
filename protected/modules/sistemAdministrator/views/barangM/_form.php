<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sabarang-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'), //return cekNomorReg();
    'focus' => '#' . CHtml::activeId($model, 'bidang_id'),
));
?>
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'barang_type', LookupM::getItems('barangumumtype'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'onchange' => 'cekTipeBarang();')); ?>

        <div class="control-group">
            <?php echo CHtml::label('Jenis Barang  <span class="required">*</span>', 'jenisbarang_id', array('class' => 'control-label required')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jenisbarang_id', CHtml::listData(JenisbarangM::model()->findAll('jenisbarang_aktif = true order by jenisbarang_nama'), 'jenisbarang_id', 'jenisbarang_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
            </div>
        </div>
       

        <?php /*

        <?php //golongan
			echo $form->dropDownListRow($model,'golongan_id', CHtml::listData($model->GolonganItems, 'golongan_id', 'golongan_nama'),
			array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",
				'ajax'=>array('type'=>'POST',
					'url'=>$this->createUrl('/ActionDynamic/GetBidang',array('encode'=>false,'model_nama'=>get_class($model))),
					'update'=>"#".CHtml::activeId($model, 'bidang_id'),
				),
			'onchange'=>"setClearBidang();setClearKelompok();setClearSubKelompok();setClearSubSubKelompok();",));?>
		<?php //bidang //
			if (!empty($model->subsubkelompok_id)){
				$bidang = BidangM::model()->findAll(" bidang_aktif = TRUE AND golongan_id = '".$model->golongan_id."' ORDER BY bidang_kode ASC ");
			}else{
				$bidang = array();
			}
			echo $form->dropDownListRow($model,'bidang_id', CHtml::listData($bidang, 'bidang_id', 'bidang_nama'),
				array('empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)",
				'ajax'=>array('type'=>'POST',
					'url'=>$this->createUrl('/ActionDynamic/GetKelompok',array('encode'=>false,'model_nama'=>get_class($model))),
					'update'=>"#".CHtml::activeId($model, 'kelompok_id'),
				),
			'onchange'=>"setClearKelompok();setClearSubKelompok();setClearSubSubKelompok();",));?>

		<?php //kelompok //
			if (!empty($model->subsubkelompok_id)){
				$kelompok = KelompokM::model()->findAll(" kelompok_aktif = TRUE AND bidang_id = '".$model->bidang_id."' ORDER BY kelompok_kode ASC ");
			}else{
				$kelompok = array();
			}
			echo $form->dropDownListRow($model,'kelompok_id', CHtml::listData($kelompok, 'kelompok_id', 'kelompok_nama'),
			array('empty'=>'-- Pilih --','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",
				'ajax'=>array('type'=>'POST',
					'url'=>$this->createUrl('/ActionDynamic/GetSubKelompok',array('encode'=>false,'model_nama'=>get_class($model))),
					'update'=>"#".CHtml::activeId($model, 'subkelompok_id'),
				),
			'onchange'=>"setClearSubKelompok();setClearSubSubKelompok();",));?>

		<?php //subkelompok //
			if (!empty($model->subsubkelompok_id)){
				$subkelompok = SubkelompokM::model()->findAll(" subkelompok_aktif = TRUE AND kelompok_id = '".$model->kelompok_id."' ORDER BY subkelompok_kode ASC ");
			}else{
				$subkelompok = array();
			}
			echo $form->dropDownListRow($model,'subkelompok_id', CHtml::listData($subkelompok, 'subkelompok_id', 'subkelompok_nama'),
			array('empty'=>'-- Pilih --','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",
				'ajax'=>array('type'=>'POST',
					'url'=>$this->createUrl('/ActionDynamic/GetSubSubKelompok',array('encode'=>false,'model_nama'=>get_class($model))),
					'update'=>"#".CHtml::activeId($model, 'subsubkelompok_id'),
				),
			'onchange'=>"setClearSubSubKelompok();",));?>

		 <?php //subsubkelompok //
			if (!empty($model->subsubkelompok_id)){
				$subsubkelompok = SubsubkelompokM::model()->findAll(" subsubkelompok_aktif = TRUE AND subkelompok_id = '".$model->subkelompok_id."' ORDER BY subsubkelompok_kode ASC ");
			}else{
				$subsubkelompok = array();
			}
			echo $form->dropDownListRow($model,'subsubkelompok_id', CHtml::listData($subsubkelompok, 'subsubkelompok_id', 'subsubkelompok_nama'),
			array('empty'=>'-- Pilih --','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",
				'ajax'=>array('type'=>'POST',
					'url'=>$this->createUrl('/ActionAjax/GetKodeBarangSubSubKel',array('encode'=>false,'model_nama'=>get_class($model))),
					//'update'=>"#".CHtml::activeId($model, 'barang_kode'),
					'dataType' => 'json',
					'success' => 'function(data){
						var nomorregis = $("#SABarangM_nomorregister").val();
						$("#barangkode").val(data.kodebarang);
						$("#SABarangM_barang_kode").val(data.kodebarang);
					}',

				),//'onchange'=>"nomorReg();",
			));?>
		<!--<div class="control-group">
							<label class="control-label" for="bidang">Bidang</label>
							<div class="controls">-->
		<?php //echo $form->hiddenField($model,'bidang_id'); ?>
		<?php /*
		  $this->widget('MyJuiAutoComplete', array(

		  'name'=>'bidangNama',
		  'source'=>'js: function(request, response) {
		  $.ajax({
		  url: "'.Yii::app()->createUrl('ActionAutoComplete/getBidang').'",
		  dataType: "json",
		  data: {
		  term: request.term,
		  },
		  success: function (data) {
		  response(data);
		  }
		  })
		  }',
		  'options'=>array(
		  'showAnim'=>'fold',
		  'minLength' => 2,
		  'focus'=> 'js:function( event, ui ) {
		  $(this).val( ui.item.label);
		  return false;
		  }',
		  'select'=>'js:function( event, ui ) {
		  $("#'.CHtml::activeId($model, 'bidang_id').'").val(ui.item.bidang_id);
		  $("#bidangNama").val(ui.item.bidang_nama);
		  return false;
		  }',
		  ),
		  'htmlOptions'=>array(
		  'onkeypress'=>"return $(this).focusNextInputField(event)",
		  ),
		  'tombolDialog'=>array('idDialog'=>'dialogBidang'),
		  ));
		 */ ?>

        <?php echo CHtml::hiddenField('tempKode', $model->barang_kode); ?>
        <?php echo CHtml::hiddenField('barangkode'); ?>
        <?php echo $form->textFieldRow($model, 'barang_kode', array('class' => 'span3',  'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'readonly' => true)); //'onkeyup' => 'setKode(this);',
        ?>
        <?php /*
        <div class="control-group">
				<?php echo Chtml::label("Nomor Register <span style='color:red'>*</span>", 'nomorregister', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($model, 'nomorregister', array('onblur'=>'valReg(this);','class' => 'span1 numbers-only',  'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4)); //'onkeyup' => 'setKode(this);',?>
				<?php echo '&nbsp;&nbsp;&nbsp;s/d&nbsp;&nbsp;&nbsp;';?>
				<?php echo $form->textField($model, 'nomorregistersd', array('onblur'=>'valRegSD(this);','class' => 'span1 numbers-only',  'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4)); //'onkeyup' => 'setKode(this);',?>
			</div>
		</div>
         *
         */ ?>
        <?php echo $form->textFieldRow($model, 'barang_nama', array('class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'barang_namalainnya', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
        <?php echo $form->textFieldRow($model, 'barang_merk', array('class' => 'reqForm  span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'barang_noseri', array('onkeyup' => 'upper(this);', 'class' => 'span2 alphanumeric-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
        <?php echo $form->textFieldRow($model, 'barang_ukuran', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>

        <div class="control-group">
            <?php
            if (isset($_GET['sukses'])) {
                if (isset($_GET['barang_id'])) {
            ?>

                    <div style="border: 0 solid;margin-left: 90px; margin-top: 80px;text-align:center;width:200px;">
                        <img src="index.php?r=barcode/myBarcode&code=<?php echo $_GET['barang_id']; ?>&is_text=" style="transform:scale(2.0)">
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
<i class="fas fa-cubes"></i> Stok</div>
            </div>
            <div class="panel-body" id="fieldsetStok">
                <!--fieldset class='box' id="fieldsetStok"-->
                <div class="toggle">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'minimalstok', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'minimalstok', array(
                                        'class' => 'span1 integer2',
                                        'onkeypress' => "return $(this).focusNextInputField(event);"
                                    )); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'lokasigudang_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->dropDownList(
                                        $model,
                                        'lokasigudang_id',
                                        CHtml::listData($model->lokasiGudangItems, 'lokasigudang_id', 'lokasigudang_nama'),
                                        array(
                                            'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                            'empty' => '-- Pilih --', 'style' => 'width:130px;'
                                        )
                                    ); ?>
                                </div>
                            </div>
                            <?php echo $form->textFieldRow($model, 'maksimalstok', array(
                                'class' => 'span2 integer2',
                                'onkeypress' => "return $(this).focusNextInputField(event);"
                            )); ?>
                        </div>
                    </div>
                </div>
                <!--</fieldset>-->
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'barang_bahan', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
        <?php echo $form->textFieldRow($model, 'barang_thnbeli', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 4, 'style' => 'text-align:right;')); ?>
        <?php echo $form->dropDownListRow($model, 'barang_warna', LookupM::getItems('warna'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2')); ?>
        <?php //echo $form->checkBoxRow($model,'barang_statusregister', array('onkeypress'=>"return $(this).focusNextInputField(event);"));  
        ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'barang_ekonomis_thn', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'barang_ekonomis_thn', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'text-align:right;', 'maxlength' => 4)) . ' tahun '; ?>
            </div>
        </div>

        <?php
        echo $form->dropDownListRow($model, 'barang_satuan', LookupM::getItems('satuanbarang'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2'));
        ?>
        <?php echo $form->textFieldRow($model, 'barang_jmldlmkemasan', array('class' => 'span1 numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'barang_harganetto', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'barang_harganetto', array('class' => 'span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")) . ' <label>Rupiah</label>'; ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'barang_persendiskon', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'barang_persendiskon', array('class' => 'span1 comadesimal-only', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'ppn_persen', array('class' => 'control-label', 'label' => 'PPN (%)')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'ppn_persen', array('class' => 'span1 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'text-align:right;')); ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'barang_ppn', array('class' => 'control-label', 'label' => 'PPN')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'barang_ppn', array('class' => 'span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")) . ' <label>Rupiah</label>'; ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'barang_hpp', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'barang_hpp', array('class' => 'span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")) . ' <label>Rupiah</label>'; ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'barang_hargajual', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'barang_hargajual', array('class' => 'span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")) . ' <label>Rupiah</label>'; ?>
            </div>
        </div>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'barang_image', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
            <div class="controls">
                <?php echo Chtml::activeFileField($model, 'barang_image', array('maxlength' => 254, 'hint' => 'Isi Jika Akan Menambahkan Logo')); ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($model, 'barang_keterangan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'rows' => 4, 'cols' => 50)); ?>
    </div>
</div>
<div class="form-actions">
    <?php
    $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
    $disableSave = false;
    $disableSave = ($sukses > 0) ? true : false;

    ?>
    <?php $disablePrint = ($disableSave) ? false : true; ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disableSave)); //formSubmit(this,event) 
    ?>

    <?php
    //    if($model->isNewRecord){
    //        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    //        echo CHtml::htmlButton(Yii::t('mds', '{icon} Create',array('{icon}' => '<i class="entypo-check"></i>')));

    //        echo CHtml::link(Yii::t('mds', '{icon} Print Karcis', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;')).'&nbsp;';
    //    }else{
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'button', 'onclick'=>'return false', 'onkeypress'=>'return false', 'disabled'=>true, 'style'=>'cursor:not-allowed;'));

    //        echo CHtml::link(Yii::t('mds', '{icon} Print Karcis', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printKarcis();return false",'disabled'=>FALSE  )).'&nbsp;';
    ////        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
    //    }

    //    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')) : Yii::t('mds', '{icon} Create',array('{icon}' => '<i class="entypo-check"></i>'));
    // echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit'));
    ?>
    <?php
    if (isset($_GET['sukses'])) {
        echo CHtml::link(Yii::t('mds', '{icon} Print Barang', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printBarang();return false", 'disabled' => FALSE));
    } else {
        echo CHtml::link(Yii::t('mds', '{icon} Print Barang', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
    }

    //        echo CHtml::link($model->isNewRecord ? Yii::t('mds', '{icon} Create',array('{icon}' => '<i class="entypo-check"></i>', 'disabled'=>true, 'style'=>'cursor:not-allowed;'))) : Yii::t('mds', '{icon} Print Karcis', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printKarcis();return false",'disabled'=>FALSE));
    ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/' . $this->id . '/create'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . Yii::app()->createUrl($this->module->id . '/' . $this->id . '/create') . '";}); return false;'
        )
    );
    ?>

    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Barang', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/gudangUmum/BarangMGU', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_tips . 'tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Bidang =========================
/*$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBidang',
    'options' => array(
        'title' => 'Bidang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));

$modBidang = new GUBidangM('search');
$modBidang->unsetAttributes();
if (isset($_GET['GUBidangM']))
    $modBidang->attributes = $_GET['GUBidangM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sainstalasi-m-grid',
    'dataProvider' => $modBidang->search(),
    'filter' => $modBidang,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>",
                                "#",
                                array(
                                    "class"=>"btn-small",
                                    "id" => "selectBidang",
                                    "onClick" => "
                                    $(\"#' . CHtml::activeId($model, 'bidang_id') . '\").val(\'$data->bidang_id\');
                                    $(\"#bidangNama\").val(\'$data->bidangNama\');
                                    $(\'#dialogBidang\').dialog(\'close\');return false;"))'
        ),
        array(
            'header' => 'Golongan',
            'filter' => CHtml::listData($model->GolonganItems, 'golongan_id', 'golongan_nama'),
            'value' => '$data->subkelompok->kelompok->golongan->golongan_nama',
        ),
        array(
            'header' => 'Kelompok',
            'filter' => CHtml::listData($model->KelompokItems, 'kelompok_id', 'kelompok_nama'),
            'value' => '$data->subkelompok->kelompok->kelompok_nama',
        ),
        array(
            'header' => 'Sub Kelompok',
            'filter' => CHtml::listData($model->SubKelompokItems, 'subkelompok_id', 'subkelompok_nama'),
            'value' => '$data->subkelompok->subkelompok_nama',
        ),
        array(
            'name' => 'bidang_id',
            'filter' => CHtml::listData($model->BidangItems, 'bidang_id', 'bidang_nama'),
            'value' => '$data->bidang_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();*/
?>

<?php Yii::app()->clientScript->registerScript('head', '
    function setKode(obj){
        var value = $("#tempKode").val();
        var objValue = $(obj).val();
        if (objValue < value){
           $(obj).val(value);
        }
    }
', CClientScript::POS_HEAD); ?>
<?php
$js = <<< JS
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly', $js, CClientScript::POS_READY);
?>

<script type="text/javascript">
    function cekTipeBarang() {
        var tipebarang = $("#SABarangM_barang_type").val();
        if (tipebarang != '') {
            $.post("<?php echo $this->createUrl('generatorKodeBarang'); ?>", {
                tipebarang: tipebarang
            }, function(data) {
                if (data != null) {
                    $("#<?php echo CHtml::activeId($model, "barang_kode"); ?>").val(data.kodebarang);
                }
            }, "json");
        } else {
            $("#<?php echo CHtml::activeId($model, "barang_kode"); ?>").val("");
        }


        return true;
        /* if ()//tipebarang === "Habis Pakai" || tipebarang === "Persediaan"
         {   //disabled
             $("#<?php //echo CHtml::activeId($model,"barang_kode");
                    ?>").val('');
             $("#barangkode").val('');
             $("#barangkode").val('');
             $(".alert-block").remove();
             $(".help-inline").remove();
             $("label[for=SABarangM_golongan_id]").find($("span[class=required]")).remove();
             $("label[for=SABarangM_bidang_id]").find($("span[class=required]")).remove();
             $("label[for=SABarangM_kelompok_id]").find($("span[class=required]")).remove();
             $("label[for=SABarangM_subkelompok_id]").find($("span[class=required]")).remove();
             $("label[for=SABarangM_subsubkelompok_id]").find($("span[class=required]")).remove();
             $("label[for=SABarangM_nomorregister]").find($("span[class=required]")).remove();
             $("label[for=SABarangM_barang_ekonomis_thn]").find($("span[class=required]")).remove();

             $("#SABarangM_golongan_id option[value='']").attr('selected','selected');
             $(".control-group").removeClass('error').addClass('notrequired');
             $("#<?php //echo CHtml::activeId($model,"golongan_id");
                    ?>").removeClass('error').addClass('inputnotrequired');
             $("#<?php //echo CHtml::activeId($model,"bidang_id");
                    ?>").removeClass('error').addClass('inputnotrequired');
             $("#<?php //echo CHtml::activeId($model,"kelompok_id");
                    ?>").removeClass('error').addClass('inputnotrequired');
             $("#<?php //echo CHtml::activeId($model,"subkelompok_id");
                    ?>").removeClass('error').addClass('inputnotrequired');
             $("#<?php //echo CHtml::activeId($model,"subsubkelompok_id");
                    ?>").removeClass('error').addClass('inputnotrequired');
             $("#<?php //echo CHtml::activeId($model,"nomorregister");
                    ?>").removeClass('error').addClass('inputnotrequired');
             $("#<?php //echo CHtml::activeId($model,"barang_ekonomis_thn");
                    ?>").removeClass('error').addClass('inputnotrequired');

             $("label[for=SABarangM_golongan_id]").removeClass('error required').addClass('notrequired');
             $("label[for=SABarangM_bidang_id]").removeClass('error required').addClass('notrequired');
             $("label[for=SABarangM_kelompok_id]").removeClass('error required').addClass('notrequired');
             $("label[for=SABarangM_subkelompok_id]").removeClass('error required').addClass('notrequired');
             $("label[for=SABarangM_subsubkelompok_id]").removeClass('error required').addClass('notrequired');
             $("label[for=SABarangM_nomorregister]").removeClass('error required').addClass('notrequired');
             $("label[for=SABarangM_barang_ekonomis_thn]").removeClass('error required').addClass('notrequired');

             $("#<?php //echo CHtml::activeId($model,"bidang_id");
                    ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
             $("#<?php //echo CHtml::activeId($model,"kelompok_id");
                    ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
             $("#<?php //echo CHtml::activeId($model,"subkelompok_id");
                    ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
             $("#<?php //echo CHtml::activeId($model,"subsubkelompok_id");
                    ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');

             $("#<?php //echo CHtml::activeId($model,"barang_kode");
                    ?>").prop("readonly", false );
             $("#<?php //echo CHtml::activeId($model,"golongan_id");
                    ?>").prop("disabled", true );
             $("#<?php //echo CHtml::activeId($model,"bidang_id");
                    ?>").prop("disabled", true );
             $("#<?php //echo CHtml::activeId($model,"kelompok_id");
                    ?>").prop("disabled", true );
             $("#<?php //echo CHtml::activeId($model,"subkelompok_id");
                    ?>").prop("disabled", true );
             $("#<?php //echo CHtml::activeId($model,"subsubkelompok_id");
                    ?>").prop("disabled", true );
         }
         else    */
        // {
        $("#<?php echo CHtml::activeId($model, "barang_kode"); ?>").prop("readonly", true);
        $("#<?php echo CHtml::activeId($model, "golongan_id"); ?>").prop("disabled", false);
        $("#<?php echo CHtml::activeId($model, "bidang_id"); ?>").prop("disabled", false);
        $("#<?php echo CHtml::activeId($model, "kelompok_id"); ?>").prop("disabled", false);
        $("#<?php echo CHtml::activeId($model, "subkelompok_id"); ?>").prop("disabled", false);
        $("#<?php echo CHtml::activeId($model, "subsubkelompok_id"); ?>").prop("disabled", false);

        $("label[for=SABarangM_golongan_id]").find($("span[class=required]")).remove();
        $("label[for=SABarangM_bidang_id]").find($("span[class=required]")).remove();
        $("label[for=SABarangM_kelompok_id]").find($("span[class=required]")).remove();
        $("label[for=SABarangM_subkelompok_id]").find($("span[class=required]")).remove();
        $("label[for=SABarangM_subsubkelompok_id]").find($("span[class=required]")).remove();
        $("label[for=SABarangM_nomorregister]").find($("span[class=required]")).remove();
        $("label[for=SABarangM_barang_ekonomis_thn]").find($("span[class=required]")).remove();

        $("label[for=SABarangM_golongan_id]").append("<span class=required> *</span>")
        $("label[for=SABarangM_bidang_id]").append("<span class=required> *</span>");
        $("label[for=SABarangM_kelompok_id]").append("<span class=required> *</span>");
        $("label[for=SABarangM_subkelompok_id]").append("<span class=required> *</span>");
        $("label[for=SABarangM_subsubkelompok_id]").append("<span class=required> *</span>");
        $("label[for=SABarangM_nomorregister]").append("<span class=required> *</span>");
        $("label[for=SABarangM_barang_ekonomis_thn]").append("<span class=required> *</span>");

        $("label[for=SABarangM_golongan_id]").addClass("required");
        $("label[for=SABarangM_bidang_id]").addClass("required");
        $("label[for=SABarangM_kelompok_id]").addClass("required");
        $("label[for=SABarangM_subkelompok_id]").addClass("required");
        $("label[for=SABarangM_subsubkelompok_id]").addClass("required");
        $("label[for=SABarangM_nomorregister]").addClass("required");
        $("label[for=SABarangM_barang_ekonomis_thn]").addClass("required");

        setClearBidang();
        setClearKelompok();
        setClearSubKelompok();
        setClearSubSubKelompok();
        //  }

    }

    function namaLain(nama) {
        document.getElementById('SABarangM_barang_namalainnya').value = nama.value.toUpperCase();
    }

    function setClearBidang() {
        $("#<?php echo CHtml::activeId($model, "bidang_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
        $("#<?php echo CHtml::activeId($model, "barang_kode"); ?>").val('');
        $("#barangkode").val('');
    }

    function setClearKelompok() {
        $("#<?php echo CHtml::activeId($model, "kelompok_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
        $("#<?php echo CHtml::activeId($model, "barang_kode"); ?>").val('');
        $("#barangkode").val('');
    }

    function setClearSubKelompok() {
        $("#<?php echo CHtml::activeId($model, "subkelompok_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
        $("#<?php echo CHtml::activeId($model, "barang_kode"); ?>").val('');
        $("#barangkode").val('');
    }

    function setClearSubSubKelompok() {
        $("#<?php echo CHtml::activeId($model, "subsubkelompok_id"); ?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
        $("#<?php echo CHtml::activeId($model, "barang_kode"); ?>").val('');
        $("#barangkode").val('');
    }

    function nomorReg() {
        var nomorR = $("#<?php echo CHtml::activeId($model, "nomorregister"); ?>").val();
        var kodebarang = $("#barangkode").val();
        //var kodebarang = $("#<?php //echo CHtml::activeId($model,"barang_kode");
                                ?>").val();
        $("#<?php echo CHtml::activeId($model, "barang_kode"); ?>").val(kodebarang + '.' + nomorR);
    }

    function kodeBarang() {
        var nomorR = $("#<?php echo CHtml::activeId($model, "nomorregister"); ?>").val();
        var kodebarang = $("#<?php echo CHtml::activeId($model, "barang_kode"); ?>").val();

        $("#barangkode").val(kodebarang);
        var pecah = $("#barangkode").val().replace(nomoR, '');
        $("#<?php echo CHtml::activeId($model, "barang_kode"); ?>").val(pecah + '.' + nomorR);
    }

    function cekNomorReg() {
        var nomoreg = $("#<?php echo Chtml::activeId($model, 'nomorregister'); ?>").val();
        var nomoregsd = $("#<?php echo Chtml::activeId($model, 'nomorregistersd'); ?>").val();

        if (nomoreg == '') {
            myAlert("Maaf, Nomor Register Awal Tidak Boleh Kosong");
            return false;
        } else {
            if (nomoreg.length < 4) {
                myAlert("Maaf, Nomor Register Awal Harus 4 digit Angka");
                return false;
            } else if (nomoregsd == '') {
                return requiredCheck("#sabarang-m-form");
            } else {
                if (nomoregsd.length < 4) {
                    myAlert("Maaf, Nomor Register Sampai Dengan Harus 4 digit Angka");
                    return false;
                } else {
                    if (nomoregsd == nomoreg) {
                        myAlert("Maaf, Nomor Register Sampai Dengan Tidak Boleh Sama Dengan Nomor Register Awal");
                        return false;
                    } else {
                        return requiredCheck("#sabarang-m-form");
                    }
                }
            }
        }
    }

    function valReg(obj) {
        var no = $(obj).val().length;

        if (no < 4) {
            myAlert("Maaf, Nomor Register Awal Harus 4 digit Angka");
            return false;
        }

    }

    function valRegSD(obj) {
        var no = $(obj).val();
        var no2 = $("#SABarangM_nomorregister").val();

        if (no.length < 4) {
            myAlert("Maaf, Nomor Register Sampai Dengan Harus 4 digit Angka");
            return false;
        } else {
            if (no == no2) {
                myAlert("Maaf, Nomor Register Sampai Dengan Tidak Boleh Sama Dengan Nomor Register Awal");
                return false;
            }
        }

    }

    function upper(obj) {
        var upper = $(obj).val().toUpperCase();

        $(obj).val(upper);
    }

    /**
     * print status
     */
    function printBarang() {
        window.open('<?php echo $this->createUrl('printBarang', array('barang_id' => isset($_GET['barang_id']) ? $_GET['barang_id'] : null)); ?>', 'printwin', 'left=100,top=100,width=860,height=480');
    }
</script>