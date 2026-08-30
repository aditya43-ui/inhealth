<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <div class="search-form">
            <?php
            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'action' => Yii::app()->createUrl($this->route),
                'method' => 'get',
                'type' => 'horizontal',
                'id' => 'searchLaporan',
                'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'),
            ));
            ?>

            <style>
                .form-horizontal .radio>label,
                .form-horizontal .checkbox>label {
                    float: left !important;
                    margin-left: 5px !important;
                    padding: 0 !important;
                }
        
                .form-horizontal .radio>input,
                .form-horizontal .checkbox>input {
                    float: left !important;
                    margin-top: 2px !important;
                }
            </style>
        
            <div class="row">
                <div class="col-sm-6">
                    <?php //$format = new MyFormatter(); 
                    ?>
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
                    <div class="control-group">
                        <label class="control-label">Filter</label>
                        <div class="controls">
                            <?php echo $form->checkBoxList($model, 'kunjungan', LookupM::getItems('kunjungan'), array('value' => 'pengunjung',  'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->hiddenField($model, 'pilihan', array('value' => 'instalasi', 'disabled' => 'disabled')); ?>
                        <label class="control-label">Instalasi Asal</label>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($model, 'instalasiasal_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true'), 'instalasi_id', 'instalasi_nama'), array(
                                'class' => 'span4', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'ajax' => array(
                                    'type' => 'POST',
                                    'url' => Yii::app()->createUrl('ActionDynamic/GetRuanganAsalForCheckBox', array('encode' => false, 'namaModel' => '' . $model->getNamaModel() . '')),
                                    'update' => '.ruangan',  //selector to update
                                )
                            ));
                            ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Ruangan</label>
                        <div class="controls">
                            <label> data tidak ditemukan</label>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                </div>
            </div>

            <div class="form-actions">
                <?php
                echo CHtml::htmlButton(
                    Yii::t(
                        'mds',
                        '{icon} Search',
                        array('{icon}' => '<i class="entypo-search"></i>')
                    ),
                    array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit', 'id' => 'btn_simpan')
                );
                ?>
                <?php
                echo CHtml::link(
                    Yii::t(
                        'mds',
                        '{icon} Ulang',
                        array('{icon}' => '<i class="entypo-arrows-ccw"></i>')
                    ),
                    Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id . ''),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
                    )
                );
                ?>
            </div>
            <?php //$this->widget('UserTips', array('type' => 'create')); 
            ?>
        </div>
    </div>
</div>
<?php
$this->endWidget();
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRJ', array('pendaftaran_id' => ''));
?>

<?php //Yii::app()->clientScript->registerScript('onclickButton','
//  var tampilGrafik = "<div class=\"tampilGrafik\" style=\"display:inline-block\"> <i class=\"icon-arrow-right icon-white\"></i> Grafik</div>";
//  $(".accordion-heading a.accordion-toggle").click(function(){
//            $(this).parents(".accordion").find("div.tampilGrafik").remove();
//            $(this).parents(".accordion-group").has(".accordion-body.in").length ? "" : $(this).append(tampilGrafik);
//            
//            
//  });
//',  CClientScript::POS_READY);
?>