<?php namespace Admin\Controller;

use Common\Controller\CommonController;

class AboutController extends CommonController
{
	################## 品牌  ##########################
	//品牌首页显示
	public function about()
	{
		$about  = D("About");
		$result = $about->Order("id desc")->select();
		
		
		$this->assign("result", $result);
		$this->display();
	}
	
	//品牌页面添加
	public function addAbout()
	{
		if (IS_POST) {
			
			$about = M("About");
			
			$img   = I("post.imgs");
			$text  = I("post.text");	
			if (empty($img)) { 
				$this->error("图片不能为空!");
			}
			if (empty($text)) {
				$this->error("文本不能为空!");
			}

			$result = $about->add( I("post.") );
			if ($result) {
				$this->success("添加成功!", U("Admin/About/about")); exit;
			} else {
				$this->error("添加失败!"); exit;
			}
		}
		$this->display();
	}
	
	//品牌页面编辑
	public function editAbout()
	{
		$about  = M("About");
		
		$where['id']   = I("id");
		$result = $about->where($where)->find(); 
		
		$this->assign("result", $result);
		$this->display();
	}
	
	//编辑后数据提交
	public function doEditAbout()
	{
		$id     = I("id");
		$about  = M("About");
		
		$result = $about->where(array(
			'id'   => $id,
		))->save( I("post."));
		if ($result) {
			$this->success("更新成功!", U("Admin/About/about", '', false)); exit;
		} else {
			$this->error("数据没有变动", U("Admin/About/about", '', false), 1); exit;
		}
	}
	
	public function delAbout()
	{
		$id     = I("id");
		$data   = M("About");
		
		$result = $data->where(array(
				'id' => $id,
		))->delete();
		
		if ($result) {
			$this->success("删除成功!", U("Admin/About/about", '', false));
		} else {
			$this->error("删除失败!", U("Admin/About/about"), 1);
		}
	}
	
	
	################# 贡献  ###########################
	//贡献页面
	public function contribution()
	{
		$about  = M("Contribution");
		$result = $about->select();
		
		$this->assign("result", $result);
		$this->display();			
	}
	
	//贡献页面添加
	public function addContribution()
	{
		if (IS_POST) {
			$about  = M("Contribution");
			
			$heads  = I("post.heads");
			$title  = I("post.tilte");
			$text   = I("post.text");
			$imgs   = I("post.imgs");
			
			if(empty($heads)) {
				$this->error("模块标题不能为空");
			}
			if(empty($title)) {
				$this->error("图片标题不能为空");
			}
			if(empty($text)) {
				$this->error("图片描述不能为空");
			}
			if(empty($imgs)) {
				$this->error("图片不能为空");
			}
	
			$result = $about->add( I("post.") );
			if ($result) {
				$this->success("添加成功!", U("Admin/About/contribution",'',false)); exit;
			} else {
				$this->error("添加失败"); exit;
			} 
		}
		$this->display();
	}
	
	//贡献页面编辑
	public function editContribution()
	{
		$id = I("id");
		$about  = M("Contribution");
		$result = $about->where(array(
			"id"=> $id,
		))->find();
		
		$this->assign("result", $result);
		$this->display();
	}
	
	//修改后的贡献页面
	public function doEditContribution()
	{
		$Contribution = M("Contribution");
		$id 	= I("id");
		$heads  = I("post.heads");
		$title  = I("post.tilte");
		$text   = I("post.text");
		$imgs   = I("post.imgs");
			
		if(empty($heads)) {
			$this->error("模块标题不能为空");
		}
		if(empty($title)) {
			$this->error("图片标题不能为空");
		}
		if(empty($text)) {
			$this->error("图片描述不能为空");
		}
		if(empty($imgs)) {
			$this->error("图片不能为空");
		}
		
		$result = $Contribution->where(array(
				"id" => $id,
			))->save( I("post.") );
		
		if ($result) {
			$this->success("修改成功!", U("Admin/About/contribution", '', false)); exit;
		} else {
			$this->error("修改失败!"); exit;
		}
	}
	
