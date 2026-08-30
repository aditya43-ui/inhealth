<?php
if (!empty($term))
{
    $active = 'opened';
    $visible = 'visible';        
}else{
    $active = '';
    $visible = '';        
}

 $this->widget('zii.widgets.CMenu',array(
            'htmlOptions'=>array(
                    'class'=>'main-menu'
            ),
            'id'=>'main-menu',
            'encodeLabel' => false,                                        
            'activeCssClass' => $active,
            'activateParents'=>true,     
            'submenuHtmlOptions'=>array('class'=>$visible),
            'items'=>$menus,
    ));
?>

