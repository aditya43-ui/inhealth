

<?php
/*
 $this->widget('bootstrap.widgets.BootTabbable', array(
    'type'=>'tabs',
    'placement'=>'above', // 'above', 'right', 'below' or 'left'
    'tabs'=>array(
        array('label'=>'Section 1', 'content'=>'<p>Hoho, I\'m in Section 1.</p> Saya ini bagian dari Konten2 '),
        array('label'=>'Section 2', 'content'=>$this->renderPartial( '_comments', array( 'model'=>$model ), true ),
        array('label'=>'Section 3', 'content'=>'<p>What up girl, this is Section 3.</p> Ternyata susah juga ini..'),     
        ),
));
*/
  ?>

<?php 
/*
$this->widget('bootstrap.widgets.BootTabbable', array(
    'type'=>'tabs',
    'tabs'=>array(
        array('label'=>'Comment1','content'=>$this->renderPartial( '_comments', array( 'model'=>$model ), true ),),
        array('label'=>'Comment2','content'=>$this->renderPartial( '_comments2', array( 'model'=>$model ), true ),),
    )
));
*/
?>






<?php 
/*
$this->widget('bootstrap.widgets.BootTabbable', array(
                'type'=>'tabs', // 'tabs' or 'pills'
                'tabs'=>array(
                        array('label'=>'Marionettisti', 'content'=>$this->renderPartial('staff/_view_staff_marionettisti', array('model'=>$model),$this),'active'=>true),
                        array('label'=>'Voci e Musica', 'content'=>$this->renderPartial('staff/_view_staff_vociemusica', array('model'=>$model),$this)),
                        array('label'=>'Laboratorio', 'content'=>$this->renderPartial('staff/_view_staff_laboratorio', array('model'=>$model),$this)),
                        array('label'=>'Direttore Artistico', 'content'=>$this->renderPartial('staff/_view_staff_direttore_artistico', array('model'=>$model),$this)),
                ),
            ));
       
$this->renderPartial('staff/_view_staff_marionettisti', array('model'=>$model),true,true
?>



<?php 
/*$this->widget('bootstrap.widgets.BootTabbable', array(
                'type'=>'tabs', // 'tabs' or 'pills'
                'tabs'=>array(
                        array('label'=>'Marionettisti', 'content'=>$this->renderPartial('staff/_view_staff_marionettisti', array('model'=>$model),$this),'active'=>true),
                        array('label'=>'Voci e Musica', 'content'=>$this->renderPartial('staff/_view_staff_vociemusica', array('model'=>$model),$this)),
                        array('label'=>'Laboratorio', 'content'=>$this->renderPartial('staff/_view_staff_laboratorio', array('model'=>$model),$this)),
                        array('label'=>'Direttore Artistico', 'content'=>$this->renderPartial('staff/_view_staff_direttore_artistico', array('model'=>$model),$this)),
                ),
            )); 
*/?>




<?php

$this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=>array(
        array('label'=>'Pekerjaan', 'url'=>$this->createUrl('/pendaftaranPenjadwalan/pekerjaanM'), 'active'=>true),
        array('label'=>'Pendidikan', 'url'=>$this->createUrl('/pendaftaranPenjadwalan/pendidikanM')),
        array('label'=>'Suku', 'url'=>$this->createUrl('/pendaftaranPenjadwalan/sukuM')),
    ),
));

?>