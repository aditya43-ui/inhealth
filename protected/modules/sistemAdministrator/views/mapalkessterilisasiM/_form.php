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
        <div class="control-group">
            <?php echo CHtml::label('Alkes', 'obatalkes_nama', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $oa = new ObatalkesM;
                if (!empty($model->obatalkes_id)) {
                    $oa = ObatalkesM::model()->findByPk($model->obatalkes_id);
                }

                $this->widget('MyJuiAutoComplete', array(
                    'name' => 'obatalkes_nama',
                    'value' => $oa->obatalkes_nama,
                    'source' => 'js: function(request, response) {
                                    $.ajax({
                                    url: "' . $this->createUrl('AutocompleteObatAlkes') . '",
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
                        $(this).val("");
                        return false;
                    }',
                        'select' => 'js:function( event, ui ) {
                        $(this).val(ui.item.value);
                        $("#obatalkes_id").val(ui.item.obatalkes_id);
                        $("#obatalkes_nama").val(ui.item.obatalkes_nama);
                        return false;
                    }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span3',
                        'placeholder' => 'Nama Alkes',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'onblur' => 'if(this.value === "") $("#obatalkes_id").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogObatAlkes'),
                ));
                ?>
                <?php echo $form->hiddenField($model, 'obatalkes_id', array('id' => 'obatalkes_id')); ?>
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
                        'placeholder' => 'Nama Peralatan Sterilisasi',
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
        Yii::t('mds', '{icon} Pengaturan Sterilisasi Alkes ', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
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
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogObatAlkes',
    'options' => array(
        'title' => 'Daftar Stok',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'resizable' => true,
    ),
));
$modObatAlkes = new ObatalkesM('searchDataObat');
$modObatAlkes->unsetAttributes();
//$modObatAlkes = $model->ruangan_id;
if (isset($_GET['ObatalkesM'])) {
    $modObatAlkes->attributes = $_GET['ObatalkesM'];
    //$modObatAlkes->jenisobatalkes_nama = isset($_GET['GFObatalkesM']['jenisobatalkes_nama'])?$_GET['GFObatalkesM']['jenisobatalkes_nama']:null;
    //$modObatAlkes->satuankecil_nama = isset($_GET['GFObatalkesM']['satuankecil_nama'])?$_GET['GFObatalkesM']['satuankecil_nama']:null;
    // $modObatAlkes->ruangan_id = $_GET['GFPesanobatalkesT']['ruangan_id'];
    //$_GET['GFPesanobatalkesT']['ruangan_id'] = $_GET['GFInfostokobatalkesruanganV']['ruangan_id'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $modObatAlkes->searchObatFarmasi(),
    'filter' => $modObatAlkes,
    // 'template'=>"{items}\n{pager}",
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            /*'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'#obatalkes_id\').val($data->obatalkes_id);
                                        $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#jenisobatalkes_nama\').val(\'$data->jenisobatalkes_nama\');
                                        $(\'#tglkadaluarsa\').val(\'$data->tglkadaluarsa\');
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;"
                                        ))',*/
            'value' => function ($data) use (&$modObatAlkes) {
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array(
                    "class" => "btn-small",
                    "id" => "selectObat",
                    "onClick" => '
                                        $(\'#obatalkes_id\').val("' . $data->obatalkes_id . '");
                                        $(\'#obatalkes_nama\').val("' . $data->obatalkes_nama . '");
                                   
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;'
                ));
            }
        ),

        array(
            'name' => 'jenisobatalkes_id',
            'type' => 'raw',
            'value' => function ($data) {
                return empty($data->jenisobatalkes_id) ? "" : $data->jenisobatalkes->jenisobatalkes_nama;
            },
            'filter' =>  CHtml::activeHiddenField($modObatAlkes, 'instalasi_id', array('class' => 'dialog_instalasi_id')) . CHtml::activeHiddenField($modObatAlkes, 'ruangan_id', array('class' => 'dialog_ruangan_id')) . CHtml::activeDropDownList($modObatAlkes, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll("jenisobatalkes_aktif = TRUE ORDER BY jenisobatalkes_nama ASC"), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty' => '-- Pilih --')),
        ),
        array(
            'name' => 'obatalkes_golongan',
            'type' => 'raw',
            'value' => '$data->obatalkes_golongan',
            'filter' => CHtml::activeDropDownList($modObatAlkes, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty' => '-- Pilih --')),
        ),
        array(
            'name' => 'obatalkes_kategori',
            'type' => 'raw',
            'value' => '$data->obatalkes_kategori',
            'filter' => CHtml::activeDropDownList($modObatAlkes, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty' => '-- Pilih --')),
        ),
        'obatalkes_nama',
        array(
            'header' => 'Jumlah Stok',
            'type' => 'raw',
            'value' => function ($data) use ($modObatAlkes) {
                return StokobatalkesT::getJumlahStok($data->obatalkes_id, $modObatAlkes->ruangan_id) . " " . $data->satuankecil->satuankecil_nama;
            },
            'htmlOptions' => array('style' => 'text-align: right;'),
        ),
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

$modSterilisasi = new SAPeralatansterilisasiM('searchDialogAlatMedis');
$modSterilisasi->unsetAttributes();
if (isset($_GET['SAPeralatansterilisasiM']))
    $modSterilisasi->attributes = $_GET['SAPeralatansterilisasiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'barang-m-grid',
    'dataProvider' => $modSterilisasi->searchDialogAlatMedis(),
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