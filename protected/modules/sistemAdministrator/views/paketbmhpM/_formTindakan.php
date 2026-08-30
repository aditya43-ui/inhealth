<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tindakan</div>
    </div>
    <div class="panel-body">
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'name'=>'daftartindakan',
            'value'=>'',
            'source'=>'js: function(request, response) {
                                         $.ajax({
                                                url: "'.$this->createUrl('AutocompleteDaftarTindakan').'",
                                                dataType: "json",
                                                data: {
                                                    daftartindakan: request.term,
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
                                    addTindakan(ui.item.daftartindakan_id);
                                    return false;
                        }',
            ),
            'tombolDialog'=>array('idDialog'=>'dialogdaftartindakan'),
            'htmlOptions'=>array(
                'placeholder'=>'Tambah Tindakan','rel'=>'tooltip',
                'onkeyup'=>"return $(this).focusNextInputField(event)",
            ),
        ));
        ?>
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Daftar Tindakan</th>
                    <th width="50">Qty</th>
                    <th width="150">Tarif Satuan</th>
                    <th width="150">Total Tarif</th>
                    <th width="50">Hapus</th>
                </tr>
            </thead>
            <tbody class="tab_tindakan">
                <?php 
                $tindakan = PaketbmhptindakanM::model()->findAllByAttributes(array(
                    'paketbmhp_id'=>$model->paketbmhp_id,
                ));

                foreach ($tindakan as $item) {
                    $item->tarifsatuan = MyFormatter::formatNumberForPrint($item->tarifsatuan, 2);
                    $item->totaltarif = MyFormatter::formatNumberForPrint($item->totaltarif, 2);

                    echo $this->renderPartial($this->path_view."_rowTindakan", array('tindakan'=>$item), true);
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
function addTindakan(id) {
    $("#daftartindakan").val("");
    $.post('<?php echo $this->createUrl("ajaxTambahTindakan"); ?>', {id: id}, function(data) {
        $(".tab_tindakan").append(data.html);

        $(".tab_tindakan tr:last .integer2").maskMoney(
            {"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
        );
        $(".tab_tindakan tr:last .integer-decimal").maskMoney(
            {"symbol": "", "defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 2}
        );

        hitungTotalTindakan();
    }, 'json');
}



function hitungTotalTindakan() {
    total_tindakan = 0;
    $(".tab_tindakan tr").each(function() {
        var qty = parseInt($(this).find(".qty").val());
        var harga_satuan = parseFloat(unformatNumber($(this).find(".tarifsatuan").val()));

        var total = qty * harga_satuan;

        total_tindakan += total;

        $(this).find(".totaltarif").val(formatThousandDecimal(total));
    });


    totalSemua();
}

function hapusTindakan(obj) {
    $(obj).parents("tr").remove();
}
</script>



<?php
/* ====================================== Widget Dialog Daftar Tindakan ====================================== */

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
        'id'=>'dialogdaftartindakan',
        'options'=>array(
            'title'=>'Pencarian Daftar Tindakan',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>900,
            'height'=>400,
            'resizable'=>false,
            ),
    ));

$modDaftarTindakan = new DaftartindakanM('search');
$modDaftarTindakan->unsetAttributes();
if(isset($_GET['DaftartindakanM'])) {
    $modDaftarTindakan->attributes = $_GET['DaftartindakanM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'daftartindakan-grid',
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
                                            "id" => "selectbarang",
                                            "onClick" => "addTindakan(".$data->daftartindakan_id."); $(\"#dialogdaftartindakan\").dialog(\"close\");"

                                     )
                     )',
                ),
                'daftartindakan_nama',
                array(
                    'header'=>'Kelompok Tindakan',
                    'name'=>'kelompoktindakan_nama',
                    'value'=>'isset($data->kelompoktindakan->kelompoktindakan_nama)?$data->kelompoktindakan->kelompoktindakan_nama:" - "',
                    'filter' => CHtml::dropDownList('DaftartindakanM[kelompoktindakan_nama]',$modDaftarTindakan->kelompoktindakan_nama, CHtml::listData($modDaftarTindakan->getKelompokTindakanItems(), 'kelompoktindakan_nama', 'kelompoktindakan_nama'), array('empty'=>'-- Pilih --'))
                ),
                array(
                    'header'=>'Kategori Tindakan',
                    'name'=>'kategoritindakan_nama',
                    'value'=>'isset($data->kategoritindakan->kategoritindakan_nama)?$data->kategoritindakan->kategoritindakan_nama:" - "',
                    'filter' => CHtml::dropDownList('DaftartindakanM[kategoritindakan_nama]',$modDaftarTindakan->kategoritindakan_nama, CHtml::listData($modDaftarTindakan->getKategoriTindakanItems(), 'kategoritindakan_nama', 'kategoritindakan_nama'), array('empty'=>'-- Pilih --'))
                ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
/* ====================================== endWidget Dialog Daftar Tindakan ====================================== */
?>