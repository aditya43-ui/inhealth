<style type="text/css">
    .integer-decimal {
        text-align: right;
    }
</style>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'bkpembayaranpelayanan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);'), //DIMATIKAN KARENA PAKAI VERIFIKASI FORM >> , 'onsubmit'=>'return requiredCheck(this);'
    'focus' => '#instalasi_id',
)); ?>
<?php echo $form->errorSummary($modKunjungan); ?>
<?php echo $form->errorSummary($model); ?>
<?php echo $form->errorSummary($modTandabukti); ?>
<?php echo $form->errorSummary($modPemakaianuangmuka); ?>
<?php echo $form->hiddenField($model,'pembayaranpelayanan_id',array('readonly'=>true));?>
<?php echo $form->hiddenField($modTandabukti,'tandabuktibayar_id',array('readonly'=>true));?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-money-bill"></i> Pembayaran Tagihan <b>Pasien Penunjang</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <?php echo CHtml::label('No. Antrian','noantrian',array('class'=>'control-label'));?>
            <div class="controls">
                <?php echo $form->hiddenField($model,'antrian_id',array('readonly'=>true));?>
                <?php echo CHtml::dropDownList('cari_loket_id', $modAntrian->modelantrian_id,CHtml::listData($modAntrian->getModelAntriansKasir(), 'modelantrian_id', 'modelantrian_nama'),array('class'=>'span2','empty'=>'-- Pilih --','onchange'=>'setNamaLoket(this.value); setFormAntrian("reset");') )?>
                <?php echo CHtml::textField('noantrian',$modAntrian->noantrian,array('readonly'=>true,'class'=>'span2', 'style'=>'width:50px;', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                di <i class="diLoketAjax"> <?php echo CHtml::dropDownList('namaLoket', $modAntrian->namaLoket,CHtml::listData($modAntrian->getNamaLoketAntrian($modAntrian->modelantrian_id), 'loket_id', 'loket_nama'),array('class'=>'span2','empty'=>'-- Pilih --','style'=>'width:100px;','onchange'=>'setFormAntrian("reset");') )?> </i>
                &nbsp; <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('id'=>'bth-lihatantrian','title'=>'Klik untuk menampilkan form antrian','rel'=>'tooltip','class'=>'btn  btn-mini btn-primary', 'onclick'=>'$("#dialog-panggilantrian").dialog("open");')); ?>
            </div>
        </div>
        <div class="panel panel-success" id="form-datakunjungan">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Kunjungan</b>
                    <?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan',)); ?>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <?php $this->renderPartial('_formInfoKunjunganPenunjang', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><strong>Multi Penjamin</strong></div>
            </div>
            <div class="panel-body">
                <div class="row-fluid">
                    <div style="overflow-x: auto; max-width: 100%;" id="form-multipenjamin">
                        <?php $this->renderPartial($this->path_view.'_formMultiPenjamin', array()); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading" id="">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Detail <b>Tagihan Tindakan Penunjang</b>
                    <?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setRincianTindakan();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk me-refresh rincian tagihan tindakan')); ?>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div id="form-rinciantindakan">
                    <?php //$penjaminIdDaftar = $modKunjungan->penjamin_id; ?>
                    <?php //$this->renderPartial('_formRincianTindakanPenunjang', array('dataTindakanPenunjangs' => $dataTindakanPenunjangs, 'penjamin_id' => $penjaminIdDaftar, 'dataPenunjangs'=>$dataPenunjangs)); ?>
                    <?php //$this->renderPartial('_formInfoKunjunganPenunjang', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> <b>Total Rincian Pelayanan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div id="form-rinciansemua">
                    <?php $this->renderPartial('_formRincianTotal', array()); ?>
                </div>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading" id="">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Pembayaran</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', "Data pembayaran berhasil disimpan!");
                    $this->widget('bootstrap.widgets.BootAlert');
                } ?>
                <?php $this->renderPartial($this->path_view . '_formPembayaran', array('form' => $form, 'model' => $model, 'modTandabukti' => $modTandabukti, 'modPemakaianuangmuka' => $modPemakaianuangmuka)); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            if(empty($_GET['sukses'])){
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'setVerifikasi();', 'onkeypress' => 'setVerifikasi();')); //formSubmit(this,event)
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            }
            ?>
            <?php
            if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
            }
            ?>
            <?php
            if(empty($_GET['sukses'])){
                echo CHtml::link(Yii::t('mds', '{icon} Invoice', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printRincianPenunjangBelumBayar();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Bukti Kas Masuk', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                echo CHtml::link(Yii::t('mds', '{icon} Print Kuitansi', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Invoice', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printRincianSudahBayar();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Bukti Kas Masuk', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printBuktiKasMasuk();return false", 'disabled' => FALSE));
                echo CHtml::link(Yii::t('mds', '{icon} Print Kuitansi', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKuitansi();return false", 'disabled' => FALSE));
            }
            ?>
            <?php
            $content = $this->renderPartial($this->path_view . 'tips/tipsPembayaranTagihanPasien', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <!-- awal untuk tampilan antrian suara -->
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'model' => $model, 'modTandabukti' => $modTandabukti, 'modPemakaianuangmuka' => $modPemakaianuangmuka, 'modPiutangAsuransi'=> $modPiutangAsuransi)); ?>
        <?php $this->renderPartial('_jsFunctions', array('modKunjungan' => $modKunjungan, 'model' => $model, 'modTandabukti' => $modTandabukti, 'modPemakaianuangmuka' => $modPemakaianuangmuka)); ?>
        <?php echo $this->renderPartial($this->path_view.'_jsFunctionsAntrian', array('modAntrian'=>$modAntrian)); ?>

        <?php
        $autoopen = Yii::app()->user->getState('isantrian');
        if(!empty($model->pendaftaran_id)){
                $autoopen = false;
        }
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id'=>'dialog-panggilantrian',
                'options'=>array(
                        'title'=>'No. Antrian',
                        'autoOpen'=>$autoopen,
                        'width'=>80,
                        'resizable'=>true,
                        // 'position'=>array("right",'140'),
                ),
        ));
        ?>
        <div class="dialog-content">
            <?php echo $this->renderPartial($this->path_view.'_formPanggilAntrian', array('modAntrian'=>$modAntrian)); ?>
        </div>
        
        <div style="text-align: center;">
                        <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-backward icon-white"></i>')),array('title'=>'Klik untuk tampilkan antrian sebelumnya','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger','onclick'=>'setFormAntrian("prev");','style'=>'font-size:10px; width:24px; height:24px;')); ?>
                        <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-forward icon-white"></i>')),array('title'=>'Klik untuk tampilkan antrian berikutnya','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger','onclick'=>'setFormAntrian("next");','style'=>'font-size:10px; width:24px; height:24px;')); ?>
                        <?php //RND-1956 >>> echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-volume-down icon-white"></i>')),array('title'=>'Klik untuk membatalkan pemanggilan antrian ini','rel'=>'tooltip','class'=>'btn  btn-mini btn-danger', 'onclick'=>'if(requiredCheck(this)){ panggilAntrian("batal");}','style'=>'font-size:10px; width:24px; height:24px;')); ?>
                        <?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('title'=>'Klik untuk mengulang antrian','rel'=>'tooltip','class'=>'btn btn-mini btn-danger','onclick'=>'if(confirm("Apakah akan mengulang antrian ?")){setFormAntrian("reset");}','style'=>'font-size:10px; width:24px; height:24px;')); ?>
                <br>
                        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Panggil / Daftar',array('{icon}'=>'<i class="icon-volume-up icon-white"></i>')),array('title'=>'Klik untuk memanggil antrian ini','rel'=>'tooltip','class'=>'btn  btn-mini btn-primary', 'onclick'=>'if(requiredCheck(this)){ panggilAntrian();}','style'=>'font-size:10px; width:128px; height:24px;')); ?>
        </div>
        <?php $this->endWidget(); ?>
        <!-- akhir widget untuk tampilan suara -->
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
        <div id="suarapanggilan"></div>
        <div class="col-sm-12 clear">
            <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Lanjutkan', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Lanjutkan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'disableOnSubmit(this); simpanPembayaranPel();')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), array('title' => 'Batal', 'class' => 'btn btn-default', 'type' => 'button', 'onclick' => 'batalDialog("dialog-verifikasi");')); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>