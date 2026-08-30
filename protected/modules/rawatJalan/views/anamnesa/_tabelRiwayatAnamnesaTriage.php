<style>
.fa-disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>
<?php
    $modul_login = Yii::app()->user->getState('modul_id');
    $modul_hide = [6, 7, 72];

    $hide = in_array($modul_login, $modul_hide) ? "hidden" : "";
?>
<div class="control-group hide" style="margin-top: 0px; margin-bottom: 20px;">
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
            <th>PPDS</th>
            <th>Paramedis</th>
            <th>Lihat Detail</th>
            <th <?=$hide?>>Edit</th>
            <th>Salin</th>
            <th>Hapus</th>
        </tr>
    </thead>
    <tbody id="pendaftaran" class="isi-riwayat">
    <?php if(!empty($tabelAnamnesa)){?>

        <?php foreach ($tabelAnamnesa as $i => $Anamnesa) { ?>
        <tr>
            <?php
        
        $ruangan_login = Yii::app()->user->getState('ruangan_id');
        $ruangan_create = $Anamnesa->create_ruangan;

        $fa_disabled = $ruangan_login != $ruangan_create ? "fa-disabled" : "";

        $pegawai_login = Yii::app()->user->getState('loginpemakai_id');

        $ruangan_create = $Anamnesa->create_ruangan;
        $pegawai_create = $Anamnesa->create_loginpemakai_id;

        $modul_pel = [6, 7, 72];

        $bisa_hapus = ((($ruangan_login == $ruangan_create) && ($pegawai_login == $pegawai_create) && in_array($modul_login, $modul_pel)) || ($ruangan_login == $ruangan_create && !in_array($modul_login, $modul_pel))) ? 1 : 0;

        $fa_disabled = !$bisa_hapus ? "fa-disabled" : "";

        

        ?>
            <td><?php echo $format->formatDateTimeForUser($Anamnesa->tglanamnesis); ?></td>
            <?php $ruangan = RuanganM::model()->findByPk($Anamnesa->create_ruangan) ?>
            <td><?php echo  $ruangan->ruangan_nama; ?></td>
            <?php $pegawai = PegawaiM::model()->findByPk($Anamnesa->pegawai_id) ?>
            <td><?php echo  $pegawai->namaLengkap; ?></td>
            <td><?php echo $Anamnesa->ppds->ppds_nama ?? "" ; ?></td>
            <td><?php echo $Anamnesa->paramedis_nama; ?></td>
            <td><?php echo CHtml::link("<i class='icon-form-lihat'></i>", '#', array('onclick'=>'viewDetailAnamnesaTriage("'.$Anamnesa->anamesa_id.'","'.$_GET["notriage_pasien_id"].'");return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail anamnesa')); ?>
            </td>
            <td <?=$hide?>><?php echo CHtml::link("<i class='icon-form-ubah $fa_disabled'></i>", Yii::app()->controller->createUrl("index", array("notriage_pasien_id" => $_GET["notriage_pasien_id"], "id" => $Anamnesa->anamesa_id, "tipe" => "ubah")), array('return false;','rel'=>'tooltip','title'=>'Klik untuk ubah anamnesa')); ?>
            </td>
            <td><?php echo CHtml::link("<i class='icon-form-input'></i>", Yii::app()->controller->createUrl("index", array("notriage_pasien_id" => $_GET["notriage_pasien_id"], "id" => $Anamnesa->anamesa_id, "tipe" => "salin")), array('return false;','rel'=>'tooltip','title'=>'Klik untuk menyalin anamnesa')); ?>
            </td>
            <td>
                <?php 
            $tglAnamnesis = (isset($_GET['tglanamnesis'])?$_GET['tglanamnesis']:null);
            if ($tglAnamnesis !== $Anamnesa->tglanamnesis){ ?>
                <a onclick="hapusAnamnesis('<?php echo $Anamnesa->anamesa_id; ?>',this, <?=$bisa_hapus?>);return false;" rel="tooltip"
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
        <tr>
            <?php
        
        $ruangan_login = Yii::app()->user->getState('ruangan_id');
        $ruangan_create = $Anamnesa->create_ruangan;

        $fa_disabled = $ruangan_login != $ruangan_create ? "fa-disabled" : "";

        ?>
            <td><?php echo $format->formatDateTimeForUser($Anamnesa->tglanamnesis); ?></td>
            <?php $ruangan = RuanganM::model()->findByPk($Anamnesa->create_ruangan) ?>
            <td><?php echo  $ruangan->ruangan_nama; ?></td>
            <?php $pegawai = PegawaiM::model()->findByPk($Anamnesa->pegawai_id) ?>
            <td><?php echo  $pegawai->namaLengkap; ?></td>
            <td><?php echo $Anamnesa->paramedis_nama; ?></td>
            <td><?php echo CHtml::link("<i class='icon-form-lihat'></i>", '#', array('onclick'=>'viewDetailAnamnesa("'.$Anamnesa->anamesa_id.'","'.$_GET["notriage_pasien_id"].'");return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail anamnesa')); ?>
            </td>
            <td><?php// echo CHtml::link("<i class='icon-form-ubah $fa_disabled'></i>", Yii::app()->controller->createUrl("index", array('is_triage' => 1, "notriage_pasien_id" => $_GET["notriage_pasien_id"], "id" => $Anamnesa->anamesa_id, "tipe" => "ubah")), array('return false;','rel'=>'tooltip','title'=>'Klik untuk ubah anamnesa')); ?>
            </td>
            <td><?php echo CHtml::link("<i class='icon-form-input'></i>", Yii::app()->controller->createUrl("index", array('is_triage' => 1, "notriage_pasien_id" => $_GET["notriage_pasien_id"], "id" => $Anamnesa->anamesa_id, "tipe" => "salin")), array('return false;','rel'=>'tooltip','title'=>'Klik untuk menyalin anamnesa')); ?>
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
    tabel = obj;

    if(is_bisa == 1) {

    myConfirm('Apakah Anda akan menghapus Anamnesa ini?', 'Perhatian!', function(r) {
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

function viewDetailAnamnesaTriage(idAnamnesis, notriage_pasien_id) {

    $.post('<?php echo $this->createUrl('ajaxDetailAnamnesaTriage') ?>', {
        idAnamnesis: idAnamnesis,
        notriage_pasien_id: notriage_pasien_id
    }, function(data) {
        $('#contentDetailAnamnesa').html(data.result);
    }, 'json');
    $('#dialogDetailAnamnesa').dialog('open');
    $('.redactor-left').addClass('hide');
}

function salinAnamnesaTriage(idAnamnesis, notriage_pasien_id) {
    $.post('<?php echo $this->createUrl('index') ?>', {
        is_triage: 1,
        notriage_pasien_id: notriage_pasien_id,
        idAnamnesis: idAnamnesis,
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
        'top' => 500,
        // 'position'=>'center',
        'close' => 'js:function(){setRedactor();}',
    ),
));

    echo '<div id="contentDetailAnamnesa" style="margin-left: 80px;">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>