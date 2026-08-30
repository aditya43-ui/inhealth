<div class="search-form">
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'focus' => '#FAPenjualanResepT_pegawai_id',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
        
        $format = new MyFormatter();
    ?>
    <style>
        #penjamin, #ruangan{
            width:650px;
        }
        #penjamin label.checkbox, #ruangan label.checkbox{
            width: 150px;
            display:inline-block;
        }

    </style>
    <div class="row">
        <div class="col-sm-6">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model,'jns_periode', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'bln_awal', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'bln_akhir', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'thn_awal', array('class'=>'span2')); ?>
                <?php echo $form->hiddenField($model,'thn_akhir', array('class'=>'span2')); ?>
                <?php echo CHtml::label("Periode Laporan",'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>             
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php
                $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'namadokter',
                    'slide' => true,
                    'content' => array(
                        'content2' => array(
                            'multi' => 'multi',
                            'header' => 'Berdasarkan Nama Dokter ',
                            'isi' => CHtml::hiddenField('filter', 'pegawai_id', array('disabled' => 'disabled')) . 
                                '<div class="control-group">
                                    '.CHtml::label('Nama Dokter','pegawai_id', array('class' => 'control-label')).' 
                                    <div class="controls">
                                        '.$form->dropDownList($model, 'pegawai_id', CHtml::listData(DokterV::model()->findAll(array('condition'=>'pegawai_aktif = TRUE'),array('order'=>'nama_pegawai')), 'pegawai_id', 'namaLengkap'),array(
                                        'class'=>'form-control', 'multiple'=>'multiple')).'											
                                    </div>
                                </div>',
                            'active' => true,
                        ),
                    ),
                ));
            ?>             
        </div>                                                   
    </div> 
    <div class="form-actions">
        <?php
            echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
        );
        ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
            Yii::app()->createUrl($this->module->id.'/LaporanFarmasi/LaporanJasaServices&modul_id='.Yii::app()->session['modul_id']), 
            array('class' => 'btn btn-default',
                'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  
        ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); ?> 
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php Yii::app()->clientScript->registerScript('cekAll', '
  $("#big").find("input").attr("checked", "checked");
  $("#kelasPelayanan").find("input").attr("checked", "checked");
', CClientScript::POS_READY); ?>

<?php Yii::app()->clientScript->registerScript('reloadPage', '
    function konfirmasi(){
        window.location.href="'.Yii::app()->createUrl($module.'/'.$controller.'/LaporanPemakaianKategoriObat', array('modul_id'=>Yii::app()->session['modul_id'])).'";
    }', CClientScript::POS_HEAD); ?>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
