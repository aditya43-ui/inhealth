<?php

class MenuModul 
{
    /**
     * menampilkan menumodule_k menjadi array untuk extension menu
     * @param type $menuModuls
     * @return array
     */
    public static function getMenuModul($menuModuls)
    {
        $menus = array();
        $result = array();
        $tempKelId = '';
        $j = 0;
        if(!empty($menuModuls)) {
            foreach ($menuModuls as $i=>$menuModul) {
                if($tempKelId == $menuModul->kelmenu_id)
                    $j++;
                else 
                    $j = 0;
                $menus[$menuModul->kelmenu_id]['url'] = '';
                $menus[$menuModul->kelmenu_id]['label'] = '&nbsp;<i class="'.(isset($menuModul->kelompokmenu->kelmenu_icon) ? $menuModul->kelompokmenu->kelmenu_icon : "") .'"></i> '.(isset($menuModul->kelompokmenu->kelmenu_nama) ? $menuModul->kelompokmenu->kelmenu_nama : "") .'<icon class="icon-accordion icon-white pull-right"></icon>';
                $menus[$menuModul->kelmenu_id][$j]['url'] = array('route'=>$menuModul->menu_url,'params'=>array('modul_id'=>$menuModul->modul_id));
                $menus[$menuModul->kelmenu_id][$j]['label'] = '<icon class="'.(isset($menuModul->menu_icon) ? $menuModul->menu_icon : "") .'"></icon> '.$menuModul->menu_nama;
                $tempKelId = $menuModul->kelmenu_id;
            }
            foreach ($menus as $kelMenuId=>$key) {
                $result[] = $key;
            }
        } else {
            $result['label'] = 'kosong';
            $result['url'] = '';
        }
        
        return $result;
    }
	
	 /**
     * menampilkan menumodule_k menjadi array untuk extension menu
     * @param type $menuModuls
     * @return array
     */
    public static function getMenuModulAdmin($menuModuls)
    {
        $menus = array();
        $result = array();
        $tempKelId = '';
        $j = 0;
        $k = 0;
        if(!empty($menuModuls)) {
            
             foreach ($menuModuls as $i=>$menuModul) {
				if($menuModul->menu_shortcut){
					
                                        $menus[0]['url'] = '';
                                        $menus[0]['icon'] = "icon-favorit";
                                        $menus[0]['kelmenu_id'] = "";
                        //                $menus[$menuModul->kelmenu_id]['label'] = '&nbsp;<i class="'.(isset($menuModul->kelompokmenu->kelmenu_icon) ? $menuModul->kelompokmenu->kelmenu_icon : "") .'"></i> '.(isset($menuModul->kelompokmenu->kelmenu_nama) ? $menuModul->kelompokmenu->kelmenu_nama : "");
                                        $menus[0]['label'] = "Favorit";
                                        $menus[0]['menus'][$k]['url'] = array('route'=>$menuModul->menu_url,'params'=>array('modulId'=>$menuModul->modul_id));
                                        $menus[0]['menus'][$k]['label'] = $menuModul->menu_nama;
                                        $menus[0]['menus'][$k]['icon'] = $menuModul->menu_icon;  
					$k++;
				}
            }
            foreach ($menuModuls as $i=>$menuModul) {
                if($tempKelId == $menuModul->kelmenu_id)
                    $j++;
                else 
                    $j = 0;
                $menus[$menuModul->kelmenu_id]['url'] = '';
                $menus[$menuModul->kelmenu_id]['icon'] = $menuModul->kelompokmenu->kelmenu_icon;
                $menus[$menuModul->kelmenu_id]['kelmenu_id'] = $menuModul->kelmenu_id;
//                $menus[$menuModul->kelmenu_id]['label'] = '&nbsp;<i class="'.(isset($menuModul->kelompokmenu->kelmenu_icon) ? $menuModul->kelompokmenu->kelmenu_icon : "") .'"></i> '.(isset($menuModul->kelompokmenu->kelmenu_nama) ? $menuModul->kelompokmenu->kelmenu_nama : "");
                $menus[$menuModul->kelmenu_id]['label'] = (isset($menuModul->kelompokmenu->kelmenu_nama) ? $menuModul->kelompokmenu->kelmenu_nama : "");
                $menus[$menuModul->kelmenu_id]['menus'][$j]['url'] = array('route'=>$menuModul->menu_url,'params'=>array('modulId'=>$menuModul->modul_id));
                $menus[$menuModul->kelmenu_id]['menus'][$j]['label'] = $menuModul->menu_nama;
                $menus[$menuModul->kelmenu_id]['menus'][$j]['icon'] = $menuModul->menu_icon;
                $tempKelId = $menuModul->kelmenu_id;
            }
            foreach ($menus as $kelMenuId=>$key) {
                $result[] = $key;
            }
        } else {
            $result['label'] = 'kosong';
            $result['url'] = '';
        }
        
        return $result;
    }
}
?>
