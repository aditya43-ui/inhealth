<div class="panel panel-pr_imary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-file-alt"></i> Jadwal <b>Pemeriksaan Dokter</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'checkjadwal-r-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
            'focus' => '#' . CHtml::activeId($model, 'pendaftaran_id'),
        )); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class='far fa-file-alt'></i> Check in <b>Dokter</b>
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'Transaksi Permintaan Check in',
                );
                ?>
                <?php
                // if (isset($_GET['sukses'])) {
                //     Yii::app()->user->setFlash("success", "Data pemesanan " . $modPesanObatalkes->nopemesanan . " berhasil disimpan!");
                // }
                ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

                <?php echo $this->renderPartial('_form', array('form' => $form, 'model' => $model)); ?>
            </div>
            <div class="form-actions">
                <?php
                    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger btn-simpan ', 'type' => 'submit', 'onClick' =>'setAwal()'));  
                ?>
                <?php
                    // echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), '', array('class' => 'btn btn-default  btn-ulang',
                    //     'onclick' => 'window.parent.myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.$this->createUrl('index',['checkjadwal_id'=>$_GET['checkjadwal_id']]).'";}); return false;'));
                    ?>    
                    <?php
                    $tips = array(
                        '0' => 'simpan',
                        '1' => 'ulang',
                    );
                    $content = $this->renderPartial('perawatanIntensif.views.tips.transaksi', array('tips' => $tips), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

                    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Riwayat Check in Dokter</div>
            </div>
            <div class="panel-body">
                <?= $this->renderPartial('_daftarRiwayat',['model'=>$model]) ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>