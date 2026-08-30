<div class="white-container">
    <legend class="rim2">Pemakaian <b>BMHP</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB 
    ?>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data pemakaian BMHP berhasil disimpan!");
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'pemakaianbahp-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
        'focus' => '#no_pendaftaran',
    )); ?>

    <fieldset class="box" id="form-datakunjungan">
        <legend class="rim">Data Kunjungan
            <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setKunjunganReset();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk mengulang data kunjungan')); ?></span>
        </legend>
        <div class="row">
            <?php $this->renderPartial($this->path_view . '_formInfoKunjungan', array('form' => $form, 'modKunjungan' => $modKunjungan)); ?>
        </div>
    </fieldset>
    <div class="row">
        <div class="span12">
            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                'id' => 'riwayat-obatalkespasien-t',
                'content' => array(
                    'content-riwayat-obatalkespasien-t' => array(
                        'header' => '<b>Tabel Riwayat Obat dan Alat Kesehatan Pasien</b>',
                        'isi' => '
                                <table class="table table-condensed table-striped">
                                    <thead>
                                        <th>No.</th>
                                        <th>Tgl. Pelayanan</th>
                                        <th>Obat / Alat Kesehatan</th>
                                        <th>Satuan Kecil</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Sub Total</th>
                                        <th>Hapus</th>
                                    </thead>
                                    <tbody>
                                        <tr><td colspan=7>Data tidak ditemukan</td></tr>
                                    </tbody>
                                </table>',
                        'active' => true,
                    ),
                ),
            )); ?>
        </div>
    </div>
    <fieldset class="box" id="form-tambahobatalkes">
        <legend class='rim'>Obat dan Alat Kesehatan</legend>
        <div class="row">
            <?php $this->renderPartial($this->path_view . '_formObatAlkesPasien', array('modKunjungan' => $modKunjungan)); ?>
        </div>
        <div class="block-tabel">
            <h6>Tabel <b>BMHP</b></h6>
            <table class="items table table-striped table-condensed" id="table-obatalkespasien">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Obat / Alat Kesehatan</th>
                        <th>Satuan Kecil</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Jumlah</th>
                        <th>Sub Total</th>
                        <th>Batal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count((array)$dataOas) > 0) {
                        foreach ($dataOas as $i => $modObatAlkesPasien) {
                            echo $this->renderPartial($this->path_view . '_rowObatAlkesPasien', array('modObatAlkesPasien' => $modObatAlkesPasien));
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </fieldset>

    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);'));
        if (!isset($_GET['frame'])) {
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'class' => 'btn btn-default',
                    //                                  'onclick'=>'if(!confirm("Apakah Anda ingin mengulang ini ?")) return false;'));
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "' . $this->createUrl('index') . '";} ); return false;'
                )
            );
        }
        if ($modKunjungan->isNewRecord) {
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => 'true'));
        } else {
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print(" . $modKunjungan->pasienmasukpenunjang_id . ");return false"));
        }

        $content = $this->renderPartial($this->path_view . 'tips/tipsPemakaianBmhp', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>

    <?php $this->endWidget(); ?>

    <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKunjungan' => $modKunjungan, 'modObatAlkesPasien' => $modObatAlkesPasien)); ?>
</div>