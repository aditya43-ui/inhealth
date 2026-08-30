<?php echo CHtml::htmlButton(
	Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),
    array('class'=>'btn btn-danger','type'=>'button','disabled'=>false,'onclick'=>'searchData();return false;','title'=>"Klik untuk mencari Status Isolasi",'rel'=>"tooltip",));
?>