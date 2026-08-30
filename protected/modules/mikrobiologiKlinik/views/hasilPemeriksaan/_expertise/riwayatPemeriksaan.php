<style>
.link_col {
    width: 60px !important;
    text-align: center !important;
}

.btn-grey {
    background-color: grey;
    color: white;
    font-weight: bold;
}

.btn-green {
    background-color: green;
    color: white;
    font-weight: bold;
}


.btn-orange {
    background-color: orange;
    color: white;
    font-weight: bold;
}

.btn-red {
    background-color: red;
    color: white;
    font-weight: bold;
}

.btn-blue-rev {
    background-color: white;
    border-color: blue;
    color: blue;
    font-weight: bold;
}

.btn-group .btn-blue-rev:hover {
    background-color: blue;
    border-color: white;
    color: white;
    font-weight: bold;
}

.btn-blue {
    background-color: #76A2BE;
    border-color: #76A2BE;
    font-weight: bold;
}

.btn-blue-disabled {
    background-color: #B3DAF2;
    border-color: #B3DAF2;
    font-weight: bold;
}
</style>



<?php

$kel = new KelompokpemeriksaanmikroT;
$kel->kelompokpemeriksaanmikro_id = $kelompok->kelompokpemeriksaanmikro_id;

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'kelompok-grid',
    'dataProvider' => $kel->search(),
    'template' => "{items}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Tanggal Pemeriksaan',
            'name' => 'tgl_pendaftaran',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pemeriksaan)',
        ),
        array(
            'name' => 'no_lab',
            'type' => 'raw',
            'header' => 'No. Lab',
            'value' => '$data->no_lab',
        ),
        array(
            'header' => 'Pemeriksaan',
            'type' => 'raw',
            'value' => function($data) use (&$tindakan) {
                $tindakan = TindakanpelayananT::model()->findByPk($data->tindakanpelayanan_id);
                return !empty($tindakan) ? $tindakan->daftartindakan->daftartindakan_nama : ' - ';
            },
        ),
        array(
            'header' => 'Jenis Pemeriksaan',
            'type' => 'raw',
            'value' => function ($data) use (&$tindakan) {
                echo '<center>';
                echo ' <div class="btn-group mr-2" role="group" aria-label="Pemeriksaan">';
                echo !$data->is_pemeriksaankultur ? "" : CHtml::link('Kultur', $this->createUrl('kultur', array('kelompokpemeriksaanmikro_id' => $data->kelompokpemeriksaanmikro_id,'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id, 'pemeriksaankultur_id' => $data->pemeriksaankultur_id)), array('class' => 'btn btn-grey'));
                echo !$data->is_pemeriksaanpewarnaan ? "" : CHtml::link('Pewarnaan Langsung', $this->createUrl('pewarnaan', array('kelompokpemeriksaanmikro_id' => $data->kelompokpemeriksaanmikro_id,'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id, 'pemeriksaanpewarnaan_id'=>$data->pemeriksaanpewarnaan_id)), array('class' => 'btn btn-blue'));
                echo !$data->is_pemeriksaancci ? "" : CHtml::link('CCI', 'javascript:;', array('class' => 'btn btn-green'));
                echo !$data->is_pemeriksaanpcr ? "" : CHtml::link('PCR COVID', $this->createUrl('pcrCovid', array('pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id, 'daftartindakan_id'=>$tindakan->daftartindakan_id, 'tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id)), array('class' => 'btn btn-orange'));
                echo !$data->is_pemeriksaanviralload ? "" : CHtml::link('VIRAL LOAD', $this->createUrl('viralLoad', array('pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id)), array('class' => 'btn btn-red'));
                echo !$data->is_pemeriksaantbc ? "" : CHtml::link('TBC', $this->createUrl('Tbc', array('pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id)), array('class' => 'btn btn-blue-rev'));
                echo '</div>';
                echo '</center>';
            },
        ),
        array(
            'header' => 'Lihat Detail',
            'type' => 'raw',
            'value' => function ($data) {
                $onclick = "return false;";
                if ($data->is_pemeriksaanpcr) {
                    $onclick = "printRiwayatPCR(".$data->pemeriksaanpcr_id."); return false";
                }
    
                if($data->is_pemeriksaankultur) {
                    $onclick = "printKultur(".$data->pemeriksaankultur_id."); return false";
                }
    
                if($data->is_pemeriksaanpewarnaan) {
                    $onclick = "printPewarnaan2(".$data->pemeriksaanpewarnaan_id."); return false";
                }

                if($data->is_pemeriksaancci) {
                    $onclick = "printCci(".$data->pemeriksaancci_id."); return false";
                }

                echo CHtml::link('<i class="icon-form-print"></i>', '#', array('onclick'=>$onclick));

            }

        ),
        array(
            'header' => 'Edit',
            'type' => 'raw',
            'value' => function ($data) use (&$tindakan) {


                $updateLink = "#";
                $updateLinkTemp = "#";
                
                $updateLinkTemp = $updateLink;

                echo Chtml::hiddenField('update-link',$updateLinkTemp,array('class'=>'update-link'));


                if($data->is_validasi) {
                    $updateLink = 'javascript::void(0);';
                }

                if ($data->is_pemeriksaanpcr) {
                    $updateLink = $this->createUrl('pcrCovid', array('pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id, 'daftartindakan_id'=>$tindakan->daftartindakan_id, 'tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id, 'pemeriksaanpcr_id'=>$data->pemeriksaanpcr_id));
                    
                }
    
                if($data->is_pemeriksaankultur) {
                    $updateLink = $this->createUrl('kultur', array('kelompokpemeriksaanmikro_id' => $data->kelompokpemeriksaanmikro_id, 'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id, 'pemeriksaankultur_id'=>$data->pemeriksaankultur_id));
                }
    
                if($data->is_pemeriksaanpewarnaan) {
                    $updateLink = $this->createUrl('pewarnaan', array('kelompokpemeriksaanmikro_id' => $data->kelompokpemeriksaanmikro_id, 'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id, 'pemeriksaanpewarnaan_id'=>$data->pemeriksaanpewarnaan_id));
                }

                if($data->is_pemeriksaancci) {
                    $updateLink = $this->createUrl('CCI', array('kelompokpemeriksaanmikro_id' => $data->kelompokpemeriksaanmikro_id, 'pasienmasukpenunjang_id' => $data->pasienmasukpenunjang_id, 'jenispemeriksaanlab_id'=>$data->tindakanpelayanan->jenispemeriksaanlab_id, 'pemeriksaancci_id' => $data->pemeriksaancci_id));
                }

                if($data->is_kirimhasil) {
                    $updateLink = 'javascript:myAlert("Hasil Sudah Dikirim")';
                }

                echo CHtml::link('<i class="icon-form-ubah"></i>', $updateLink, array('rel'=>'tooltip', 'title'=>'Klik untuk mengubah hasil pemeriksaan', 'disabled'=>false, 'class'=>'ubah-pemeriksaan'));

            }

        ),

        array(
            'header' => 'Validasi',
            'type' => 'raw',
            'value' => function ($data) {

                $peg_login = Yii::app()->user->getState('pegawai_id');
                // $onclick = 'myAlert("Hanya dokter DPJP yang dapat mengganti")';

                $onclick = 'validasi('.$data->kelompokpemeriksaanmikro_id.',this);';

                if($peg_login == $data->dpjp_id) {
                    $onclick = 'validasi('.$data->kelompokpemeriksaanmikro_id.',this);';
                }

                $btn_validasi = 'btn btn-primary';
                $txt_validasi = 'Validasi';

                $click_kirim = 'javascript::void(0);';

                if($data->is_validasi) {
                    $btn_validasi = 'btn btn-danger';
                    $txt_validasi = 'Batal Validasi';
                } 

                echo CHtml::link($txt_validasi, '', array('rel'=>'tooltip', 'title'=>'Klik untuk salin/duplikat hasil pemeriksaan', 'class'=>$btn_validasi, 'onclick'=>$onclick));
            }
        ),

        array(
            'header' => 'Kirim Hasil',
            'type' => 'raw',
            'value' => function ($data) {

                $peg_login = Yii::app()->user->getState('pegawai_id');
                $onclick = 'myAlert("Hanya dokter DPJP yang dapat mengganti")';

                $btn_kirim = 'btn btn-blue-disabled';
                $txt_kirim = 'Kirim';

                $click_kirim = 'javascript::void(0);';

                if($data->is_validasi) {
                    $btn_kirim = 'btn btn-blue';
                    $click_kirim = 'kirimHasil('.$data->kelompokpemeriksaanmikro_id.',this);';
                } 
                
                if($data->is_kirimhasil) {
                    $txt_kirim = 'Batal Kirim';
                }

                echo CHtml::link($txt_kirim, '', array('rel'=>'tooltip', 'title'=>'Klik untuk salin/duplikat hasil pemeriksaan', 'class'=>$btn_kirim . ' kirim-hasil', 'onclick'=>$click_kirim));            }
        ),

       
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
?>




<script>
function printRiwayatPCR(id) {
    window.open(
        '<?php echo $this->createUrl('/mikrobiologiKlinik/daftarPasien/printPcr'); ?>&pemeriksaanpcr_id=' + id,
        'printwin', 'left=100,top=100,width=640,height=480');
}

function printKultur(id) {
    window.open(
        '<?php echo $this->createUrl('/mikrobiologiKlinik/daftarPasien/printKultur'); ?>&pemeriksaankultur_id=' +
        id,
        'printwin', 'left=100,top=100,width=640,height=480');
}
function printCci(pemeriksaancci_id) {
    window.open(
        '<?php echo $this->createUrl('/mikrobiologiKlinik/daftarPasien/printCci'); ?>' + '&pemeriksaancci_id=' + pemeriksaancci_id,
        'printwin', 'left=100,top=100,width=720,height=960');
}
function printPewarnaan2(id) {
    console.log('tes print pewarnaan');
    window.open(
        '<?php echo $this->createUrl('/mikrobiologiKlinik/daftarPasien/printPewarnaan'); ?>&pemeriksaanpewarnaan_id=' +
        id,
        'printwin', 'left=100,top=100,width=640,height=480');
}

function validasi(id, obj) {

    var update_link = $(obj).closest('tr').find('.update-link').val();
    var tbl_ubah = $(obj).closest('tr').find('.ubah-pemeriksaan').attr('href');
    var click_kirim = $(obj).closest('tr').find('.click-kirim').val();

    myConfirm('Apakah Sudah Yakin?', 'Peringatan', function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('validasi'); ?>', {
                id: id
            }, function(data) {
                if (data.ok == 1) {
                    if (tbl_ubah == 'javascript::void(0);') {
                        $(obj).closest('tr').find('.ubah-pemeriksaan').attr('href', update_link);
                        $(obj).removeClass('btn-danger');
                        $(obj).addClass('btn-primary');
                        $(obj).closest('a').html('Validasi');
                        $(obj).closest('tr').find('.kirim-hasil').attr('onclick', '');
                        $(obj).closest('tr').find('.kirim-hasil').removeClass('btn-blue');
                        $(obj).closest('tr').find('.kirim-hasil').addClass('btn-blue-disabled');
                    } else {
                        $(obj).closest('tr').find('.ubah-pemeriksaan').attr('href',
                            'javascript::void(0);');
                        $(obj).removeClass('btn-primary');
                        $(obj).addClass('btn-danger');
                        $(obj).closest('a').html('Batal Validasi');
                        $(obj).closest('tr').find('.kirim-hasil').attr('onclick', click_kirim);
                        $(obj).closest('tr').find('.kirim-hasil').removeClass('btn-blue-disabled');
                        $(obj).closest('tr').find('.kirim-hasil').addClass('btn-blue');
                    }
                    $.fn.yiiGridView.update('kelompok-grid');

                } else {
                    myAlert('Perubahan validasi gagal dilakukan');
                }
            }, 'json');
        }
    });
}


function kirimHasil(id, obj) {

    var update_link = $(obj).closest('tr').find('.update-link').val();
    var tbl_ubah = $(obj).closest('tr').find('.ubah-pemeriksaan').attr('href');


    myConfirm('Apakah Sudah Yakin?', 'Peringatan', function(r) {
        if (r) {
            $.post('<?php echo $this->createUrl('kirimHasil'); ?>', {
                id: id
            }, function(data) {
                if (data.ok == 1) {
                    if (tbl_ubah == 'javascript::void(0);') {
                        $(obj).closest('tr').find('.ubah-pemeriksaan').attr('href', update_link);
                        $(obj).html('Kirim');
                    } else {
                        $(obj).closest('tr').find('.ubah-pemeriksaan').attr('href',
                            'javascript::void(0);');
                        $(obj).html('Batal Kirim');
                    }
                } else {
                    myAlert('Perubahan validasi gagal dilakukan');
                }
            }, 'json');
            $.fn.yiiGridView.update('kelompok-grid');
        }
    });
}
</script>