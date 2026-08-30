
<div class="row">
    <div class="col-md-12">

        <div class="panel-body" style="margin: -1.3%">
            <div class="panel panel-success panel-shadow" hidden="">
                <div class="panel-heading">
                    <div class="panel-title">Tabel Informasi Perkembangan Terintegrasi Pasien</div>
                </div>
                <div class="panel-body" style="width: 100%">
                    <?php
                    $pend_id = isset($_GET['id']) ? $_GET['id'] : $_GET['pendaftaran_id'];


                    //echo "<pre>";                    var_dump(Yii::app()->user->getState('ruangan_nama')); die();
                    $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'daftarPasien-grid',
                        'dataProvider' => $model->searchRI(),
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'replaceUrl' => true,
                        'columns' => array(
                            array(
                                'header' => 'No',
                                'value' => '$row+1',
                            ),
                            array(
                                'header' => 'Tanggal Pelaksanaan',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->tgltransaksi)',
                            ),
                            array(
                                'header' => 'Profesi',
                                'value' => '$data->profesi',
                            ),
                            array(
                                'header' => 'SOAP-I',
                                'value' =>
                                function($data) {
                                    return CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-form-detailtagihan"></i>')), Yii::app()->createUrl('rawatInap/PerkembanganTerintegrasiPasienT/lihatSOAP&perkembangan_terintegrasi_pasien_id='
                                                            . $data->perkembangan_terintegrasi_pasien_id . '&pendaftaran_id=' . $data->pendaftaran_id));
                                }
                                ,
                                'type' => 'raw',
                                'htmlOptions' => array('style' => 'text-align: center;'),
                                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                            ),
                            array(
                                'header' => 'Status Verifikasi',
                                'value' => function($data) {

                                    echo $data->menyetujui;
                                }
                            ,
                            ),
                            array(
                                'header' => 'Verifikasi DPJP',
                                'value' =>
                                function($data) {


                                    $pend_id = isset($_GET['id']) ? $_GET['id'] : $_GET['pendaftaran_id'];


                                    // Jika RI maka ambil dari pasienadmisi_t.pegawai_id selain itu pendaftaran_t.pegawai_id
                                    $cekLogin = Yii::app()->user->getState('pegawai_id');
                                    $cekModul = Yii::app()->user->getState('modul_id');
                                    $modDaftar = PendaftaranT::model()->findByPk($pend_id);
                                    if ($cekModul == Params::MODUL_ID_RI) {
                                        $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $modDaftar->pendaftaran_id));
                                        if (empty($data->menyetujui)) {
                                            if ($cekLogin == $modAdmisi->pegawai_id) {
                                                return CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="fa fa-check"></i> Verifikasi')), $this->createUrl('verifikasiDPJP', array('perkembangan_terintegrasi_pasien_id' => $data->perkembangan_terintegrasi_pasien_id, 'pendaftaran_id' => $data->pendaftaran_id)), array('style' => 'width: 120px;', 'class' => 'btn btn-green', "rel" => "tooltip", "title" => "Klik untuk Verifikasi DPJP"));
                                            } else {
                                                return CHtml::htmlButton('<i class="fa fa-check"> </i> Verifikasi', array(
                                                            'onclick' => 'tidakVerifikasi(' . $pend_id . ');',
                                                            'class' => 'btn btn-green',
                                                            'disabled' => false,
                                                            'style' => 'width: 120px;',
                                                            'rel' => 'tooltip',
                                                ));
                                            }
                                        } else {
                                            return CHtml::htmlButton('<i class="fa fa-check"> </i> Verifikasi', array(
                                                        'class' => 'btn btn-green',
                                                        'disabled' => true,
                                                        'style' => 'width: 120px;',
                                                        'rel' => 'tooltip',
                                            ));
                                        }
                                    } else {
                                        if (empty($data->menyetujui)) {
                                            if ($cekLogin == $modDaftar->pegawai_id) {
                                                return CHtml::link(Yii::t('mds', '{icon}', array('{icon}' => '<i class="fa fa-check"></i> Verifikasi')), $this->createUrl('verifikasiDPJP', array('perkembangan_terintegrasi_pasien_id' => $data->perkembangan_terintegrasi_pasien_id, 'pendaftaran_id' => $data->pendaftaran_id)), array('style' => 'width: 120px;', 'class' => 'btn btn-green', "rel" => "tooltip", "title" => "Klik untuk Verifikasi DPJP"));
                                            } else {
                                                return CHtml::htmlButton('<i class="fa fa-green"> </i> Verifikasi', array(
                                                            'onclick' => 'tidakVerifikasi(' . $pend_id . ');',
                                                            'class' => 'btn btn-primary',
                                                            'disabled' => false,
                                                            'style' => 'width: 120px;',
                                                            'rel' => 'tooltip',
                                                ));
                                            }
                                        } else {
                                            return CHtml::htmlButton('<i class="fa fa-check"> </i> Verifikasi', array(
                                                        'class' => 'btn btn-green',
                                                        'disabled' => true,
                                                        'style' => 'width: 120px;',
                                                        'rel' => 'tooltip',
                                            ));
                                        }
                                    }
                                },
                                'type' => 'raw',
                                'htmlOptions' => array('style' => 'text-align: center;'),
                                'headerHtmlOptions' => array('style' => 'text-align:center;'),
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                    ));
                    ?>
                </div>
            </div>
            <br>
            <?php
