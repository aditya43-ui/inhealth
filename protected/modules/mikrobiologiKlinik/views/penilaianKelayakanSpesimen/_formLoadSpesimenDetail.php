<div class = "col-sm-6">
    <?php
    echo CHtml::activeHiddenField($modSpesimen, '[' . $i . ']spesimen_id', array('class' => 'span3', 'readonly' => true));
    ?>
    <div class="control-group">
        <?php echo CHtml::label("Jenis Spesimen <span class='required'>*</span>", 'manajerpelayanan_id', array('class' => 'control-label required')) ?>
        <div class = "controls">
            <div class="input-append">
                <?php
                echo CHtml::activeTextField($modSpesimen, '['.$i.']samplelab_nama', array('class' => 'span3', 'placeholder' => 'Pilih Spesimen'));
                ?>
                <span class="add-on"><a onclick="setDialogSampleLab(this);" id="" href="javascript:void(0);"><i class="icon-list"></i><i class="icon-search"></i></a></span>
            </div>
            <?php
            echo CHtml::activeHiddenField($modSpesimen, '['.$i.']samplelab_id', array('class' => 'span3', 'readonly' => true));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Jenis/Nama Pemeriksaan <span class='required'>*</span>", 'manajerpelayanan_id', array('class' => 'control-label required')) ?>
        <div class = "controls">
            <div class="input-append">
                <?php
                echo CHtml::activeTextField($modSpesimen, '['.$i.']pemeriksaanlab_nama', array('class' => 'span3', 'placeholder' => 'Pilih Pemeriksaan'));
                ?>
                <span class="add-on"><a onclick="setDialogPemeriksaan(this);" id="" href="javascript:void(0);"><i class="icon-list"></i><i class="icon-search"></i></a></span>
            </div>
            <?php
            echo CHtml::activeHiddenField($modSpesimen, '['.$i.']pemeriksaanlab_id', array('class' => 'span3', 'readonly' => true));
            ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Tanggal</label>
        <?php $modSpesimen->waktu_pengambilan_spesimen = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modSpesimen->waktu_pengambilan_spesimen, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $modSpesimen,
                'attribute' => '['.$i.']waktu_pengambilan_spesimen',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('readonly' => true, 'class' => ' span3'),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Spesimen ID</label>
        <div class="controls">
            <?php
            echo CHtml::activeTextField($modSpesimen, '['.$i.']no_spesimen', array('class' => 'span3', 'readonly'=>true, 'placeholder'=>'-Otomatis-'));
            ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Status</label>
        <div class="controls">
            <?php echo CHtml::activeDropDownList($modSpesimen, '['.$i.']status', LookupM::getItems('jenispermintaan'), array('empty'=>'-- Pilih --','class'=>'span3')); ?>
        </div>
    </div>
</div>
<div class = "col-sm-6">
    <div class="control-group">
        <label class="control-label">Kualitas Spesimen</label>
        <div class="controls">
            <?php echo CHtml::activeRadioButtonList($modSpesimen, '['.$i.']kualitas_spesimen', LookupM::getItems('kualitasspesimen'), array()); ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Alasan</label>
        <div class="controls">
            <?php 
            echo CHtml::activeTextArea($modSpesimen, '['.$i.']alasan', array('class' => 'span3', 'placeholder'=>'Alasan'));
            ?>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="row-fluid">
 <?php
            if (isset($modSpesimen->spesimen_id)) {
                echo CHtml::link(Yii::t('mds', '{icon} Print Barcode Spesimen', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printBarcode('$modSpesimen->spesimen_id');return false"));
                echo '&nbsp;';
                echo CHtml::link(Yii::t('mds', '{icon} Print QR Code Spesimen', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printQr('$modSpesimen->spesimen_id');return false"));
            } else {
                echo CHtml::link(Yii::t('mds', '{icon} Print Barcode Spesimen', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
                echo '&nbsp;';
                echo CHtml::link(Yii::t('mds', '{icon} Print QR Code Spesimen', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
            }

            ?>
</div>