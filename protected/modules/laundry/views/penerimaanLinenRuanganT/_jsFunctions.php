<script type="text/javascript">
function backMenu() {
	if (window.history.length < 3) {
		window.location.href = '<?php echo Yii::app()->createUrl('/laboratorium/RujukanPenunjang/Index'); ?>';
	} else {
		window.history.go(-2);
	}
}
function print(caraPrint)
{
    var penlinenruangan_id = '<?php echo isset($_GET['penlinenruangan_id']) ? $_GET['penlinenruangan_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&penlinenruangan_id='+penlinenruangan_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
</script>