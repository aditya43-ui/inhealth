<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Data Kantong Darah
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Jenis Kantong Darah", "", array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo CHtml::activeTextField($cekKantong, 'jeniskantong_nama', array('readonly' => true)); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">No Barcode Kantong Utama</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($cekKantong, 'nomorbarcode_utama', array('readonly' => true)) ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">No Barcode Sampel</label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($cekKantong, 'nomorbarcode_sample', array('readonly' => true)) ?> <br>
                    <?php echo CHtml::activeTextField($cekKantong, 'nomorbarcode_sample_imltd', array('readonly' => true, 'style' => 'margin-top: 8px;')) ?>
                </div>
            </div>       
        </div>
        <div class="col-sm-6">
        </div>
    </div>
</div>

