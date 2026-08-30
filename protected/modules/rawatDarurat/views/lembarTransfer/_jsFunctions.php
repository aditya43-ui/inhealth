<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<script type='text/javascript'>
function viewDetailResep(idReseptur,pendaftaran_id)
{
    $.post('<?php echo $this->createUrl('ajaxDetailResep') ?>', {idReseptur: idReseptur, pendaftaran_id: pendaftaran_id}, function(data){
                $('#contentDetailResep').html(data.result);
        }, 'json');
        $('#dialogDetailresep').dialog('open');
}
    
function printReseptur(caraPrint, idReseptur)
{
    var pendaftaran_id = '<?php echo isset($_GET["pendaftaran_id"]) ? $_GET["pendaftaran_id"] : null ?>';
    window.open('<?php echo $this->createUrl('printReseptur'); ?>&id='+pendaftaran_id+'&idReseptur='+idReseptur+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

</script>

