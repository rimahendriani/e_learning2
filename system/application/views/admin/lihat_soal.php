
<div id="bg-isi">
<?php
	$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
	if($session!=""){
?>
<h2>Tes Soal Online</h2><br />
<?php
	foreach($judul->result() as $jdl)
	{
		echo $jdl->nama_mk;
	}
?>
<div id="isi">
<a href="<?php echo base_url(); ?>index.php/admin/tambahsoal"><div class="pagingpage"><b> + Tambah soal </b></div><br /><br /></a>
<br /><table cellpadding="3" cellspacing="1" style="border: 1pt ridge #C8E862;" bgcolor="#EEFAFF" class="widget" width="90%">
<?php
	$nomor=$page+1;
	foreach($query->result() as $kat)
	{
		if(($nomor%2)==0){
			$warna="#FFFFFF";
		} else{
			$warna="#D6F3FF";
		}
		echo "<tr bgcolor='".$warna."'><td width='20' align='center'>".$nomor."</td><td width='460'><a href='".base_url()."index.php/admin/daftar_soal/".$kat->id_matkul."/".$kat->no_soal."'>Soal  ".$nomor.
		" ".$kat->nama_mk."</a></td><td><img src='".base_url()."system/application/views/e-learning/images/bullet.gif'> <a href='".base_url()."index.php/admin/daftar_soal/".$kat->id_matkul."/".$kat->no_soal."'>[ Detail soal ]</a></td></tr>";
		$nomor++;
	}
?>
</table><br />
<table class="widget" align="center"><tr><td><?=$paginator;?></td></tr></table><br /><br /><br />
<?php
	}
	else{
?>
	<script type="text/javascript" language="javascript">
		alert("Log In dulu untuk masuk ke sini");
	</script>
	<table height="300" width="600" style="border: 1pt ridge #DDDDDD;" bgcolor="#F2FCFE" cellpadding="2" cellspacing="1" class="widget-small" align="center"><tr><td valign="top">You are not authorised...!!!!!</td></tr></table>
<?php
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."index.php/tes'>"; 		
	}
?>
</div>

