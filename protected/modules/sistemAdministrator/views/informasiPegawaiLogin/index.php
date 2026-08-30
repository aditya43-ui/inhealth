<?php
$this->breadcrumbs = array(
    'Informasi Pegawai Login',
); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pegawai Login</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
        $('#informasipegawailogin-v-search').submit(function(){
                $.fn.yiiGridView.update('informasipegawailogin-v-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pegawai Login</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial($this->path_view . '_table', array('model' => $model)); ?>
            </div>
        </div>
        <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
        ?>
        <?php
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        //        $this->widget('UserTips',array('type'=>'admin'));
        //           $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        //           $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        //           $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        //$js = <<< JSCRIPT
        //function print(caraPrint)
        //{
        //    window.open("${urlPrint}/"+$('#gumutasibrg-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
        //}
        //JSCRIPT;
        //    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
        ?>
    </div>
</div>