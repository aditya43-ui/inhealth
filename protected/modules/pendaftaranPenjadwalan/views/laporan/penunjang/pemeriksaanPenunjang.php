<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Kunjungan Penunjang</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Laporan Kunjungan Penunjang'
        );

        $url = Yii::app()->createUrl('rekamMedis/laporan/frameGrafikPemeriksaanPenunjang&id=1');
        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#Grafik').attr('src','').css('height','0px');
        $.fn.yiiGridView.update('PPInfoKunjungan-v', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
        ?>
        <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
        ?>
        <div class="search-form">
            <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan._searchPenunjang', array(
                'modPPInfoKunjunganV' => $model, 'format' => $format
            )); ?>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $this->widget('bootstrap.widgets.BootMenu', array(
            'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
            'stacked' => false, // whether this is a stacked menu
            'items' => array(
                array('label' => 'Global', 'url' => $this->createAbsoluteUrl($controller . '/laporanKunjunganPenunjang'),),
                array('label' => 'Umur', 'url' => $this->createAbsoluteUrl($controller . '/laporanKunjunganUmurPenunjang'),),
                array('label' => 'Jenis Kelamin', 'url' => $this->createAbsoluteUrl($controller . '/laporanKunjunganJkPenunjang'),),
                array('label' => 'Kedatangan Lama / Baru', 'url' => $this->createAbsoluteUrl($controller . '/laporanStatusKunjunganPenunjang'),),
                array('label' => 'Agama', 'url' => $this->createAbsoluteUrl($controller . '/laporanAgamaKunjunganPenunjang'),),
                array('label' => 'Pekerjaan', 'url' => $this->createAbsoluteUrl($controller . '/laporanPekerjaanKunjunganPenunjang'),),
                array('label' => 'Status Perkawinan', 'url' => $this->createAbsoluteUrl($controller . '/laporanStatusPerkawinanKunjunganPenunjang'),),
                array('label' => 'Alamat Lengkap', 'url' => $this->createAbsoluteUrl($controller . '/laporanAlamatKunjunganPenunjang'),),
                array('label' => 'Kecamatan', 'url' => $this->createAbsoluteUrl($controller . '/laporanKecamatanKunjunganPenunjang'),),
                array('label' => 'Kab. / Kota', 'url' => $this->createAbsoluteUrl($controller . '/laporanKabKotaKunjunganPenunjang'),),
                array('label' => 'Cara Masuk', 'url' => $this->createAbsoluteUrl($controller . '/laporanCaraMasukKunjunganPenunjang'),),
                array('label' => 'Rujukan', 'url' => $this->createAbsoluteUrl($controller . '/laporanRujukanKunjunganPenunjang'),),
                array('label' => 'Pemeriksaan', 'url' => $this->createAbsoluteUrl($controller . '/laporanPemeriksaanKunjunganPenunjang'), 'active' => true),
                array('label' => 'Keterangan Pulang', 'url' => $this->createAbsoluteUrl($controller . '/laporanKetPulangKunjunganPenunjang'),),
                array('label' => 'Penjamin Pasien', 'url' => $this->createAbsoluteUrl($controller . '/laporanPenjaminKunjunganPenunjang'),),
                array('label' => 'Nama Dokter', 'url' => $this->createAbsoluteUrl($controller . '/laporanDokterPemeriksaKunjunganPenunjang'),),
                array('label' => 'Per Unit Pelayanan', 'url' => $this->createAbsoluteUrl($controller . '/laporanUnitPelayananKunjunganPenunjang'),),

            ),
        ));
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Kunjungan Penunjang - Pemeriksaan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<h6>Table Kunjungan <b>Rawat Jalan - Pemeriksaan</b></h6>-->
                <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan._tablePemeriksaan', array('model' => $model)); ?>
                <!--</div>-->
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-chart-bar"></i> Grafik
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan._tab'); ?>
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>

        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printPemeriksaKunjunganPenunjang');
        $this->renderPartial('pendaftaranPenjadwalan.views.laporan._footer', array('urlPrint' => $urlPrint, 'url' => $url, 'tips' => 'bukuregister'));
        ?>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.penunjang/_jsFunctions', array('model' => $model)); ?>
    </div>
</div>