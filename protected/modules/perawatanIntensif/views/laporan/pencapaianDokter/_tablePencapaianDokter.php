<style type="text/css">
.table td.centerText {
    text-align: center;
}
.table-striped tr th, .table-striped tr td, .table-striped td + td{
    border-bottom: 1px solid rgba(189, 217, 240, 1);
}
</style>
<?php 
    $dataLapDPJP = PILaporanvisitedokterV::model()->findAll($model->functionCriteriaDPJP());
    $dataLapPegawai = PILaporanvisitedokterV::model()->findAll($model->functionCriteriaPegawai());
//    echo Yii::app()->user->getState('ruangan_id');
//    echo Yii::app()->user->getState('nursestation_id');
?>
    <table class="table table-striped table-condensed">
        <thead>
            <tr>
<th id="tableRujukanRS_c0" rowspan="2"><p style="margin: 0; text-align: center;">NO</p></th>
<th id="tableRujukanRS_c1" rowspan="2"><p style="margin: 0; text-align: center;">NAMA DOKTER</p></th>
<th id="tableRujukanRS_c2" colspan="2"><p style="margin: 0; text-align: center;">CAPAIAN (DPJP)</p></th>
<th id="tableRujukanRS_c3" rowspan="2"><p style="margin: 0; text-align: center;">JML PX</p></th>
<th id="tableRujukanRS_c4" colspan="2"><p style="margin: 0; text-align: center;">VISITE</p></th>
<th id="tableRujukanRS_c5" rowspan="2"><p style="margin: 0; text-align: center;">JML VISITE</p></th>
<th id="tableRujukanRS_c6" rowspan="2"><p style="margin: 0; text-align: center;">JML KONSUL</p></th>
<th id="tableRujukanRS_c7" rowspan="2"><p style="margin: 0; text-align: center;">TANDA TANGAN DOKTER</p></th>
            </tr>
            <tr>
                <th>BPJS</th>
                <th>UMUM</th>
                <th>BPJS</th>
                <th>UMUM</th>
            </tr>
        </thead>
