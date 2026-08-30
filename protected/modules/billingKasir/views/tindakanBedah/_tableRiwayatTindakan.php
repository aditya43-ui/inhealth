<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'riwayat-tindakan-grid',
    'dataProvider'=>$modRiwayatTindakans->searchRiwayatTindakan($modPendaftaran->pendaftaran_id,PARAMS::INSTALASI_ID_IBS),
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
                'header'=>'Tindakan / Pemeriksaan <br> Dokter Pemeriksa',
                'value'=>function($data){
                  echo  (isset($data->daftartindakan_nama) ? $data->daftartindakan_nama : "")."<br>";
                  echo !empty($data->dokterpemeriksa1_id)?$data->getNamaLengkap():"";
                },
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
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>