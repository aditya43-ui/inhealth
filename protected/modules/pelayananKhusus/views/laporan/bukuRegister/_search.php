<?php
/**
 * untuk menampilkan form pencarian
 * 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
?>
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
    </style>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Pencarian</div>
        </div>
        <div class="panel-body">
            <div class="row-fluid">
                <div class="col-sm-6">
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
                    </div>   
                </div>
            </div> 
            <div class="row-fluid">
                <div class="col-sm-6">
                    <div id='searching'>
                        <?php
                        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                            'id' => 'wilayah',
                            //                                    'disabled'=>true,
                            'content' => array(
                                'content1' => array(
                                    'multi' => 'multi',
                                    'header' => 'Berdasarkan Wilayah',
                                    'isi' => CHtml::hiddenField('filter', 'wilayah') .
                                    '<div class="control-group">
                                                                                ' . CHtml::label('Propinsi', 'carabayar_id', array('class' => 'control-label')) . ' 
                                                                                <div class="controls">
                                                                                        ' . $form->dropDownList($model, 'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), array(
                                        'class' => 'form-control', 'multiple' => 'multiple')) . '											
                                                                                </div>
                                                                        </div>
                                                                        <div class="control-group">
                                                                                ' . CHtml::label('Kabupaten', 'penjamin_id', array('class' => 'control-label')) . ' 
                                                                                <div class="controls">												 
                                                                                        ' . $form->dropDownList($model, 'kabupaten_id', array(), array('class' => 'form-control', 'multiple' => 'multiple')) . ' 													
                                                                                </div>
                                                                        </div>',
                                    'active' => true,
                                ),),
                                //                                    'htmlOptions'=>array('class'=>'aw',)
                        ));
                        ?>			
                    </div> 
                </div>
                <div class="col-sm-6">
                    <div id='searching'>			
<?php
$this->Widget('ext.bootstrap.widgets.BootAccordion', array(
    'id' => 'carabayar',
    'slide' => true,
    'content' => array(
        'content2' => array(
            'multi' => 'multi',
            'header' => 'Berdasarkan Jenis Penjamin',
            'isi' => CHtml::hiddenField('filter', 'carabayar', array('disabled' => 'disabled')) .
            '<div class="control-group">
                                                                        ' . CHtml::label('Jenis Penjamin', 'carabayar_id', array('class' => 'control-label')) . ' 
                                                                        <div class="controls">
                                                                                ' . $form->dropDownList($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array(
                'class' => 'form-control', 'multiple' => 'multiple')) . '											
                                                                        </div>
                                                                </div>
                                                                <div class="control-group">
                                                                        ' . CHtml::label('Penjamin', 'penjamin_id', array('class' => 'control-label')) . ' 
                                                                        <div class="controls">												 
                                                                                ' . $form->dropDownList($model, 'penjamin_id', array(), array('class' => 'form-control', 'multiple' => 'multiple')) . ' 													
                                                                        </div>
                                                                </div>',
            'active' => true,
        ),
    ),
        //                                    'htmlOptions'=>array('class'=>'aw',)
));
?>	
                    </div> 
                </div>
            </div>
            <div class="form-actions">
<?php
echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="'.MyIcon::getIcons('cari').'"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan'));
?>
                <?php
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="'.MyIcon::getIcons('ulang').'"></i>')), array('class' => 'btn btn-danger', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)'));
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

<?php echo $this->renderPartial('_jsFunctions',array('model'=>$model)); ?>
