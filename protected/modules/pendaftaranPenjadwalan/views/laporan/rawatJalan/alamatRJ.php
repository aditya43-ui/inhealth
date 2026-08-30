<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Kunjungan Rawat Jalan</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Laporan Kunjungan Rawat Jalan'
        );

        $url = Yii::app()->createUrl('pendaftaranPenjadwalan/laporan/frameGrafikAlamatRJ&id=1');
        if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_REKAM_MEDIS) {
            $url = Yii::app()->createUrl('rekamMedis/laporan/frameGrafikAlamatRJ&id=1');
        }
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
        <div class="search-form ">
            <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan._searchRJ', array(
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
                array('label' => 'Global', 'url' => $this->createAbsoluteUrl($controller . '/laporanKunjunganRJ'),),
                array('label' => 'Umur', 'url' => $this->createAbsoluteUrl($controller . '/laporanKunjunganUmurRJ'),),
                array('label' => 'Jenis Kelamin', 'url' => $this->createAbsoluteUrl($controller . '/laporanKunjunganJkRJ'),),
                array('label' => 'Kedatangan Lama / Baru', 'url' => $this->createAbsoluteUrl($controller . '/laporanStatusKunjunganRJ'),),
                array('label' => 'Agama', 'url' => $this->createAbsoluteUrl($controller . '/laporanAgamaKunjunganRJ'),),
                array('label' => 'Pekerjaan', 'url' => $this->createAbsoluteUrl($controller . '/laporanPekerjaanKunjunganRJ'),),
                array('label' => 'Status Perkawinan', 'url' => $this->createAbsoluteUrl($controller . '/laporanStatusPerkawinanKunjunganRJ'),),
                array('label' => 'Alamat Lengkap', 'url' => $this->createAbsoluteUrl($controller . '/laporanAlamatKunjunganRJ'), 'active' => true),
                array('label' => 'Kecamatan', 'url' => $this->createAbsoluteUrl($controller . '/laporanKecamatanKunjunganRJ'),),
                array('label' => 'Kab. / Kota', 'url' => $this->createAbsoluteUrl($controller . '/laporanKabKotaKunjunganRJ'),),
                array('label' => 'Cara Masuk', 'url' => $this->createAbsoluteUrl($controller . '/laporanCaraMasukKunjunganRJ'),),
                array('label' => 'Rujukan', 'url' => $this->createAbsoluteUrl($controller . '/laporanRujukanKunjunganRJ'),),
                array('label' => 'Pemeriksaan', 'url' => $this->createAbsoluteUrl($controller . '/laporanPemeriksaanKunjunganRJ'),),
                array('label' => 'Keterangan Pulang', 'url' => $this->createAbsoluteUrl($controller . '/laporanKetPulangKunjunganRJ'),),
                array('label' => 'Penjamin Pasien', 'url' => $this->createAbsoluteUrl($controller . '/laporanPenjaminKunjunganRJ'),),
                array('label' => 'Nama Dokter', 'url' => $this->createAbsoluteUrl($controller . '/laporanDokterPemeriksaKunjunganRJ'),),
                array('label' => 'Per Unit Pelayanan', 'url' => $this->createAbsoluteUrl($controller . '/laporanUnitPelayananKunjunganRJ'),),
                Yii::app()->user->getState("instalasi_id") === Params::INSTALASI_ID_RM ? 
                array('label' => 'Per Petugas', 'url' => $this->createAbsoluteUrl($controller . '/laporanPerPetugasRJ')) : 
                null,
            ),
        ));
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Kunjungan Rawat Jalan - Alamat</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <!--<h6>Table Kunjungan <b>Rawat Jalan - Alamat</b></h6>-->
                <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan._tableAlamat', array('model' => $model)); ?>
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
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printAlamatKunjunganRJ');
        $this->renderPartial('pendaftaranPenjadwalan.views.laporan._footer', array('urlPrint' => $urlPrint, 'url' => $url, 'tips' => 'bukuregister'));
        ?>
        <?php $this->renderPartial('pendaftaranPenjadwalan.views.laporan.rawatJalan/_jsFunctions', array('model' => $model)); ?>
    </div>
</div>