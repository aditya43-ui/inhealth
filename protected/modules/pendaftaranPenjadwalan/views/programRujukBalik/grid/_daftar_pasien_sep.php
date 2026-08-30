<?php
$modSep = new PPPencarianseprujukankeluarV('searchDialog');
$modSep->default = 'kosong';
if(isset($_GET['PPPencarianseprujukankeluarV'])){
    $modSep->attributes = $_GET['PPPencarianseprujukankeluarV'];        
    $modSep->default = isset($_GET['PPPencarianseprujukankeluarV']['default'])?$_GET['PPPencarianseprujukankeluarV']['default']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'daftar-pasien-sep-grid',
	'dataProvider'=>$modSep->searchPasienSep(),
	'filter'=>$modSep,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'filter' => CHtml::activeHiddenField($modSep, 'default'),
                    'value'=>function($data){    
    
                        $sep = SepT::model()->findByPk($data->sep_id);

                        $pendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);

                        $dt = $data->attributes;                     
                        $dt['dpjp_id'] = $pendaftaran->pegawai_id;
                        $dt['dpjp_nama'] = $pendaftaran->pegawai->namaLengkap;
                        $dt['dpjp_kode'] = $pendaftaran->pegawai->kodedokter_bpjs;
                        if (!empty($sep)) {
                            $dt['programprb_kode'] = $sep->programprb_kode;
                            $dt['programprb_nama'] = $sep->programprb_nama;
                            $dt['diagnosabpjskode'] = "";
                            if (!empty($sep->programprb_kode)) {
                                $dt['diagnosabpjskode'] = $sep->programprb_kode." - ".$sep->programprb_nama;
                            }
                        }
                        
                        $res = json_encode($dt);
                        
                        return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small",                             
                            "onClick" => "
                                setPasienSep(".$res.",'')
                            return false;"));
                    },
                ),
                [
                    'header' => 'No Sep/<br/>Tgl Sep',
                    'type' => 'raw',
                    'name' => 'nosep',
                    'value' => function($data){
                        return $data->nosep.'/<br/>'.MyFormatter::formatDateTimeForUser($data->tglsep);
                    }
                ],
                [
                    'header' => 'No Pendaftaran/<br/>Tgl Pendaftaran',
                    'type' => 'raw',
                    'name' => 'no_pendaftaran',
                    'value' => function($data){
                        return $data->no_pendaftaran.'/<br/>'.MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran);
                    }
                ],
                [
                    'header' => 'No Rekam Medik',
                    'name' => 'no_rekam_medik',
                    
                ],
                [
                    'header' => 'Nama Pasien',
                    'name' => 'nama_pasien',
                    
                ],
                [
                    'header' => 'Kelas',
                    'name' => 'klsrawat',
                    
                ],
                [
                    'header' => 'Pelayanan',
                    'name' => 'jnspelayanan',
                    
                ],
                
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
