<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kkruanestesi-add-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#lookupKruAnestesi',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
        ));
?>

<div class="row-fluid">
    <div class="control-group">
        <?php echo CHtml::label("Kru Anestesi <span class='required'>*</span> ", "", array('class' => 'control-label', 'style' => 'float:left;padding:10px;')) ?>
        <div class="controls">
            <?php echo CHtml::dropDownList("lookupKruAnestesi", '', LookupM::getItemsUrutan('kruanestesi'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onchange' => 'gantiKru(this)')); ?>
        </div>

        <div class="controls">
            <?php
            echo CHtml::link("<i class='" . MyIcon::getIcons('tambah-baris') . "'></i>", "javascript:;", array(
                'class' => 'btn btn-primary',
                'style' => 'color:#fff; padding : 8px;',
                'onclick' => "tambahLookup()",
                'rel' => 'tooltip',
                'title' => 'Klik untuk menambah kru Anestesi yang lain '));
            ?>
        </div>
    </div>	

    <div class="clear"></div>

    <?php echo CHtml::hiddenField("kruAnestesiId", '', array('readonly' => true)) ?>
    <div class="control-group" id="pegawai">
        <?php echo CHtml::label("Nama Pegawai <span class='required'>*</span> ", "", array('class' => 'control-label', 'style' => 'float:left;padding:10px;')) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'kruAnestesiNama',
                'value' => '',
                'sourceUrl' => $this->createUrl('/anestesi/rencanaAnestesi/pegawaiRuangan'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.label);
                                    return false;
                                }',
                    'select' => 'js:function( event, ui ) {
                                    $("#kruAnestesiId").val( ui.item.value );																		
                                    return false;
                                }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogPegawai1'),
                'htmlOptions' => array('class' => 'span3',)
            ));
            ?>
        </div>
    </div>	

    <div class="control-group" id="ppds" style="display:none">
        <?php echo CHtml::label("Nama PPDS <span class='required'>*</span> ", "", array('class' => 'control-label', 'style' => 'float:left;padding:10px;')) ?>
        <div class="controls">
            <?php
            $this->widget('MyJuiAutoComplete', array(
                'name' => 'kruAnestesiNama2',
                'value' => '',
                'sourceUrl' => $this->createUrl('/anestesi/rencanaAnestesi/ppds'),
                'options' => array(
                    'showAnim' => 'fold',
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.label);
                                    return false;
                                }',
                    'select' => 'js:function( event, ui ) {
                                    $("#kruAnestesiId").val( ui.item.value );																		
                                    return false;
                                }',
                ),
                'tombolDialog' => array('idDialog' => 'dialogPegawai2'),
                'htmlOptions' => array('class' => 'span3',)
            ));
            ?>
        </div>
    </div>	
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Tambah', array('{icon}' => '<i class="' . MyIcon::getIcons('tambah-baris') . '"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'simpanKruPegawai();')); //,'onKeypress'=>'return formSubmit(this,event)' 
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai1',
    'options' => array(
        'title' => 'Pencarian Data Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPegawai1 = new PegawairuanganV('search');
$modPegawai1->unsetAttributes();
if (isset($_GET['PegawairuanganV'])) {
    $modPegawai1->attributes = $_GET['PegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-1-grid',
    'dataProvider' => $modPegawai1->searchDialogPegRuangan(),
    'filter' => $modPegawai1,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectAmbulans",
                    "onClick" => "
                        $(\"#kruAnestesiId\").val(\"$data->pegawai_id\");
                        $(\"#kruAnestesiNama\").val(\"$data->nama_pegawai\");
                        $(\"#dialogPegawai1\").dialog(\"close\");
                "))',
        ),
        'nomorindukpegawai',
        'nama_pegawai'
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        }',
));
$this->endWidget();
?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai2',
    'options' => array(
        'title' => 'Pencarian Data PPDS',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPpds= new PpdsM('searchPPDSPelayanan');
$modPpds->unsetAttributes();
if (isset($_GET['PpdsM'])) {
    $modPpds->attributes = $_GET['PpdsM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-2-grid',
    'dataProvider' => $modPpds->searchPPDSPelayanan(),
    'filter' => $modPpds,
    'template' => "{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectAmbulans",
                    "onClick" => "
                        $(\"#kruAnestesiId\").val(\"$data->ppds_id\");
                        $(\"#kruAnestesiNama2\").val(\"$data->ppds_nama\");
                        $(\"#dialogPegawai2\").dialog(\"close\");
                "))',
        ),
        'ppds_nama',
        'ppds_nim',
        'ppds_nik',
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
        }',
));
$this->endWidget();
?>


<script>
    /**
     * Ganti Pengambilan data krubedah
     * @param {type} obj
     * @returns {undefined}
     */
    function gantiKru(obj) {
        var x = document.getElementById("ppds");
        var y = document.getElementById("pegawai");
        var a = document.getElementById("kruAnestesiId");
        var b = document.getElementById("kruAnestesiNama");
        var c = document.getElementById("kruAnestesiNama2");
        if (obj.value == 'PPDS Anastesiologi') {
            if (x.style.display === "none") {
                x.style.display = "block";
                y.style.display = "none";
                a.value = '';
                b.value = '';
                c.value = '';
            } else {
                x.style.display = "none";
                y.style.display = "block";
                a.value = '';
                b.value = '';
                c.value = '';
            }
        } else {
            if (x.style.display === "block") {
                x.style.display = "none";
                y.style.display = "block";
                a.value = '';
                b.value = '';
                c.value = '';
            }
        }
    }
</script>
