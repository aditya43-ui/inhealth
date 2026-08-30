<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pinjaman <b>Pegawai</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $sukses = null;
        if (isset($_GET['id'])) {
            $sukses = $_GET['id'];
        }
        if ($sukses > 0)
            Yii::app()->user->setFlash('success', "Data Pinjaman Pegawai berhasil disimpan!");

        $this->widget('bootstrap.widgets.BootAlert');
        ?>
        <?php
        $this->breadcrumbs = array(
            'Pinjaman Pegawai' => array('create'),
            'Create',
        );

        $arrMenu = array();
        //array_push($arrMenu,array('label'=>' Pinjaman Pegawai ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_form', array('model' => $model, 'modPegawai' => $modPegawai)); ?>
        <!--/div-->
    </div>
</div>