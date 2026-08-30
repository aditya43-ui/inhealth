<div class="white-container">
    <legend class='rim2'>Master <b>Konfigurasi Anggaran</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Agkonfiganggaran Ks'=>array('index'),
            'Manage',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('agkonfiganggaran-k-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form">
        <?php $this->renderPartial($this->path_view.'_search',array(
                'model'=>$model,'format'=>$format,
        )); ?>
    </div><!--search-form-->
    
        <!--<h6>Tabel <b>Periode Anggaran</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'agkonfiganggaran-k-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                            'header'=>'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                            : ($row+1)',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:center; width:5px;'),
                    ),
                    array(
                            'header'=>'Periode Anggaran',
                            'name' => 'tglanggaran',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tglanggaran)',
                            'filter' => $this->widget('MyDateTimePicker', array(
                                    'model'=>$model, 
                                    'attribute'=>'tglanggaran', 
                                    'mode' => 'date',                                        
                                    'htmlOptions' => array(
                                        'id' => 'datepicker_for_due_date',
                                        'size' => '10',
                                        'style'=>'width:80%'
                                    ),
                                    'options' => array(  // (#3)                    
                                        'dateFormat' => Params::DATE_FORMAT,                    
                                        'maxDate' => 'd',
                                    ),                                   
                                ), 
                                true),
                    ),
                    array(
                            'header'=>'Sampai Dengan',
                            'name' => 'sd_tglanggaran',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->sd_tglanggaran)',
                            'filter' => $this->widget('MyDateTimePicker', array(
                                    'model'=>$model, 
                                    'attribute'=>'sd_tglanggaran', 
                                    'mode' => 'date',                                        
                                    'htmlOptions' => array(
                                        'id' => 'datepicker_for_due_date1',
                                        'size' => '10',
                                        'style'=>'width:80%'
                                    ),
                                    'options' => array(  // (#3)                    
                                        'dateFormat' => Params::DATE_FORMAT,                    
                                        'maxDate' => 'd',
                                    ),                                   
                                ), 
                                true),
                    ),
                    'deskripsiperiode',
                    array(
                            'header'=>'Status Closing',
                            'type'=>'raw',
                            'value'=>'(($data->isclosing_anggaran) ? "Closing" : "Tidak Closing")',
                    ),
                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                    'view' => array(),
                             ),
                    ),
                    array(
                            'header'=>Yii::t('zii','Update'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(
                                    'update' => array(),
                             ),
                    ),
            array(
                'header'=>'Hapus',
                'type'=>'raw',
                'value'=>'($data->isclosing_anggaran)?CHtml::link("<i class=\'icon-form-check\'></i> ","javascript:nonActive($data->konfiganggaran_id)",array("id"=>"$data->konfiganggaran_id","rel"=>"tooltip","title"=>"Klik untuk membuka anggaran"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->konfiganggaran_id)",array("id"=>"$data->konfiganggaran_id","rel"=>"tooltip","title"=>"Klik untuk menghapus periode anggaran")):CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:active($data->konfiganggaran_id)",array("id"=>"$data->konfiganggaran_id","rel"=>"tooltip","title"=>"Klik untuk closing anggaran"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->konfiganggaran_id)",array("id"=>"$data->konfiganggaran_id","rel"=>"tooltip","title"=>"klik untuk menghapus periode anggaran"));',
                'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
            ),
            ),
             'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                reinstallDatePicker();                    
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                });
                $("table").find("select").each(function(){
                    cekForm(this);
                });
            }',
        )); ?>
    <!--</div>-->
    <?php 
    echo CHtml::link(Yii::t('mds','{icon} Tambah Konfigurasi Anggaran',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    $tips = array(
        '0' => 'tanggal',
        '1' => 'lihat',
        '2' => 'ubah',
        '3' => 'closing',
        '4' => 'hapus',
        '5' => 'bukaclosing',        
        '6' => 'masterPRINT',
        '7' => 'masterEXCEL',
        '8' => 'masterPDF',
        '9' => 'pencarianlanjut',
        '10' => 'cari',
        '11' => 'masterUlang',
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    $urlPrint= $this->createUrl('print');
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#agkonfiganggaran-k-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#agkonfiganggaran-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD); 
Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {        
$('#datepicker_for_due_date').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::DATE_FORMAT."','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
$('#datepicker_for_due_date1').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::DATE_FORMAT."','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
}
");
    ?>
</div>
<script type="text/javascript">	
	function deleteRecord(id){
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm("Yakin Akan Menghapus Data ini?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('agkonfiganggaran-k-grid');
                            }else{
                                myAlert('Data gagal dihapus!')
                            }
                },"json");
           }
       });
    }
	function nonActive(id){
        var url = '<?php echo $url."/nonActive"; ?>';
		myConfirm("Anda yakin akan membuka anggaran ini untuk sementara?","Perhatian!",
			function(r){
			if(r){ 
				$.post(url, {id: id},
				 function(data){
					if(data.status == 'proses_form'){
							$.fn.yiiGridView.update('agkonfiganggaran-k-grid');
						}else{
							myAlert('Data gagal dinonaktifkan!')
						}
				},"json");
			}
		});
	}
	function active(id){
        var url = '<?php echo $url."/active"; ?>';
		myConfirm("Anda yakin akan closing anggaran ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('agkonfiganggaran-k-grid');
                            }else{
                                myAlert('Data Gagal di Aktifkan')
                            }
					},"json");
				}
			}
		);
	}
</script>