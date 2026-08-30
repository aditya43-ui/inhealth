<?php
$instalasi = '';
$modInstalasi = InstalasiM::model()->findAllByAttributes(array('instalasi_aktif' => true), array('order' => 'instalasi_nama'));
?>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::dropDownList(
                'instalasi',
                $instalasi,
                CHtml::listData($modInstalasi, 'instalasi_id', 'instalasi_nama'),
                array(
                    'empty' => '-- Instalasi --',
                    'ajax' => array(
                        'type' => 'POST',
                        'url' =>  CController::createUrl('dynamicRuangan'),
                        'update' => '#ruangan_id2',
                    ), 'class' => 'span2'
                )
            ); ?>
            <?php echo CHtml::dropDownList(
                'ruangan_id2',
                '',
                CHtml::listData(RuanganM::model()->getRuanganByInstalasi($instalasi), 'ruangan_id', 'ruangan_nama'),
                array(
                    'empty' => '-- Ruangan --',
                    'onchange' => 'refreshDialogObatAlkes();',
                    'class' => 'span2'
                )
            ); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label('Nama Obat Alkes', 'obatalkes_nama', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::hiddenField('obatalkes_id'); ?>
            <?php echo CHtml::hiddenField('qty_stok', 0); ?>
            <?php //echo CHtml::hiddenField('satuankecil_id'); 
            ?>
            <?php //echo CHtml::hiddenField('satuankecil_nama'); 
            ?>
            <?php //echo CHtml::hiddenField('sumberdana_id'); 
            ?>
            <?php //echo CHtml::hiddenField('hargajual'); 
            ?>
            <?php //echo CHtml::hiddenField('harganetto'); 
            ?>

            <?php
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'obatalkes_nama',
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
                    'minLength' => 2,
                    'focus' => 'js:function( event, ui ) {
											$(this).val("");
											return false;
										}',
                    'select' => 'js:function( event, ui ) {
											$(this).val(ui.item.value);
											$("#obatalkes_id").val(ui.item.obatalkes_id);
											$("#qty_stok").val(ui.item.qty_stok);
											$("#satuankecil_id").val(ui.item.satuankecil_id);
											$("#satuankecil_nama").val(ui.item.satuankecil_nama);
											$("#hargajual").val(ui.item.hargajual);
											$("#harganetto").val(ui.item.harganetto);
											$("#obatalkes_nama").val(ui.item.obatalkes_nama);
											$("#sumberdana_id").val(ui.item.sumberdana_id);
											return false;
										}',
                ),
                'htmlOptions' => array(
                    'onkeyup' => "return $(this).focusNextInputField(event)",
                    "class" => "span3",
                    'placeholder' => 'Nama Obat Alkes',
                ),
                'tombolDialog' => array('idDialog' => 'dialogObatAlkes'),
            ));
            ?>
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label('Jumlah', 'qty_input', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::textField('qty_input', '1', array('readonly' => false, 'onblur' => '$("#qty").val(this.value);', 'onkeyup' => "return $(this).focusNextInputField(event)", 'class' => 'span1 integer')) ?>
            <?php echo CHtml::htmlButton(
                '<i class="icon-plus icon-white"></i>',
                array(
                    'onclick' => 'tambahObatAlkesPasien();',
                    'class' => 'btn btn-primary',
                    'onkeypress' => "tambahObatAlkesPasien();",
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan resep",
                )
            ); ?>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogObatAlkes',
    'options' => array(
        'title' => 'Obat dan Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 980,
        'height' => 600,
        'resizable' => false,
    ),
));
$modObatAlkes = new BKInfostokobatalkesruanganV('searchDialog');
$modObatAlkes->unsetAttributes();
if (isset($_GET['BKInfostokobatalkesruanganV'])) {
    $modObatAlkes->attributes = $_GET['BKInfostokobatalkesruanganV'];
    $modObatAlkes->ruangan_id = $_GET['BKInfostokobatalkesruanganV']['ruangan_id'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $modObatAlkes->searchDialog(),
    'filter' => $modObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'name' => 'jenisobatalkes_id',
            'type' => 'raw',
            'value' => '$data->jenisobatalkes_nama',
            'filter' =>  CHtml::activeTextField($modObatAlkes, 'jenisobatalkes_nama'),
        ),
        'obatalkes_nama',
        'obatalkes_kategori',
        'obatalkes_golongan',
        array(
            'name' => 'satuankecil_id',
            'type' => 'raw',
            'value' => '$data->satuankecil_nama',
            'filter' =>  CHtml::activeTextField($modObatAlkes, 'satuankecil_nama') . " " . CHtml::activeHiddenField($modObatAlkes, 'ruangan_id', array('readonly' => true)),
        ),
        //                array(
        //                    'name'=>'sumberdana_id',
        //                    'type'=>'raw',
        //                    'value'=>'$data->sumberdana->sumberdana_nama',
        //                    'filter'=>  CHtml::activeTextField($modObatAlkes, 'sumberdana_nama'),
        //                ),
        array(
            'header' => 'Harga Jual (Rp)',
            'name' => 'hargajual',
            'type' => 'raw',
            'value' => 'MyFormatter::formatNumberForPrint($data->hargajual)',
            'filter' => false,
        ),
        array(
            'header' => 'Jumlah Stok',
            'type' => 'raw',
            'value' => 'StokobatalkesT::getJumlahStok($data->obatalkes_id, $data->ruangan_id)',
            //                    'value'=>'$data->qtystok_in-$data->qtystok_out',
        ),
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'#obatalkes_id\').val($data->obatalkes_id);
                                        $(\'#qty_stok\').val(".StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState(\'ruangan_id\')).");
                                        $(\'#satuankecil_id\').val($data->satuankecil_id);
                                        $(\'#satuankecil_nama\').val(\'$data->satuankecil_nama\');
                                        $(\'#hargajual\').val($data->hargajual);
                                        $(\'#harganetto\').val($data->harganetto);
                                        $(\'#obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#sumberdana_id\').val(\'$data->sumberdana_id\');
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;"
                                        ))',
        ),


    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>