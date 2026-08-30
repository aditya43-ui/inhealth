<?php $url = Yii::app()->createAbsoluteUrl($this->route) ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    #excel {

        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        cursor: plus;
    }
</style>

<?php
$this->breadcrumbs = array(
    'Import Data dari Excel',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-file-excel"></i> Import Data dari Excel
        </div>
    </div>
    <div class="panel-body">
        <form id="test" enctype="multipart/form-data" action="<?php echo $url; ?>" method='post' class="form-horizontal">

            <div class="row-fluid">
                <div class="col-sm-6">
                    <div class="control-group" id="widget">
                        <label for="namaObat" class="control-label">Masukan Nama Tabel :</label>
                        <div class="controls">
                            <?php $this->widget('MyJuiAutoComplete', array(
                                'name' => 'tableName',
                                'source' => Yii::app()->createUrl('actionAutoComplete/getListTable'),
                                'options' => array(
                                    'minLength' => '3',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => 'Masukan Nama Tabel',
                                    'size' => '65',
                                    'onchange' => 'uploadFile()'
                                ),
                            )); ?>

                            <a href="" class="btn btn-info" onclick="createTemplateXcel();return false;"><i class="entypo-newspaper"></i> Buat Template</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <label for="namaObat" class="control-label">Import Excel (.xls, .xlsx) :</label>
                        <div class="controls">
                            <div class="input-append">
                                <input type="file" name="upload" id="upload" onchange="uploadFile();">
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="row-fluid" style="overflow-x: auto;">
                <div id="excel"></div>
            </div>
            <div class="form-actions">
                <button type="submit" class='btn btn-danger' value="Simpan" title="Simpan">
                    <i class="entypo-check"></i> Simpan
                </button>
                <?php $this->widget('UserTips', array()); ?>
            </div>
        </form>
    </div>
</div>
<script type='text/javascript'>
    $("#test").submit(function() {
        valueField = $("#beginValueField").val();
        lastValueField = $("#lastValueField").val();
        tableName = $("#tableName").val();
        if (tableName != '') {
            return true;
        } else {
            return false;
        }
    });

    function uploadFile() {
        namaTable = $("#tableName").val();
        if (namaTable == '') {
            myAlert("Silakan isi nama tabel terlebih dahulu!");
        } else {
            var formData = new FormData($('form')[0]);
            tableName = $("#tableName").val();
            formData.append('tableName', tableName);
            //        var serial = $("#test").serialize();
            $.ajax({
                url: '<?php echo $url; ?>', //server script to process data
                type: 'POST',
                xhr: function() { // custom xhr
                    myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) { // check if upload property exists
                        myXhr.upload.addEventListener('progress', function() {
                            console.log("testing ath kk");
                        }, false); // for handling the progress of the upload
                    }
                    return myXhr;
                },
                //Ajax events
                success: function(data) {
                    $("#excel").html(data);
                    $("#widget").show();
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            });
        }
    }

    function createTemplateXcel() {
        tableName = $("#tableName").val();
        if (tableName != '') {
            window.open("<?php echo Yii::app()->createUrl('sistemAdministrator/konfigsystemK/createTemplateXcel'); ?>&tableName=" + tableName, "", 'location=_new, width=900px');
        } else {
            myAlert("Silakan isi nama tabel terlebih dahulu!");
        }
    }
</script>