<?php

Yii::app()->clientScript->registerScript('search', "
    $('#corectivemaintenance-r-search').submit(function(){
        $.fn.yiiGridView.update('corectivemaintenance-r-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");

$this->widget('bootstrap.widgets.BootAlert');

?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-info-circled"></i> Pemeliharaan Aset <strong>Corrective Maintenance</strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-credit-card"></i> Corrective Maintenance</div>
                    </div>
                    <div class="panel-body overflow-x" >                            
                        <?php
                        $this->renderPartial($this->path_view.'grid._grid_informasi',['model'=>$model]);
                        ?>                            
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="">
                            <?php $this->renderPartial($this->path_view.'_search',array(
                                    'model'=>$model,
                            )); ?>
                        </fieldset>
                    </div>
                </div>								
            </div>
        </div>
    </div>
</div>        
<?php
echo '<div class="hide">';
$this->widget('ext.select2.ESelect2', array(
        'name'=>'name',       
        'data' => [],
        'options' => array(
                'placeholder' =>'-- Pilih --',
                'allowClear' => true,
            'class' => 'merk_id'
        ),
));
echo "</div>";
echo $this->renderPartial($this->path_view.'_dialog',['model'=>$model],true);

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
$url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

?>
<?php
   //======================= form monitoring ======================= 
       $this->beginWidget('zii.widgets.jui.CJuiDialog',
           array(
               'id'=>'dialogPemeliharaan',
               'options'=>array(
                   'title'=>'Pemeliharaan Aset',
                   'autoOpen' => false,
                   'modal' => true,
                   'width' => 900,
                   'height' => 400,
                   'resizable' => false,
               ),
           )
       );
       echo CHtml::hiddenField('temp_dialogPemeliharaan','',array('readonly'=>true));
       echo '<div class="divForFormdialogPemeliharaan"></div>';
       $this->endWidget('zii.widgets.jui.CJuiDialog');
       // end
?>

<?php   
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogPending',
            'options'=>array(
                'title'=>'Corrective Maintenance - Pending',
                'autoOpen' => false,
                'modal' => true,
                'width' => 700,
                'height' => 300,
                'resizable' => false,
            ),
        )
    );
    echo '<div class="form-pending"></div>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');       
?>

<script type="text/javascript">
    
    var setTeknisiForm = (obj) => {
        
        let id = $(obj).data('id');
        let url = $(obj).data('url');
        
        $("#dialogSetTeknisi").dialog("open");
        
        $.ajax({
            type:'GET',
            url:url,
            data: {
                id:id
            },
            dataType: "json",
            success:function(data){
                    $("#form-set-teknisi").html(data);                    
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        }); 
        
        
    }
    
    var refreshInformasi = () => {
        $.fn.yiiGridView.update('corectivemaintenance-r-grid',{
            data:$("#corectivemaintenance-r-search").serialize()
        });
    }
    
     function setStatus(id, status) {
          var korektifmainten_id = id;
          myConfirm('Ubah Status menjadi '+status+' ?','Perhatian!',function(r){
            if (r){
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('setStatus'); ?>',
                data: {korektifmainten_id:korektifmainten_id},
                dataType: "json",
                    success:function(data){
                        if(data.status == true){
                             refreshInformasi();
                        }else{
                            myAlert(data.pesan);	
                        }	
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	    }); 
            }
            });
    }  
     function setdialogPemeliharaanaset(id) {
     
        $('#temp_dialogPemeliharaan').val(id);
         jQuery.ajax({'url':'<?php echo $this->createUrl('insertPemeliharaanAset')?>&id='+id,
        'data':$(this).serialize(),
        'type':'post',
        'dataType':'json',
        'success':function(data){
            if (data.status == 'create_form') {
                $('#dialogPemeliharaan div.divForFormdialogPemeliharaan').html(data.div);
                $('#dialogPemeliharaan div.divForFormdialogPemeliharaan form').submit(setdialogPemeliharaanaset);
            }else{
                $('#dialogPemeliharaan div.divForFormdialogPemeliharaan').html(data.div);
                $('#dialogPemeliharaan').dialog('close');
                refreshInformasi();
            }
        },
        'cache':false
    });
    return false; 
    } 
    
    function simpanPending(id, jenis) {
             
        if (jenis == 'simpan'){
            if (!requiredCheck($("#pending-form"))){
                return false;
            }
        }
             
             
        jQuery.ajax({
            'url':'<?php echo $this->createUrl('simpanPending')?>',
            'data':{
                id:id,
                formdata:$("#pending-form").serialize(),
                jenis:jenis
            },
            'type':'post',
            'dataType':'json',
            'success':function(data){
               if (data.status == 'load') {
                   $(".form-pending").html(data.form);
               }else{
                   if (data.sukses == 1){
                       toastr.success(data.pesan,'Perhatian!');
                       $("#dialogPending").dialog("close");
                       refreshInformasi();
                   }else{
                       toastr.error(data.pesan,'Perhatian!');
                   }
               }
            },            
       });
    return false; 
    } 
    
    function konfirmasi(id) {
        myConfirm('Ubah Status menjadi Finish ?','Perhatian!',function(r){
            if (r){
             setdialogPemeliharaanaset(id); $('#dialogPemeliharaan').dialog('open'); return false; 
            }
        }); 
    }
    
    function pending(id) {
        myConfirm('Ubah Status menjadi Pending ?','Perhatian!',function(r){
            if (r){
                simpanPending(id,'load');
                $('#dialogPending').dialog('open'); 
                return false; 
            }
        }); 
    }
</script>
