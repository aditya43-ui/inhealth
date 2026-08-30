<?php

/**
 * view ini digunakan untuk menampilkan informasi pasien mcu dalam bentuk tabel
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
?>
<div class="panel panel-success" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Pasien MCU</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id' => 'daftarpasien-v-grid',
            'replaceUrl' => true,
            'dataProvider' => $model->searchDaftarPasienMcu(),
            'template' => "{summary}\n{items}\n{pager}",
            'itemsCssClass' => 'table table-striped table-condensed',
            'columns' => array(
                array(
                    'name' => 'tglrenkontrol',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tglrenkontrol)',
                ),
                array(
                    'name' => 'tgl_pendaftaran',
                    'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
                ),
                array(
                    'name' => 'No_pendaftaran',
                    'type' => 'raw',
                    'value' => '$data->no_pendaftaran',
                ),
                array(
                    'header' => 'No. Rekam Medik/<br>Nama Pasien Alias/<br>Alamat/<br>RT/RW',
                    'type' => 'raw',
                    'value' => function ($data) {
                        echo "<b>".$data->no_rekam_medik."</b>" . "<br>";
                        echo "<b>".$data->nama_pasien."</b>" . "<br>" . $data->nama_bin . "<br>";
                        echo $data->alamat_pasien . "<br>" . $data->RTRW . "<br>";
                    },
                ),

                array(
                    'name' => 'Penjamin<br>Jenis Penjamin',
                    'type' => 'raw',
                    'value' => '"$data->penjamin_nama"."<br>"."$data->carabayar_nama"',
                ),
                array(
                    'header' => 'DPJP',
                    'type' => 'raw',
                    'value' => function ($data) use (&$admisi) {
                        $pegawai = PegawaiM::model()->findByPk($data->pegawai_id);
                        if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {
                            return $pegawai->namaLengkap;
                        } else {
                            if (!empty($admisi)) return $pegawai->namaLengkap;
                            return CHtml::link("<span style='font-size:16px;'><i class='icon-form-ubah'></i></span>" . $pegawai->namaLengkap, " ", array("onclick" => "ubahDokterPeriksa('$data->pendaftaran_id');$('#editDokterPeriksa').dialog('open');return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Mengubah Data Dokter Penanggung Jawab"));
                        }
                    },
                    'htmlOptions' => array(
                        'class' => 'rajal'
                    )
                ),
                array(
                    'header' => 'PPJP',
                    'type' => 'raw',
                    'value' => function ($data) use (&$admisi) {

                        $ppjp = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                        if (!empty($ppjp->ppjp_id)) {
                            if ($data->statusperiksa == Params::STATUSPERIKSA_SUDAH_PULANG) {

                                return $ppjp->perawatPJP->namaLengkap;
                            } else {
                                if (!empty($admisi)) return $ppjp->perawatPJP->namaLengkap;
                                return CHtml::link("<span style='font-size:16px;'><i class='icon-form-ubah'></i></span>" . $ppjp->perawatPJP->namaLengkap, " ", array("onclick" => "ubahPerawatPJP('$data->pendaftaran_id');$('#editPerawatPJP').dialog('open');return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Mengubah Data Perawat Penanggung Jawab", "class" => 'ppjp'));
                            }
                        } else {
                            //return CHtml::link("<span style='font-size:16px;'><i class='".MyIcon::getIcons('ubah')."'></i></span>","javascript:;",array("onclick"=>"tambahPPJP(this,'$data->pendaftaran_id');", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik untuk Menambah Data Perawat Penanggung Jawab","class"=>'ppjp'));
                            return CHtml::link("<span style='font-size:16px;'><i class='icon-form-ubah'></i></span>", " ", array("onclick" => "ubahPerawatPJP('$data->pendaftaran_id');$('#editPerawatPJP').dialog('open');return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Menambahkan Data Perawat Penanggung Jawab", "class" => 'ppjp'));
                        }
                    },
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;', 'class' => 'list_ppjp'),
                ),
                array(
                    'header' => 'Kasus Penyakit ',
                    'type' => 'raw',
                    'value' => 'CHtml::hiddenField("RJInfokunjunganrV[$data->pendaftaran_id][pendaftaran_id]", $data->pendaftaran_id, array("id"=>"pendaftaran_id","onkeypress"=>"return $(this).focusNextInputField(event)","class"=>"span3")).$data->jeniskasuspenyakit_nama',
                ),
                array(
                    'name' => 'Riwayat Vaksinasi/Imunisasi',
                    'type' => 'raw',
                    // 'value' => '',
                    'value' => function ($data) {
                        return CHtml::link('<i class="icon-form-detail"></i>', Yii::app()->controller->createUrl('/pendaftaranPenjadwalan/pendaftaranRawatJalan/updateRiwayatVaksinasi', array(
                            'pendaftaran_id'=>$data->pendaftaran_id,
                        )), array(
                            'target'=>'frameRiwayatVaksinasi',
                            'onclick'=>"$('#dialogRiwayatVaksinasi').dialog('open');",
                        ));
                    },
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                ),
                array(
                    'header' => 'Paket Pemeriksaan',
                    'type' => 'raw',
                    'value' => function ($data) {
                        $hasil = '';
                        $pendaftaran = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                        if (isset($pendaftaran)) {
                            $modTIndakanPelayanan = TindakanpelayananT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran->pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));
                            if (isset($modTIndakanPelayanan)) {
                                $modTipePaket = TipepaketM::model()->findByPk($modTIndakanPelayanan->tipepaket_id);
                                if ($modTipePaket->tipepaket_id == 1) {
                                    $hasil = 'Non Paket';
                                } else {
                                    $hasil = 'Paket';
                                }
                            }
                        }

                        if ($data->statusperiksa == Params::STATUSPERIKSA_ANTRIAN && empty($data->pembayaranpelayanan_id)) {
                            $update = "&nbsp;" . CHtml::link("<i class='icon-form-ubah'></i>", Yii::app()->controller->createUrl("PendaftaranPasien/UpdatePaketTindakanPasien", array("pendaftaran_id" => $data->pendaftaran_id)), array("rel" => "tooltip", "title" => "Ubah Paket/Tindakan Pasien"));
                        } else if ($data->statusperiksa == Params::STATUSPERIKSA_SEDANG_PERIKSA && empty($data->pembayaranpelayanan_id)) {
                            $update = "&nbsp;" . CHtml::link("<i class='icon-form-ubah'></i>", Yii::app()->controller->createUrl("PendaftaranPasien/UpdatePaketTindakanPasien", array("pendaftaran_id" => $data->pendaftaran_id)), array("rel" => "tooltip", "title" => "Ubah Paket/Tindakan Pasien"));
                        } else {
                            $update = null;
                        }

                        return $hasil . CHtml::link("<i class=\"icon-form-verifikasi\" style=\"filter: hue-rotate(240deg);\"></i>", Yii::app()->controller->createUrl("RincianPaketMCU", array("pendaftaran_id" => $data->pendaftaran_id, "frame" => true)), array("target" => "frameRincianPaket", "rel" => "tooltip", "title" => "Lihat rincian Paket/Non Paket", "onclick" => "$('#dialogRincianPaket').dialog('open');")) . $update;
                    },
                    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                ),
                /* array(
                    'header'=>'Rincian Paket/Non Paket',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<icon class=\'icon-form-detail\' ></icon> ", Yii::app()->controller->createUrl("RincianPaketMCU", array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincianPaket","rel"=>"tooltip", "title"=>"lihat rincian Paket/Non Paket", "onclick"=>"$(\'#dialogRincianPaket\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px ')                  
                ),  */
                array(
                    'header' => 'Riwayat Pemeriksaan',
                    'type' => 'raw',
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                    'value' => function ($data) {
                        echo CHtml::link("<i class='icon-form-ubah'></i>", Yii::app()->createUrl('mcu/informasiDaftarPasienMC/riwayatPemeriksaan&pendaftaran_id=' . $data->pendaftaran_id), array("rel" => "tooltip", "title" => "Klik untuk Melihat Riwayat Pemeriksaan Pasien", "style" => "align: center"));
                    },
                ),
                array(
                    'header' => 'Status Periksa',
                    'type' => 'raw',
                    'value' => '$data->getStatus($data->statusperiksa,$data->pendaftaran_id)',
                    'htmlOptions' => array('style' => 'text-align:center;')
                ),
                // RSIH-540
                // array(
                //     'name' => 'Asesmen Pasien',
                //     'type' => 'raw',
                //     'value' => '((($data->alihstatus==FALSE) || (!empty($data->konsulPoli($data->pendaftaran_id)))) ? CHtml::link("<i class=\'icon-form-periksa\'></i> ", Yii::app()->controller->createUrl("/mcu/pemeriksaanAsesmenPasienMC",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien MCU")): CHtml::link("<i class=\'icon-list-alt\'></i>", "javascript:cektindaklanjut()",array("rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien MCU")))',
                //     'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                // ),
                array(
                    'name' => 'Periksa Pasien',
                    'type' => 'raw',
                    'value' => '((($data->alihstatus==FALSE) || (!empty($data->konsulPoli($data->pendaftaran_id)))) ? CHtml::link("<i class=\'icon-form-periksa\'></i> ", Yii::app()->controller->createUrl("/mcu/pemeriksaanPasienMC",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien MCU")): CHtml::link("<i class=\'icon-list-alt\'></i>", "javascript:cektindaklanjut()",array("rel"=>"tooltip","title"=>"Klik untuk Pemeriksaan Pasien MCU")))',
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                ),
                array(
                    'name' => 'Ambil Hasil',
                    'type' => 'raw',
                    'value' => '((($data->alihstatus==FALSE) || (!empty($data->konsulPoli($data->pendaftaran_id)))) ? '
                        . ' (($data->pembayaranpelayanan_id != "") ? '
                        . ' (($data->ambilHasil($data->pendaftaran_id) == "") ? 
                             CHtml::Link("<i class=\'icon-form-verifikasi\'></i>",Yii::app()->controller->createUrl("InformasiDaftarPasienMC/ambilHasil",array("pendaftaran_id"=>$data->pendaftaran_id, "frame"=>1,"popup"=>"true")),
                                    array("class"=>"", 
                                        "target"=>"iframeAmbilHasil",
                                        "onclick"=>"$(\"#dialogAmbilHasil\").dialog(\"open\");",
                                        "rel"=>"tooltip",
                                        "title"=>"Klik untuk Pengambilan Hasil", 
                                        )) : "Pengambilan Hasil ".$data->ambilHasil($data->pendaftaran_id) )
                        : "" ) '
                        . ' : CHtml::link("<i class=\'icon-list-alt\'></i>", "javascript:cektindaklanjut()",array("rel"=>"tooltip","title"=>"Klik untuk Pengambilan Hasil")))',
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                ),
                /*array(
                    'header'=>'Detail Rincian Tagihan',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<icon class=\'icon-form-detailtagihan\' ></icon> ", Yii::app()->controller->createUrl("PrintDetailRincianBelumBayar", array("instalasi_id"=>$data->instalasi_id,"pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"lihat detail rincian tagihan pasien", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px ')                  
                ),  
		), 
                array(
                    'header'=>'Rincian Tagihan',
                    'type'=>'raw',
                    'value'=>'CHtml::link("<icon class=\'icon-form-detail\' ></icon> ", Yii::app()->controller->createUrl("RincianTagihanPasien", array("pendaftaran_id"=>$data->pendaftaran_id,"frame"=>true)), array("target"=>"frameRincian","rel"=>"tooltip", "title"=>"lihat rincian tagihan pasien", "onclick"=>"$(\'#dialogRincian\').dialog(\'open\');"))','htmlOptions'=>array('style'=>'text-align: center; width:40px ')                  
                ),*/
                array(
                    'header' => 'Batal Periksa',
                    'type' => 'raw',
                    'value' => 'CHtml::link("<i class=\'icon-form-silang\'></i>", "javascript:batalperiksa($data->pendaftaran_id)",array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk membatalkan pemeriksaan"))',
                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                ),
            ),
            'afterAjaxUpdate' => 'function(id, data){
                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                }',
        )); ?>
    </div>
