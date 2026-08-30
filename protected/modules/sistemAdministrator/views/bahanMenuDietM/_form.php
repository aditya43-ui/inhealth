<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bahan-menu-diet-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#menudiet',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>
<div class="control-label">Menu Diet <span style="color:red;">*</span>
</div>
<div class="controls">
    <?php // echo $form->textFieldRow($model,'menudiet_id'); 
    ?>
    <?php echo CHtml::ActiveHiddenField($model, 'menudiet_id', '', array('readonly' => true)) ?>
    <?php $this->widget('MyJuiAutoComplete', array(
        'name' => 'menudiet',
        'source' => 'js: function(request, response) {
                                                                       $.ajax({
                                                                           url: "' . Yii::app()->createUrl('ActionAutoComplete/MenuDiet') . '",
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
            'focus' => 'js:function( event, ui )
                                                                               {
                                                                                $(this).val(ui.item.label);
                                                                                return false;
                                                                                }',
            'select' => 'js:function( event, ui ) {
                                                                               $("#BahanMenuDietM_menudiet_id").val(ui.item.menudiet_id);
                                                                                return false;
                                                                            }',
        ),
        'htmlOptions' => array(
            'readonly' => false,
            'placeholder' => 'Menu Diet',
            'size' => 13,
        ),
        'tombolDialog' => array('idDialog' => 'dialogMenuDiet'),
    )); ?>
</div>
<div class="control-label">Bahan Makanan <span style="color:red;">*</span>
</div>
<div class="controls">
    <?php // echo $form->textFieldRow($model,'bahanmakanan_id'); 
    ?>
    <?php echo CHtml::ActiveHiddenField($model, 'bahanmakanan_id', '', array('readonly' => true)) ?>
    <?php $this->widget('MyJuiAutoComplete', array(
        'name' => 'bahanmakanan',
        'source' => 'js: function(request, response) {
                                                                       $.ajax({
                                                                           url: "' . Yii::app()->createUrl('ActionAutoComplete/BahanMakanan') . '",
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
            'focus' => 'js:function( event, ui )
                                                                               {
                                                                                $(this).val(ui.item.label);
                                                                                return false;
                                                                                }',
            'select' => 'js:function( event, ui ) {
                                                                               $("#BahanMenuDietM_bahanmakanan_id").val(ui.item.bahanmakanan_id);
                                                                                return false;
                                                                            }',
        ),
        'htmlOptions' => array(
            'readonly' => false,
            'placeholder' => 'Bahan Makanan',
            'size' => 13,
        ),
        'tombolDialog' => array('idDialog' => 'dialogBahanMakanan'),
    )); ?>
</div>
<div class="control-label">Jumlah Bahan</div>
<div class="controls">
    <?php echo $form->textField($model, 'jmlbahan', array('class' => 'span1',)); ?>
    <?php echo CHtml::textField('satuan', '', array('readonly' => true, 'class' => 'span2'))  ?>
</div>
<div class="controls">
    <?php echo CHtml::htmlButton(
        '<i class="icon-plus icon-white"></i>',
        array(
            'onclick' => 'submitBahanMenuDiet();
                                                                                  return false;',
            'class' => 'btn btn-danger',
            'onkeypress' => "submitJadwalMakan();",
            'rel' => "tooltip",
            'id' => 'tambahbahanmenudiet',
            'title' => "Klik untuk Menambahkan Bahan",
        )
    );
    ?>
</div>
<div><br>
    <table id="tableBahanMenuDiet" class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th><?php echo CHtml::checkBox('checkListUtama', true, array('onclick' => 'checkAll(\'cekList\',this);')); ?></th>
                <th>Menu Diet</th>
                <th>Bahan Makanan</th>
                <th>Jumlah Bahan</th>
                <th>Satuan</th>
            </tr>
        </thead>
    </table>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeypress' => 'return formSubmit(this,event)', 'onClick' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/bahanMenuDietM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Bahan Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('/sistemAdministrator/BahanMenuDietM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit2b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<!--=========================== Widget DialogBox =========================================-->
<?php $this->endWidget(); ?>
<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMenuDiet',
    'options' => array(
        'title' => 'Pencarian Menu Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => false,
    ),
));

