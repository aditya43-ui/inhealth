<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gfobatsupplier-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>
<div class='block-tabel'>
    <?php
    if ($form->errorSummary($modObatSupplier)) {
        echo '<div class="alert alert-block alert-error">' . $form->errorSummary($modObatSupplier) . '</div>';
    }
    ?>
    <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <table id="tableobatSupplier" class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Supplier</th>
                <th>Nama Obat Alkes</th>
                <th>Satuan Kecil</th>
                <th>Satuan Besar</th>
                <th>Harga Beli <br> Satuan Besar</th>
                <th>Harga Beli <br> Satuan Kecil</th>
                <th>Keringanan (%)</th>
                <th>Ppn (%)</th>
                <th>Batal</th>
            </tr>
            <thead>
            <tbody>
                <?php
                $supplier_id = (isset($_POST['supplier_id']) ? $_POST['supplier_id'] : null);
                $obatalkes_id = (isset($_POST['obatalkes_id']) ? $_POST['obatalkes_id'] : null);
                $i = 1;
                $tr = null;
                foreach ($modObatSupplier as $i => $value) {
                    $hapus = Yii::app()->createUrl('gudangFarmasi/obatSupplier/deleteupdate', array('obatalkes_id' => "$value->obatalkes_id", 'supplier_id' => "$value->supplier_id"));
                    $tr .= "<tr>";
                    $tr .= "<td>"
                        . CHtml::activeHiddenField($value, '[' . $i . ']obatalkes_id', array('id' => 'obatalkles_id', 'class' => 'obatAlkes'))
                        . CHtml::activeHiddenField($value, '[' . $i . ']supplier_id', array('id' => 'supplier_id', 'class' => 'barang'))
                        . ($i + 1)
                        . "</td>";
                    $tr .= "<td>" . $value->supplier->supplier_nama . "</td>";
                    $tr .= "<td>" . $value->obatalkes->obatalkes_nama
                        //                                         .CHtml::activehiddenField($value,'['.$i.']harganetto',array('class'=>'span1 numbersOnly netto','readonly'=>FALSE)).
                        . CHtml::activehiddenField($value, '[' . $i . ']hargabelikecil', array('class' => 'span1 numbersOnly netto', 'readonly' => FALSE))
                        . CHtml::activehiddenField($value, '[' . $i . ']hargabelibesar', array('class' => 'span1 numbersOnly', 'readonly' => FALSE)) .
                        "</td>";
                    //                            $tr .= "<td>".CHtml::activetextField($value,'['.$i.']harganettoppn',array('onkeyup'=>'setHargaJual(this);','value'=>ceil($value->harganettoppn),'class'=>'span1 numbersOnly netto','readonly'=>FALSE,))."</td>";
                    //                            $tr .= "<td>".CHtml::activetextField($value,'['.$i.']hargajual',array('value'=>ceil($value->hargajual),'class'=>'span1 numbersOnly hargajual','readonly'=>FALSE))."</td>";
                    //                            $tr .= "<td>".$value->satuankecil->satuankecil_nama."</td>";
                    $tr .= "<td>" . CHtml::activeDropDownList($value, '[' . $i . ']satuankecil_id',  CHtml::listData(SatuankecilM::model()->findAllByAttributes(array('satuankecil_aktif' => true)), 'satuankecil_id', 'satuankecil_nama'), array('value' => ceil($value->satuankecil_id), 'class' => 'span1', 'readonly' => FALSE, 'style' => 'width:80px;')) . "</td>";
                    $tr .= "<td>" . CHtml::activeDropDownList($value, '[' . $i . ']satuanbesar_id',  CHtml::listData(SatuanbesarM::model()->findAllByAttributes(array('satuanbesar_aktif' => true)), 'satuanbesar_id', 'satuanbesar_nama'), array('value' => ceil($value->satuankecil_id), 'class' => 'span1', 'readonly' => FALSE, 'style' => 'width:80px;')) . "</td>";
                    $tr .= "<td>" . CHtml::activetextField($value, '[' . $i . ']hargabelikecil', array('value' => ceil($value->hargabelikecil), 'class' => 'span1 numbersOnly netto', 'readonly' => FALSE,)) . "</td>";
                    $tr .= "<td>" . CHtml::activetextField($value, '[' . $i . ']hargabelibesar', array('value' => ceil($value->hargabelibesar), 'class' => 'span1 numbersOnly', 'readonly' => FALSE)) . "</td>";
                    $tr .= "<td>" . CHtml::activetextField($value, '[' . $i . ']diskon_persen', array('value' => ceil($value->diskon_persen), 'class' => 'span1 numbersOnly', 'readonly' => FALSE)) . "</td>";
                    $tr .= "<td>" . CHtml::activetextField($value, '[' . $i . ']ppn_persen', array('value' => ceil($value->ppn_persen), 'class' => 'span1 numbersOnly', 'readonly' => FALSE)) . "</td>";

                    $tr .= '<td>' . CHtml::link("<i class='icon-form-silang'></i>", $hapus) . '</td>';
                    $tr .= "</tr>";
                }
                echo $tr;

                if (count((array)$modDetails) > 0) {
                    foreach ($modDetails as $i => $detail) {
                        $modObat = ObatalkesM::model()->findByPk($detail->obatalkes_id);
                        $tr = "<tr>";
                        $tr .= "<td>"
                            . CHtml::activeHiddenField($detail, '[' . $i . ']obatalkes_id', array('class' => 'barang'))
                            . CHtml::activeHiddenField($detail, '[' . $i . ']supplier_id', array('class' => 'barang'))
                            . $modBarang->jenisobatalkes->jenisobatalkes_nama
                            . "</td>";
                        $tr .= "<td>" . $detail->supplier->supplier_nama . "</td>";
                        $tr .= "<td>" . $detail->obatalkes_nama . "</td>";
                        //                            $tr .= "<td>".CHtml::activetextField($value,'['.$i.']harganettoppn',array('onkeyup'=>'setHargaJual(this);','value'=>($detail->harganetto * 1.1),'class'=>'span1 numbersOnly netto','readonly'=>FALSE))."</td>";
                        $tr .= "<td>" . CHtml::activeDropDownList($value, '[' . $i . ']satuankecil_id',  CHtml::listData(SatuankecilM::model()->findAllByAttributes(array('satuankecil_aktif' => true)), 'satuankecil_id', 'satuankecil_nama'), array('value' => ceil($value->satuankecil_id), 'class' => 'span1', 'readonly' => FALSE, 'style' => 'width:80px;')) . "</td>";
                        $tr .= "<td>" . CHtml::activeDropDownList($value, '[' . $i . ']satuanbesar_id',  CHtml::listData(SatuanbesarM::model()->findAllByAttributes(array('satuanbesar_aktif' => true)), 'satuanbesar_id', 'satuanbesar_nama'), array('value' => ceil($value->satuankecil_id), 'class' => 'span1', 'readonly' => FALSE, 'style' => 'width:80px;')) . "</td>";
                        $tr .= "<td>" . CHtml::activetextField($value, '[' . $i . ']hargabelikecil', array('value' => $detail->hargabelikecil, 'class' => 'span1 numbersOnly netto', 'readonly' => FALSE)) . "</td>";
                        $tr .= "<td>" . CHtml::activetextField($value, '[' . $i . ']hargabelibesar', array('value' => $detail->hargabelibesar, 'class' => 'span1 numbersOnly ', 'readonly' => FALSE)) . "</td>";
                        //                            $tr .= "<td>".CHtml::activetextField($value,'['.$i.']hargajual',array('value'=>$detail->hargajual,'class'=>'span1 numbersOnly hargajual','readonly'=>FALSE))."</td>";
                        $tr .= "<td>" . CHtml::activetextField($value, '[' . $i . ']diskon_persen', array('value' => $detail->diskon_persen, 'class' => 'span1 numbersOnly ', 'readonly' => FALSE)) . "</td>";
                        $tr .= "<td>" . CHtml::activetextField($value, '[' . $i . ']ppn_persen', array('value' => $detail->ppn_persen, 'class' => 'span1 numbersOnly ', 'readonly' => FALSE)) . "</td>";

                        $tr .= "<td>" . CHtml::link("<i class='icon-form-silang'></i>", '#', array('onclick' => 'remove(this);')) . "</td>";
                        $tr .= "</tr>";
                        echo $tr;
                    }
                }
                ?>

            </tbody>
    </table>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/ObatSupplier/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Obat Supplier', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl(
            Yii::app()->controller->id . '/admin',
            array('modul_id' => Yii::app()->session['modul_id'])
        ),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial($this->path_tips . 'tips.tipsaddedit3b', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<?php
//========= Dialog buat cari data obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogObatAlkes',
    'options' => array(
        'title' => 'Pencarian Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modObatAlkes = new ObatalkesfarmasiV('search');
$modObatAlkes->unsetAttributes();
if (isset($_GET['ObatalkesfarmasiV'])) {
    $modObatAlkes->attributes = $_GET['ObatalkesfarmasiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'obatAlkes-m-grid',
    'dataProvider' => $modObatAlkes->search(),
    'filter' => $modObatAlkes,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                            "id" => "selectPasien",
                                            "onClick" => "$(\"#obatalkes_id\").val(\"$data->obatalkes_id\");
                                                        submitObat();
                                                          $(\"#dialogObatAlkes\").dialog(\"close\");    
                                                "))',
        ),
        array(
            'header' => 'Sumber Dana',
            'name' => 'sumberdana_nama',
            'value' => '$data->sumberdana_nama',
            'filter' => CHtml::dropDownList('ObatalkesfarmasiV[sumberdana_nama]', $modObatAlkes->sumberdana_nama, CHtml::listData($modObatAlkes->getSumberDanaItems(), 'sumberdana_nama', 'sumberdana_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Jenis',
            'name' => 'jenisobatalkes_nama',
            'value' => '$data->jenisobatalkes_nama',
            'filter' => CHtml::dropDownList('ObatalkesfarmasiV[jenisobatalkes_nama]', $modObatAlkes->jenisobatalkes_nama, CHtml::listData($modObatAlkes->getJenisObatAlkesItems(), 'jenisobatalkes_nama', 'jenisobatalkes_nama'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Kategori',
            'name' => 'obatalkes_kategori',
            'value' => '$data->obatalkes_kategori',
            'filter' => CHtml::dropDownList('ObatalkesfarmasiV[obatalkes_kategori]', $modObatAlkes->obatalkes_kategori, LookupM::getItems('obatalkes_kategori'), array('empty' => '-- Pilih --'))
        ),
        array(
            'header' => 'Golongan',
            'name' => 'obatalkes_golongan',
            'value' => '$data->obatalkes_golongan',
            'filter' => CHtml::dropDownList('ObatalkesfarmasiV[obatalkes_golongan]', $modObatAlkes->obatalkes_golongan, LookupM::getItems('obatalkes_golongan'), array('empty' => '-- Pilih --'))
        ),
        'obatalkes_kode',
        'obatalkes_nama',
        'obatalkes_kadarobat',
        //'kemasanbesar',
        'kekuatan',
        // 'tglkadaluarsa',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end obatAlkes dialog =============================
?>
<?php
$urlGetObatAlkesSupplier = Yii::app()->createUrl('gudangFarmasi/obatSupplier/getObatAlkesSupplier');
$jscript = <<< JS
    function submitObat()
    {
        obatalkes_id = $('#obatalkes_id').val();
        supplier_id = $('#supplier_id').val();

        if(supplier_id =='')
        {
            myAlert('Silakan pilih supplier terlebih dahulu!');
        }else if(obatalkes_id==''){
            myAlert('Silakan pilih obat terlebih dahulu!');
        }else{
                $.post("${urlGetObatAlkesSupplier}", { obatalkes_id: obatalkes_id, supplier_id:supplier_id},
                function(data){
                    $("#tableobatSupplier tbody tr:last").find('.numbersOnly').maskMoney({"defaultZero":true, "allowZero":true, "decimal":",", "thousands":".", "symbol":null, "precision":0});
                    $('#tableobatSupplier tbody').append(data.tr);
                    clear();

                }, "json");
        }   
    }

    function remove(obj) {
        $(obj).parents('tr').remove();
    }

    function clear(){

        urut = 1;
        $(".noUrut").each(function(){
            $("#ObatsupplierM_obatAlkes").val("");
            $("#GFObatSupplierM_supplier_id").val();
                $(this).val(urut);
                 urut++;
        });
    }
JS;
Yii::app()->clientScript->registerScript('obatAlkes', $jscript, CClientScript::POS_HEAD);
?>