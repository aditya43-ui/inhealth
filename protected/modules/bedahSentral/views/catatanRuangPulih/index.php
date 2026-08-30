<?php
$this->breadcrumbs = array(
    'Catatan Anestesi dan Sedasi',
);

?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Catatan Perawatan Ruang Pulih
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view . '_infoPasien', array(
            'model' => $model,
        ), true); ?>
        <?php
        echo $this->renderPartial($this->path_view . '_tabMenu', array(), true);
        echo $this->renderPartial($this->path_view . '_jsFunctions', array(), true);
        ?>
        <div>
            <iframe class="biru" id="frame" src="" width='100%' frameborder="0" style="overflow-y:scroll; "></iframe>
        </div>

    </div>
</div>