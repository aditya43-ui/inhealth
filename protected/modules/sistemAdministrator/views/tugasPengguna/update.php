<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Tugas Pemakai</b>
        </div>
    </div>
    <div class="panel-body">
        <?php

        $this->breadcrumbs = array(
            'Satugaspengguna Ks' => array('index'),
            $model->tugaspengguna_id => array('view', 'id' => $model->tugaspengguna_id),
            'Update',
        );

        ?>

        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_formUpdate', array('model' => $model, 'data' => $data, 'modul_id' => $modul_id)); ?>
        <?php $this->renderPartial('_jsFunctions', array());
        ?>

        <script type="text/javascript">
            function checkModul() {
                var modul = [
                    <?php
                    foreach ($moduls as $i => $modul) {
                        echo "'" . $modul->modul->url_modul . "',";
                    }
                    ?>
                ];
                total = modul.length;
                i = 0;
                modul.forEach(function(data) {
                    $('#' + data).prop("checked", true);
                });
            }

            function checkController() {
                var controller = [
                    <?php
                    foreach ($controllers as $i => $controller) {
                        echo "['" . lcfirst($controller->controller_nama) . "','" . $controller->modul->url_modul . "'],";
                    }
                    ?>
                ];

                controller.forEach(function(data) {
                    console.log('input[modul="' + data[1] + '"][controller="' + data[0] + '"]');
                    $('input[modul="' + data[1] + '"][value="' + data[0] + '"]').prop("checked", true);
                    tambahAction($('input[modul="' + data[1] + '"][value="' + data[0] + '"]'), true);
                });
            }

            function checkAction() {
                var action = [
                    <?php
                    foreach ($actions as $i => $action) {
                        echo "['" . lcfirst($action->action_nama) . "','" . lcfirst($action->controller_nama) . "'],";
                    }
                    ?>
                ];

                action.forEach(function(data) {
                    $('input[controller="' + data[1] + '"][value="' + data[0] + '"]').prop("checked", true);
                });
            }

            checkModul();
            checkController();
            checkAction();
        </script>
    </div>
</div>