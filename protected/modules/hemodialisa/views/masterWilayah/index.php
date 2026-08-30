<div class="row">
<div class="col-md-12">
	<div class="panel panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">Master Wilayah</div>
	</div>
	<div class="panel-body">
    <?php 
    $this->breadcrumbs=array(
            'Master Wilayah'=>array('index'),
            //'Manage',
    );
    ?>

    <?php $this->renderPartial('_tabMenu',array()); ?>
    <?php $this->renderPartial('_jsFunctions',array()); ?>
    <div>
        <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll" ></iframe>
    </div>
	</div>
	</div>
</div>
</div>