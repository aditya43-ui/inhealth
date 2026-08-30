<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'id' => 'pesanambulans-t-search',
            'type' => 'horizontal',
            'focus' => '#' . CHtml::activeId($modPemesanan, 'pesanambulans_no'),
        )); ?>
        <div class="row">
            <div class='col-sm-12'>
                <div class="control-group">
                    <?php echo CHtml::label("Tgl. Pemesanan", '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <div class="daterange daterange-inline input-inline span4" data-format="D MMMM YYYY" data-start-date="<?php echo date('d F Y', strtotime($modPemesanan->tgl_awal)) ?>" data-end-date="<?php echo date('d F Y', strtotime($modPemesanan->tgl_akhir)) ?>">
                            <i class="entypo-calendar"></i>
                            <span><?php echo date('d F Y', strtotime($modPemesanan->tgl_awal)) ?> - <?php echo date('d F Y', strtotime($modPemesanan->tgl_akhir)) ?></span>
                            <?php echo $form->hiddenField($modPemesanan, 'tgl_awal', array('class' => 'start')) ?>
                            <?php echo $form->hiddenField($modPemesanan, 'tgl_akhir', array('class' => 'end')) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-sm-6'>
                <div class="control-group">
                    <label for="namaPasien" class="control-label">No. Pesan Ambulans</label>
                    <div class="controls">
                        <?php echo $form->textField($modPemesanan, 'pesanambulans_no', array('placeholder' => 'No. Pesan Ambulans', 'class' => 'span4', 'maxlength' => 20)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="namaPasien" class="control-label">No. Rekam Medis</label>
                    <div class="controls">
                        <?php echo $form->textField($modPemesanan, 'norekammedis', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4 numbers-only', 'maxlength' => 8)); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">Nama Pasien</label>        
                    <div class="controls">
                        <?php echo $form->textField($modPemesanan,'namapasien',array('placeholder'=>'Nama Pasien','class'=>'span3','maxlength'=>100)); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">Nama Ruang</label>        
                    <div class="controls">
                        <?php echo $form->textField($modPemesanan,'ruangan_nama',array('placeholder'=>'Nama Ruangan','class'=>'span3')); ?>
                    </div>
                </div>
            
    </div>
            </div>
            <div class='col-sm-6'>
                <div class="control-group">
                    <label for="namaPasien" class="control-label">Nama Pasien</label>
                    <div class="controls">
                        <?php echo $form->textField($modPemesanan, 'namapasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'maxlength' => 100)); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="namaPasien" class="control-label">Nama Ruang</label>
                    <div class="controls">
                        <?php echo $form->textField($modPemesanan, 'ruangan_nama', array('placeholder' => 'Nama Ruangan', 'class' => 'span4')); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                )
            ); ?>
            <?php
            $content = $this->renderPartial('../tips/informasi_ambulans', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintInformasiPemesanan');
$js = <<< JSCRIPT
function print(caraPrint)
{
window.open("${urlPrint}/"+$('#pesanambulans-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}   
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>