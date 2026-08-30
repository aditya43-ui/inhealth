<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Penerimaan Darah dari PMI</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php
                    echo $form->label($modelPenerimaan, 'No. Penerimaan <span class="required">*</span>', array(
                        'class' => 'control-label required', 'readonly' => true
                    ));
                    ?>
                    <div class="controls">
                        <?php
                        echo $form->hiddenField($modelPenerimaan, 'penerimaandarahpmi_id', array(
                            'class' => 'penerimaandarahpmi_id',
                        ));
                        echo $form->textField($modelPenerimaan, 'no_penerimaan', array(
                            'readonly' => true,
                            'class' => 'span3 no_penerimaan',
                            'onblur' => 'return false;',
                        ));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($modelPenerimaan, 'Petugas Penerima', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelPenerimaan, 'petugas_penerima_nama', array(
                            'readonly' => true,
                            'class' => 'span3 petugas_penerima_nama',
                            'onblur' => 'return false;',
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->label($modelPenerimaan, 'Mengetahui', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelPenerimaan, 'petugas_mengetahui_nama', array(
                            'readonly' => true,
                            'class' => 'span3 petugas_mengetahui_nama',
                            'onblur' => 'return false;',
                        )); ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo $form->label($modelPenerimaan, 'tgl_penerimaan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modelPenerimaan, 'tgl_penerimaan', array(
                            'readonly' => true,
                            'class' => 'span3 tgl_penerimaan',
                            'onblur' => 'return false;',
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modelPenerimaan, 'keterangan_penerimaan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textArea($modelPenerimaan, 'keterangan_penerimaan', array(
                            'rows' => 3,
                            'readonly' => true,
                            'class' => 'span3 keterangan_penerimaan',
                            'onblur' => 'return false;',
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>