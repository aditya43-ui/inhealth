<div class="white-container">
    <legend class="rim2">Laporan Permintaan <b>Pembelian Barang</b></legend>
    <fieldset class="box">
        <legend class="rim"><i class="entypo-search"></i> Pencarian</legend>
        <?php
            $url = Yii::app()->createUrl($this->module->id.'/'.$this->id.'/FramePembelianBarang&id=1');
            Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                    return false;
            });
            $('#laporan-search').submit(function(){
                    $.fn.yiiGridView.update('laporan-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");
        ?>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'action'=>Yii::app()->createUrl($this->route),
                'method'=>'get',
                        'type'=>'horizontal',
                        'id'=>'laporan-search',
        )); ?>
        <div class="row">
             <div class="col-sm-4">
                 <?php echo CHtml::label('Tgl. Permintaan', 'tglpenerimaan', array('class' => 'control-label')) ?>
                 <div class="controls">
                     <?php echo CHtml::hiddenField('type',''); ?>
                     <?php echo $form->dropDownList($model,'jns_periode', array('hari'=>'Hari','bulan'=>'Bulan','tahun'=>'Tahun'), array('class'=>'span2', 'onchange'=>'ubahJnsPeriode();')); ?>
                 </div>
             </div>
             <div class="col-sm-4">
                 <div class='control-group hari'>
                     <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
                     <div class="controls">  
                         <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>                     
                        <?php
                         $this->widget('MyDateTimePicker', array(
                             'model' => $model,
                             'attribute' => 'tgl_awal',
                             'mode' => 'date',
                             'options' => array(
                                 'dateFormat' => Params::DATE_FORMAT,
                                 'maxDate'=>'d',
                             ),
                             'htmlOptions' => array('readonly' => true, 'class' => "span2",
                                 'onkeypress' => "return $(this).focusNextInputField(event)"),
                         ));
                         ?>
                         <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>                     
                     </div> 

                 </div>
                 <div class='control-group bulan'>
                     <?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
                     <div class="controls">
                         <?php $model->bln_awal = $format->formatMonthForUser($model->bln_awal); ?>
                         <?php 
                             $this->widget('MyMonthPicker', array(
                                 'model' => $model,
                                 'attribute' => 'bln_awal', 
                                 'options'=>array(
                                     'dateFormat' => Params::MONTH_FORMAT,
                                 ),
                                 'htmlOptions' => array('readonly' => true,
                                     'class' => "span2",
                                     'onkeypress' => "return $(this).focusNextInputField(event)"),
                             ));  
                         ?>
                         <?php $model->bln_awal = $format->formatMonthForDb($model->bln_awal); ?>
                     </div> 
                 </div>
                 <div class='control-group tahun'>
                     <?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
                     <div class="controls">
                         <?php 
                         echo $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null,null), array('class' => "span2",'onkeypress' => "return $(this).focusNextInputField(event)")); 
                         ?>
                     </div>
                 </div>
             </div>
             <div class="col-sm-4">
                 <div class='control-group hari'>
                     <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                     <div class="controls">  
                         <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                         <?php
                         $this->widget('MyDateTimePicker', array(
                             'model' => $model,
                             'attribute' => 'tgl_akhir',
                             'mode' => 'date',
                             'options' => array(
                                 'dateFormat' => Params::DATE_FORMAT,
                                 'maxDate'=>'d',
                             ),
                             'htmlOptions' => array('readonly' => true,'class' => "span2",
                                 'onkeypress' => "return $(this).focusNextInputField(event)"),
                         ));
                         ?>
                         <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                     </div> 
                 </div>
                 <div class='control-group bulan'>
                     <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                     <div class="controls"> 
                         <?php $model->bln_akhir = $format->formatMonthForUser($model->bln_akhir); ?>
                         <?php 
                             $this->widget('MyMonthPicker', array(
                                 'model' => $model,
                                 'attribute' => 'bln_akhir', 
                                 'options'=>array(
                                     'dateFormat' => Params::MONTH_FORMAT,
                                 ),
                                 'htmlOptions' => array('readonly' => true,'class' => "span2",
                                     'onkeypress' => "return $(this).focusNextInputField(event)"),
                             ));  
                         ?>
                         <?php $model->bln_akhir = $format->formatMonthForDb($model->bln_akhir); ?>
                     </div> 
                 </div>
                 <div class='control-group tahun'>
                     <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                     <div class="controls">
                         <?php 
                         echo $form->dropDownList($model, 'thn_akhir', CustomFunction::getTahun(null,null), array('class' => "span2",'onkeypress' => "return $(this).focusNextInputField(event)")); 
                         ?>
                     </div>
                 </div>
             </div> 
        </div>
        <?php echo $form->dropDownListRow($model,'supplier_id', CHtml::listData(SupplierM::model()->findAll('supplier_aktif = true'), 'supplier_id', 'supplier_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),
                    array('class' => 'btn btn-danger', 'type'=>'submit')); ?>

            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                    Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                    array('class' => 'btn btn-default',
                          'onclick'=>'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.'').'";}); return false;')); ?>
        </div>
    </fieldset>
    <?php
    $this->endWidget();
    ?>
    <div class="block-tabel">
        <h6>Tabel Permintaan <b>Pembelian Barang</b></h6>
        <?php $this->renderPartial('pembelianBarang/_pembelianBarang',array('model'=>$model)); ?>
        <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintPembelianBarang');
        ?>
    </div>
    <div class="block-tabel">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>
        </div>
    <?php $this->renderPartial('_footer_pisah', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
    <?php $this->renderPartial('_jsFunctions', array('model'=>$model));?>
</div>