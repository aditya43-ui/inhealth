<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-clipboard-check"></i> Transaksi <b>Proses Inspeksi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Pembersihan' => Yii::app()->request->getUrlReferrer(),
            'Proses Inspeksi'
        );

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian Pembersihan
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_pencarian', array('modPembersihanSearch' => $modPembersihanSearch)); ?>
            </div>
        </div>

        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'prosesinspeksi-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
        ));
        ?>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-tshirt"></i> Pembersihan
                </div>
            </div>
            <div class="panel-body table-responsive">

                <table id="tabel-pembersihan" class="items table table-striped table-condensed" style="max-width: 1300px;">
                    <thead>
                        <tr>
                            <th hidden>Pilih
                                <?php echo CHtml::checkBox('check_semua', true, array('rel' => 'tooltip', 'title' => 'Pilih semua penerimaan', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked')) ?>
                            </th>
                            <th>Tgl. Pembersihan</th>
                            <th>No. Pembersihan</th>
                            <th>Ruangan asal</th>
                            <th>Nama Peralatan (Jumlah)</th>
                            <th>Keadaan Terima</th>
                            <th>Dekontaminasi</th>
                            <th>Pembersihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($modPembersihan)) {
                            echo $this->renderPartial($this->path_view . '_rowPembersihan', array('modPembersihan' => $modPembersihan, 'row' => '1'), true);
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Ispeksi & Hasil
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_formInspeksi', array(
                    'model' => $model,
                    'form' => $form

                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            if ($model->isNewRecord) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => '')
                );
                //                                                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false;",'disabled'=>'true', 'style'=>'cursor:not-allowed;'));
            } else {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
                    array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan', 'onclick' => "", 'disabled' => true)
                );
                //                                                echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="'.MyIcon::getIcons('cetak').'"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printAsesmen();return false",'enabled'=>'true'));
            }
            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl($this->id . '/index'),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>

        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . '_jsFunctions', array(
    'model' => $model,
    'modPembersihan' => $modPembersihan,
    'modPembersihanSearch' => $modPembersihanSearch
)); ?>