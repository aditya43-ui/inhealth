<style>
    body{
        color: black !important;
    }
    h5{
        color: black !important;
    }
    label{
        color: black !important;
    }
    .tab_header {
        width: 100%;
    }
    .pilihan_ijin, .pilihan_privasi {
        font-weight: bold;
        cursor: pointer;
    }

    p {
        text-align: justify;
    }

    .tab_header {
        width: 100%;
    }

    .tab_header td {
        vertical-align: top;
    }

    .tab_oa {
        width: 100%;
        border-collapse: collapse;
    }

    .tab_oa th, .tab_oa td {
        border: 1px solid black;
        padding: 2px;
    }

    .tab_layout td {
        vertical-align: top;
    }

    .text-center{
        text-align: center !important;
    }
    .padding10 {
        padding: 10px;
    }
    .padding5 {
        padding: 5px;
    }
    /* @page { size: landscape; } */

    .divUtama{
        padding: 0 50px 0 50px;
    }
    
    .tab_info td {
        vertical-align: top;
    }
    
    .tab_detail {
        width: 100%;
        border-collapse: collapse;
    }
    
    .tab_detail td {
        border: 1px solid black;
    }
    
</style>

<?php 
$ceklis = "&#9745;";
$unceklis = "&#9744;";
?>

<br />
<?php echo $this->renderPartial($this->path_view . '_headerSurat', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
<br/> 
<br/>



<div class="divUtama">
    <!--center>
        <div>FORMULIR DOKUMENTASI MANAJER <br/> PELAYANAN PASIEN (CASE MANAGER)  <br/>FORM B "CATATAN IMPLEMENTASI"</div>
    </center-->

    <table width="100%" class="tab_info">
        <tr>
            <td width="100">Nama</td>
            <td width="10">:</td>
            <td width="35%"><?php echo $modPasien->nama_pasien; ?></td>
            <td width="100">No. RM</td>
            <td width="10">:</td>
            <td><?php echo $modPasien->no_rekam_medik; ?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td><?php echo $modPasien->jeniskelamin; ?></td>
            <td>DPJP</td>
            <td>:</td>
            <td>
            <?php
                $pegawaiNamaDpjp = "";
                $pegawaiId = $modPendaftaran->pegawai_id;

                if(!empty($pegawaiId)){
                  $modPeg = PegawaiM::model()->findByPk($pegawaiId);
                  $pegawaiNamaDpjp = (isset($modPeg)? $modPeg->namaLengkap:"");
                }

                echo $pegawaiNamaDpjp;
            ?>
            </td>
        </tr>
        <tr>
            <td>Umur</td>
            <td>:</td>
            <td><?php echo $modPendaftaran->umur; ?></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Ruangan</td>
            <td>:</td>
            <td><?php echo $model->ruangan->ruangan_nama; ?></td>
            <td>Diagnosis</td>
            <td>:</td>
            <td><?php echo $model->diagnosa_nama; ?></td>
        </tr>
    </table>
    
    <table class="tab_detail">
        <tr>
            <td rowspan="6" width="150" align="center"><?php echo date('d', strtotime($model->tgl_evaluasi)) . ' ' . MyFormatter::getMonthId(date('m', strtotime($model->tgl_evaluasi))) . ' ' . date('Y', strtotime($model->tgl_evaluasi)); ?></td>
            <td>
                Pelaksanaan:<br/>
                <?php echo $model->pelaksanaan; ?>
            </td>
        </tr>
        <tr>
            <td>
                Monitoring:<br/>
                <?php echo $model->monitoring; ?>
            </td>
        </tr>
        <tr>
            <td>
                Fasilitas, Koordinasi, Komunikasi dan Kolaborasi<br/>
                <?php
                $pilih = array(
                    "DPJP", 
                    "Pelayanan Asuransi", 
                    "Anggota Tim Klinis", 
                    "Pelayanan Administrasi", 
                    "Pelayanan Keuangan", 
                    "Pasien dan Keluarga"
                );
                $fasilitas = explode(";", $model->fasilitas);
                
                foreach ($pilih as $item): ?>
                <div class="pilihan">
                    <?php echo in_array($item, $fasilitas) ? $ceklis : $unceklis; ?>
                    <?php echo $item; ?>
                </div>
                <?php endforeach; ?>
            </td>
        </tr>
        <tr>
            <td>
                Advokasi:<br/>
                <?php echo $model->advokasi; ?>
            </td>
        </tr>
        <tr>
            <td>
                Hasil Pelayanan:<br/>
                <?php echo $model->hasilpelayanan; ?>
            </td>
        </tr>
        <tr>
            <td>
                Terminasi:<br/>
                <?php echo $model->terminasi; ?>
            </td>
        </tr>
    </table>

</div>
<br /><br /><br />
<table width="100%">
    <tr>
        <td style="width:70%; text-align: left;" colspan="2">
        </td>
        <td style="text-align: left;" colspan="2" nowrap>
            <center>Singaraja, <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')); ?> WITA</center>
        </td>
    </tr>
    <tr>
        <td style="width:70%; text-align: left;" colspan="2">
        </td>
        <td colspan="2" >
            <center>Manager Pelayanan Pasien
                <br><br><br><br><br><br>
                <?php echo $model->petugaspengisi->namaLengkap; ?>
            </center>
        </td>
    </tr>
</table>


<?php if (empty($caraPrint)) { 
    echo CHtml::link('Kembali', $this->createUrl('riwayat', array(
        'pasien_id'=>$model->pasien_id,
        'frame'=>1
    )), array(
        'class'=>'btn btn-danger'
    ));
}
?>
<br/>