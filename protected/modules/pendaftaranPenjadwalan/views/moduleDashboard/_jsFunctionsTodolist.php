<script type="text/javascript">
    
    function refreshFormTodolist(){
        $("#<?php echo CHtml::activeId($modTodolist, 'todolist_id'); ?>").val('');
        $("#<?php echo CHtml::activeId($modTodolist, 'todolist_nama'); ?>").val('');
        $("#<?php echo CHtml::activeId($modTodolist, 'tgltodolist'); ?>").val('<?php echo MyFormatter::formatDateTimeForUser(date("Y-m-d"));?>');
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
            setKalender();
            refresh("todolist");
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
            setKalender();
            refresh("todolist");
            // myAlert(data.pesan);
            refreshFormTodolist();
            $('#dialog-ubah-todolist').dialog('close');
            return true;
        },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
    }

    function HapusTodolist(id) {
        // if (confirm("Apakah Anda yakin akan menghapus data ini?")) {
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('HapusTodolist'); ?>',
                data: {todolist_id:id},
                dataType: "json",
                success:function(data){
                    setKalender();
                    refresh("todolist");
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
        // if (confirm("Apakah Anda yakin akan mengubah status data ini?")) {
            $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('UbahStatusTodolist'); ?>',
                data: {todolist_id:id},
                dataType: "json",
                success:function(data){
                    setKalender();
                    refresh("todolist");
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
    

</script>