<?php $this->renderPartial($this->path_view . '_tombolPrinout', array()); ?>
<br />
<?php
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'datariwayatprofil-grid',
    'dataProvider' => $modDaftar->searchRiwayatPRMRJ(),
    'filter' => $modDaftar,
    'ajaxUrl' => $this->createUrl('checkData'),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'No',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
        ),
        array(
            'header' => 'Tanggal Kunjungan',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)',
            'filter' => CHtml::activeHiddenField($modDaftar, 'pendaftaran_id') .
                CHtml::activeHiddenField($modDaftar, 'pasien_id') .
                CHtml::activeHiddenField($modDaftar, 'isprmrj') .
                CHtml::activeHiddenField($modDaftar, 'instalasi_id') . CHtml::activeCheckBox($modDaftar, 'ceklispendaftaran')
                . ' ' . CHtml::activeTextField($modDaftar, 'tgl_pendaftaran', array('class' => 'span3', 'readonly' => true)),
        ),
        array(
            'header' => 'Ruangan',
            'type' => 'raw',
            'value' => '$data->ruangan_nama',
            'filter' => CHtml::activeDropDownList($modDaftar, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true order by ruangan_nama desc'), 'ruangan_id', 'ruangan_nama'), array('empty' => '- Pilih -'))
        ),
        array(
            'header' => 'Dokter Pemeriksa',
            'type' => 'raw',
            'value' => function ($data) {
                $pegawaiM = PegawaiM::model()->findByPk($data->pegawai_id);
                return (isset($pegawaiM) ? $pegawaiM->namaLengkap : "");
            },
            'filter' => CHtml::activeDropDownList($modDaftar, 'pegawai_id', CHtml::listData(DokterV::model()->findAll(), 'pegawai_id', 'namaLengkap'), array('empty' => '- Pilih -'))
        ),
        array(
            'header' => 'Diagnosa',
            'type' => 'raw',
            'value' => function ($data) {
                $modPasienMobid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $data->pendaftaran_id, 'ruangan_id' => $data->ruangan_id));
                $htmlMobid = "";

                if (count($modPasienMobid) > 0) {
                    $htmlDiagnosaUtama = "";
                    $htmlDiagnosa = "";
                    $indexU = 0;
                    $indexT = 0;
                    foreach ($modPasienMobid as $dataMorbid) {
                        if ($dataMorbid->kelompokdiagnosa_id == 2) {
                            if ($indexU > 0) {
                                $htmlDiagnosaUtama .= "<br/>";
                            }
                            $htmlDiagnosaUtama .= '- ' . $dataMorbid->diagnosa->diagnosa_nama;
                            $indexU++;
                        } else if ($dataMorbid->kelompokdiagnosa_id == 3) {
                            if ($indexT > 0) {
                                $htmlDiagnosaUtama .= "<br/>";
                            }
                            $htmlDiagnosa .= '- ' . $dataMorbid->diagnosa->diagnosa_nama;
                            $indexT++;
                        }
                    }
                    $htmlMobid .= "Diagnosa Utama <br/> " . $htmlDiagnosaUtama . " <br/>Diagnosa <br/> " . $htmlDiagnosa;
                }

                return $htmlMobid;
            },
            'filter' => CHtml::activeTextField($modDaftar, 'diagnosa_nama', array('class' => 'span3'))
        ),
        array(
            'header' => 'ICD-X',
            'type' => 'raw',
            'value' => function ($data) {
                $modPasienMobid = PasienmorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $data->pendaftaran_id, 'ruangan_id' => $data->ruangan_id));
                $htmlMobid = "";

                if (count($modPasienMobid) > 0) {
                    $htmlDiagnosaUtama = "";
                    $htmlDiagnosa = "";
                    $indexU = 0;
                    $indexT = 0;
                    foreach ($modPasienMobid as $dataMorbid) {
                        if ($dataMorbid->kelompokdiagnosa_id == 2) {
                            if ($indexU > 0) {
                                $htmlDiagnosaUtama .= "<br/>";
                            }
                            $htmlDiagnosaUtama .= '- ' . $dataMorbid->diagnosa->diagnosa_kode;
                            $indexU++;
                        } else if ($dataMorbid->kelompokdiagnosa_id == 3) {
                            if ($indexT > 0) {
                                $htmlDiagnosaUtama .= "<br/>";
                            }
                            $htmlDiagnosa .= '- ' . $dataMorbid->diagnosa->diagnosa_kode;
                            $indexT++;
                        }
                    }
                    $htmlMobid .= "Diagnosa Utama <br/> " . $htmlDiagnosaUtama . " <br/>Diagnosa <br/> " . $htmlDiagnosa;
                }

                return $htmlMobid;
            },
            'filter' => CHtml::activeTextField($modDaftar, 'diagnosa_kode', array('class' => 'span3'))
        ),
        array(
            'header' => 'Pemeriksaan Penunjang',
            'type' => 'raw',
            'value' => function ($data) {
                $modPasienPenunj = PasienmasukpenunjangT::model()->findAllByAttributes(array('pendaftaran_id' => $data->pendaftaran_id, 'ruanganasal_id' => $data->ruangan_id));
                $html = "";

                if (count($modPasienPenunj) > 0) {
                    $htmlLab = "";
                    $htmlRad = "";
                    $iR = 0;
                    $iL = 0;
                    foreach ($modPasienPenunj as $dataPenunj) {
                        $tindakanpel = TindakanpelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $dataPenunj->pasienmasukpenunjang_id));
                        $daftartindakan = (isset($tindakanpel) ? (isset($tindakanpel->daftartindakan) ? $tindakanpel->daftartindakan->daftartindakan_nama : "") : "");

                        if ($dataPenunj->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK) {
                            if ($iL > 0) {
                                $htmlLab .= "<br/>";
                            }
                            $htmlLab .= '- ' . $daftartindakan;
                            $iL++;
                        } else if ($dataPenunj->ruangan_id == Params::RUANGAN_ID_RAD) {
                            if ($iR > 0) {
                                $htmlRad .= "<br/>";
                            }
                            $htmlRad .= '- ' . $daftartindakan;
                            $iR++;
                        }
                    }
                    if ($iL > 0) {
                        $html .= "- Laboratorium <br />" . $htmlLab;
                    }
                    if ($iR > 0) {
                        $html .= "- Radiologi <br />" . $htmlRad;
                    }
                }

                return $html;
            }
        ),
        array(
            'header' => 'Obat-Obatan',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::link("<i class='icon-form-detail'></i> ", Yii::app()->controller->createUrl("pemeriksaanPasien/ObatObatanPasien", array("id" => $data->pendaftaran_id)), array("id" => "$data->no_pendaftaran", "target" => "dlgObatObatan", "rel" => "tooltip", "title" => "Klik untuk Obat - Obatan", "onclick" => "window.parent.$('#dialogObatObatan').dialog('open');"));
            }
        ),
        array(
            'header' => 'Riwayat Rawat Inap sejak Kunjungan Terakhir',
            'type' => 'raw',
            'value' => function ($data) {
                $criteria = new CDbCriteria();
                $criteria->select = "t.pendaftaran_id, pasienadmisi_t.tgladmisi, pasienpulang_t.tglpasienpulang";
                $criteria->group = $criteria->select;
                $criteria->join = "JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = t.pasienadmisi_id "
                    . "LEFT JOIN pasienpulang_t ON pasienpulang_t.pasienpulang_id = pasienadmisi_t.pasienpulang_id";
                $criteria->addCondition('t.pasien_id =' . $data->pasien_id);
                $criteria->order = "t.pendaftaran_id desc";
                $criteria->limit = 2;

                $modDaftar = PendaftaranT::model()->findAll($criteria);
                $html = "";

                if (count($modDaftar) > 0) {
                    $html .= "Ya <br/>";
                    foreach ($modDaftar as $i => $dataDaftar) {
                        if ($i > 0) {
                            $html .= "<br/>";
                        }
                        $html .= "- " . date('d M Y', strtotime(MyFormatter::formatDateTimeForDb($dataDaftar->tgladmisi))) . ' s.d ' . (!empty($dataDaftar->tglpasienpulang) ? date('d M Y', strtotime(MyFormatter::formatDateTimeForDb($dataDaftar->tglpasienpulang))) : "-");
                    }
                } else {
                    $html = "Tidak";
                }

                return $html;
            }
        ),
        array(
            'header' => 'Prosedur Bedah/ Operasi sejak Kunjungan Terkahir',
            'type' => 'raw',
            'value' => function ($data) {
                $criteria = new CDbCriteria();
                $criteria->select = "t.pasienmasukpenunjang_id, rencanaoperasi_t.mulaioperasi, daftartindakan_m.daftartindakan_nama";
                $criteria->group = $criteria->select;
                $criteria->join = " LEFT JOIN rencanaoperasi_t ON rencanaoperasi_t.pasienmasukpenunjang_id = t.pasienmasukpenunjang_id "
                    . "JOIN tindakanpelayanan_t ON tindakanpelayanan_t.tindakanpelayanan_id = rencanaoperasi_t.tindakanpelayanan_id "
                    . "JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = tindakanpelayanan_t.daftartindakan_id";
                $criteria->addCondition('t.pasien_id =' . $data->pasien_id);
                $criteria->addCondition('t.ruangan_id =' . Params::RUANGAN_ID_BEDAH);
                $criteria->order = "t.pasienmasukpenunjang_id desc";
                $criteria->limit = 2;

                $modDaftar = PasienmasukpenunjangT::model()->findAll($criteria);
                $html = "";

                if (count($modDaftar) > 0) {

                $html .= "Ya <br/>";
                    foreach ($modDaftar as $i => $dataDaftar) {
                        if ($i > 0) {
                            $html .= "<br/>";
                        }


                        if (empty($dataDaftar->mulaioperasi)) {
                            $html .= "- ";
                        }else{

                            $html .= "- " . date('d M Y', strtotime(MyFormatter::formatDateTimeForDb($dataDaftar->mulaioperasi))) . '<br/> (' . $dataDaftar->daftartindakan_nama . ')';
                        }
                    }
                } else {
                    $html = "Tidak";
                }
                return $html;
            }
        ),
        array(
            'header' => 'Nama Petugas',
            'type' => 'raw',
            'value' => function ($data) {
                $pegawai = PegawaiM::model()->findByPk($data->petugaskesehatan_prmrj);
                return (isset($pegawai) ? $pegawai->namaLengkap : "");
            }
        ),
        array(
            'header' => 'Hapus',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::link('<i class="icon-trash"></i>', '#', array(
                    'onclick' => 'hapusPRMRJ(' . $data->pendaftaran_id . '); return false'
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            )
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
//                 jQuery(\'#implementasiaskep_tgl\').datepicker(jQuery.extend({
//                        showMonthAfterYear:false},
//                        jQuery.datepicker.regional[\'id\'],
//                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
//                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
//                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'}));
//                jQuery(\'#implementasiaskep_tgl_date\').on(\'click\', function(){jQuery(\'#implementasiaskep_tgl\').datepicker(\'show\');});
                jQuery("#' . CHtml::activeId($modDaftar, 'tgl_pendaftaran') . '").daterangepicker({
                    "maxDate": "' . date('m/d/Y') . '",
                    "showDropdowns": true,
                },afterPilihTanggal);

            }',
));
?>



