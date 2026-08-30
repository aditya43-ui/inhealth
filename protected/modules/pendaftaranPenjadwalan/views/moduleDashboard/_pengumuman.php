<?php 
$this->widget('ext.bootstrap.widgets.BootListView',array(
	'dataProvider'=>$dataProvider,
	'id'=>'list-pengumuman',
	'template'=>"{items}",
	'itemView'=>'_pengumumanView',
)); ?>