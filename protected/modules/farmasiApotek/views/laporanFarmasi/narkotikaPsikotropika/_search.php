<div class="search-form">
    <?php
    //$model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
    //$model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'horizontal',
        'id' => 'searchLaporan',
        'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
    ));
    ?>
    <style>
        #penjamin,
        #ruangan {
            width: 650px;
        }

        #penjamin label.checkbox,
        #ruangan label.checkbox {
            width: 150px;
            display: inline-block;
        }
    </style>
    <div class="row">
        <div class="col-sm-6">
            <?php echo CHtml::hiddenField('type', ''); ?>
            <div class="control-group">
                <?php echo $form->hiddenField($model, 'jns_periode', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'bln_akhir', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_awal', array('class' => 'span2')); ?>
                <?php echo $form->hiddenField($model, 'thn_akhir', array('class' => 'span2')); ?>
                <?php echo CHtml::label("Periode Laporan", 'tgl_rekam', array('class' => 'control-label')) ?>
                <div class="controls">
                    <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php
            /*$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'jenisobat',
                    'slide' => true,
                    'content' => array(
                        'content2' => array(
                            'multi' => 'multi',
                            'header' => 'Berdasarkan Jenis Obat',
                            'isi' => CHtml::hiddenField('filter', 'jenisobat', array('disabled' => 'disabled')) . 
                                '<div class="control-group">
                                    '.CHtml::label('Jenis Obat','jenisobatalkes_id', array('class' => 'control-label')).' 
                                    <div class="controls">
                                        '.$form->dropDownList($model, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif = true'), 'jenisobatalkes_id', 'jenisobatalkes_nama'),array(
                                        'class'=>'form-control', 'multiple'=>'multiple')).'											
                                    </div>
                                </div>',
                            'active' => true,
                        ),
                    ),
                ));*/
            ?>
            <div class="control-group">
                <?php echo CHtml::label('Nama Obat', 'jenisobatalkes_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model, 'obatalkes_nama', array(
                        'placeholder' => 'Nama obat',
                        'class' => 'span4'
                    )); ?>
                </div>
            </div>

            <div class="control-group">
                <?php echo CHtml::label('Jenis Obat', 'jenisobatalkes_id', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'jenisobatalkes_id', CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif = true'), 'jenisobatalkes_id', 'jenisobatalkes_nama'), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    )); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <?php
            /*$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'jenisobat',
                    'slide' => true,
                    'content' => array(
                        'content2' => array(
                            'multi' => 'multi',
                            'header' => 'Berdasarkan Golongan',
                            'isi' => CHtml::hiddenField('filter', 'jenisobat', array('disabled' => 'disabled')) . 
                                '<div class="control-group">
                                    '.CHtml::label('Golongan','obatalkes_golongan', array('class' => 'control-label')).' 
                                    <div class="controls">
                                        '.$form->dropDownList($model, 'obatalkes_golongan',   LookupM::getItemsUrutan('obatalkes_golongan'),array(
                                        'class'=>'form-control', 'multiple'=>'multiple')).'											
                                    </div>
                                </div>',
                            'active' => true,
                        ),
                    ),
                ));*/
            $gol_grop = LookupM::model()->findAll("lookup_type = '" . Params::LOOKUPTYPE_OBATALKES_GOLONGAN . "' AND lookup_value IN ('" . Params::OBATALKESPASIEN_GOLONGAN_NARKOTIKA . "', '" . Params::OBATALKESPASIEN_GOLONGAN_PSIKOTROPIKA . "') ");
            ?>
            <div class="control-group">
                <?php echo CHtml::label('Golongan', 'obatalkes_golongan', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'obatalkes_golongan', CHtml::listData($gol_grop, 'lookup_value', 'lookup_name'), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    )); ?>
                </div>
            </div>

            <?php
            /*$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'jenisobat',
                    'slide' => true,
                    'content' => array(
                        'content2' => array(
                            'multi' => 'multi',
                            'header' => 'Berdasarkan Kategori',
                            'isi' => CHtml::hiddenField('filter', 'jenisobat', array('disabled' => 'disabled')) . 
                                '<div class="control-group">
                                    '.CHtml::label('Kategori','obatalkes_kategori', array('class' => 'control-label')).' 
                                    <div class="controls">
                                        '.$form->dropDownList($model, 'obatalkes_kategori',   LookupM::getItemsUrutan('obatalkes_kategori'),array(
                                        'class'=>'form-control', 'multiple'=>'multiple')).'											
                                    </div>
                                </div>',
                            'active' => true,
                        ),
                    ),
                ));*/
            ?>
            <div class="control-group">
                <?php echo CHtml::label('Kategori', 'obatalkes_kategori', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'obatalkes_kategori',   LookupM::getItemsUrutan('obatalkes_kategori'), array(
                        'class' => 'form-control', 'multiple' => 'multiple'
                    )); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
            array('title' => 'Cari', 'autofocus' => true, 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan', 'onKeyUp' => 'return formSubmit(this,event)')
        );
        ?>
        <?php
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)')
        );
        ?>
    </div>
    <?php //$this->widget('UserTips', array('type' => 'create')); 
    ?>
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
        window.location.href="' . Yii::app()->createUrl($module . '/' . $controller . '/LaporanPenjualanJenisoa', array('modul_id' => Yii::app()->session['modul_id'])) . '";
    }', CClientScript::POS_HEAD); ?>
<script>
    function checkAll() {
        if ($('#pilihSemua').is(':checked')) {
            $('#penjamin').each(function() {
                $(this).find('input').attr('checked', true);
            });
        } else {
            $('#penjamin').each(function() {
                $(this).find('input').removeAttr('checked');
            });
        }
    }
    checkAll();
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>