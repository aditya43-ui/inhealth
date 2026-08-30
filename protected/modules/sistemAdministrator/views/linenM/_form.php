<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/fileupload/fileupload.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'salinen-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);', 'enctype' => 'multipart/form-data'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">

    <div class="col-sm-6">
        <div class="control-group">
            <?php echo $form->labelEx($model, 'barang_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'barang_id'); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'barang_nama',
                    'source' => 'js: function(request, response) {
										   $.ajax({
											   url: "' . $this->createUrl('AutocompleteBarang') . '",
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
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
										$(this).val("");
										return false;
									}',
                        'select' => 'js:function( event, ui ) {
										$(this).val(ui.item.value);
										$("#barang_id").val(ui.item.barang_id);
										$("#namaBarang").val(ui.item.barang_nama);
										return false;
									}',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span3',
                        'placeholder' => 'Linen Nama',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#barang_id").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogBarang'),
                ));
                ?>

            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'noregisterlinen', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->dropDownListRow($model, 'bahanlinen_id', CHtml::listData(BahanlinenM::model()->findAll(), 'bahanlinen_id', 'bahanlinen_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->dropDownListRow($model, 'jenislinen_id', CHtml::listData(JenislinenM::model()->findAll(), 'jenislinen_id', 'jenislinen_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'kodelinen', array('placeholder' => 'Kode', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'namalinen', array('placeholder' => 'Nama', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'namalainnya', array('placeholder' => 'Nama Lainnya', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
        <?php echo $form->textFieldRow($model, 'merklinen', array('placeholder' => 'Merk', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'beratlinen', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'beratlinen', array('placeholder' => 'Berat', 'class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->label($model, 'gram'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'tahunbeli', array('placeholder' => 'Tahun Beli', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 6)); ?>
        <?php echo $form->textFieldRow($model, 'warna', array('placeholder' => 'Warna', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model, 'rakpenyimpanan_id', CHtml::listData(RakpenyimpananM::model()->findAll(), 'rakpenyimpanan_id', 'rakpenyimpanan_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>

        <?php echo $form->dropDownListRow($model, 'satuanlinen', LookupM::getItems('satuanbarang'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); ?>
        <?php echo $form->textFieldRow($model, 'tglregisterlinen', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <div id="divCaraAmbilPhotoFile" style="display: block;">
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'gambarlinen', array('class' => 'control-label', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
                    <div class="controls">
                        <?php
                        $url_photopegawai = (!empty($model->gambarlinen) ? Params::urlLinenThumbs() . "kecil_" . $model->gambarlinen : Params::urlLinenThumbs() . "no_photo.jpeg");
                        ?>
                        <?php echo $form->hiddenField($model, 'tempPhoto', array('readonly' => TRUE, 'value' => '.jpg')); ?>
                        <?php echo Chtml::activeFileField($model, 'gambarlinen', array('maxlength' => 254, 'Hint' => 'Isi Jika Akan Menambahkan Logo', 'class' => 'fileupload-new', 'value' => $model->gambarlinen)); ?>
                    </div>
                </div>
                <div class="control-group" style="padding-left:29.5%;">
                    <div class="controls">
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; line-height: 20px;"><img src="<?php echo $url_photopegawai; ?>" /></div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'jmlcucilinen', array('placeholder' => 'Jumlah Cuci', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

        <div class="control-group">
            <?php echo CHtml::label("", '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'linen_aktif') . ' <label for="SALinenM_linen_aktif">Linen Aktif</label>'; ?>
            </div>
        </div>
    </div>

</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'title' => 'Ulang', 
            'class' => 'btn btn-default',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Linen', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_tips . 'tipsaddedit3a', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBarang',
    'options' => array(
        'title' => 'Daftar Barang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1000,
        'height' => 570,
        'resizable' => false,
    ),
));

$modBarang = new BarangM('search');
$modBarang->unsetAttributes();
if (isset($_GET['BarangM'])) {
    $modBarang->attributes = $_GET['BarangM'];
    $modBarang->kelompok_id = $_GET['BarangM']['kelompok_id'];
    $modBarang->subkelompok_id = $_GET['BarangM']['subkelompok_id'];
    $modBarang->subsubkelompok_id = $_GET['BarangM']['subsubkelompok_id'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barang-t-grid',
    'dataProvider' => $modBarang->searchBarang(),
    'filter' => $modBarang,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectBarang",
				"onClick" => "
					$(\"#' . CHtml::activeId($model, 'barang_id') . '\").val(\'$data->barang_id\');
                                        $(\"#' . CHtml::activeId($model, 'barang_nama') . '\").val(\'$data->barang_nama\');                                           
					$(\'#dialogBarang\').dialog(\'close\');
					return false;"))',
        ),
        array(
            'name' => 'barang_id',
            'value' => '$data->barang_id',
            'filter' => false,
        ),
        array(
            'name' => 'kelompok_id',
            'type' => 'raw',
            'value' => function ($data) {
                $kel = SubsubkelompokM::model()->findByPk($data->subsubkelompok_id);
                return empty($kel->subsubkelompok_id) ? "-" : $kel->subkelompok->kelompok->kelompok_nama;
            },
            'filter' =>  CHtml::activeDropDownList(
                $modBarang,
                'kelompok_id',
                CHtml::listData(KelompokM::model()->findAll(array(
                    'condition' => 'kelompok_aktif = true',
                    'order' => 'kelompok_nama'
                )), 'kelompok_id', 'kelompok_nama'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'name' => 'subkelompok_id',
            'type' => 'raw',
            'value' => function ($data) {
                $kel = SubsubkelompokM::model()->findByPk($data->subsubkelompok_id);
                return empty($kel->subsubkelompok_id) ? "-" : $kel->subkelompok->subkelompok_nama;
            },
            'filter' =>  CHtml::activeDropDownList(
                $modBarang,
                'subkelompok_id',
                CHtml::listData(SubkelompokM::model()->findAll(array(
                    'condition' => 'subkelompok_aktif = true',
                    'order' => 'subkelompok_nama'
                )), 'subkelompok_id', 'subkelompok_nama'),
                array('empty' => '-- Pilih --')
            ),
        ),
        array(
            'name' => 'subsubkelompok_id',
            'type' => 'raw',
            'value' => function ($data) {
                $kel = SubsubkelompokM::model()->findByPk($data->subsubkelompok_id);
                return empty($kel->subsubkelompok_id) ? "-" : $kel->subsubkelompok_nama;
            },
            'filter' =>  CHtml::activeDropDownList(
                $modBarang,
                'subsubkelompok_id',
                CHtml::listData(SubsubkelompokM::model()->findAll(array(
                    'condition' => 'subsubkelompok_aktif = true',
                    'order' => 'subsubkelompok_nama'
                )), 'subsubkelompok_id', 'subsubkelompok_nama'),
                array('empty' => '-- Pilih --')
            ),
        ),
        //'golongan_nama',
        //'kelompok_nama',
        //'subkelompok_nama',
        //'subsubkelompok_nama',
        'barang_nama',
        array(
            'name' => 'barang_satuan',
            'filter' => CHtml::dropDownList('BarangM[barang_satuan]', $modBarang->barang_satuan, LookupM::getItems('satuanbarang'), array('empty' => '-- Pilih --')),
            'value' => '$data->barang_satuan',
        ),
        'barang_ukuran',
        'barang_bahan',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>

<script type="text/javascript">
    function namaLain(nama) {
        document.getElementById('SALinenM_namalainnya').value = nama.value.toUpperCase();
    }
</script>