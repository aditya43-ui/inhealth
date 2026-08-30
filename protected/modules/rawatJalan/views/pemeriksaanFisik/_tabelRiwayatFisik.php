<style>
.fa-disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>

<?php

$pg_login = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
$pg_loginpps = PpdsM::model()->findByPk(Yii::app()->user->getState('ppds_id'));
$modul_id = Yii::app()->user->getState('modul_id');
// echo '<pre>';
// var_dump($pg_login->kelompokpegawai_id);die;
if(!empty($pg_login->kelompokpegawai_id)){
    // var_dump('as');die;
    $readonly = $pg_login->kelompokpegawai_id == 2 && $modul_id != 7;
}
if (!empty($pg_loginpps->kelompokpegawai_id)){
    // var_dump('as2');die;
    $readonly = $pg_loginpps->kelompokpegawai_id == 1 && $modul_id != 7;

}

$hide = $readonly ? " hide" : "";
$hidden = $readonly ? " hidden" : "";

if($modul_id == Params::MODUL_ID_TINDAKAN) {
    $hidden = '';
}
$modul_login = Yii::app()->user->getState('modul_id');
$modul_hide = Params::MODUL_ID_HIDE;

$hide_edit = in_array($modul_login, $modul_hide) ? "hidden" : "";

$hidden_edit = $readonly ? " hidden" : "";

    $modul_login = Yii::app()->user->getState('modul_id');
    $modul_hide = Params::MODUL_ID_HIDE;

    $hide_1 = in_array($modul_login, $modul_hide) ? "hidden" : "";

    if($hidden_edit == '') {
        $hidden_edit = $hide_1;
    }


?>

<div class="control-group" style="margin-top: 0px; margin-bottom: 25px; margin-left:10px;">
    <!-- <div class="controls">
        <table>
            <tr>
                <td> <?php // echo CHtml::label('Filter Berdasarkan', '', array('class' => 'control-label')) ?>&emsp;&emsp;&emsp;
                </td>
                <td><?php // echo CHtml::dropDownList("riwayat-berdasarkan", '', array('pendaftaran' => 'Pendaftaran Pasien', 'kunjungan' => 'Kunjungan Pasien'), array('onchange' => 'lihatRiwayat(this);')); ?>
                </td>
            </tr>
        </table>
    </div> -->
