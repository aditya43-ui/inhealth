<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Ubah <b>Akses Pemakai</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'saaksespengguna Ks' => array('index'),
            $model->aksespengguna_id => array('view', 'id' => $model->aksespengguna_id),
            'Update',
        );
        ?>

        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $this->renderPartial('_formUpdate', array('model' => $model, 'data' => $data, 'modPeran' => $modPeran)); ?>

        <?php $this->renderPartial('_jsFunctions', array()); ?>
    </div>
</div>

<script type="text/javascript">
    function checkModul() {
        var modul = [
            <?php
            foreach ($tugas as $i => $item) {
                echo "['" . $item->peranpengguna_id . "','" . $item->tugas_nama . "'],";
            }
            ?>
        ];
        total = modul.length;
        i = 0;
        modul.forEach(function(data) {
            $('#tugas_' + data[0] + '[value="' + data[1] + '"]').prop("checked", true);
        });
    }

    function checkPeran() {
        var controller = [
            <?php
            foreach ($perans as $i => $peran) {
                echo "'" . $peran->peranpengguna_id . "',";
            }
            ?>
        ];

        // console.log(controller);

        $.each(controller, function(idx, val) {
            $('input[value="' + val + '"]').prop("checked", true);
        });
    }

    checkModul();
    checkPeran();
</script>