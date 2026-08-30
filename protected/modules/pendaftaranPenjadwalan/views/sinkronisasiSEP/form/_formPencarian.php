<div class="row-fluid">
    <div class="span8">
        <div class="control-group ">
            <label class="control-label">
                <?php
                echo "No. Kartu";
                ?>
            </label>
            <div class="controls">
                <?php echo CHtml::textField('nomorkartu', '', array('class' => 'span3')); ?>
                <?php echo CHtml::htmlButton(
                    'Cari <i class="entypo-search"></i>',
                    array(
                        'onclick' => 'setNomorDanCariRiwayatSEP();return false;',
                        'class' => 'btn btn-primary btn-nomorkartu',
                        'onkeypress' => "setNomorDanCariRiwayatSEP();return false;",
                        'rel' => "tooltip",
                        'title' => "Klik untuk mencari data peserta BPJS berdasarkan Nomor Kartu Peserta BPJS",
                    )
                ); ?>
                <?php echo CHtml::htmlButton(
                    'Ulang',
                    array(
                        'onclick' => 'clearData();return false;',
                        'class' => 'btn btn-mini btn-primary-blue btn-nomorkartu',
                        'onkeypress' => "clearData();return false;",
                        'rel' => "tooltip",
                        'title' => "Klik untuk ulang pencarian",
                    )
                ); ?>
            </div>
        </div>
    </div>
    <div class="span4">

    </div>
</div>