//            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
//                'id' => 'form-riwayat',
//                'content' => array(
//                    'content-detailpasien' => array(
//                        'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onclick' => '',
//                            'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk tampilkan riwayat pasien')) .
//                        '<b> Riwayat Pasien</b>',
//                        'isi' => '<iframe src="" id="riwayatPasien" width="100%" height="120%"></iframe>',
//                        'active' => false,
//                    ),
//                ),
//            ));
            ?>
            <?php
            $path_view = !empty($this->path_perkembangan)?$this->path_perkembangan:$this->path_view;
            echo $this->renderPartial($path_view . 'createIntegrasi', array('model' => $model, 'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien, 'modTampilAsesmen' => !empty($modTampilAsesmen)?$modTampilAsesmen:null, 'modTampilAsesmenDetail' => !empty($modTampilAsesmenDetail)?$modTampilAsesmenDetail:null, 'modPenunjang' => $modPenunjang,'path_view'=>$path_view));
            ?>      
            <?php
            //echo "<pre>";            var_dump($modAdmisi->attributes); die();
//            $pasienadmisi_id = !empty($modAdmisi->pasienadmisi_id) ? $modAdmisi->pasienadmisi_id : null;
//            //echo empty($modAdmisi->pasienadmisi_id);
//            echo CHtml::link(Yii::t('mds', '{icon} Tambah Integrasi', array('{icon}' => '<i class="entypo-check"></i>')), Yii::app()->createUrl($this->module->id . '/PerkembanganTerintegrasiPasienT' . $this->init . '/createIntegrasi&iframe=not&pendaftaran_id=' . $modPendaftaran->pendaftaran_id .
//                            '&pasienadmisi_id=' . $pasienadmisi_id . '&pasienmasukpenunjang_id=' . $modPenunjang->pasienmasukpenunjang_id . '&konsulpoli_id=' . (isset($_GET['konsulpoli_id']) ? $_GET['konsulpoli_id'] : null)), array('class' => 'btn btn-success')) . "&nbsp";
//            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info TketPrint ', 'onclick' => "print();return false", 'enabled' => true)) . "&nbsp";
//            $content = $this->renderPartial('rawatInap.views.tips.transaksi', array(), true);
//            $this->widget('UserTips', array('content' => $content));
            ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    function print() {
        window.open('<?php echo $this->createUrl('print', array('pendaftaran_id' => $pend_id)); ?>', 'printwin', 'left=100,top=100,width=640,height=480');
    }



    function tidakVerifikasi(pendaftaran_id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('tidakVerifikasi'); ?>',
            data: {pendaftaran_id: pendaftaran_id},
            dataType: "json",
            success: function (data) {
                myAlert(data.pesan);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }
</script>