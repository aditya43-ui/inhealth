<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'riwayat-tindakan-grid',
    'dataProvider'=>$modRiwayatTindakans->searchRiwayatTindakan($modPendaftaran->pendaftaran_id,PARAMS::INSTALASI_ID_RAD),
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-bordered table-striped table-condensed',
    'columns'=>array(
            array(
                'header'=>'Tanggal Masuk Penunjang <br> No. Masuk Penunjang',
                'value'=>'(isset($data->tglmasukpenunjang) ? MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang) : "")."<br>".$data->no_masukpenunjang',
                'type'=>'raw',
                'filter'=>false,
            ),
            array(
                'header'=>'Pemeriksaan <br> Dokter Pemeriksa',
                'value'=>'(isset($data->daftartindakan_nama) ? $data->daftartindakan_nama : "")."<br>".$data->getNamaLengkap()',
                'type'=>'raw',
                'filter'=>false,
            ),
            array(
                'header'=>'Tarif',
                'value'=>'MyFormatter::formatNumberForUser($data->tarif_tindakan)',
                'type'=>'raw',
                'htmlOptions'=>array('style'=>'text-align:right;'),
                'filter'=>false,
            ),
            array(
                'header'=>'Hapus',
                'value'=>'CHtml::link("<i class=\"icon-remove\"></i>", "javascript:void(0);", array("onclick"=>"hapusTindakan(this,$data->tindakanpelayanan_id);return false;","rel"=>"tooltip","title"=>"Klik untuk menghapus tindakan"))',
                'type'=>'raw',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'filter'=>false,
            ),
            array(
                'header'=>'Verifikasi',
                'value'=> function ($data) {
                    $ret = '';
                    $ret .= CHtml::checkBox('is_verifikasi['.$data->tindakanpelayanan_id.']', false, array('onchange'=>'verifTindakan(this);'));
                    $ret .= CHtml::hiddenField('is_verif['.$data->tindakanpelayanan_id.']', 'no', array('class' => 'is_verif'));
                    $ret .= CHtml::hiddenField('riwayatTindakan['.$data->tindakanpelayanan_id.'][tindakanpelayanan_id]',$data->tindakanpelayanan_id,array('readonly'=>true, 'class' => 'tindakanpelayanan_id'));
                    $ret .= CHtml::hiddenField('riwayatTindakan['.$data->tindakanpelayanan_id.'][pendaftaran_id]',$data->pendaftaran_id,array('readonly'=>true, 'class' => 'pendaftaran_id'));

                    return $ret;

                },
                'type'=>'raw',
                'htmlOptions'=>array('style'=>'text-align:center;'),
                'filter'=>false,
            ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>

<script>

function verifTindakan(obj){

var tindakanpelayanan_id = $(obj).closest('tr').find('.tindakanpelayanan_id').val();
var pendaftaran_id = $(obj).closest('tr').find('.pendaftaran_id').val();

if($(obj).is(':checked')) {

    $.ajax({
        type:'POST',
        url:'<?php echo Yii::app()->createUrl('billingKasir/tindakanRawatJalan/VerifikasiTindakan'); ?>',
        data: {tindakanpelayanan_id:tindakanpelayanan_id},
        dataType: "json",
        success:function(data){
            $.fn.yiiGridView.update('riwayat-tindakan-grid', {
                data:{
                    "BKTindakanPelayananT[pendaftaran_id]":pendaftaran_id,
                    "BKTindakanPelayananT[instalasi_id]": 5,
                }
            });
            myAlert(data.pesan);
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            console.log(errorThrown);
        }
    });

}

}
</script>