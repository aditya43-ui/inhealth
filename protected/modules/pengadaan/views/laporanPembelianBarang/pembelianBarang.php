<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Laporan Permintaan <b>Pembelian Barang</b></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
            </div>
            <div class="panel-body">
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
                
                <div class="row-fluid">
                    <div class="span6">
                        <div class="control-group">
                               <?php echo $form->hiddenField($model,'jns_periode', array('class'=>'span2')); ?>
                               <?php echo $form->hiddenField($model,'bln_awal', array('class'=>'span2')); ?>
                               <?php echo $form->hiddenField($model,'bln_akhir', array('class'=>'span2')); ?>
                               <?php echo $form->hiddenField($model,'thn_awal', array('class'=>'span2')); ?>
                               <?php echo $form->hiddenField($model,'thn_akhir', array('class'=>'span2')); ?>
                               <?php echo CHtml::label('Tanggal Permintaan', 'tglpenerimaan', array('class' => 'control-label')) ?>
                               <div class="controls">
                                       <div class="daterange daterange-inline add-ranges input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                                               <i class="entypo-calendar"></i>
                                               <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                                               <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                                               <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                                       </div>
                               </div>
                       </div>
                    </div>
                   <div class="span6">
                       <?php echo $form->dropDownListRow($model,'supplier_id', CHtml::listData(SupplierM::model()->findAll('supplier_aktif = true'), 'supplier_id', 'supplier_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
                   </div>

                   <div class="clear"></div>
               <div class="form-actions">
                   <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),
                           array('class'=>'btn btn-primary', 'type'=>'submit')); ?>

                   <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                           Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                           array('class'=>'btn btn-danger',
                                 'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "'.Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.'').'";}); return false;'));  ?>
               </div>
                   <?php
                    $this->endWidget();
                    ?>
            </div>
        </div>                        
    </div>
    
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Tabel Permintaan <b>Pembelian Barang</div>
        </div>
        <div class="panel-body">
            <?php $this->renderPartial('_pembelianBarang',array('model'=>$model)); ?>
            <?php 
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintPembelianBarang');
            ?>
        </div>
    </div>
        <br/>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Grafik</div>
        </div>
        <div class="panel-body">
            <?php $this->renderPartial('_tab'); ?>
            <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
            </iframe>
        </div>
    </div>
    <?php $this->renderPartial('_footer_pisah', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
    </div>
    <?php $this->renderPartial('_jsFunctions', array('model'=>$model));?>
</div>