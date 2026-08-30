<?php 
    $itemCssClass = 'table table-bordered table-striped table-condensed';
    $table = 'ext.bootstrap.widgets.HeaderGroupGridView';
    $sort = true;
    $row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
    if (isset($caraPrint)){
        $row = '$row+1';
        $data = $model->searchTable();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL"){
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
        }
         if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
            
        }
  
        echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        $itemCssClass = 'table border';
        
    } else{
        $data = $model->searchTable();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<style>
    .border th, .border td{
        border:1px solid #000 !important;
    }

    .border thead tr{
        background:none !important;
        color:#333 !important;
    }

    .border {
        box-shadow:none !important;
        border-spacing:0px !important;
        padding:0px !important;
    }
</style>
<div>
    <table id="tableLaporan" width="100%" class="border" border="1px solid !important" style="text-align:center;">
        <thead>
            <tr>
                <th style="vertical-align: middle; text-align: center;" rowspan="3">TGL</th>
                <th style="vertical-align: middle; text-align: center;" rowspan="3">NAMA</th>
                <th style="vertical-align: middle; text-align: center;" rowspan="3">NOMOR REGISTER DONOR</th>
                <th style="vertical-align: middle; text-align: center;" colspan="5">KELOMPOK UMUR</th>
                <th style="vertical-align: middle; text-align: center;" rowspan="2" colspan="2">JENIS DONOR</th>
                <th style="vertical-align: middle; text-align: center;" rowspan="3">ALAMAT</th>
                <th style="vertical-align: middle; text-align: center;" colspan="18">DONOR KE</th>
                <th style="vertical-align: middle; text-align: center;" colspan="3">JUMLAH</th>
                <th style="vertical-align: middle; text-align: center;" rowspan="3">KET</th>
            </tr>
            <tr>
                <th style="vertical-align: middle; text-align: center;"><&nbsp;17&nbsp;TH</th>
                <th style="vertical-align: middle; text-align: center;">18&nbsp;-&nbsp;24&nbsp;TH</th>
                <th style="vertical-align: middle; text-align: center;">25&nbsp;-&nbsp;45&nbsp;TH</th>
                <th style="vertical-align: middle; text-align: center;">46&nbsp;-&nbsp;64&nbsp;TH</th>
                <th style="vertical-align: middle; text-align: center;">>&nbsp;65&nbsp;TH</th>
                <th style="vertical-align: middle; text-align: center;" colspan="3">I</th>
                <th style="vertical-align: middle; text-align: center;" colspan="3">II</th>
                <th style="vertical-align: middle; text-align: center;" colspan="3">III</th>
                <th style="vertical-align: middle; text-align: center;" colspan="3">IV</th>
                <th style="vertical-align: middle; text-align: center;" colspan="3">V</th>
                <th style="vertical-align: middle; text-align: center;" colspan="3">VI</th>
                <th style="vertical-align: middle; text-align: center;" rowspan="2">Skrl</th>
                <th style="vertical-align: middle; text-align: center;" rowspan="2">Pggt</th>
                <th style="vertical-align: middle; text-align: center;" rowspan="2">Auto</th>
            </tr>
            <tr>
                <th style="vertical-align: middle; text-align: center;">I</th>
                <th style="vertical-align: middle; text-align: center;">II</th>
                <th style="vertical-align: middle; text-align: center;">III</th>
                <th style="vertical-align: middle; text-align: center;">IV</th>
                <th style="vertical-align: middle; text-align: center;">V</th>
                <th style="vertical-align: middle; text-align: center;">BARU</th>
                <th style="vertical-align: middle; text-align: center;">RUTIN</th>
                <th style="vertical-align: middle; text-align: center;">Skrl</th>
                <th style="vertical-align: middle; text-align: center;">Pggt</th>
                <th style="vertical-align: middle; text-align: center;">Auto</th>
                <th style="vertical-align: middle; text-align: center;">Skrl</th>
                <th style="vertical-align: middle; text-align: center;">Pggt</th>
                <th style="vertical-align: middle; text-align: center;">Auto</th>
                <th style="vertical-align: middle; text-align: center;">Skrl</th>
                <th style="vertical-align: middle; text-align: center;">Pggt</th>
                <th style="vertical-align: middle; text-align: center;">Auto</th>
                <th style="vertical-align: middle; text-align: center;">Skrl</th>
                <th style="vertical-align: middle; text-align: center;">Pggt</th>
                <th style="vertical-align: middle; text-align: center;">Auto</th>
                <th style="vertical-align: middle; text-align: center;">Skrl</th>
                <th style="vertical-align: middle; text-align: center;">Pggt</th>
                <th style="vertical-align: middle; text-align: center;">Auto</th>
                <th style="vertical-align: middle; text-align: center;">Skrl</th>
                <th style="vertical-align: middle; text-align: center;">Pggt</th>
                <th style="vertical-align: middle; text-align: center;">Auto</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($modShow as $val) : ?>
                <?php $cekpendonor1ASC = LappenyadapandarahV::model()->findByAttributes(array('pendonor_id' => $val->pendonor_id), array('order' => 'waktu_pendaftaran ASC')); ?>
                <?php $cekpendonor1DESC = LappenyadapandarahV::model()->findByAttributes(array('pendonor_id' => $val->pendonor_id), array('order' => 'waktu_pendaftaran DESC')); ?>
                <?php
                $criteria = new CDbCriteria;
                $criteria->addCondition('donasi_ke != 0');
                $criteria->addCondition('pendonor_id = ' . $val->pendonor_id);
                $cekall = BDLappenyadapandarahV::model()->findAll($criteria);
                ?>
                <tr>
                    <td><?php echo!empty($cekpendonor1ASC) ? date('d M Y', strtotime($cekpendonor1ASC->waktu_pendaftaran)) : ''; ?></td>
                    <td><?php echo!empty($cekpendonor1DESC) ? $cekpendonor1DESC->nama_lengkap : ''; ?></td>
                    <td><?php echo!empty($cekpendonor1ASC) ? $cekpendonor1ASC->no_pendonor : ''; ?></td>
                    <td style="text-align: center;">
                        <?php
                        if (!empty($cekpendonor1DESC)) {
                            if ($cekpendonor1DESC->kelompok_umur == 1) {
                                echo 'v';
                            }
                        }
                        ?>
                    </td>
                    <td style="text-align: center;">
                        <?php
                        if (!empty($cekpendonor1DESC)) {
                            if ($cekpendonor1DESC->kelompok_umur == 2) {
                                echo 'v';
                            }
                        }
                        ?>
                    </td>
                    <td style="text-align: center;">
                        <?php
                        if (!empty($cekpendonor1DESC)) {
                            if ($cekpendonor1DESC->kelompok_umur == 3) {
                                echo 'v';
                            }
                        }
                        ?>
                    </td>
                    <td style="text-align: center;">
                        <?php
                        if (!empty($cekpendonor1DESC)) {
                            if ($cekpendonor1DESC->kelompok_umur == 4) {
                                echo 'v';
                            }
                        }
                        ?>
                    </td>
                    <td style="text-align: center;">
                        <?php
                        if (!empty($cekpendonor1DESC)) {
                            if ($cekpendonor1DESC->kelompok_umur == 5) {
                                echo 'v';
                            }
                        }
                        ?>
                    </td>
                    <td style="text-align: center;">
                        <?php
                        if ($cekpendonor1DESC->donasi_ke == 1) {
                            echo 'v';
                        }
                        ?>
                    </td>
                    <td style="text-align: center;">
                        <?php
                        if ($cekpendonor1DESC->donasi_ke > 1) {
                            echo 'v';
                        }
                        ?>
                    </td>
                    <td><?php echo!empty($cekpendonor1DESC) ? $cekpendonor1DESC->alamat_lengkap : ''; ?></td>
                    <?php
                    $criteria2 = new CDbCriteria;
                    $criteria2->select = 'jenisdonor,no_formulir,waktu_observasi,pendonor_id';
                    $criteria2->addCondition('donasi_ke != 0');
                    $criteria2->addCondition('pendonor_id = ' . $val->pendonor_id);
                    $criteria2->group = 'jenisdonor,no_formulir,waktu_observasi,pendonor_id';
                    $criteria2->order = 'waktu_observasi ASC';
                    $criteria2->limit = 6;
                    $cekdonorke = BDLappenyadapandarahV::model()->findAll($criteria2);
                    ?>
                    <?php
                    $totalSukarela = 0;
                    $totalPengganti = 0;
                    $totalAutologus = 0;
                    $sisa = 6 - count($cekdonorke);
                    ?>
                    <?php foreach ($cekdonorke as $value) : ?>
                        <td style="text-align: center;">
                            <?php
                            if ($value->jenisdonor == 'Sukarela') {
                                echo date('d M Y', strtotime($value->waktu_observasi));
                                $totalSukarela++;
                            }
                            ?>
                        </td>
                        <td style="text-align: center;">
                            <?php
                            if ($value->jenisdonor == 'Pengganti') {
                                echo date('d M Y', strtotime($value->waktu_observasi));
                                $totalPengganti++;
                            }
                            ?>
                        </td>
                        <td style="text-align: center;">
                            <?php
                            if ($value->jenisdonor == 'Autologus') {
                                echo date('d M Y', strtotime($value->waktu_observasi));
                                $totalAutologus++;
                            }
                            ?>
                        </td>
                    <?php endforeach; ?>
                    <?php if ($sisa > 0): ?>
                        <?php for ($a = 0; $a < $sisa; $a++): ?>
                            <td></td>
                            <td></td>
                            <td></td>
                        <?php endfor; ?>
                    <?php endif; ?>
                    <td style="text-align: center;">
                        <?php
                        if ($value->jenisdonor == 'Sukarela') {
                            echo $totalSukarela;
                        }
                        ?>
                    </td>
                    <td style="text-align: center;">
                        <?php
                        if ($value->jenisdonor == 'Pengganti') {
                            echo $totalPengganti;
                        }
                        ?>
                    </td>
                    <td style="text-align: center;">
                        <?php
                        if ($value->jenisdonor == 'Autologus') {
                            echo $totalAutologus;
                        }
                        ?>
                    </td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<br>
<?php if ($caraPrint=='PDF') : ?>
<table width="100%" border="0">
    <tr>
        <td></td>
        <td></td>
        <td>&nbsp;Surabaya, <?php echo date('d ').MyFormatter::getMonthId(date('m')).date(' Y');  ?></td>
    </tr>
    <tr>
        <td width="37%" style="text-align: center">
            Koordinator Pelayanan Donor
            <br><br><br><br><br>
            Rosa Rusdiana, A.Md.Kep <br>
            (NIP. 19661219 198903 2 007)
        </td>
        <td></td>
        <td width="28%" style="text-align: center">
            Penanggung Jawab Edukasi dan Pendaftaran
            <br><br><br><br><br>
            Mei Indah Prhatiningsih <br> 
            (NIP. 19680529 198803 2 007)
        </td>
    </tr>
</table>
<?php endif; ?>
<?php if ($caraPrint=='PRINT') : ?>
<table width="100%" border="0">
    <tr>
        <td></td>
        <td></td>
        <td>&nbsp;Surabaya, <?php echo date('d ').MyFormatter::getMonthId(date('m')).date(' Y');  ?></td>
    </tr>
    <tr>
        <td width="37%" style="text-align: center">
            Koordinator Pelayanan Donor
            <br><br><br><br><br>
            Rosa Rusdiana, A.Md.Kep <br>
            (NIP. 19661219 198903 2 007)
        </td>
        <td></td>
        <td width="21%" style="text-align: center">
            Penanggung Jawab Edukasi dan Pendaftaran
            <br><br><br><br><br>
            Mei Indah Prhatiningsih <br> 
            (NIP. 19680529 198803 2 007)
        </td>
    </tr>
</table>
<?php endif; ?>

<?php if ($caraPrint=='EXCEL') : ?>
<table width="100%" border="0">
    <tr>
        <td colspan="3"></td>
        <td colspan="27"></td>
        <td colspan="3">&nbsp;Surabaya, <?php echo date('d ').MyFormatter::getMonthId(date('m')).date(' Y');  ?></td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: center">
            Koordinator Pelayanan Donor
            <br><br><br><br><br>
            Rosa Rusdiana, A.Md.Kep <br>
            (NIP. 19661219 198903 2 007)
        </td>
        <td colspan="27"></td>
        <td colspan="3" style="text-align: center">
            Penanggung Jawab Edukasi dan Pendaftaran
            <br><br><br><br><br>
            Mei Indah Prhatiningsih <br> 
            (NIP. 19680529 198803 2 007)
        </td>
    </tr>
</table>
<?php endif; ?>