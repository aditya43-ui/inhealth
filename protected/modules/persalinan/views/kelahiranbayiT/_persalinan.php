<?php //$this->widget('bootstrap.widgets.BootAlert'); 
?>
<?php

if (!empty($modPersalinan)) {
    $format = new MyFormatter();
    $modPersalinan->tglmulaipersalinan = $format->formatDateTimeId($modPersalinan->tglmulaipersalinan);
    $modPersalinan->tglselesaipersalinan = $format->formatDateTimeId($modPersalinan->tglselesaipersalinan);
    $modPersalinan->paritaske = $format->formatNumberForUrutanText($modPersalinan->paritaske);
?>
    <style>
        table label.control-label {
            font-size: 11px;
            font-weight: normal;
        }
    </style>

    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="glyphicon glyphicon-file"></i> Data <b>Persalinan</b>
            </div>
        </div>
        <div class="panel-body">
            <table width='100%' class="table-condensed">
                <tr>
                    <td><?php echo CHtml::activeLabel($modPersalinan, 'tglmulaipersalinan', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPersalinan, 'tglmulaipersalinan', array('readonly' => true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modPersalinan, 'tglselesaipersalinan', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPersalinan, 'tglselesaipersalinan', array('readonly' => true)); ?></td>
                    <td rowspan="4">

                    </td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPersalinan, 'carapersalinan', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPersalinan, 'carapersalinan', array('readonly' => true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modPersalinan, 'posisijanin', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPersalinan, 'posisijanin', array('readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td><?php echo CHtml::activeLabel($modPersalinan, 'jeniskegiatanpersalinan', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPersalinan, 'jeniskegiatanpersalinan', array('readonly' => true)); ?></td>

                    <td><?php echo CHtml::activeLabel($modPersalinan, 'paritaske', array('class' => 'control-label')); ?></td>
                    <td><?php echo CHtml::activeTextField($modPersalinan, 'paritaske', array('readonly' => true)); ?></td>
                </tr>

            </table>

        <?php
    } else {
        Yii::app()->user->setFlash('error', "Tidak ada data riwayat persalinan pasien");
        $this->widget('bootstrap.widgets.BootAlert');
    }

        ?>
        </div>
    </div>