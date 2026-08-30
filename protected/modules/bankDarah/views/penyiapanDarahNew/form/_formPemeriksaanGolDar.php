<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Kantong Penyiapan Darah
        </div>
    </div>
    <div class="panel-body">
    
        
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th rowspan="2">Nomor Kantong</th>
                    <th rowspan="2">Jenis Darah</th>
                    <th colspan="5">Kirim</th>
                </tr>
                
            </thead>
            <tbody>
                <?php
                    if(count($modPemeriksaanGolDar) > 0) {
                        foreach ($modPemeriksaanGolDar as $i => $data) {
                            $this->renderPartial($this->path_view . 'form/_rowGoldar', ['i' => $i, 'model' => $data]);
                        }
                    }
                ?>
            </tbody>
        </table>
     
    </div>
</div>

<script>
    function setKirimDarah(obj) { 
        var pemeriksaangoldar_id = $(obj).parents('tr').find('.pemeriksaangoldar_id').val();
        $('#tab_penyiapan').addClass('animation-loading');
        $.post('<?= $this->createUrl('setKirimDarah') ?>', {
            pemeriksaangoldar_id:pemeriksaangoldar_id
        }, function(data){
            if($(obj).is(':checked')) {
                $('#tab_penyiapan').append(data.row);
            } else {
                $('#tab_penyiapan tr').each(function(){
                    if($(this).data('pemeriksaangoldar') == pemeriksaangoldar_id) {
                        $(this).detach();
                    }
                })
            }
            setDateTimePickerPenyiapan();
            $('#tab_penyiapan').removeClass('animation-loading');

        }, 'json');
    }

  
</script>