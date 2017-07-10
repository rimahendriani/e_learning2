<div id="bg-isi">
<br>
<h2>Module Polling</h2><br />
<!-- Batas Content -->
<a href="<?php echo base_url().'index.php/admin/tambahsoalpoll';?>"><div class="pagingpage"><b> + Tambah Soal Polling</b></div></a> 
<a href="<?php echo base_url().'index.php/admin/tambahjwbpoll';?>"><div class="pagingpage"><b> + Tambah Jawaban Polling</b></div></a> 
<br /><br /><br />
<form method="post" action="<?php echo base_url(); ?>index.php/admin/simpanjwbpoll">
<table width="100%" style="border:1px dashed #999999;" cellpadding="2" cellspacing="1" class="widget-small">
<tr><td>Pertanyaan</td><td>:</td><td>
<select class="input" name="pertanyaan">
<?php
foreach($soal_poll->result_array() as $s)
{
echo "<option value='".$s['id_soal_poll']."'>".$s['soal_poll']."</option>";
}
?>
</select></td></tr>
<tr><td>Jawaban</td><td>:</td><td><input type="text" class="input" size="50" name="jawaban" /></td></tr>
<tr><td></td><td></td><td><input type="submit" class="input" value="Simpan Data" /> <input type="reset" class="input" value="Hapus" /></td></tr>
</table>
</form>
<br />
<table width="100%"cellpadding="2" cellspacing="1" class="widget-small">
<tr bgcolor="#FFF" align="center"><td><strong>No.</strong></td><td><strong>Soal</strong></td><td><strong>Jawaban</strong></td><td><strong>Counter</strong></td><td colspan="2"><strong>Aksi</strong></td></tr>
<?php 
$no = $page+1;
foreach($jwb_poll->result_array() as $artikel){ ?>
<tr>
<td align='center'><?php echo $no; ?></td>
<td><?php echo $artikel['soal_poll']; ?></td>
<td><?php echo $artikel['jawaban']; ?></td>
<td><?php echo $artikel['counter']; ?></td>
<?php
echo"<td>
	<a href='".base_url()."index.php/admin/editjwbpoll/".$artikel['id_jawaban_poll']."'><div class='submitButton2'>Edit Data</div></a></td><td><a href='".base_url()."index.php/admin/hapusjwbpoll/".$artikel['id_jawaban_poll']."' onClick=\"return confirm('Anda yakin ingin menghapus data ini?')\" ><div class='submitButton2'>Hapus Data</div></a></td>";
?>
</tr>
<?php 
	$no++;
 }
  
?>
</table><br />
<?php echo $paginator;?>

<!-- Batas content bawah -->
</div>