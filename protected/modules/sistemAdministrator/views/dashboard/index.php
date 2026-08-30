<div class="white-container">
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); // untuk Pencarian Menu Dashboard Sistem Administrator ?>
    <?php $this->pageTitle=Yii::app()->name; 
                $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <?php
        echo "<div class='dashboard'>";
        echo "<div>";
    // RND-5795 (menu tidak dikelompokan)
    //        foreach ($kelmenus as $i=>$kelmenu){
    //        	$menuDefault = MenumodulK::model()->findByAttributes(array('kelmenu_id'=>$kelmenu->kelmenu_id,'modul_id'=>Yii::app()->session['modul_id']));
    //        	if(count((array)$menuDefault)>0){
    //        		echo "<a href=".Yii::app()->createUrl(isset($menuDefault->menu_url)?$menuDefault->menu_url:'',array('modul_id'=>Yii::app()->session['modul_id'],'kelMenu'=>$kelmenu->kelmenu_id))." class='shortcut'>";
    //	            echo "<i class='".$kelmenu->kelmenu_icon."'></i><br><br>";
    //	            echo "$kelmenu->kelmenu_namalainnya";          
    //                    echo "</a>";
    //        	}
    //        }
    ?>

    <div class="row" style="margin:5px;">
            <div class="span12">
                    <?php 
    //		$this->Widget('ext.bootstrap.widgets.BootAccordion',array(
    //						'id'=>'carimodul',
    //						'content'=>array(
    //							'content-carimodul'=>array(
    //								'header'=>'<b><i class="icon-book icon-white"></i> Pencarian Menu</b>',
    //								'isi'=>$this->renderPartial('_searchMenu',array('modMenu'=>$modMenu),true),
    //								'active'=>true,
    //								),   
    //							),
    //							)); 
                    $this->renderPartial('_searchMenu',array('modMenu'=>$modMenu));
                    ?>      
            </div>
    </div>
    <div id="carimenu">
        <?php
                foreach ($kelompokMenu as $i=>$kelmenu){
                        $menuDefault = MenumodulK::model()->findByAttributes(array('kelmenu_id'=>$kelmenu->kelmenu_id,'modul_id'=>Yii::app()->session['modul_id']), array('order'=>'menu_urutan'));
                        if(!empty($menuDefault)){
                            echo '<fieldset class="box">';
                            echo '<legend class="rim">';
                            echo $kelmenu->kelmenu_nama."<br>";
                            echo '</legend>';
                            $menuDetails = MenumodulK::model()->findAllByAttributes(array('kelmenu_id'=>$menuDefault->kelmenu_id,'modul_id'=>Yii::app()->session['modul_id'],'menu_aktif'=>true),array('order'=>'menu_urutan'));
                            foreach ($menuDetails as $i =>$menuDetail){
                                echo "<a href=".Yii::app()->createUrl(isset($menuDetail->menu_url)?$menuDetail->menu_url:'',array('modul_id'=>Yii::app()->session['modul_id'],'kelMenu'=>$kelmenu->kelmenu_id))." class='shortcut4'>";
                                echo "<i class='".$menuDetail->menu_icon."'></i><br><br>";
                                echo "$menuDetail->menu_nama";  
                                echo "</a>";
                            }
                            echo '</fieldset>';
                        }
                }
            echo "</div>";
            echo "</div>";
            echo "</div>";
        ?>
    </div>
</div>	
<script type="text/javascript">
$(document).ready(function(){
	$("#<?php echo CHtml::activeId($modMenu, 'menu_nama') ?>").focus();
});
</script>