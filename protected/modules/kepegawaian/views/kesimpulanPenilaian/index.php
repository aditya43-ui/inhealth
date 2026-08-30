<!--div class="white-container"-->
<div class="row">
    <?php
    Yii::app()->clientScript->registerScript('search', "
        $('#pencarian-form').submit(function(){
            $('#sterilisasi-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('sterilisasi-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash("success", "Data berhasil disimpan!");
    }
    ?>
    <?php
    $this->breadcrumbs = array(
        'Informasi Pegawai' => Yii::app()->request->getUrlReferrer(),
        'Transaksi Kesimpulan Penilaian',
    );

    $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="far fa-chart-bar"></i> Transaksi <b>Kesimpulan Penilaian</b>
                </div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-search"></i> Pencarian Penilaian
                        </div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="box" id="form-penerimaan">
                            <div>
                                <?php $this->renderPartial(
                                    $this->path_view . '_search',
                                    array(
                                        'modPenilaianPegawai' => $modPenilaianPegawai,
                                    )
                                );
                                ?>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-credit-card"></i> Tabel <b>Penilaian</b>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                            'id' => 'penyimpanansteril-t-form',
                            'enableAjaxValidation' => false,
                            'type' => 'horizontal',
                            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onSubmit' => 'return requiredCheck(this);'),
                        )); ?>
                        <div class="block-tabel" id="form-kesimpulan">
                            <table id="tabel-kesimpulan" class="items table table-bordered table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>NIP</th>
                                        <th>Nama Pegawai Penilai</th>
                                        <th>Tanggal Penilaian</th>
                                        <th>Keterangan Penilaian</th>
                                        <th>Hasil Penilaian</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                            <?php echo $this->renderPartial($this->path_view . '_form', array(
                                'form' => $form,
                                'modKesimpulan' => $modKesimpulan,
                            ));
                            ?>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <?php
                    if (isset($_GET['kesimpulanpenilaian_id'])) {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true, 'style' => 'cursor:not-allowed;')
                        );
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT');return false", 'disabled' => FALSE));
                    } else {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'validasiCek();', 'onclick' => 'validasiCek();')
                        );
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => TRUE, 'style' => 'cursor:not-allowed;'));
                    }
                    ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl($this->id . '/index'),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'return refreshForm(this);'
                        )
                    ); ?>
                    <?php
                    $content = $this->renderPartial($this->path_view . 'tips/tipsKesimpulan', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKesimpulan' => $modKesimpulan, 'modPenilaianPegawai' => $modPenilaianPegawai)); ?>

<!--/div-->