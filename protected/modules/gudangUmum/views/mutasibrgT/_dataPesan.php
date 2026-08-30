<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Pemesanan Barang</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPesan, 'nopemesanan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo CHtml::activeTextField($modPesan, 'nopemesanan', array('readonly' => true))
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPesan, 'tglpesanbarang', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo CHtml::activeTextField($modPesan, 'tglpesanbarang', array('readonly' => true))
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPesan, 'ruanganpemesan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo CHtml::activeTextField($modPesan, 'ruanganpemesan_id', array('readonly' => true, 'value' => $modPesan->ruanganpemesan->ruangan_nama))
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::activeLabel($modPesan, 'pegpemesan_id', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo CHtml::activeTextField($modPesan, 'pegpemesan_id', array('readonly' => true, 'value' => $modPesan->pegawaipemesan->namaLengkap))
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>