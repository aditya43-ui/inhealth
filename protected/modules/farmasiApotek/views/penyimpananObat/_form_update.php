<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'penyimpananobat-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
<div class="row" id="form-ruangan">
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <?php echo $form->errorSummary($model); ?>

    <div class="col-sm-6">
        <?php  // echo $form->textFieldRow($model, 'ruangan_id', array('placeholder' => 'Ruangan', 'class' => 'span3', 'onkeyup' => "namaLain(this)", 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
        <div class="control-group">
                                <?php echo CHtml::label("Ruangan", 'ruangan_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo CHtml::activeHiddenField($model, 'ruangan_id'); ?>
                                    <div style="float:left;">
                                        <?php $this->widget('MyJuiAutoComplete', array(
                                            'model' => $model,
                                            'attribute' => 'ruangan_nama',
                                            'sourceUrl' => $this->createUrl('RuanganList'),
                                            'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 2,
                                                'focus'=> 'js:function( event, ui )
                                                {
                                                 $(this).val(ui.item.label);
                                                 return false;
                                                 }',
                                                'select' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($model, 'ruangan_id') . '").val(ui.item.ruangan_id);
                                            refreshDialog(); 

                                        }',
                                            ),
                                            'tombolDialog' => array('idDialog' => 'dialogRuangan'),
                                            'htmlOptions' => array(
                                                'placeholder' => 'Ruangan',
                                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'ruangan_id') . '").val(""); ',
                                                'class' => 'span3 required', 'style' => 'float:left;'
                                            ),
                                        )); ?>
                                    </div>
                                </div>
        </div>

        <div class="control-group">
                                <?php echo CHtml::label("Rak ", 'rakobat_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo CHtml::activeHiddenField($model, 'rakobat_id'); ?>
                                    <div style="float:left;">
                                        <?php $this->widget('MyJuiAutoComplete', array(
                                            'model' => $model,
                                            'attribute' => 'rakobat_nama',
                                            'sourceUrl' => $this->createUrl('RakList'),
                                            'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 2,
                                                'focus'=> 'js:function( event, ui )
                                                {
                                                 $(this).val(ui.item.label);
                                                 return false;
                                                 }',
                                                'select' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($model, 'rakobat_id') . '").val(ui.item.rakobat_id);
                                        }',
                                            ),
                                            'tombolDialog' => array('idDialog' => 'dialogRakObat'),
                                            'htmlOptions' => array(
                                                'placeholder' => 'Rak',
                                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'rakobat_id') . '").val(""); ',
                                                'class' => 'span3 required', 'style' => 'float:left;',
                                            ),
                                        )); ?>
                                    </div>
                                </div>
                            </div>
    </div>
  
    <div class="col-sm-6">
        <?php // echo $form->textFieldRow($model, 'rakobat_id', array('placeholder' => 'Rak Obat', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event) namaLain(this);", 'maxlength' => 100)); ?>
      
      
   
      
        <?php // echo $form->textFieldRow($model, 'obatalkes_id', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group">
                                <?php echo CHtml::label("Obat Alkes ", 'obatalkes_id', array('class' => 'control-label')) ?>
                                <div class="controls">
                                    <?php echo CHtml::activeHiddenField($model, 'obatalkes_id'); ?>
                                    <div style="float:left;">
                                        <?php $this->widget('MyJuiAutoComplete', array(
                                            'model' => $model,
                                            'attribute' => 'obatalkes_nama',
                                            'sourceUrl' => $this->createUrl('ObatList'),
                                            'options' => array(
                                                'showAnim' => 'fold',
                                                'minLength' => 2,
                                                'select' => 'js:function( event, ui ) {
                                            $("#' . CHtml::activeId($model, 'obatalkes_id') . '").val(ui.item.obatalkes_id);
                                        }',
                                            ),
                                            'tombolDialog' => array('idDialog' => 'dialogObat'),
                                            'htmlOptions' => array(
                                                'placeholder' => 'Obat Alkes',
                                                'onkeypress' => "if(event.keyCode == 13 ){submitObat();}return $(this).focusNextInputField(event)",
                                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'obatalkes_id') . '").val(""); ',
                                                'class' => 'span3 required', 'style' => 'float:left;'
                                            ),
                                        )); ?>
                                    </div>
                                </div>
                            </div>
      
    
        <?php // echo $form->textFieldRow($model, 'create_time', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->checkBoxRow($model,'penyimpananobat_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php // echo $form->textFieldRow($model, 'update_time', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>

        
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
        Yii::t('mds', '{icon} Pengaturan Lokasi Obat', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php //$this->widget('UserTips',array('content'=>''));
    $content = $this->renderPartial('../tips/tipsaddedit2', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data Pemberi Tugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRuangan',
    'options' => array(
        'title' => 'Data Ruangan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modRuangan = new RuanganM;
if (isset($_GET['RuanganM']))

$modRuangan->attributes = $_GET['RuanganM'];
$provider =$modRuangan->search();
$provider->sort->defaultOrder = 'ruangan_nama asc';
$provider->criteria->order = 'ruangan_nama asc';

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'ruangan-m-grid',
    'dataProvider' => $provider,
    'filter' => $modRuangan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array("class" => "btn-small",
                            "id" => "ruangan",
                            "onClick" => "
                        $(\"#PenyimpananobatM_ruangan_id\").val(" . $data->ruangan_id . ");
                        $(\"#PenyimpananobatM_ruangan_nama\").val('" . $data->ruangan_nama . "');
                        refreshDialog(); 
                        $(\"#dialogRuangan\").dialog(\"close\");    
                    return false;
                "));
            }
        ),
        // array(
        //     'header' => 'No.',
        //     'type' => 'raw',
        //     'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        //     'filter' => false,
        // ),
        // // 'Id Ruangan',
        // array(
        //     'header' => 'Id Ruangan',
        //     'value' => '$data->ruangan_id',
        // ),

        // array(
        //     'header' => 'Nama Ruangan',
        //     'value' => '$data->ruangan_nama',
        // ),
        'ruangan_nama',

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));




?>
<?php $this->endWidget(); ?>



<?php
//========= Dialog buat cari data Pemberi Tugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRakObat',
    'options' => array(
        'title' => 'Data Rak',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modRakobat = new RakobatM;
if (isset($_GET['RakobatM']))

$modRakobat->attributes = $_GET['RakobatM'];
$provider =$modRakobat->search();
$provider->sort->defaultOrder = 'rakobat_nama asc';
$provider->criteria->order = 'rakobat_nama asc';
//  var_dump($$data->rakobat_nama);

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rakobat-m-grid',
    'dataProvider' => $provider,
    'filter' => $modRakobat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array("class" => "btn-small",
                            "id" => "rakobat",
                            "onClick" => "
                        $(\"#PenyimpananobatM_rakobat_id\").val(" . $data->rakobat_id . ");
                        $(\"#PenyimpananobatM_rakobat_nama\").val('" . $data->rakobat_nama . "');
                        $(\"#dialogRakObat\").dialog(\"close\");    
                    return false;
                "));
            }
        ),
        'rakobat_nama',
        
        array(
            'header'=>'Ruangan',
            'visible'=>false,
            'value'=>'$data->ruangan->ruangan_nama',
        'filter' => CHtml::activeHiddenField($modRakobat, 'ruangan_id', array('class' => 'ruangan')) . CHtml::activeTextField($modRakobat, 'ruangan_id', array())

            )
        // array(
        //     'header' => 'Nama Rak Obat',
        //     'value' => '$data->rakobat_nama',
        // ),
        

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));




?>

<?php $this->endWidget(); ?>




<?php
//========= Dialog buat cari data Pemberi Tugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogObat',
    'options' => array(
        'title' => 'Data Obat',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modObat = new FAObatalkesM;
if (isset($_GET['FAObatalkesM']))

$modObat->attributes = $_GET['FAObatalkesM'];
$provider2 =$modObat->searchDialog();
// $provider->sort->defaultOrder = 'obatalkes_nama asc';
// $provider->criteria->order = 'obatalkes_nama asc';
//  var_dump($data->obatalkes_nama);

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatalkes-m-grid',
    'dataProvider' => $provider2,
    'filter' => $modObat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array("class" => "btn-small",
                            "id" => "obatalkes",
                            "onClick" => "
                        $(\"#PenyimpananobatM_obatalkes_id\").val(" . $data->obatalkes_id . ");
                        $(\"#PenyimpananobatM_obatalkes_nama\").val('" . $data->obatalkes_nama . "');
                        $(\"#dialogObat\").dialog(\"close\");    
                    return false;
                "));
            }
        ),
        // array(
        //     'header' => 'No.',
        //     'type' => 'raw',
        //     'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        //     'filter' => false,
        // ),
        // 'Id Ruangan',
        // array(
        //     'header' => 'Id Obat',
        //     'value' => '$data->obatalkes_id',
        // ),
        'obatalkes_kode',
        'obatalkes_nama',
        // array(
        //     'header' => 'Nama Obat',
        //     'value' => '$data->obatalkes_nama',
        // ),
        

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));




?>

<?php $this->endWidget(); ?>

<?php
$urlGetObatAlkesSupplier = Yii::app()->createUrl('farmasiApotek/penyimpananObat/getObatAlkesSupplier');

$jscript = <<< JS
function submitObat()
{
    obatalkes_id = $('#PenyimpananobatM_obatalkes_id').val();
    ruangan_id = $('#PenyimpananobatM_ruangan_id').val();
    rakobat_id = $('#PenyimpananobatM_rakobat_id').val();

    if(ruangan_id =='')
    {
        myAlert('Silakan pilih Ruangan terlebih dahulu!');
    }else if(obatalkes_id==''){
        myAlert('Silakan pilih obat terlebih dahulu!');
    }else if(rakobat_id == ''){
        myAlert('Silahkan pilih Rak Obat Terlebih dahulu');
    }else{
            $.post("${urlGetObatAlkesSupplier}", { obatalkes_id: obatalkes_id, ruangan_id:ruangan_id,rakobat_id:rakobat_id},
            function(data){
                $('#tableobatSupplier > tbody').append(data.form);
                renameInputRowObatAlkes('#tableobatSupplier');
                sortTable();
                clear();
                
            }, "json");
    }   
}

function renameInputRowObatAlkes(obj_table){    
    var row = 0;
    console.log(row);
    $(obj_table).find("tbody > tr").each(function(a){
        console.log(a);
        $(this).find("#no_urut").val(row+1);
        // $(this).find('span').each(function(){ //element <input>
        //     var old_name = $(this).attr("name").replace(/]/g,"");
        //     var old_name_arr = old_name.split("[");
        //     if(old_name_arr.length == 3){
        //         $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
        //     }
        // });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        row++;
    });
    $('#obatalkes_id').val('');
    $('#obatalkes_nama').val('');
    $('#qty_input').val(1);
}

function sortTable(){
        var rows = $('#tableobatSupplier tbody  tr').get();
        var no = 1;

        rows.sort(function(a, b) {

            var A = $(a).children('td').eq(3).text().toUpperCase();
            var B = $(b).children('td').eq(3).text().toUpperCase();

            if(A < B) {
                return -1;
            }

            if(A > B) {
                return 1;
            }

            return 0;

        });
        $.each(rows, function(index, row) {
            $('#tableobatSupplier').children('tbody').append(row);
        });

        $('#tableobatSupplier').find("tbody > tr").each(function(){
            $(this).find("#no_urut").val(no);
            no++;
        });
    }

function remove(obj) {
    $(obj).parents('tr').remove();
}

function clear(){
    
    urut = 1;
    $(".no_urut").each(function(){
        $("#ObatsupplierM_obatAlkes").val("");
        $("#SAObatSupplierM_supplier_id").val();
            $(this).val(urut);
             urut++;
    });
}
JS;
Yii::app()->clientScript->registerScript('obatAlkes', $jscript, CClientScript::POS_HEAD);
?>


<script>
    function refreshDialog() {
        var ruangan = $("#PenyimpananobatM_ruangan_id").val();
        var def = '';
        if (ruangan == "") {
            def = 'ada';
        }

        console.log(ruangan);
        $(".ruangan_id").val(ruangan);
        $(".ruangan").val(ruangan);

        $("#PenyimpananobatM_rakobat_nama").val('');

        setTimeout(function () {
            $("#dialogRakObat").removeClass('animation-loading-1');                               

            $.fn.yiiGridView.update('rakobat-m-grid', {
                data: {
                    "RakobatM[ruangan_id]": ruangan
                }
            });
        }, 500);
    }

    $(document).ready(function(){
        var ruangan = $("#PenyimpananobatM_ruangan_id").val();
        var def = '';
        if (ruangan == "") {
            def = 'ada';
        }

        console.log(ruangan);
        $(".ruangan_id").val(ruangan);
        $(".ruangan").val(ruangan);


        setTimeout(function () {
            $("#dialogRakObat").removeClass('animation-loading-1');                               

            $.fn.yiiGridView.update('rakobat-m-grid', {
                data: {
                    "RakobatM[ruangan_id]": ruangan
                }
            });
        }, 500);
    })
</script>