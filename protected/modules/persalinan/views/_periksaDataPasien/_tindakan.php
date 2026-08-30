<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
            header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}
?>
<?php

$this->widget('ext.bootstrap.widgets.BootGridView',array( 
    'id'=>'rjtindakan-pelayanan-t-grid', 
    'dataProvider'=>$modTindakanSearch->searchDetailTindakan($modPendaftaran->pendaftaran_id), 
    //'filter'=>$modTindakan, 
        'template'=>"{summary}\n{items}\n{pager}", 
        'itemsCssClass'=>'table table-striped table-bordered table-condensed', 
    'columns'=>array( 
        ////'tindakanpelayanan_id',
        array( 
                        'name'=>'No', 
                        'value'=>'$data->tindakanpelayanan_id', 
                        'filter'=>false, 
                ),
        //'penjamin_id',
        //'pasienadmisi_id',
        'tgl_tindakan',
        'daftartindakan.kategoritindakan.kategoritindakan_nama',
        'daftartindakan.daftartindakan_nama',
        'qty_tindakan',
        //'hasilpemeriksaanrm_id',
        //'konsulpoli_id',
        //'hasilpemeriksaanrad_id',
        /*
        'pasien_id',
        'detailhasilpemeriksaanlab_id',
        'kelaspelayanan_id',
        'tipepaket_id',
        'instalasi_id',
        'tindakansudahbayar_id',
        'pendaftaran_id',
        'shift_id',
        'rencanaoperasi_id',
        'hasilpemeriksaanpa_id',
        'pasienmasukpenunjang_id',
        'karcis_id',
        'daftartindakan_id',
        'carabayar_id',
        'jeniskasuspenyakit_id',
        
        'tarif_rsakomodasi',
        'tarif_medis',
        'tarif_paramedis',
        'tarif_bhp',
        'tarif_satuan',
        'tarif_tindakan',
        'satuantindakan',
        'qty_tindakan',
        'cyto_tindakan',
        'tarifcyto_tindakan',
        'dokterpemeriksa1_id',
        'dokterpemeriksa2_id',
        'dokterpendamping_id',
        'dokteranastesi_id',
        'dokterdelegasi_id',
        'bidan_id',
        'suster_id',
        'perawat_id',
        'kelastanggungan_id',
        'discount_tindakan',
        'pembebasan_tindakan',
        'subsidiasuransi_tindakan',
        'subsidipemerintah_tindakan',
        'subsisidirumahsakit_tindakan',
        'iurbiaya_tindakan',
        'tm',
        'create_time',
        'update_time',
        'create_loginpemakai_id',
        'update_loginpemakai_id',
        'create_ruangan',
        */
        
    ), 
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}', 
)); ?> 