	//删除一条数据
	public function delContribution()
	{
		$id = I("id");
		$contribution = M("Contribution");
		$result = $contribution->where(array(
			"id" => $id,
		))->delete();
		
		if ($result) {
			$this->success("删除成功!", U("Admin/About/contribution", '', false)); exit;
		} else {
			$this->error("删除失败!", U("Admin/About/contribution"), 1); exit;
		}
	}
	
	
	#################### 广告 #########################
	//广告页面
	public function advertising()
	{
		$about  = M("Advertisement");
		
		$count  = $about->count();
		$page   = getpage($count, 6);
		$show	= $page->show();
		
		$result = $about->Order("dates asc")
				->limit($page->firstRow .','. $page->listRows)
				->select();
		
		$this->assign("result", $result);
		$this->assign("page",	$show);
		$this->display();
	}
	
	//添加一条数据
	public function addAdvertising()
	{
		if (IS_POST) {
		
			$Advertisement  = M("Advertisement");
			
			$imgs       = I("post.imgs");
			$video_url  = I("post.video_url");
			$btn_img	= I("post.btn_img");
			$date       = I("post.dates");
			$name       = I("post.name");
			if(empty($imgs)) {
				$this->error("图片不能为空");
			}
			if (empty($btn_img)) {
				$this->error("小图不能为空");
			}
			if(empty($video_url)) {
				$this->error("图片路径不能为空");
			}
			if(empty($date)) {
				$this->error("日期不能为空");
			}
  
			$data['dates']   	= substr(I("dates"), 0, 4);
			$data['imgs']	 	= I("imgs");
			$data['small_imgs']	= I("btn_img");
			$data['video_url']	= I("video_url");
			$data['name']		= I("name");
			$result = $Advertisement->add( $data );
			if ($result) {
				$this->success("添加成功!", U("Admin/About/advertising", '', false)); exit;
			} else {
				$this->error("添加失败"); exit;
			}
		}
		$this->display();
	}
	
	//广告页面编辑
	public function editAdvertising()
	{
		$id = I("id");
		$Advertisement  = M("Advertisement");
		$result = $Advertisement->where(array(
			"id" => $id,
		))->find();
		
		$this->assign("result", $result);
		$this->display();
	}
	
	//编辑以后的数据
	public function doEditAdvertising()
	{
		if (IS_POST) {
			$id = I("id");
			$Advertisement  = M("Advertisement");
				
			$imgs       = I("post.imgs");
			$btn_img	= I("post.btn_img");
			$video_url  = I("post.video_url");
			$date       = I("post.dates");
			$name       = I("post.name");
			if(empty($imgs)) {
				$this->error("图片不能为空");
			}
			if (empty($btn_img)) {
				$this->error("小图不能为空");
			}
			if(empty($video_url)) {
				$this->error("图片路径不能为空");
			}
			if(empty($date)) {
				$this->error("日期不能为空");
			}
		
			$data['dates']   	= substr(I("dates"), 0, 4);
			$data['imgs']	 	= I("imgs");
			$data['small_imgs']	= I("btn_img");
			$data['video_url']	= I("video_url");
			$data['name']		= I("name");
			if(!$data['video_url']){
				unset($data['video_url']);
			}
			
			
			$result = $Advertisement->where(array("id" => $id))->save( $data );
			if ($result) {
				$this->success("更新成功!", U("Admin/About/advertising", '', false)); exit;
			} else { 
				$this->error("数据没有变动", U("Admin/About/advertising", '', false), 1); exit;
			}
		}	
	}
	
	//删除一条数据
	public function delAdvertising()
	{
		$id = I("id");
		$contribution = M("Advertisement");
		$result = $contribution->where(array(
				"id" => $id,
		))->delete();
	
		if ($result) {
			$this->success("删除成功!", U("Admin/About/advertising", '', false)); exit;
		} else {
			$this->error("删除失败!", U("Admin/About/advertising"), 1); exit;
		}
	}
	
	
	#################### 素颜清晰 #######################
	//素颜小清晰
	public function distinct()
	{
		$distinct  = M("Distinct");
		$count     = $distinct->count();
		
		$page      = getpage($count, 6);
		$show	   = $page->show();
		
		$result    = $distinct->limit(
			$page->firstRow. ',' .$page->listRows
		)->select();
		
		$this->assign("result", $result);
		$this->assign("page",	$show);
		$this->display();
	}
	
