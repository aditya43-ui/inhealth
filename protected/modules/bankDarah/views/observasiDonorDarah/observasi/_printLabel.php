<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: left;
        letter-spacing: 3px; 
        font-size: 7pt;
    } 
    tr, td{ 
        font-size: 7pt !important; 
        margin-top: 0px;
    }
    body{
        width:3.14961in; 
    }
    h1 {
        font-size: 25pt;
    }
</style>

<div style="width:3.14961in; height: 1.1811in">
    <?php
    $color = '';
    if ($modObservasi->pendonor->gol_darah == 'A') {
        $color = 'yellow';
    } else if ($modObservasi->pendonor->gol_darah == 'B') {
        $color = 'red';
    } else if ($modObservasi->pendonor->gol_darah == 'O') {
        $color = 'cyan';
    } else if ($modObservasi->pendonor->gol_darah == 'AB') {
        $color = 'white';
    }
    $cekPegawai = PegawaiM::model()->findByPk($modObservasi->petugas_id);
    $pegawai = '';
    if (!empty($cekPegawai)) {
        $pegawai = $cekPegawai->namaLengkap;
    }
    ?>
    <table style="width:3.14961in; height: 1.1811in" style="border: 1px solid #000000">
        <thead>
            <tr>
                <td colspan="3" style="border: 1px solid #000000; text-align: center; font-weight: bold; padding: 2px">INSTALASI TRANSFUSI DARAH RSUD DR. SOETOMO</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="3" style="border: 1px solid #000000; text-align: center; background: <?php echo $color ?>"><b><h1><?php echo $modObservasi->pendonor->gol_darah; ?></h1></b></td>
                <td style="border: 1px solid #000000; text-align: center; font-weight: bold; background: <?php echo $color ?>">Rhesus</td>
                <td rowspan="3" style="border: 1px solid #000000; vertical-align: top">
                    <br>
                    <div style="text-align: center;font-size:7pt; font-weight: bold">Penyadapan Darah</div>
                    <br>
                    <br>
                    <div style="font-size:7pt">&nbsp;  Tanggal dan Jam &nbsp;: <?php echo date('d ', strtotime($modObservasi->waktu_observasi)) . MyFormatter::getMonthId(date('m', strtotime($modObservasi->waktu_observasi))) . date(' Y', strtotime($modObservasi->waktu_observasi)) . date(' H:i:s', strtotime($modObservasi->waktu_observasi)); ?></div>
                    <div style="font-size:7pt">&nbsp;  Nama Penyadap &nbsp; : <?php echo $pegawai; ?></div>
                </td>
            </tr>
            <tr>
                <td rowspan="2" style="border: 1px solid #000000; text-align: center; font-weight: bold;background: <?php echo $color ?>">
                    <b>
                        <h1>
                            <?php
                            if ($modObservasi->pendonor->rhesus == 'Positif' || $modObservasi->pendonor->rhesus == 'POSITIF') {
                                echo '+';
                            } else if ($modObservasi->pendonor->rhesus == 'Negatif' || $modObservasi->pendonor->rhesus == 'NEGATIF') {
                                echo '-';
                            }
                            ?>
                        </h1>
                    </b>
                </td>
            </tr>
            <tr>

            </tr>
        </tbody>
    </table>
</div> 
<br>