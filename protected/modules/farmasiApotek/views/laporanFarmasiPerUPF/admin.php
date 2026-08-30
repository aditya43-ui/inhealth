<?php
$this->breadcrumbs = array(
    'Laporan Kunjungan Pasien'
);
?>
<style>
    #ui-datepicker-div {
        top: 92px !important;
    }
</style>

<div class="search-form">
    <?php
    $url = Yii::app()->createUrl('rawatJalan/laporan/frameGrafikKunjungan&id=1');
    Yii::app()->clientScript->registerScript('search', "
		$('.search-button').click(function(){
			$('.search-form').toggle();
			return false;
		});
		$('.search-form form').submit(function(){
			$('#Grafik').attr('src','').css('height','0px');
			$.fn.yiiGridView.update('tableLaporan', {
					data: $(this).serialize()
			});
			return false;
		});
    ");
    ?>

    <div class="panel panel-gradient">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-newspaper"></i> Laporan <b> Transaksi Seluruh UPF</b>
            </div>
        </div>
        <div class="panel-body">
            <div class="panel panel-success" style="margin: 0 !important;">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-search"></i> Pencarian
                    </div>
                </div>
                <div class="panel-body">
                    <?php
                    $this->renderPartial($this->path_view . '_search', array(
                        'model' => $model,
                    ));
                    ?>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-credit-card"></i> Tabel <b>Laporan Petugas Farmasi</b>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <?php $this->renderPartial($this->path_view . '_table', array('model' => $model)); ?>
                </div>
            </div>

            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporan');
            // $this->renderPartial($this->path_view . '_footer', array('urlPrint' => $urlPrint, 'url' => $url));
            ?>
        </div>
    </div>
</div>
<script>
    function cekPeriode(obj, tanggalakhir) {

        var tanggalawal = $('.tanggal').val()

        tanggalawal = ubahFormatTanggal(tanggalawal);

        tanggalakhir = ubahFormatTanggal(tanggalakhir);

        if(tanggalakhir < tanggalawal) {
            myAlert('Rentang periode tidak sesuai');
            $('#tanggal_akhir').val("<?= MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')) ?>");
            return false;
        }

    }

    function ubahFormatTanggal(tanggalInput) {

        var tanggalArray = tanggalInput.split(' '); // Memisahkan tanggal dan waktu
        var tanggal = tanggalArray[0];
        var bulan = tanggalArray[1];
        var tahun = tanggalArray[2];
        var waktu = tanggalArray[3];
        // Objek bulan singkat ke angka bulan
        var bulanSingkat = {
            "Jan": "01",
            "Feb": "02",
            "Mar": "03",
            "Apr": "04",
            "Mei": "05",
            "Jun": "06",
            "Jul": "07",
            "Agu": "08",
            "Sep": "09",
            "Okt": "10",
            "Nov": "11",
            "Des": "12"
        };

        var tanggalBaru = tahun + '-' + bulanSingkat[bulan] + '-' + tanggal + ' ' + waktu;

        return tanggalBaru;
    }
</script>