<?php

$modForm = new BedahanastesilokalMedikasiintraopT;
$row = $this->renderPartial($this->path_view."_rowPemakaian", array(
    'form'=>$form,
    'modForm'=>$modForm
), true);

?>
<div class="form_penggunaan">

    <div class="control-group">
        <?php echo $form->label($modForm, 'obatalkes_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($modForm, 'obatalkes_id', array('class'=>'pemakaian_obatalkes_id')); ?>
            <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name'=>'pemakaian_obatalkes_nama',
                    'source'=>'js: function(request, response) {
                        $.ajax({
                            url: "'.$this->createUrl('AutocompleteObatAlkes').'",
                            dataType: "json",
                            data: {
                                term: request.term,
                            },
                            success: function (data) {
                                response(data);
                            }
                        })
                    }',
                    'options'=>array(
                        'showAnim'=>'fold',
                        'minLength' => 2,
                        'focus'=> 'js:function( event, ui ) {
                            $(this).val("");
                            return false;
                        }',
                        'select'=>'js:function( event, ui ) {
                            $(this).val(ui.item.value);
                            $("#pemakaian_obatalkes_id").val(ui.item.obatalkes_id);
                            $("#pemakaian_obatalkes_nama").val(ui.item.obatalkes_nama);
                            return false;
                        }',
                    ),
                    'htmlOptions'=>array(
                        'class'=>'pemakaian_obatalkes_nama',
                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialogObatAlkes'),
                ));
            ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modForm, 'obatalkes_dosis', array(
        'class'=>'jumlah span2',
    )); ?>
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('class'=>'btn btn-primary', 'onclick'=>'addObatPemakaian()')); ?>

        </div>
    </div>
</div>
<div class="clear"></div>

<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>No.</th>
            <th>Obat</th>
            <th>Dosis</th>
            <th>Hapus</th>
        </tr>
    </thead>
    <tbody class="tab_penggunaan">
        <?php

        if (!$model->isNewRecord) {

            $list = BedahanastesilokalMedikasiintraopT::model()->findAllByAttributes(array(
                'bedahanastesilokal_intraop_id'=>$model->bedahanastesilokal_intraop_id,
            ));

            foreach ($list as $item) {
                echo $this->renderPartial($this->path_view."_rowPemakaian", array(
                    'form'=>$form,
                    'modForm'=>$item
                ), true);
            }
        }

        ?>
    </tbody>
</table>

<script>

    var row_penggunaan = <?php echo CJSON::encode(array('html'=>$row)); ?>;

    function addObatPemakaian() {
        var obatalkes_id = $(".form_penggunaan .pemakaian_obatalkes_id").val();
        var obatalkes_nama = $(".form_penggunaan .pemakaian_obatalkes_nama").val();
        var jumlah = $(".form_penggunaan .jumlah").val();

        $(".tab_penggunaan").append(row_penggunaan.html);

        var last = $(".tab_penggunaan tr:last-child");
        $(last).find(".obatalkes_id").val(obatalkes_id);
        $(last).find(".pemakaian_jumlah").val(jumlah);

        $(last).find(".label_nama_obat").html(obatalkes_nama);
        $(last).find(".label_jumlah").html(jumlah);

        $(".form_penggunaan :input").val("");

        renameInputPenggunaanObat();
    }

    function renameInputPenggunaanObat() {
        var cnt = 0;
        $(".tab_penggunaan tr").each(function() {
            $(this).find(".nomor").html(cnt + 1);
            $(this).find(".bedahanastesilokal_medikasiintraop_id").prop("name", "BedahanastesilokalMedikasiintraopT[detail][" + cnt + "][bedahanastesilokal_medikasiintraop_id]");
            $(this).find(".obatalkes_id").prop("name", "BedahanastesilokalMedikasiintraopT[detail][" + cnt + "][obatalkes_id]");
            $(this).find(".pemakaian_jumlah").prop("name", "BedahanastesilokalMedikasiintraopT[detail][" + cnt + "][pemakaian_jumlah]");
            cnt++;
        });
    }

    function hapusRowPemakaianObat(obj) {
        var id = $(obj).parents("tr").find(".bedahanastesilokal_medikasiintraop_id").val();
        myConfirm("Anda yakin untuk menghapus Data Medikasi ini?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl("hapusMedikasi"); ?>', {id: id}, function(data) {
                    if (data.ok == 1) {
                        myAlert("Data berhasil di-hapus");
                        $(obj).parents("tr").remove();
                        $.fn.yiiGridView.update('obatalkes-pemakaian-grid');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });

        // $(obj).parents("tr").remove();
    }

    $(document).ready(function() {
        renameInputPenggunaanObat();
    });

</script>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogObatAlkes',
    'options'=>array(
        'title'=>'Obat Alkes Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>600,
        'height'=>600,
        'resizable'=>false,
    ),
));
$modObatAlkes = new InfostokobatalkesruanganV('search');
$modObatAlkes->unsetAttributes();
$modObatAlkes->ruangan_id = Yii::app()->user->getState('ruangan_id');
if(isset($_GET['InfostokobatalkesruanganV'])){
    $modObatAlkes->attributes = $_GET['InfostokobatalkesruanganV'];
    //$modObatAlkes->jenisobatalkes_nama = $_GET['InfostokobatalkesruanganV']['jenisobatalkes_nama'];
   // $modObatAlkes->satuankecil_nama = $_GET['InfostokobatalkesruanganV']['satuankecil_nama'];
//    $modObatAlkes->sumberdana_nama = $_GET['LBObatalkesM']['sumberdana_nama'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'obatalkes-pemakaian-grid',
	'dataProvider'=>$modObatAlkes->searchObat(),
	'filter'=>$modObatAlkes,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",
                                    "id" => "selectObat",
                                    "onClick" => "
                                        $(\'.pemakaian_obatalkes_id\').val($data->obatalkes_id);
                                        $(\'.pemakaian_obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#dialogObatAlkes\').dialog(\'close\');
                                        return false;"
                                        ))',
                ),
               array(
                    'name'=>'jenisobatalkes_id',
                    'type'=>'raw',
                    'value'=>'(!empty($data->jenisobatalkes_id) ? $data->jenisobatalkes_nama : "")',
                    'filter'=>  CHtml::activeDropDownList($modObatAlkes, 'jenisobatalkes_id', CHtml::listData(
                   JenisobatalkesM::model()->findAll(array(
                       'condition'=>'jenisobatalkes_aktif = true',
                       'order'=>'jenisobatalkes_nama',
                   )), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty'=>'-- Pilih --')),
                ),
                array(
                    'name'=>'obatalkes_kategori',
                    'filter'=>  CHtml::activeDropDownList($modObatAlkes, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array(
                        'empty'=>'-- Pilih --'
                    ))
                ),
                array(
                    'name'=>'obatalkes_golongan',
                    'filter'=>  CHtml::activeDropDownList($modObatAlkes, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array(
                        'empty'=>'-- Pilih --'
                    ))
                ),
                'obatalkes_nama',
//                array(
//                    'name'=>'sumberdana_id',
//                    'type'=>'raw',
//                    'value'=>'$data->sumberdana->sumberdana_nama',
//                    'filter'=>  CHtml::activeTextField($modObatAlkes, 'sumberdana_nama'),
//                ),

                array(
                    'header'=>'Jumlah Stok',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'text-align: right;'),
                    'value'=>'StokobatalkesT::getJumlahStok($data->obatalkes_id, Yii::app()->user->getState("ruangan_id"))." ".$data->satuankecil_nama',
                ),

	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>
