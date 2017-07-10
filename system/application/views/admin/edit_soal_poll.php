<div id="bg-isi">
<br>
<h2>Module Polling</h2><br />
<!-- Batas Content -->
<a href="<?php echo base_url().'index.php/admin/tambahsoalpoll';?>"><div class="pagingpage"><b> + Tambah Soal Polling</b></div></a> 
<a href="<?php echo base_url().'index.php/admin/tambahjwbpoll';?>"><div class="pagingpage"><b> + Tambah Jawaban Polling</b></div></a> 
<br /><br />
<?php
foreach($detail->result_array() as $e)
{
$id = $e['id_soal_poll'];
$soal = $e['soal_poll'];
$status = $e['status'];
}
?>
<table width="100%" cellpadding="2" cellspacing="1" class="widget-small">
<form method="post" action="<?php echo base_url(); ?>index.php/admin/updatesoalpoll">
<tr><td><strong>Soal Polling</strong></td><td>:</td><td><input type="text" name="soal" class="input" size="70" value="<?php echo $soal; ?>" /></td></tr>
<tr><td><strong>Status</strong></td><td>:</td><td>
<select name="status" class="input">
<?php
if($status=="Y")
{
?>
<option value="N">Tidak Aktif</option><option value="Y" selected="selected">Aktif</option>
<?php
}
else{
?>
<option value="N" selected="selected">Tidak Aktif</option><option value="Y">Aktif</option>
<?php
}
?>
</select>
</td></tr>
<tr><td></td><td></td><td><input type="submit" value="Simpan Data" class="input" /> <input type="reset" value="Hapus" class="input" /><input type="hidden" value="<?php echo $id; ?>" name="id" /></td></tr>
</form>
</table>
<br />
<!-- Batas content bawah -->
</div>