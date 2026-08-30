<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>

<style>
    .judul{
        text-align:center;
    }

    @media print {
        html, body {

            font-size:11px !important;
        }

        div{
            font-size:11px !important;
        }

        tr td {
            font-size:11px !important;
        }

    }

    .fa{
        font-size: 12pt;
    }
    .padding5{
        padding: 5px !important;
    }

    .borderclass{
        border: 1px solid black !important;
    }

    .tablecustom th, .tablecustom td {
        padding: 5px;
        border: 1px solid black !important;
    }

    .bordertopnoneclass{
        border-top: none !important;
    }
    .borderbottomnoneclass{
        border-bottom: none !important;
    }
    .textcenter {
        text-align: center;
    }
</style>
<?php

    // Obat Infus
    $groupObatInfus = array();
    $groupTgl = array();
    $modObatInfus = CatatanpemberianobatT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'jenisinfus'=>'INFUS'));
    
    if(!empty($modObatInfus)){
        foreach($modObatInfus as $ori_infus){
            $modDet = CatatanpemberianobatdetT::model()->findAllByAttributes(array('catatanpemberianobat_id'=>$ori_infus->catatanpemberianobat_id),array('order'=>'tanggal_pemberian ASC'));
            if(!empty($modDet)){
                foreach($modDet as $ori_det){
                    $groupTgl[$ori_det->tanggal_pemberian]['tanggal'] = $ori_det->tanggal_pemberian;

                    $groupObatInfus[$ori_infus->obatalkes->obatalkes_id][$ori_det->tanggal_pemberian][] = array(
                            'obatalkes_nama'=>$ori_infus->obatalkes->obatalkes_nama,
                            'dosisobat'=>$ori_infus->dosisobat,
                            'aturanpakaiobat'=>$ori_infus->aturanpakaiobat,
                            'catatanpemberian'=>$ori_infus->catatanpemberian,
                            'keteragan'=>$ori_infus->keteragan,
                            'jam'=>$ori_det->jam_pemberian,
                            'tanda'=>$ori_det->tanda,
                            'initial'=>$ori_det->initial,
                    );
                }
            }
        }
    }
    
    $oriObatInfus = array();

    if(!empty($groupTgl)){
        $indx = 0;
        $ind_infus = 0;
        foreach($groupTgl as $i => $data_obat){
            $indx++;
            
            $oriObatInfus[$ind_infus][] = $data_obat;
            if($indx == 2){
                $ind_infus++;
                $indx = 0;
            }
        }
    }

    // Obat Injeksi
    $groupObatInjeksi = array();
    $groupTglInjeksi = array();
    $modObatInjeksi = CatatanpemberianobatT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'jenisinfus'=>'INJEKSI'));
    
    if(!empty($modObatInjeksi)){
        foreach($modObatInjeksi as $ori){
            $modDet = CatatanpemberianobatdetT::model()->findAllByAttributes(array('catatanpemberianobat_id'=>$ori->catatanpemberianobat_id),array('order'=>'tanggal_pemberian ASC'));
            if(!empty($modDet)){
                foreach($modDet as $ori_det){
                    $groupTglInjeksi[$ori_det->tanggal_pemberian]['tanggal'] = $ori_det->tanggal_pemberian;

                    $groupObatInjeksi[$ori->obatalkes->obatalkes_id][$ori_det->tanggal_pemberian][] = array(
                            'obatalkes_nama'=>$ori->obatalkes->obatalkes_nama,
                            'dosisobat'=>$ori->dosisobat,
                            'aturanpakaiobat'=>$ori->aturanpakaiobat,
                            'catatanpemberian'=>$ori->catatanpemberian,
                            'keteragan'=>$ori->keteragan,
                            'jam'=>$ori_det->jam_pemberian,
                            'tanda'=>$ori_det->tanda,
                            'initial'=>$ori_det->initial,
                    );
                }
            }
        }
    }
    
    $oriObatInjeksi = array();

    if(!empty($groupTglInjeksi)){
        $indx = 0;
        $ind_injeksi = 0;
        foreach($groupTglInjeksi as $i => $data_obat){
            $indx++;
            
            $oriObatInjeksi[$ind_injeksi][] = $data_obat;
            if($indx == 2){
                $ind_injeksi++;
                $indx = 0;
            }
        }
    }
    
    // Obat Oral
    $groupObatOral = array();
    $groupTglOral = array();
    $modObatOral = CatatanpemberianobatT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'jenisinfus'=>'ORAL'));
    
    if(!empty($modObatOral)){
        foreach($modObatOral as $ori){
            $modDet = CatatanpemberianobatdetT::model()->findAllByAttributes(array('catatanpemberianobat_id'=>$ori->catatanpemberianobat_id),array('order'=>'tanggal_pemberian ASC'));
            if(!empty($modDet)){
                foreach($modDet as $ori_det){
                    $groupTglOral[$ori_det->tanggal_pemberian]['tanggal'] = $ori_det->tanggal_pemberian;

                    $groupObatOral[$ori->obatalkes->obatalkes_id][$ori_det->tanggal_pemberian][] = array(
                            'obatalkes_nama'=>$ori->obatalkes->obatalkes_nama,
                            'dosisobat'=>$ori->dosisobat,
                            'aturanpakaiobat'=>$ori->aturanpakaiobat,
                            'catatanpemberian'=>$ori->catatanpemberian,
                            'keteragan'=>$ori->keteragan,
                            'jam'=>$ori_det->jam_pemberian,
                            'tanda'=>$ori_det->tanda,
                            'initial'=>$ori_det->initial,
                    );
                }
            }
        }
    }
    
    $oriObatOral = array();

    if(!empty($groupTglOral)){
        $indx = 0;
        $ind_oral = 0;
        foreach($groupTglOral as $i => $data_obat){
            $indx++;
            
            $oriObatOral[$ind_oral][] = $data_obat;
            if($indx == 2){
                $ind_oral++;
                $indx = 0;
            }
        }
    }

    // Obat Luar
    $groupObatLuar = array();
    $groupTglLuar = array();
    $modObatLuar = CatatanpemberianobatT::model()->findAllByAttributes(array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id,'jenisinfus'=>'OBAT LUAR'));
    
    if(!empty($modObatLuar)){
        foreach($modObatLuar as $ori){
            $modDet = CatatanpemberianobatdetT::model()->findAllByAttributes(array('catatanpemberianobat_id'=>$ori->catatanpemberianobat_id),array('order'=>'tanggal_pemberian ASC'));
            if(!empty($modDet)){
                foreach($modDet as $ori_det){
                    $groupTglLuar[$ori_det->tanggal_pemberian]['tanggal'] = $ori_det->tanggal_pemberian;

                    $groupObatLuar[$ori->obatalkes->obatalkes_id][$ori_det->tanggal_pemberian][] = array(
                            'obatalkes_nama'=>$ori->obatalkes->obatalkes_nama,
                            'dosisobat'=>$ori->dosisobat,
                            'aturanpakaiobat'=>$ori->aturanpakaiobat,
                            'catatanpemberian'=>$ori->catatanpemberian,
                            'keteragan'=>$ori->keteragan,
                            'jam'=>$ori_det->jam_pemberian,
                            'tanda'=>$ori_det->tanda,
                            'initial'=>$ori_det->initial,
                    );
                }
            }
        }
    }
    
    $oriObatLuar = array();

    if(!empty($groupTglLuar)){
        $indx = 0;
        $ind_luar = 0;
        foreach($groupTglLuar as $i => $data_obat){
            $indx++;
            
            $oriObatLuar[$ind_luar][] = $data_obat;
            if($indx == 2){
                $ind_luar++;
                $indx = 0;
            }
        }
    }
