<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Paket BMHP
        </div>
    </div>
    <div class="panel-body">
        <?php //echo CHtml::link('<i class="entypo-search"></i>', '#', array('class' => 'btn btn-danger','onclick'=>'$("#dialogPaketBMHP").dialog("open");return false;')); 
        ?>
        <?php $this->widget('MyJuiAutoComplete', array(
            'name' => 'paketBMHP',
            'value' => '',
            'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . Yii::app()->createUrl('perawatanIntensif/tindakanTPI/PaketBMHP') . '",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                           idTipePaket: $("#RJTindakanPelayananT_0_tipepaket_id").val(),
                                           idKelasPelayanan: $("#RJPendaftaranT_kelaspelayanan_id").val(),
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
            'options' => array(
                'showAnim' => 'fold',
                'minLength' => 2,
                'focus' => 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                'select' => 'js:function( event, ui ) {
                            inputBMHP(ui.item.daftartindakan_id, ui.item.kelompokumur_id);
                            $(this).val(\'\');
                            return false;
                        }',

            ),
            'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2', 'placeholder' => 'Paket BMHP'),
            'tombolDialog' => array('idDialog' => 'dialogPaketBMHP'),
        )); ?>
        <table class="items table table-striped table-bordered table-condensed" id="tblInputPaketBhp">
            <thead>
                <tr>
                    <th>Uraian Tindakan</th>
                    <th>Nama BMHP</th>
                    <th>Harga</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div>
            <b>Total BMHP : </b>
            <?php echo CHtml::textField("totHargaBmhp", 0, array('readonly' => true, 'class' => 'inputFormTabel integer')); ?>
        </div>
    </div>
</div>

<?php
//========= Dialog buat cari data Paket BMHP =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPaketBMHP',
    'options' => array(
        'title' => 'Paket BMHP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 440,
        'resizable' => false,
    ),
));

//$filtersForm=new MyFiltersForm;
//if (isset($_GET['MyFiltersForm']))
//    $filtersForm->filters=$_GET['MyFiltersForm'];
//
//$command = Yii::app()->db->createCommand();
//$command->select = 'paketbmhp_m.daftartindakan_id, daftartindakan_m.daftartindakan_nama, 
//                    paketbmhp_m.kelompokumur_id, kelompokumur_m.kelompokumur_nama, SUM(hargapemakaian) as hargapemakaian';
//$command->from = 'paketbmhp_m';
//$command->group = 'paketbmhp_m.daftartindakan_id, daftartindakan_m.daftartindakan_nama, 
//                   paketbmhp_m.kelompokumur_id, kelompokumur_m.kelompokumur_nama';
//$command->order = 'paketbmhp_m.daftartindakan_id';
//$command->leftJoin('daftartindakan_m', 'paketbmhp_m.daftartindakan_id = daftartindakan_m.daftartindakan_id', array());
//$command->leftJoin('kelompokumur_m','paketbmhp_m.kelompokumur_id = kelompokumur_m.kelompokumur_id');
//
//if(!empty($filtersForm->filters['daftartindakanNama'])){
//    $command->where(array('like', 'LOWER(daftartindakan_m.daftartindakan_nama)', '%'.strtolower($filtersForm->filters['daftartindakanNama']).'%'));
//}
//if(!empty($filtersForm->filters['kelompokumurNama'])){
//    $command->where(array('like', 'LOWER(kelompokumur_m.kelompokumur_nama)', '%'.strtolower($filtersForm->filters['kelompokumurNama']).'%'));
//}
//
//$rawData=$command->queryAll();
//$dataProvider=new CArrayDataProvider($rawData, array(
//    'id'=>'daftartindakan-dataprovider',
//    'sort'=>array(
//        'attributes'=>array(
//             'daftartindakanNama','hargapemakaian',
//        ),
//    ),
//    'pagination'=>array(
//        'pageSize'=>2,
//    ),
//));

$modBMHP = new PIPaketbmhpM('searchPaket');
$modBMHP->unsetAttributes();
if (isset($_GET['PIPaketbmhpM'])) {
    $modBMHP->attributes = $_GET['PIPaketbmhpM'];
    $modBMHP->daftartindakanNama = $_GET['PIPaketbmhpM']['daftartindakanNama'];
    $modBMHP->kelompokumurNama = $_GET['PIPaketbmhpM']['kelompokumurNama'];
}


