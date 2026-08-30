<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'gzpesanmenudiet-t-search',
    'type' => 'horizontal',
        ));
?>
<div class="panel panel-darkk">
    <span class="group-title"> Pencarian </span>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class ="control-group">
                    <?php echo Chtml::label("Jenis Waktu", 'jeniswaktu_id', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->dropDownList($model, 'jeniswaktu_id', CHtml::listData(JeniswaktuM::model()->findAllByAttributes(array('jeniswaktu_aktif' => true)), 'jeniswaktu_id', 'jeniswaktu_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'Jenis Diet', array('class' => 'control-label required')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'menudiet_id', CHtml::listData(MenuDietM::model()->findAllByAttributes(array()), 'menudiet_id', 'menudiet_nama'), array('class' => 'span3', 'empty' => '-- Pilih --')); ?>
                    </div>
                </div>
            </div>
            <?php if($modPesan->jenispesanmenu == Params::JENISPESANMENU_PASIEN){ ?>
            <div class="col-sm-6">
                <div class ="control-group">
                    <?php echo Chtml::label("Nama Pasien", 'nama_pasien', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textField($model, 'nama_pasien', array('class' => 'span3', 'placeholder' => 'Ketik Nama Pasien')); ?>
                    </div>
                </div>
                <div class ="control-group">
                    <?php echo Chtml::label("No Rekam Medis", 'no_rekam_medik', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textField($model, 'no_rekam_medik', array('class' => 'span3', 'placeholder' => 'Ketik Nomor Rekam Medis')); ?>
                    </div>
                </div>
            </div>
            <?php }else{ ?>
            <div class="col-sm-6">
                <div class ="control-group">
                    <?php echo Chtml::label("Nama Pegawai/Tamu", 'nama_pegawai', array('class' => 'control-label')) ?>
                    <div class = "controls">
                        <?php echo $form->textField($model, 'nama_pegawai', array('class' => 'span3', 'placeholder' => 'Ketik Nama Pegawai/Tamu')); ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Tampilkan', array('{icon}' => '')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick'=>'caripemesanan();')); ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
