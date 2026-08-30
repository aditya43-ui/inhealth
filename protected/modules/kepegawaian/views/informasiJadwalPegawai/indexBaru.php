<?php $linkHalaman = CustomFunction::getUrlByMenuID(3338); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.mtz.monthpicker.js'); ?>
<style>
    .sorot {
        background-color: yellow;
    }
</style>
<div class="panel panel-gradient">
    <?php
    $this->breadcrumbs = array(
        'Informasi Jadwal Pegawai',
    );
    Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('informasijadwalpegawai-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
    ?>
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Jadwal Pegawai</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array(
                    'dropRuang' => $dropRuang, 'dis' => $dis, 'model' => $model, 'format' => new MyFormatter()
                )); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Jadwal Pegawai</b>
                </div>
            </div>
            <div class="panel-body table-responsive" id="tabel-jadwalpegawai">
            </div>
        </div>
    </div>
</div>
<?php
// Dialog untuk tindak lanjut pasien ke RI=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogUbahJadwal',
    'options' => array(
        'title' => 'Transaksi <b>Ubah Jadwal Pegawai</b>',
        'autoOpen' => false,
        'modal' => true,
        'zIndex' => 1002,
        'width' => 900,
        'height' => 500,
        'resizable' => true,
        'close' => "js:function(){generateJadwal();}",
    ),
));
?>
<iframe name='frameUbahJadwal' style="width: 100%; height: 98%;"></iframe>
<?php $this->endWidget();
$urlPrint = $this->createUrl('printJadwalPegawai');
?>
<script>
    function batalJadwal(obj, id) {
        $(obj).parents("li").addClass('sorot');
        myConfirm("Anda yakin untuk membatalkan Jadwal ini?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('batalJadwal'); ?>', {
                    id: id
                }, function(data) {
                    if (data.ok == 1) {
                        myAlert(data.msg);
                        generateJadwal();
                    } else {
                        myAlert(data.msg);
                        $(obj).parents("li").removeClass('sorot');
                    }
                }, 'json');
            } else {
                $(obj).parents("li").removeClass('sorot');
            }
        });
    }

    function generateJadwal(tanggal) {
        $("#tabel-jadwalpegawai").addClass("animation-loading");
        if (typeof tanggal === "undefined") {
            var tgl = $("#KPInformasijadwalpegawaiV_tgl_awal").val();
        } else {
            var tgl = '<?php echo date('Y-m-d') ?>';
        }
        var kelompokpegawai_id = $("#<?php echo CHtml::activeId($model, 'kelompokpegawai_id') ?>").val();
        var shift_id = $("#<?php echo CHtml::activeId($model, 'shift_id') ?>").val();
        var nama_pegawai = $("#<?php echo CHtml::activeId($model, 'nama_pegawai') ?>").val();
        var instalasi_id = $("#<?php echo CHtml::activeId($model, 'instalasi_id') ?>").val();
        var ruangan_id = $("#<?php echo CHtml::activeId($model, 'ruangan_id') ?>").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('CreateGrid'); ?>',
            data: {
                instalasi_id: instalasi_id,
                ruangan_id: ruangan_id,
                tgl: tgl,
                kelompokpegawai_id: kelompokpegawai_id,
                shift_id: shift_id,
                nama_pegawai: nama_pegawai
            },
            dataType: "json",
            success: function(data) {
                if (data.sukses == 1) {
                    $("#tabel-jadwalpegawai").html(data.tr);
                    $("#tabel-jadwalpegawai").removeClass("animation-loading");
                } else {
                    myAlert(data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function print(caraPrint) {
        if (typeof tanggal === "undefined") {
            var tgl = $("#KPInformasijadwalpegawaiV_tgl_awal").val();
        } else {
            var tgl = '<?php echo date('Y-m-d') ?>';
        }
        var kelompokpegawai_id = $("#<?php echo CHtml::activeId($model, 'kelompokpegawai_id') ?>").val();
        var shift_id = $("#<?php echo CHtml::activeId($model, 'shift_id') ?>").val();
        var nama_pegawai = $("#<?php echo CHtml::activeId($model, 'nama_pegawai') ?>").val();
        var instalasi_id = $("#<?php echo CHtml::activeId($model, 'instalasi_id') ?>").val();
        var ruangan_id = $("#<?php echo CHtml::activeId($model, 'ruangan_id') ?>").val();
        if (caraPrint == null) {
            caraPrint = "EXCEL";
        }
        window.open("<?php echo $urlPrint ?>" +
            "&tgljadwal=" + tgl +
            "&kelompokpegawai_id=" + kelompokpegawai_id +
            "&shift_id=" + shift_id +
            "&nama_pegawai=" + nama_pegawai +
            "&instalasi_id=" + instalasi_id +
            "&ruangan_id=" + ruangan_id +
            "&caraPrint=" + caraPrint,
            "", 'location=_new, width=900px');
    }
    $(document).ready(function() {
        $('#KPInformasijadwalpegawaiV_tgl_awal').monthpicker({
            pattern: 'mmmm yyyy'
        });
        generateJadwal('<?php echo MyFormatter::formatMonthForUser(date('m Y')); ?>');
    });
</script>