$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'rjpaketobat-alkes-m-grid',
    'dataProvider' => $modBMHP->searchPaket(),
    'filter' => $modBMHP,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
                                    $(\'#kelompokumur_id\').val($data->kelompokumur_id);
                                    inputBMHP($data->daftartindakan_id);return false;"))',
        ),
        array(
            'header' => 'Daftar Tindakan',
            'name' => 'daftartindakanNama',
            'value' => '(isset($data->daftartindakan_id) ? $data->daftartindakan->daftartindakan_nama : "")',
        ),
        array(
            'header' => 'Kelompok Umur',
            'name' => 'kelompokumurNama',
            'value' => '(isset($data->kelompokumur_id) ? $data->kelompokumur->kelompokumur_nama : "")',
        ),
        array(
            'header' => 'Harga Pemakaian',
            'name' => 'hargapemakaian',
            'value' => 'number_format($data->hargapemakaian)',
        ),

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script type="text/javascript">
    function inputBMHP(daftartindakan_id, kelompokumur_id) {
        var ketemu = false;
        var pendaftaran_id = <?php echo (isset($_GET['pendaftaran_id']) ? $_GET['pendaftaran_id'] : null); ?>;
        $('#tblInputTindakan').find('input[name$="[daftartindakan_id]"]').each(function() {
            //DIDISABLE SEMENTARA KARENA ADA BMHP YG TDK BERDASARKAN TINDAKAN >> if($(this).val() == daftartindakan_id){
            ketemu = true;
            jQuery.ajax({
                'url': '<?php echo Yii::app()->createUrl('perawatanIntensif/tindakanTPI/addFormPaketBmhp') ?>',
                'data': {
                    daftartindakan_id: daftartindakan_id,
                    kelompokumur_id: kelompokumur_id,
                    pendaftaran_id: pendaftaran_id
                },
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    //                        LNG-675
                    //                        if(data.status == false){
                    //                            window.parent.myAlert('Maaf, paket bmhp tidak termasuk pada kelompok umur tindakan pasien');
                    //                        }else 
                    if (data.status == true && data.pesan != '') {
                        window.parent.myAlert(data.pesan);

                    } else {
                        $('#tblInputPaketBhp').append(data.form);
                        //                            urutkanInputBMHP();
                        renameInputBMHP($("#tblInputPaketBhp"));
                        hitungTotalBMHP();
                        formatNumberSemua();
                    }
                },
                'cache': false
            });
            //} 
        });
        if (!ketemu) {
            window.parent.myAlert('Tidak ada tindakan yang dimaksud.');
        }
    }

    function hitungTotalBMHP() {
        var total = 0;
        $('#tblInputPaketBhp').find('input[name$="[hargapemakaian]"]').each(function() {
            total = total + unformatNumber(this.value);
        });
        $('#totHargaBmhp').val(formatNumber(total));
    }

    function urutkanInputBMHP() {
        renameInputBMHP('paketBmhp', 'stokobatalkes_id');
        renameInputBMHP('paketBmhp', 'daftartindakan_id');
        renameInputBMHP('paketBmhp', 'obatalkes_id');
        renameInputBMHP('paketBmhp', 'satuankecil_id');
        renameInputBMHP('paketBmhp', 'sumberdana_id');
        renameInputBMHP('paketBmhp', 'qtypemakaian');
        renameInputBMHP('paketBmhp', 'hargasatuan');
        renameInputBMHP('paketBmhp', 'harganetto');
        renameInputBMHP('paketBmhp', 'hargajual');
        renameInputBMHP('paketBmhp', 'hargapemakaian');

    }

    /**
     * rename input grid
     */
    function renameInputBMHP(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find("#no_urut").val(row + 1);
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
    //
    //function renameInputBMHP(modelName,attributeName)
    //{
    //    var i = -1;
    //    $('#tblInputPaketBhp tr').each(function(){
    //        if($(this).has('input[name$="[obatalkes_id]"]').length){
    //            i++;
    //        }
    //        $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
    //        $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
    //        $(this).find('select[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
    //        $(this).find('select[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
    //    });
    //}

    function hapusBMHP(obj) {
        window.parent.myConfirm("Apakan Anda ingin menghapus ini?", "Perhatian!", function(r) {
            if (r) {
                $(obj).parent().parent().remove();
                urutkanInputBMHP();
                hitungTotalBMHP();
            }
        });
        return false;
    }

    /**
     * class integer di unformat 
     * @returns {undefined}
     */
    function unformatNumberSemua() {
        $(".integer").each(function() {
            $(this).val(parseInt(unformatNumber($(this).val())));
        });
    }
    /**
     * class integer di format kembali
     * @returns {undefined}
     */
    function formatNumberSemua() {
        $(".integer").each(function() {
            $(this).val(formatInteger($(this).val()));
        });
    }
</script>