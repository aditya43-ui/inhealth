<!--div class="white-container"-->

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"> Informasi <b>Presensi</b></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Presensi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->breadcrumbs = array(
                    'Kppresensi Ts' => array('index'),
                    'Manage',
                );

                Yii::app()->clientScript->registerScript('search', "
                           $('#kppresensi-t-search').submit(function(){
                                $.fn.yiiGridView.update('kppresensi-t-grid', {
                                    data: $(this).serialize()
                                });
                                return false;
                           });
                           ");
                $this->widget('bootstrap.widgets.BootAlert');

                //
                //$arrMenu = array();
                //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Presensi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
                ////                array_push($arrMenu,array('label'=>Yii::t('mds','List').' KPPresensiT', 'icon'=>'list', 'url'=>array('index'))) ;
                //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Presensi', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                //                
                //$this->menu=$arrMenu;

                $this->widget('bootstrap.widgets.BootAlert'); ?>
                <div class="form-horizontal">
                    <?php
                    if (!Yii::app()->user->getState('isotomatispresensi')) {  //RND-7741
                        $konfigFinger = AlatfingerM::model()->findAll();
                        if (is_array($konfigFinger)) {
                            echo '<div class="control-group"><label for="KPPresensiT_no_fingerprint" class="control-label required">No. Finger Print <span class="required">*</span></label>
                                                                       <div class="controls">';
                            echo CHtml::dropDownList('finger', '', CHtml::listData($konfigFinger, 'alatfinger_id', 'namaalat'), array('empty' => '-- Pilih --'));
                            echo CHtml::button("connect", array("id" => "connect", "class" => 'btn btn-primary', 'style' => 'height:20px;line-height:4px;padding:0px 5px 0px 5px ;', 'onclick' => 'aktifkanFinger(this, false);'));
                            echo CHtml::button("info", array("class" => 'btn btn-info', 'style' => 'height:20px;line-height:4px;padding:0px 5px 0px 5px ;', 'onclick' => '$("#infokoneksi").slideToggle();'));
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    ?>
                    <style>
                        #overlay {
                            position: absolute;
                            left: 0;
                            top: 0;
                            bottom: 0;
                            right: 0;
                            background: #000;
                            opacity: 0.8;
                            filter: alpha(opacity=80);
                            z-index: 9999;
                            overflow: auto;
                        }

                        #loading {
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            margin: -28px 0 0 -25px;
                        }

                        #infokoneksi {
                            margin-left: 80px;
                            display: none;
                            width: 400px;
                            border: 1px solid #cccccc;
                            padding: 5px;
                            -webkit-border-radius: 2px;
                            -moz-border-radius: 2px;
                            border-radius: 2px;
                            margin-bottom: 10px;
                        }

                        #infokoneksi .control-label {
                            width: 50px;
                        }

                        #infokoneksi .controls {
                            margin-left: 70px;
                        }
                    </style>
                    <div id="infokoneksi">
                        <div class="control-group"><label for="KPPresensiT_no_fingerprint" class="control-label required">Status</label>
                            <div class="controls" id="status-connection">

                            </div>
                        </div>
                        <div class="control-group"><label for="KPPresensiT_no_fingerprint" class="control-label required">IP</label>
                            <div class="controls" id="ip-connection">

                            </div>
                        </div>
                        <div class="control-group"><label for="KPPresensiT_no_fingerprint" class="control-label required">Lokasi</label>
                            <div class="controls" id="lokasi-connection">

                            </div>
                        </div>
                    </div>
                </div>
                <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
                ?>

                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'kppresensi-t-grid',
                    'dataProvider' => $model->searchInformasiPresensi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                    'columns' => array(
                        //'no_fingerprint',
                        array(
                            'header' => 'No. FP',
                            'name' => 'no_fingerprint'
                        ),
                        array(
                            'header' => 'Kelompok Pegawai/<br>Jabatan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $kelompok = !empty($data->pegawai->kelompokpegawai_id) ? $data->pegawai->kelompokpegawai->kelompokpegawai_nama : '-';
                                $jabatan = !empty($data->pegawai->jabatan_id) ? $data->pegawai->jabatan->jabatan_nama : '-';

                                return $kelompok . '/<br>' . $jabatan;
                            }
                        ),
                        //'pegawai.kelompokpegawai.kelompokpegawai_nama',
                        //'pegawai.jabatan.jabatan_nama',
                        'pegawai.nomorindukpegawai',
                        'pegawai.nama_pegawai',
                        //'statusscan.statusscan_nama',               
                        array(
                            'header' => 'Shift/<br>Jam Kerja',
                            'name' => 'pegawai.shift.shift_nama',
                            'value' => function ($data) {
                                $jamM = null;
                                $jamP = null;
                                $tgl = MyFormatter::formatDateTimeForDb(date('Y-m-d',  strtotime($data->tglpresensi)));
                                $cekJadwal = PenjadwalandetailT::model()->cekPenjadwalan($data->pegawai_id, $data->tglpresensi);
                                $cekPertukaran = PertukaranjadwaldetT::model()->cekPertukaran($data->pegawai_id, $data->tglpresensi);
                                $jammasuk = PresensiT::model()->getJam(Params::STATUSSCAN_MASUK, $data->tglpresensi, $data->pegawai_id);
                                $jampulang = PresensiT::model()->getJam(Params::STATUSSCAN_PULANG, $data->tglpresensi, $data->pegawai_id);
                                $masuk = PresensiT::model()->findAll(" statusscan_id = '" . Params::STATUSSCAN_MASUK . "' AND tglpresensi::text iLike '$tgl%' AND pegawai_id = '$data->pegawai_id' ");

                                if (count((array)$masuk) > 0) {
                                    foreach ($masuk as $masuk) :
                                        $jamM = $masuk->tglpresensi;
                                    endforeach;
                                }
                                $pulang = PresensiT::model()->findAll(" statusscan_id = '" . Params::STATUSSCAN_PULANG . "' AND tglpresensi::text iLike '$tgl%' AND pegawai_id = '$data->pegawai_id' ");

                                if (count((array)$pulang) > 0) {
                                    foreach ($pulang as $pulang) :
                                        $jamP = $pulang->tglpresensi;
                                    endforeach;
                                }

                                if ($cekPertukaran == 0) {
                                    if ($cekJadwal == 0) {
                                        if (isset($data->pegawai->shift_id)) {
                                            return $data->pegawai->shift->shift_nama . ' / ' . $data->pegawai->shift->shift_jamawal . ' s/d ' . $data->pegawai->shift->shift_jamakhir;
                                        } else {
                                            return ShiftM::model()->getShift($jammasuk, $jampulang, $jamM, $jamP);
                                        }
                                    } else {
                                        return ShiftM::model()->getJam($cekJadwal);
                                    }
                                } else {
                                    return ShiftM::model()->getJam($cekPertukaran);
                                }
                            }
                        ),
                        array(
                            'name' => 'tglpresensi',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tglpresensi);'
                        ),
                        array(
                            'header' => 'Masuk',
                            'value' => function ($data) use (&$cr) {
                                $cr = new CDbCriteria();
                                $cr->compare('tglpresensi::date', $data->tglpresensi);
                                $cr->compare('pegawai_id', $data->pegawai_id);
                                //$cr->compare('statuskehadiran_id', $data->statuskehadiran_id);
                                $cr->addCondition('statusscan_id=:p1');
                                $cr->params[':p1'] = Params::STATUSSCAN_MASUK;
                                $pr = PresensiT::model()->find($cr);
                                if (empty($pr)) return "-";
                                return date('H:i:s', strtotime($pr->tglpresensi));
                            },
                        ),
                        array(
                            'header' => 'Keluar',
                            'value' => function ($data) use (&$cr) {
                                $cr->params[':p1'] = Params::STATUSSCAN_KELUAR;
                                $pr = PresensiT::model()->find($cr);
                                if (empty($pr)) return "-";
                                return date('H:i:s', strtotime($pr->tglpresensi));
                            },
                        ),
                        array(
                            'header' => 'Datang',
                            'value' => function ($data) use (&$cr) {
                                $cr->params[':p1'] = Params::STATUSSCAN_DATANG;
                                $pr = PresensiT::model()->find($cr);
                                if (empty($pr)) return "-";
                                return date('H:i:s', strtotime($pr->tglpresensi));
                            },
                        ),
                        array(
                            'header' => 'Pulang',
                            'value' => function ($data) use (&$cr) {
                                $cr->params[':p1'] = Params::STATUSSCAN_PULANG;
                                $pr = PresensiT::model()->find($cr);
                                if (empty($pr)) return "-";
                                return date('H:i:s', strtotime($pr->tglpresensi));
                            },
                        ),
                        array(
                            'header' => 'Terlambat (Menit)',
                            'value' => function ($data) use (&$cr) {
                                $cr = new CDbCriteria();
                                $cr->compare('tglpresensi::date', $data->tglpresensi);
                                $cr->compare('pegawai_id', $data->pegawai_id);
                                $cr->addCondition('statusscan_id=:p1');
                                $cr->params[':p1'] = Params::STATUSSCAN_MASUK;
                                $pr = PresensiT::model()->find($cr);
                                if (empty($pr)) return "-";
                                $jammasuk = strtotime(date('H:i:s', strtotime($pr->tglpresensi)));

                                //return $pr1->jam;
                                $shift = $data->getShiftId($data->pegawai_id);
                                $jamM = null;
                                $jamP = null;
                                $tgl = MyFormatter::formatDateTimeForDb(date('Y-m-d',  strtotime($data->tglpresensi)));
                                $cekJadwal = PenjadwalandetailT::model()->cekPenjadwalan($data->pegawai_id, $data->tglpresensi);
                                $cekPertukaran = PertukaranjadwaldetT::model()->cekPertukaran($data->pegawai_id, $data->tglpresensi);
                                $jammasuk = PresensiT::model()->getJam(Params::STATUSSCAN_MASUK, $data->tglpresensi, $data->pegawai_id);
                                $jampulang = PresensiT::model()->getJam(Params::STATUSSCAN_PULANG, $data->tglpresensi, $data->pegawai_id);
                                $masuk = PresensiT::model()->findAll(" statusscan_id = '" . Params::STATUSSCAN_MASUK . "' AND tglpresensi::text iLike '$tgl%' AND pegawai_id = '$data->pegawai_id' ");

                                if (count((array)$masuk) > 0) {
                                    foreach ($masuk as $masuk) :
                                        $jamM = $masuk->tglpresensi;
                                    endforeach;
                                }
                                $pulang = PresensiT::model()->findAll(" statusscan_id = '" . Params::STATUSSCAN_PULANG . "' AND tglpresensi::text iLike '$tgl%' AND pegawai_id = '$data->pegawai_id' ");

                                if (count((array)$pulang) > 0) {
                                    foreach ($pulang as $pulang) :
                                        $jamP = $pulang->tglpresensi;
                                    endforeach;
                                }

                                if ($cekPertukaran == 0) {
                                    if ($cekJadwal == 0) {
                                        if (isset($data->pegawai->shift_id)) {
                                            if ($data->pegawai->shift_id == Params::SHIFT_PAGI) {
                                                $tepat = strtotime(date('Y-m-d', strtotime($pr->tglpresensi)) . " 08:15:00");
                                            } else {
                                                $tepat = strtotime(date('Y-m-d', strtotime($pr->tglpresensi)) . $shift->shift_jamawal);
                                            }
                                            //$tepat =  strtotime(date('Y-m-d',strtotime($pr->tglpresensi)).' '.$data->pegawai->shift->shift_jamawal);
                                        } else {
                                            $tepat =  strtotime(date('Y-m-d', strtotime($pr->tglpresensi)) . ' ' . ShiftM::model()->getShift($jammasuk, $jampulang, $jamM, $jamP, 1));
                                        }
                                    } else {
                                        return ShiftM::model()->getJam($cekJadwal, 1);
                                    }
                                } else {
                                    return ShiftM::model()->getJam($cekPertukaran, 1);
                                }

                                $masuk = strtotime(date('Y-m-d H:i:s', strtotime($pr->tglpresensi)));
                                $jam = floor(round(abs($masuk - $tepat) / 60, 2));

                                //if ($data->statuskehadiran_id == Params::STATUSKEHADIRAN_HADIR)
                                //{    
                                if ($masuk < $tepat) {
                                    return "0 Menit";
                                } else {
                                    return $jam . ' Menit';
                                }
                                // }
                                // else{
                                //   return '-';
                                // }*/
                                return '-';
                            },
                            'htmlOptions' => array('style' => 'text-align:center;')
                        ),
                        array(
                            'header' => 'Pulang Awal (Menit)',
                            'value' => function ($data) use (&$cr) {
                                $cr->params[':p1'] = Params::STATUSSCAN_PULANG;
                                $pr = PresensiT::model()->find($cr);
                                if (empty($pr)) return "-";

                                $shift = $data->getShiftId($data->pegawai_id);
                                $jamM = null;
                                $jamP = null;
                                $tgl = MyFormatter::formatDateTimeForDb(date('Y-m-d',  strtotime($data->tglpresensi)));
                                $cekJadwal = PenjadwalandetailT::model()->cekPenjadwalan($data->pegawai_id, $data->tglpresensi);
                                $cekPertukaran = PertukaranjadwaldetT::model()->cekPertukaran($data->pegawai_id, $data->tglpresensi);
                                $jammasuk = PresensiT::model()->getJam(Params::STATUSSCAN_MASUK, $data->tglpresensi, $data->pegawai_id);
                                $jampulang = PresensiT::model()->getJam(Params::STATUSSCAN_PULANG, $data->tglpresensi, $data->pegawai_id);
                                $masuk = PresensiT::model()->findAll(" statusscan_id = '" . Params::STATUSSCAN_MASUK . "' AND tglpresensi::text iLike '$tgl%' AND pegawai_id = '$data->pegawai_id' ");

                                if (count((array)$masuk) > 0) {
                                    foreach ($masuk as $masuk) :
                                        $jamM = $masuk->tglpresensi;
                                    endforeach;
                                }
                                $pulang = PresensiT::model()->findAll(" statusscan_id = '" . Params::STATUSSCAN_PULANG . "' AND tglpresensi::text iLike '$tgl%' AND pegawai_id = '$data->pegawai_id' ");

                                if (count((array)$pulang) > 0) {
                                    foreach ($pulang as $pulang) :
                                        $jamP = $pulang->tglpresensi;
                                    endforeach;
                                }

                                if ($cekPertukaran == 0) {
                                    if ($cekJadwal == 0) {
                                        if (isset($data->pegawai->shift_id)) {
                                            if ($data->pegawai->shift_id == Params::SHIFT_PAGI) {
                                                $tepat = strtotime(date('Y-m-d', strtotime($pr->tglpresensi)) . " 14:00:00");
                                            } else {
                                                $tepat = strtotime(date('Y-m-d', strtotime($pr->tglpresensi)) . $shift->shift_jamakhir);
                                            }
                                            //$tepat =  strtotime(date('Y-m-d',strtotime($pr->tglpresensi)).' '.$data->pegawai->shift->shift_jamakhir);
                                        } else {
                                            $tepat =  strtotime(date('Y-m-d', strtotime($pr->tglpresensi)) . ' ' . ShiftM::model()->getShift($jammasuk, $jampulang, $jamM, $jamP, 2));
                                        }
                                    } else {
                                        return ShiftM::model()->getJam($cekJadwal, 2);
                                    }
                                } else {
                                    return ShiftM::model()->getJam($cekPertukaran, 2);
                                }


                                $pulang = strtotime(date('Y-m-d H:i:s', strtotime($pr->tglpresensi)));
                                $jam = floor(round(abs($tepat - $pulang) / 60, 2));

                                // if ($data->statuskehadiran_id == Params::STATUSKEHADIRAN_HADIR)
                                // {
                                if ($pulang > $tepat) {
                                    return "0 Menit";
                                } else {
                                    return $jam . ' Menit';
                                }
                                // }else{
                                //      return '-';
                                // }*/
                                return '-';
                            },
                            'htmlOptions' => array('style' => 'text-align:center;')
                        ),
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            //'name' => 'statuskehadiran.statuskehadiran_nama',
                            'value' => function ($data) {

                                $cr4 = new CDbCriteria();
                                $cr4->compare('tglpresensi::date', $data->tglpresensi);
                                $cr4->compare('pegawai_id', $data->pegawai_id);
                                $cr4->addCondition('statusscan_id=:p1');
                                $cr4->params[':p1'] = Params::STATUSSCAN_MASUK;
                                $pr4 = PresensiT::model()->find($cr4);

                                $cr5 = new CDbCriteria();
                                $cr5->compare('tglpresensi::date', $data->tglpresensi);
                                $cr5->compare('pegawai_id', $data->pegawai_id);
                                $cr5->addCondition('statusscan_id=:p1');
                                $cr5->params[':p1'] = Params::STATUSSCAN_PULANG;
                                $pr5 = PresensiT::model()->find($cr5);

                                $masuk = !empty($pr4) ? strtotime($pr4->tglpresensi) : null;
                                $pulang = !empty($pr5) ? strtotime($pr5->tglpresensi) : null;


                                if ((!empty(Params::getStatusHadir(!empty($pr5->statuskehadiran_id) ? $pr5->statuskehadiran_id : null)) || (!empty(Params::getStatusHadir(!empty($pr4->statuskehadiran_id) ? $pr4->statuskehadiran_id : null))))) {
                                    if (!empty(Params::getStatusHadir(!empty($pr4->statuskehadiran_id) ? $pr4->statuskehadiran_id : null))) {
                                        echo PresensiT::model()->getWarnaKehadiran($pr4->statuskehadiran->statuskehadiran_nama);
                                    } elseif (!empty(Params::getStatusHadir(!empty($pr5->statuskehadiran_id) ? $pr5->statuskehadiran_id : null))) {
                                        echo PresensiT::model()->getWarnaKehadiran($pr5->statuskehadiran->statuskehadiran_nama);
                                    }
                                } else {
                                    if ((empty($masuk)) && (empty($pulang))) {
                                        return 'Tidak ada absen masuk/pulang';
                                    } elseif ((!empty($masuk)) && (empty($pulang))) {
                                        return 'Tidak ada absen pulang';
                                    } elseif ((empty($masuk)) && (!empty($pulang))) {
                                        return 'Tidak ada absen masuk';
                                    } else {
                                        $jam = floor(round(abs($masuk - $pulang) / 60, 2) / 60);

                                        if ($jam >= Params::KUOTA_JAM_KERJA) {
                                            return PresensiT::model()->getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_HADIR);
                                        } else {
                                            return PresensiT::model()->getWarnaKehadiran(Params::STATUSKEHADIRAN_NAMA_ALPHA);
                                        }
                                    }
                                }



                                //$diff = CustomFunction::get
                                /*if (count((array)$pr4)>0){
                                                       $waktu = date('H:i:s', strtotime($pr4->tglpresensi));
                                                       if ( ($waktu >= '09:00:00') AND ($waktu <= '10:00:00')){
                                                           echo PresensiT::model()->getWarnaKehadiran(StatuskehadiranM::model()->findByPk(Params::STATUSKEHADIRAN_ALPHA)->statuskehadiran_nama);
                                                       }else{
                                                           echo PresensiT::model()->getWarnaKehadiran($pr4->statuskehadiran->statuskehadiran_nama);
                                                       }

                                                   }else{
                                                       if (count((array)$pr5)){
                                                           echo PresensiT::model()->getWarnaKehadiran($pr5->statuskehadiran->statuskehadiran_nama);
                                                       }else{
                                                           echo '-';
                                                       }
                                                   }*/
                            }
                        ),
                        /*
                                           array(
                                               'name'=>'verifikasi',
                                           ),
                                                        * 
                                                        */
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>

            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_search', array(
                    'model' => $model,
                )); ?>
            </div>
        </div>
    </div>
