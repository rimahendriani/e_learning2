<div id="bg-isi"><h2>Module Matkul - E-Learning</h2><br />
<a href="<?php echo base_url(); ?>index.php/admin/tambahmatkul"><div class="pagingpage"><b> + Tambah matkul </b></div><br /><br /></a>
<table width="870" style="border: 1pt ridge #cccccc;" cellpadding="2" cellspacing="1" class="widget-small">
<?php echo form_open_multipart('admin/simpanmatkul');?>
<tr><td width="150">semester</td><td width="10">:</td><td><input type="text" name="semester" class="textfield" size="80" required></td></tr>
<tr><td width="150">kode_mk</td><td width="10">:</td><td><input type="text" name="kode_mk" class="textfield" size="80" required></td></tr>
<tr><td width="150">nama_mk</td><td width="10">:</td><td><input type="text" name="nama_mk" class="textfield" size="80" required></td></tr>
<tr><td width="150">sks</td><td width="10">:</td><td><input type="text" name="sks" class="textfield" size="80" required></td></tr>
<tr><td width="150">dosen</td><td width="10">:</td><td>
<select name="id_dosen">
<?php
$get = $this->db->get("tbldosen");
foreach($get->result() as $g)
{
	echo "<option value='".$g->id_dosen."'>".$g->dosen."</option>";
}
?>
</select>
</td></tr>
<tr><td width="150">prasyarat</td><td width="10">:</td><td><input type="text" name="prasyarat" class="textfield" size="80" required></td></tr>
<tr><td width="150">prodi</td><td width="10">:</td><td>
<select name="prodi">
	<option value="TI">TI</option>
	<option value="MI">MI</option>
</select>
</td></tr>

<tr><td width="150" valign="top"></td><td width="10" valign="top"></td><td><input type="submit" value="Simpan" class="tombol"></td></tr>
</form>
</table><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
</div>