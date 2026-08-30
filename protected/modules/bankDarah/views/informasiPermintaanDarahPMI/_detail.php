<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'penelitian-human-subject-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event);',
        'onsubmit' => 'return requiredCheck(this);',
        'enctype' => 'multipart/form-data',
    ),
));
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian Data Permintaan Darah
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php
                    echo $form->label($model, 'no_permintaan', array(
                        'class' => 'control-label',
                    ));
                    ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($model, 'no_permintaan', array(
                            'readonly' => true,
                            'class' => 'span3',
                            'onblur' => 'return false;',
                        ));
                        ?>

                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($model, 'tgl_permintaan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($model, 'tgl_permintaan', array(
                            'readonly' => true,
                            'class' => 'span3',
                            'onblur' => 'return false;',
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'petugas_nama', array('class' => 'control-label', 'label' => 'Petugas')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($model, 'petugas_nama', array(
                            'readonly' => true,
                            'class' => 'span3',
                            'onblur' => 'return false;',
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'instalasi_nama', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($model, 'instalasi_nama', array(
                            'readonly' => true,
                            'class' => 'span3',
                            'onblur' => 'return false;',
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'ruangan_nama', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($model, 'ruangan_nama', array(
                            'readonly' => true,
                            'class' => 'span3',
                            'onblur' => 'return false;',
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model, 'keterangan_permintaan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo $form->textArea($model, 'keterangan_permintaan', array(
                            'rows' => 3,
                            'readonly' => true,
                            'class' => 'span3',
                            'onblur' => 'return false;',
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Detail <b>Penerimaan Darah</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Jenis Darah</th>
                    <th>Gol. Darah</th>
                    <th>Rhesus</th>
                    <th>Jumlah Permintaan</th>
                    <th>Jumlah Terima</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                if (!empty($modPenerimaanDetail)) {
                    foreach ($modPenerimaanDetail as $detail) {
                ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php
                                if (!empty($detail->jeniskomponendarah_id)) {
                                    $jenisdarah = JeniskomponendarahM::model()->findByPk($detail->jeniskomponendarah_id);
                                    if (!empty($jenisdarah)) {
                                        echo $jenisdarah->jeniskantongdarah_singkatan;
                                    } else {
                                        echo '-';
                                    }
                                } else {
                                    echo '-';
                                }
                                ?></td>
                            <td><?php echo $detail->golongandarah; ?></td>
                            <td><?php echo $detail->rhesus; ?></td>
                            <td><?php echo $detail->jumlah_permintaan; ?></td>
                            <td><?php echo $detail->jumlah_terima; ?></td>
                            <td><?php echo $detail->keterangan_det; ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Penerimaan Darah</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php
                    echo $form->label($modPenerimaan, 'tgl_penerimaan', array(
                        'class' => 'control-label',
                    ));
                    ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPenerimaan, 'tgl_penerimaan', array(
                            'readonly' => true,
                            'class' => 'span3',
                            'onblur' => 'return false;',
                        ));
                        ?>

                    </div>
                </div>
                <div class="control-group">
                    <?php
                    echo $form->label($modPenerimaan, 'no_penerimaan', array(
                        'class' => 'control-label',
                    ));
                    ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPenerimaan, 'no_penerimaan', array(
                            'readonly' => true,
                            'class' => 'span3',
                            'onblur' => 'return false;',
                        ));
                        ?>

                    </div>
                </div>
                <div class="control-group">
                    <?php
                    echo $form->label($modPenerimaan, 'keterangan_penerimaan', array(
                        'class' => 'control-label',
                    ));
                    ?>
                    <div class="controls">
                        <?php
                        echo $form->textArea($modPenerimaan, 'keterangan_penerimaan', array(
                            'readonly' => true,
                            'class' => 'span3',
                            'onblur' => 'return false;',
                        ));
                        ?>

                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php
                    echo $form->label($modPenerimaan, 'petugas_penerima_id', array(
                        'class' => 'control-label',
                    ));
                    ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPenerimaan, 'petugas_penerima_nama', array(
                            'readonly' => true,
                            'class' => 'span3',
                            'onblur' => 'return false;',
                        ));
                        ?>

                    </div>
                </div>
                <div class="control-group">
                    <?php
                    echo $form->label($modPenerimaan, 'petugas_mengetahui_id', array(
                        'class' => 'control-label',
                    ));
                    ?>
                    <div class="controls">
                        <?php
                        echo $form->textField($modPenerimaan, 'petugas_mengetahui_nama', array(
                            'readonly' => true,
                            'class' => 'span3',
                            'onblur' => 'return false;',
                        ));
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>