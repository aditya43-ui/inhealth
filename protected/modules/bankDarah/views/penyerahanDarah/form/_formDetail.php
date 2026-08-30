<div class="overflow-x">
    <table class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th>Pilih</th>
                <th>No. Kantong Darah</th>
            </tr>
        </thead>
        <tbody id="tab_penyerahan">
            <?php 

            foreach ($penyiapan as $row => $detail): 

                $item = UjikompatibilitasT::model()->findByPk($detail->ujikompatibilitas_id);                
                echo $this->renderPartial($this->path_view."form/_rowPenyerahanDetail", array(                    
                    'model'=>$model,
                    'item'=>$item,
                    'row'=>$row,
                    'detail'=>$detail,                    
                ), true);                                                  

            endforeach; ?>
        </tbody>
    </table>
</div>
<div class="clear"></div>
<div class="col-sm-12">
    <div class="control-group">
        <label class="control-label">Petugas Yang Menerima <span class="required">*</span></label>
        <div class="controls">
            <?php 
                echo CHtml::activeHiddenField($model, 'peg_ygmenyerahkan_id',array('readonly'=>true, 'class'=>'required'));
                echo CHtml::activeTextField($model, 'peg_ygmenyerahkan_nama',array('readonly'=>true, 'class'=>'required'));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Tanggal Terima <span class="required">*</span></label>
        <div class="controls">
            <?php 
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tglpenyerahan',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array(                        
                        'readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Transporter Darah <span class="required">*</span></label>
        <div class="controls">
            <?php 
               echo CHtml::activeTextField($model, 'peg_transporter',array('readonly'=>true,'class'=>'required'));
            ?>
        </div>
    </div>
</div>

<script>
var idx = null;

function setDialogPetugas(id, dialog_id) {
    idx = id;
    
    $("#" + dialog_id).dialog("open");
}

function setPetugasVerifikator(data) {
    $("#tab_penyerahan tr").eq(idx).find(".peg_vetifikator_id").val(data.pegawai_id);
    $("#tab_penyerahan tr").eq(idx).find(".peg_vetifikator_nama").val(data.nama_pegawai).blur();
    
    $("#dialogPetugasVerifikator").dialog("close");
    $("#alamatpasien").blur();
}

function setPetugasMenyerahkan(data) {
    $("#tab_penyerahan tr").eq(idx).find(".peg_ygmenyerahkan_id").val(data.pegawai_id);
    $("#tab_penyerahan tr").eq(idx).find(".peg_ygmenyerahkan_nama").val(data.nama_pegawai).blur();
    
    $("#dialogPetugasMenyerahkan").dialog("close");
    $("#alamatpasien").blur();
}

function setPetugasTransporter(data) {
    $("#tab_penyerahan tr").eq(idx).find(".peg_transporter_id").val(data.pegawai_id);
    $("#tab_penyerahan tr").eq(idx).find(".peg_transporter_nama").val(data.nama_pegawai);
    
    $("#dialogPetugasTransporter").dialog("close");
    $("#alamatpasien").blur();
}

</script>

<?php
//========= Dialog buat cari Petugas Verifikator =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugasVerifikator',
    'options' => array(
        'title' => 'Daftar Petugas Verifikator',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modPegawai = new BDPegawaiM('search');
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');

if (isset($_GET['BDPegawaiM']))
    $modPegawai->attributes = $_GET['BDPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugasverifikator-grid',
    'dataProvider' => $modPegawai->searchDialogPenyerahanDarah(),
    'filter' => $modPegawai,
    'template' => "{items}\n{pager}",
//    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectBahan",
                "onClick" => "
                    setPetugasVerifikator(".CJSON::encode($data->attributes).");
                    return false;"))',
        ),
        'nama_pegawai',
        'nomorindukpegawai',
        'alamat_pegawai',
        'agama',
        array(
            'name' => 'jeniskelamin',
            'filter' => LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>


<?php
//========= Dialog buat Petugas yang Menyerahkan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugasMenyerahkan',
    'options' => array(
        'title' => 'Daftar Petugas Menyerahkan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modPegawai = new BDPegawaiM('search');
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');

if (isset($_GET['BDPegawaiM']))
    $modPegawai->attributes = $_GET['BDPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugasmenyerahkan-grid',
    'dataProvider' => $modPegawai->searchDialogPenyerahanDarah(),
    'filter' => $modPegawai,
    'template' => "{items}\n{pager}",
//    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectBahan",
                "onClick" => "
                    setPetugasMenyerahkan(".CJSON::encode($data->attributes).");
                    return false;"))',
        ),
        'nama_pegawai',
        'nomorindukpegawai',
        'alamat_pegawai',
        'agama',
        array(
            'name' => 'jeniskelamin',
            'filter' => LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat Petugas Transporter =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPetugasTransporter',
    'options' => array(
        'title' => 'Daftar Petugas Transporter',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modPegawai = new BDPegawaiM('search');
$modPegawai->unsetAttributes();
$modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');

if (isset($_GET['BDPegawaiM']))
    $modPegawai->attributes = $_GET['BDPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'petugastransporter-grid',
    'dataProvider' => $modPegawai->searchDialogPenyerahanDarah(),
    'filter' => $modPegawai,
    'template' => "{items}\n{pager}",
//    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        ////'pegawai_id',
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectBahan",
                "onClick" => "
                    setPetugasTransporter(".CJSON::encode($data->attributes).");
                    return false;"))',
        ),
        'nama_pegawai',
        'nomorindukpegawai',
        'alamat_pegawai',
        'agama',
        array(
            'name' => 'jeniskelamin',
            'filter' => LookupM::getItems('jeniskelamin'),
            'value' => '$data->jeniskelamin',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>