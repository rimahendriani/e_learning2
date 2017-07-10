<div id="bg-isi"><h2>Module Soal - E-Learning</h2><br />
<a href="<?php echo base_url(); ?>index.php/admin/tambahsoal"><div class="pagingpage"><b> + Tambah soal </b></div><br /><br /></a>
<table width="870" style="border: 1pt ridge #cccccc;" cellpadding="2" cellspacing="1" class="widget-small">
<?php echo form_open_multipart('admin/simpansoal');?>
<tr><td width="150">no_soal</td><td width="10">:</td><td><input type="text" name="no_soal" class="textfield" size="80" value="<?php echo $no_soal; ?>" required></td></tr>
<tr><td width="150">pertanyaan</td><td width="10">:</td><td><input type="text" name="pertanyaan" class="textfield" size="80" value="<?php echo $pertanyaan; ?>" required></td></tr>
<tr><td width="150">jwb_a</td><td width="10">:</td><td><input type="text" name="jwb_a" class="textfield" size="80" value="<?php echo $jwb_a; ?>" required></td></tr>
<tr><td width="150">jwb_b</td><td width="10">:</td><td><input type="text" name="jwb_b" class="textfield" size="80" value="<?php echo $jwb_b; ?>" required></td></tr>
<tr><td width="150">jwb_c</td><td width="10">:</td><td><input type="text" name="jwb_c" class="textfield" size="80" value="<?php echo $jwb_c; ?>" required></td></tr>
<tr><td width="150">jwb_d</td><td width="10">:</td><td><input type="text" name="jwb_d" class="textfield" size="80" value="<?php echo $jwb_d; ?>"></td></tr>
<tr><td width="150">jwb_e</td><td width="10">:</td><td><input type="text" name="jwb_e" class="textfield" size="80" value="<?php echo $jwb_e; ?>"></td></tr>	
<tr><td width="150">kunci</td><td width="10">:</td><td><input type="text" name="kunci" class="textfield" size="80" value="<?php echo $kunci; ?>"></td></tr>	
<tr><td width="150">mata kuliah</td><td width="10">:</td><td>
<input type="hidden" name="id_soal" value="<?php echo $id_soal; ?>">
<select name="id_matkul">
<?php
$get = $this->db->get("tblmatkul");
foreach($get->result() as $g)
{
	if($id_matkul==$g->id_mk)
	{
	echo "<option value='".$g->id_mk."' selected>".$g->nama_mk."</option>";
	}
	else
	{
	echo "<option value='".$g->id_mk."'>".$g->nama_mk."</option>";
	}
}
?>
</select>
</td></tr>

<tr><td width="150" valign="top"></td><td width="10" valign="top"></td><td><input type="submit" value="Simpan" class="tombol"></td></tr>
</form>
</table><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
</div>