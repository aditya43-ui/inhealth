<?php echo $this->renderPartial($this->path_view."_grafik", array(
    'partograf'=>$partograf, 'kontraksi'=>$kontraksi, 'jalanlahir'=>$jalanlahir
)); ?>
<?php echo $this->renderPartial($this->path_view."table._serviks", array(
    'partograf'=>$partograf, 'is_detail'=>1,
), true); ?>
<?php echo $this->renderPartial($this->path_view."table._kontraksi", array(
    'partograf'=>$partograf, 'is_detail'=>1,
), true); ?>
