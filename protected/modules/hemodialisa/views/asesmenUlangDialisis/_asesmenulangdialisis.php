<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Asesmen Ulang Dialisis</div>
    </div>
    <div class="panel-body">
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-penyulithd',
            'content' => array(
                'content-penyulithd' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan Riwayat Penyulit HD')) . '<b> Riwayat Penyulit HD</b>',
                    'isi' => $this->renderPartial('_riwayatpenyulitHD', array(
                                'modPendaftaran'=>$modPendaftaran,
                                'modPenyulitHD'=>$modPenyulitHD,
                            ), true),
                    'active' => true,
                ),
            ),
        ));
        ?>

        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-transfusi',
            'content' => array(
                'content-transfusi' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan Riwayat Transfusi')) . '<b> Riwayat Transfusi</b>',
                    'isi' => $this->renderPartial('_riwayatTransfusi', array(
                                'modPendaftaran'=>$modPendaftaran,
                                'modTransfusi'=>$modTransfusi,
                            ), true),
                    'active' => true,
                ),
            ),
        ));
        ?>

        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-abnormallab',
            'content' => array(
                'content-abnormallab' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan Riwayat Pemeriksaan Laboratorium')) . '<b> Riwayat Pemeriksaan Laboratorium</b>',
                    'isi' => $this->renderPartial('_riwayatAbnormalLab', array(
                            'modPendaftaran'=>$modPendaftaran,
                            'modPemeriksaanLab' => $modPemeriksaanLab, 
                            ), true),
                    'active' => true,
                ),
            ),
        ));
        ?>

        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-gizi',
            'content' => array(
                'content-gizi' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan Riwayat Gizi')) . '<b> Riwayat Gizi</b>',
                    'isi' => $this->renderPartial('_riwayatGizi', array(
                                'modPendaftaran'=>$modPendaftaran,
                                'modGizi'=>$modGizi
                            ), true),
                    'active' => true,
                ),
            ),
        ));
        ?>

        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-awaldialisis',
            'content' => array(
                'content-awaldialisis' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan Riwayat Asesmen Awal Dialisis')) . '<b> Riwayat Asesmen Awal Dialisis</b>',
                    'isi' => $this->renderPartial('_riwayatAwalDialisis', array(
                                'modPendaftaran'=>$modPendaftaran,
                                'modAwalDialisis'=>$modAwalDialisis
                            ), true),
                    'active' => true,
                ),
            ),
        ));
        ?>
        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'list-asesmenawalmedis',
            'content' => array(
                'content-asesmenawalmedis' => array(
                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan Asesmen Ulang Dialisis')) . '<b> Asesmen Ulang Dialisis</b>',
                    'isi' => $this->renderPartial('_asesmenawaldialisis', array(
                                'modPendaftaran'=>$modPendaftaran,
                                'modAwalDialisis'=>$modAwalDialisis
                            ), true),
                    'active' => false,
                ),
            ),
        ));
        ?>
        
        <?php
//        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
//            'id' => 'list-grafiktandavital',
//            'content' => array(
//                'content-grafiktandavital' => array(
//                    'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan Grafik Tanda Vital Pasien')) . '<b>Grafik Tanda Vital Pasien</b>',
//                    'isi' => $this->renderPartial('_grafiktandavital', array(
////                                'modPendaftaran'=>$modPendaftaran,
////                                'modAwalDialisis'=>$modAwalDialisis
//                            ), true),
//                    'active' => true,
//                ),
//            ),
//        ));
        ?>

<!--        <div class="row-fluid">
            <div class="span12">
                <div class="form-actions">

                    <?php
//                    if (isset($_GET['sukses'])) {
//                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'id' => 'btn_submit', 'disabled' => true)) . "&nbsp";
//
//                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info',
//                            'onclick' => "print(" . $modPendaftaran->pendaftaran_id . ",'');return false")) . "&nbsp;";
//                    } else {
//                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary submit', 'id' => 'btn_submit', 'onclick' => 'cekInsert();', 'onKeypress' => 'cekInsert();', 'disabled' => false)) . "&nbsp";
//                        
//                        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => 'disabled')) . "&nbsp";
//                    }
                    ?>

                </div>
            </div>
        </div>-->
    </div>
</div>