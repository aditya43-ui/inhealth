<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Pasien</b>
        </div>
    </div>
    <div class="panel-body">
        <table style="width: 100%; border: none;">
            <tr>
                <!--RND-7615-->
                <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'tgl_pendaftaran', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'tgl_pendaftaran', array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'no_rekam_medik', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'no_rekam_medik', array('readonly' => true)); ?></td>
                <td rowspan="5">
                    <?php echo CHtml::activeHiddenField($modPasienMasukPenunjang, 'photopasien', array('readonly' => true)); ?>
                    <?php
                    $url_photopasien = (!empty($modPasienMasukPenunjang->photopasien) ? Params::urlPasienTumbsDirectory() . "kecil_" . $modPasienMasukPenunjang->photopasien : Params::urlPhotoPasienDirectory() . "no_photo.jpeg");
                    ?>
                    <img id="photo-preview" src="<?php echo $url_photopasien ?>" width="120px" />
                </td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'no_pendaftaran', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'no_pendaftaran', array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'jeniskelamin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'jeniskelamin', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'umur', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'umur', array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'nama_pasien', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'nama_pasien', array('readonly' => true)); ?></td>
            </tr>
            <tr>
                <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'jeniskasuspenyakit_nama', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'jeniskasuspenyakit_nama', array('readonly' => true)); ?></td>

                <td><?php echo CHtml::activeLabel($modPasienMasukPenunjang, 'nama_bin', array('class' => 'control-label')); ?></td>
                <td><?php echo CHtml::activeTextField($modPasienMasukPenunjang, 'nama_bin', array('readonly' => true)); ?></td>
            </tr>
        </table>

    </div>
</div>
<hr>