</div>

<!--/div-->
<?php
//.'/images/ajax-loader.gif'
$url_image = Yii::app()->getBaseUrl('webroot');

Yii::app()->clientScript->registerScript('onheadfungsi', '
        var interval;
    function updateTable(){
        $.fn.yiiGridView.update("kppresensi-t-grid", {
                data: $(".search-form form").serialize()
        });
    }
    
    function setAuto(){
        if ($("#atur").is(":checked")){
            atur = $("#atur").val();
        }else{
            atur = 0;
        }
        $.post("' . Yii::app()->createUrl('actionAjax/turnAutoRefresh') . '",{atur:atur},function(data){
        });
    }
    
    function ambilData(ip,key){
        $.post("' . Yii::app()->createUrl('kepegawaian/presensiT/ambilData') . '",{ip:ip,key:key},function(data){
            if (data == 1){
                updateTable();
                hideLoadingMsg();
                $("#finger").val("");
            }
        });
    }
    
    function beat(){
        $.post("' . Yii::app()->createUrl('kepegawaian/presensiT/ambilData') . '",{},function(data){
            if (data == 1){
                updateTable();
            }
        });
    }
    
    function statusOff()
    {
        setInterval(function(){
            hideLoadingMsg();
        },10000);
        
    }
    
    function showLoadingMsg()
    {
        var over = \'<div id="overlay">\' + \'<img id="loading" src="images/ajax-loader.gif">\' + \'</div>\';
        $(over).appendTo(\'body\');
    }
    
    function hideLoadingMsg()
    {
        $(\'#overlay\').remove();
        aktifkanFinger($("#is_disconnect"), true);
    }    
    
function aktifkanFinger(obj,disconnect){
    var idAlat = $("#finger").val();
    var data = {idAlat:idAlat};

    if (disconnect){
        data = {idAlat:idAlat,disconnect:true};
    }
    
    if (jQuery.isNumeric(idAlat)){
        $(obj).parents(".controls").find("select, input#connect").attr("disabled","disabled");
        $.ajax({
            dataType:"json",
            data: data,
            success:function(data){

                if (disconnect){
                   if (data.success == true){
                        clearInterval(interval);
                        if ($("#infokoneksi").not(":hidden")){
                            $("#infokoneksi").slideUp();
                        }
                        $("#status-connection").html("");
                        $("#ip-connection").html("");
                        $("#lokasi-connection").html("");
                        $("select#finger, input#connect").removeAttr("disabled");
                        //clearInterval(interval);
                    }
                }else{
                    if ($("#infokoneksi").is(":hidden")){
                        $("#infokoneksi").slideDown();
                    }
                    var statusKoneksi;
                    if(data.success == 1 && data.connection == true){
                        showLoadingMsg();
                        //interval = setInterval(function(){ambilData(data.data.ipfinger, data.data.keyfinger);},5000);
                        statusKoneksi = "Connect ("+data.time+") <a onclick=\"aktifkanFinger(this, true);\" id=\"is_disconnect\" style=\"line-height:8px;\" class=\"btn btn-danger\">disconnect</a>";
                        ambilData(data.data.ipfinger, data.data.keyfinger);
                    }
                    else{
                        $(obj).parents(".controls").find("select, input#connect").removeAttr("disabled");
                        statusKoneksi = "<div class=\'error\'>Failed";
                    }
                    $("#status-connection").html(statusKoneksi);
                    $("#ip-connection").html("<div class=\'control-label\' style=\'width: 0;\'>"+data.data.ipfinger+"</div>");
                    $("#lokasi-connection").html("<div class=\'control-labe\' style=\'width: 0;\'>"+data.data.lokasifinger+"</div>");
                }
            }
        });
    }
    
    return false;
}
', CClientScript::POS_HEAD); ?>