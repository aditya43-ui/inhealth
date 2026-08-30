<?php

$pg_login = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
$pg_loginpps = PpdsM::model()->findByPk(Yii::app()->user->getState('ppds_id'));

$modul_id = Yii::app()->user->getState('modul_id');
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
$hidden_edit = $readonly ? " hidden" : "";

    $modul_login = Yii::app()->user->getState('modul_id');
    $modul_hide = Params::MODUL_ID_HIDE;

    $hide_1 = in_array($modul_login, $modul_hide) ? "hidden" : "";

    if($hidden_edit == '') {
        $hidden_edit = $hide_1;
    }



?>

<style>
.fa-disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>

<div class="control-group hide" style="margin-top: 0px; margin-bottom: 25px;">
    <div class="controls">
        <table>
            <tr>
                <td> <?php echo CHtml::label('Filter Berdasarkan', 'no_tleponpj', array('class' => 'control-label')) ?></td>
                <td><?php echo CHtml::dropDownList("riwayat-berdasarkan", '', array('pendaftaran' => 'Pendaftaran Pasien', 'kunjungan' => 'Kunjungan Pasien'), array('onchange' => 'lihatRiwayat(this);')); ?></td>
            </tr>
        </table>
    </div>
</div>
<table class="items table table-striped table-condensed" id="tblInputAnamnesa">
    <thead>
        <tr>
            <th>Tanggal Anamnesis</th>
            <th>Ruangan</th>
            <th>Dokter</th>
            <!-- <th>PPDS</th> -->
            <!-- <th>Perawat</th> -->
            <th>Lihat Detail</th>
            <th <?= $hidden_edit ?>>Edit</th>
            <th <?= 'hidden' ?>>Salin</th>
            <th <?= $hidden ?>>Hapus</th>
        </tr>
    </thead>
    <tbody id="pendaftaran" class="isi-riwayat">
    <?php if(!empty($tabelAnamnesa)){?>

        <?php foreach ($tabelAnamnesa as $i => $Anamnesa) { ?>
        <tr class="data-row">
            <?php
                $bisa_hapus = CustomFunction::hakAksesHapus(Yii::app()->user->getState('loginpemakai_id'), $Anamnesa->create_ruangan, $Anamnesa->create_loginpemakai_id);

                $fa_disabled = !$bisa_hapus ? "fa-disabled" : "";
            ?>
            <td><?php echo $format->formatDateTimeForUser($Anamnesa->tglanamnesis); ?></td>
            <?php $ruangan = RuanganM::model()->findByPk($Anamnesa->create_ruangan) ?>
            <td><?php echo  $ruangan->ruangan_nama; ?></td>
            <?php $pegawai = PegawaiM::model()->findByPk($Anamnesa->pegawai_id) ?>
            <td><?php echo  $pegawai->namaLengkap; ?></td>
            <td hidden><?php echo $Anamnesa->ppds->ppds_nama ?? "" ; ?></td>
            <td hidden><?php echo $Anamnesa->paramedis_nama; ?></td>
            <td><?php echo CHtml::link("<i class='icon-form-lihat'></i>", '#', array('onclick'=>'viewDetailAnamnesa("'.$Anamnesa->anamesa_id.'","'.$_GET["pendaftaran_id"].'");return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail anamnesa')); ?>
            </td>
            <td <?= $hidden_edit ?>><?php echo CHtml::link("<i class='icon-form-ubah $fa_disabled'></i>", Yii::app()->controller->createUrl("index", array("pendaftaran_id" => $_GET["pendaftaran_id"], "id" => $Anamnesa->anamesa_id, "tipe" => "ubah")), array('return false;','rel'=>'tooltip','title'=>'Klik untuk ubah anamnesa')); ?>
            </td>
            <td <?= 'hidden' ?>><?php echo CHtml::link("<i class='icon-form-input'></i>", Yii::app()->controller->createUrl("index", array("pendaftaran_id" => $_GET["pendaftaran_id"], "id" => $Anamnesa->anamesa_id, "tipe" => "salin")), array('return false;','rel'=>'tooltip','title'=>'Klik untuk menyalin anamnesa')); ?>
            </td>
            <td <?= $hidden ?>>
                <?php 
            $tglAnamnesis = (isset($_GET['tglanamnesis'])?$_GET['tglanamnesis']:null);
            if ($tglAnamnesis !== $Anamnesa->tglanamnesis){ ?>
                <a onclick="hapusAnamnesis('<?php echo $Anamnesa->anamesa_id; ?>',this, <?= $bisa_hapus ?>);return false;" rel="tooltip"
                    href="javascript:void(0);" title="Klik untuk menghapus Anamnesa"><i
                        class="icon-form-sampah <?= $fa_disabled?>"></i></a>
                <?php }
            ?>
            </td>
        </tr>
        <?php } ?>
        <?php } else {
            echo "<tr><td colspan='9'>Data tidak ditemukan</td></tr>";
        } ?>
    </tbody>
    <tbody id="kunjungan" class="isi-riwayat">
    <?php if(!empty($tabelAnamnesaPasien)){?>

        <?php foreach ($tabelAnamnesaPasien as $i => $Anamnesa) { ?>
        <tr class="data-row">
        <?php
            $bisa_hapus = CustomFunction::hakAksesHapus(Yii::app()->user->getState('loginpemakai_id'), $Anamnesa->create_ruangan, $Anamnesa->create_loginpemakai_id);

            $fa_disabled = !$bisa_hapus ? "fa-disabled" : "";
        ?>
            <td><?php echo $format->formatDateTimeForUser($Anamnesa->tglanamnesis); ?></td>
            <?php $ruangan = RuanganM::model()->findByPk($Anamnesa->create_ruangan) ?>
            <td><?php echo  $ruangan->ruangan_nama; ?></td>
            <?php $pegawai = PegawaiM::model()->findByPk($Anamnesa->pegawai_id) ?>
            <td><?php echo  $pegawai->namaLengkap; ?></td>
            <td><?php echo $Anamnesa->paramedis_nama; ?></td>
            <td><?php echo CHtml::link("<i class='icon-form-lihat'></i>", '#', array('onclick'=>'viewDetailAnamnesa("'.$Anamnesa->anamesa_id.'","'.$_GET["pendaftaran_id"].'");return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail anamnesa')); ?>
            </td>
            <td><?php echo CHtml::link("<i class='icon-form-ubah $fa_disabled'></i>", Yii::app()->controller->createUrl("index", array("pendaftaran_id" => $_GET["pendaftaran_id"], "id" => $Anamnesa->anamesa_id, "tipe" => "ubah")), array('return false;','rel'=>'tooltip','title'=>'Klik untuk ubah anamnesa')); ?>
            </td>
            <td hidden><?php echo CHtml::link("<i class='icon-form-input'></i>", Yii::app()->controller->createUrl("index", array("pendaftaran_id" => $_GET["pendaftaran_id"], "id" => $Anamnesa->anamesa_id, "tipe" => "salin")), array('return false;','rel'=>'tooltip','title'=>'Klik untuk menyalin anamnesa')); ?>
            </td>
            <td>
                <?php 
            $tglAnamnesis = (isset($_GET['tglanamnesis'])?$_GET['tglanamnesis']:null);
            if ($tglAnamnesis !== $Anamnesa->tglanamnesis){ ?>
                <a onclick="hapusAnamnesis('<?php echo $Anamnesa->anamesa_id; ?>',this);return false;" rel="tooltip"
                    href="javascript:void(0);" title="Klik untuk menghapus Anamnesa"><i
                        class="icon-form-sampah <?= $fa_disabled?>"></i></a>
                <?php }
            ?>
            </td>
        </tr>
        <?php } ?>
        <?php } else {
            echo "<tr><td colspan='8'>Data tidak ditemukan</td></tr>";
        } ?>
    </tbody>

