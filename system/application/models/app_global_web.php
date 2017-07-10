<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class app_global_web extends Model {

	/**
	 * @author : Gede Lumbung
	 * @web : http://gedelumbung.com
	 **/
	 
	 
	public function generate_index_menu()
	{
		$hasil="";
		$w = $this->db->get_where("dlmbg_menu");
		
		$hasil .= "<ul id='treemenu1'>";
		foreach($w->result() as $h)
		{
			$hasil .= '<li><a href="'.base_url().'web/pages/'.$h->id_menu.'/'.url_title($h->menu,'-',TRUE).'">'.$h->menu.'</a></li>';
		}
		$hasil .= '</ul>';
		return $hasil;
	}

	public function generate_index_kinerja_bidang($bidang,$limit,$offset)
	{
		$i = $offset+1;
		$where['jenis_kinerja'] = $bidang;
		$where['a.id_dosen'] = $this->session->userdata("id_dosen_kinerja");
		
		$this->db->select("*")->join("dlmbg_dosen b","a.id_dosen=b.id_dosen");
		$tot_hal = $this->db->get_where("dlmbg_kinerja a",$where);

		$config['base_url'] = base_url() . 'web/kinerja_bidang/set/'.$bidang.'/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 5;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);
		
		$this->db->select("*")->join("dlmbg_dosen b","a.id_dosen=b.id_dosen");
		$w = $this->db->get_where("dlmbg_kinerja a",$where,$limit,$offset);
		
		$hasil = "";
		$hasil .= "<table cellpadding='8' cellspacing='0' style='border-collapse:collapse; width:100%;' border='1'>
				<thead>
				<tr class='warning'>
				<td width='30'><b>No.</b></td>
				<td><b>Nama</b></td>
				<td><b>Jenis Kegiatan</b></td>
				<td><b>SKS</b></td>
				<td><b>Masa Penugasan</b></td>
				<td>Cek Detail</td>
				</tr>
				</thead>";
				
		foreach($w->result() as $h)
		{
			$gbr = "no-image.jpg";
			if($h->gambar!="")
			{
				$gbr = $h->gambar;
			}
			$hasil .= "<tr><td>".$i." </td><td>".$h->nama." </td><td>".$h->jenis_kegiatan." </td><td>".$h->sks_penugasan." </td><td>".$h->masa_penugasan." </td>
			<td><a href='".base_url()."web/kinerja_bidang/detail/".$bidang."/".$h->id_kinerja."' class='input-button'>
			<i class='icon-edit'></i> Detail</a>";
			
			$hasil .= "</td></tr>";
			$i++;
		}
		
		$hasil .= "</table>";
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}

	public function generate_detail_kinerja_bidang($bidang,$param)
	{
		$where['id_kinerja'] = $param;
		
		$this->db->select("*")->join("dlmbg_dosen","dlmbg_kinerja.id_dosen=dlmbg_dosen.id_dosen","left")->join("dlmbg_rekomendasi","dlmbg_kinerja.id_rekomendasi=dlmbg_rekomendasi.id_rekomendasi","left");
		$w = $this->db->get_where("dlmbg_kinerja",$where);
		
		$hasil = "";
		$hasil .= "<table cellpadding='8' cellspacing='0'>";
				
		foreach($w->result() as $h)
		{
			$gbr = "no-image.jpg";
			if($h->gambar!="")
			{
				$gbr = $h->gambar;
			}
			$hasil .= "<tr><td>Nomor</td><td>:</td><td>".$h->nomor." </td></tr>";
			$hasil .= "<tr><td>Nama</td><td>:</td><td>".$h->nama." </td></tr>";
			$hasil .= "<tr><td>Jenis Kegiatan</td><td>:</td><td>".$h->jenis_kegiatan." </td></tr>";
			$hasil .= "<tr><td>Bukti Penugasan</td><td>:</td><td>".$h->bukti_penugasan." </td></tr>";
			$hasil .= "<tr><td>SKS Penugasan</td><td>:</td><td>".$h->sks_penugasan." </td></tr>";
			$hasil .= "<tr><td>Masa Penugasan</td><td>:</td><td>".$h->masa_penugasan." </td></tr>";
			$hasil .= "<tr><td>Bukti Dokumen</td><td>:</td><td>".$h->bukti_dokumen." </td></tr>";
			$hasil .= "<tr><td>SKS Dokumen</td><td>:</td><td>".$h->sks_dokumen." </td></tr>";
			$hasil .= "<tr><td>Rekomendasi</td><td>:</td><td>".$h->rekomendasi." </td></tr>";
			$hasil .= "<tr><td>Jenis Kerja</td><td>:</td><td>".$h->jenis_kinerja." </td></tr>";
		}
		
		$hasil .= "</table>";
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}

	public function generate_index_dosen($limit,$offset)
	{
		$i = $offset+1;
		$tot_hal = $this->db->get("dlmbg_dosen");

		$config['base_url'] = base_url() . 'web/dosen/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);
		
		$w = $this->db->get("dlmbg_dosen",$limit,$offset);
		
		$hasil = "";
		$hasil .= "<table cellpadding='8' cellspacing='0' style='border-collapse:collapse; width:100%;' border='1'>
				<thead>
				<tr class='warning'>
				<td width='30'><b>No.</b></td>
				<td><b>Nama</b></td>
				<td><b>NIP</b></td>
				<td><b>Email</b></td>
				<td><b>Foto</b></td>
				<td>Cek Detail</td>
				</tr>
				</thead>";
				
		foreach($w->result() as $h)
		{
			$gbr = "no-image.jpg";
			if($h->gambar!="")
			{
				$gbr = $h->gambar;
			}
			$hasil .= "<tr><td>".$i." </td><td>".$h->nama." </td><td>".$h->nip." </td><td>".$h->email." </td>
			<td><img src='".base_url()."asset/foto-dosen/".$gbr."' width='50'> </td>
			<td><a href='".base_url()."web/dosen/detail/".$h->id_dosen."' class='input-button'>
			<i class='icon-edit'></i> Detail</a>";
			
			$hasil .= "</td></tr>";
			$i++;
		}
		
		$hasil .= "</table>";
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}

	public function generate_index_member($limit,$offset)
	{
		$i = $offset+1;
		$tot_hal = $this->db->get("dlmbg_user");

		$config['base_url'] = base_url() . 'web/member/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);
		
		$w = $this->db->get("dlmbg_user",$limit,$offset);
		
		$hasil = "";
		$hasil .= "<table cellpadding='8' cellspacing='0' style='border-collapse:collapse; width:100%;' border='1'>
				<thead>
				<tr class='warning'>
				<td width='30'><b>No.</b></td>
				<td><b>Nama</b></td>
				<td><b>Level</b></td>
				<td><b>Username</b></td>
				<td><b>Foto</b></td>
				<td>Kirim Pesan</td>
				</tr>
				</thead>";
				
		foreach($w->result() as $h)
		{
			$gbr = "no-img.jpg";
			if($h->gbr!="")
			{
				$gbr = $h->gbr;
			}
			$hasil .= "<tr><td>".$i." </td><td>".$h->nama_user." </td><td>".$h->level." </td><td>".$h->username." </td>
			<td><img src='".base_url()."asset/gravatar-member/thumb/".$gbr."' width='50'> </td>
			<td><a href='".base_url()."global/inbox/pesan_baru/".$h->kode_user."' class='input-button'>
			<i class='icon-edit'></i> Kirim Pesan</a>";
			
			$hasil .= "</td></tr>";
			$i++;
		}
		
		$hasil .= "</table>";
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}

	public function generate_detail_dosen($param)
	{
		$where['id_kinerja'] = $param;
		
		$this->db->select("*")->join("dlmbg_dosen","dlmbg_kinerja.id_dosen=dlmbg_dosen.id_dosen")->join("dlmbg_rekomendasi","dlmbg_kinerja.id_rekomendasi=dlmbg_rekomendasi.id_rekomendasi");
		$w = $this->db->get_where("dlmbg_kinerja",$where);
		
		$hasil = "";
		$hasil .= "<table cellpadding='8' cellspacing='0'>";
				
		foreach($w->result() as $h)
		{
			$gbr = "no-image.jpg";
			if($h->gambar!="")
			{
				$gbr = $h->gambar;
			}
			$hasil .= "<tr><td>Nomor</td><td>:</td><td>".$h->nomor." </td></tr>";
			$hasil .= "<tr><td>Nama</td><td>:</td><td>".$h->nama." </td></tr>";
			$hasil .= "<tr><td>Jenis Kegiatan</td><td>:</td><td>".$h->jenis_kegiatan." </td></tr>";
			$hasil .= "<tr><td>Bukti Penugasan</td><td>:</td><td>".$h->bukti_penugasan." </td></tr>";
			$hasil .= "<tr><td>SKS Penugasan</td><td>:</td><td>".$h->sks_penugasan." </td></tr>";
			$hasil .= "<tr><td>Masa Penugasan</td><td>:</td><td>".$h->masa_penugasan." </td></tr>";
			$hasil .= "<tr><td>Bukti Dokumen</td><td>:</td><td>".$h->bukti_dokumen." </td></tr>";
			$hasil .= "<tr><td>SKS Dokumen</td><td>:</td><td>".$h->sks_dokumen." </td></tr>";
			$hasil .= "<tr><td>Rekomendasi</td><td>:</td><td>".$h->rekomendasi." </td></tr>";
			$hasil .= "<tr><td>Jenis Kerja</td><td>:</td><td>".$h->jenis_kinerja." </td></tr>";
		}
		
		$hasil .= "</table>";
		$hasil .= $this->pagination->create_links();
		return $hasil;
	}

	public function generate_banner_gallery()
	{
		$w = $this->db->order_by("id_banner","DESC")->get("dlmbg_banner");
		
		$hasil = "";
				
		foreach($w->result() as $h)
		{
			$hasil .= '<img src="'.base_url().'asset/banner/'.$h->gbr.'" width="583" height="314" title="'.$h->judul.'"/> ';
		}
		return $hasil;
	}

	public function generate_banner_berita($limit)
	{
		$w = $this->db->order_by("id_berita","DESC")->get("dlmbg_berita",$limit,0);
		
		$hasil = "";
				
		foreach($w->result() as $h)
		{
			$hasil .= '<span class="WhiteTxt3">Posted on '.$h->tgl_post.' - '.$h->jam_post.'</span>
			<strong><span class="YellowTxt"><div class="padding-tittle">'.$h->judul.'</div>
			</span></strong>
			'.strip_tags(substr($h->isi,0,250)).'
			<a href="'.base_url().'web/berita/detail/'.$h->id_berita.'" title="'.$h->judul.'"><strong>read more</strong></a><br /><div class="line-green2"></div>';
		}
		return $hasil;
	}

	public function generate_home_berita($limit)
	{
		$w = $this->db->order_by("id_berita","DESC")->get("dlmbg_berita",$limit,2);
		
		$hasil = "";
				
		foreach($w->result() as $h)
		{
			$gbr = "no-image.jpg";
			if($h->gbr!="")
			{
				$gbr = $h->gbr;
			}
			$hasil .= '<div style="width:100%; height:15px; clear:right;"></div><div class="line-grey"></div><div style="width:100%; height:15px; clear:right;"></div>
	    <table width="700" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="17%" valign="top"><img src="'.base_url().'asset/berita/'.$gbr.'" width="118" height="89" class="img-border" /></td>
        <td width="3%" valign="top">&nbsp;</td>
        <td width="80%" valign="top"><span class="date-txt">'.$h->tgl_post.' - '.$h->jam_post.'</span><br />
          <span class="h1-black"><strong>'.$h->judul.'</strong></span><br />
          <br />
			'.strip_tags(substr($h->isi,0,250)).'
			<a href="'.base_url().'web/berita/detail/'.$h->id_berita.'" title="'.$h->judul.'"><strong>read more</strong></a></td>
      </tr>
    </table>';
		}
		return $hasil;
	}

	public function generate_detail_berita($param)
	{
		$where['id_berita'] = $param;
		$w = $this->db->get_where("dlmbg_berita",$where);
		
		$hasil = "";
				
		foreach($w->result() as $h)
		{
			$gbr = "no-image.jpg";
			if($h->gbr!="")
			{
				$gbr = $h->gbr;
			}
			$hasil .= '<strong class="h1-black2">'.$h->judul.'</strong>
<div class="cleaner_h10"></div>
<span class="date-txt">'.$h->tgl_post.' - '.$h->jam_post.'</span>
	
	<div class="cleaner_h10"></div>
	<table width="700" border="0" cellspacing="0" cellpadding="0">
      <tr>
	  <td>
	<!-- AddThis Button BEGIN -->
	<div class="addthis_toolbox addthis_default_style ">
	<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
	<a class="addthis_button_tweet"></a>
	<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
	<a class="addthis_counter addthis_pill_style"></a>
	</div>
	<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fd4ba7a210b88f3"></script>
	<!-- AddThis Button END -->
	  </td>
    </table>
	<div class="cleaner_h10"></div>
	
	<div id="detail-img-with-article">
	<img src="'.base_url().'asset/berita/'.$gbr.'" width="320" />
	<div class="cleaner_h10"></div>
	
	</div>'.$h->isi.'
	';
		}
		return $hasil;
	}






	public function generate_index_cari_dosen($limit,$offset)
	{
		$i = $offset+1;
		$cari['nama'] = $this->session->userdata("cari_data");
		$tot_hal = $this->db->like($cari)->get_where("dlmbg_dosen",$cari);

		$config['base_url'] = base_url() . 'web/dosen/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);
		
		$w = $this->db->like($cari)->get("dlmbg_dosen",$limit,$offset);
		
		$hasil = "";
		$hasil .= "<table cellpadding='8' cellspacing='0' style='border-collapse:collapse; width:100%;' border='1'>
				<thead>
				<tr class='warning'>
				<td width='30'><b>No.</b></td>
				<td><b>Nama</b></td>
				<td><b>NIP</b></td>
				<td><b>Email</b></td>
				<td><b>Foto</b></td>
				<td>Cek Detail</td>
				</tr>
				</thead>";
				
		foreach($w->result() as $h)
		{
			$gbr = "no-image.jpg";
			if($h->gambar!="")
			{
				$gbr = $h->gambar;
			}
			$hasil .= "<tr><td>".$i." </td><td>".$h->nama." </td><td>".$h->nip." </td><td>".$h->email." </td>
			<td><img src='".base_url()."asset/foto-dosen/".$gbr."' width='50'> </td>
			<td><a href='".base_url()."web/dosen/detail/".$h->id_dosen."' class='input-button'>
			<i class='icon-edit'></i> Detail</a>";
			
			$hasil .= "</td></tr>";
			$i++;
		}
		
		$hasil .= "</table>";
		//$hasil .= $this->pagination->create_links();
		return $hasil;
	}

	public function generate_index_cari_kinerja($limit,$offset)
	{
		$i = $offset+1;
		$cari['jenis_kegiatan'] = $this->session->userdata("cari_data");
		$cari['a.id_dosen'] = $this->session->userdata("id_dosen_kinerja");
		
		$this->db->like($cari)->select("*")->join("dlmbg_dosen b","a.id_dosen=b.id_dosen");
		$tot_hal = $this->db->get("dlmbg_kinerja a");

		$config['base_url'] = base_url() . 'web/kinerja_bidang/set/'.$cari.'/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 5;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);
		
		$this->db->select("*")->join("dlmbg_dosen b","a.id_dosen=b.id_dosen");
		$w = $this->db->like($cari)->get("dlmbg_kinerja a",$limit,$offset);
		
		$hasil = "";
		$hasil .= "<table cellpadding='8' cellspacing='0' style='border-collapse:collapse; width:100%;' border='1'>
				<thead>
				<tr class='warning'>
				<td width='30'><b>No.</b></td>
				<td><b>Nama</b></td>
				<td><b>Jenis Kegiatan</b></td>
				<td><b>SKS</b></td>
				<td><b>Masa Penugasan</b></td>
				<td>Cek Detail</td>
				</tr>
				</thead>";
				
		foreach($w->result() as $h)
		{
			$gbr = "no-image.jpg";
			if($h->gambar!="")
			{
				$gbr = $h->gambar;
			}
			$hasil .= "<tr><td>".$i." </td><td>".$h->nama." </td><td>".$h->jenis_kegiatan." </td><td>".$h->sks_penugasan." </td><td>".$h->masa_penugasan." </td>
			<td><a href='".base_url()."web/kinerja_bidang/detail/".$cari."/".$h->id_kinerja."' class='input-button'>
			<i class='icon-edit'></i> Detail</a>";
			
			$hasil .= "</td></tr>";
			$i++;
		}
		
		$hasil .= "</table>";
		//$hasil .= $this->pagination->create_links();
		return $hasil;
	}

	public function generate_index_cari_member($limit,$offset)
	{
		$i = $offset+1;
		$cari['nama_user'] = $this->session->userdata("cari_data");
		$tot_hal = $this->db->like($cari)->get("dlmbg_user");

		$config['base_url'] = base_url() . 'web/member/index/';
		$config['total_rows'] = $tot_hal->num_rows();
		$config['per_page'] = $limit;
		$config['uri_segment'] = 4;
		$config['first_link'] = 'First';
		$config['last_link'] = 'Last';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Prev';
		$this->pagination->initialize($config);
		
		$w = $this->db->like($cari)->get("dlmbg_user",$limit,$offset);
		
		$hasil = "";
		$hasil .= "<table cellpadding='8' cellspacing='0' style='border-collapse:collapse; width:100%;' border='1'>
				<thead>
				<tr class='warning'>
				<td width='30'><b>No.</b></td>
				<td><b>Nama</b></td>
				<td><b>Level</b></td>
				<td><b>Username</b></td>
				<td><b>Foto</b></td>
				<td>Kirim Pesan</td>
				</tr>
				</thead>";
				
		foreach($w->result() as $h)
		{
			$gbr = "no-img.jpg";
			if($h->gbr!="")
			{
				$gbr = $h->gbr;
			}
			$hasil .= "<tr><td>".$i." </td><td>".$h->nama_user." </td><td>".$h->level." </td><td>".$h->username." </td>
			<td><img src='".base_url()."asset/gravatar-member/thumb/".$gbr."' width='50'> </td>
			<td><a href='".base_url()."global/inbox/pesan_baru/".$h->kode_user."' class='input-button'>
			<i class='icon-edit'></i> Kirim Pesan</a>";
			
			$hasil .= "</td></tr>";
			$i++;
		}
		
		$hasil .= "</table>";
		//$hasil .= $this->pagination->create_links();
		return $hasil;
	}

}
