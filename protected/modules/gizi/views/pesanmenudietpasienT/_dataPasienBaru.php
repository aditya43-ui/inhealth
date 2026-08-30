<style>
    .tr_isadmin { 
        background-color: #FFA07A !important;;  
    }
    .tr_isadmin:hover { 
        background-color: #FFA07A !important;;  
    }
    </style>
<?php 
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
    'id'=>'pasienbaru-m-grid',
    'dataProvider'=>$modPasienPulang->searchPasienBaru(),
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-bordered table-striped table-condensed',
    'rowCssClassExpression'=>'!empty($data->rencanapasienpulang_id)?"tr_isadmin":""',
    'columns'=>array(
        array(
		'header'=>'No',
		'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
		'type'=>'raw',
		'htmlOptions'=>array('style'=>'text-align:right;'),
	),
        array(
            'header'=>'Tanggal Masuk',
            'type'=>'raw',
            'value'=>function($data){
                if(!empty($data->tgl_pendaftaran)){
                    return MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran);
                }else{
                    return '-';
                }
            },
        ),
        array(
            'header'=>'Tanggal Pendaftaran / No. Pendaftaran',
            'type'=>'raw',
            'value'=> function($data){
                if(!empty($data->tgl_pendaftaran)){
                    return MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran).'/'.$data->no_pendaftaran;
                }else{
                    return '-';
                }
            }
        ),
       array(
            'header'=>'No. Rekam Medis',
            'type'=>'raw',
            'value'=> function($data){
                return $data->no_rekam_medik;
            }
        ),
        array(
            'header'=>'Nama Pasien',
            'type'=>'raw',
            'value'=> function($data){
                return $data->nama_pasien;
            }
        ),
        array(
            'header'=>'Instalasi',
            'type'=>'raw',
            'value'=> function($data){
                return $data->instalasiadmisi_nama;
            }
        ),
        array(
            'header'=>'Ruangan',
            'type'=>'raw',
            'value'=> function($data){
                return $data->ruanganadmisi_nama;
            }
        ),
        array(
            'header'=>'Kamar / Nomor Bed',
            'type'=>'raw',
            'value'=> function($data){
                 if(!empty($data->pasienadmisi_id)){
                    $pasienadmisi = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);
                    if(!empty($pasienadmisi)){
                        $kamar = KamarruanganM::model()->findByPk($pasienadmisi->kamarruangan_id);
                        if(!empty($kamar)){
                            return $kamar->kamarruangan_nokamar.' / '.$kamar->kamarruangan_nobed;
                        }else{
                            return '-';
                        }
                    }else{
                        return '-';
                    }
                }else{
                    return '-';
                }
            }
        ),
        array(
            'header'=>'Kelas Perawatan',
            'type'=>'raw',
            'value'=> function($data){
                return $data->kelaspelayanan_nama;
            }
        ),
        array(
            'header'=>'DPJP',
            'type'=>'raw',
            'value'=> function($data){
                if(!empty($data->pasienadmisi_id)){
                    $pasienadmisi = PasienadmisiT::model()->findByPk($data->pasienadmisi_id);
                    if(!empty($pasienadmisi)){
                        $str = '<ul>';
                        if (!empty($pasienadmisi->pegawai_id)) {
                            $peg = PegawaiM::model()->findByPk($pasienadmisi->pegawai_id);
                            $str .= '<li>'.$peg->namaLengkap.'</li>';
                        }
                        if (!empty($pasienadmisi->dpjp2_id)) {
                            $peg = PegawaiM::model()->findByPk($pasienadmisi->dpjp2_id);
                            $str .= '<li>'.$peg->namaLengkap.'</li>';
                        }
                        if (!empty($pasienadmisi->dpjp3_id)) {
                            $peg = PegawaiM::model()->findByPk($pasienadmisi->dpjp3_id);
                            $str .= '<li>'.$peg->namaLengkap.'</li>';
                        }

                        $str .= '</ul>';

                        return $str;
                    }else{
                        return '-';
                    }
                }else{
                    return '-';
                }
            }
        ),
        array(
            'header'=>'Lama Dirawat',
            'type'=>'raw',
            'value'=> function($data){
                return CustomFunction::hitungHariRawat($data->tgl_pendaftaran, $data->tglselesaiperiksa).' Hari';
            }
        ),
        array(
            'header'=>'Status Periksa',
            'type'=>'raw',
            'value'=> function($data){
                return $data->statusperiksa;
            }
        ),
        array(
            'header'=>'Pesan Menu Diet',
            'type'=>'raw',
            'value'=> function($data){
                
                $pesanmenu = PesanmenudetailT::model()->findByAttributes(array('pendaftaran_id' => $data->pendaftaran_id));
                if(!empty($pesanmenu)){
                    return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",
                        array(
                            "class"=>"btn-small",
                            'onclick' => "myAlert('Pasien sudah dilakukan pemesanan menu diet, jika ada perubahan silahkan menggunakan fitur edit');return false"
                         )
                    );
                }else{
                
                    $res = $data->attributes;
                    $res['kelaspelayanan_id']  = !empty($data->kelaspelayanan_id) ? $data->kelaspelayanan_id : '-';
                    $res['nama_pasien']  = !empty($data->pasien_id) ? $data->pasien->nama_pasien : '-';
                    $res['pasien_id']  = !empty($data->pasien_id) ? $data->pasien_id : '-';
                    $res = json_encode($res);

                    return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",
                        array(
                            "class"=>"btn-small",
                            "onClick" => "setPesanMenuDiet(".$res.");"

                         )
                    );
                }
                    
            }
        ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
        }',
)); 
?> 
<script>
    function setPesanMenuDiet(data) {
        var menuDiet = $('#tableMenuDiet tbody tr').length;
        if(menuDiet > 0) {
            myAlert('Silahkan simpan terlebih dahulu pemesanan menu diet yang sudah di tambahkan');
            return false;
        }
        $("#formdetail-pemesananmenu").find("#GZPesanmenudietT_kelaspelayanan_id").val(data.kelaspelayanan_id);
        $("#formdetail-pemesananmenu").find("#kelaspelayanan_id").val(data.kelaspelayanan_id);
        $("#formdetail-pemesananmenu").find("#GZPendaftaranT_nama_pasien").val(data.nama_pasien);
        $("#formdetail-pemesananmenu").find("#pasien_id").val(data.pasien_id);
        $("#formdetail-pemesananmenu").find("#pendaftaran_id").val(data.pendaftaran_id);
        $("#formdetail-pemesananmenu").find("#pasienadmisi_id").val(data.pasienadmisi_id);

        setKelasKunjungan(data.kelaspelayanan_id);
        loadAlatMakan();
    }
</script>