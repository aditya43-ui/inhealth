<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>

<script>
    const set_warning = () => {
        var status = '<?= $model->status ?>';
        var url = '<?= $model->url ?>';
        if (status >= 1) {
            myAlert('Selesaikan proses pengajuan kasbon anda!', 'Perhatian!');
            setTimeout(function(){                
                window.location = url;
            },500); 
        }
    }

    $(document).ready(function() {
        set_warning();
    })
</script>