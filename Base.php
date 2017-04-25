<?php
namespace vote;
use think\Request;
use think\Config;


defined('VOTE_DIR') or define('VOTE_DIR',__DIR__. DS);
defined('VOTE_VIEW_HOME_PATH') or define(VOTE_DIR.'home'. DS . 'view');
defined('VOTE_VIEW_ADMIN_PATH') or define(VOTE_DIR.'admin'. DS . 'view');
defined('VOTE_STYLE_PATH') or define('VOTE_STYLE_PATH','/static/vote/');// 根目录下的 static

defined('VOTE_HOME_STYLE_PATH') or define('VOTE_HOME_STYLE_PATH','/public/static/vote/home/');
define('WEIXIN_CACHE_PATH', 'F:\2017_web_sys\huiz_crm_v1.0\runtime');   //

class Base {
	
	public function __construct()
	{
		$this->request      = Request::instance();
		
		//加载组件配置
		Config::load(VOTE_DIR."config.php",'','vote') ;
		
		//缓存设置
		$cache_config = Config::get("cache",'vote');
		cache($cache_config);

		
		//参数过滤检测
		$sysconfig_default_filter = Config::get("default_filter");
		if(!$sysconfig_default_filter){
			$default_filter =  Config::get("default_filter",'vote');
			$this->request->filter($default_filter);
		}
		
		$this->param        = $this->request->param();
		$this->module       = $this->request->module();
		$this->controller   = $this->request->controller();
		$this->action       = $this->request->action();
		
	}
	
	/**
	 * 加载控制器方法
	 * @access public
	 * @param  string $controller 控制器
	 * @param  string $action 方法名
	 * @return mixed
	 */
	public function autoload($controller,$action){
	
		$className = '\\vote\\admin\\controller\\'.$controller;
		$controller = new $className($this->request);
		if(method_exists($controller,$action)){
			return  call_user_func([$controller, $action]);
		}
		return false;
	}
	
	/**
	 * 加载控制器方法
	 * @access public
	 * @param  string $controller 控制器
	 * @param  string $action 方法名
	 * @return mixed
	 */
	public function autoload2($controller,$action){
	
		$className = '\\vote\\home\\controller\\'.$controller;
		$controller = new $className($this->request);
		if(method_exists($controller,$action)){
			return  call_user_func([$controller, $action]);
		}
		return false;
	}
	
}
include_once  VOTE_DIR . 'extend/common.php';



