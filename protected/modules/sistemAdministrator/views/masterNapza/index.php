<div class="white-container">
    <legend class="rim2">Master <b>Napza</b></legend>
    <?php 
    $this->breadcrumbs=array(
            'Sapendidikan Ms'=>array('index'),
            'Manage',
    );
    ?>
    <?php $this->renderPartial($this->path_view.'_tabMenu',array()); ?>
    <?php $this->renderPartial($this->path_view.'_jsFunctions',array()); ?>
    <div>
    <iframe id="frame" class="biru" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
    </div>
</div>