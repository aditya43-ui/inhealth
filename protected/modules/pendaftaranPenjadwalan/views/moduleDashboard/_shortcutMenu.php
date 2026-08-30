<form>
<div class="row">
<?php
	foreach ($modMenu as $menu) {
	    echo '<a href="index.php?r='.$menu->menu_url.'&modul_id=2" class="btn btn-success" style="text-align:left;">
				<i class="'.$menu->menu_icon.' icon-white"></i> <b>'.$menu->menu_nama.'</b>
				</a>';
	}
?>
</div>
<!--<div class="form-actions">
		Tombol
</div>-->
</form>