</table>
<script type="text/javascript">
function hapusAnamnesis(anamesa_id, obj, is_bisa) {

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

    if(is_bisa == 1) {    
    tabel = obj;
    window.parent.myConfirm('Apakah Anda akan menghapus Anamnesa ini?', 'Perhatian!', function(r) {
        if (r) {
            $.ajax({
                type: 'POST',
                url: '<?php echo $this->createUrl('hapusRiwayatAnamnesa'); ?>',
                data: {
                    anamesa_id: anamesa_id
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

function viewDetailAnamnesa(idAnamnesis, pendaftaran_id) {

    $.post('<?php echo $this->createUrl('ajaxDetailAnamnesa') ?>', {
        idAnamnesis: idAnamnesis,
        pendaftaran_id: pendaftaran_id
    }, function(data) {
        $('#contentDetailAnamnesa').html(data.result);
    }, 'json');
    $('#dialogDetailAnamnesa').dialog('open');
    $('.redactor-left').addClass('hide');
}

function salinAnamnesa(idAnamnesis, pendaftaran_id) {
    $.post('<?php echo $this->createUrl('index') ?>', {
        idAnamnesis: idAnamnesis,
        pendaftaran_id: pendaftaran_id
    }, function(data) {
        $('#contentDetailAnamnesa').html(data.result);
    }, 'json');
}

function lihatRiwayat(obj) {

    var riwayat = $(obj).val();
    $('.isi-riwayat').addClass('hide');

    $('#' + riwayat).removeClass('hide');

}

function setRedactor() {
    $('.redactor-left').removeClass('hide');
    // console.log('testestse');
}

$(document).ready(function() {

    $('#riwayat-berdasarkan').val('pendaftaran').change();
});
</script>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'dialogDetailAnamnesa',
    'options'=>array(
        'title'=>'Detail Anamnesa',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>800,
        'resizable'=>false,
        'position'=>'top',
        'close' => 'js:function(){setRedactor();}'
    ),
));

    echo '<div id="contentDetailAnamnesa">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>