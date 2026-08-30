<legend class="rim2">Informasi Kamar</legend> 

<style>
    .contentKamar, .bed{
        -moz-box-shadow: 0px 5px 10px rgba(0,0,0,.6);
        -webkit-box-shadow: 0px 5px 10px rgba(0,0,0,.6);
        -o-box-shadow: 0px 5px 10px rgba(0,0,0,.6);
        -moz-border-radius:3px;
        -webkit-border-radius:3px;
        -o-border-radius:3px;
    }
    .contentKamar{
        border:1px solid black;
        margin:10px;
		
    }
    .bed{
        display:inline-block;
        width:13%;
        border-color:#ccc;
        margin:10px;
    }
    .popover-inner{
        width:100%;
    }
    .image_ruangan{
        height:100px;
        width:100px;
    }
	.pintu{
		background-image:url(images/pintu.png);
		width:16px;
		height:75px;
		margin-top:80px;
		float:right;
		margin-right:-2px;
		}
</style>

<div class="isi">
<?php echo $row; ?>
</div>