</div>


<?php
//=============================== Dialog Riwayat Vaksinasi =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogRiwayatVaksinasi',
        'options' => array(
            'title' => 'Riwayat Vaksinasi/Imunisasi',
            'autoOpen' => false,
            'zIndex' => 1002,
            'width' => 1000,
            'height' => 450,
            'resizable' => true,
            'close' => "js:function(){ $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                        data: $('#formCari').serialize()
                    }); }",
        ),
    )
);

echo '<iframe name="frameRiwayatVaksinasi" style="width: 100%; height: 98%;"></iframe>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?> 

<script type="text/javascript">
    {
        function batalperiksa(pendaftaran_id) {
            myConfirm("Anda yakin akan membatalkan pemeriksaan rawat jalan pasien ini?", "Perhatian!", function(r) {
                if (r) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . 'batalPeriksa'); ?>',
                        data: {
                            pendaftaran_id: pendaftaran_id
                        }, //
                        dataType: "json",
                        success: function(data) {
                            if (data.status == true) {
                                myAlert(data.pesan);
                                $.fn.yiiGridView.update('daftarpasien-v-grid', {
                                    data: $(this).serialize()
                                });
                            } else if (data.pesan == 'exist') {
                                myAlert('Pasien telah melakukan pemeriksaan');
                            } else if (data.pesan == 'NoBatal') {
                                myAlert('Pemeriksaan tidak bisa dibatalkan karena Pasien telah melakukan pembayaran');
                            } else {
                                myAlert(data.pesan);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(errorThrown);
                        }
                    });
                }
            });
        }
        //validasi pemeriksaan
        function cektindaklanjut() {
            myAlert("Pasien sudah ditindak lanjut ke Rawat Inap!");
        }

        function ubahPerawatPJP(pendaftaran_id) {
            $('#temp_idPendaftaranPPJP').val(pendaftaran_id);
            jQuery.ajax({
                'url': '<?php echo $this->createUrl('ubahPerawatPJP') ?>',
                'data': $(this).serialize(),
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    if (data.status == 'create_form') {
                        $('#editPerawatPJP div.divForFormEditPerawatPJP').html(data.div);
                        $('#editPerawatPJP div.divForFormEditPerawatPJP form').submit(ubahPerawatPJP);
                        loadDataPendaftaran();
                    } else {
                        $('#editPerawatPJP div.divForFormEditPerawatPJP').html(data.div);
                        $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            data: $('form').serialize()
                        });
                        setTimeout("$('#editPerawatPJP').dialog('close') ", 500);
                    }
                },
                'cache': false
            });
            return false;
        }

        function ubahDokterPeriksa(pendaftaran_id) {
            $('#temp_idPendaftaranDP').val(pendaftaran_id);
            jQuery.ajax({
                'url': '<?php echo $this->createUrl('ubahDokterPeriksa', array('menu' => 'MCU')) ?>',
                'data': $(this).serialize(),
                'type': 'post',
                'dataType': 'json',
                'success': function(data) {
                    if (data.status == 'create_form') {
                        $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                        $('#editDokterPeriksa div.divForFormEditDokterPeriksa form').submit(ubahDokterPeriksa);
                        loadDataPendaftaranDokter();
                    } else {
                        $('#editDokterPeriksa div.divForFormEditDokterPeriksa').html(data.div);
                        $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            data: $(this).serialize()
                        });
                        setTimeout("$('#editDokterPeriksa').dialog('close') ", 500);
                    }
                },
                'cache': false
            });
            return false;
        }

        function tambahPPJP(obj, pendaftaran_id) {
            var pendaftaran_id = pendaftaran_id;

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('/ActionDynamic/SetDropdownPPJP'); ?>',
                data: {
                    pendaftaran_id: pendaftaran_id
                },
                dataType: "json",
                success: function(data) {
                    $(obj).parents('tr').find('.list_ppjp').append(data.dropPPJP);
                    $(obj).parents('td').find('.ppjp').hide();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
            return false;
        }

        function savePPJP(obj, pendaftaran_id) {
            var ppjp_id = $(obj).val();
            var pendaftaran_id = pendaftaran_id;

            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('savePPJP'); ?>',
                data: {
                    pendaftaran_id: pendaftaran_id,
                    ppjp_id: ppjp_id
                },
                dataType: "json",
                success: function(data) {
                    if (data.pesan == 'berhasil') {
                        window.parent.myAlert('Data PPJP berhasil di tambah');
                        $.fn.yiiGridView.update('daftarpasien-v-grid', {
                            data: $(this).serialize()
                        });
                    } else {
                        window.parent.myAlert('Data PPJP gagal di ubah');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
            return false;
        }
    }
</script>