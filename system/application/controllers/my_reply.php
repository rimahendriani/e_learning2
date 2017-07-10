<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class my_reply extends Controller {

	/**
	 * @author : Gede Lumbung
	 * @web : http://gedelumbung.com
	 **/

	function index($uri=0)
	{
		$d['menu'] = $this->app_global_web->generate_index_menu();

		$param = $this->session->userdata("kode_user");

		$d['detail'] = $this->app_global_forum->generate_index_forum_my_reply($param,$GLOBALS['site_limit_medium'],$uri);
		$d['nama'] = "My Reply : ".$this->session->userdata("nama_user_login");

 		$this->load->view($GLOBALS['site_theme']."/forum/bg_header",$d);
 		$this->load->view($GLOBALS['site_theme']."/forum/bg_left");
 		$this->load->view($GLOBALS['site_theme']."/forum/bg_my_thread");
 		$this->load->view($GLOBALS['site_theme']."/forum/bg_footer");
	}
}
