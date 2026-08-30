<div class="white-container">
    <?php 
    $this->breadcrumbs=array(
            'Sapendidikan Ms'=>array('index'),
            'Manage',
    );
    ?>
    <legend class="rim2">Master <b>Rumah Sakit</b></legend>
    <?php $this->renderPartial('_tabMenu',array()); ?>
    <?php $this->renderPartial('_jsFunctions',array()); ?>
    <div>
    <iframe id="frame" class="biru" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
    </div>
</div>