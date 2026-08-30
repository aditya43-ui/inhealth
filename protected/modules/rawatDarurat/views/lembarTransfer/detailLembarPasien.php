<style type="text/css">
    .tablefont td{
        color: black;
        padding: 5px;
    }
    .borderclass {
        border: 1px solid black;
    }
</style>


<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title"><strong>Data Transfer Pasien</strong></div>
    </div>
    <div class="panel-body">
        <table width="100%">
            <tr>
                <td width="50%">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="200px">Ruangan Asal</td>
                            <td width="10px">:</td>
                            <td><?php echo $model->ruanganasal->instalasi->instalasi_nama.'/ '.$model->ruanganasal->ruangan_nama; ?></td>
                        </tr>
                        <tr>
                            <td>Waktu Transfer</td>
                            <td>:</td>
                            <td><?php echo $model->waktu_transfer; ?></td>
                        </tr>
                        <tr>
                            <td>Diagnosa Masuk RS</td>
                            <td>:</td>
                            <td><?php echo $model->diagnosamasukrs; ?></td>
                        </tr>
                        <tr>
                            <td>Dokter Pengirim</td>
                            <td>:</td>
                            <td><?php echo $model->dokterpengirim->namaLengkap; ?></td>
                        </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="200px">Tanggal Transfer</td>
                            <td width="10px">:</td>
                            <td><?php echo MyFormatter::formatDateTimeForUser($model->tanggal_transfer); ?></td>
                        </tr>
                        <tr>
                            <td>Ruangan yang dituju</td>
                            <td>:</td>
                            <td> <?php echo $model->instalasitujuan->instalasi_nama.'/ '.$model->ruangantujuan->ruangan_nama; ?></td>
                        </tr>
                        <tr>
                            <td>Waktu Tiba</td>
                            <td>:</td>
                            <td> <?php echo (!empty($modProsesTransfer->setelahtransfer_waktutiba)? $modProsesTransfer->setelahtransfer_waktutiba: '-'); ?></td>
                        </tr>
                        <tr>
                            <td>Indikasi Dirawat</td>
                            <td>:</td>
                            <td> <?php echo $model->indikasidirawat; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title"><strong>I. Ringkasan Riwayat Pasien</strong></div>
    </div>
    <div class="panel-body">
        <table width="100%" class="tablefont">
            <tr>
                <td width="100px">Pukul</td>
                <td width="10px">:</td>
                <td><?php echo $model->jamringkas_riwayatpasien; ?></td>
            </tr>
        </table>
        <br/>
        <table width="100%">
            <tr>
                <td colspan="2" style="font-weight: bold; color: black;">Anamnesis</td>
            </tr>
            <tr>
                <td width="50%">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="120px">Keluhan Utama</td>
                            <td width="10px">:</td>
                            <td><?php echo $model->dokter_keluhanutama; ?></td>
                        </tr>
                        <tr>
                            <td width="120px">Riwayat Penyakit</td>
                            <td width="10px">:</td>
                            <td><?php echo $model->riwayatpenyakitterdahulu; ?></td>
                        </tr>
                        <tr>
                            <td>Riwayat Alergi</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="padding-left: 20px;">
                                <?php echo $model->riwayatalergi; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Keadaan Umum</td>
                            <td>:</td>
                            <td><?php echo $model->dokter_keadaanumum; ?></td>
                        </tr>
                    </table>
                </td>
                <td width="50%" valign="top">
                    <table width="100%" class="tablefont">
                        <tr>
                            <td width="150px">Pemeriksaan Tanda Vital</td>
                            <td width="10px">:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="padding-left:100px">Tensi</td>
                            <td>:</td>
                            <td> <?php echo $model->ttvdokter_td_systolic.'/ '.$model->ttvdokter_td_diastolic; ?> mmHg</td>
                        </tr>
                        <tr>
                            <td style="padding-left:100px">Suhu</td>
                            <td>:</td>
                            <td> <?php echo $model->ttvdokter_suhutubuh; ?> &#176 Celcius</td>
                        </tr>
                        <tr>
                            <td style="padding-left:100px">Nadi</td>
                            <td>:</td>
                            <td> <?php echo $model->ttvdokter_nadi; ?> x/menit </td>
                        </tr>
                        <tr>
                            <td>Alasan Ditransfer</td>
                            <td>:</td>
                            <td> <?php echo $model->alasanditransfer; ?></td>
                        </tr>
                        <tr>
                            <td>Kebutuhan Pelayanan</td>
                            <td>:</td>
                            <td> <?php echo $model->kebutuhanpelayanan; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title"><strong>II. Ringkasan Riwayat Pasien</strong></div>
    </div>
    <div class="panel-body">
      <div style="color: black;"><?php echo $model->dokter_ringkasanriwayatpasien; ?></div>
    </div>
