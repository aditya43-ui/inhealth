<h3 align="center">FORMULIR PEMANTAUAN CPIS PASIEN ICU</h3>
<h3 align="center"><i>( CLINICAL PULMONARY INFECTIONS SCORE )</i></h3>

<?php
    $riwayat = $model->listRiwayatByDaftarId();    
?>

<table class="prinout w100 grid">
    <tr>
        <th rowspan="2" style="text-align: center;">Hasil<br/>Pemantauan</th>
        <th colspan="5" style="text-align: center;">CPIS</th>
        <th rowspan="2">Total<br/>Score</th>
        <th rowspan="2">Hasil<br/>(VAP)</th>
        <th rowspan="2">Nama & Paraf<br/>Pemantau</th>
    </tr>
    <?php
        foreach($riwayat as $key => $val){
            foreach($val->det as $k => $v){
                echo "<td>".$v->label."</td>";                
            }
            break;
        }
    
    
        $format = new MyFormatter;
        $no = 1;
        foreach($riwayat as $key => $val){
            echo "<tr>";
            echo "<td>Hari ".$no."<br/>Tgl : ".($format->formatDateTimeForUser($val->tanggalpengkajian))."</td>";
            foreach($val->det as $k => $v){
                echo "<td>".$v->hasipenilaian."</td>";
            }
            echo "<td>".$val->total_skor."</td>";
            echo "<td>".$v->hasil_vap."</td>";
            echo "<td>".$val->petugaspengkaji_nama."</td>";
            echo "</tr>";
            
            $no++;
        }
    ?>
    <tr>
        <td colspan="9" height="100px">
            <?= 'Hasil Kultur :<br/>'.$model->allHasilKultur ?>
        </td>
    </tr>
</table>

<br /><br /><br />

<h3 align="center">CPIS SCORE</h3>
<table class="prinout w100 grid">
    <tr>
        <th style="text-align: center;">* CPIS Point</th>
        <th style="text-align: center;">0</th>
        <th style="text-align: center;">1</th>
        <th style="text-align: center;">2</th>
    </tr>
    <tr>
        <td style="text-align: center;">Sekresi trachea**</td>
        <td style="text-align: center;">Sedikit</td>
        <td style="text-align: center;">Sedang</td>
        <td style="text-align: center;">Banyak</td>
    </tr>
    <tr>
        <td style="text-align: center;">Infiltrat CXR</td>
        <td style="text-align: center;">Tidak ada infiltrat</td>
        <td style="text-align: center;">Difus</td>
        <td style="text-align: center;">Terloklisir</td>
    </tr>
    <tr>
        <td style="text-align: center;">Suhu (<sup>o</sup>C)</td>
        <td style="text-align: center;">&ge; 36.5 dan &le; 38.4</td>
        <td style="text-align: center;">&ge; 38.5 dan &le; 38.9</td>
        <td style="text-align: center;">&ge; 39 dan &le; 36</td>
    </tr>
    <tr>
        <td style="text-align: center;">Leukosit (per mm<sup>3</sup>)</td>
        <td style="text-align: center;">&ge; 4.000 dan &le; 11.000</td>
        <td style="text-align: center;">< 4.000 atau > 11.000</td>
        <td style="text-align: center;">&nbsp;</td>
    </tr>
    <tr>
        <td style="text-align: center;">Pa02 / Fi02</td>
        <td style="text-align: center;"> ARDS</td>
        <td style="text-align: center;"></td>
        <td style="text-align: center;">Bukan ARDS</td>
    </tr>
</table>

<table class="prinout w100">
    <tr>
        <td rowspan="3" width="5%">Ket : </td>
        <td width="5%">*</td>
        <td>CPIS dievaluasi 1x setiap haru</td>
    </tr>
    <tr>        
        <td>**</td>
        <td>Jika purulent, skore + 1</td>
    </tr>
    <tr>        
        <td>***</td>
        <td>Berdasarkan AGD pagi</td>
    </tr>
</table>