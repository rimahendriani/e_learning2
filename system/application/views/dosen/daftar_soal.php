<div id="kiri">
<div id="isi">
<?php
	$session=isset($_SESSION['username_belajar']) ? $_SESSION['username_belajar']:'';
	if($session!=""){
?>
<br />

<a href="<?php echo base_url(); ?>index.php/dosen/tambahsoal"><div class="pagingpage"><b> + Tambah soal </b></div><br /><br /></a>
<table width="90%" style="border: 1pt ridge #DDDDDD;" bgcolor="#F2FCFE" cellpadding="1" cellspacing="1" class="widget-small" align="center"><tr><td>
Anda berada di : <b>Beranda</b> >> <b>Soal Online</b> >> <b>
<?php
	foreach($judul->result_array() as $jdl)
	{
		echo $jdl["nama_mk"]."</b> >> <b>Soal ".$jdl["no_soal"]." ".$jdl["nama_mk"]."</a>";
	}
?>
</b><br />
</td></tr></table><br /><br />
<table width="600" cellpadding="2" cellspacing="1" class="widget-small">
<?php
	$nomor=1;
	foreach($soal->result_array() as $jwb)
	{
		$no_soal=$jwb["no_soal"];
		$id_mk=$jwb["id_matkul"];
		$matkul=$jwb["nama_mk"];
		echo "<tr><td width='20'>".$nomor."</td><td>".$jwb["pertanyaan"]."</td></tr><tr>";
		echo "<td></td><td><input type='radio' value='a' name='pilih[".$jwb["id_soal"]."]'>A. ".$jwb["jwb_a"]."</td></tr>";
		echo "<td></td><td><input type='radio' value='b' name='pilih[".$jwb["id_soal"]."]'>B. ".$jwb["jwb_b"]."</td></tr>";
		echo "<td></td><td><input type='radio' value='c' name='pilih[".$jwb["id_soal"]."]'>C. ".$jwb["jwb_c"]."</td></tr>";
		if($jwb["jwb_d"]!="")
		{
			echo "<td></td><td><input type='radio' value='d' name='pilih[".$jwb["id_soal"]."]'>D. ".$jwb["jwb_d"]."</td></tr>";
		}
		else
		{
			echo "";
		}
		if($jwb["jwb_e"]!="")
		{
			echo "<td></td><td><input type='radio' value='e' name='pilih[".$jwb["id_soal"]."]'>E. ".$jwb["jwb_e"]."</td></tr>";
		}
		else
		{
			echo "";
		}
		$nomor++;
		echo "<td></td><td>
		<a href='".base_url()."index.php/dosen/edit_soal/".$jwb['id_soal']."'><div class='pagingpage'><b>Edit</b></div></a>
		<a href='".base_url()."index.php/dosen/hapus_soal/".$jwb['id_soal']."'><div class='pagingpage'><b>Hapus</b></div></a>
		</td></tr>";
	}
?>
</table>

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
</div>
</div>