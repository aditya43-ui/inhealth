<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pelayananpasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'), //DIMATIKAN KARENA PAKAI VERIFIKASI FORM >> , 'onsubmit'=>'return requiredCheck(this);'
    'focus' => '#instalasi_id',
)); ?>
<?php echo $form->errorSummary($modKunjungan); ?>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->errorSummary($modTandabukti); ?>

<?php
$this->breadcrumbs = array(
    'Pelayanan Pasien',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-user"></i> Pelayanan <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-users"></i> Data <b>Kunjungan</b>
                    <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
                </div>
            </div>
            <div class="panel-body" id="form-datakunjungan">
                <div class="search-form">
                    <div class="row">
                        <?php $this->renderPartial($this->path_view . '_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                    </div>
                </div>
                <?php echo $this->renderPartial($this->path_view . '_tabMenu', array()); ?>
                <div>
                    <iframe class="biru" id="frame" src="" width='100%' height='0' frameborder="0" style="overflow-y:scroll; "></iframe>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php
            //                      BELUM JELAS FUNGSINYA >>  echo CHtml::link(Yii::t('mds', '{icon} Verifikasi', array('{icon}'=>'<i class="icon-file icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-danger','onclick'=>"printRincianSudahBayar();return false",'disabled'=>FALSE  ));
            echo CHtml::link(Yii::t('mds', '{icon} Pembayaran', array('{icon}' => '<i class="icon-file icon-white"></i>')), 'javascript:void(0);', array('class' => 'btn btn-success', 'onclick' => "pembayaranTagihanPasien();return false", 'disabled' => FALSE));
            ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips/tipsPembayaranTagihanPasien', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->renderPartial('_jsFunctions', array('modKunjungan' => $modKunjungan, 'model' => $model, 'modTandabukti' => $modTandabukti)); ?>
        <?php $this->endWidget(); ?>
        <?php
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialog-verifikasi',
            'options' => array(
                'title' => 'Verifikasi Pembayaran',
                'autoOpen' => false,
                'modal' => true,
                'minWidth' => 960,
                'height' => 480,
                'resizable' => false,
            ),
        ));

        echo '<div class="dialog-content"></div>';
        ?>

        <div class="col-sm-12 clear">
            <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Lanjutkan', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Lanjutkan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'disableOnSubmit(this); $("#pelayananpasien-form").submit();')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), array('title' => 'Batal', 'class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'batalDialog("dialog-verifikasi");')); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>

        <?php
        //========= Dialog Detail dari riwayat pasien
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'dialogDetailData',
            'options' => array(
                'title' => 'Detail Data',
                'autoOpen' => false,
                'modal' => true,
                'width' => 500,
                'height' => 500,
                'resizable' => false,
            ),
        ));
        ?>
        <iframe src="" name="detailDialog" style="width: 100%; height: 98%;"></iframe>
        <?php
        $this->endWidget();
        ?>
    </div>
</div>

<!--fieldset>
        <?php

        //      RND-3402 >>  $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
        //                'id'=>'riwayatpasien',
        //                'content'=>array(
        //                    'content-riwayatpasien'=>array(
        //                        'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk tampilkan riwayat pasien')).'<b>Riwayat Pasien</b>',
        //                        'isi'=>"<iframe id='frame-riwayatpasien' src='' width='100%' height='100%'></iframe>",
        //                        'active'=>false,
        //                        ),   
        //                    ),
        //        )); 
        ?>
        
    </fieldset-->