<script type="text/javascript">
    function printRiwayat(caraPrint) {
        window.open('<?php echo $this->createUrl('printPRMRJ'); ?>&' + $('#datariwayatprofil-grid').find('input, textarea, select').serialize() + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=793,height=1122,scrollbars=yes');
    }

    function hapusPRMRJ(id) {
        var pendaftaran_id = id; 
        myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('hapusPRMRJ'); ?>', {
                    pendaftaran_id: id
                }, function(data) {
                    if (data.sukses == 1) {
                        myAlert(data.msg);
                        var grid_id = $(parent.document).find('.isContent').find('#form-riwayatprofil').find('#content-riwayatprofil');

                        $.post('<?php echo $this->createUrl('/rawatJalan/pemeriksaanPasien/CheckData'); ?>', {
                            pendaftaran_id: pendaftaran_id
                        }, function(data) {
                            if (data != null) {
                                grid_id.find('.accordion-inner').html('');
                                grid_id.find('.accordion-inner').html(data);
                            }
                        }, 'html');

                        setRiwayatPasien(); 
                        
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }

    function afterPilihTanggal(start, end) {
        $.fn.yiiGridView.update('datariwayatprofil-grid', {
            data: $("#datariwayatprofil-grid thead :input").serialize()
        });
    }

    function refreshRingkasMedis(id) {
        $.post('<?php echo $this->createUrl('cekPRMRJ'); ?>', {
            pendaftaran_id: id
        }, function(data) {

            if (data != null) {
                $.fn.yiiGridView.update('datariwayatprofil-grid', {
                    data: $('#datariwayatprofil-grid').find('input, textarea, select').serialize()
                });
            }
        }, 'json');

    }

    $(document).ready(function() {
        $('input[name="PendaftaranT[tgl_pendaftaran]').daterangepicker({
            "maxDate": "<?php echo date('m/d/Y') ?>",
            "showDropdowns": true,
        }, afterPilihTanggal);
    });
</script>