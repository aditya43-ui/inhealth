<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Informasi <b>Jadwal Operasi</b>
            <span class="pull-right">
                <?php
                echo CHtml::link('<i class="entypo-calendar"></i> Tampilkan Kalender', '#', array(
                    'onclick' => 'to_calendar(); return false;',
                    'class' => 'btn btn-default',
                    'id' => 'btn_table',
                ));
                ?>
                <?php
                echo CHtml::link('<i class="entypo-list""></i> Tampilkan Daftar', '#', array(
                    'onclick' => 'to_table(); return false;',
                    'class' => 'btn btn-default',
                    'style' => 'display: none;',
                    'id' => 'btn_calendar',
                ));
                ?>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Informasi Jadwal Operasi',
        );
        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('reinformasipenjualanprodukpos-v-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <div class="pan_type" id="pan_table">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-search"></i> Pencarian
                    </div>
                </div>
                <div class="panel-body">
                    <?php $this->renderPartial($this->path_view . 'jadwalOperasi/_search', array('model' => $model,)); ?>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="entypo-credit-card"></i> Jadwal Operasi
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <?php
                    echo $this->renderPartial($this->path_view . 'jadwalOperasi/_tabel', array(
                        'model' => $model,
                    ), true);
                    ?>
                </div>
            </div>
            <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="entypo-search"></i>')),'#',array('class'=>'search-button btn'));  
            ?>
        </div>
        <div class="pane_type" id="pan_calendar">
            <?php
            echo $this->renderPartial($this->path_view . 'jadwalOperasi/_kalendar', array(
                'model' => $model,
            ), true);
            ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#pan_calendar").hide();
        $("#pan_table").show();
    });
</script>