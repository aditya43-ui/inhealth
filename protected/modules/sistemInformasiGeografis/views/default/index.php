<div class="new-container">
    <div class="dashboard">
	<div class="block">
		<h6>Sistem Informasi Geografis (SIG)</h6>
                <?php 
                $menus = $this->module->menu;
                foreach($menus AS $i => $menu){
                    if($menu->kelmenu_id == Params::KELMENU_ID_DASHBOARD){
                        echo "<a href=".Yii::app()->createUrl($menu->menu_url,array('modul_id'=>$menu->modul_id))." class='shortcut2'>";
                        echo "<img alt='' src='".Params::urlIconModulDirectory().(empty($menu->menu_icon) ? $menu->modulk->icon_modul: $menu->menu_icon)."'>";
                        echo "$menu->menu_namalainnya</a>";
                    }
                } ?>
	</div>
    </div>
</div>