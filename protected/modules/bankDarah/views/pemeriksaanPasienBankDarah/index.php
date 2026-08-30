<div class="white-container">
    <legend class="rim2">Pemeriksaan <b>Pasien Bank Darah</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'pemeriksaanlaboratorium-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        'focus' => '#no_pendaftaran',
    ));
    ?>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data pemeriksaan pasien bank darah berhasil disimpan!");
        $this->widget('bootstrap.widgets.BootAlert');
    }
    ?>
    <fieldset class="box" id="form-datakunjungan">
        <legend class="rim">Data Kunjungan
            <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
        </legend>
        <div class="row">
            <?php $this->renderPartial('_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
        </div>
    </fieldset>
    <fieldset class="box">
        <div class="row">
            <div class="span8">
                <fieldset id='content-pemeriksaan-lab' class='box2'>
                    <legend class="rim">Daftar Pemeriksaan Bank Darah</legend>
                    <?php
                    $this->renderPartial($this->path_view_pendaftaran . '_formCariPemeriksaan', array(
                        'modPemeriksaanLab' => $modPemeriksaanLab,
                    ));
                    ?>
                    <div class='checklists'></div>
                </fieldset>
            </div>
            <div class="col-sm-4">
                <fieldset class="box2">
                    <legend class="rim">Data Kunjungan Bank Darah</legend>
                    <div id="form-masukpenunjang">
                        <?php echo $this->renderPartial('_formUbahMasukPenunjang', array('form' => $form, 'modPasienMasukPenunjang' => $modPasienMasukPenunjang)); ?>
                    </div>
                </fieldset>
                <!--<fieldset class="box2">-->
                <div class="block-tabel">
                    <legend class="rim">Tabel Pemeriksaan</legend>
                    <div id="form-tindakanpemeriksaan">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <th>No.</th>
                                <th>Nama Pemeriksaan</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Nominal Tarif</th>
                                <th>Cyto</th>
                                <th>Tarif Cyto</th>
                                <th>Total Tarif</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--</fieldset>-->
            </div>
        </div>

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

            echo CHtml::link(
                Yii::t('mds', '{icon} Print Status', array('{icon}' => '<i class="entypo-print"></i>')),
                'javascript:void(0);',
                array('class' => 'btn btn-info', 'onclick' => "printStatus();return false")
            );

            $content = $this->renderPartial('tips/tipsPemeriksaanPasienBankDarah', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
    <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modTindakan' => $modTindakan)); ?>
</div>