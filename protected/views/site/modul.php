<?php
    $criteria = new CDbCriteria;
    $criteria->addCondition('modul_aktif = TRUE');
    $criteria->order = 'modul_kategori, modul_namalainnya';
    $moduls = ModulK::model()->findAll($criteria);
?>

<div class='layer3'>
<table width="200" height="400" border="0">
  <tr>
    
 <?php 
    $katModul = $moduls[0]->modul_kategori;
    echo '<td width="50%">';
    echo '<h6>'.$katModul.'</h6>';
    foreach($moduls as $i=>$modul){
        if($katModul != $modul->modul_kategori){
            echo '</td><td width="50%">';
            echo '<h6>'.$modul->modul_kategori.'</h6>';
            $katModul = $modul->modul_kategori;
        }
        echo CHtml::ajaxLink(CHtml::image(Params::urlIconModulThumbsDirectory().$modul->icon_modul, "Icon ".$modul->modul_nama, array('width'=>'15px')).
                             ' '.ucwords(strtolower($modul->modul_namalainnya)), $this->createUrl('detailModul'), 
                             array('dataType'=>'json',
                                   'success'=>"function(data){
                                                setContent2(data.content);
                                             }",
                                   'data' => array('idModul'=>$modul->modul_id),
                             ), 
                             array()).'<br/>';
    }
    echo '</td>';
 ?>
  </tr>
</table>

</div>

