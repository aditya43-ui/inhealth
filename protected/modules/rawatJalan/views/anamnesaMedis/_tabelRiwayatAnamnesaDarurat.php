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
            <th>PPDS</th>
            <th>Perawat</th>
            <th>Lihat Detail</th>
            <th hidden>Edit</th>
            <th hidden>Salin</th>
            <th>Hapus</th>
        </tr>
    </thead>
    <tbody id="pendaftaran" class="isi-riwayat">
    <?php
    
    if(!empty($tabelAnamnesaRD)){?>
        

        <?php foreach ($tabelAnamnesaRD as $i => $Anamnesa) { ?>
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
            <td><?php echo $Anamnesa->ppds->ppds_nama ?? "" ; ?></td>
            <td><?php echo $Anamnesa->paramedis_nama; ?></td>
            <td ><?php echo CHtml::link("<i class='icon-form-lihat'></i>", '#', array('onclick'=>'viewDetailAnamnesa("'.$Anamnesa->anamesa_id.'","'.$Anamnesa->notriage_pasien_id.'");return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail anamnesa')); ?>
            </td>
            <td hidden><?php echo CHtml::link("<i class='icon-form-ubah $fa_disabled'></i>", Yii::app()->controller->createUrl("index", array('id' => $Anamnesa->anamesa_id,"is_triage"=>true, "notriage_pasien_id" => $Anamnesa->notriage_pasien_id, "tipe" => "ubah")), array('return false;','rel'=>'tooltip','title'=>'Klik untuk ubah anamnesa')); ?>
            </td>
            <td hidden><?php echo CHtml::link("<i class='icon-form-input'></i>", Yii::app()->controller->createUrl("index", array("is_triage"=>true, "notriage_pasien_id" => $Anamnesa->notriage_pasien_id, "tipe" => "salin")), array('return false;','rel'=>'tooltip','title'=>'Klik untuk menyalin anamnesa')); ?>
            </td>
            <td >
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
            echo "<tr><td colspan='9'>Data tidak ditemukan</td></tr>";
        } ?>
    </tbody>
    <tbody id="kunjungan" class="isi-riwayat">
    <?php if(empty($tabelAnamnesaPasienRD)){?>

        <?php foreach ($tabelAnamnesaPasienRD as $i => $Anamnesa) { ?>
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
            <td><?php echo  $pegawai->nama_pegawai; ?></td>
            <td><?php echo $Anamnesa->paramedis_nama; ?></td>
            <td><?php echo CHtml::link("<i class='icon-form-lihat'></i>", '#', array('onclick'=>'viewDetailAnamnesa("'.$Anamnesa->anamesa_id.'","'.$_GET["pendaftaran_id"].'");return false;','rel'=>'tooltip','title'=>'Klik untuk melihat detail anamnesa')); ?>
            </td>
            <td hidden><?php echo CHtml::link("<i class='icon-form-ubah $fa_disabled'></i>", Yii::app()->controller->createUrl("index", array("pendaftaran_id" => $_GET["pendaftaran_id"], "id" => $Anamnesa->anamesa_id, "tipe" => "ubah")), array('return false;','rel'=>'tooltip','title'=>'Klik untuk ubah anamnesa')); ?>
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

function viewDetailAnamnesa(idAnamnesis, notriage_pasien_id) {

    $.post('<?php echo $this->createUrl('ajaxDetailAnamnesa2') ?>', {
        idAnamnesis: idAnamnesis,
        notriage_pasien_id: notriage_pasien_id
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
        'close' => 'js:function(){setRedactor();}'
    ),
));

    echo '<div id="contentDetailAnamnesa">dialog content here</div>';

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>