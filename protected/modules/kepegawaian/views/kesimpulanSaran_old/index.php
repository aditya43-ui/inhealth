<div class="white-container">
    <legend class="rim2">Transaksi <b>Pencatatan Kesimpulan dan Saran Penilaian</b></legend>
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
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <fieldset class="box" id="form-penerimaan">
        <legend class="rim">Pencarian Penilaian</legend>
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
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'penyimpanansteril-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onSubmit' => 'return requiredCheck(this);'),
    )); ?>
    <fieldset class="box" id="form-kesimpulan">
        <legend class='rim'>Tabel Penilaian</legend>
        <table id="tabel-kesimpulan" class="items table table-striped table-condensed">
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
    </fieldset>

    <div class="form-actions">
        <?php
        if (isset($_GET['kesimpulanpenilaian_id'])) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT');return false", 'disabled' => FALSE));
        } else {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onKeypress' => 'validasiCek();', 'onclick' => 'validasiCek();'));
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => TRUE, 'style' => 'cursor:not-allowed;'));
        }
        ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl($this->id . '/index'),
            array(
                'class' => 'btn btn-default',
                'onclick' => 'return refreshForm(this);'
            )
        ); ?>
        <?php
        $content = $this->renderPartial($this->path_view . 'tips/tipsKesimpulan', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>

    <?php $this->endWidget(); ?>

    <?php $this->renderPartial($this->path_view . '_jsFunctions', array('modKesimpulan' => $modKesimpulan, 'modPenilaianPegawai' => $modPenilaianPegawai)); ?>

</div>