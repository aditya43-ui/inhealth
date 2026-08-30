<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pemeriksaanlaboratorium-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#no_pendaftaran',
        )); 
        
        $controller = Yii::app()->controller->action->id;
        
        ?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-doc-text"></i> Pencatatan Hasil <b>Expertise</b>
        </div>
    </div>
    <div class="panel-body">

        <?php
        if (isset($_GET['sukses'])) {
            // die();
            Yii::app()->user->setFlash('success', "Data pemeriksaan pasien laboratorium " . $modKunjungan->nama_pasien . " berhasil disimpan!");
        }
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title rim">
                    <i class="entypo-user"></i> Data <b>Kunjungan</b>
                    <span class='tombol'
                        style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body" id="form-datakunjungan">
                <!--fieldset class="box" id="form-datakunjungan"-->
                <div class="row">
                    <?php $this->renderPartial($this->path_view_daftar . '_hasilAnalis/formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                </div>
                <!--</fieldset>-->
                <div class="row">
                    <div class="col-sm-6">
                        <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'riwayat-anamnesa',
                            'content' => array(
                                'content-riwayat-anamnesa' => array(
                                    'header' => '<b>Riwayat Anamnesa</b>',
                                    'isi' => '<div class="content"></div>',
                                    'active' => false,
                                ),
                            ),
                        )); ?>
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
                    <div class="col-sm-6">
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
            </div>
        </div>

        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-book"></i> &nbsp;<b>Tabel Riwayat Pemeriksaan Hasil Lab</b>
                </div>
            </div>
            <div class="panel-body" id="">
                <?php
             echo $this->renderPartial('_expertise/riwayatPemeriksaan', array(
                'model' => $modKunjungan,
                'kelompok' => $kelompok
            ), true);

        ?>
            </div>
        </div><br>



    </div>
</div>
<?php

if(isset($_GET['pemeriksaankultur_id'])) {

    echo $this->renderPartial($this->path_view_daftar . '_hasilAnalis/_kultur', array(
        'model' => $modKunjungan,
        'kultur' => $kultur,
        'form' => $form
    ), true);

}

if(isset($_GET['pemeriksaanpewarnaan_id'])) {

    echo $this->renderPartial($this->path_view_daftar . '_hasilAnalis/_pewarnaan', array(
        'model' => $modKunjungan,
        'pewarnaan' => $pewarnaan,
        'form' => $form
    ), true);

}

if(isset($_GET['pemeriksaancci_id'])) {

    echo $this->renderPartial($this->path_view_daftar . '_hasilAnalis/_cci', array(
        'model' => $modKunjungan,
        'cci' => $cci,
        'form' => $form
    ), true);

}

?>



<?php $this->endWidget() ?>