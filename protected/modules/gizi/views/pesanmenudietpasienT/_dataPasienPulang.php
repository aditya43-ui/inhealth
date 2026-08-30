<?php 
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
    'id'=>'pasienpulang-m-grid',
    'dataProvider'=>$modPasienPulang->searchPasienPulang(),
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-bordered table-striped table-condensed',
    'columns'=>array(
//        array(
//            'header'=> 'Pilih '.CHtml::checkBox('is_pilihsemuaPasienPulang',false,array('onclick'=>'pilihSemuaPasienPulang(this)','title'=>'Klik untuk pilih / tidak <br>semua pasien pulang','rel'=>'tooltip')),
//            'type'=>'raw',
//            'value'=>'
//                CHtml::hiddenField("GZPendaftaranT[".$data->pendaftaran_id."][pendaftaran_id]",$data->pendaftaran_id).
//                CHtml::checkBox("GZPendaftaranT[".$data->pendaftaran_id."][cekList]", false, array("class"=>"cekList", "onkeyup"=>"return $(this).focusNextInputField(event);"));
//                ',
//        ),
        array(
            'header'=>'Tanggal Pulang',
            'type'=>'raw',
            'value'=>function($data){
                if(!empty($data->tglselesaiperiksa)){
                    return MyFormatter::formatDateTimeForUser($data->tglselesaiperiksa);
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
//        array(
//            'header'=>'Hapus Pemesanan',
//            'type'=>'raw',
//            'value'=> function($data){
//                return CHtml::link("<i class='glyphicon glyphicon-trash'></i> ", "javascript:deleteRecord($data->pendaftaran_id)",array("id"=>"$data->pendaftaran_id","rel"=>"tooltip","data-placement"=>"left","title"=>"Hapus Pemesanan"));
//            }
//        ),
    ),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
        }',
)); 

?> 
<script>
    function pilihSemuaPasienPulang(obj){
        if($(obj).is(":checked")){
                $(".cekList").val(1);
                $(".cekList").attr("checked",true);
        }else{
                $(".cekList").val(0);
                $(".cekList").attr("checked",false);
        }
   }
</script>