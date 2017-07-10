<style>
body{
	background-image:url(images/bg-body.jpg);
	background-repeat:repeat-x;
	background-attachment:fixed;
	background-position:bottom;
	font-family:Arial, Helvetica, sans-serif;
	font-size:11px;
}
h2{
	font-size:15px;
	padding:0px;
	margin:0px;
	font-weight:bold;
	color:#666666;
}
h3{
	font-size:12px;
	padding:0px;
	margin:0px;
	font-weight:normal;
	color:#666666;
}
.tombol{
background-color:#EEFAFF;
border:1px solid #DDDDDD;
font-size:11px;
color:#666666;
font-weight:bold;
}
.textfield{
background-color:#EEFAFF;
-moz-border-radius:4px;
-khtml-border-radius: 4px;
-webkit-border-radius: 4px;
border-radius:4px;
font-size:12px;
font-family:Arial;
}
.widget-small{
	font-size:11px;
}
a{
color:orange;
text-decoration:none;
}
a:hover{
color:#999999;
text-decoration:none;
}
</style>
<h2>Upload Foto -  <?php echo $nama; ?></h2><br />

<?php echo form_open_multipart("learning/simpanfoto"); ?>
<input type="file" name="userfile"> *
<input type="submit" valu="upload">
<p>* Maksimal ukuran foto 800x800</p>
<p>* format gambar harus .jpg</p>
<?php echo form_close(); ?>