</div>
<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title"><strong>III. Tindakan Medis yang Sudah Dilakukan</strong></div>
    </div>
    <div class="panel-body">
      <div style="color: black;"><?php echo $model->dokter_tindakanmedisygdilakukan; ?></div>

        <!-- <table class="table table-bordered table-condensed">
            <thead>
                <th>Tindakan</th>
            </thead>
            <tbody>
        <?php //foreach ($modTindakans as $i => $modTindakan) { ?>
            <tr>
                <td>
                    <?php //echo $modTindakan->tgl_tindakan; ?> <br/>
                    <?php //echo !empty($modTindakan->tipePaket->tipepaket_nama) ? $modTindakan->tipePaket->tipepaket_nama:"-"; ?> <br/>

                    <?php //echo $modTindakan->daftartindakan->daftartindakan_nama; ?>,
                    <?php //echo $modTindakan->qty_tindakan; ?>
                    <?php //echo $modTindakan->satuantindakan; ?> <br/>

                    Pemeriksa :
                    <?php
                        //echo (isset($modTindakan->dokter1->namaLengkap) ? $modTindakan->dokter1->namaLengkap : '');
                        //echo (!empty($modTindakan->dokterpemeriksa1_id)) ? ',' : '';
                    ?>
                    <?php //echo ((isset($modTindakan->dokter2)) ? $modTindakan->dokter2->namaLengkap : null); echo (!empty($modTindakan->dokterpemeriksa2_id)) ? ',' : ''; ?>
                    <?php //echo ((isset($modTindakan->dokterPendamping)) ? $modTindakan->dokterPendamping->namaLengkap : null); echo (!empty($modTindakan->dokterpendamping_id)) ? ',' : ''; ?>
                    <?php //echo ((isset($modTindakan->dokterAnastesi)) ? $modTindakan->dokterAnastesi->namaLengkap : null); echo (!empty($modTindakan->dokteranastesi_id)) ? ',' : ''; ?>
                    <?php //echo ((isset($modTindakan->dokterDelegasi)) ? $modTindakan->dokterDelegasi->namaLengkap : null); echo (!empty($modTindakan->dokterdelegasi_id)) ? ',' : ''; ?>
                    <?php //echo ((isset($modTindakan->bidan)) ? $modTindakan->bidan->nama_pegawai : null); echo (!empty($modTindakan->bidan_id)) ? ',' : ''; ?>
                    <?php //echo ((isset($modTindakan->bidan2)) ? $modTindakan->bidan2->nama_pegawai : null); echo (!empty($modTindakan->bidan2_id)) ? ',' : ''; ?>
                    <?php //echo ((isset($modTindakan->suster)) ? $modTindakan->suster->nama_pegawai : null); echo (!empty($modTindakan->suster_id)) ? ',' : ''; ?>
                    <?php //echo ((isset($modTindakan->perawat)) ? $modTindakan->perawat->nama_pegawai : null); echo (!empty($modTindakan->perawat_id)) ? ',' : ''; ?>
                    <?php //echo ((isset($modTindakan->perawat2)) ? $modTindakan->perawat2->nama_pegawai : null); echo (!empty($modTindakan->perawat2_id)) ? ',' : ''; ?>
                </td>
            </tr>
        <?php //} ?>
            </tbody>
        </table> -->
    </div>
