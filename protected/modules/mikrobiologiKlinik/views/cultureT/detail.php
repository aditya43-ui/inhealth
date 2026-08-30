<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB     ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'staining-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#no_pendaftaran',
        ));
?>
<?php $modCulture->tanggal_culture = MyFormatter::formatDateTimeForUser($modCulture->tanggal_culture); ?>
<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Inoculating Processing </b> </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <?php echo CHtml::label('Tanggal', '', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo CHtml::activeTextField($modCulture, 'tanggal_culture', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>

            </div>
        </div>
        <?php
        $modBlood = BloodAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));
        if (!empty($modBlood)) {
            foreach ($modBlood as $mBlood) :
                ?>
                <div class="row-fluid">
                    <div id="input-bloodagar">
                        <div class="panel panel-success panel-shadow panel-bloodagar">
                            <div class="panel-heading">
                                <?php
                                $tambah = CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-plus icon-white"></i>')), array('class' => 'btn btn-green', 'type' => 'button', 'onclick' => 'tambahBlood(this);return false;'));
                                ?>
                                <div class="panel-title"><span class='judul'><b>Data Blood Agar</b></span></div>
                            </div>
                            <div class="panel-body">
                                <div class="row-fluid">
                                    <div class="control-group">
                                        <?php echo CHtml::label("Blood Agar", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
                                        <div class = "controls">
                                            <?php echo $form->dropDownList($mBlood, 'blood_agar', LookupM::getItems('culture'), array('class' => 'span3', 'disabled' => true, 'empty' => '-- Pilih Blood Agar --', 'class' => 'span3')); ?>
                                            <?php // echo $form->dropDownList($mBlood, 'blood_agar_morfologi', LookupM::getItems('culture_morfologi'), array('class' => 'span3', 'disabled' => true, 'empty' => '-- Pilih Blood Agar Morfologi --', 'class' => 'span3')); ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <?php echo CHtml::label("Upload Gambar", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
                                        <div class="controls">
                                            <?php 
                                                $modBloodGambar = BloodagarGambarT::model()->findAllByAttributes(array('blood_agar_id' => $mBlood->blood_agar_id));
                                                if (!empty($modBloodGambar)) { 
                                                    foreach ($modBloodGambar as $mBloodGambar) : ?>
                                                        <div class="col-sm-2 controls" style="margin-left: 120px;">
                                                            <img src="<?php echo Params::urlDokBloodAgarDirectory().$mBloodGambar->bloodagar_gambar?>"></img>
                                                        </div>
                                                    <?php endforeach;
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <?php echo CHtml::label("Keterangan", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
                                        <div class = "controls">
                                            <?php echo $form->textArea($mBlood, 'keterangan', array('class' => 'span6', 'disabled' => true, 'placeholder' => 'Tambahkan Keterangan Blood Agar')); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
        } else {
            ?>

        <?php } ?>

        <?php
        $modChoc = ChocAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));
        if (!empty($modChoc)) {
            foreach ($modChoc as $mChoc) :
                ?>
                <div class="row-fluid">
                    <div id="input-chocagar">
                        <div class="panel panel-success panel-shadow panel-chocagar">
                            <div class="panel-heading">
                                <div class="panel-title"><span class='judul'><b>Data Choc Agar</b></span></div>
                            </div>
                            <div class="panel-body" id="form-chocagar">
                                <div class="row-fluid">
                                    <div class="panel-body">
                                        <div class="row-fluid">
                                            <div class="control-group">
                                                <?php echo CHtml::label("Choc Agar", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
                                                <div class = "controls">
                                                    <?php echo $form->dropDownList($mChoc, 'choc_agar', LookupM::getItems('culture'), array('class' => 'span3', 'disabled' => true, 'empty' => '-- Pilih Choc Agar --', 'class' => 'span3')); ?>
                                                    <?php // echo $form->dropDownList($mChoc, 'choc_agar_morfologi', LookupM::getItems('culture_morfologi'), array('class' => 'span3', 'disabled' => true, 'empty' => '-- Pilih Choc Agar Morfologi --', 'class' => 'span3')); ?>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <?php echo CHtml::label("Upload Gambar", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
                                                <div class="controls">
                                                <?php 
                                                    $modChocGambar = ChocagarGambarT::model()->findAllByAttributes(array('choc_agar_id' => $mChoc->choc_agar_id));
                                                    if (!empty($modChocGambar)) { 
                                                        foreach ($modChocGambar as $mChocGambar) : ?>
                                                        <div class="col-sm-2 controls" style="margin-left: 120px;">
                                                                <img src="<?php echo Params::urlDokChocAgarDirectory().$mChocGambar->chocagar_gambar?>"></img>
                                                            </div>
                                                        <?php endforeach;
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <?php echo CHtml::label("Keterangan", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
                                                <div class = "controls">
                                                    <?php echo $form->textArea($mChoc, 'keterangan', array('class' => 'span6', 'disabled' => true, 'placeholder' => 'Tambahkan Keterangan Choc Agar')); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
        } else {
            ?>

        <?php } ?>

        <?php
        $modMcConcey = McconceyAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));
        if (!empty($modMcConcey)) {
            foreach ($modMcConcey as $mConcey) :
                ?>
                <div class="row-fluid">
                    <div id="input-chocagar">
                        <div class="panel panel-success panel-shadow panel-chocagar">
                            <div class="panel-heading">
                                <div class="panel-title"><span class='judul'><b>Data Mc Conkey Agar</b></span></div>
                            </div>
                            <div class="panel-body" id="form-chocagar">
                                <div class="row-fluid">
                                    <div class="panel-body">
                                        <div class="row-fluid">
                                            <div class="control-group">
                                                <?php echo CHtml::label("Mc Conkey", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
                                                <div class = "controls">
                                                    <?php echo $form->dropDownList($mConcey, 'mcconcey_agar', LookupM::getItems('culture'), array('class' => 'span3', 'disabled' => true, 'empty' => '-- Pilih Mc Conkey Agar --', 'class' => 'span3')); ?>
                                                    <?php // echo $form->dropDownList($mConcey, 'mcconcey_agar_morfologi', LookupM::getItems('culture_morfologi'), array('class' => 'span3', 'disabled' => true, 'empty' => '-- Pilih Mc Conkey Agar Morfologi --', 'class' => 'span3')); ?>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <?php echo CHtml::label("Upload Gambar", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
                                                <div class="controls">
                                                    <?php
                                                        $modMcConceyGambar = McconceyagarGambarT::model()->findAllByAttributes(array('mcconcey_agar_id' => $mConcey->mcconcey_agar_id));
                                                        if (!empty($modMcConceyGambar)) {
                                                            foreach ($modMcConceyGambar as $mConceyGambar ): ?>
                                                                <div class="col-sm-2 controls" style="margin-left: 120px;">
                                                                    <img src="<?php echo Params::urlDokMcconceyAgarDirectory().$mConceyGambar->mcconceyagar_gambar?>"></img>
                                                                </div>
                                                            <?php endforeach;
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <?php echo CHtml::label("Keterangan", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
                                                <div class = "controls">
                                                    <?php echo $form->textArea($mConcey, 'keterangan', array('class' => 'span6', 'disabled' => true, 'placeholder' => 'Tambahkan Keterangan Mc Conkey Agar')); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
        } else {
            ?>

        <?php } ?>
        
        
        <?php
        $modBrucella = RosellaAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));
        if (!empty($modBrucella)) {
            foreach ($modBrucella as $mBrucella) :
                ?>
                <div class="row-fluid">
                    <div id="input-chocagar">
                        <div class="panel panel-success panel-shadow panel-chocagar">
                            <div class="panel-heading">
                                <div class="panel-title"><span class='judul'><b>Data Brucella Agar</b></span></div>
                            </div>
                            <div class="panel-body" id="form-chocagar">
                                <div class="row-fluid">
                                    <div class="panel-body">
                                        <div class="row-fluid">
                                            <div class="control-group">
                                                <?php echo CHtml::label("Rosella", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
                                                <div class = "controls">
                                                    <?php echo $form->dropDownList($mBrucella, 'rosella_agar', LookupM::getItems('culture'), array('class' => 'span3', 'disabled' => true, 'empty' => '-- Pilih Brucella Agar --', 'class' => 'span3')); ?>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <?php echo CHtml::label("Upload Gambar", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
                                                <div class="controls">
                                                    <?php
                                                        $modBrucellaGambar = RosellaagarGambarT::model()->findAllByAttributes(array('rosella_agar_id' => $mBrucella->rosella_agar_id));
                                                        if (!empty($modBrucellaGambar)) {
                                                            foreach ($modBrucellaGambar as $mBrucellaGambar ): ?>
                                                                <div class="col-sm-2 controls" style="margin-left: 120px;">
                                                                    <img src="<?php echo Params::urlDokRosellaAgarDirectory().$mBrucellaGambar->rosellaagar_gambar?>"></img>
                                                                </div>
                                                            <?php endforeach;
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <?php echo CHtml::label("Keterangan", 'manajerpelayanan_id', array('class' => 'control-label')) ?>
                                                <div class = "controls">
                                                    <?php echo $form->textArea($mBrucella, 'keterangan', array('class' => 'span6', 'disabled' => true, 'placeholder' => 'Tambahkan Keterangan Brucella Agar')); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
        } else {
            ?>

        <?php } ?>
        <?php 
            /*
            $cekLogin = Yii::app()->user->getState('pegawai_id');
            if ($modCulture->status_verifikasi == false) {
                if ($cekLogin == $modCulture->verifikator_id) {
                    echo CHtml::link(Yii::t('mds', '{icon} Belum Terverifikasi', 
                        array('{icon}' => '<i class="icon-check icon-white"></i>')), 
                            'javascript:void(0);', 
                            array(
                                'class' => 'btn btn-danger', 
                                'onclick' => "setVerifikasi(this, ".$modCulture->culture_id.");return false", 
                                'disabled' => FALSE)) . "&nbsp;";
                } else {
                    echo CHtml::link(Yii::t('mds', '{icon} Belum Terverifikasi', array('{icon}' => '<i class="icon-check icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-danger', 'onclick' => "myAlert('Anda tidak bisa melakukan verifikasi.');return false", 'disabled' => FALSE)) . "&nbsp;";
                }
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Terverifikasi', array('{icon}' => '<i class="icon-check icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-success', 'disabled' => FALSE)) . "&nbsp;";
            }
             */
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<script>
        function setVerifikasi(obj, id) {
            myConfirm('Apakah anda yakin untuk melakukan verifikasi untuk culture ini?', 'Perhatian!', function (r) {
                if (r) {
                    $.post('<?php echo $this->createUrl('verifikasi'); ?>', {id: id}, function (data) {
                        if (data.ok == 1) {
                            myAlert(data.msg);
                            location.reload();
                        } else {
                            myAlert(data.msg);
                        }
                    }, 'json');
                }
            });
        }
</script>