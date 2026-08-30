<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Pengaturan <b>Master SDKI</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Master SDKI' => array('index'),
            'Manage',
        );
        ?>
        <?php $this->renderPartial($this->path_view . '_tabMenu', array()); ?>
        <?php $this->renderPartial($this->path_view . '_jsFunctions', array()); ?>

        <iframe id="frame" class='biru' src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
    </div>
</div>