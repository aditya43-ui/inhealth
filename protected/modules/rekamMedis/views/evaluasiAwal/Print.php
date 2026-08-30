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
    .borderclass {
        border: 1px solid black;
    }
    .bordertopclass {
        border-top: 1px solid black;
    }
    .borderrightclass {
        border-right: 1px solid black;
    }
    .borderleftclass {
        border-left: 1px solid black;
    }
    .borderbottomclass {
        border-bottom: 1px solid black !important;
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

    .borderclass {
        border: 1px solid black;
    }
    .bordertopclass {
        border-top: 1px solid black;
    }
    .borderrightclass {
        border-right: 1px solid black;
    }
    .borderleftclass {
        border-left: 1px solid black;
    }
    .borderbottomclass {
        border-bottom: 1px solid black !important;
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
    
    .pilihan {
        display: inline-block;
        width: 300px;
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
<!--    <center>
        <div>FORMULIR DOKUMENTASI MANAJER <br/> PELAYANAN PASIEN (CASE MANAGER)  <br/>FORM A "EVALUASI AWAL"</div>
    </center>-->
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
            <td rowspan="5" width="150" align="center"><?php echo date('d', strtotime($model->tgl_evaluasi)) . ' ' . MyFormatter::getMonthId(date('m', strtotime($model->tgl_evaluasi))) . ' ' . date('Y', strtotime($model->tgl_evaluasi)); ?></td>
            <td>
                Identifikasi/Skrining Pasien: <br/>
                <?php
                $resiko_item = LookupM::getItems('kelompokresiko');
                if (!in_array($model->kelompok_resiko, $resiko_item)) {
                    $model->kelompok_resikolainnya = $model->kelompok_resiko;
                    $model->kelompok_resiko = "LAINNYA";
                }
                
                
                foreach ($resiko_item as $item => $label): ?>
                <div class="pilihan">
                    <?php echo ($model->kelompok_resiko == $item) ? $ceklis : $unceklis; ?>
                    <?php echo $label; ?>
                    <?php if ($item == "LAINNYA") {
                        echo ", ".$model->kelompok_resikolainnya;
                    } ?>
                </div>
                <?php endforeach; ?>
            </td>
        </tr>
        <tr>
            <td>
                Asesmen: <br/>
                <ol>
                    <li>Informasi Klinis<br/>
                        <ul>
                            <li>Psikososial : <?php echo $model->psikososial; ?></li>
                            <li>Sosio Ekonomi : <?php echo $model->sosioekonomi; ?></li>
                            <li>Sistem Pembayaran Rumah Sakit :<br/>
                            <?php
                            $cr = new CDbCriteria;
                            $cr->addCondition("tgl_pendaftaran::date <= '".$model->tgl_evaluasi."'::date");
                            $cr->compare('pasien_id', $model->pasien_id);
                            $cr->order = 'pendaftaran_id desc';
                            $daftar = PendaftaranT::model()->find($cr);
                            ?>
                            Jenis Penjamin : <?php echo $daftar->carabayar->carabayar_nama; ?>, Penjamin: <?php echo $daftar->penjamin->penjamin_nama; ?></li>
                        </ul>
                    
                    </li>
                </ol>
            </td>
        </tr>
        <tr>
            <td>
                Identifikasi Masalah:<br/>
                <?php echo $model->identifikasi_masalah; ?>
            </td>
        </tr>
        <tr>
            <td>
                Perencanaan:<br/>
                <?php echo $model->perencanaan; ?>
            </td>
        </tr>
        <tr>
            <td>
                Edukasi Pasien dalam Pengambilan Keputusan Mengenai:<br/>
                <?php echo $model->assesmen; ?>
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
