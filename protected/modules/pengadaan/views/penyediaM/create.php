<?php
$this->breadcrumbs=array(
	'Penyedia Ms'=>array('index'),
	'Create',
);
?>
<div class="white-container">
    <?php 
        $this->widget('bootstrap.widgets.BootAlert');

        echo $this->renderPartial($this->path_view.'_form', array('model'=>$model));
    ?>
</div>