</div>
<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title"><strong>IV. Pemberian Terapi</strong></div>
    </div>
    <div class="panel-body">
      <div style="color: black;"><?php echo $model->dokter_pemberianterapi; ?></div>
        <!-- <p style="font-weight: bold; color: black">Pemakaian Bahan Habis Pakai (BHP)</p>
        <table class="table table-bordered table-condensed" style="width: 70%">
            <thead>
                <th>Tgl. Pemakaian</th>
                <th>Jenis Obat Alkes</th>
                <th>Nama Obat Alkes</th>
                <th>Jumlah</th>
            </thead>
            <tbody>
        <?php

        // if(count($modRiwayatResepBHP) > 0){
        // foreach ($modRiwayatResepBHP as $i => $bmhp) { ?>
            <tr>
                <td>
                    <?php //echo $bmhp->tglpelayanan; ?>
                </td>
                <td>
                    <?php //echo (isset($bmhp->obatalkes->jenisobatalkes)? $bmhp->obatalkes->jenisobatalkes->jenisobatalkes_nama: ""); ?>
                </td>
                <td>
                    <?php //echo $bmhp->obatalkes->obatalkes_nama; ?>
                </td>
                <td style="text-align:right;">
                    <?php //echo $bmhp->qty_oa; ?>
                </td>
            </tr>
        <?php //} ?>
        <?php  //}else{ ?>
            <tr>
                <td colspan="4">Tidak ditemukan hasil.</td>
            </tr>
            <?php //} ?>
            </tbody>
        </table>
        <p style="font-weight: bold; color: black">Resep</p>
        <table class="items table table-bordered table-striped table-condensed" id="tblInputTindakan">
            <thead>
                <tr>
                    <th>Tanggal Resep</th>
                    <th>No. Resep</th>
                    <th>Nama Dokter</th>
                    <th>Lihat Detail</th>
                </tr>
            </thead>
            <?php
            // if(count($modRiwayatResep) > 0){
            // foreach ($modRiwayatResep as $i => $resep) { ?>
            <tr>
                <td><?php //echo $resep->tglreseptur ?></td>
                <td><?php //echo $resep->noresep ?></td>
                <?php //$pegawai = PegawaiM::model()->findByPk($resep->pegawai_id) ?>
                <td><?php //echo  $pegawai->namaLengkap ?></td>
                <td><center><?php //echo CHtml::link("<i class='icon-eye-open'></i>", 'javascript:void(0)', array('onclick'=>'viewDetailResep("'.$resep->reseptur_id.'","'.$model->pendaftaran_id.'");return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail resep'));  ?></center></td>
            </tr>
            <?php //}  ?>
           <?php  //}else{ ?>
            <tr>
                <td colspan="4">Tidak ditemukan hasil.</td>
            </tr>
            <?php //} ?>
        </table> -->
    </div>
</div>
<div class="panel panel-success panel-shadow">
    <div class="panel-heading">
        <div class="panel-title"><strong>V. Lain-Lain</strong></div>
    </div>
    <div class="panel-body">
        <div style="color: black;"><?php echo $model->dokter_catatanlainlain; ?></div>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailresep',
    'options'=>array(
        'title'=>'Detail Reseptur',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
    ),
));

    echo '<div id="contentDetailResep"></div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>

<script type='text/javascript'>
function viewDetailResep(idReseptur,pendaftaran_id)
{
    $.post('<?php echo $this->createUrl('ajaxDetailResep') ?>', {idReseptur: idReseptur, pendaftaran_id: pendaftaran_id}, function(data){
                $('#contentDetailResep').html(data.result);
        }, 'json');
        $('#dialogDetailresep').dialog('open');
}

function printReseptur(caraPrint, idReseptur)
{
    var pendaftaran_id = '<?php echo isset($_GET["pendaftaran_id"]) ? $_GET["pendaftaran_id"] : null ?>';
    window.open('<?php echo $this->createUrl('printReseptur'); ?>&id='+pendaftaran_id+'&idReseptur='+idReseptur+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

</script>
