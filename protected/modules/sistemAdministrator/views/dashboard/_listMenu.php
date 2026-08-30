<?php
	if(count((array)$modPencarianMenu)>0){
            $kel = CHtml::listData(KelompokmenuK::model()->findAll('kelmenu_aktif = true'), 'kelmenu_id', 'kelmenu_nama');
            $keldat = array();
            foreach ($modPencarianMenu as $i =>$menuDetail){
                if (empty($keldat[$menuDetail->kelmenu_id])) $keldat[$menuDetail->kelmenu_id] = array(
                    'nama'=>$kel[$menuDetail->kelmenu_id],
                    'detail'=>array(),
                );
                
                $keldat[$menuDetail->kelmenu_id]['detail'][] = $menuDetail->attributes;
                //echo $menuDetail->menu_nama;
		//echo "<a href=".Yii::app()->createUrl(isset($menuDetail->menu_url)?$menuDetail->menu_url:'',array('modul_id'=>Yii::app()->session['modul_id']))." class='shortcut4'>";
		//echo "<i class='icon-th-list'></i><br><br>";
		//echo "$menuDetail->menu_nama";  
		//echo "</a>";
            }
            
            foreach ($keldat as $idx => $kels) {
                echo '<fieldset class="box">';
                echo '<legend class="rim">';
                echo $kels['nama']."<br>";
                echo '</legend>';
                
                foreach ($kels['detail'] as $detail) {
                    // var_dump($detail);
                    
                    echo "<a href=".Yii::app()->createUrl(isset($detail['menu_url'])?$detail['menu_url']:'',array('modul_id'=>Yii::app()->session['modul_id'],'kelMenu'=>$idx))." class='shortcut4'>";
                    echo "<i class='".$detail['menu_icon']."'></i><br><br>";
                    echo $detail['menu_nama'];  
                    echo "</a>";
                }
                
                echo '</fieldset>';
            }
	}
?>