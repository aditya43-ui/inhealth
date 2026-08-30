<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sajenis-anastesi-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->hiddenField($model, 'barang_id', array('id' => 'barang_id')); ?>
        <div class="control-group">
            <label class='control-label'>Barang</label>
            <div class="controls">
                <?php

                $barang = new BarangM;
                if (!empty($model->barang_id)) {
                    $barang = BarangM::model()->findByPk($model->barang_id);
                }

                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'namaBarang',
                    'value' => $barang->barang_nama,
                    'source' => 'js: function(request, response) {
							$.ajax({
								url: "' . Yii::app()->createUrl('ActionAutoComplete/barang') . '",
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
								$("#barang_id").val(ui.item.barang_id);  
                                                                $("#namaBarang").val(ui.item.barang_nama); 
								return false;
							}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Nama Barang',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3 custom-only',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogBarang'),
                ));
                ?>
            </div>

        </div>
    </div>
    <div class="col-sm-6">
        <?php echo $form->hiddenField($model, 'peralatansterilisasi_id', array('id' => 'peralatansterilisasi_id')); ?>
        <div class="control-group">
            <label class='control-label'>Peralatan Sterilisasi</label>
            <div class="controls">
                <?php

                $alat = new PeralatansterilisasiM;
                if (!empty($model->peralatansterilisasi_id)) {
                    $alat = PeralatansterilisasiM::model()->findByPk($model->peralatansterilisasi_id);
                }

                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'namaPeralatan',
                    'value' => $alat->peralatansterilisasi_nama,
                    'source' => 'js: function(request, response) {
							$.ajax({
								url: "' . $this->createUrl('AutoCompletePeralatansterilisasi') . '",
							
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
								$("#peralatansterilisasi_id").val(ui.item.peralatansterilisasi_id);  
                                                                $("#namaPeralatan").val(ui.item.peralatansterilisasi_nama); 
								return false;
							}',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Nama Peralatan Steriliasi',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'span3 custom-only',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogSterilisasi'),
                ));
                ?>
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
        Yii::t('mds', '{icon} Pengaturan Sterilisasi Barang ', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_tips . 'transaksi', array(), true);
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
        'width' => 750,
        'height' => 500,
        'resizable' => true,
    ),
));

$modBarang = new SABarangM('searchDialog');
$modBarang->unsetAttributes();
if (Yii::app()->session['modul_id'] == 87) { //modul strerilisasi RSPMC-723
    $modBarang->jenisbarang_id = 44; // 44 -> STERILISATOR
}

if (isset($_GET['SABarangM']))
    $modBarang->attributes = $_GET['SABarangM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barang-m-grid',
    'dataProvider' => $modBarang->searchDialog(),
    'filter' => $modBarang,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'barang_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBarang",
                                    "onClick" => "
                                        
                                        $(\'#barang_id\').val(\'$data->barang_id\');
                                        $(\'#namaBarang\').val(\'$data->barang_nama\');
                                        $(\'#dialogBarang\').dialog(\'close\');
                                        return false;"))',
        ),
        array(
            'name' => 'jenisbarang_id',
            'type' => 'raw',
            'value' => 'isset($data->jenisbarang_id)?$data->jenisbarangs->jenisbarang_nama:""',
            'filter' => CHtml::activeDropDownList($modBarang, 'jenisbarang_id', CHtml::listData(JenisbarangM::model()->findAll("jenisbarang_aktif = TRUE ORDER BY jenisbarang_nama ASC"), 'jenisbarang_id', 'jenisbarang_nama'), array('empty' => '-- Pilih --')),
        ),
        array(
            'name' => 'barang_id',
            'value' => '$data->barang_id',
            'filter' => false,
        ),
        //        'bidang.subkelompok.kelompok.golongan.golongan_nama',
        //        'bidang.subkelompok.kelompok.kelompok_nama',
        //        'bidang.subkelompok.subkelompok_nama',
        //        'bidang.bidang_nama',
        //        'bidang_id',
        //        'barang_type',
        //        'barang_kode',
        'barang_nama',
        //        'barang_satuan',
        array(
            'name' => 'barang_satuan',
            'filter' => LookupM::getItems('satuanbarang'),
            'value' => '$data->barang_satuan',
        ),
        'barang_ukuran',
        'barang_bahan',
        //        'barang_namalainnya',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogSterilisasi',
    'options' => array(
        'title' => 'Daftar Sterilisasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => true,
    ),
));

$modSterilisasi = new SAPeralatansterilisasiM('searchDialogBarang');
$modSterilisasi->unsetAttributes();
if (isset($_GET['SAPeralatansterilisasiM'])) {
    $modSterilisasi->attributes = $_GET['SAPeralatansterilisasiM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'sterilisasi-m-grid',
    'dataProvider' => $modSterilisasi->searchDialogBarang(),
    'filter' => $modSterilisasi,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'barang_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBarang",
                                    "onClick" => "
                                        
                                        $(\'#peralatansterilisasi_id\').val(\'$data->peralatansterilisasi_id\');
                                        $(\'#namaPeralatan\').val(\'$data->peralatansterilisasi_nama\');
                                        $(\'#dialogSterilisasi\').dialog(\'close\');
                                        return false;"))',
        ),

        'peralatansterilisasi_nama',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>