$modMenuDiet = new SAMenuDietM('search');
$modMenuDiet->unsetAttributes();
if (isset($_GET['SAMenuDietM'])) {
    $modMenuDiet->attributes = $_GET['SAMenuDietM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'menudiet-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modMenuDiet->search(),
    'filter' => $modMenuDiet,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectTipeDiet",
                                                    "onClick" => "\$(\"#BahanMenuDietM_menudiet_id\").val(\"$data->menudiet_id\");
                                                                          \$(\"#menudiet\").val(\"$data->menudiet_nama\");
                                                                          \$(\"#dialogMenuDiet\").dialog(\"close\");"
                                             )
                             )',
        ),
        array(
            'header' => 'Jenis Diet',
            'filter' => CHtml::listData($modMenuDiet->getJenisdietItems(), 'jenisdiet_id', 'jenisdiet_nama'),
            'value' => '$data->jenisdiet->jenisdiet_nama',
        ),
        array(
            'header' => 'Nama Menu Diet',
            'value' => '$data->menudiet_nama',
        ),
        array(
            'header' => 'Jumlah Porsi',
            'value' => '$data->jml_porsi',
        ),
        array(
            'header' => 'URT',
            'value' => '$data->ukuranrumahtangga',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* ========================================= endWidget MenuDiet =============================== */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogBahanMakanan',
    'options' => array(
        'title' => 'Pencarian Bahan Makanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => false,
    ),
));

$modBahanMakanan = new SABahanMakananM('search');
$modBahanMakanan->unsetAttributes();
if (isset($_GET['SABahanMakananM'])) {
    $modBahanMakanan->attributes = $_GET['SABahanMakananM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'bahanmakanan-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modBahanMakanan->search(),
    'filter' => $modBahanMakanan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectBahanMakanan",
                                                    "onClick" => "\$(\"#BahanMenuDietM_bahanmakanan_id\").val($data->bahanmakanan_id);
                                                                          \$(\"#bahanmakanan\").val(\"$data->namabahanmakanan\");
                                                                          \$(\"#satuan\").val(\"$data->satuanbahan\");
                                                                          \$(\"#dialogBahanMakanan\").dialog(\"close\");"
                                             )
                             )',
        ),
        array(
            'header' => 'Golongan Bahan',
            'filter' => CHtml::listData($modBahanMakanan->getGolBahanMakananItems(), 'golbahanmakanan_id', 'golbahanmakanan_nama'),
            'value' => '$data->golbahanmakanan->golbahanmakanan_nama',
        ),
        array(
            'header' => 'Jenis Bahan',
            'value' => '$data->jenisbahanmakanan',
        ),
        array(
            'header' => 'Kelompok Makanan',
            'value' => '$data->kelbahanmakanan',
        ),
        array(
            'header' => 'Nama Bahan Makanan',
            'value' => '$data->namabahanmakanan',
        ),
        array(
            'header' => 'Jumlah Persediaan',
            'value' => '$data->jmlpersediaan',
        ),
        array(
            'header' => 'Satuan',
            'value' => '$data->satuanbahan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<!--========================================= endWidget Bahan Makanan ======================-->
<?php
$urlGetBahanMenuDiet = Yii::app()->createUrl('actionAjax/GetBahanMenuDiet');
?>

<?php
$jscript = <<< JS
function submitBahanMenuDiet()
{
    menudiet_id = $('#BahanMenuDietM_menudiet_id').val();
    bahanmakanan_id = $('#BahanMenuDietM_bahanmakanan_id').val();
    jmlbahan = $('#BahanMenuDietM_jmlbahan').val();
    satuan = $('#satuan').val();
    if(menudiet_id==''){
        myAlert('Silakan pilih menu terlebih dahulu!');
    }else{
        $.post("${urlGetBahanMenuDiet}", { menudiet_id:menudiet_id, bahanmakanan_id:bahanmakanan_id, jmlbahan:jmlbahan, satuan:satuan},
        function(data){
            $('#tableBahanMenuDiet').append(data.return);
        }, "json");
    }   
}
function checkAll(kelas,obj)
{
    if(obj.checked) {
        $('.'+kelas+'').each(function() {
            $(this).attr('checked', 'checked');
        });
    }
    else
    {
        obj.checked = false;
        $('.'+kelas+'').each(function() {
            $(this).removeAttr('checked');
        });
    }
}
JS;

Yii::app()->clientScript->registerScript('bahanmenudiet', $jscript, CClientScript::POS_HEAD);
?>