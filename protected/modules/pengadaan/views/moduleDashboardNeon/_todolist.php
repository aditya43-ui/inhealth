<div id="refresh" class="">
<div class="tile-block" id="todo_tasks">

	<div class="tile-header">
		<a onclick="refreshTodoList();" style="cursor: pointer;"><i class="entypo-arrows-ccw" ></i></a>
		<a href="#">
			Todo List
		</a>
	</div>

	<div class="tile-content">
		<?php $form_todolist=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
			'id'=>'todolist-t-form',
			'enableAjaxValidation'=>false,
				'type'=>'horizontal',
				'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
				'focus'=>'#',
		)); ?>
		<?php echo $form_todolist->hiddenField($modTodolist,'todolist_id',array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

		<?php echo $form_todolist->textField($modTodolist,'todolist_nama',array('style'=>'margin-bottom:10px','class'=>'form-control', 'placeholder'=>'Ketikkan todo list', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

		<?php 

			$modTodolist->tgltodolist_new = date("d/m/Y 00:00:00");
			$this->widget('MyDateTimePicker',array(
									'model'=>$modTodolist,
									'attribute'=>'tgltodolist_new',
									'mode'=>'datetime',
									'options'=> array(
	//                                            'dateFormat'=>Params::DATE_FORMAT,
										'showOn' => false,
										'minDate' => 'd',
										'yearRange'=> "-150:+0",
									),
									'htmlOptions'=>array('placeholder'=>'00/00/0000 00:00:00','class'=>'dtPicker2 form-control datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)",
									),
			));
			?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon}',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),array('class'=>'btn btn-primary pull-right','onclick'=>'simpanTodolist();','onKeyPress'=>'simpanTodolist();')); ?>
		<?php $this->endWidget(); ?>
		<ul class="todo-list" style="margin-top:40px">
		   <?php
			$this->widget('ext.bootstrap.widgets.BootListView',array(
				'dataProvider'=>$dataProviderTodolist,
				'id'=>'listTodolist',
				'template'=>"{items}",
				'itemView'=>$this->path_view.'_todolistView',
				 'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
			)); ?>
		</ul>
	</div>

	<div class="tile-footer">
		<a href="#">View all tasks</a>
	</div>

</div>
</div>
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialog-ubah-todolist',
    'options'=>array(
        'title'=>'Todo List',
        'autoOpen'=>false,
        'width'=>600,
        'resizable'=>false,
    ),
));
?>
<div class="dialog-content">
    <?php echo $this->renderPartial($this->path_view.'_formTodolist', array('modTodolist'=>$modTodolist)); ?>
</div>

<div style="text-align: center;">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Simpan',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn  btn-warning','onclick'=>'updateTodolist();')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Batal',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),array('class'=>'btn btn-danger','onclick'=>'$(\'#dialog-ubah-todolist\').dialog(\'close\')')); ?>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    
	function refreshFormTodolist(){
        $("#<?php echo CHtml::activeId($modTodolist, 'todolist_id'); ?>").val('');
        $("#<?php echo CHtml::activeId($modTodolist, 'todolist_nama'); ?>").val('');
        $("#<?php echo CHtml::activeId($modTodolist, 'tgltodolist_new'); ?>").val('<?php echo date('d/m/Y 00:00:00');?>');
        $("#<?php echo CHtml::activeId($modTodolist, 'todolist_aktif'); ?>").prop('checked', true);
    }

    function setFormTodolist(id){

    $("#dialog-ubah-todolist > .dialog-content").addClass('animation-loading');
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('SetFormTodolist'); ?>',
        data: {todolist_id:id},
        dataType: "json",
        success:function(data){
            // if(data.pesan !== ""){
            //     myAlert(data.pesan);
            // }
            $("#dialog-ubah-todolist > .dialog-content").html(data.form_todolist);
            $("#dialog-ubah-todolist > .dialog-content .dtPicker2").datetimepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'dateFormat':'dd M yy','minDate':'d','timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold','yearRange':'-80y:+20y'}));
            $("#dialog-ubah-todolist > .dialog-content").removeClass('animation-loading');
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    }  

    function simpanTodolist(){
        var nama_todo = $("#<?php echo CHtml::activeId($modTodolist, 'todolist_nama'); ?>").val();
        var tgl_todo = $("#<?php echo CHtml::activeId($modTodolist, 'tgltodolist_new'); ?>").val();
        
        if (nama_todo == '' || tgl_todo == ''){
            alert("Todo list dan tanggal todo list tidak boleh kosong");
            return false;
        }
                
        $("#dialog-ubah-todolist > .dialog-content").addClass('animation-loading');        
        var isi = $('#todolist-t-form').serialize();
        
        
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('SimpanTodolist'); ?>',
            data: {isi:isi},
            dataType: "json",
            success:function(data){
                $("#dialog-ubah-todolist > .dialog-content").html(data.form_todolist);
                $("#dialog-ubah-todolist > .dialog-content").removeClass('animation-loading');
    //            setKalender();
                refreshTodoList();
                // myAlert(data.pesan);
                refreshFormTodolist();
                $('#dialog-ubah-todolist').dialog('close');                
                return true;
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    function updateTodolist(){
        
    $("#dialog-ubah-todolist > .dialog-content").addClass('animation-loading');
    var isi = $('#todolistupdate-t-form').serialize();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('UpdateTodolist'); ?>',
        data: {isi:isi},
        dataType: "json",
        success:function(data){
            $("#dialog-ubah-todolist > .dialog-content").html(data.form_todolist);
            $("#dialog-ubah-todolist > .dialog-content").removeClass('animation-loading');
//            setKalender();
            refreshTodoList();
            // myAlert(data.pesan);
            refreshFormTodolist();
            $('#dialog-ubah-todolist').dialog('close');
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    }

    function HapusTodolist(id) {
        // if (confirm("Apakah anda yakin akan menghapus data ini?")) {
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('HapusTodolist'); ?>',
                data: {todolist_id:id},
                dataType: "json",
                success:function(data){
//                    setKalender();
                    refreshTodoList();
                    // myAlert(data.pesan);
                    return true;
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        
        // } else {
            
        //     return false;
        // }
    }

    function UbahStatusTodolist(id) {
        // if (confirm("Apakah anda yakin akan mengubah status data ini?")) {
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('UbahStatusTodolist'); ?>',
                data: {todolist_id:id},
                dataType: "json",
                success:function(data){
//                    setKalender();
                    refreshTodoList();
                    // myAlert(data.pesan);
                    $('#dialog-ubah-todolist').dialog('close');
                    return true;
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
        
        // } else {
            
        //     return false;
        // }
    }
	/**
	 * refresh by click / setelah input data
	 * @returns {undefined}	 */
	function refreshTodoList(){
                $("#refresh").addClass("animation-loading");
		$.fn.yiiListView.update("listTodolist");
                setTimeout(
                function() 
                {
                  $("#refresh").removeClass("animation-loading");
                }, 500);
                
	}
    
</script>