<div class="white-container">
    <legend class="rim2">Pengaturan <b>PTKP</b></legend>
    <?php
    $this->breadcrumbs=array(
            'PTKP Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //    (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' PTKP ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
        // (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' PTKP ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('ptkp-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    $this->renderPartial('_tabMenu',array());
    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="biru">
        <div class="white">
            <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut search-form">
                <?php $this->renderPartial('_search',array(
                        'model'=>$model,
                )); ?>
            </div><!--search-form-->
            
                <!--<h6>Tabel <b>PTKP</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'ptkp-m-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                            array(
                        'name'=>'ptkp_id',
                        'value'=>'$data->ptkp_id',
                        'filter'=>false,
                    ),
                            'tglberlaku',
                            'statusperkawinan',
                            'jmltanggunan',
                            'wajibpajak_thn',
                    'wajibpajak_bln', 
                    array(
                        'header'=>'Aktif',
                        'value'=>'($data->berlaku)?"aktif":"non aktif"',
                        'filter'=>false,
                    ),
                    // array(
                    //     'header'=>'Aktif',
                    //     'class'=>'CCheckBoxColumn',
                    //     'id'=>'rows',
                    //     'selectableRows'=>0,
                    //     'checked'=>'$data->berlaku',
                    // ),
                            array(
                        'header'=>Yii::t('zii','View'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                            ),
                            array(
                        'header'=>Yii::t('zii','Update'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update' => array (
                              'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                            ),
                        ),
                            ),
                            array(
                        'header'=>Yii::t('zii','Delete'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{delete}',
                        'buttons'=>array(
                            'delete'=> array(
                                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
                            ),
                        )
                            ),
                    ),
               'afterAjaxUpdate'=>'function(id, data){
                        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                        $("table").find("input[type=text]").each(function(){
                            cekForm(this);
                        })
                        $("table").find("select").each(function(){
                            cekForm(this);
                        })
                    }',
                )); ?>
            <!--</div>-->
        </div>
    </div>
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah PTKP', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    $content = $this->renderPartial('../tips/master',array(),true); 
    $this->widget('UserTips',array('type'=>'admin','content'=>$content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#ptkp-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#ptkp-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">

    $(document).ready(function(){
        $("input[name='KPPtkpM[tglberlaku]']").focus();
    })
</script>