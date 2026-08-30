<div class="white-container">
    <legend class="rim2">Pencatatan Hasil <b>Pemeriksaan Bank Darah</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'pemeriksaanlaboratorium-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        'focus' => '#no_pendaftaran',
    )); ?>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data hasil pemeriksaan bank darah berhasil disimpan!");
    }
    ?>
    <fieldset class="box" id="form-datakunjungan">
        <legend class="rim">Data Kunjungan
            <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
        </legend>
        <div class="row">
            <?php $this->renderPartial($this->path_view . '_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
        </div>
    </fieldset>
    <fieldset>
        <div class="row">
            <div class="col-sm-4">
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'riwayat-anamnesa',
                    'content' => array(
                        'content-riwayat-anamnesa' => array(
                            'header' => '<b>Riwayat Anamnesis</b>',
                            'isi' => '<div class="content"></div>',
                            'active' => false,
                        ),
                    ),
                )); ?>
            </div>
            <div class="col-sm-4">
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'riwayat-pemeriksaan-fisik',
                    'content' => array(
                        'content-riwayat-pemeriksaan-fisik' => array(
                            'header' => '<b>Riwayat Pemeriksaan Fisik</b>',
                            'isi' => '<div class="content"></div>',
                            'active' => false,
                        ),
                    ),
                ));
                ?>
            </div>
            <div class="col-sm-4">
                <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'riwayat-diagnosa',
                    'content' => array(
                        'content-riwayat-diagnosa' => array(
                            'header' => '<b>Riwayat Diagnosa</b>',
                            'isi' => '<div class="content"></div>',
                            'active' => false,
                        ),
                    ),
                ));
                ?>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="row">
            <div class="span12">
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'form-tindakanpemeriksaan',
                    'content' => array(
                        'content-tindakan' => array(
                            'header' => '<b>Tabel Pemeriksaan</b>',
                            'isi' => '
                                    <table class="table table-condensed table-striped">
                                        <thead>
                                            <th>No.</th>
                                            <th>Nama Pemeriksaan</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                            <th>Tarif</th>
                                            <th>Total</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>',
                            'active' => false,
                        ),
                    ),
                )); ?>
            </div>
        </div>
        <?php
        if ($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_KLINIK) {
            echo $this->renderPartial('_formHasilPemeriksaan', array('form' => $form, 'modHasilPemeriksaan' => $modHasilPemeriksaan));
        } else if ($modKunjungan->ruangan_id == Params::RUANGAN_ID_LAB_ANATOMI) {
            echo $this->renderPartial('_formHasilPemeriksaanPA', array('format' => $format));
        }
        ?>

        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);')
            );
            if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        //                                      'onclick'=>'if(!confirm("Apakah Anda ingin mengulang ini ?")) return false;'));
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                );
            }

            echo CHtml::link(Yii::t('mds', '{icon} Print Hasil', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printHasil();return false"));

            $content = $this->renderPartial('tips/tipsPencatatanHasilPemeriksaan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
    <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modTindakan' => $modTindakan, 'dariHasil' => 1)); ?>
    <?php $this->renderPartial('_jsFunctions', array('modKunjungan' => $modKunjungan, 'modHasilPemeriksaan' => $modHasilPemeriksaan, 'modTindakan' => $modTindakan)); ?>
</div>