<script type="text/javascript">

function changeJenisInput(obj){
    var jenispenginputan = $(obj).val();
    var pendaftaran_id = $('#<?php echo CHtml::activeId($model,'pendaftaran_id');?>').val();
    if(jenispenginputan != ''){
      $.ajax({
          type:'POST',
          url:'<?php echo $this->createUrl('LoadJenisPenginputan'); ?>',
          data: {pendaftaran_id:pendaftaran_id, jenispenginputan: jenispenginputan},
          dataType: "json",
          success:function(data){
            $('#<?php echo CHtml::activeId($model,'situation');?>').parent().find(".redactor_frame").contents().find("body #page").html(data.situation);
            $("#<?php echo CHtml::activeId($model, 'situation')?>").val(data.situation);
            $('#<?php echo CHtml::activeId($model,'background');?>').parent().find(".redactor_frame").contents().find("body #page").html(data.background);
            $("#<?php echo CHtml::activeId($model, 'background')?>").val(data.background);
            $('#<?php echo CHtml::activeId($model,'assesmen');?>').parent().find(".redactor_frame").contents().find("body #page").html(data.asesmen);
            $("#<?php echo CHtml::activeId($model, 'assesmen')?>").val(data.asesmen);
          },
          error: function (jqXHR, textStatus, errorThrown) {
              myAlert("Data tidak ditemukan !");
              console.log(errorThrown);
          }
      });
    }
}
</script>
