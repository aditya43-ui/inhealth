<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sajadwalmakan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php echo CHtml::label('Jenis Diet', 'jjenisdiet', array('class' => "control-label")) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('jenisdietid', $model->jenisdiet_id, array('readonly' => true)) ?>

                <?php $this->widget('MyJuiAutoComplete', array(
                    'name' => 'jenisdiet',
                    'value' => $model->jenisdiet->jenisdiet_nama,
                    'source' => 'js: function(request, response) {
                                                                   $.ajax({
                                                                       url: "' . Yii::app()->createUrl('ActionAutoComplete/Jenisdiet') . '",
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
                                                                           $(\'#jenisdietid\').val(ui.item.jenisdiet_id);
                                                                           $(\'#jenisdiet_nama\').val(ui.item.jenisdiet_nama);
                                                                            return false;
                                                                        }',
                    ),
                    'htmlOptions' => array(
                        'readonly' => false,
                        'placeholder' => 'Jenis Diet',
                        'size' => 13,
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogJenisdiet'),
                )); ?>
            </div>
        </td>
        <td>
            <?php echo CHtml::label('Tipe Diet', 'ttipediet', array('class' => "control-label")) ?>
            <div class="controls">
                <?php echo CHtml::hiddenField('tipedietid', $model->tipediet_id, array('readonly' => true)) ?>
                <?php
                /* $tipediet = TipeDietM::model()->findAll();
                            foreach($tipediet as $valuetipediet):
                                $returnTipeDiet[] = array(    
                                  'label'=>$valuetipediet->tipediet_nama,
                                  'value'=>$valuetipediet->tipediet_id,
                                  'id'=>$valuetipediet->tipediet_id,);
                            endforeach; */
                ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                    'name' => 'tipediet',
                    // 'value'=>$model->menudiet->tipediet_id,
                    'value' => $model->tipediet->tipediet_nama,
                    'source' => 'js: function(request, response) {
                                                       $.ajax({
                                                           url: "' . Yii::app()->createUrl('ActionAutoComplete/TipeDiet') . '",
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
                                                               $("#tipedietid").val(ui.item.tipediet_id);
                                                               $("#tipediet_nama").val(ui.item.tipediet_nama);
                                                                return false;
                                                            }',
                    ),
                    'htmlOptions' => array(
                        'readonly' => false,
                        'placeholder' => 'Tipe Diet',
                        'size' => 13,
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogTipeDiet'),
                )); ?>
            </div>
        </td>
        <td>
            <?php echo CHtml::label('Menu Diet', 'mmenudiet', array('class' => "control-label")) ?>
            <div class="controls">

                <?php echo CHtml::hiddenField('menudiet_id', $model->menudiet_id, array('readonly' => true)) ?>
                <?php
                /* $menudiet = MenuDietM::model()->findAll();
                                        foreach($menudiet as $valuemenudiet):
                                            $returnMenuDiet[] = array(    
                                              'label'=>$valuemenudiet->menudiet_nama,
                                              'value'=>$valuemenudiet->menudiet_nama,
                                              'id'=>$valuemenudiet->menudiet_id,);
                                        endforeach; */
                ?>
                <?php $this->widget('MyJuiAutoComplete', array(
                    'name' => 'menudiet',
                    'value' => $model->menudiet->menudiet_nama,
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
                                                                           $("#menudietid").val(ui.item.menudiet_id);
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
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->dropDownListRow(
                $model,
                'jeniswaktu_id',
                CHtml::listData($model->JenisWaktuItems, 'jeniswaktu_id', 'jeniswaktu_nama'),
                array('readonly' => true),
                array('class' => 'inputRequire span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',)
            ); ?>
        </td>
        <td>

        </td>
        <td>

        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeypress' => 'return formSubmit(this,event)', 'onClick' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/jadwalMakanM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Jadwal Makan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('jadwalMakanM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit2b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogJenisdiet',
    'options' => array(
        'title' => 'Pencarian Jenis Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modJenisdiet = new SAJenisdietM('search');
$modJenisdiet->unsetAttributes();
if (isset($_GET['SAJenisdietM'])) {
    $modJenisdiet->attributes = $_GET['SAJenisdietM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'jenisdiet-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modJenisdiet->search(),
    'filter' => $modJenisdiet,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectJenisdiet",
                                                    "onClick" => "\$(\"#jenisdietid\").val($data->jenisdiet_id);
                                                                          \$(\"#jenisdiet\").val(\"$data->jenisdiet_nama\");
                                                                          \$(\"#dialogJenisdiet\").dialog(\"close\");"
                                             )
                             )',
        ),
        'jenisdiet_nama',
        'jenisdiet_namalainnya',
        'jenisdiet_keterangan',
        array(
            'header' => 'Catatan',
            'type' => 'raw',
            'value' => '$data->jenisdiet_catatan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* -------------------------------------------------------------------------- endWidget Jenisdiet ---------------------------------------------- */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTipeDiet',
    'options' => array(
        'title' => 'Pencarian Tipe Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => false,
    ),
));

$modTipeDiet = new SATipeDietM('search');
$modTipeDiet->unsetAttributes();
if (isset($_GET['SATipeDietM'])) {
    $modTipeDiet->attributes = $_GET['SATipeDietM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'tipediet-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modTipeDiet->search(),
    'filter' => $modTipeDiet,
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
                                                    "onClick" => "\$(\"#tipedietid\").val($data->tipediet_id);
                                                                          \$(\"#tipediet\").val(\"$data->tipediet_nama\");
                                                                          \$(\"#dialogTipeDiet\").dialog(\"close\");"
                                             )
                             )',
        ),
        'tipediet_nama',
        'tipediet_namalainnya',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* -------------------------------------------------------------------------- endWidget TipeDiet ---------------------------------------------- */

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
                                                    "onClick" => "\$(\"#menudiet_id\").val($data->menudiet_id);
                                                                          \$(\"#menudiet\").val(\"$data->menudiet_nama\");
                                                                          \$(\"#dialogMenuDiet\").dialog(\"close\");"
                                             )
                             )',
        ),
        'menudiet_nama',
        'menudiet_namalain',
        'jml_porsi',
        'ukuranrumahtangga',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMenuDietForTest',
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
                                                    "id" => "selectTipeMenuDiet",
                                                    "onClick" => "var parent = $(\"#dialogMenuDietForTest\").attr(\"parentclick\");
                                                            $(\"#\"+parent+\"\").val($data->menudiet_id);
                                                                          $(\"#\"+parent+\"\").parents(\"td\").find(\".adamenudiet\").val(\"$data->menudiet_nama\");
                                                                          $(\"#dialogMenuDietForTest\").dialog(\"close\");"
                                             )
                             )',
        ),
        'menudiet_nama',
        'menudiet_namalain',
        'jml_porsi',
        'ukuranrumahtangga',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
/* -------------------------------------------------------------------------- endWidget MenuDiet ---------------------------------------------- */
?>

<?php
$urlGetJadwalMakan = Yii::app()->createUrl('actionAjax/GetJadwalMakan');
?>

<?php
$jscript = <<< JS
function submitJadwalMakan()
{
    var jeniswaktu = new Array();
    jenisdietid = $('#jenisdietid').val();
    tipedietid = $('#tipedietid').val();
    jeniswaktuid = $('#jeniswaktuid').val();
    menudietid = $('#menudietid').val();
    i = 0;
    $('.jeniswaktu').each(function(){   
        if ($(this).is(':checked')){
            jeniswaktu[i] = $(this).val();
            i++;
        }
    });
    if(jenisdietid==''){
        myAlert('Silakan pilih jenis diet terlebih dahulu!');
    }else{
        $.post("${urlGetJadwalMakan}", {jeniswaktu:jeniswaktu, jenisdietid: jenisdietid, tipedietid:tipedietid, jeniswaktuid:jeniswaktuid, menudietid:menudietid,},
        function(data){
            $('#tableJadwalMakan').append(data.return);
            renameInput();
            autoMenuDiet();
        }, "json");
    }   
}

function renameInput(){
    nourut = 0;
    $('.cekList').each(function(){
        $(this).parents('tr').find('[name*="JadwalMakanM"]').each(function(){
            var input = $(this).attr('name');
            var data = input.split('JadwalMakanM[]');
            if (typeof data[1] === 'undefined'){} else{
                $(this).attr('name','JadwalMakanM['+nourut+']'+data[1]);
            }
        });
        nourut++;
    });
}

function autoMenuDiet(){
    jQuery('.adamenudiet').autocomplete({'showAnim':'fold','minLength':2,'focus':function( event, ui )
    {
    $(this).val(ui.item.label);
    return false;
    },'select':function( event, ui ) {
    $(this).parents('td').find('.menudiet').val(ui.item.menudiet_id);
    return false;
    },'source': function(request, response) {
    $.ajax({
    url: "/simrs/index.php?r=ActionAutoComplete/MenuDiet",
    dataType: "json",
    data: {
    term: request.term,
    },
    success: function (data) {
    response(data);
    }
    })
    }}); 
}

function openDialog(obj){
    var idObj = $(obj).parents('td').find('.menudiet').attr('id');
    $('#dialogMenuDietForTest').attr('parentClick',idObj);
    $('#dialogMenuDietForTest').dialog('open');   
}
JS;

Yii::app()->clientScript->registerScript('jadwalMakan', $jscript, CClientScript::POS_HEAD);
?>