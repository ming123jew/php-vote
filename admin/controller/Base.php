<?php
namespace vote\controller;
use think\Config;
use vote\library\Tree;

class Base {
	
	const  PATH                 = __DIR__;
	public $request				= "";
	public $param				= "";
	public $post				= "";
	public $id					= 0 ;
	public $data				= "";
	public $user				= "";
	public $uid					= 0;
	public $username			= 'admin';
	
	//权限
	public $VOTE_role_table_name = "";
	public $VOTE_role_id = "";
	public $VOTE_role_name = "";
	public $VOTE_admin_table_name = "";
	public $VOTE_admin_role = "";
	
	public function __construct($request)
	{	
		//如果设置了session信息则,读取session
		$VOTE_admin_session = Config::get("VOTE_admin_session",'vote');
		
		if($VOTE_admin_session){
			$this->user = session($VOTE_admin_session);
		}
		$VOTE_admin_uid = Config::get("VOTE_admin_uid",'vote');
		if($VOTE_admin_uid && !array_key_exists('uid',$this->user)){
			$this->uid = $this->user[$VOTE_admin_uid];
			$this->user['uid'] = $this->uid;
		}else{
			$this->uid = $this->user['uid'];
		}
		$VOTE_admin_username = Config::get("VOTE_admin_username",'vote');
		if($VOTE_admin_username){
			$this->username = $this->user[$VOTE_admin_username];
		}
		
		
		$this->request  = $request;
		$this->param    = $this->request->param();
		$this->post     = $this->request->post();
		$this->id       = isset($this->param['id'])?intval($this->param['id']):'';
		$this->data     = ['pach'=>VOTE_VIEW_PATH,'static'=>VOTE_STYLE_PATH];
	}
	
	public function Tree($datas,$selected = 1,$field='id'){
		$tree = new Tree();
		$array = [];
		foreach ($datas as $r) {
			$r['selected'] = $r[$field] == $selected ? 'selected' : '';
			$array[] = $r;
		}
		$str = "<option value='\$id' \$selected>\$spacer \$name</option>";
		
		$tree->init($array);
		$parentid = isset($where['parentid'])?$where['parentid']:0;
	
		return $tree->get_tree($parentid, $str);
	}
	
}