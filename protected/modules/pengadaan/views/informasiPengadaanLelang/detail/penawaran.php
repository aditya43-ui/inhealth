<?php
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sabarang-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)'), //return cekNomorReg();
        ));
?>
<table class="table table-bordered table-striped table-condensed" id="tabelPenawaran">
    <thead>
        <tr>
            <th> No. </th>
            <th> No. </th>
            <th> Nomor Penyedia </th>
            <th> Penyedia </th>
            <th> Total Persiapan Pengadaan </th>
            <th> File Penawaran </th>
            <th> Keterangan </th>
            <th> Penilaian </th>
            <th> Hasil </th>
            <th> Alasan </th>
            <th> Undangan </th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
<?php echo "&nbsp;".CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl('penawaran&id='.$model->persiapanpengadaan_id), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);')); ?>
<?php $this->endWidget(); ?>

<script>
    function setDokumen(){
        var id = '<?php echo $_GET['id']?>';
        $("#tabelPenawaran").addClass("animation-loading");
        $('#tabelPenawaran > tbody').html("");
        $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('GetDokumen'); ?>',
                data: {
                    id: id, 
                },//
                dataType: "json",
                success:function(data){
                        $('#tabelPenawaran > tbody').append(data.form);
                        jQuery('<?php  echo Params::TOOLTIP_SELECTOR; ?>').tooltip({"placement":"<?php echo Params::TOOLTIP_PLACEMENT; ?>"});
                        renameInputRow($("#tabelPenawaran"));
                        $("#tabelPenawaran").removeClass("animation-loading");
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }   
    
    function renameInputRow(obj_table){
            var row = 0;
            $(obj_table).find("tbody > tr").each(function(){
                    $(this).find('span').each(function(){ //element <input>
                            var old_name = $(this).attr("name").replace(/]/g,"");
                            var old_name_arr = old_name.split("[");
                            if(old_name_arr.length == 3){
                                    $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
                            }
                    });
                    $(this).find('input,select,textarea').each(function(){ //element <input>
                            var old_name = $(this).attr("name").replace(/]/g,"");
                            var old_name_arr = old_name.split("[");
                            if(old_name_arr.length == 3){
                                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                            }
                    });
                    row++;
            });

	}
    $(document).ready(function(){
        setDokumen();
    });
</script>
    