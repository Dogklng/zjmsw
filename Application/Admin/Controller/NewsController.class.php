<?php namespace Admin\Controller;

use Common\Controller\CommonController;

class NewsController extends CommonController
{
	//初始化父类
	public function _initialize()
	{
		parent::_initialize();
		$this->assign("urlname", ACTION_NAME);
	}
	
	//新闻管理首页
	public function index()
	{
		$is_show = array('是', '否');
		$news    = M("News");
		
		//显示分页
		$tatal = $news->where(array('status' => 0 ))->count();		
		$pages = getpage($tatal, 5);
		$show  = $pages->show();

		//模糊查询
		$title =  I("get.title");
		if ($title) {
			$where['title']	= array('like', "%".$title. "%");
		}
		
		$where['status'] = 0;
		//获取新闻列表
		$news_list = $news->where($where)
			->Order("id desc")
			->limit($pages->firstRow. ',' .$pages->listRows)
			->select();	
		
		//组织数据进行分配
		$this->assign("page" , $show);
		$this->assign("is_show", $is_show);
		$this->assign("news_list" ,$news_list);
		$this->display();	
	}
	
	//添加新闻
	public function addNews()
	{
		if (IS_POST) {
			$add_result = M("News")->add( I("post.") );
			if ($add_result) {
				$this->success("添加成功", U('Admin/News/index', '', false));
			} else {
				$this->error("添加失败", U('Admin/News/addNews', '', false));
			}
		}
		$this->display();
	}
	
	//编辑新闻
	public function editNews()
	{
		$id 	  = I("id");
		$news     = M("News");
		$one_news = $news->where(array(
			'id' 	 => $id,
			'status' => 0,
		))->find();

		$this->assign("one_news", $one_news);
		$this->display();
	}
	
	//编辑后的新闻数据信息
	public function doEditNews()
	{
		$id = I("id");
		$edit_news = M("News");
		$result    = $edit_news->where(array(
			"id"	=> $id,
		))->save( I("post.") );
		
		if ($result) {
			$this->success("编辑成功!", U('Admin/News/index', '', false));
		} else {
			$this->error("编辑失败", U('Admin/News/index', '', false));
		}
	}
	
	//删除新闻
	public function delNews()
	{
		$id = I("id");	
		$del_news = M("News");
		$result   = $del_news->where(array(
			"id"  => $id,
		))->save(array('status' => 1 ));
		
		if ($result) {
			$this->success("删除成功!", U('Admin/News/index', '', false));
		} else {
			$this->error("删除失败!", U('Admin/News/index', '', false));
		}
	}
	
}