	public function addDistinct()
	{
		if (IS_POST) {
			$Advertisement  = M("Distinct");
				
			$imgs       = I("post.imgs");
			$video_url  = I("post.video_url");
			$date       = I("post.dates");
		
			if(empty($imgs)) {
				$this->error("图片不能为空");
			}
			if(empty($video_url)) {
				$this->error("图片路径不能为空");
			}
			if(empty($date)) {
				$this->error("日期不能为空");
			}
		
			$data['dates']   	= substr(I("dates"), 0, 4);
			$data['imgs']	 	= I("imgs");
			$data['video_url']	= I("video_url");
			
			$result = $Advertisement->add( $data );
			if ($result) {
				$this->success("添加成功!", U("Admin/About/distinct", '', false)); exit;
			} else {
				$this->error("添加失败"); exit;
			}
		}
		$this->display();
	}
	
	//素颜小清晰编辑
	public function editDistinct()
	{
		$id = I("id");
		$Advertisement  = M("Distinct");
		$result = $Advertisement->where(array(
			"id" => $id,
		))->find();
		
		$this->assign("result", $result);
		$this->display();
	}
	
	//编辑以后的数据
	public function doEditDistinct()
	{
		if (IS_POST) {
			$id = I("id");
			$Advertisement  = M("Distinct");
	
			$imgs       = I("post.imgs");
			$video_url  = I("post.video_url");
			$date       = I("post.dates");
	
			if(empty($imgs)) {
				$this->error("图片不能为空");
			}
			if(empty($video_url)) {
				$this->error("图片路径不能为空");
			}
			if(empty($date)) {
				$this->error("日期不能为空");
			}
	
			$data['dates']   	= substr(I("dates"), 0, 4);
			$data['imgs']	 	= I("imgs");
			$data['video_url']	= I("video_url");
			
			$result = $Advertisement->where(array("id" => $id))->save( $data );
			if ($result) {
				$this->success("更新成功!", U("Admin/About/distinct", '', false)); exit;
			} else {
				$this->error("数据没有变动", U("Admin/About/distinct", '', false), 1); exit;
			}
		}
	}
	
	//删除一条数据
	public function delDistinct()
	{
		$id = I("id");
		$contribution = M("Distinct");
		$result = $contribution->where(array(
				"id" => $id,
		))->delete();
	
		if ($result) {
			$this->success("删除成功!", U("Admin/About/distinct", '', false)); exit;
		} else { 
			$this->error("删除失败!", U("Admin/About/distinct"), 1); exit;
		}
	}
	
	
	#####################  自然恩惠 ######################
	
	//自然恩惠首页
	public function gift() 
	{
		$distinct  = M("Nature");
		$result = $distinct->select();
		
		$this->assign("result", $result);
		$this->display();
	}
	
	//添加一条数据
	public function addGift()
	{
		if (IS_POST) {
			$nature  = M("Nature");
				
			$imgs  = I("post.imgs");
			$text  = I("post.text");
		
			if(empty($imgs)) {
				$this->error("图片不能为空");
			}
			if(empty($text)) {
				$this->error("描述不能为空");
			}
		
			$result = $nature->add( I("post.") );
			if ($result) {
				$this->success("添加成功!", U("Admin/About/gift", '', false)); exit;
			} else {
				$this->error("添加失败"); exit;
			}
		}
		$this->display();
	}
	
	//自然恩惠编辑
	public function editGift()
	{
		$id = I("id");
		$Advertisement  = M("Nature");
		$result = $Advertisement->where(array(
			"id" => $id,
		))->find();
	
		$this->assign("result", $result);
		$this->display();
	}
	
	//编辑以后的数据
	public function doEditGift()
	{
		if (IS_POST) {
			$Advertisement  = M("Nature");
			$imgs    = I("post.imgs");
			$text    = I("post.text");
	
			if(empty($imgs)) {
				$this->error("logo不能为空");
			}
			if(empty($text)) {
				$this->error("描述不能为空");
			}
		
			$result = $Advertisement->save( I("post.") );
			if ($result) {
				$this->success("更新成功!", U("Admin/About/gift", '', false)); exit;
			} else {
				$this->error("数据没有变动", U("Admin/About/gift", '', false), 1); exit;
			}
		}
	}
	
	//删除数据
	public function delGift()
	{
		$id = I("id");
		$contribution = M("Nature");
		$result = $contribution->where(array(
			"id" => $id,
		))->delete();
	
		if ($result) {
			$this->success("删除成功!", U("Admin/About/gift", '', false)); exit;
		} else { 
			$this->error("删除失败!", U("Admin/About/gift"), 1); exit;
		} 
	}
	
}






