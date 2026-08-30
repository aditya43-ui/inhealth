<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php //Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); 
?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bahanmenudiet-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#menudiet',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this)'
    ),
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label required">Menu Diet <span class="required">*</span></label>
            <div class="controls">
                <?php // echo $form->textFieldRow($model,'menudiet_id'); 
                ?>
                <?php echo CHtml::ActiveHiddenField($model, 'menudiet_id', array('readonly' => true, 'class' => 'required')) ?>
                <?php

                if (!isset($_GET['id'])) {
                    $this->widget('MyJuiAutoComplete', array(
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
                            'class' => 'required',
                            // 'onkeypress'=>"return $(this).focusNextInputField(event);",
                            'onkeypress' => 'changeSize()',
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogMenuDiet'),
                    ));
                } else {
                    echo CHtml::textField("menudiet", $model->menudiet->menudiet_nama, array('class' => 'span3', 'readonly' => true));
                }

                ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Bahan Makanan</label>
            <div class="controls">
                <?php echo CHtml::ActiveHiddenField($model, 'bahanmakanan_id', array('readonly' => true)) ?>
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
														   $("#satuan").val(ui.item.satuanbahan);
															return false;
														}',
                    ),
                    'htmlOptions' => array(
                        'readonly' => false,
                        'placeholder' => 'Bahan Makanan',
                        'size' => 13,
                        // 'onkeypress'=>"return $(this).focusNextInputField(event);" ,
                        'onkeypress' => 'changeSize()',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogBahanMakanan'),
                )); ?>
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Jumlah Bahan</label>
            <div class="controls">

                <?php
                $model->jmlbahan = number_format(1, 2, ",", ".");
                echo $form->textField($model, 'jmlbahan', array('class' => 'span1 float2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo CHtml::textField('satuan', '', array('readonly' => true, 'class' => 'span2'))  ?>
            </div>
            <div class="controls">
                <?php echo CHtml::htmlButton(
                    '<i class="icon-plus icon-white"></i>',
                    array(
                        'onclick' => 'submitBahanMenuDiet();
																  return false;',
                        'class' => 'btn btn-primary',
                        'onkeypress' => "return $(this).focusNextInputField(event);",
                        'rel' => "tooltip",
                        'id' => 'tambahbahanmenudiet',
                        'title' => "Klik untuk Menambahkan Bahan",
                    )
                );
                ?>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Detail <b>Bahan Makanan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="tableBahanMenuDiet" class="table table-condensed table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Bahan Makanan</th>
                    <th>Jumlah Bahan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($getAll)) {
                    $i = 1;
                    foreach ($getAll as $det) {
                        $det->namabahanmakanan = $det->bahanmakanan->namabahanmakanan;
                        echo $this->renderPartial("_rowMenuDiet", array('model' => $det, 'i' => $i), true);
                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeyUp' => 'return formSubmit(this,event)')
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
        Yii::t('mds', '{icon} Pengaturan Bahan Menu Diet', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('bahanMenuDietM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('../tips/tipsaddedit3c', array(), true);
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
        'height' => 500,
        'resizable' => true,
    ),
));

$modMenuDiet = new GZMenuDietM('search');
$modMenuDiet->unsetAttributes();
if (isset($_GET['GZMenuDietM'])) {
    $modMenuDiet->attributes = $_GET['GZMenuDietM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'menudiet-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modMenuDiet->search(),
    'filter' => $modMenuDiet,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectTipeDiet",
                                                    "onClick" => "\$(\"#BahanMenuDietM_menudiet_id\").val(\"$data->menudiet_id\");
                                                                          \$(\"#menudiet\").val(\"$data->menudiet_nama\");
																		  setMenuDiet(\"$data->menudiet_id\");
                                                                          \$(\"#dialogMenuDiet\").dialog(\"close\");"
                                             )
                             )',
        ),
        array(
            'header' => 'Jenis Diet',
            'name' => 'jenisdiet_id',
            'filter' => CHtml::dropDownList('GZMenuDietM[jenisdiet_id]', $modMenuDiet->jenisdiet_id, CHtml::listData($modMenuDiet->getJenisdietItems(), 'jenisdiet_id', 'jenisdiet_nama'), array('empty' => '-- Pilih --')),
            'value' => '$data->jenisdiet->jenisdiet_nama',
        ),
        array(
            'header' => 'Nama Menu Diet',
            'name' => 'menudiet_nama',
            'value' => '$data->menudiet_nama',
        ),
        array(
            'header' => 'Jumlah Porsi',
            'name' => 'jml_porsi',
            'value' => '$data->jml_porsi',
        ),
        array(
            'header' => 'URT',
            'name' => 'ukuranrumahtangga',
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
        'height' => 500,
        'resizable' => true,
    ),
));

$modBahanMakanan = new GZBahanMakananM('search');
$modBahanMakanan->unsetAttributes();
if (isset($_GET['GZBahanMakananM'])) {
    $modBahanMakanan->attributes = $_GET['GZBahanMakananM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'bahanmakanan-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modBahanMakanan->search(),
    'filter' => $modBahanMakanan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed table-bordered',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
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
            'name' => 'golbahanmakanan_id',
            'filter' => CHtml::dropDownList('GZBahanMakananM[golbahanmakanan_id]', $modBahanMakanan->golbahanmakanan_id, CHtml::listData($modBahanMakanan->getGolBahanMakananItems(), 'golbahanmakanan_id', 'golbahanmakanan_nama'), array('empty' => '-- Pilih --')),
            'value' => '$data->golbahanmakanan->golbahanmakanan_nama',
        ),
        array(
            'header' => 'Jenis Bahan',
            'name' => 'jenisbahanmakanan',
            'value' => '$data->jenisbahanmakanan',
        ),
        array(
            'header' => 'Kelompok Makanan',
            'name' => 'kelbahanmakanan',
            'value' => '$data->kelbahanmakanan',
        ),
        array(
            'header' => 'Nama Bahan Makanan',
            'name' => 'namabahanmakanan',
            'value' => '$data->namabahanmakanan',
        ),
        array(
            'header' => 'Jumlah Persediaan',
            'name' => 'jmlpersediaan',
            'value' => 'number_format($data->stokBahanMakanan,2,",",".")',
            'htmlOptions' => array('style' => 'text-align: right;'),
            'filter' => false
        ),
        array(
            'header' => 'Satuan',
            'name' => 'satuanbahan',
            'value' => '$data->satuanbahan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<!--========================================= endWidget Bahan Makanan ======================-->
<?php
$urlGetBahanMenuDiet = $this->createUrl('GetBahanMenuDiet');
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
			$("#tableBahanMenuDiet tbody tr:last .float2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2,"symbol":null});
			renameInputRow($("#tableBahanMenuDiet"));
			resetPilihMenuBahan();
			unformatNumberSemua();
			formatNumberSemua();
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
		
function resetPilihMenuBahan(){
}
JS;

Yii::app()->clientScript->registerScript('bahanmenudiet', $jscript, CClientScript::POS_HEAD);
?>
<script>
    $(document).ready(function() {
        $(".add-on").on("click", function() {
            changeSize();
        });

    });

    function changeSize() {
        window.parent.document.getElementById('frame').style = 'width: 100%; overflow-y: scroll; border: medium none; height: 600px;';
    }

    function setMenuDiet(id) {
        $("#tableBahanMenuDiet").addClass("animation-loading");
        $('#tableBahanMenuDiet > tbody').html("");
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('GetMenuDiet'); ?>',
            data: {
                id: id,
                is_update: 1
            }, //
            dataType: "json",
            success: function(data) {
                $('#tableBahanMenuDiet > tbody').append(data.form);
                jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip({
                    "placement": "<?php echo Params::TOOLTIP_PLACEMENT; ?>"
                });
                renameInputRow($("#tableBahanMenuDiet"));
                $("#tableBahanMenuDiet").removeClass("animation-loading");
                $("#tableBahanMenuDiet tbody tr .float2").maskMoney({
                    "defaultZero": true,
                    "allowZero": true,
                    "decimal": ",",
                    "thousands": ".",
                    "precision": 2,
                    "symbol": null
                });

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

    }

    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find('.nourut').val(row + 1);
            $(this).find('span').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });

    }

    function hapusBahanMenuDiet(obj) {
        var bahanmenudiet_id = $(obj).parents("tr").find("input[name$='[bahanmenudiet_id]']").val();
        if (bahanmenudiet_id !== "") {
            myConfirm("Apakah Anda yakin akan menghapus data ini dari database?", "Perhatian!",
                function(r) {
                    if (r) {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo $this->createUrl('Delete'); ?>&id=' + bahanmenudiet_id,
                            data: {
                                id: bahanmenudiet_id
                            }, //
                            dataType: "json",
                            success: function(data) {
                                if (data.sukses == 1) {
                                    $(obj).parents('tr').detach();
                                    renameInputRow($("#tableBahanMenuDiet"));
                                }
                                myAlert(data.pesan);
                                var rowCount = $("#tableBahanMenuDiet").find('tbody tr').length;
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(errorThrown);
                            }
                        });
                    }
                });
        } else {
            $(obj).parents('tr').detach();
            renameInputRow($("#tableBahanMenuDiet"));
        }
    }
</script>