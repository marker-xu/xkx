<?php

/**
 * 控制器基类，放置一些控制器的公用属性和方法
 */
class Controller extends JKit_Controller
{
    const ERROR_NEED_LOGIN = 'sys.permission.need_login';
    
	protected $_uid; // 未登录为NULL，请不要修改成0或其它，有的地方依赖NULL值
	protected $_user;
	
	public function before() {
	    parent::before();
	    
		//用户信息初始化
		$this->_user = Session::instance()->get('user');
		if($this->_user) {
			$this->_uid = (int) $this->_user['_id'];
		}
		$this->template->set('login_user', $this->_user);
		// xhprof
    	if ($this->request->param('xhprof')) {
            if (!extension_loaded('xhprof')) {
                dl('xhprof.so');
            }
            xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
//            xhprof_enable(XHPROF_FLAGS_NO_BUILTINS);
        }
	}
	
	/**
	 * 
	 * 登录判断，跳转,ajax返回，错误
	 */
	protected function _needLogin() {
		if ( !$this->_uid || !$this->_user) {
			//deny not logined user
			if($this->request->is_ajax()) {
				$this->err(null, '请先登录！', null, null, self::ERROR_NEED_LOGIN);
			} else {
				$this->request->redirect('user/login?f=' . urlencode(preg_replace('/^\//', '', $_SERVER['REQUEST_URI'])));
			}
			exit();
		}
	}
	
    public function after()
    {
        // xhprof
        if ($this->request->param('xhprof')) {
            $xhprof_data = xhprof_disable();
            include_once DOCROOT."/xhprof_lib/utils/xhprof_lib.php";
            include_once DOCROOT."/xhprof_lib/utils/xhprof_runs.php";
            $xhprof_runs = new XHProfRuns_Default();
            $xhprofid = $xhprof_runs->save_run($xhprof_data, "xhprof");
            $this->trace('xhprofid', $xhprofid);
        }
        
        parent::after();
    }
}