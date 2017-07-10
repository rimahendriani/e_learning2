<div id="bg-isi"><h2>Module dosen - E-Learning</h2><br />
<a href="<?php echo base_url(); ?>index.php/admin/tambahdosen"><div class="pagingpage"><b> + Tambah dosen </b></div><br /><br /></a>
<table width="750" bgcolor="#ccc" cellpadding="2" cellspacing="1" class="widget-small">
<tr bgcolor="#FFF" align="center"><td><strong>No.</strong></td><td><strong>Username</strong></td><td><strong>Nama</strong></td><td><strong>Status</strong></td><td colspan="2"><strong>Aksi</strong></td></tr>
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
echo "<tr bgcolor='".$warna."'><td align='center'>".$nomor."</td><td>".$t->username."</td><td>".$t->nama."</td><td>".$t->status."</td><td>
<a href='".base_url()."index.php/admin/editdosen/".$t->username."' title='Edit Tutorial'><img src='".base_url()."system/application/views/dosen/images/edit-icon.gif' border='0'></a></td>
<td><a href='".base_url()."index.php/admin/hapusdosen/".$t->username."' onClick=\"return confirm('Anda yakin ingin menghapus pengumuman ini?')\" title='Hapus Tutorial'><img src='".base_url()."system/application/views/dosen/images/hapus-icon.gif' border='0'></a></td>
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