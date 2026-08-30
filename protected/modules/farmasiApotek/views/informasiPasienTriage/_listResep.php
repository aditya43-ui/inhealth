<?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftarriwayat-v-grid',
    'dataProvider' => $modRiwatReseptur->searchRiwayat(),
    'template' => "{summary}\n{items}\n{pager}",
    "replaceUrl" => true,
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => [
        [
            'header' => 'No',
            'value' => '$row+1',
        ],  [
            'header' => 'Tanggal Resep',
            'value' => function ($data) {
                return MyFormatter::formatDateTimeForUser($data->create_time);
            }
        ],
        [
            'header' => 'No Resep',
            'value' => function ($data) {
                return $data->noresep_triage;
            }
        ],
        [
            'header' => 'No Bed Triage',
            'type' => 'raw',
            'value' => function($data) {
                if(!empty($data->pendaftaran_id)) {
                    if(!empty($data->pendaftaran->pasien)) {
                        echo $data->pendaftaran->pasien->nama_pasien;
                    }
                }
            }
        ],
        [
            'header' => 'Jenis Penjamin/ <br> Penjamin/ <br> No. SEP/ <br> No. Kartu',
            'value' => function($data) {
                $str = $data->pendaftaran->carabayar->carabayar_nama ?? '';
                $str .= "<br/>" . $data->pendaftaran->penjamin->penjamin_nama ?? '';
                $str .= "<br>";
                $str .= $data->pendaftaran->sepTs->nosep ?? '';
                $str .= "<br>";
                $str .= $data->pendaftaran->sepTs->nokartuasuransi ?? '';
                echo $str;
            }
        ],
        [
            'header' => 'Petugas Farmasi',
            'value' => function ($data) {
                if(!empty($data->petugasfarmasi->namaLengkap)) {
                    echo $data->petugasfarmasi->namaLengkap;
                }
            }
        ],
        [
            'header' => 'Pengambil Obat',
            'value' => '$data->petugas_pengambil_obat'
        ],
        [
            'header' => 'Nama Obat',
            'value' => function($data) {
                if(!empty($data->obatalkes->obatalkes_nama)) {
                    echo $data->obatalkes->obatalkes_nama;
                }
            }
        ],
        'jumlah',
        [
            'header' => 'Etiket',
            'value' => function($data) {
                echo CHtml::link('<i class="icon-form-print"></i>', '', [
                    'onclick' => "printEtiketTriage('" . $data->pengambilanobat_triage_id . "')"
                ]);
            }
        ],
        [
            'header' => 'Ubah',
            'type' => 'raw',
            'value' => function ($data) {
                if($data->validasi) {
                    $html = CHtml::link('<i class="icon-form-ubah"></i>', '', [
                        'onclick' => "window.parent.myAlert('Data Tidak Dapat Diubah Karena sudah di Validasi')"
                    ]);
                } else {
                    $html = CHtml::link('<i class="icon-form-ubah"></i>', $this->createUrl('ubah', ['pengambilanobat_triage_id' => $data->pengambilanobat_triage_id]), [
                        'target' => 'iframeUbah',
                        'onclick' => "$('#dialogUbah').dialog('open')"
                    ]);
                }

                echo $html;
            }
        ],
        [
            'header' => 'Hapus',
            'type' => 'raw',
            'value' => function ($data) {
                $pemakai = LoginpemakaiK::model()->findByAttributes(['pegawai_id' => $data->pegawai_id]);
                $kelompokinput_id =  LoginpemakaiK::model()->findByAttributes(['pegawai_id' => $data->pegawai_id])->pegawai->kelompokpegawai_id;
                $kelompokperawat_id =  LoginpemakaiK::model()->findByPk(Yii::app()->user->getState('loginpemakai_id'))->pegawai->kelompokpegawai_id;

                if(empty($data->penjualanresep_id)){
                    if ($kelompokinput_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK || Yii::app()->user->getState('loginpemakai_id') == Params::PERANPENGGUNA_ID_ADMIN) {
                        if($pemakai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id') || Yii::app()->user->getState('loginpemakai_id') == Params::PERANPENGGUNA_ID_ADMIN) {
                            if($data->validasi) {
                                return "<center>" . CHtml::link("<i class='icon-trash'></i>",'#', array('rel' => 'tooltip', 'title' => 'Klik edit resep', 'onclick' => 'window.parent.myAlert("Tidak Dapat DIhapus, Sudah Divalidasi")' )) . "</center>";  
                            } else {
                                return "<center>" . CHtml::link("<i class='icon-trash'></i>",'#', array('rel' => 'tooltip', 'title' => 'Klik untuk menghapus Reseptur', 'onclick' => 'hapusresep('.$data->pengambilanobat_triage_id.')' )) . "</center>";  
                            }
                        } else {
                            return "<center>" . CHtml::link("<i class='icon-trash'></i>",'#', array('rel' => 'tooltip', 'title' => 'Klik edit resep', 'onclick' => 'window.parent.myAlert("Hanya dokter yang meresepkan yang dapat menghapus")' )) . "</center>";  
                        }
                    } else {
                        if ($kelompokperawat_id == Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN && $pemakai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id') || $kelompokperawat_id == Params::KELOMPOKPEGAWAI_ID_BIDAN && $pemakai->loginpemakai_id == Yii::app()->user->getState('loginpemakai_id') || $kelompokperawat_id == Params::KELOMPOKPEGAWAI_ID_PARAMEDIS_KEPERAWATAN) {
                            if($data->validasi) {
                                return "<center>" . CHtml::link("<i class='icon-trash'></i>",'#', array('rel' => 'tooltip', 'title' => 'Klik edit resep', 'onclick' => 'window.parent.myAlert("Tidak Dapat DIhapus, Sudah Divalidasi")' )) . "</center>";  
                            } else {
                                return "<center>" . CHtml::link("<i class='icon-trash'></i>",'#', array('rel' => 'tooltip', 'title' => 'Klik untuk menghapus Reseptur', 'onclick' => 'hapusresep('.$data->pengambilanobat_triage_id.')' )) . "</center>";  
                            }
                        } else {
                            return "<center>" . CHtml::link("<i class='icon-trash'></i>",'#', array('rel' => 'tooltip', 'title' => 'Klik edit resep', 'onclick' => 'window.parent.myAlert("Hanya perawat yang meresepkan yang dapat menghapus")' )) . "</center>";  
                        }
                    }
                }else{
                    return "<center>" . CHtml::link("<i class='icon-trash'></i>",'#', array('rel' => 'tooltip', 'title' => 'Klik edit resep', 'onclick' => 'window.parent.myAlert("Resep tidak bisa dihapus karena sudah dijual")' )) . "</center>";  
                }
            }
        ],
        [
            'header' => 'Validasi',
            'type' => 'raw',
            'value' => function($data) {
                if(!empty($data->pendaftaran_id)) {
                    if($data->validasi) {
                        return "<center>" . CHtml::link('<i class="fas fa-check-square" style="color:green"></i>','#', array('rel' => 'tooltip', 'title' => 'Klik untuk validasi Reseptur', 'onclick' => 'validasi('.$data->pengambilanobat_triage_id.')' )) . "</center>"; 
                        
                    } else {
                        return "<center>" . CHtml::link('<i class="fas fa-check-square" style="color:red"></i>','#', array('rel' => 'tooltip', 'title' => 'Klik untuk validasi Reseptur', 'onclick' => 'validasi('.$data->pengambilanobat_triage_id.')' )) . "</center>"; 
                    }
                } else {
                    return "<center>" . CHtml::link('<i class="fas fa-check-square" style="color:red"></i>','#', array('rel' => 'tooltip', 'title' => 'Klik untuk validasi Reseptur', 'onclick' => 'myAlert("Data Tidak Bisa Divalidasi Karena Belum Memiliki Pendaftaran")' )) . "</center>";
                }
            }
        ],
        [
            'header' => 'Ket',
            'type' => 'raw',
            'value' => '$data->keterangan'
        ]
    ],
    'afterAjaxUpdate' => 'function(id, data){
jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
)); ?>

<?php
echo CHtml::hiddenField('is_reseptur', (isset($_GET['reseptur_id']) ? $_GET['reseptur_id'] : null)); ?>
<script>
    function hapusresep(pengambilanobat_triage_id)
    {
        
        window.parent.myConfirm('Apakah anda akan menghapus Reseptur ini?', 'Perhatian!', function(r)
        {
            if(r){
                $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('hapus'); ?>',
                    data: {pengambilanobat_triage_id:pengambilanobat_triage_id},
                    dataType: "json",
                    success:function(data){
                        if(data.sukses == 1){
                            $.fn.yiiGridView.update('daftarriwayat-v-grid');
                            
                        } else {
                            myAlert('Data gagal Dihapus');
                        }
                        
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });

            }
        });
        
    }

    function refreshForm2(pendaftaran_id){
        window.location.href = "<?php echo Yii::app()->createUrl('rawatJalan/'.$this->id.'/index/&pendaftaran_id='.$_GET['pendaftaran_id']); ?>";
    }


    function cekVerifikasi(penjualanresep_id){
        if(penjualanresep_id != ""){
            window.parent.myAlert("Resep sudah diverifikasi di farmasi");
        }
    }

    const copy_reseptur = (reseptur_id) => {
        var hitung = 0;
        var rke = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
        $('#table-obatalkespasien > tbody > tr').each(function() {
            var det_id = $(this).find('.reseptur_id').val();
            if (reseptur_id == det_id) {
                hitung++;
            }
        });

        if (hitung >= 1) {
            window.parent.myAlert("Data Penjualan Resep sudah ada di tabel. Silahkan pilih yang lain.", "Perhatian!");
            return false;
        }

        if (rke == undefined) {
            rke = 1;
        } 
        // else {
        //     rke++;
        // }


        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('copyReseptur'); ?>',
            data: {
                reseptur_id: reseptur_id,
                rke: rke,
            },
            dataType: "json",
            success: function(data) {
                $('#table-obatalkespasien > tbody').append(data.tr);
                renameInputRowObatAlkes($("#table-obatalkespasien"));
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function cekValidasi(type) {
        var notriage_pasien_id = '<?= $_GET['notriage_pasien_id'] ?>';
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('cekValidasi'); ?>',
            data: {
                notriage_pasien_id: notriage_pasien_id,
                type:type
            },
            dataType: "json",
            success: function(data) {
                console.log(data, 'cekvalidasi')
                if(data.disabled == 1) {
                    $('#btn_reseptur').attr('disabled', true);
                } else {
                    $('#btn_reseptur').attr('disabled', false);
                }
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function validasi(pengambilanobat_triage_id) {
        myConfirm('Yakin Ingin memvalidasi ?', '! Perhatian', function(r){
            if(r) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('validasi'); ?>',
                    data: {
                        pengambilanobat_triage_id: pengambilanobat_triage_id,
                    },
                    dataType: "json",
                    success: function(data) {
                        if(data.sukses == 1) {
                            myAlert('Data Berhasil Di validasi');
                        } else {
                            myAlert('Data gagal divalidasi');
                        }
                        $.fn.yiiGridView.update('daftarriwayat-v-grid');
                        cekValidasi('saatvalidasi');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        })
    }

    
</script>
