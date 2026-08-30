<script type="text/javascript">
    function resetForm(){
        window.open("<?php echo $this->createUrl("/".$this->route); ?>", "_self");
    }
    function searchForm(){
        $('#informasiclosingkasir-m-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasiclosingkasir-m-grid', {
		data: $(this).serialize()
	});
	return false;
    }
</script>

