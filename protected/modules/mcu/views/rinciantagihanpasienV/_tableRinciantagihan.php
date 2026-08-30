<?php
/**
* - digunakan sebagai Informasi Rincian Tagihan Pasien
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<?php 
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rjrinciantagihanpasien-v-grid',
    'replaceUrl'=>true,
	'dataProvider'=>$model->searchDaftarPasienMcu(),
//	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
        'pageSizeInput'=>false,
	'columns'=>array(
				array(
                                    'name'=>'Tgl. Pendaftaran<br>No. Pendaftaran',
					'name'=>'tgl_pendaftaran',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."<br>".$data->no_pendaftaran',
				),
                array(
                    'header'=>'No. Rekam Medik',
                    'type'=>'raw',
                    'value'=>'$data->no_rekam_medik',
                ),
                array(
                    'header'=>'Nama Pasien',
                    'type'=>'raw',
                    'value'=>'$data->namadepan.$data->nama_pasien',
                ),
//                'nama_pegawai',
                'jeniskasuspenyakit_nama',
                array(
                    'header'=>'Dokter',
                    'type'=>'raw',
                    'value'=>function($data) use (&$p) {
                        $p = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                        return $p->pegawai->namaLengkap;
                    } // '$data->gelardepan.$data->nama_pegawai.", ".$data->gelarbelakang_nama',
                ),
                array(
                    'header'=>'Status Periksa',
                    'value'=>function($data) use (&$p) {
                        return $p->statusperiksa;
                    }
                ),
                array(
                    'header'=>'Jenis Penjamin <br>Penjamin',
                    'type'=>'raw',
                    'value'=>'$data->CaraBayarPenjamin',
                ),
                array(
                    'header'=>'Total Tagihan',
                    'type'=>'raw',
                    //'value'=>'number_format($data->Totaltagihan,0,\',\',\'.\')',  
                    'htmlOptions'=>array('style'=>'text-align:right;'),
                    'value'=>function($data){
                    
                        $ruangan = array();
                        $total = 0;
                        $subsidiAsuransi = 0;
                        $subsidiPemerintah = 0;
                        $subsidiRumahSakit = 0;
                        $iurBiaya = 0;
                        $modRincian = RJRinciantagihanpasienV::model()->findAllByAttributes(array('pendaftaran_id' => $data->pendaftaran_id), array('order'=>'ruangan_id'));
                        foreach ($modRincian as $i=>$row){
                            $rowspan = count(RJRinciantagihanpasienV::model()->findAll('ruangan_id = '.$row->ruangan_id.' and pendaftaran_id = '.$row->pendaftaran_id));
                            if (!in_array($row->ruangan_id, $ruangan)){
                                $ruangan[] = $row->ruangan_id;
                                $ruanganTd = '<td rowspan="'.$rowspan.'" style="vertical-align:middle;text-align:center;">'.$row->ruangan_nama.'</td>';
                            }
                            else{
                                $ruanganTd = '';
                            }
                            $subtot = $row->tarifcyto_tindakan + ($row->tarif_satuan * $row->qty_tindakan);
                            $total += $subtot;
                        }
                        return 'Rp '.number_format($total,0,',','.');
                    }
                ),
                array(
                    'header'=>'Status Bayar',
                    'type'=>'raw',
                    'value'=>'(empty($data->pembayaranpelayanan_id)) ? "Belum Lunas" : "Lunas"' ,
                ),
//                'totaltagihan',
                array(
                    'header'=>'Rincian',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<icon class=\'icon-form-detail\'></idcon>", Yii::app()->controller->createUrl("rincian", array("id"=>$data->pendaftaran_id, "frame"=>1)), array("target"=>"frameRincian", "rel"=>"tooltip", "title"=>"lihat rincian tagihan pasien", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align:left; width:40px')
                ),		
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',

)); ?>