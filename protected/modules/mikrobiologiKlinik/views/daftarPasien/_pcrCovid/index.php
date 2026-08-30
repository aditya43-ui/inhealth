
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'pemeriksaanlaboratorium-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        )); ?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-doc-text"></i> Pencatatan Hasil <b>Pemeriksaan</b>
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
                    <?php $this->renderPartial('_pcrCovid/formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
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

    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php
            $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'riwayat-pemeriksaan',
                'content' => array(
                    'content-pemeriksaan' => array(
                        'header' => '<b>Tabel Riwayat Pemeriksaan Hasil Laboratorium</b>',
                        'isi' => $this->renderPartial('_hasilAnalis/riwayatPemeriksaan', array(
                            'model' => $modKunjungan,
                        ), true),
                        'active' => false,
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-book"></i> &nbsp;<b>Hasil Pemeriksaan Laboratorium</b>
        </div>
    </div>
    <div class="panel-body" id="">
        <?php
             echo $this->renderPartial('_hasilAnalis/hasilPemeriksaan', array(
                'model' => $modKunjungan,
            ), true);

        ?>
    </div>
</div><br>

<?php 

echo $this->renderPartial('_pcrCovid/_pcr', array(
    'model' => $modKunjungan,
    'pcr' => $model,
    'form' => $form
), true);


?>


<div class="row-fluid">
    <div class="form-actions">
        <?php

            if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit'));
                echo "&nbsp;";
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
                echo "&nbsp;";
            }       
                
            if (!isset($_GET['pemeriksaanpcr_id'])) {
                echo CHtml::link(Yii::t('mds', '{icon} Print PCR Covid', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('disabled' => true, 'class' => 'btn btn-info', 'onclick' => "return false"));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print PCR Covid', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printPCR();return false"));
            }
            
                $content = $this->renderPartial('akuntansi.views.tips.tipsaddedit3a', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                
    
?>
    </div>
</div>





<?php $this->endWidget() ?>

<script>
    function printPCR() {
        window.open(
            '<?php echo $this->createUrl('printPcr', array('pemeriksaanpcr_id' => $model->pemeriksaanpcr_id)); ?>',
            'printwin', 'left=100,top=100,width=640,height=480');
    }
</script>