?>

<?php
    if($_GET['typeoa'] == 'obat'){
        if(!empty($oriObatInfus)){
            $ind = 0;
            foreach($oriObatInfus as $i => $dataObat){ 
                $ind++;
                
                if($ind % 2 == 0){
                    echo '<div style="page-break-before:always; page-break-after:always;">';
                }
                echo '<div style="text-align:right; font-weight: bold" class="">FRM/90.1/RSBM</div>';
                echo $this->renderPartial($this->path_view.'print/_headerSurat',array('judulLaporan'=>$judulLaporan, 'colspan'=>'','modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran));
                echo $this->renderPartial($this->path_view.'print/_jadwalPemberian',array('modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran,'modAdmisi'=>$modAdmisi));    
                echo $this->renderPartial($this->path_view.'print/_obat',array('headerpanel'=>'OBAT INFUS','modObat'=>$dataObat,'groupObatInfus'=>$groupObatInfus));    
                echo $this->renderPartial($this->path_view.'print/_footer',array());    
                if($ind % 2 == 0){
                    echo '</div>';
                }
                
            }
        }
    
        if(!empty($oriObatInjeksi)){
            $ind = 0;
            foreach($oriObatInjeksi as $i => $dataObat){ 
                $ind++;
                
                if($ind % 2 == 0){
                    echo '<div style="page-break-before:always; page-break-after:always;">';
                }
                echo '<div style="text-align:right; font-weight: bold" class="">FRM/90.1/RSBM</div>';
                echo $this->renderPartial($this->path_view.'print/_headerSurat',array('judulLaporan'=>$judulLaporan, 'colspan'=>'','modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran));
                echo $this->renderPartial($this->path_view.'print/_jadwalPemberian',array('modPendaftaran'=>$modPendaftaran,'modAdmisi'=>$modAdmisi));    
                echo $this->renderPartial($this->path_view.'print/_obat',array('headerpanel'=>'OBAT INJEKSI','modObat'=>$dataObat,'groupObatInfus'=>$groupObatInjeksi));    
                echo $this->renderPartial($this->path_view.'print/_footer',array());
                if($ind % 2 == 0){
                    echo '</div>';
                }
                
            }
        }
    }else if($_GET['typeoa'] == 'luar'){
        if(!empty($oriObatOral)){
            $ind = 0;
            foreach($oriObatOral as $i => $dataObat){ 
                $ind++;
                
                if($ind % 2 == 0){
                    echo '<div style="page-break-before:always; page-break-after:always;">';
                }
                echo '<div style="text-align:right; font-weight: bold" class="">FRM/90.1/RSBM</div>';
                echo $this->renderPartial($this->path_view.'print/_headerSurat',array('judulLaporan'=>$judulLaporan, 'colspan'=>'','modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran));
                echo $this->renderPartial($this->path_view.'print/_jadwalPemberian',array('modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran,'modAdmisi'=>$modAdmisi));    
                echo $this->renderPartial($this->path_view.'print/_obat',array('headerpanel'=>'OBAT ORAL','modObat'=>$dataObat,'groupObatInfus'=>$groupObatOral));    
                echo $this->renderPartial($this->path_view.'print/_footer',array());
                if($ind % 2 == 0){
                    echo '</div>';
                }
                
            }
        }
    
        if(!empty($oriObatLuar)){
            $ind = 0;
            foreach($oriObatLuar as $i => $dataObat){ 
                $ind++;
                
                if($ind % 2 == 0){
                    echo '<div style="page-break-before:always; page-break-after:always;">';
                }
                echo '<div style="text-align:right; font-weight: bold" class="">FRM/90.1/RSBM</div>';
                echo $this->renderPartial($this->path_view.'print/_headerSurat',array('judulLaporan'=>$judulLaporan, 'colspan'=>'','modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran));
                echo $this->renderPartial($this->path_view.'print/_jadwalPemberian',array('modPendaftaran'=>$modPendaftaran,'modAdmisi'=>$modAdmisi));    
                echo $this->renderPartial($this->path_view.'print/_obat',array('headerpanel'=>'OBAT LUAR','modObat'=>$dataObat,'groupObatInfus'=>$groupObatLuar));    
                echo $this->renderPartial($this->path_view.'print/_footer',array());
                if($ind % 2 == 0){
                    echo '</div>';
                }
                
            }
        }
    }


    
?>
