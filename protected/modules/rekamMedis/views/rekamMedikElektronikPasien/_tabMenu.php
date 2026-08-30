<?php 
$module = '/'.$this->module->id;
$modInstalasi = InstalasiM::model()->findByPk(Yii::app()->user->getState("instalasi_id"));
$init = $modInstalasi->instalasi_singkatan;
$tabulasi_list = array();
$config = KonfigsystemK::model()->findbyPk(1);

$pemberianobat = $config->pemberian_obat;

    $tabulasi_list = array_merge($tabulasi_list, array(
        array('label'=>'Catatan Perkembangan Pasien Terintegrasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rekamMedis/CPPTRK/index')),
        )
    );

if($_GET['type'] == 'Perawat'){
    if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_PI,Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERSALINAN, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_IBS, Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_TINDAKAN, Params::INSTALASI_ID_TINDAKAN2, Params::INSTALASI_ID_TINDAKAN3, Params::INSTALASI_ID_TINDAKAN4, Params::INSTALASI_ID_TINDAKAN5, Params::INSTALASI_ID_TINDAKAN6))){
        if(!in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_TINDAKAN, Params::INSTALASI_ID_TINDAKAN2, Params::INSTALASI_ID_TINDAKAN3, Params::INSTALASI_ID_TINDAKAN4, Params::INSTALASI_ID_TINDAKAN5, Params::INSTALASI_ID_TINDAKAN6))){
            $tabulasi_list = array_merge($tabulasi_list, array( 
                    array('label'=>'Pengkajian Resiko Jatuh', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/PengkajianResikoJatuh/index')),
                )
            );
        }else{
            $tabulasi_list = array_merge($tabulasi_list, array( 
                array('label'=>'Catatan Pemindahan Pasien', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatDarurat/FormulirTransferPasien/index')),
            )        
        ); 
        
        
        }

        if(!in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_IBS, Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_TINDAKAN, Params::INSTALASI_ID_TINDAKAN2, Params::INSTALASI_ID_TINDAKAN3, Params::INSTALASI_ID_TINDAKAN4, Params::INSTALASI_ID_TINDAKAN5, Params::INSTALASI_ID_TINDAKAN6))){
            $tabulasi_list = array_merge($tabulasi_list, array( 
                array('label'=>'Pengakajian Nyeri', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatDarurat/PengkajianNyeri/create'))
                )
            );
        }

        if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_TINDAKAN, Params::INSTALASI_ID_TINDAKAN2, Params::INSTALASI_ID_TINDAKAN3, Params::INSTALASI_ID_TINDAKAN4, Params::INSTALASI_ID_TINDAKAN5, Params::INSTALASI_ID_TINDAKAN6))){
            $tabulasi_list = array_merge($tabulasi_list, array( 
                    array('label'=>'Early Warning Score', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatDarurat/EarlyWarningScore/index')),
                    // array('label'=>'Catatan Pemberian Obat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/CatatanPemberianObat/create')),
                    array('label'=>'Lembar Observasi Komprehensif', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatDarurat/Observasi/index')),
                )
            );

            if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_RD))){
                $tabulasi_list = array_merge($tabulasi_list, array(
                        array('label'=>'Kriteria ICU', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatDarurat/KriteriaMasukICU/index')),
                        array('label'=>'Checklist Serah Terima', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rekamMedis/ChecklistSerahTerimaPasien/index')),
                    )
                );
            }
        }

        if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_RI))){
            $tabulasi_list = array_merge($tabulasi_list, array( 
                // array('label'=>'Catatan Pemberian Obat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/CatatanPemberianObat/create')),
                array('label'=>'Early Warning Score', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatDarurat/EarlyWarningScore/index')),
                array('label'=>'Observasi Tanda Vital & Balance Cairan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/tandaVitalBalanceCairan/index')),
                )
            );
        }

        if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_PI, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERSALINAN))){
            $tabulasi_list = array_merge($tabulasi_list, array(
                //array('label' => 'Catatan Pemindahan Pasien', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatDarurat/FormulirTransferPasien/index')),
                array('label' => 'Checklist Serah Terima', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rekamMedis/ChecklistSerahTerimaPasien/index')),
            ));
        }

        if(Yii::app()->user->getState("instalasi_id")==Params::INSTALASI_ID_RI){
            $tabulasi_list = array_merge(
                $tabulasi_list,
                array(
                    array('label' => 'Konsultasi Gizi', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/konsulGiziRI/index')),
                    array('label' => 'Surveilans PPI', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/SurveilansTRI/index')),
                    array('label' => 'KIE', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/KieRI/index')),
                    //array('label' => 'Asesmen Pasien', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/asesmenPerawatRI/index')),
                    array('label' => 'Asesmen Awal Keperawatan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' =>'/rawatInap/AsesmenAwalKeperawatanRI/index')),
                    //array('label' => 'Surat Keterangan Mata', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/SuratKeteranganTRI/pemeriksaanMata')),
                    array('label' => 'Catatan Perawat', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/CatatanPerawatRI/index')),
                    array('label' => 'Grafik Tanda Vital', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' =>'/rawatInap/GrafikTandaVital/create')),
                    array('label' => 'Pemakaian Bahan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/pemakaianBahanRI/index')),
                    // array('label' => 'Ringkasan Pasien Pulang (Resume Medis)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatInap/RingkasanMasukKeluar/index')),
                    array('label' => 'Hand Over', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatJalan/Sbar/index')),
                    array('label' => 'Lembar Observasi Pasien', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/KardeksTRI/create')),
                )
            ); 
        }else if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_RD))){
            $tabulasi_list = array_merge(
                $tabulasi_list,
                array(
                    array('label' => 'Konsultasi Gizi', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/konsulGiziTRD/index')),
                    array('label' => 'Surveilans PPI', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/SurveilansTRD/index')),
                    array('label' => 'KIE', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/kieRD/index')),
                    //array('label' => 'Asesmen Pasien', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/asesmenPerawatRJ/index')),
                    array('label' => 'Pengkajian Keperawatan IGD', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/AsesmenAwalKeperawatan' . $init . '/index')),
                    //array('label' => 'Surat Keterangan Mata', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/SuratKeteranganTRJ/pemeriksaanMata')),
                    array('label' => 'Catatan Perawat', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/CatatanPerawatRD/index')),
                    array('label' => 'Grafik Tanda Vital', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/GrafikTandaVitalRD/create')),
                    array('label' => 'Pemakaian Bahan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/pemakaianBahan/index')),
                    // array('label' => 'Ringkasan Pasien Pulang (Resume Medis)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatInap/RingkasanMasukKeluar/index')),
                    array('label' => 'Hand Over', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatJalan/Sbar/index')),
                    array('label' => 'Lembar Observasi Pasien', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/KardeksTRD/create')),
                )
            );

        }else if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_RJ))){
            $tabulasi_list = array_merge(
                $tabulasi_list,
                array(
                    array('label' => 'Konsultasi Gizi', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/konsulGiziTRJ/index')),
                    array('label' => 'Surveilans PPI', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/SurveilansTRJ/index')),
                    array('label' => 'KIE', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/kiaRJ/index')),
                    //array('label' => 'Asesmen Pasien', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/asesmenPerawatRJ/index')),
                    array('label' => 'Asesmen Awal Keperawatan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/AsesmenAwalKeperawatan' . $init .'/index')),
                    //array('label' => 'Surat Keterangan Mata', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/SuratKeteranganTRJ/pemeriksaanMata')),
                    array('label' => 'Catatan Perawat', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/CatatanPerawatRJ/index')),
                    array('label' => 'Grafik Tanda Vital', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/GrafikTandaVitalRJ/create')),
                    array('label' => 'Pemakaian Bahan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/pemakaianBahan/index')),
                    // array('label' => 'Ringkasan Pasien Pulang (Resume Medis)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatInap/RingkasanMasukKeluar/index')),
                    array('label' => 'Hand Over', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatJalan/Sbar/index')),
                    array('label' => 'Lembar Observasi Pasien', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/KardeksTRJS/create')),
                )
            );
        }else if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_TINDAKAN, Params::INSTALASI_ID_TINDAKAN2, Params::INSTALASI_ID_TINDAKAN3, Params::INSTALASI_ID_TINDAKAN4, Params::INSTALASI_ID_TINDAKAN5, Params::INSTALASI_ID_TINDAKAN6))){
            $tabulasi_list = array_merge(
                $tabulasi_list,
                array(
                    array('label' => 'Konsultasi Gizi', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/konsulGiziTRJ/index')),
                    array('label' => 'Surveilans PPI', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/SurveilansTRJ/index')),
                    array('label' => 'KIE', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/kiaRJ/index')),
                    //array('label' => 'Asesmen Pasien', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/asesmenPerawatRJ/index')),
                 //   array('label' => 'Asesmen Awal Keperawatan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' =>'/tindakan/AsesmenAwalKeperawatan/index')),
                    //array('label' => 'Surat Keterangan Mata', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/SuratKeteranganTRJ/pemeriksaanMata')),
                    array('label' => 'Catatan Perawat', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/CatatanPerawatRJ/index')),
                    array('label' => 'Grafik Tanda Vital', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/GrafikTandaVitalRJ/create')),
                    array('label' => 'Pemakaian Bahan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/pemakaianBahan/index')),
                    // array('label' => 'Ringkasan Pasien Pulang (Resume Medis)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatInap/RingkasanMasukKeluar/index')),
                    array('label' => 'Hand Over', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatJalan/Sbar/index')),
                    array('label' => 'Lembar Observasi Pasien', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/KardeksTRJS/create')),
                )
            );
        } else if(Yii::app()->user->getState("instalasi_id")==Params::INSTALASI_ID_PI){
            $tabulasi_list = array_merge(
                $tabulasi_list,
                array(
                    array('label' => 'Konsultasi Gizi', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module.'/KonsultasiGiziPI/index')),
                    array('label' => 'Surveilans PPI', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/SurveilansPI/index')),
                    array('label' => 'KIE', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/KiePI/index')),
                    //array('label' => 'Asesmen Pasien', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/asesmenPerawatRJ/index')),
                    array('label' => 'Asesmen Awal Keperawatan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/asesmenAwalKeperawatanPI/index')),
                    //array('label' => 'Surat Keterangan Mata', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/SuratKeteranganTRJ/pemeriksaanMata')),
                    array('label' => 'Catatan Perawat', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/CatatanPerawatPI/index')),
                    array('label' => 'Grafik Tanda Vital', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/GrafikTandaVitalTPI/create')),
                    array('label' => 'Pemakaian Bahan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/pemakaianBahanTPI/index')),
                    // array('label' => 'Ringkasan Pasien Pulang (Resume Medis)', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatInap/RingkasanMasukKeluar/index')),
                    array('label' => 'Hand Over', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatJalan/Sbar/index')),
                    array('label' => 'Lembar Observasi Pasien', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/kardeksTPI/create')),
                )
            );
        } else if(Yii::app()->user->getState("instalasi_id")!==Params::INSTALASI_ID_IBS){
            $tabulasi_list = array_merge(
                $tabulasi_list,
                array(
                    array('label' => 'Konsultasi Gizi', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/konsulGiziBS/index')),
                    array('label' => 'Surveilans PPI', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/SurveilansTBS/index')),
                    array('label' => 'KIE', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/KiaBS/index')),
                    //array('label' => 'Asesmen Pasien', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/asesmenPerawatRJ/index')),
                    array('label' => 'Asesmen Awal Keperawatan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module .'/AsesmenAwalKeperawatanBS/index')),
                    //array('label' => 'Surat Keterangan Mata', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/SuratKeteranganTRJ/pemeriksaanMata')),
                    array('label' => 'Catatan Perawat', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/CatatanPerawatBS/index')),
                    array('label' => 'Grafik Tanda Vital', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/GrafikTandaVitalBS/create')),
                    array('label' => 'Pemakaian Bahan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/pemakaianBahanBS/index')),
                    array('label' => 'Ringkasan Masuk dan Keluar', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatInap/RingkasanMasukKeluar/index')),
                    array('label' => 'Hand Over', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatJalan/Sbar/index')),
                    array('label' => 'Lembar Observasi Pasien', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => $module . '/kardeksTBS/create')),
                )
            );
        }   
        
        if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_PI,Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERSALINAN, Params::INSTALASI_ID_RD))){
            if ($pemberianobat === "Jadwal dari Farmasi"){
                $tabulasi_list = array_merge($tabulasi_list, array( 
                     array('label'=>'Pemberian Obat Rutin', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/PemberianObatRutin/create')),
                ));
            }else{
                $tabulasi_list = array_merge($tabulasi_list, array( 
                    array('label'=>'Catatan Pemberian Obat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/CatatanPemberianObat/create')),
               ));
            }
        }

        
    }
}

if($_GET['type'] == 'Dokter'){
    if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI))){
        
        if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_RD))){
            $tabulasi_list = array_merge($tabulasi_list, array( 
                array('label'=>'Surat Perintah Rawat Inap', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/SuratPerintahRawatInap/index')),
                array('label'=>'Catatan Pemindahan Pasien', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatDarurat/FormulirTransferPasien/index')),
                array('label'=>'Hasil Pemeriksaan USG', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/HasilPemeriksaanUsg/index')),
                )
            );
        }

        $tabulasi_list = array_merge($tabulasi_list, array( 
                array('label'=>'Resume Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rekamMedis/ResumeMedis/index')),
                // array('label'=>'Ringkasan Pasien Pulang (Resume Medis)', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/RingkasanMasukKeluar/index')),
            )
        );

        if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_RI))){
            $tabulasi_list = array_merge($tabulasi_list, array( 
                    array('label'=>'Hand Over', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/Sbar/index')),
                    array('label'=>'Kriteria Masuk ICU', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatDarurat/KriteriaMasukICU/index')),
                )
            );
        }



    } 

    if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_TINDAKAN, Params::INSTALASI_ID_TINDAKAN2, Params::INSTALASI_ID_TINDAKAN3, Params::INSTALASI_ID_TINDAKAN4, Params::INSTALASI_ID_TINDAKAN5, Params::INSTALASI_ID_TINDAKAN6))){
        $tabulasi_list = array_merge($tabulasi_list, array( 
            array('label'=>'Hasil Pemeriksaan USG', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/HasilPemeriksaanUsg/index')),
            array('label'=>'Resume Medis', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rekamMedis/ResumeMedis/index')),
            )
        );
    }

   
}

if(Yii::app()->user->getState("instalasi_id")==Params::INSTALASI_ID_PI){
    $tabulasi_list = array_merge($tabulasi_list, array( 
            array('label'=>'Catatan Pemberian Obat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/CatatanPemberianObat/create')),
            array('label' => 'Early Warning Score', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatDarurat/EarlyWarningScore/index')),
            array('label' => 'Lembar Observasi Komprehensif', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatDarurat/Observasi/index')),    
        )
    );
}

// if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RJ,Params::INSTALASI_ID_RI,Params::INSTALASI_ID_PI, Params::INSTALASI_ID_PERSALINAN, Params::INSTALASI_ID_REHAB, Params::INSTALASI_ID_IBS))){
if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_RI,Params::INSTALASI_ID_PI, Params::INSTALASI_ID_RD))){
    $tabulasi_list = array_merge($tabulasi_list, array( 
        array('label'=>'Catatan Edukasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/CatatanEdukasi/create')),
        )
    );
//     if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RI))){
//         $tabulasi_list = array_merge($tabulasi_list, array( 
//                 array('label'=> 'Hand Over', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/Sbar/index')),
//             )
//         );
//     }
}

if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_IBS))){

    if ($_GET['type'] == 'Dokter') {

    $tabulasi_list = array_merge($tabulasi_list, array(
        array('label' => 'Asesmen Pra Bedah', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatInap/asesmenPraBedah/index', 'id' => 'prabedah')),
        array('label' => 'Asesmen Pra Anestesi', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatInap/asesmenPraAnestesi/index')),
        array('label' => 'Pencatatan DPJP', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rekamMedis/PencatatanDPJP/index')),
    ));
}

    $tabulasi_list = array_merge($tabulasi_list, array(
        array('label' => 'Pelayanan Pembedahan', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'bedahSentral/PersiapanPraBedah/index')),
    ));

    $tabulasi_list = array_merge($tabulasi_list, array(
        array('label'=>'Form Terduga TB', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rekamMedis/TerdugaTb/index')),
        array('label'=>'Daftar Pemakaian Obat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'bedahSentral/daftarPemakaianObat/admin')),
        array('label'=>'Checklist Kelengkapan Pre-Operasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'bedahSentral/ChecklistKelengkapan/index')),
        array('label'=>'Ringkasan Transfer Pasien Intra Rumah Sakit', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rekamMedis/RingkasanTransfer/index')),
       )
    );

    $tabulasi_list = array_merge($tabulasi_list, array( 
        array('label'=>'Catatan Elektrokardiogram', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/CatatanElektrokardiogram/create')),
        array('label'=>'Penandaan Area Operasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'bedahSentral/PenandaanAreaOperasi/index')),
    )
    );
    if ($_GET['type'] == 'Perawat') {

    if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_IBS))){
        $tabulasi_list = array_merge($tabulasi_list, array( 
                array('label'=>'Kriteria Masuk ICU', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatDarurat/KriteriaMasukICU/index')),
            )
        );
    }
}

    if ($_GET['type'] == 'Dokter') {

        // if (in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_IBS, Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERAWATAN_INTENSIF, Params::INSTALASI_ID_PERSALINAN, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RJ))) {
            $tabulasi_list = array_merge($tabulasi_list, array(
                array('label' => 'Laporan Operasi', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'bedahSentral/laporanOperasi/index')),
                array('label' => 'Ringkasan Masuk Keluar', 'url' => 'javascript:void(0);', 'itemOptions' => array('onclick' => 'setTab(this);', 'tab' => 'rawatInap/RingkasanMasukKeluar/index')),
                    )
            );

            $tabulasi_list = array_merge($tabulasi_list, array( 
                array('label'=>'Asesmen Awal Keperawatan Rawat Inap', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/AsesmenAwalKeperawatan/index')),
                array('label'=>'Lembar Keseimbangan Cairan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rekamMedis/LembarBalanceCairan/index')),
            ));

            $tabulasi_list = array_merge($tabulasi_list, array( 
                array('label'=>'CPIS', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'perawatanIntensif/cpis/index', 'id'=>'cpis')),                
                array('label'=>'Persiapan Ekstubasi', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'perawatanIntensif/persiapanEkstubasi/index', 'id'=>'persiapan-ekstubasi')),
                // dipindahkan dari asesmen pasien
                // array('label'=>'Asesmen Resiko Jatuh', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/PengkajianResikoJatuh/index')),
                // array('label'=>'Asesmen Nyeri', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/asesmenNyeri/index')),
            
                )
            );
        }



    if ($_GET['type'] == 'Perawat') {



            $tabulasi_list = array_merge($tabulasi_list, array( 
                array('label'=>'Asesmen Awal Keperawatan Rawat Inap', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/AsesmenAwalKeperawatan/index')),
                array('label'=>'Lembar Keseimbangan Cairan', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rekamMedis/LembarBalanceCairan/index')),
            ));

  
        }





        

}



if(!in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_IBS))){

    $tabulasi_list = array_merge($tabulasi_list, array(
        array('label'=>'Asesmen Ulang', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/asesmenUlang/index','id'=>'asesmen-ulang')),
    ));

}

if($_GET['type'] == 'Perawat'){

    if(!in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_IBS))){

    $tabulasi_list = array_merge($tabulasi_list, array( 
        // dipindahkan dari asesmen pasien
        array('label'=>'Asesmen Resiko Jatuh', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/PengkajianResikoJatuh/index')),
        array('label'=>'Asesmen Nyeri', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/asesmenNyeri/index')),
        )
        
);
    }

if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_RI))){
    $tabulasi_list = array_merge($tabulasi_list, array( 
        // array('label'=>'Catatan Pemberian Obat', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatInap/CatatanPemberianObat/create')),
        array('label'=>'Skrining Gizi Awal', 'url'=>'javascript:void(0);', 'itemOptions'=>array('onclick'=>'setTab(this);', 'tab'=>'rawatJalan/keperawatan/skriningGizi')),
        )
    );
}

}

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=> $tabulasi_list,
));

$pencatat = $_GET['type'];


$isAsesmenUlang = 'tidak';
if(in_array(Yii::app()->user->getState("instalasi_id"), array(Params::INSTALASI_ID_PI,Params::INSTALASI_ID_RI, Params::INSTALASI_ID_PERSALINAN, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_IBS, Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_TINDAKAN, Params::INSTALASI_ID_TINDAKAN2, Params::INSTALASI_ID_TINDAKAN3, Params::INSTALASI_ID_TINDAKAN4, Params::INSTALASI_ID_TINDAKAN5, Params::INSTALASI_ID_TINDAKAN6))){
    $isAsesmenUlang = 'ya';
}

$jscript = <<< JS
    $(document).ready(function(){
        const pencatat = '${pencatat}';       
        if (pencatat != 'Perawat'){
            $("#cpis, #persiapan-ekstubasi, #asesmen-ulang").detach();
        }else{
            const isAsesmenUlang = '${isAsesmenUlang}';
            if (isAsesmenUlang == 'tidak')
                $("#asesmen-ulang").detach();
        }
    });    
        
JS;


$jscript = <<< JS
    $(document).ready(function(){
       const pencatat = '${pencatat}';       
        if (pencatat != 'Perawat'){
            $("#cpis, #persiapan-ekstubasi").detach();
        } 
    });    
        
JS;

Yii::app()->clientScript->registerScript('tab-menu-rekammedik-js', $jscript, CClientScript::POS_HEAD);
?>