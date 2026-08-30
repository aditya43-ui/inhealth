<div class="row-fluid">
    <div class="span12">
        <div class="control-group ">
            <div class="controls">
                <?php echo CHtml::label('Kata Kunci ( Kode / Nama )', '', array('class' => 'control-label')); ?>
                <?php echo CHtml::textField('katakunci_poli', '', array('class' => 'span3', 'placeholder' => 'Ketikan kata kunci')); ?>
                <?php
                echo CHtml::htmlButton('<i class="entypo-search"></i>', array(
                    'onclick' => 'cariDataPoli();return false;',
                    'class' => 'btn btn-primary btn-katakunci',
                    'onkeypress' => "cariDataPoli();return false;",
                    'rel' => "tooltip",
                    'title' => "Klik untuk mencari data Poli",
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="span12">
        <div class="block-tabel">
            <table class="items table table-striped table-condensed" id="table-poli">
                <thead>
                    <tr>
                        <th style="width: 20px;">Pilih</th>
                        <th>Kode Poli</th>
                        <th>Nama Poli</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

</div>
<script type="text/javascript">
    function cariDataPoli() {
        var katakunci = $('#katakunci_poli').val();
        if (<?php echo (Yii::app()->user->getState('isbridging') == TRUE) ? 1 : 0; ?>) {} else {
            myAlert('Fitur Bridging tidak aktif!');
            return false;
        }

        if (katakunci != '') {
            var isi = katakunci;
            var aksi = 1; // 1 untuk mencari data fasilitas kesehatan
        }

        if (isi == "" || !katakunci) {
            myAlert('Isi Kata Kunci terlebih dahulu!');
            return false;
        };
        var setting = {
            url: "<?php echo $this->createUrl('poli/bpjsInterface'); ?>",
            type: 'GET',
            dataType: 'html',
            data: 'param=' + aksi + '&query=' + isi,
            beforeSend: function() {
                $("#table-poli").addClass("animation-loading");
            },
            success: function(data) {
                $("#table-poli").removeClass("animation-loading");
                var obj = JSON.parse(data);
                var obj1 = JSON.parse(data);
                if (obj1.metaData.message != 'Sukses') {
                    myAlert(obj1.metaData.message);
                }

                var list = obj.response.poli;
                $.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('setFormPoli'); ?>',
                    data: {
                        poliList: list
                    }, //
                    dataType: "json",
                    success: function(data) {
                        $("#table-poli > tbody > tr").remove();
                        $('#table-poli > tbody').append(data.form);
                        renameInputRow($("#table-poli"));
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
                //				
                jQuery.expr[':'].contains = function(a, i, m) {
                    return jQuery(a).text().toUpperCase()
                        .indexOf(m[3].toUpperCase()) >= 0;
                };
            },
            error: function(data) {
                $("#table-poli").removeClass("animation-loading");
            }
        }

        if (typeof ajax_request !== 'undefined')
            ajax_request.abort();
        ajax_request = $.ajax(setting);
    }

    /**
     * rename input grid
     */
    function renameInputRow(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });

    }
</script>