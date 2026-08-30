<div class = "col-sm-6">
    <?php echo CHtml::hiddenField('supplier_id',"", array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo CHtml::hiddenField('permintaanpembelian_id',$modPermintaanPembelian->permintaanpembelian_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>

    <?php echo $form->textFieldRow($modPermintaanPembelian,'nopermintaan',array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <div class="control-group ">
        <?php echo $form->labelEx($modPermintaanPembelian,'tglpermintaanpembelian', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php
                $modPermintaanPembelian->tglpermintaanpembelian = (!empty($modPermintaanPembelian->tglpermintaanpembelian) ? date("d/m/Y H:i:s",strtotime($modPermintaanPembelian->tglpermintaanpembelian)) : null);
                $this->widget('MyDateTimePicker',array(
                    'model'=>$modPermintaanPembelian,
                    'attribute'=>'tglpermintaanpembelian',
                    'mode'=>'datetime',
                    'options'=> array(
    //                                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                            'maxDate' => 'd',
                            'yearRange'=> "-150:+0",
                    ),
                    'htmlOptions'=>array('readonly'=>true,'placeholder'=>'00/00/0000 00:00:00','class'=>'span3 dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                    ),
            )); ?>
        </div>
    </div>
    <div class="control-group " hidden>
        <?php echo Chtml::label("Supplier <font style = 'color:red'>*</font>", 'supplier_id', array('class' => 'control-label required')); ?>
        <div class="controls" >
            <?php echo $form->hiddenField($modPermintaanPembelian, 'supplier_id',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php
            $this->widget('MyJuiAutoComplete', array(
                    'model'=>$modPermintaanPembelian,
                    'attribute' => 'supplier_nama',
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                    url: "' . $this->createUrl('AutoCompleteSupplier') . '",
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
                                                                            refreshDialogOA();
                                    return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                    $("#'.Chtml::activeId($modPermintaanPembelian, 'supplier_id') . '").val(ui.item.supplier_id);
                                    $("#'.Chtml::activeId($modPermintaanPembelian, 'supplier_alamat') . '").val(ui.item.supplier_alamat);
                                    return false;
                            }',
                    ),
                    'htmlOptions' => array(
                            'class'=>'span3',
                            'onkeyup'=>"return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#'.Chtml::activeId($modPermintaanPembelian, 'supplier_id') . '").val(""); '
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogSupplier'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo $form->labelEx($modPermintaanPembelian,'tgldikirim', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php
                $modPermintaanPembelian->tgldikirim = (!empty($modPermintaanPembelian->tgldikirim) ? date("d/m/Y H:i:s",strtotime($modPermintaanPembelian->tgldikirim)) : null);
                $this->widget('MyDateTimePicker',array(
                    'model'=>$modPermintaanPembelian,
                    'attribute'=>'tgldikirim',
                    'mode'=>'datetime',
                    'options'=> array(
    //                                            'dateFormat'=>Params::DATE_FORMAT,
                            'showOn' => false,
                            'maxDate' => 'd',
                            'yearRange'=> "-150:+0",
                    ),
                    'htmlOptions'=>array('readonly'=>true, 'placeholder'=>'00/00/0000 00:00:00','class'=>'span3 dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                    ),
            )); ?>
        </div>
    </div>
    <?php echo $form->textAreaRow($modPermintaanPembelian,'alamatpengiriman',array('placeholder'=>'Alamat Pengirim','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    <?php echo $form->textFieldRow($modPermintaanPembelian,'noreferensi',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
</div>
<div class = "col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("Jenis PPh","pajak_id",array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($modPermintaanPembelian,'pajak_id',
                    CHtml::listData(PajakM::model()->findAll('pajak_aktif = true AND ispajakpegawai = false AND isppnkeluaran = false ORDER BY pajak_nama ASC'), 'pajak_id', 'pajak_nama'),
                    array('class'=>'span2', 'onkeyup'=>"return $(this).focusNextInputField(event)",
                    'empty'=>'-- Pilih --',)); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo CHtml::label("Pegawai Pemesan <font style = 'color:red'>*</font>", 'pegawai_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($modPermintaanPembelian, 'pegawaiapoteker_id',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->hiddenField($modPermintaanPembelian, 'pegawai_id',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textField($modPermintaanPembelian, 'pegawai_nama', array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo CHtml::label("Manager Umum <font style = 'color:red'>*</font>", 'pegawaimengetahuiumum_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($modPermintaanPembelian, 'pegawaimengetahuiumum_id',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textField($modPermintaanPembelian, 'pegawaimengetahuiumum_nama', array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo CHtml::label("Manager Keuangan <font style = 'color:red'>*</font>", 'pegawaimengetahui_id', array('class' => 'control-label')); ?>
        <div class="controls">
                <?php echo $form->hiddenField($modPermintaanPembelian, 'pegawaimengetahui_id',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                <?php echo $form->textField($modPermintaanPembelian, 'pegawaimengetahui_nama', array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo Chtml::label("Direktur <font style = 'color:red'>*</font>", 'pegawaimenyetujui_id', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($modPermintaanPembelian, 'pegawaimenyetujui_id',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->textField($modPermintaanPembelian, 'pegawaimenyetujui_nama', array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="control-group ">
        <?php echo $form->labelEx($modPermintaanPembelian,'keteranganpermintaan', array('class'=>'control-label','label'=>'Keterangan')) ?>
        <div class="controls">
            <?php echo $form->textArea($modPermintaanPembelian,'keteranganpermintaan',array('placeholder'=>'Keterangan','class'=>'span3')); ?>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMengetahui',
    'options'=>array(
        'title'=>'Pencarian Pegawai Purchasing',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiMengetahui = new PegawairuanganV('search');
$modPegawaiMengetahui->unsetAttributes();
$modPegawaiMengetahui->ruangan_id = Params::RUANGAN_ID_GUDANG_UMUM;
if(isset($_GET['PegawairuanganV'])) {
    $modPegawaiMengetahui->attributes = $_GET['PegawairuanganV'];
}

$prov = $modPegawaiMengetahui->search();
$prov->sort->defaultOrder = 'nama_pegawai';

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimengetahui-grid',
	'dataProvider'=>$prov,
	'filter'=>$modPegawaiMengetahui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($modPermintaanPembelian,'pegawaimengetahui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modPermintaanPembelian,'pegawaimengetahui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMengetahui\").dialog(\"close\");
                                                  return false;
                                        "))',
                ),
                 array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                    'filter'=>Chtml::activeTextField($modPegawaiMengetahui, 'nomorindukpegawai', array('class' => 'numbers-only'))
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai'),
                    'value'=>'$data->namaLengkap',
                    'filter'=>Chtml::activeTextField($modPegawaiMengetahui, 'nama_pegawai', array('class' => 'hurufs-only'))
                ),
                 array(
                    'header'=>'Jabatan',
                    'name' => 'jabatan_id',
                    'filter'=>  CHtml::activeDropDownList($modPegawaiMengetahui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif  = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
                    'value'=> function($data){
                        $j = JabatanM::model()->findByPk($data->jabatan_id);

                        if (!empty($j)){
                            return $j->jabatan_nama;
                        }else{
                            return '-';
                        }
                    }
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
                   jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '         $(".numbers-only").keyup(function(){setNumbersOnly(this);});$(".hurufs-only").keyup(function(){setHurufsOnly(this);});}',
        ));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>

<?php
//========= Dialog buat cari data Pegawai Menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawaiMenyetujui',
    'options'=>array(
        'title'=>'Pencarian Penanggung Jawab Penunjang',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modPegawaiMenyetujui = new PegawaiM('search');
$modPegawaiMenyetujui->unsetAttributes();
$modPegawaiMenyetujui->pegawai_aktif = true;
$modPegawaiMenyetujui->unitkerja_id = array(Params::UNITKERJA_ID_PELAYANAN_MEDIS, Params::UNITKERJA_ID_PENUNJANG_MEDIS);
if(isset($_GET['PegawaiM'])) {
    $modPegawaiMenyetujui->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'pegawaimenyetujui-grid',
	'dataProvider'=>$modPegawaiMenyetujui->search(),
	'filter'=>$modPegawaiMenyetujui,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small",
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "
                                                  $(\"#'.CHtml::activeId($modPermintaanPembelian,'pegawaimenyetujui_id').'\").val(\"$data->pegawai_id\");
                                                  $(\"#'.CHtml::activeId($modPermintaanPembelian,'pegawaimenyetujui_nama').'\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawaiMenyetujui\").dialog(\"close\");
                                                  return false;
                                        "))',
                ),
                 array(
                    'header'=>'NIP',
                    'value'=>'$data->nomorindukpegawai',
                    'filter'=>Chtml::activeTextField($modPegawaiMenyetujui, 'nomorindukpegawai', array('class' => 'numbers-only'))
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'filter'=>  CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
                    'value'=>'$data->namaLengkap',
                    'filter'=>Chtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai', array('class' => 'hurufs-only'))
                ),
                 array(
                    'header'=>'Jabatan',
                    'name' => 'jabatan_id',
                    'filter'=>  CHtml::activeDropDownList($modPegawaiMenyetujui, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif  = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
                     'value'=> function($data){
                        $j = JabatanM::model()->findByPk($data->jabatan_id);
                        if (!empty($j)){
                            return $j->jabatan_nama;
                        }else{
                            return '-';
                        }
                    }
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
                   jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '         $(".numbers-only").keyup(function(){setNumbersOnly(this);});$(".hurufs-only").keyup(function(){setHurufsOnly(this);});}',
        ));
$this->endWidget();
//========= end Pegawai Menyetujui dialog =============================
?>

<?php
//========= Dialog buat cari data Pegawai Menyetujui =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogSupplier',
    'options'=>array(
        'title'=>'Pencarian Supplier',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modSupplier = new SupplierM('search');
$modSupplier->unsetAttributes();
$modSupplier->supplier_aktif = true;

if (isset($_GET['SupplierM'])) {
    $modSupplier->attributes = $_GET['SupplierM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'supplier-grid',
    'dataProvider' => $modSupplier->search(),
    'filter' => $modSupplier,
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
                                                  $(\"#' . CHtml::activeId($modPermintaanPembelian, 'supplier_id') . '\").val(\"$data->supplier_id\");
                                                  $(\"#' . CHtml::activeId($modPermintaanPembelian, 'supplier_nama') . '\").val(\"$data->supplier_nama\");
                                                  $(\"#' . CHtml::activeId($modPermintaanPembelian, 'supplier_alamat') . '\").val(\"$data->supplier_alamat\");
													  refreshDialogOA();
                                                  $(\"#dialogSupplier\").dialog(\"close\");
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'Nama',
            'name' => 'supplier_nama',
            'value' => '$data->supplier_nama',
            'filter' => Chtml::activeTextField($modSupplier, 'supplier_nama', array('class' => ''))
        ),
        array(
            'header' => 'Alamat',
            'value' => '$data->supplier_alamat',
            'filter' => Chtml::activeTextField($modSupplier, 'supplier_alamat'),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
                   jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); }',
));
$this->endWidget();
//========= end Pegawai Menyetujui dialog =============================
?>
