<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'hasilpmeriksaan-rehabMedis-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => false,
    'type' => 'horizontal',
    'focus' => '#',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
));
?>
<div class="white-container">
    <?php $this->widget('bootstrap.widgets.BootAlert');
    $this->renderPartial('_formDataPasien', array('modPasienPenunjang' => $modPasienPenunjang));
    ?>
    <table width="100%" id="tblFormHasilPemeriksaanRE" class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th>No. Urut Jadwal</th>
                <th>Pemeriksaan</th>
                <th>Hasil Pemeriksaan</th>
                <th>Keterangan Hasil</th>
                <th>Peralatan yang Digunakan</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <?php foreach ($modJadwalKunjungan as $i => $jadwalKunjungan) : ?>
            <?php $modHasilPemeriksaanrm = HasilpemeriksaanrmT::model()->findAll('jadwalKunjunganrm_id = ' . $jadwalKunjungan->jadwalkunjunganrm_id . '') ?>
            <tr id="jadwal_<?php echo $i; ?>">
                <td>
                    <?php echo $jadwalKunjungan->nourutjadwal; ?>
                </td>
                <td>
                    <?php foreach ($modHasilPemeriksaanrm as $tindakanrm) {
                        echo TindakanrmM::model()->with('jenistindakanrm')->findByPk($tindakanrm->tindakanrm_id)->jenistindakanrm->jenistindakanrm_nama . '</br>';
                        echo '<b>' . TindakanrmM::model()->with('jenistindakanrm')->findByPk($tindakanrm->tindakanrm_id)->tindakanrm_nama . '</b></br>';
                        echo $jadwalKunjungan->tglkunjunganrm . '</br></br>';
                    }
                    ?>
                </td>
                <td>
                    <?php foreach ($modHasilPemeriksaanrm as $hasilpemeriksaan) {
                        echo CHtml::hiddenField('hasilpemeriksaanrm[hasilpemeriksaanrm_id][]', $hasilpemeriksaan->hasilpemeriksaanrm_id);
                        echo CHtml::textArea('hasilpemeriksaanrm[hasilpemeriksaanrm][]', $hasilpemeriksaan->hasilpemeriksaanrm) . '</br></br>';
                    }
                    ?>
                </td>
                <td>
                    <?php foreach ($modHasilPemeriksaanrm as $hasilpemeriksaan) {
                        echo CHtml::textArea('hasilpemeriksaanrm[keteranganhasilrm][]', $hasilpemeriksaan->keteranganhasilrm) . '</br></br>';
                    }
                    ?>
                </td>
                <td>
                    <?php foreach ($modHasilPemeriksaanrm as $hasilpemeriksaan) {
                        echo CHtml::textArea('hasilpemeriksaanrm[peralatandigunakan][]', $hasilpemeriksaan->peralatandigunakan) . '</br></br>';
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class='form-actions'>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
            array(
                'class' => 'btn btn-danger', 'type' => 'submit',
                'onKeypress' => 'return formSubmit(this,event)',
                'id' => 'btn_simpan',
            )
        ); ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('' . Yii::app()->controller->id . '/' . $this->action->Id . ''),
            array('class' => 'btn btn-danger')
        ); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>