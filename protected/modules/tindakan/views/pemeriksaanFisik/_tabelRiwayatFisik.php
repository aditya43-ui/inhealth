<style>
.fa-disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>
<div class="control-group" style="margin-top: 0px; margin-bottom: 25px; margin-left:10px;">
    <div class="controls">
        <table>
            <tr>
                <td> <?php echo CHtml::label('Filter Berdasarkan', '', array('class' => 'control-label')) ?>&emsp;&emsp;&emsp;
                </td>
                <td><?php echo CHtml::dropDownList("riwayat-berdasarkan", '', array('pendaftaran' => 'Pendaftaran Pasien', 'kunjungan' => 'Kunjungan Pasien'), array('onchange' => 'lihatRiwayat(this);')); ?>
                </td>
            </tr>
        </table>
    </div>
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
            <th>Ubah</th>
            <?php if ($this->module->id == 'rehabMedis'): ?>
            <th>Salin</th>
            <?php endif; ?>
            <th>Hapus</th>
        </tr>
    </thead>
    <tbody id="pendaftaran" class="isi-riwayat">

    <?php // echo '<pre>'; var_dump(count($tabelPemeriksaan), count($tabelPemeriksaanPasien)); die;?>
        <?php if(!empty($tabelPemeriksaan)):?>
        <?php foreach ($tabelPemeriksaan as $i => $Fisik) { ?>
        <tr>
            <?php 
                $ruangan_login = Yii::app()->user->getState('ruangan_id');
                $ruangan_create = $Fisik->create_ruangan;
            
                $fa_disabled = $ruangan_login != $ruangan_create ? "fa-disabled" : "";
            ?>
            <td><?php echo $format->formatDateTimeForUser($Fisik->tglperiksafisik); ?></td>
            <?php $ruangan = RuanganM::model()->findByPk($Fisik->create_ruangan) ?>
            <td><?php echo  $ruangan->ruangan_nama; ?></td>
            <?php $pegawai = PegawaiM::model()->findByPk($Fisik->pegawai_id) ?>
            <td><?php echo $pegawai->nama_pegawai; ?></td>
            <td><?php echo $Fisik->ppds->ppds_nama ?? "" ; ?></td>
            <td><?php echo $Fisik->paramedis_nama; ?></td>
            <td><?php echo CHtml::link("<i class='icon-form-lihat'></i>", '#', array('onclick' => 'viewDetailFisik("' . $Fisik->pemeriksaanfisik_id . '","' . $_GET["pendaftaran_id"] . '");return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat detail pemeriksaan fisik')); ?>
            </td>
            <td><?php echo CHtml::link("<i class='icon-form-ubah $fa_disabled'></i>", $this->createUrl('index', ['pendaftaran_id' => $Fisik->pendaftaran_id, 'id' => $Fisik->pemeriksaanfisik_id, 'jnstransaksi' => 'ubah']), array('rel' => 'tooltip', 'title' => 'Klik untuk salin data pemeriksaan fisik')); ?>
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
                <a onclick="hapuspemeriksaan('<?php echo $Fisik->pemeriksaanfisik_id; ?>', this);return false;"
                    rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Pemeriksaan Fisik"><i
                        class="icon-form-sampah <?= $fa_disabled?>"></i></a>
                <?php }
                    ?>
            </td>
        </tr>
        <?php } ?>
        <?php else:?>
            <tr><td colspan="<?php echo $this->module->id == 'rehabMedis' ? 8 : 7?>">Data tidak ditemukan</td></tr>
        <?php endif;?>
    </tbody>
    <tbody id="kunjungan" class="isi-riwayat">
    <?php if(!empty($tabelPemeriksaanPasien)):?>
        <?php foreach ($tabelPemeriksaanPasien as $i => $Fisik) { ?>
        <tr>
            <?php 
                $ruangan_login = Yii::app()->user->getState('ruangan_id');
                $ruangan_create = $Fisik->create_ruangan;
            
                $fa_disabled = $ruangan_login != $ruangan_create ? "fa-disabled" : "";
            ?>
            <td><?php echo $format->formatDateTimeForUser($Fisik->tglperiksafisik); ?></td>
            <?php $ruangan = RuanganM::model()->findByPk($Fisik->create_ruangan) ?>
            <td><?php echo  $ruangan->ruangan_nama; ?></td>
            <?php $pegawai = PegawaiM::model()->findByPk($Fisik->pegawai_id) ?>
            <td><?php echo $pegawai->nama_pegawai; ?></td>
            <td><?php echo $Fisik->paramedis_nama; ?></td>
            <td><?php echo CHtml::link("<i class='icon-form-lihat'></i>", '#', array('onclick' => 'viewDetailFisik("' . $Fisik->pemeriksaanfisik_id . '","' . $_GET["pendaftaran_id"] . '");return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk melihat detail pemeriksaan fisik')); ?>
            </td>
            <td><?php echo CHtml::link("<i class='icon-form-ubah $fa_disabled'></i>", $this->createUrl('index', ['pendaftaran_id' => $Fisik->pendaftaran_id, 'id' => $Fisik->pemeriksaanfisik_id, 'jnstransaksi' => 'ubah']), array('rel' => 'tooltip', 'title' => 'Klik untuk salin data pemeriksaan fisik')); ?>
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
                <a onclick="hapuspemeriksaan('<?php echo $Fisik->pemeriksaanfisik_id; ?>', this);return false;"
                    rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Pemeriksaan Fisik"><i
                        class="icon-form-sampah <?= $fa_disabled?>"></i></a>
                <?php }
                    ?>
            </td>
        </tr>
        <?php } ?>
        <?php else:?>
            <tr><td colspan="<?php echo $this->module->id == 'rehabMedis' ? 8 : 7?>">Data tidak ditemukan</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<script type="text/javascript">
function hapuspemeriksaan(pemeriksaanfisik_id, obj) {
    tabel = obj;
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