</div>
<table class="items table table-striped table-condensed" id="tblInputTindakan">
    <thead>
        <tr>
            <th>Tanggal Periksa</th>
            <th>Ruangan</th>
            <th>Dokter</th>
            <th>PPDS</th>
            <th>Paramedis</th>
            <th>Lihat Detail</th>
            <th <?= $hidden_edit ?>>Ubah</th>
            <?php if ($this->module->id == 'rehabMedis' || $modul_id == Params::MODUL_ID_TINDAKAN): ?>
            <th <?= $hidden ?>>Salin</th>
            <?php endif; ?>
            <th <?= $hidden ?>>Hapus</th>
        </tr>
    </thead>
    <tbody id="pendaftaran" class="isi-riwayat">

    <?php // echo '<pre>'; var_dump(count($tabelPemeriksaan), count($tabelPemeriksaanPasien)); die;?>
        <?php if(!empty($tabelPemeriksaan)):?>
        <?php foreach ($tabelPemeriksaan as $i => $Fisik) { ?>
        <tr class="data-row">
            <?php 
                $bisa_hapus = CustomFunction::hakAksesHapus(Yii::app()->user->getState('loginpemakai_id'), $Fisik->create_ruangan, $Fisik->create_loginpemakai_id);
                
                $fa_disabled = !$bisa_hapus ? "fa-disabled" : "";
            ?>
            <td><?php echo $format->formatDateTimeForUser($Fisik->tglperiksafisik); ?></td>
            <?php $ruangan = RuanganM::model()->findByPk($Fisik->create_ruangan) ?>
            <td><?php echo  $ruangan->ruangan_nama; ?></td>
            <?php $pegawai = PegawaiM::model()->findByPk($Fisik->pegawai_id) ?>
            <td><?php echo $pegawai->namaLengkap; ?></td>
            <td><?php echo $Fisik->ppds->ppds_nama ?? "" ; ?></td>
            <td><?php echo $Fisik->paramedis_nama; ?></td>
            <td><?php echo CHtml::link("<i class='icon-form-lihat'></i>", '#', array('onclick' => 'viewDetailFisik("' . $Fisik->pemeriksaanfisik_id . '","' . $_GET["pendaftaran_id"] . '");return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat detail pemeriksaan fisik')); ?>
            </td>
            <td <?= $hidden_edit ?>><?php echo CHtml::link("<i class='icon-form-ubah $fa_disabled'></i>", $this->createUrl('index', ['pendaftaran_id' => $Fisik->pendaftaran_id, 'id' => $Fisik->pemeriksaanfisik_id, 'jnstransaksi' => 'ubah']), array('rel' => 'tooltip', 'title' => 'Klik untuk salin data pemeriksaan fisik')); ?>
            </td>
            <?php if ($this->module->id == 'rehabMedis' || $modul_id == Params::MODUL_ID_TINDAKAN): ?>
            <td <?= $hidden ?>><?php echo CHtml::link("<i class='icon-form-copy'></i>", $this->createUrl('index', ['pendaftaran_id' => $Fisik->pendaftaran_id, 'id' => $Fisik->pemeriksaanfisik_id, 'jnstransaksi' => 'salin']), array('rel' => 'tooltip', 'title' => 'Klik untuk mengubah data pemeriksaan fisik')); ?>
            </td>
            <?php endif; ?>
            <td <?= $hidden ?>>
                <?php
                $tglperiksafisik = (isset($_GET['tglperiksafisik']) ? $_GET['tglperiksafisik'] : null);
                if ($tglperiksafisik !== $Fisik->tglperiksafisik) {
                    ?>
                <a onclick="hapuspemeriksaan('<?php echo $Fisik->pemeriksaanfisik_id; ?>', this, <?= $bisa_hapus ?>);return false;"
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
    <?php if(!empty($tabelPemeriksaanPasien)):?>
        <?php foreach ($tabelPemeriksaanPasien as $i => $Fisik) { ?>
        <tr class="data-row">
            <?php 
                $bisa_hapus = CustomFunction::hakAksesHapus(Yii::app()->user->getState('loginpemakai_id'), $Fisik->create_ruangan, $Fisik->create_loginpemakai_id);
        
                $fa_disabled = !$bisa_hapus ? "fa-disabled" : "";
            ?>
            <td><?php echo $format->formatDateTimeForUser($Fisik->tglperiksafisik); ?></td>
            <?php $ruangan = RuanganM::model()->findByPk($Fisik->create_ruangan) ?>
            <td><?php echo  $ruangan->ruangan_nama; ?></td>
            <?php $pegawai = PegawaiM::model()->findByPk($Fisik->pegawai_id) ?>
            <td><?php echo $pegawai->namaLengkap; ?></td>
            <td><?php echo $Fisik->paramedis_nama; ?></td>
            <td><?php echo CHtml::link("<i class='icon-form-lihat'></i>", '#', array('onclick' => 'viewDetailFisik("' . $Fisik->pemeriksaanfisik_id . '","' . $_GET["pendaftaran_id"] . '");return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat detail pemeriksaan fisik')); ?>
            </td>
            <td <?= $hidden_edit ?>><?php echo CHtml::link("<i class='icon-form-ubah $fa_disabled'></i>", $this->createUrl('index', ['pendaftaran_id' => $Fisik->pendaftaran_id, 'id' => $Fisik->pemeriksaanfisik_id, 'jnstransaksi' => 'ubah']), array('rel' => 'tooltip', 'title' => 'Klik untuk salin data pemeriksaan fisik')); ?>
            </td>
            <?php if ($this->module->id == 'rehabMedis'): ?>
            <td <?= $hidden ?>><?php echo CHtml::link("<i class='icon-form-copy'></i>", $this->createUrl('index', ['pendaftaran_id' => $Fisik->pendaftaran_id, 'id' => $Fisik->pemeriksaanfisik_id, 'jnstransaksi' => 'salin']), array('rel' => 'tooltip', 'title' => 'Klik untuk mengubah data pemeriksaan fisik')); ?>
            </td>
            <?php endif; ?>
            <td <?= $hidden ?>>
                <?php
                $tglperiksafisik = (isset($_GET['tglperiksafisik']) ? $_GET['tglperiksafisik'] : null);
                if ($tglperiksafisik !== $Fisik->tglperiksafisik) {
                    ?>
                <a onclick="hapuspemeriksaan('<?php echo $Fisik->pemeriksaanfisik_id; ?>', this, <?=$bisa_hapus ?>);return false;"
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
<script type="text/javascript">
function hapuspemeriksaan(pemeriksaanfisik_id, obj, is_bisa) {
    tabel = obj;

    // untuk menentukan hanya data yang terbaru yang dapat dihapus
    // Temukan elemen <tr>  yang diklik
    var trElement = $(obj).closest("tr");
    // Dapatkan indeks elemen <tr> tersebut
    var trIndex = $(".data-row").index(trElement);
    // indeks <tr> yang diklik
    console.log("TR ke-" + trIndex + " di klik.");

    if(trIndex > 0) {
        window.parent.myAlert("Data tidak dapat dihapus karena sudah valid");
        return false;
    }

    if(is_bisa) {

    window.parent.myConfirm('Apakah Anda akan menghapus Pemeriksaan Fisik ini?', 'Perhatian!', function(r) {
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
                    window.parent.myAlert(data.pesan);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        }
    });
} else {
    window.parent.myAlert('Anda tidak memiliki akses');
    }
}

function viewDetailFisik(idFisik, pendaftaran_id) {

    $.post('<?php echo $this->createUrl('ajaxDetailFisik') ?>', {
        idFisik: idFisik,
        pendaftaran_id: pendaftaran_id
    }, function(data) {
        $('#contentDetailFisik').html(data.result);
        $('#contentDetailFisik').trigger("load_detail_periksagambar");
    }, 'json');
    $('#dialogDetailFisik').dialog('open');
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

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailFisik',
    'options' => array(
        'title' => 'Detail Pemeriksaan Fisik',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
        'position' => 'top',
    ),
));

echo '<div id="contentDetailFisik">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>