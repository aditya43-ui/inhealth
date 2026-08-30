<div class="panel-det-pemeriksaan" row-det-staining="0">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title"> 
                <?php $tambah = CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-plus icon-white"></i>')), array('class' => 'btn btn-green', 'type' => 'button', 'onclick' => 'tambahBarisPemeriksaan(this); return false;')); ?>
                <?php $kurang = CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-minus icon-white"></i>')), array('style' => 'float: right', 'class' => 'btn btn-red', 'type' => 'button', 'onclick' => 'hapusBarisPemeriksaan(this); return false;')); ?>
                <b> Data Pemeriksaan &nbsp;&nbsp;&nbsp; <?= $tambah ?> </b>
                <?php 
                    $disable = false;
                    if (!empty($modStainingGambar->tgl_verifikasi_dpjtm) && !empty($modStainingGambar->tgl_verifikasi_ppds)) {
                        $disable = true;
                    }
                ?>
            </div>
        </div>
        <div class="panel-body">
            <?php echo $kurang; ?>
            <div class="control-group gram">
                <label class="control-label">Gram</label>
                <div class="controls">
                    <?php echo CHtml::activeDropDownList($modStainingDet, '[detail][' . $i . '][' . $j . ']gram', LookupM::getItems('gram'), array('disabled' => $disable, 'empty' => '-- Pilih Gram --', 'class' => 'span2')); ?>
                </div>
                <div class="controls">
                    <?php echo CHtml::activeDropDownList($modStainingDet, '[detail][' . $i . '][' . $j . ']gram_morfologi', LookupM::getItems('gram_morfologi'), array('disabled' => $disable, 'empty' => '-- Pilih Morfologi --', 'class' => 'span2')); ?>
                </div>
                <div class="controls">
                    <?php echo CHtml::activeDropDownList($modStainingDet, '[detail][' . $i . '][' . $j . ']gram_kuantitas', LookupM::getItems('gram_kuantitas'), array('disabled' => $disable, 'empty' => '-- Pilih Kuantitas --', 'class' => 'span2')); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Keterangan</label>
                <div class="controls">
                    <?php echo CHtml::activeHiddenField($modStainingDet, '[detail][' . $i . '][' . $j . ']status', array('readonly' => true, 'class' => 'span1 status')) ?>
                    <?php echo CHtml::activeHiddenField($modStainingDet, '[detail][' . $i . '][' . $j . ']stainingdet_id', array('readonly' => true, 'class' => 'span1 stainingdet_id')) ?>
                    <?php echo CHtml::activeTextArea($modStainingDet, '[detail][' . $i . '][' . $j . ']keterangan', array('disabled' => $disable, 'class' => 'span6')) ?>
                </div>
            </div>
        </div>
    </div>
</div>