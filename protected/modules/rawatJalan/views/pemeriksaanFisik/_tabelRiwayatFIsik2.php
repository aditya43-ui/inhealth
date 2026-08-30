<style>
.fa-disabled {
    opacity: 0.7;
    cursor: not-allowed;
}
</style>
<?php

    $modul_login = Yii::app()->user->getState('modul_id');
    $ruangan_login = Yii::app()->user->getState('ruangan_id');
    $pegawai_login = Yii::app()->user->getState('loginpemakai_id');

?>
<table class="items table table-striped table-condensed" id="tblInputTindakan">
    <thead>
        <tr>
            <th>Tanggal Periksa</th>
            <th>Ruangan</th>
            <th>Dokter</th>
            <th>PPDS</th>
            <th>Perawat</th>
            <th>Lihat Detail</th>
            <th>Ubah</th>
            <?php if ($this->module->id == 'rehabMedis'): ?>
            <th>Salin</th>
            <?php endif; ?>
            <th>Hapus</th>
        </tr>
    </thead>
                
    <tbody id="pendaftaran" class="isi-riwayat">
        <?php if(!empty($tabelAnamnesaRD)):?>
        <?php foreach ($tabelAnamnesaRD as $i => $Fisik) { ?>
        <tr>
            <?php 
                
                        $ruangan_create = $Fisik->create_ruangan;
                        $pegawai_create = $Fisik->create_loginpemakai_id;
                
                        $modul_pel = [6, 7, 72];
                
                        $bisa_hapus = ((($ruangan_login == $ruangan_create) && ($pegawai_login == $pegawai_create) && in_array($modul_login, $modul_pel)) || ($ruangan_login == $ruangan_create && !in_array($modul_login, $modul_pel))) ? 1 : 0;
                
                        $fa_disabled = !$bisa_hapus ? "fa-disabled" : "";
            ?>
            <td><?php echo $format->formatDateTimeForUser($Fisik->tglperiksafisik); ?></td>
            <?php $ruangan = RuanganM::model()->findByPk($Fisik->create_ruangan) ?>
            <td><?php echo  $ruangan->ruangan_nama; ?></td>
            <?php $pegawai = PegawaiM::model()->findByPk($Fisik->pegawai_id) ?>
            <td><?php  echo $pegawai->namaLengkap; ?></td>
            <td><?php echo $Fisik->ppds->ppds_nama ?? "" ; ?></td>
            <td><?php echo $Fisik->paramedis_nama; ?></td>
            <td><?php echo CHtml::link("<i class='icon-form-lihat'></i>", '#', array('onclick' => 'viewDetailFisik2("' . $Fisik->notriage_pasien_id . '","' . $Fisik->pemeriksaanfisik_id  . '");return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat detail pemeriksaan fisik')); ?>
            </td>
            <td><?php echo CHtml::link("<i class='icon-form-ubah $fa_disabled'></i>", $this->createUrl('indexDarurat', ['notriage_pasien_id' => $Fisik->notriage_pasien_id, 'pemeriksaanfisik_id' => $Fisik->pemeriksaanfisik_id,'is_triage'=>true, 'jnstransaksi' => 'ubah']), array('rel' => 'tooltip', 'title' => 'Klik untuk salin data pemeriksaan fisik')); ?>
            </td>
            <?php if ($this->module->id == 'rehabMedis'): ?>
            <td><?php echo CHtml::link("<i class='icon-form-copy'></i>", $this->createUrl('index', ['pendaftaran_id' => $Fisik->pendaftaran_id, 'id' => $Fisik->pemeriksaanfisik_id, 'jnstransaksi' => 'salin']), array('rel' => 'tooltip', 'title' => 'Klik untuk mengubah data pemeriksaan fisik')); ?>
            </td>
            <?php endif; ?>
            <td>
                <?php
                $tglperiksafisik = (isset($_GET['tglperiksafisik']) ? $_GET['tglperiksafisik'] : null);
                if ($tglperiksafisik !== $Fisik->tglperiksafisik) {
                    ?>
                <a onclick="hapuspemeriksaan('<?php echo $Fisik->pemeriksaanfisik_id; ?>', this, <?=$bisa_hapus?>);return false;"
                    rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Pemeriksaan Fisik"><i
                        class="icon-form-sampah <?= $fa_disabled?>"></i></a>
                <?php }
                    ?>
            </td>
        </tr>
         <?php } ?>
        <?php else:?>
            <!-- <tr><td colspan="<?php // echo $this->module->id == 'rehabMedis' ? 8 : 7?>">Data tidak ditemukan</td></tr> -->
        <?php endif;?>
    </tbody>
    <tbody id="kunjungan" class="isi-riwayat">
    <?php if(!empty($tabelAnamnesaPasienRD)):?>
        <?php foreach ($tabelAnamnesaPasienRD as $i => $Fisik) { ?>
        <tr>
        <?php 
                
                        $ruangan_create = $Fisik->create_ruangan;
                        $pegawai_create = $Fisik->create_loginpemakai_id;
                
                        $modul_pel = [6, 7, 72];
                
                        $bisa_hapus = ((($ruangan_login == $ruangan_create) && ($pegawai_login == $pegawai_create) && in_array($modul_login, $modul_pel)) || ($ruangan_login == $ruangan_create && !in_array($modul_login, $modul_pel))) ? 1 : 0;
                
                        $fa_disabled = !$bisa_hapus ? "fa-disabled" : "";
            ?>
            <td><?php echo $format->formatDateTimeForUser($Fisik->tglperiksafisik); ?></td>
            <?php $ruangan = RuanganM::model()->findByPk($Fisik->create_ruangan) ?>
            <td><?php echo  $ruangan->ruangan_nama; ?></td>
            <?php $pegawai = PegawaiM::model()->findByPk($Fisik->pegawai_id) ?>
            <td><?php echo $pegawai->namaLengkap; ?></td>
            <td><?php echo !empty($Fisik->ppds) ? $Fisik->ppds->ppds_nama : '-'; ?></td>
            <td><?php echo $Fisik->paramedis_nama; ?></td>
            <td><?php echo CHtml::link("<i class='icon-form-lihat'></i>", '#', array('onclick' => 'viewDetailFisik2("' . $Fisik->pemeriksaanfisik_id . '","' . $_GET["notriage_pasien_id"] . '");return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat detail pemeriksaan fisik')); ?>
          </td>
            <td><?php echo CHtml::link("<i class='icon-form-ubah $fa_disabled'></i>", $this->createUrl('indexDarurat', ['notriage_pasien_id' => $Fisik->notriage_pasien_id, 'id' => $Fisik->pemeriksaanfisik_id, 'jnstransaksi' => 'ubah']), array('rel' => 'tooltip', 'title' => 'Klik untuk salin data pemeriksaan fisik')); ?>
            </td>
            <?php if ($this->module->id == 'rehabMedis'): ?>
            <td><?php echo CHtml::link("<i class='icon-form-copy'></i>", $this->createUrl('indexDarurat', ['id' => $Fisik->pemeriksaanfisik_id, 'jnstransaksi' => 'salin']), array('rel' => 'tooltip', 'title' => 'Klik untuk mengubah data pemeriksaan fisik')); ?>
            </td>
            <?php endif; ?>
            <td>
                <?php
                $tglperiksafisik = (isset($_GET['tglperiksafisik']) ? $_GET['tglperiksafisik'] : null);
                if ($tglperiksafisik !== $Fisik->tglperiksafisik) {
                    ?>
                <a onclick="hapuspemeriksaan('<?php echo $Fisik->pemeriksaanfisik_id; ?>', this, <?=$bisa_hapus?>);return false;"
                    rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Pemeriksaan Fisik"><i
                        class="icon-form-sampah <?= $fa_disabled?>"></i></a>
                <?php }
                    ?>
            </td>
        </tr>
        <?php } ?>
        <?php else:?>
            <!-- <tr><td colspan="<?php // echo $this->module->id == 'rehabMedis' ? 8 : 7?>">Data tidak ditemukan</td></tr> -->
        <?php endif; ?>
    </tbody>
