<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
    </div>
    <div class="panel-body">
    <div class="search-form" style="">
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
            table{
                margin-bottom: 0px;
            }
            .form-actions{
                padding:4px;
                margin-top:5px;
            }
            .nav-tabs>li>a{display:block; cursor:pointer;}
            .nav-tabs > .active a:hover{cursor:pointer;}
             #jeniss label.checkbox, .ruangan span label.checkbox{
                width: 150px;
                display:inline-block;
            }
        </style>
            <table width="100%">
                <tr>
                    <td>
                        <div class="col-sm-12">                            
                           <?php //$format = new MyFormatter(); ?>
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
                        <span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div> </div>
                        <div class="col-sm-6">
                        <div id='searching'>
                        
                            <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                                        'id'=>'big',
    //                                    'parent'=>false,
    //                                    'disabled'=>true,
    //                                    'accordion'=>false, //default
                                        'content'=>array(
                                            'content1'=>array(
                                                'header'=>'Berdasarkan Instalasi Asal',
                                                'isi'=>'<table id="jeniss"><tr><td>'.$form->hiddenField($model, 'pilihan', array('value'=>'instalasi','disabled'=>'disabled'))
                                                .'<label>Instalasi</label></td><td>'
                                                    .$form->dropDownList($model, 'instalasiasal_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                                'ajax' => array('type' => 'POST',
                                                                    'url' => Yii::app()->createUrl('ActionDynamic/GetRuanganAsalForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                                                    'update' => '.ruangan',  //selector to update
                                                                )
                                                        ))
                                                .'</td></tr><tr><td><label>Ruangan</label></td><td>
                                                    <div class="ruangan"><label>data tidak ditemukan</label></div>
                                                    </td></tr></table>',
                                                'active'=>true,
                                                ),
                                            'content2'=>array(
                                                'header'=>'Berdasarkan Jenis Penjamin',
                                                'isi'=>'<table><tr>
                                                            <td>'.$form->hiddenField($model, 'pilihan', array('value'=>'carabayar','disabled'=>'disabled')).'<label>Jenis Penjamin</label></td>
                                                            <td>'.$form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                                'ajax' => array('type' => 'POST',
                                                                    'url' => Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                                                    'update' => '#'.CHtml::activeId($model, 'penjamin_id').'',  //selector to update
                                                                ),
                                                            )).'</td>
                                                                </tr><tr>
                                                            <td><label>Penjamin</label></td><td>'.
                                                            $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)).'</td></tr></table>',            
                                                'active'=>false,
                                                ),
                                        ),
    //                                    'htmlOptions'=>array('class'=>'aw',)
                                )); ?>
                        
                            </div>
                        </div>
                    
                        <div class="col-sm-6">
                        <div id='searching'>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="panel-title">Grafik Kunjungan</div>
                                </div>
                                <div class="panel-body">
                                <?php echo '<table>
                                                                <tr>
                                                                <td>'.
                                                                $form->checkBoxList($model, 'kunjungan', LookupM::getItems('kunjungan'), array('value'=>'pengunjung',  'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")).'</td></tr></table>'; ?>
                                </div>
                            </div>
                        </div>
                        </div>
                    </td>
                </tr>
            </table>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
            ?>
                    <?php
     echo CHtml::htmlButton(Yii::t('mds','{icon} Ualng',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                                                                            array('class'=>'btn btn-danger','onclick'=>'konfirmasi()','onKeypress'=>'return formSubmit(this,event)'));
    ?> 
        </div>
        <?php //$this->widget('UserTips', array('type' => 'create')); ?>    
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
