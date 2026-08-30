<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Obat/Alkes</div>
    </div>
    <div class="panel-body">
    <?php
        $this->widget('MyJuiAutoComplete', array(
            'name'=>'obatalkes',
            'value'=>'',
            'source'=>'js: function(request, response) {
                                         $.ajax({
                                                url: "'.$this->createUrl('autocompleteObatAlkes').'",
                                                dataType: "json",
                                                data: {
                                                    obatalkes: request.term,
                                                },
                                                success: function (data) {
                                                    response(data);
                                                }
                                         })
            }',
            'options'=>array(
                        'minLength' => 4,
                        'focus'=> 'js:function( event, ui ) {
                                    $(this).val("");
                                    return false;
                        }',
                        'select'=>'js:function( event, ui ) {
                                    addObat(ui.item.obatalkes_id);
                                    return false;
                        }',
            ),
            'tombolDialog'=>array('idDialog'=>'dialogobatalkes'),
            'htmlOptions'=>array(
                'placeholder'=>'Tambah Obat/Alkes','rel'=>'tooltip',
                'onkeyup'=>"return $(this).focusNextInputField(event)",
            ),
        ));
        ?>

        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Obat/Alkes</th>
                    <th width="50">Qty</th>
                    <th width="150">Tarif Satuan</th>
                    <th width="150">Total Tarif</th>
                    <th width="50">Hapus</th>
                </tr>
            </thead>
            <tbody class="tab_oa">
            <?php 
                $oadata = PaketbmhpobatM::model()->findAllByAttributes(array(
                    'paketbmhp_id'=>$model->paketbmhp_id,
                ));

                foreach ($oadata as $item) {
                    $item->tarifsatuan = MyFormatter::formatNumberForPrint($item->tarifsatuan, 2);
                    $item->totaltarif = MyFormatter::formatNumberForPrint($item->totaltarif, 2);

                    echo $this->renderPartial($this->path_view."_rowObat", array('oa'=>$item), true);
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>

function addObat(id) {
    $("#obatalkes").val("");
    $.post('<?php echo $this->createUrl("ajaxTambahObat"); ?>', {id: id}, function(data) {
        $(".tab_oa").append(data.html);

        $(".tab_oa tr:last .integer2").maskMoney(
            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
        );
        $(".tab_oa tr:last .integer-decimal").maskMoney(
            {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
        );

        hitungTotalObat();
    }, 'json');
}



function hitungTotalObat() {
    total_obat = 0;
    $(".tab_oa tr").each(function() {
        var qty = parseInt($(this).find(".qty").val());
        var harga_satuan = parseFloat(unformatNumber($(this).find(".tarifsatuan").val()));

        var total = qty * harga_satuan;

        total_obat += total;

        $(this).find(".totaltarif").val(formatThousandDecimal(total));
    });

    totalSemua();
}

function hapusOa(obj) {
    $(obj).parents("tr").remove();
}

</script>

<?php
/* ====================================== Widget Dialog Daftar Tindakan ====================================== */

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogobatalkes',
        'options'=>array(
            'title'=>'Pencarian Obat Alkes',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>900,
            'height'=>400,
            'resizable'=>false,
            ),
    ));

$modDaftarTindakan = new ObatalkesM('search');
$modDaftarTindakan->unsetAttributes();
$modDaftarTindakan->obatalkes_aktif = true;
if(isset($_GET['ObatalkesM'])) {
    $modDaftarTindakan->attributes = $_GET['ObatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'obatalkes-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider'=>$modDaftarTindakan->search(),
    'filter'=>$modDaftarTindakan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0)",
                                    array(
                                            "class"=>"btn-small",
                                            "id" => "selectobat",
                                            "onClick" => "addObat(".$data->obatalkes_id."); $(\"#dialogobatalkes\").dialog(\"close\");"

                                     )
                     )',
                ),
                'obatalkes_nama',
                array(
                    'header'=>'Jenis Obatalkes',
                    'name'=>'jenisobatalkes_id',
                    'value'=>'isset($data->jenisobatalkes->jenisobatalkes_nama)?$data->jenisobatalkes->jenisobatalkes_nama:" - "',
                    'filter' => CHtml::dropDownList('ObatalkesM[jenisobatalkes_id]',$modDaftarTindakan->jenisobatalkes_id, CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif = true order by jenisobatalkes_nama'), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array('empty'=>'-- Pilih --'))
                ),
                array(
                    'header'=>'Satuan Kecil',
                    'name'=>'satuankecil_id',
                    'value'=>'isset($data->satuankecil->satuankecil_nama)?$data->satuankecil->satuankecil_nama:" - "',
                    'filter' => CHtml::dropDownList('ObatalkesM[satuankecil_id]',$modDaftarTindakan->satuankecil_id, CHtml::listData(SatuankecilM::model()->findAll('satuankecil_aktif = true order by satuankecil_nama'), 'satuankecil_id', 'satuankecil_nama'), array('empty'=>'-- Pilih --'))
                ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Daftar Tindakan ====================================== */
?>  