</table>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailFisik2',
    'options' => array(
        'title' => 'Detail Pemeriksaan Fisik',
        'modal' => true,
        'autoOpen'=>false,
        'movable'=>true,
        'width' => 750,
        'height' => 600,
        'resizable' => true,
    ),
));

echo '<div style="align:center;margin-top:150px;" id="contentDetailFisik2"></div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script type="text/javascript">
function hapuspemeriksaan(pemeriksaanfisik_id, obj, is_bisa) {
    tabel = obj;
    if(is_bisa) {
    myConfirm('Apakah Anda akan menghapus Pemeriksaan Fisik ini?', 'Perhatian!', function(r) {
        if (r) {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('hapusRiwayatPemeriksaan'); ?>',
                data: {
                    pemeriksaanfisik_id: pemeriksaanfisik_id
                },
                dataType: "json",
                success: function(data) {
                    if (data.sukses) {
                        var delete_row = $(tabel).parents('tr');
                        delete_row.detach();
                    }
                    myAlert(data.pesan);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    });
} else {
        myAlert('Anda tidak memiliki akses');
    }
}

function viewDetailFisik2(idFisik, notriage_pasien_id) {

    $.post('<?php echo $this->createUrl('ajaxDetailFisik2') ?>', {
        idFisik: idFisik,
        notriage_pasien_id : notriage_pasien_id
    }, function(data) {
        $('#contentDetailFisik2').html(data.result);
        $('#contentDetailFisik2').trigger("load_detail_periksagambar");
    }, 'json');
    $('#dialogDetailFisik2').dialog('open');
}



function lihatRiwayat(obj) {

    var riwayat = $(obj).val();
    $('.isi-riwayat').addClass('hide');

    $('#' + riwayat).removeClass('hide');

    console.log(riwayat);

}

$(document).ready(function() {

    $('#riwayat-berdasarkan').val('pendaftaran').change();
});
</script>

