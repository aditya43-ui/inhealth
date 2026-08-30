<?php
$oa = ObatpartografT::model()->findAllByAttributes(array(
    'kesejahteraanibu_id' => $model->kesejahteraanibu_id,
    ));
?>
<div class="panel panel-success form_pilih_oa">
    <div class="panel-heading">
        <div class="panel-title"><?php echo CHtml::checkBox('is_obat', count($oa) > 0, array('id'=>'is_obat', 'uncheckValue'=>null)); ?> Obat dan Cairan IV</div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <label class="control-label">Obat dan Cairan IV</label>
            <div class="controls">
                <?php echo CHtml::htmlButton('+ Tambah Obat', array('class' => 'btn btn-success', 'onclick' => 'setPilihObat();')); ?>
            </div>
        </div>
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Obat/Cairan IV</th>
                    <th width="70">Qty</th>
                    <th width="70">Hapus</th>
                </tr>
            </thead>
            <tbody class="tab_obat">
                    <?php
                    if (count($oa) > 0) {
                        foreach ($oa as $item) {
                            echo $this->renderPartial($this->path_view.'form._rowObat', array('model'=>$item), true);
                        }
                    }
                    
                    ?>
            </tbody>
        </table>
    </div>
</div>


<?php
//========= Dialog buat cari data Obat =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogObatPersalinan',
    'options' => array(
        'title' => 'Pencarian Obat',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

$modObat = new PSObatAlkesM;
$modObat->unsetAttributes();
$modObat->pendaftaran_id = $pendaftaran_id;
if (isset($_GET['PSObatAlkesM'])) {
    $modObat->attributes = $_GET['PSObatAlkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-grid',
    'dataProvider' => $modObat->searchDialogPasien(),
    'filter' => $modObat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                            setObatAuto($data->obatalkes_id);
									"))',
        ),
        array(
            'header' => 'Kode',
            'name' => 'obatalkes_kode',
            'value' => '$data->obatalkes_kode',
        ),
        array(
            'header' => 'Nama',
            'name' => 'obatalkes_nama',
            'value' => '$data->obatalkes_nama',
        ),
        array(
            'header' => 'Satuan Kecil',
            'filter' => CHtml::activeDropDownList($modObat, 'satuankecil_id', CHtml::listData(SatuankecilM::model()->findAll(" satuankecil_aktif = TRUE ORDER BY satuankecil_nama ASC "), 'satuankecil_id', 'satuankecil_nama'), array('empty' => '-- Pilih --')),
            'value' => '(!empty($data->satuankecil_id)?$data->satuankecil->satuankecil_nama:"")'
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//========= end Obat dialog =============================
?> 

<script>
    
    function setPilihObat() {
        $("#dialogObatPersalinan").dialog('open');
    }
    
    function setObatAuto(id) {
        
        var is_ada = false;
        $(".tab_obatalkes_id").each(function() {
            if ($(this).val() == id) {
                is_ada = true;
            }
        });
        
        if(is_ada) {
            myAlert("Obat sudah dipilih sebelumnya");
            return false;
        }
        
        $("#dialogObatPersalinan").dialog('close');
        $.post('<?php echo $this->createUrl('tambahObat'); ?>', {id: id}, function(data) {
            $(".tab_obat").append(data.html);
            var last = $(".tab_obat tr:last-child");
            
            $(last).find(".integer").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
        }, 'json');
    }
    
    function setCeklisPilihObat() {
        if ($("#is_obat").is(":checked")) {
            $(".form_pilih_oa .panel-body").show();
        } else {
            $(".form_pilih_oa .panel-body").hide();
            $(".tab_obat").empty();
        }
    }
    
    $(document).ready(function() {
        $("#is_obat").on("click", setCeklisPilihObat);
        setCeklisPilihObat();
    });
    
</script>