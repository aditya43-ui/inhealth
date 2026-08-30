<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'penyimpananobat-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>
    <?php echo $form->errorSummary($model); ?>
<div class="row" id="form-ruangan">

    <div class="col-sm-6">
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
                            'focus' => 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',

                            'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                $("#PenyimpananobatM_ruangan_id").val(ui.item.ruangan_id);
                                $("#PenyimpananobatM_ruangan_nama").val(ui.item.ruangan_nama);
                                refreshDialog(); 
                                return false;
                            }',
                        ),
                        'tombolDialog' => array("idDialog" => "dialogRuangan",
                        "onclick"=>"window.parent.$(\'#dialogRuangan\').dialog(\'open\')"
                        // 'jsFunction'=>'CallDialog();',
                    ),
                        'htmlOptions' => array(
                            'placeholder' => 'Ruangan',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'ruangan_nama') . '").val(""); ',
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
                            'focus' => 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',

                            'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                $("#PenyimpananobatM_rakobat_id").val(ui.item.rakobat_id);
                                            $("#PenyimpananobatM_rakobat_nama").val(ui.item.rakobat_nama);
                                            return false;

                                        }',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogRakObat'),
                        'htmlOptions' => array(
                            'placeholder' => 'Rak',
                            'onkeyup' => "return $(this).focusNextInputField(event)",
                            'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'rakobat_id') . '").val(""); ',
                            'class' => 'span3 required', 'style' => 'float:left;'
                        ),
                    )); ?>
                </div>
            </div>
        </div>
        <!--  -->

    </div>

    <div class="col-sm-6">


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
                            'focus' => 'js:function( event, ui ) {
                                $(this).val("");
                                return false;
                            }',
                            'select' => 'js:function( event, ui ) {
                                $(this).val(ui.item.value);
                                $("#PenyimpananobatM_obatalkes_id").val(ui.item.obatalkes_id);
                                            $("#PenyimpananobatM_obatalkes_nama").val(ui.item.obatalkes_nama);
                                            return false;
                                        }',
                                        
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogObat'),
                        'htmlOptions' => array(
                            'placeholder' => 'Obat Alkes',
                            'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($model, 'obatalkes_id') . '").val(""); ',
                            'class' => 'span3 required', 'style' => 'float:left;'
                        ),
                    )); ?>


                </div>
            </div>
            &nbsp;
            <?php echo CHtml::htmlButton(
                '<i class="icon-plus icon-white"></i>',
                array(
                    'onclick' => 'submitObat();return false;',
                    'onkeyup' => "submitObat();",
                    'class' => 'btn btn-primary',
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan penyimpanan",
                )
            ); ?>
        </div>


        <?php echo $form->checkBoxRow($model, 'penyimpananobat_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>


    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Penyimpanan Obat</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="tableobatSupplier" class="table table-bordered table-condensed middle-center">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Ruangan</th>
                    <th>Nama Rak</th>
                    <th>Kode Obat</th>
                    <th>Nama Obat</th>
                    <th>Hapus</th>
                </tr>
                <thead>
                <tbody>

                </tbody>
        </table>
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
        Yii::t('mds', '{icon} Pengaturan Penyimpanan Obat', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
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
$provider = $modRuangan->search();
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
            'value' => function ($data) {
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array(
                    "class" => "btn-small",
                    "id" => "ruangan",
                    "onClick" => "
                        $(\"#PenyimpananobatM_ruangan_id\").val(" . $data->ruangan_id . ");
                        $(\"#PenyimpananobatM_ruangan_nama\").val('" . $data->ruangan_nama . "');
                        refreshDialog(); 
                        $(\"#dialogRuangan\").dialog(\"close\");    
                    return false;
                "
                ));
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

        array(
            'header' => 'Nama Ruangan',
            'name'=>'ruangan_nama',
            'value' => '$data->ruangan_nama',
        ),
        // 'ruangan_nama',

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
$provider = $modRakobat->search();
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
            'value' => function ($data) {
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array(
                    "class" => "btn-small",
                    "id" => "rakobat",                    
                    "onClick" => "
                        $(\"#PenyimpananobatM_rakobat_id\").val(" . $data->rakobat_id . ");
                        $(\"#PenyimpananobatM_rakobat_nama\").val('" . $data->rakobat_nama . "');
                        $(\"#dialogRakObat\").dialog(\"close\");    
                    return false;
                "
                ));
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
        //     'header' => 'Id Rak Obat',
        //     'value' => '$data->rakobat_id',
        // ),
        // 'rakobat_nama',

        array(
            'header' => 'Nama Rak Obat',
            'value' => '$data->rakobat_nama',
        ),

        array(
            'header'=>'Ruangan',
            'visible'=>false,
            'value'=>'$data->ruangan->ruangan_nama',
        'filter' => CHtml::activeHiddenField($modRakobat, 'ruangan_id', array('class' => 'ruangan')) . CHtml::activeTextField($modRakobat, 'ruangan_id', array())

            )



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
$provider2 = $modObat->searchDialog();
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
            'value' => function ($data) {
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "#", array(
                    "class" => "btn-small",
                    "id" => "obatalkes",
                    "onClick" => "
                        $(\"#PenyimpananobatM_obatalkes_id\").val(" . $data->obatalkes_id . ");
                        $(\"#PenyimpananobatM_obatalkes_nama\").val('" . $data->obatalkes_nama . "');
                        $(\"#dialogObat\").dialog(\"close\");    
                    return false;
                "
                ));
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

    ruangan_nama = $('#PenyimpananobatM_ruangan_nama').val();
    rakobat_nama = $('#PenyimpananobatM_rakobat_nama').val();
    obatalkes_nama = $('#PenyimpananobatM_obatalkes_nama').val();

    // console.log(ruangan_nama);
    if(ruangan_id =='')
    {
        myAlert('Silakan pilih Ruangan terlebih dahulu!');
    }else if(obatalkes_id==''){
        myAlert('Silakan pilih obat terlebih dahulu!');
    }else if(rakobat_id == ''){
        myAlert('Silahkan pilih Rak Obat Terlebih dahulu');
    }else{
        var i = 0;
        $("#tableobatSupplier > tbody > tr").each(function () {
            // if (typeof $("#tabel-batch").find('.pemrosesanbiomaterialproduk_id[value="' + $(this).attr('id-data') + '"]').val() !== 'undefined') {
            //     $(this).prop("checked", true);
            //     $(this).prop("disabled", true);
            // }
            var rak  = $(this).find('.rakobat_id').val();
            var ruangan  = $(this).find('.ruangan_id').val();
            var obat  = $(this).find('.obatalkes_id').val();

            // console.log(rak,ruangan,obat);
            // console.log(rakobat_id,ruangan_id,obatalkes_id);
            if (ruangan == ruangan_id && obat == obatalkes_id && rak ==rakobat_id ) {
                i++;
            }
            console.log(i); 
            
        });
        if (i >= 1) {
            toastr.error(obatalkes_nama + " sudah ada di " + ruangan_nama + " pada rak : " + rakobat_nama  );
            // console.log(`<nama obat> sudah ada di <ruangan_nama> pada rak : <nama rak>`);
            // console.log(obatalkes_nama + " sudah ada di " + ruangan_nama + " pada rak : " + rakobat_nama  );
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
}

function CallDialog(){
    console.log("Test");
    window.parent.$("#dialogRuangan").dialog("open"); 
    return true;
}

function renameInputRowObatAlkes(obj_table){    
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(a){
        // console.log(a);
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


        setTimeout(function () {
            $("#dialogRakObat").removeClass('animation-loading-1');                               

            $.fn.yiiGridView.update('rakobat-m-grid', {
                data: {
                    "RakobatM[ruangan_id]": ruangan
                }
            });
        }, 500);
    }
</script>