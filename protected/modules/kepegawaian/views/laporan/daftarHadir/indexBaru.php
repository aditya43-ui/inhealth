<?php
$this->breadcrumbs = array(
    'Laporan Detail Presensi',
);
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
<!--div class="white-container"-->

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Detail Presensi</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <div class="search-form">
                    <?php
                    $this->renderPartial(
                        'daftarHadir/_search',
                        array(
                            'model' => $model,
                        )
                    );
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Detail Presensi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="block-tabel">
                    <?php

                    $generate = new KPPresensiT();
                    $generate->tglpresensi = MyFormatter::formatDateTimeForDb($model->tglpresensi);
                    $generate->tglpresensi_akhir = MyFormatter::formatDateTimeForDb($model->tglpresensi_akhir);

                    $get = $generate->generateTotalKehadiran();

                    $totKehadiran = $get['totalkehadiran'];
                    $minute = $get['menit'];

                    $this->widget(
                        'ext.bootstrap.widgets.HeaderGroupGridView',
                        array(
                            'id' => 'lapegawai-m-grid',
                            'dataProvider' => $model->searchByNofinger(),
                            'template' => "{summary}\n{items}\n{pager}",
                            'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                            'mergeHeaders' => array(
                                array(
                                    'name' => '<p style="margin: 0; text-align: center;">Status Kehadiran</p>',
                                    'start' => '5',
                                    'end' => '10',
                                ),
                                array(
                                    'name' => '<p style="margin: 0; text-align: center;">Jam Kerja</p>',
                                    'start' => '11',
                                    'end' => '12',
                                ),
                            ),
                            'columns' => array(
                                array(
                                    'header' => 'No. FP',
                                    'value' => '$data->nofingerprint',
                                ),
                                'kelompokpegawai.kelompokpegawai_nama',
                                'jabatan.jabatan_nama',
                                'nomorindukpegawai',
                                'nama_pegawai',
                                //'ruanganpegawai.ruangan.ruangan_nama',
                                // array(
                                //  'header' => 'Shift',
                                //  'name' => 'shift.shift_nama',
                                // ),                    
                                /*array(
                                             'header' => 'Rerata Jam Masuk',                        
                                             'value' => function ($data) use ($model){                            
                                                //return $this->renderPartial("daftarHadir/_rerataJamMasuk",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_MASUK,'tgl_awal'=>$model->tglpresensi,'tgl_akhir'=>$model->tglpresensi_akhir),true);
                                                return '-';
                                             }
                                         ),                  
                                        array(
                                             'header' => 'Rerata Jam Pulang',
                                             'value' => function ($data) use ($model){                            
                                                //return $this->renderPartial("daftarHadir/_rerataJamKeluar",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_PULANG,'tgl_awal'=>$model->tglpresensi,'tgl_akhir'=>$model->tglpresensi_akhir),true);
                                                return '-';
                                             }

                                         ),     */
                                array(
                                    'header' => 'Hadir',
                                    // 'value' => '$data->getTotalStatusKehadiran(1, $data->pegawai_id)',
                                    'value' => function ($data) use ($totKehadiran) {
                                        if (isset($totKehadiran[$data->pegawai_id])) {
                                            return $totKehadiran[$data->pegawai_id][Params::STATUSKEHADIRAN_HADIR];
                                        } else {
                                            return 0;
                                        }
                                        //return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_HADIR, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
                                        //return $data->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_HADIR, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
                                        //return '-';
                                    }
                                ),
                                array(
                                    'header' => 'Izin',
                                    // 'value' => '$data->getTotalStatusKehadiran(2, $data->pegawai_id)'
                                    'value' => function ($data) use ($totKehadiran) {
                                        if (isset($totKehadiran[$data->pegawai_id])) {
                                            return $totKehadiran[$data->pegawai_id][Params::STATUSKEHADIRAN_IZIN];
                                        } else {
                                            return 0;
                                        }
                                        //return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_IZIN, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
                                        //return $data->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_IZIN, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir); 
                                        //return '-';
                                    }
                                ),
                                array(
                                    'header' => 'Sakit',
                                    //'value' => '$data->getTotalStatusKehadiran(3, $data->pegawai_id)'
                                    'value' => function ($data) use ($totKehadiran) {
                                        if (isset($totKehadiran[$data->pegawai_id])) {
                                            return $totKehadiran[$data->pegawai_id][Params::STATUSKEHADIRAN_SAKIT];
                                        } else {
                                            return 0;
                                        }
                                        //return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_SAKIT, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
                                        //return $data->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_SAKIT, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
                                        //return '-';
                                    }
                                ),
                                array(
                                    'header' => 'Dinas',
                                    //'value' => '$data->getTotalStatusKehadiran(4, $data->pegawai_id)'
                                    'value' => function ($data) use ($totKehadiran) {
                                        if (isset($totKehadiran[$data->pegawai_id])) {
                                            return $totKehadiran[$data->pegawai_id][Params::STATUSKEHADIRAN_DINAS];
                                        } else {
                                            return 0;
                                        }
                                        //return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_DINAS, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
                                        //return $data->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_DINAS, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
                                        //return '-';
                                    }
                                ),
                                array(
                                    'header' => 'Alpha',
                                    //'value' => '$data->getTotalStatusKehadiran(5, $data->pegawai_id)'
                                    'value' => function ($data) use ($totKehadiran) {
                                        if (isset($totKehadiran[$data->pegawai_id])) {

                                            return $totKehadiran[$data->pegawai_id][Params::STATUSKEHADIRAN_ALPHA];
                                        } else {
                                            return 0;
                                        }
                                        //return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_ALPHA, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
                                        //return $data->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_ALPHA, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
                                        //return '-';
                                    }
                                ),
                                array(
                                    'header' => 'Cuti',
                                    //'value' => '$data->getTotalStatusKehadiran(5, $data->pegawai_id)'
                                    'value' => function ($data) use ($totKehadiran) {
                                        if (isset($totKehadiran[$data->pegawai_id])) {

                                            return $totKehadiran[$data->pegawai_id][Params::STATUSKEHADIRAN_CUTI];
                                        } else {
                                            return 0;
                                        }
                                        //return $data->getTotalStatusKehadiran(Params::STATUSKEHADIRAN_ALPHA, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
                                        //return $data->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_ALPHA, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
                                        //return '-';
                                    }
                                ),
                                array(
                                    'header' => 'Total Terlambat',
                                    // 'value'=>'$this->grid->owner->renderPartial("daftarHadir/_terlambat",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>1),true)',
                                    'value' => function ($data) use ($minute) {
                                        if (isset($minute[$data->pegawai_id])) {
                                            $j =  floor(abs($minute[$data->pegawai_id]['totalterlambat']) / 60);
                                            $m =  floor(abs(($minute[$data->pegawai_id]['totalterlambat'] / 60) - $j) * 60);

                                            if ($j == 0) {
                                                return $m . ' m';
                                            } else {
                                                if ($m == 0) {
                                                    return $j . 'j';
                                                } else {
                                                    return $j . 'j ' . $m . 'm';
                                                }
                                            }
                                        } else {
                                            return 0;
                                        }

                                        //return $this->renderPartial("daftarHadir/_terlambat",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_MASUK,'tgl_awal'=>$model->tglpresensi,'tgl_akhir'=>$model->tglpresensi_akhir),true);
                                        //return $data->getTotalStatusKehadiranV2(Params::STATUSKEHADIRAN_HADIR, $data->pegawai_id, $model->tglpresensi, $model->tglpresensi_akhir);
                                        //return '-';
                                    }
                                ),
                                array(
                                    'header' => 'Total Pulang Awal',
                                    //'value'=>'$this->grid->owner->renderPartial("daftarHadir/_pulangAwal",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>2),true)',
                                    'value' => function ($data) use ($minute) {

                                        if (isset($minute[$data->pegawai_id])) {
                                            $j =  floor(abs($minute[$data->pegawai_id]['totalpulangawal']) / 60);
                                            $m =  floor(abs(($minute[$data->pegawai_id]['totalpulangawal'] / 60) - $j) * 60);

                                            if ($j == 0) {
                                                return $m . ' m';
                                            } else {
                                                if ($m == 0) {
                                                    return $j . 'j';
                                                } else {
                                                    return $j . 'j ' . $m . 'm';
                                                }
                                            }
                                        } else {
                                            return 0;
                                        }
                                        //return $this->renderPartial("daftarHadir/_pulangAwal",array("pegawai_id"=>$data->pegawai_id ,"statusscan_id"=>  Params::STATUSSCAN_PULANG,'tgl_awal'=>$model->tglpresensi,'tgl_akhir'=>$model->tglpresensi_akhir),true);
                                        //return '-';
                                    }
                                ),
                                array(
                                    'header' => 'Daftar Hadir',
                                    'type' => 'raw',
                                    //'value'=>'CHtml::link("<i class=icon-form-detail></i><br>Daftar Hadir", Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/laporan/detailLaporanAbsen",array("id"=>"$data->pegawai_id")), array("target"=>"frame_detail", "onclick"=>"$(\'#detailAbsen\').dialog(\'open\');", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Detail Daftar Hadir"))',
                                    'value' => function ($data) use ($model) {
                                        return CHtml::link("<i class=icon-form-detail></i>", Yii::app()->createUrl(Yii::app()->controller->module->id . '/laporan/detailLaporanAbsen', array("id" => $data->pegawai_id, "tgl_awal" => $model->tglpresensi, "tgl_akhir" => $model->tglpresensi_akhir)), array("target" => "frame_detail", "onclick" => "$('#detailAbsen').dialog('open');", "rel" => "tooltip", "rel" => "tooltip", "title" => "Detail Daftar Hadir"));
                                    },
                                    'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                                ),
                            ),
                            'afterAjaxUpdate' => '
                                        function(id, data){
                                            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                                    }',
                        )
                    );
                    ?>
                </div>
                <?php
                $this->beginWidget(
                    'zii.widgets.jui.CJuiDialog',
                    array(
                        'id' => 'detailAbsen',
                        'options' => array(
                            'title' => 'Detail Absen Pegawai',
                            'autoOpen' => false,
                            'Width' => 500,
                            'width' => 900,
                            'zIndex' => 1002,
                            'modal' => true,
                            'resizable' => true,

                        ),
                    )
                );
                ?>
                <iframe src="" height="500" width="100%" name="frame_detail"></iframe>
                <?php
                $this->endWidget('zii.widgets.jui.CJuiDialog');
                ?>
            </div>
        </div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintDetailPresensi');
        $this->renderPartial('daftarHadir/_footer', array('urlPrint' => $urlPrint));
        ?>
    </div>
</div>