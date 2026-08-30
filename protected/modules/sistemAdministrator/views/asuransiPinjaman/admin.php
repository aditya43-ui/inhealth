<div class="white-container">
    <legend class="rim2">Pengaturan <b>Asuransi Pinjaman</b></legend>
    <?php
  

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sapremiasuransi-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form">
        <?php $this->renderPartial($this->path_view.'_search',array(
                'model'=>$model,
        )); ?>
    </div><!--search-form-->
    
        <!--<h6>Tabel <b>Asal Aset</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'sapremiasuransi-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    ////'asalaset_id',
                    array(
                        'header'=>'ID',
                        'name'=>'premiasuransi_id',
                        'filter'=>false,
                    ),
                    array(
                        'header'=>'Umur',
                        'name'=>'umur',
                        'filter'=>Chtml::activeTextField($model, 'umur', array('class' => 'numbers-only', 'style'=>'text-align:right;')),
                        'htmlOptions' => array('style' => 'text-align: right;'),
                    ),
                    array(
                        'header'=>'Tahun',
                        'name'=>'tahun',
                        'filter'=>Chtml::activeTextField($model, 'tahun', array('class' => 'numbers-only', 'style'=>'text-align:right;')),
                        'htmlOptions' => array('style' => 'text-align: right;'),
                    ),                    
                    array(
                        'header'=>'Persen',
                        'name'=>'persen',
                        'value' => 'str_replace(".",",",$data->persen);',
                        'filter'=>Chtml::activeTextField($model, 'persen', array('class' => 'comadesimal-only', 'style'=>'text-align:right;')),
                        'htmlOptions' => array('style' => 'text-align: right;'),
                    ),  
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
                        'header'=>'Hapus',
                        'type'=>'raw',
                        //'value'=>'($data->asalaset_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->asalaset_id)",array("id"=>"$data->asalaset_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->asalaset_id)",array("id"=>"$data->asalaset_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->asalaset_id)",array("id"=>"$data->asalaset_id","rel"=>"tooltip","title"=>"Hapus"));',
                        'value'=>'CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->premiasuransi_id)",array("id"=>"$data->premiasuransi_id","rel"=>"tooltip","title"=>"Hapus"))',
                        'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                });
                 $("table").find("select").each(function(){
                    cekForm(this);
                });
                $(".numbers-only").keyup(function(){
                    setNumbersOnly(this);
                });
                $(".comadesimal-only").keypress(function(event) {
                    if ((event.keyCode != 37) && (event.keyCode != 39) && (event.which != 8) && (event.which != 44) && ((event.which < 48) || (event.which > 57))  )   
                    {        
                        event.preventDefault();
                    }

                    if(event.which == 44 && $(this).val().indexOf(",") != -1) {
                        event.preventDefault();
                    }
                }); 
            }',
        )); ?>
    <!--</div>-->
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Asuransi Pinjaman', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    
    $tips = array(
        '0' => 'cari',        
        '1' => 'pencarianlanjut',
        '2' => 'ubah',
        '3' => 'lihat',
        '4' => 'hapus',
        '5' => 'masterPDF',
        '6' => 'masterEXCEL',
        '7' => 'masterPRINT',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips' => $tips),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url= Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#sapremiasuransi-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sapremiasuransi-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">
    
    
    function deleteRecord(id){
        var id = id;
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm("Apakah Anda yakin ingin menghapus data ini?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('sapremiasuransi-m-grid');
                                myAlert('Data berhasil dihapus');
                            }else{
                                myAlert('Data gagal dihapus!');
                            }
                },"json");
           }
	   });
    }
   
</script>