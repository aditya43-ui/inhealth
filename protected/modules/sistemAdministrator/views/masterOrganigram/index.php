<?php
$this->breadcrumbs = array(
    'Kporganigram Ms' => array('index'),
    'Create',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-plus-square"></i> Tambah <b>Struktur Organigram</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo $this->renderPartial($this->path_view . '_form', array('model' => $model)); ?>
        <hr>

        <?php /*
	<div class="panel panel-success">
	<div class="panel-heading">
		<div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Struktur Organigram</b></div>
	</div>
	<div class="panel-body">
	<?php //$this->renderPartial($this->path_view.'_tabMenu',array()); ?>
	<?php $this->renderPartial($this->path_view.'_jsFunctions',array()); ?>
	<div>
		<!--<iframe id="frame" class="biru" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>-->
	
	</div>
	</div>
	</div>
	 * 
	 */ ?>
    </div>
</div>

<script>
    function setDialog(obj) {
        parent = $(obj).parents(".input-append").find("input").attr("id");
        dialog = "#dialogPegawai";

        $(dialog).attr("parent-dialog", parent);
        $(dialog).dialog("open");
    }

    function setPegawaiAuto(pegawai_id) {

        dialog = "#dialogPegawai";
        parent = $(dialog).attr("parent-dialog");
        obj = $("#" + parent);
        $.get('<?php echo $this->createUrl('/ActionAutoComplete/getPegawai'); ?>', {
            pegawai_id: pegawai_id
        }, function(data) {
            $(obj).val(data[0].nama_pegawai);
            $(obj).val(data[0].nomorindukpegawai);
            setPegawai(obj, data[0]);
        }, "json");
        $(dialog).dialog("close");
    }

    function setPegawaiAutoCom(pegawai_id, obj) {

        $.get('<?php echo $this->createUrl('/ActionAutoComplete/getPegawai'); ?>', {
            pegawai_id: pegawai_id
        }, function(data) {
            $(obj).val(data[0].nama_pegawai);
            $(obj).val(data[0].nomorindukpegawai);
            setPegawai(obj, data[0]);
        }, "json");

    }

    function setPegawai(obj, item) {
        $(obj).parents('tr').find('input[name$="[nama_pegawai]"]').val(item.nama_pegawai);
        $(obj).parents('tr').find('input[name$="[pegawai_id]"]').val(item.pegawai_id);
        $(obj).parents('tr').find('input[name$="[jabatan_id]"]').val(item.jabatan_id);
        $(obj).parents('tr').find('input[name$="[jabatan_nama]"]').val(item.jabatan_nama);
    }

    function generatePeg(obj) {
        var jml = $(obj).val();
        var tr = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view . '_rowPegawai', array('model' => $model), true)); ?>);

        if (jml < 1) {
            $("#tampung-pegawai > tbody").html('');
            $(obj).val('');
            return false;
        }

        for (var i = 1; i <= jml; i++) {
            $("#tampung-pegawai > tbody").append(tr.replace());

        }
        renameField($("#tampung-pegawai"));
    }

    function renameField(obj) {
        var row = 0;
        var jmlRow = $(obj).length;

        $(obj).find("tbody > tr").each(function() {
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_pegawai_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[pegawai][" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });

        $('.numbers-only').keyup(function() {
            setNumbersOnly(this);
        });

        jQuery('input[name$="[nama_pegawai]"]').autocomplete({
            'showAnim': 'fold',
            'minLength': 3,
            'focus': function(event, ui) {
                $(this).val(ui.item.label);
                return false;
            },
            'select': function(event, ui) {
                setPegawaiAutoCom(ui.item.value, this);
                return false;
            },
            'source': function(request, response) {
                $.ajax({
                    url: "<?php echo Yii::app()->createUrl('/ActionAutoComplete/getPegawai'); ?>",
                    dataType: "json",
                    data: {
                        term: request.term,
                    },
                    success: function(data) {
                        response(data);
                    }
                })
            }
        });
    }
</script>