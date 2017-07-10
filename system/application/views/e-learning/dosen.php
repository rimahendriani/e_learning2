<div id="tengah">
<table style="border: 1pt ridge #DDDDDD;" width="470" bgcolor="#fff" cellpadding="4" cellspacing="1" class="widget">
<?php
$no=$hal+1;
echo "<span class='judulkategori'>Daftar Dosen</span><br>";
foreach($query->result() as $dsn)
{
if(($no%2)==0){
$warna="#fff";
} else{
$warna="#eee";
}
echo "<tr bgcolor='".$warna."'><td align='center'>".$no."</td><td>".$dsn->dosen."</td><td><a href='".base_url()."learning/detail_dosen/".$dsn->id_dosen."'>Profil Dosen</a></td></tr>";
$no++;
}
?>
</table><br>
<table class="widget" style="border: 1pt ridge #DDDDDD;" align="center" bgcolor="#fff"><tr><td><?=$paginator;?></td></tr></table>
</div>