
<div id="bg-isi"><h2>Tes Soal Online</h2><br />
<div id="isi">
<br /><table width="90%" bgcolor="#C8E862" cellpadding="2" cellspacing="1" class="widget-small">
<tr><td width="30" align="center">No.</td><td width="80" align="center">Kode MK</td><td>Mata Kuliah</td><td width="40" align="center">SKS</td><td width="40" align="center">Prodi</td><td width="70" align="center">Semester</td></tr>
<?php
	$nomor=$page+1;
	foreach($query->result() as $kat)
	{
		if(($nomor%2)==0){
			$warna="#FFFFFF";
		} else{
			$warna="#D6F3FF";
		}
		echo "<tr bgcolor='".$warna."'><td align='center'>".$nomor."</td><td align='center'>".$kat->kode_mk."</td><td><a href='".base_url()."index.php/admin/lihatsoal/".$kat->id_matkul."'>"
		.$kat->nama_mk."</a></td><td align='center'>".$kat->sks."</td><td align='center'>".$kat->prodi."</td><td align='center'>".$kat->semester."</td></tr>";
		$nomor++;
	}
?>
</table><br />
<table class="widget" align="center"><tr><td><?=$paginator;?></td></tr></table>
</div>
