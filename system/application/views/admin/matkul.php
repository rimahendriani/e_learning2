<div id="bg-isi"><h2>Module Matkul - E-Learning</h2><br />
<a href="<?php echo base_url(); ?>index.php/admin/tambahmatkul"><div class="pagingpage"><b> + Tambah matkul </b></div><br /><br /></a>
<table width="750" bgcolor="#ccc" cellpadding="2" cellspacing="1" class="widget-small">
<tr bgcolor="#FFF" align="center"><td><strong>No.</strong></td><td><strong>Kode MK</strong></td><td><strong>Nama MK</strong></td><td><strong>SKS</strong></td><td><strong>Prodi</strong></td><td colspan="2"><strong>Aksi</strong></td></tr>
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
echo "<tr bgcolor='".$warna."'><td align='center'>".$nomor."</td><td>".$t->kode_mk."</td><td>".$t->nama_mk."</td><td>".$t->sks."</td><td>".$t->prodi."</td><td>
<a href='".base_url()."index.php/admin/editmatkul/".$t->id_mk."' title='Edit Tutorial'><img src='".base_url()."system/application/views/dosen/images/edit-icon.gif' border='0'></a></td>
<td><a href='".base_url()."index.php/admin/hapusmatkul/".$t->id_mk."' onClick=\"return confirm('Anda yakin ingin menghapus pengumuman ini?')\" title='Hapus Tutorial'><img src='".base_url()."system/application/views/dosen/images/hapus-icon.gif' border='0'></a></td>
</td></tr>";
$nomor++;	
}
}
else{
echo "<tr><td colspan='5'>Belum ada data</td></tr>";
}
?>
</table><br />
<table class="widget" align="center"><tr><td><?=$paginator;?></td></tr></table><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
</div>