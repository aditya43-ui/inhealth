<?php

$modForm = new PremedikasiprainduksiT;
$row = $this->renderPartial($this->path_view."_rowPremedikasi", array(
    'form'=>$form,
    'modForm'=>$modForm
), true);

?>
<div class="form_pramedikasi">

    <div class="control-group">
        <?php echo $form->label($modForm, 'obatalkes_id', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($modForm, 'obatalkes_id', array('class'=>'pramedikasi_obatalkes_id')); ?>
            <?php
                $this->widget('MyJuiAutoComplete', array(
                    'name'=>'pramedikasi_obatalkes_nama',
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
                            $("#pramedikasi_obatalkes_id").val(ui.item.obatalkes_id);
                            $("#pramedikasi_obatalkes_nama").val(ui.item.obatalkes_nama);
                            return false;
                        }',
                    ),
                    'htmlOptions'=>array(
                        'class'=>'pramedikasi_obatalkes_nama',
                        'onkeyup'=>"return $(this).focusNextInputField(event)",
                    ),
                    'tombolDialog'=>array('idDialog'=>'dialogObatAlkesPremedikasi'),
                ));
            ?>
        </div>
    </div>
    <?php echo $form->textFieldRow($modForm, 'premedikasi_jumlah', array(
        'class'=>'jumlah span1 numbers-only',
    )); ?>
    <div class="control-group">
        <?php echo $form->label($modForm, 'premedikasi_jam', array('class'=>'control-label')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker',array(
                'model'=>$modForm,
                'attribute'=>'premedikasi_jam',
                'mode'=>'time',
                'options'=> array(
                    'dateFormat'=>Params::DATE_FORMAT,
                ),
                'htmlOptions'=>array('readonly'=>true,'class'=>'span3','onclick'=>"return $(this).focusNextInputField(event)"),
            )); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('class'=>'btn btn-primary', 'onclick'=>'addObatPramedikasi()')); ?>

        </div>
    </div>
</div>
<div class="clear"></div>

<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>No.</th>
            <th>Obat</th>
            <th>Jumlah</th>
            <th>Jam</th>
            <th>Hasil</th>
            <th>Hapus</th>
        </tr>
    </thead>
    <tbody class="tab_pramedikasi">
        <?php
        $list = PremedikasiprainduksiT::model()->findAllByAttributes(array(
            'asesmenprainduksi_id'=>$model->asesmenprainduksi_id,
        ));

        foreach ($list as $item) {
            echo $this->renderPartial($this->path_view."_rowPremedikasi", array(
                'form'=>$form,
                'modForm'=>$item
            ), true);
        }

        ?>
    </tbody>
</table>

<script>

    var row_pramedikasi = <?php echo CJSON::encode(array('html'=>$row)); ?>;

    function addObatPramedikasi() {
        var obatalkes_id = $(".form_pramedikasi .pramedikasi_obatalkes_id").val();
        var obatalkes_nama = $(".form_pramedikasi .pramedikasi_obatalkes_nama").val();
        var jumlah = $(".form_pramedikasi .jumlah").val();
        var premedikasi_jam = $(".form_pramedikasi #PremedikasiprainduksiT_premedikasi_jam").val();

        $(".tab_pramedikasi").append(row_pramedikasi.html);

        var last = $(".tab_pramedikasi tr:last-child");
        $(last).find(".obatalkes_id").val(obatalkes_id);
        $(last).find(".premedikasi_jumlah").val(jumlah);
        $(last).find(".premedikasi_jam").val(premedikasi_jam);

        $(last).find(".label_nama_obat").html(obatalkes_nama);
        $(last).find(".label_jumlah").html(jumlah);
        $(last).find(".label_waktu").html(premedikasi_jam);

        $(".form_pramedikasi :input").val("");

        renameInputPramedikasi();
    }

    function renameInputPramedikasi() {
        var cnt = 0;
        $(".tab_pramedikasi tr").each(function() {
            $(this).find(".nomor").html(cnt + 1);
            $(this).find(".premedikasiprainduksi_id").prop("name", "PremedikasiprainduksiT[detail][" + cnt + "][premedikasiprainduksi_id]");
            $(this).find(".obatalkes_id").prop("name", "PremedikasiprainduksiT[detail][" + cnt + "][obatalkes_id]");
            $(this).find(".premedikasi_jumlah").prop("name", "PremedikasiprainduksiT[detail][" + cnt + "][premedikasi_jumlah]");
            $(this).find(".premedikasi_jam").prop("name", "PremedikasiprainduksiT[detail][" + cnt + "][premedikasi_jam]");
            $(this).find(".premedikasi_hasil").prop("name", "PremedikasiprainduksiT[detail][" + cnt + "][premedikasi_hasil]");
            cnt++;
        });
    }

    function hapusRowPraMedikasi(obj) {

        var id = $(obj).parents("tr").find(".premedikasiprainduksi_id").val();
        myConfirm("Anda yakin untuk menghapus Data Pramedikasi ini?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl("hapusPramedikasi"); ?>', {id: id}, function(data) {
                    if (data.ok == 1) {
                        myAlert("Data berhasil di-hapus");
                        $(obj).parents("tr").remove();
                        $.fn.yiiGridView.update('obatalkes-premedikasi-grid');
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });

    }

    $(document).ready(function() {
        renameInputPramedikasi();
    });

</script>

<?php
//========= Dialog buat cari data Alat Kesehatan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogObatAlkesPremedikasi',
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
	'id'=>'obatalkes-premedikasi-grid',
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
                                        $(\'.pramedikasi_obatalkes_id\').val($data->obatalkes_id);
                                        $(\'.pramedikasi_obatalkes_nama\').val(\'$data->obatalkes_nama\');
                                        $(\'#dialogObatAlkesPremedikasi\').dialog(\'close\');
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
