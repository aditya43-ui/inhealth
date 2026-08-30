<?php

$pasien = PasienM::model()->findByPk($model->pasien_id);
$ruangan = RuanganM::model()->findByPk($model->ruangan_id);
$kelas = KelaspelayananM::model()->findByPk($model->kelaspelayanan_id);

$ahli = PegawaiM::model()->findByPk($model->ahligizi_id);
?>

<style>
    .tab_header > tbody > tr > td {
        border: 1px solid black;
    }
    
    .tab_header td {
        vertical-align: top;
    }
    
    .no_tab_header td {
        padding: 2px;
    }
    
    .tab_asesmen {
        width: 100%;
    }
    
    .tab_asesmen td {
        padding: 5px;
        vertical-align: top;
    }
    
    .antrobio > tbody > tr > td {
        border: 1px solid black;
        padding: 2px;
    }
</style>

<table width="100%" class="tab_header">
    <tr>
        <td rowspan="3" width="100" style="text-align: center; vertical-align: middle;">PENGKAJIAN DAN ASUHAN GIZI</td>
        <td rowspan="2">
            <table class="no_tab_header">
                <tr>
                    <td>Nama</td>
                    <td width="10">: </td>
                    <td><?php echo $pasien->namadepan.$pasien->nama_pasien; ?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td width="10">: </td>
                    <td><?php echo $pasien->alamat_pasien; ?></td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td width="10">: </td>
                    <td><?php echo $pasien->jeniskelamin; ?></td>
                </tr>
            </table>
        </td>
        <td width="200" style="padding: 2px;">No. RM : <?php echo $pasien->no_rekam_medik; ?></td>
    </tr>
    <tr>
        <td>
            <table class="no_tab_header">
                <tr>
                    <td>Tgl. Lahir</td>
                    <td width="10">: </td>
                    <td><?php echo $pasien->namadepan.$pasien->nama_pasien; ?></td>
                </tr>
                <tr>
                    <td>Ruangan</td>
                    <td width="10">: </td>
                    <td><?php echo $ruangan->ruangan_nama; ?></td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td width="10">: </td>
                    <td><?php echo $kelas->kelaspelayanan_nama; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding: 2px;">
            Diagnosis Medis :<br>
            <?php echo $model->diagnosa; ?>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding: 2px;">
            <?php 
            $time_konsul = strtotime($model->tgl_konsultasi);
            ?>
            <div class="pull-left">Tanggal : <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d'), $time_konsul);?></div>
            <div class="pull-right">Jam : <?php echo date('H:i:s', $time_konsul); ?></div>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel-body">
                        <span class="group-title" style="top:12px">
                            A. Antropometri
                        </span>
                        <div class="panel panel-default" style="border: 1px solid black !important;">
                            <div class="panel-heading" style="display: flex; justify-content: center; background-color: white !important;">
                                <div class="panel-title" style="color: black !important">
                                    Antropometri <b>Dewasa</b>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="control-group">
                                            <?= CHtml::activeLabel($model, 'andewasabb') . ': '?>
                                                <?= $model->andewasabb . ' Kg' ?? '' ?>
                                        </div>
                                        <div class="control-group">
                                            <?= CHtml::activeLabel($model, 'andewasatl') . ': '?>
                                                <?= $model->andewasatl . " Cm" ?? '' ?>
                                        </div>
                                        
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="control-group">
                                            <?= CHtml::activeLabel($model, 'andewasatb') . ': '?>
                                                <?= $model->andewasatb . ' Cm' ?? '' ?>
                                        </div>
                                        <div class="control-group">
                                            <?= CHtml::activeLabel($model, 'andewasatbest') . ': '?>
                                                <?= $model->andewasatbest . ' Cm' ?? '' ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="control-group">
                                        <?= CHtml::activeLabel($model, 'andewasabbi') . ': '?>
                                                <?= $model->andewasabbi . ' Kg' ?? '' ?>
                                        </div>
                                        <div class="control-group">
                                        <?= CHtml::activeLabel($model, 'andewasalla') . ': '?>
                                                <?= $model->andewasalla . ' Cm' ?? '' ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="control-group">
                                        <?= CHtml::activeLabel($model, 'andewasaimt') . ': '?>
                                                <?= $model->andewasaimt . ' Kg/m' ?? '' ?>
                                        </div>
                                        <div class="control-group">
                                        <?= CHtml::activeLabel($model, 'andewasallap') . ': '?>
                                                <?= $model->andewasalla . ' %' ?? '' ?>
                                        </div>
                                    </div>
                                
                                </div>
                                <!-- ./row -->

                                <div class="row">
                                    <div class="col-sm-12">
                                        <?= CHtml::label("Status Gizi", '', array('class' => 'span3')) . ': '; ?>

                                        <?php 
                                            echo $model->andestatus_gizi;
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- ./panel-body -->

                            <div class="panel-heading" style="display: flex; justify-content: center; background-color: white !important;border-top: 0.5px solid grey !important;">
                                <div class="panel-title" style="color: black !important">
                                    Antropometri <b>Anak</b>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="control-group">
                                            <?= CHtml::activeLabel($model, 'ananakbb') . ': '?>
                                            <?= $model->ananakbb . ' Kg' ?? '' ?>
                                        </div>
                                        <div class="control-group">
                                            <?= CHtml::activeLabel($model, 'ananakbbu') . ': '?>
                                            <?= $model->ananakbbu . ' / ' . $model->ananakbbuu  ?>
                                        </div>
                                        <div class="control-group">
                                            <?= CHtml::activeLabel($model, 'ananakbbtb') . ': '?>
                                            <?= $model->ananakbbtb  . ' / ' .$model->ananakbbtbb  ?>
                                        </div>
                                    </div>
                    
                                    <div class="col-sm-3">
                                        <div class="control-group">
                                            <?= CHtml::activeLabel($model, 'ananaktb') . ': '?>
                                            <?= $model->ananaktb . ' Cm' ?? '' ?>
                                        </div>
                                        <div class="control-group">
                                            <?= CHtml::activeLabel($model, 'ananaktbu') . ': '?>
                                            <?= $model->ananaktbu . ' / ' .$model->ananaktbuu ?>
                                        </div>
                                        <div class="control-group">
                                            <?= CHtml::activeLabel($model, 'ananakbbi') . ': '?>
                                            <?= $model->ananakbbi . ' Kg' ?? '' ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="control-group">
                                            <?= CHtml::activeLabel($model, 'ananakpjgbdn') . ': '?>
                                            <?= $model->ananakpjgbdn ?? '' ?>
                                        </div>
                                        <div class="control-group">
                                            <?= CHtml::activeLabel($model, 'ananakpjgbdnu') . ': '?>
                                            <?= $model->ananakpjgbdnu ?>
                                        </div>
                                        <div class="control-group">
                                            <?= CHtml::activeLabel($model, 'ananakbbip') . ': '?>
                                            <?= $model->ananakbbip ?? '' ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="control-group">
                                            <?= CHtml::activeLabel($model, 'ananaklla') . ': '?>
                                            <?= $model->ananaklla . ' Cm' ?? '' ?>
                                        </div>
                                        <div class="control-group">
                                            <?= CHtml::activeLabel($model, 'ananakllau') . ': '?>
                                            <?= $model->ananakllau . ' / ' .$model->ananakllauu ?>
                                        </div>
                                        <div class="control-group">
                                            <?= CHtml::activeLabel($model, 'ananakutb') . ': '?>
                                            <?= $model->ananakutb ?? '' ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- ./row -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="control-group">
                                            <?= CHtml::label("Status Gizi", '', array('class' => 'span3')) . ': '; ?>
                                            <?php 
                                                echo $model->ananakstatus_gizi;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- ./row -->
                            </div>
                            <!-- ./panel-body -->
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding: 2px;">
            <div class="col-sm-12">
                <div class="panel panel-dark">
                    <span class="group-title">
                        B. Biokimia
                    </span>
                    <div class="panel-body">
                        <div class="control-group">
                            <?php 
                                if($model->isbiokimianormal ?? false == true ) {
                                    echo 'Normal';
                                }
                                if($model->isbiokimiabermasalah ?? false == true) {
                                    echo CHtml::activeLabel($model, 'isbiokimiabermasalah') . ': ';
                                    echo $model->biokim;
                                }
                            
                            ?>                 
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="col-sm-12">
                <div class="panel panel-dark">
                    <span class="group-title">
                        C. Fisik Klinik
                    </span>
                    <div class="panel-body">
                        <div class="control-group">
                            <?php 
                                if($model->isfisklinormal ?? false == true ) {
                                    echo 'Normal';
                                }
                                if($model->isfisklibermasalah ?? false == true) {
                                    echo CHtml::activeLabel($model, 'isfisklibermasalah') . ': ';
                                    echo $model->fisklinik;
                                }
                            
                            ?>    
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="col-sm-12">
                <div class="panel panel-dark">
                    <span class="group-title">
                        D. Riwayat Gizi
                    </span>
                    <div class="panel-body">
                        <?php echo '<b>Dahulu</b>' ?>
                        <div class="control-group">
                            <div class="controls">
                                <?php 
                                    $isalergitidak = false;
                                    $isalergiada = false;

                                    if($model->isalergiada ?? false == true) {
                                        $isalergiada = true;
                                    }
                                    if($model->isalergitidak ?? false == true) {
                                        $isalergitidak = true;
                                    }
                                ?>
                                <div class="col-sm-4">
                                    <?php echo '<span class="span2">Alergi </span>'; ?>
                                </div>
                                <div class="col-sm-4">
                                    <?php echo CHtml::CheckBox('isalergitidak', $isalergitidak, array('id' => 'alergitidak')) . CHtml::label("Tidak", '', array('style' => 'margin-right:100px'))?>
                                    <?php echo CHtml::CheckBox('isalergiada', $isalergiada, array('id' => 'alergiada',)) . CHtml::label("Ada", '', array('style' => 'margin-right:76px')) ?>
                                </div>
                                <div class="col-sm-4">
                                    <?php  echo CHtml::activeTextField($model, 'alergi', array('class'=>'span3 alergi', 'readonly' => true)) ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <?php 
                                    $ispolamakanteratur = false;
                                    $ispolamakantidak = false;

                                    if($model->ispolamakantidak ?? false == true) {
                                        $ispolamakantidak = true;
                                    }
                                    if($model->ispolamakanteratur ?? false == true) {
                                        $ispolamakanteratur = true;
                                    }
                                ?>
                                <div class="col-sm-4">
                                    <?= '<span class="span2">Pola Makan </span>' ?>
                                </div>
                                <div class="col-sm-4">
                                    <?php echo CHtml::CheckBox('ispolamakanteratur', $ispolamakanteratur, array('id' => 'ispolamakanteratur','uncheckValue' => false, 'onclick'=>'setPolaMakan("teratur")')) . CHtml::label("Teratur", '', array('style' => 'margin-right:32px'))?>
                                    <?php echo CHtml::CheckBox('ispolamakantidak', $ispolamakantidak, array('id' => 'ispolamakantidak')) . CHtml::label("Tidak Teratur", '', array('style' => 'margin-right:32px')) ?>
                                </div>
                                <div class="col-sm-4">
                                    <?php  echo CHtml::activeTextField($model, 'polamakan', array('class'=>'span3 polamakan', 'readonly' => true)) ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <?php 
                                    $issusunanmakanseimbang = false;
                                    $issusunanmakantidak = false;

                                    if($model->issusunanmakantidak ?? false == true) {
                                        $issusunanmakantidak = true;
                                    }
                                    if($model->issusunanmakanseimbang ?? false == true) {
                                        $issusunanmakanseimbang = true;
                                    }
                                ?>
                                <div class="col-sm-4">
                                    <?= '<span class="span2">Susunan Menu </span>' ?>
                                </div>
                                 <div class="col-sm-4">
                                    <?php echo CHtml::CheckBox('issusunanmakanseimbang', $issusunanmakanseimbang, array('id' => 'issusunanmakanseimbang')) . CHtml::label("Seimbang", '', array('style' => 'margin-right:17px'))?>
                                    <?php echo CHtml::CheckBox('issusunanmakantidak', $issusunanmakantidak, array('id' => 'issusunanmakantidak')) . CHtml::label("Tidak Seimbang", '', array('style' => 'margin-right:17px')) ?>
                                </div>
                                 <div class="col-sm-4">
                                    <?php  echo CHtml::activeTextField($model, 'susunanmakan', array('class'=>'span3 susunanmakan', 'readonly' => true)) ?>
                                </div>
                                

                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <?php 
                                    $isasidiberikan = false;
                                    $isasitidak = false;

                                    if($model->isasitidak ?? false == true) {
                                        $isasitidak = true;
                                    }
                                    if($model->isasidiberikan ?? false == true) {
                                        $isasidiberikan = true;
                                    }
                                ?>
                                <div class="col-sm-4">
                                    <?= '<span class="span2">ASI </span>' ?>
                                </div>
                                <div class="col-sm-4">
                                    <?php echo CHtml::CheckBox('isasidiberikan', $isasidiberikan, array('id' => 'isasidiberikan')) . CHtml::label("Diberikan", '', array('style' => 'margin-right:20px'))?>
                                    <?php echo CHtml::CheckBox('isasitidak', $isasitidak) . CHtml::label("Tidak Diberikan", '', array('style' => 'margin-right:20px')) ?>
                                </div>
                                <div class="col-sm-4">
                                    <?php  echo CHtml::activeTextField($model, 'asi', array('class'=>'span3 asi', 'readonly' => true)) ?>
                                </div>
                                

                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <?php 
                                    $lainlain2 = false;

                                    if($model->lainlain != null ) {
                                        $lainlain2 = true;
                                    }
                                    
                                ?>
                                <div class="col-sm-4">
                                    <?= '<span class="span2"></span>' ?>
                                </div>
                                <div class="col-sm-4">
                                    <?php echo CHtml::CheckBox('lainlain2',$lainlain2) . CHtml::label("Lain-lain", '', array('style' => 'margin-right:54px')) ?>

                                </div>
                                <div class="col-sm-4">
                                    <?php  echo CHtml::activeTextField($model, 'lainlain', array('class'=>'span3 lainlain', 'readonly' => true)) ?>
                                </div>

                            </div>
                        </div>


                       <?php echo '<b>Sekarang</b>' ?>
                       <div class="control-group">
                                <?php 
                                    $isnmbaik = false;
                                    $isnmkurang = false;

                                    if($model->isnmbaik ?? false == true) {
                                        $isnmbaik = true;
                                    }
                                    if($model->isnmkurang ?? false == true) {
                                        $isnmkurang = true;
                                    }
                                ?>
                            <div class="controls">
                                <div class="col-sm-4">
                                    <?= '<span class="span2">Nafsu Makan </span>' ?>
                                </div>
                                <div class="col-sm-8">
                                    <?php echo CHtml::CheckBox('isnmbaik', $isnmbaik, array('id' => 'isnmbaik','readonly' => true)) . CHtml::label("Baik", '', array('style' => 'margin-right:20px'))?>
                                    <?php echo CHtml::CheckBox('isnmkurang', $isnmkurang, array('id' => 'isnmkurang','readonly' => true)) . CHtml::label("Kurang", '', array('style' => 'margin-right:20px')) ?>
                                </div>
                                
                            </div>
                        </div> 

                        <div class="control-group">
                            <div class="controls">
                                <?php 
                                    $iskelsulit = false;
                                    $iskelsulitmengunyah = false;
                                    $iskelmual = false;
                                    $iskelmuntah = false;
                                    $iskellainlain = false;

                                    if($model->iskelsulit ?? false == true) {
                                        $iskelsulit = true;
                                    }
                                    if($model->iskelsulitmengunyah ?? false == true) {
                                        $iskelsulitmengunyah = true;
                                    }
                                    if($model->iskelmuntah ?? false == true) {
                                        $iskelmuntah = true;
                                    }
                                    if($model->iskelmual ?? false == true) {
                                        $iskelmual = true;
                                    }
                                    if($model->iskellainlain ?? false == true) {
                                        $iskellainlain = true;
                                    }
                                ?><br>
                                <div class="col-sm-4">
                                    <?= '<span class="span2">Keluhan </span>'; ?>
                                </div>
                                <div class="col-sm-8">
                                    <?php echo CHtml::CheckBox('iskelsulit', $iskelsulit, array('id' => 'iskelsulit')) . CHtml::label("Sulit Menelan", '', array('style' => 'margin-right:20px'))?>
    
                                    <?php echo CHtml::CheckBox('iskelsulitmengunyah', $iskelsulitmengunyah, array('id' => 'iskelsulitmengunyah')) . CHtml::label("Sulit Mengunyah", '', array('style' => 'margin-right:20px')) ?>
                                    
                                    <?php echo CHtml::CheckBox('iskelmual', $iskelmual, array('id' => 'iskelmual')) . CHtml::label("Mual", '', array('style' => 'margin-right:20px')) ?>
    
                                    <?php echo CHtml::CheckBox('iskelmuntah', $iskelmuntah, array('id' => 'iskelmuntah')) . CHtml::label("Muntah", '', array('style' => 'margin-right:20px')) ?>
                                    <br>
                                    <?php echo CHtml::label("", '', array('class' => 'span1', 'style' => 'margin-right:57px'))?>
                                    <?php echo CHtml::CheckBox('iskellainlain', $iskellainlain, array('id' => 'iskellainlain')) . CHtml::label("Lain-lain", '', array('style' => 'margin-right:20px')) ?>
                                </div>
                                

                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls">
                                <?php 
                                    $isjdoral = false;
                                    $isjdenteral = false;
                                    $isjdparenteral = false;

                                    if($model->isjdoral ?? false == true) {
                                        $isjdoral = true;
                                    }
                                    if($model->isjdenteral ?? false == true) {
                                        $isjdenteral = true;
                                    }
                                    if($model->isjdparenteral ?? false == true) {
                                        $isjdparenteral = true;
                                    }
                                    
                                ?>
                                <div class="col-sm-4">
                                    <?= '<span class="span2">Jenis Diet </span>'; ?>
                                </div>
                                <div class="col-sm-4">
                                    <?php echo CHtml::CheckBox('isjdoral', $isjdoral, array('id' => 'isjdoral','uncheckValue' => false)) . CHtml::label("Oral", '', array('style' => 'margin-right:40px'))?><br>
                                    <?php echo CHtml::CheckBox('isjdenteral', $isjdenteral, array('id' => 'isjdenteral','uncheckValue' => false, 'onclick' => 'setJenisDiet("enternal")')) . CHtml::label("Enteral", '', array('style' => 'margin-right:20px'))?><br>
                                    <?php echo CHtml::CheckBox('isjdparenteral', $isjdparenteral, array('id' => 'isjdparenteral','uncheckValue' => false, 'onclick' => 'setJenisDiet("parenteral")')) . CHtml::label("Parenteral", '', array('style' => 'margin-right:20px'))?>
                                </div>
                                <div class="col-sm-4">
                                    <?php  echo CHtml::activetextField($model, 'jdoral', array('class'=>'span3 jdoral', 'readonly' => true)) ?>
                                    <?php  echo CHtml::activetextField($model, 'jdenteral', array('class'=>'span3 jdenteral', 'readonly' => true)) ?>
                                    <?php  echo CHtml::activetextField($model, 'jdparenteral', array('class'=>'span3 jdparenteral', 'readonly' => true)) ?>
                                </div>
                                
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls">
                                <?php 
                                    $isrpdoral = false;
                                    $isrpdlewatpipa = false;

                                    if($model->isrpdoral ?? false == true) {
                                        $isrpdoral = true;
                                    }
                                    if($model->isrpdlewatpipa ?? false == true) {
                                        $isrpdlewatpipa = true;
                                    }
                                    
                                ?>
                                <div class="col-sm-4">
                                    <?= '<span class="span2">Rute Pemberian Diet </span>'; ?>
                                </div>
                                <div class="col-sm-8">
                                    <?php echo CHtml::CheckBox('isrpdoral', $isrpdoral, array('id' => 'isrpdoral')) . CHtml::label("Oral", '', array('style' => 'margin-right:20px'))?>
                                    <?php echo CHtml::CheckBox('isrpdlewatpipa', $isrpdlewatpipa, array('id' => 'isrpdlewatpipa')) . CHtml::label("Lewat Pipa", '', array('style' => 'margin-right:20px')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="padding: 2px;">
            <div class="col-sm-12">
                <div class="panel panel-dark">
                    <span class="group-title">
                        E. Riwayat Personal Terkait Penyakit
                    </span>
                    <div class="panel-body">
                        <?php  echo 'Riwayat Penyakit ' . CHtml::activetextField($model, 'rptpriwayatpenyakit', array('readonly' => true, 'class'=>'rptpriwayatpenyakit', 'size'=>250)) ?><br>
                        <?php  echo 'Diagnosis Medis ' .CHtml::activetextField($model, 'rptpdiagnosismedis', array('readonly'=>true, 'class'=>'rptpdiagnosismedis', 'size'=>250)) ?>
                    </div>
                </div>
            </div>
            
        </td>
    </tr>
    <tr>
        <td colspan="3" style="font-weight: bold; padding: 2px;">
            <div class="pull-right">Ahli Gizi : <?php echo empty($ahli) ? "-" : $ahli->namaLengkap; ?></div>
        </td>
    </tr>
</table>
