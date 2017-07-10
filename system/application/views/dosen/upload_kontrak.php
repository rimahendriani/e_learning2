<div id="kiri"><h2>Module Upload Kontrak Ajar</h2>
<div id="isi">
<br>
<table width="750" bgcolor="#ccc" cellpadding="2" cellspacing="1" class="widget-small">
<tr bgcolor="#FFF" align="center"><td><strong>No.</strong></td><td><strong>Mata Kuliah</strong></td><td><strong>Kode MK</strong></td><td><strong>SKS</strong></td><td><strong>Prodi</strong></td><td><strong>Edit Berkas Kontrak Ajar</strong></td></tr>
<?php
$nomor=$page+1;
if(count($query->result())>0){
foreach($query->result() as $t)
{
		if(($nomor%2)==0){
			$warna="#C8E862";
		} else{
			$warna="#D6F3FF";
		}
echo "<tr bgcolor='".$warna."'><td align='center'>".$nomor."</td><td>".$t->nama_mk."</td><td>".$t->kode_mk."</td><td>".$t->sks."</td><td>".$t->prodi."</td><td>
<a href='".base_url()."index.php/dosen/edit_kontrak/".$t->id_mk."' title='Edit File'><img src='".base_url()."system/application/views/dosen/images/edit-icon.gif' border='0'></a></td>
</td></tr>";
$nomor++;	
}
}
else{
echo "<tr><td colspan='5'>Belum ada mata kuliah yg tersedia</td></tr>";
}
?>
</table><br />
<table class="widget" align="center"><tr><td><?=$paginator;?></td></tr></table>
</div>
</div>
