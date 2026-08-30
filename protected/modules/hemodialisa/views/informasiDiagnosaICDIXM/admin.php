<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Informasi Diagnosa <b>ICD IX</b></div>
    </div>
    <div class="panel-body">

        <?php
        $this->breadcrumbs = array(
            'Sadiagnosa Icdixms' => array('index'),
            'Manage',
        );
        $arrMenu = array();
        //            (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa ICD IX ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' HDDiagnosaicdixM', 'icon'=>'list', 'url'=>array('index'))) ;
        //(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Diagnosa ICD IX', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
        $this->menu = $arrMenu;
        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sadiagnosa-icdixm-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn')); 
        ?>
        <?php $this->renderPartial('_search', array(
            'model' => $model,
        )); ?>
        <?php
        // 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
        //        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
        //        $this->widget('UserTips',array('type'=>'admin'));
        //        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        //        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        //        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        //
        //$js = <<< JSCRIPT
        //function print(caraPrint)
        //{
        //    window.open("${urlPrint}/"+$('#sadiagnosa-icdixm-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
        //}
        //JSCRIPT;
        //Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
        //
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Diagnosa ICD IX</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_tableDiagnosa', array(
                    'model' => $model,
                )); ?>
            </div>
        </div>
    </div>
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Pencarian</div>
        </div>
        <div class="panel-body">
            <?php $this->renderPartial('_search', array(
                'model' => $model,
            )); ?>
        </div>
    </div>
    <?php
    // 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    //        $this->widget('UserTips',array('type'=>'admin'));
    //        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    //        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    //        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    //
    //$js = <<< JSCRIPT
    //function print(caraPrint)
    //{
    //    window.open("${urlPrint}/"+$('#sadiagnosa-icdixm-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    //}
    //JSCRIPT;
    //Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    //
    ?>
</div>