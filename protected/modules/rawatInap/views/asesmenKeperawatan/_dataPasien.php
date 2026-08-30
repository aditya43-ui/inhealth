<?php
$this->widget('bootstrap.widgets.BootAlert');
$modPendaftaran->tgl_pendaftaran = MyFormatter::formatDateTImeForUser($modPendaftaran->tgl_pendaftaran);
$modPasien->nama_pasien = $modPasien->namadepan . $modPasien->nama_pasien;
?>


<div class="panel panel-primary panel-success" >
    <div class="panel-heading">
        <div class="panel-title">Data Pasien</div>
    </div>
    <div class="panel-body">
        <table width="100%" class="table-condensed">
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'tgl_pendaftaran', array('class' => 'control-label')); ?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'pendaftaran_id', array('class' => 'control-label')); ?>
                </td>
                <td><?php echo CHtml::activeTextField($modPendaftaran, 'tgl_pendaftaran', array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPasien, 'no_rekam_medik', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly' => true)); ?></td>
                <td rowspan="4">
                    <?php
                    if (!empty($modPasien->photopasien)) {
                        echo CHtml::image(Params::urlPhotoPasienDirectory() . $modPasien->photopasien, 'photo pasien', array('width' => 120));
                    } else {
                        echo CHtml::image(Params::urlPhotoPasienDirectory() . 'no_photo.jpeg', 'photo pasien', array('width' => 120));
                    }
                    ?> 
                </td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran, 'no_pendaftaran', array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPasien, 'nama_pasien', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'umur', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran, 'umur', array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPasien, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran, 'jeniskasuspenyakit_id', array('class' => 'control-label')); ?></td>
                <td>
                    <?php echo CHtml::activeTextField($modPendaftaran->jeniskasuspenyakit, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'kelaspelayanan_id', array('readonly' => true)); ?>
                    <?php echo CHtml::activeHiddenField($modPendaftaran, 'carabayar_id', array('readonly' => true)); ?>
                </td>

                <td><?php echo CHtml::activeLabel($modPendaftaran->carabayar, 'cara bayar', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran->carabayar, 'carabayar_nama', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPendaftaran->dokter, 'dokter_pemeriksa', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran->dokter, 'namaLengkap', array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPendaftaran->penjamin, 'penjamin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPendaftaran->penjamin, 'penjamin_nama', array('readonly' => true)); ?></td>
            </tr>

        </table>

    </div><br>
</div>
<fieldset>
<?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
	'id'=>'form-riwayat',
	'content'=>array(
		'content-detailpasien'=>array(
			'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'',
                            'onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat pasien')).
                    '<b> Riwayat Pasien</b>',
			'isi'=>'<iframe src="" id="riwayatPasien" width="100%" height="200%"></iframe>',
			'active'=>false,
			),   
		),
)); ?>
</fieldset><br>


<?php
$gets = "";
//if (isset($_GET)) {
//    foreach ($_GET AS $name => $get) {
//        if ($name != "r")
//            $gets .= "&" . $name . "=" . $get;
//    }
//}
?>
<?php $baseUrl = Yii::app()->createUrl("/"); ?>
<?php $riwayatPasien = Yii::app()->createUrl('rawatJalan/daftarPasien/getRiwayatPasien&id=' . $modPasien->pasien_id); ?>
<script type='text/javascript'>
    function setTab(obj) {
        $(obj).parents("ul").find("li").each(function () {
            $(this).removeClass("active");
            $(this).attr("onclick", "setTab(this);");
        });
        $(obj).addClass("active");
        $(obj).removeAttr("onclick", "setTab(this);");
        var tab = $(obj).attr("tab");
        var frameObj = document.getElementById("frame");
        resetIframe(frameObj);
        $(frameObj).attr("src", "<?php echo $baseUrl; ?>?r=" + tab + "<?php echo $gets; ?>");
        $(frameObj).parent().addClass("animation-loading");
        $(frameObj).load(function () {
            $(frameObj).parent().removeClass("animation-loading");
            resizeIframe(frameObj);
        });
        return false;
    }
    function setRiwayatPasien() {
        var frameObj = document.getElementById("riwayatPasien");
        $(frameObj).attr("src", "<?php echo $riwayatPasien; ?>");
        $(frameObj).parent().addClass("animation-loading");
        $(frameObj).load(function () {
            $(frameObj).parent().removeClass("animation-loading");
            $("#divRiwayatPasien").slideToggle(500);
        });
        return false;
    }
    function resetIframe(obj) {
        obj.style.height = 128 + 'px';
    }
    function resizeIframe(obj) {
        obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
    }
    $("#cekRiwayatPasien").change(function () {
        $('#divRiwayatPasien').slideToggle(500);
    });
</script>
<?php
Yii::app()->clientScript->registerScript('onLoadJs', '
    setRiwayatPasien();
', CClientScript::POS_READY);
?>



