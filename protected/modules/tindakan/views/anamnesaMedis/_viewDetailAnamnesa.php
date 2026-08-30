<style>
    .table tfoot td {
        color: black !important;
    }
</style>
<?php
$modPasien = $modPendaftaran->pasien;
?>
<table style="width: 100%; border: none;">
    <tr>
        <td >
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('nama_pasien')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->pasien->nama_pasien); ?>
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('tgl_pendaftaran')); ?>:</label>
            <?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPendaftaran->tgl_pendaftaran)); ?>
        </td>
    </tr><br>
    <tr>
        <td>
                <label class='control-label'><?php echo CHtml::encode($modPendaftaran->pasien->getAttributeLabel('jeniskelamin')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->pasien->jeniskelamin); ?>
        </td>
        <td>
             <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('no_pendaftaran')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->no_pendaftaran); ?>
        </td>
    </tr><br>
    <tr>
        <td>
                <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('umur')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->umur); ?>
        </td>
        <td>
             <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Kelas Pelayanan')); ?>:</label>
             <?php 
                $pasienAdmisi = PasienadmisiT::model()->findByPk($modAnamnesa->pasienadmisi_id);
                $kelasPelayanan = $modPendaftaran->kelaspelayanan->kelaspelayanan_nama;
                
                if(isset($pasienAdmisi)){
                    if(isset($pasienAdmisi->kelaspelayanan)){
                        $kelasPelayanan = $pasienAdmisi->kelaspelayanan->kelaspelayanan_nama;
                    }
                }
                
            echo CHtml::encode($kelasPelayanan); ?>
        </td>
    </tr><br>
    <tr>
        <td>
                <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Jenis Penjamin / Penjamin ')); ?>:</label>
                <?php echo CHtml::encode($modPendaftaran->carabayar->carabayar_nama); ?> / <?php echo CHtml::encode($modPendaftaran->penjamin->penjamin_nama); ?>
            
        </td>
        <td>
            <label class='control-label'><?php echo CHtml::encode($modPendaftaran->getAttributeLabel('Nama Dokter')); ?>:</label>
            <?php echo CHtml::encode($modPendaftaran->pegawai->nama_pegawai); ?>
        </td>
    </tr> 
</table>
<table id="tblDaftarAnamnesa" class="table table-bordered table-condensed" border="2">
    <tr>
        <td style="width:30%">Perawat</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->paramedis_nama)?$modAnamnesa->paramedis_nama:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Keluhan Utama</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->keluhanutama)?$modAnamnesa->keluhanutama:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Keluhan Tambahan</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->keluhantambahan)?$modAnamnesa->keluhantambahan:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%">Riwayat Penyakit Pasien</td>
        <td style="width:70%"><?php echo isset($modAnamnesa->riwayatperjalananpasien)?$modAnamnesa->riwayatperjalananpasien:" - "; ?></td>
    </tr>
    <tr>
        <td style="width:30%;height:86px">Keterangan</td>
        <td style="width:70%;height:86px"><?php echo isset($modAnamnesa->keterangananamesa)?$modAnamnesa->keterangananamesa:" - "; ?></td>
    </tr>
</table>

<?php if ($modAnamnesa->skrining_dewasa): ?>
            
        <div style="text-align: center">SKRINING GIZI DEWASA</div>
        <table width="100%" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Kriteria.</th>
                    <th colspan="2">Jawaban</th>
                </tr>
                <tr>
                    <th>Ya<br>Skor=1</th>
                    <th>Tidak<br>Skor=0</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="10">1</td>
                    <td>Apakah IMT < 20,5 atau LLA < 25 cm untuk wanita dan LLA < 26,3 cm untuk pria ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria1 == true ? '<i class="entypo-check">' : '' ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria1 == false ? '<i class="entypo-check">' : '' ?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Apakah pasien kehilangan BB dalam 3 minggu terakhir ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria2 == true ? '<i class="entypo-check">' : '' ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria2 == false ? '<i class="entypo-check">' : '' ?></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Apakah asupan makan pasien menurun hingga 1 minggu terakhir ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria3 == true ? '<i class="entypo-check">' : '' ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria3 == false ? '<i class="entypo-check">' : '' ?></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Apakah pasien dengan penyakit berat dan atau membutuhkan terapi gizi ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria4 == true ? '<i class="entypo-check">' : '' ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_dewasa_kriteria4 == false ? '<i class="entypo-check">' : '' ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td>TOTAL SKOR</td>
                    <td colspan="2" style="text-align: right;"><?php echo $modAnamnesa->skrining_dewasa_skor ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">HASIL : <?php echo $modAnamnesa->skrining_dewasa_hasil; ?></td>
                </tr>

            </tfoot>
        </table>

        <?php endif; ?>

        <?php if ($modAnamnesa->anamnesa_anak) {
            echo $this->renderPartial('/_periksaDataPasien/_anamnesa_anak', array(
                'modAnamnesa'=>$modAnamnesa,
            ), true);
        } ?>

        <?php if ($modAnamnesa->skrining_anak): ?>
        <div style="text-align: center">SKRINING GIZI ANAK</div>
        <table width="100%" class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Kriteria.</th>
                    <th colspan="2">Jawaban</th>
                </tr>
                <tr>
                    <th>Ya<br>Skor=1</th>
                    <th>Tidak<br>Skor=0</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="10">1</td>
                    <td>Apakah IMT anak berada dibawah nilai cut-off tabel IMT rujukan ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria1 == true ? '<i class="entypo-check">' : ''; ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria1 == false ? '<i class="entypo-check">' : ''; ?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Apakah anak mengalami penurunan berat badan akhir-akhir ini ? (Seperti penurunan BB Tidak disengaja, baju menjadi lebih longgar, kenaikan BB tidak signifikan (jika <2 tahun))</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria2 == true ? '<i class="entypo-check">' : ''; ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria2 == false ? '<i class="entypo-check">' : ''; ?></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Apakah anak mengalami penurunan intake makanan (termasuk ASI dan susu formula) setidaknya selama 1 minggu terakhir ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria3 == true ? '<i class="entypo-check">' : ''; ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria3 == false ? '<i class="entypo-check">' : ''; ?></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Apakah status gizi anak akan dipengaruhi oleh penyakit/kondisi kesehatan setidaknya untuk 1 minggu kedepan ?</td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria4 == true ? '<i class="entypo-check">' : ''; ?></td>
                    <td class="pilih_center" width="50"><?php echo $modAnamnesa->skrining_anak_kriteria4 == false ? '<i class="entypo-check">' : ''; ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td>TOTAL SKOR</td>
                    <td colspan="2" style="text-align: right;"><?php echo $modAnamnesa->skrining_anak_skor; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">HASIL : <?php echo $modAnamnesa->skrining_anak_hasil; ?></td>
                </tr>

            </tfoot>
        </table>

<?php endif; ?>

<table>
<tr>
    <td><?php echo CHtml::link(Yii::t('mds', '{icon} Print Detail', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printAnamnesa();return false")); ?></td>
</tr>
</table>
<script type="text/javascript">
    function printAnamnesa()
{
    window.open('<?php echo $this->createUrl('printAnamnesa',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)); ?>','printwin','left=100,top=100,width=640,height=480');
}
</script>