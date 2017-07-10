<div id="bg-isi">
<br>
<h2>Module Polling</h2><br />
<!-- Batas Content -->
<a href="<?php echo base_url().'index.php/admin/tambahsoalpoll';?>"><div class="pagingpage"><b> + Tambah Soal Polling</b></div></a> 
<a href="<?php echo base_url().'index.php/admin/tambahjwbpoll';?>"><div class="pagingpage"><b> + Tambah Jawaban Polling</b></div></a> 
<br /><br /><br />
<form method="post" action="<?php echo base_url(); ?>index.php/admin/updatejwbpoll">
<table width="100%" style="border:1px dashed #999999;" cellpadding="2" cellspacing="1" class="widget-small">
<tr><td>Pertanyaan</td><td>:</td><td>
<?php
foreach($detail->result_array() as $s)
{
$id_soal = $s['id_soal_poll'];
$id_jwb = $s['id_jawaban_poll'];
$jwb = $s['jawaban'];
$counter = $s['counter'];
}
?>
<select class="input" name="pertanyaan">
<?php
foreach($soal_poll->result_array() as $s)
{
if($id_soal==$s['id_soal_poll'])
{
echo "<option value='".$s['id_soal_poll']."' selected='selected'>".$s['soal_poll']."</option>";
}
else{
echo "<option value='".$s['id_soal_poll']."'>".$s['soal_poll']."</option>";
}
}
?>
</select></td></tr>
<tr><td>Jawaban</td><td>:</td><td><input type="text" class="input" size="50" name="jawaban" value="<?php echo $jwb; ?>" /></td></tr>
<tr><td>Counter</td><td>:</td><td><input type="text" class="input" size="50" name="counter" value="<?php echo $counter; ?>" /></td></tr>
<tr><td></td><td></td><td><input type="submit" class="input" value="Simpan Data" /> <input type="reset" class="input" value="Hapus" /><input type="hidden" name="id" value="<?php echo $id_jwb; ?>" /></td></tr>
</table>
</form>
<br />
</div>