<?php
    if(count((array)$dataLapDPJP) > 0 || count((array)$dataLapPegawai) > 0){
?>
        <tbody>
            <?php
            $nomor = 1;
            $total_Dpjp_Bpjs = 0;
            $total_Dpjp_umum = 0;
            $total_Visite_Bpjs = 0;
            $total_Visite_umum = 0;
            $total_konsul = 0;
            foreach ($dataLapDPJP as $key => $val) {
                $jml_bpjs = PILaporanvisitedokterV::model()->findAll($model->jumlahDpjp($val->pegawai_id, 4)); //bpjs
                $jml_bpjsX = count((array)$jml_bpjs);
                $total_Dpjp_Bpjs += $jml_bpjsX;
                
                $jml_umum = PILaporanvisitedokterV::model()->findAll($model->jumlahDpjp($val->pegawai_id, 1)); //umum
                $jml_umumX = count((array)$jml_umum);
                $total_Dpjp_umum += $jml_umumX;
                
                $jml_visite_bpjs = PILaporanvisitedokterV::model()->findAll($model->jumlahVisite($val->pegawai_id, 4, 4)); //bpjs dan kelompok id 4
                $jml_visite_bpjsX = count((array)$jml_visite_bpjs);
                $total_Visite_Bpjs += $jml_visite_bpjsX;
                
                $jml_visite_umum = PILaporanvisitedokterV::model()->findAll($model->jumlahVisite($val->pegawai_id, 1, 4)); //umum dan kelompok id 4
                $jml_visite_umumX = count((array)$jml_visite_umum);
                $total_Visite_umum += $jml_visite_umumX;
                
                $jml_konsul = PILaporanvisitedokterV::model()->findAll($model->jumlahKonsul($val->pegawai_id,2)); // kelompok id 4
                $jml_konsulX = count((array)$jml_konsul);
                $total_konsul += $jml_konsulX;
                
                echo '<tr class="old">';
                    echo '<td class="centerText">'.$nomor.'</td>';
                    echo '<td>'.$val->dpjp.'</td>';
                    echo '<td class="centerText">'.$jml_bpjsX.'</td>';
                    echo '<td class="centerText">'.$jml_umumX.'</td>';
                    echo '<td class="centerText">'.($jml_bpjsX + $jml_umumX).'</td>';
                    echo '<td class="centerText">'.$jml_visite_bpjsX.'</td>';
                    echo '<td class="centerText">'.$jml_visite_umumX.'</td>';
                    echo '<td class="centerText">'.($jml_visite_bpjsX + $jml_visite_umumX).'</td>';
                    echo '<td class="centerText">'.$jml_konsulX.'</td>';
                    echo '<td></td>';
                echo '<tr>';
                $nomor++;
            }
            ?>
            
            <?php
            foreach ($dataLapPegawai as $key2 => $val2) {
                $jml_bpjs = PILaporanvisitedokterV::model()->findAll($model->jumlahDpjp(null, 4,$val2->dokterpemeriksa1_id)); //bpjs
                $jml_bpjsX = count((array)$jml_bpjs);
                $total_Dpjp_Bpjs += $jml_bpjsX;
                
                $jml_umum = PILaporanvisitedokterV::model()->findAll($model->jumlahDpjp(null, 1, $val2->dokterpemeriksa1_id)); //umum
                $jml_umumX = count((array)$jml_umum);
                $total_Dpjp_umum += $jml_umumX;
                
                $jml_visite_bpjs = PILaporanvisitedokterV::model()->findAll($model->jumlahVisite(null, 4, 4, $val2->dokterpemeriksa1_id)); //bpjs dan kelompok id 4
                $jml_visite_bpjsX = count((array)$jml_visite_bpjs);
                $total_Visite_Bpjs += $jml_visite_bpjsX;
                
                $jml_visite_umum = PILaporanvisitedokterV::model()->findAll($model->jumlahVisite(null, 1, 4, $val2->dokterpemeriksa1_id)); //umum dan kelompok id 4
                $jml_visite_umumX = count((array)$jml_visite_umum);
                $total_Visite_umum += $jml_visite_umumX;
                
                $jml_konsul = PILaporanvisitedokterV::model()->findAll($model->jumlahKonsul(null,2, $val2->dokterpemeriksa1_id)); // kelompok id 4
                $jml_konsulX = count((array)$jml_konsul);
                $total_konsul += $jml_konsulX;
                
                echo '<tr>';
                    echo '<td class="centerText">'.$nomor.'</td>';
                    echo '<td>'.$val2->nama_pegawai.'</td>';
                    echo '<td class="centerText">'.$jml_bpjsX.'</td>';
                    echo '<td class="centerText">'.$jml_umumX.'</td>';
                    echo '<td class="centerText">'.($jml_bpjsX + $jml_umumX).'</td>';
                    echo '<td class="centerText">'.$jml_visite_bpjsX.'</td>';
                    echo '<td class="centerText">'.$jml_visite_umumX.'</td>';
                    echo '<td class="centerText">'.($jml_visite_bpjsX + $jml_visite_umumX).'</td>';
                    echo '<td class="centerText">'.$jml_konsulX.'</td>';
                    echo '<td></td>';
                echo '<tr>';
                $nomor++;
            }
            ?>
            
        </tbody>
         <tbody>
            <tr>
                <td style="text-align:right;font-weight:bold;" colspan="2">TOTAL</td>
                <td style="text-align:center;"><?php echo $total_Dpjp_Bpjs;  ?></td>
                <td style="text-align:center;"><?php echo $total_Dpjp_umum;  ?></td>
                <td style="text-align:center;"><?php echo $total_Dpjp_Bpjs + $total_Dpjp_umum;  ?></td>
                <td style="text-align:center;"><?php echo $total_Visite_Bpjs;  ?></td>
                <td style="text-align:center;"><?php echo $total_Visite_umum;  ?></td>
                <td style="text-align:center;"><?php echo $total_Visite_Bpjs + $total_Visite_umum;  ?></td>
                <td style="text-align:center;"><?php echo $total_konsul;  ?></td>
                <td></td>
            </tr>
        </tbody>
<?php
    }
    else{
?>
        <tbody>
            <tr>
                <td style="font-style:italic;" colspan="8">Data tidak ditemukan.</td>
            </tr>
        </tbody>    
<?php
    }
?>
    </table>
