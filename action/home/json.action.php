<?php

class JsonAction extends JAction{
	
	public function home_cat_tj(){

		$cid=$_GET['cid'];

		empty($cid) && $cid=0;

		$catinfo=tbk('XTICat',array('action'=>'get.sync','cid'=>$cid,'sign'=>'catinfo'));

		$tbcids=$catinfo['tbcids'];

		xshop('XSIRecommand',array('action'=>'home.cat.recommand','sign'=>'todaycatrecommand','tbcids'=>$tbcids,'limit'=>30));

		$data=XBR();

		$result=array();

		$todaycatrecommand=$data['todaycatrecommand']['value'];

		$total=$data['todaycatrecommand']['total'];

		foreach ($todaycatrecommand as $item) {
			
			$result[]=array_merge($item,array('price'=>number_format($item['price'],1),'commission'=>number_format($item['commission']*TB_TICHENG,1)));
		}

		echo json_encode(array('total'=>$total,'cid'=>$cid,'value'=>$result));
	}

	public function home_cu99_tj(){

		$cid=$_GET['cid'];

		empty($cid) && $cid=0;

		$catinfo=tbk('XTICat',array('action'=>'get.sync','cid'=>$cid,'sign'=>'catinfo'));

		$tbcids=$catinfo['tbcids'];

		xshop('XCIRecommand',array('action'=>'home.9.9.yuan','sign'=>'home99yuan','tbcids'=>$tbcids));

		$data=XBR();

		$home99yuan=$data['home99yuan']['value'];

		foreach($home99yuan as $cuitem) $iids[]=$cuitem['id'];
		
		$home99detail=xshop('XSItem',array('action'=>'some','iids'=>$iids,'sign'=>'home99detail'));
		//print_r($iids);
		$cu99items=array();

		foreach($home99yuan as $cuitem){

			$iid=$cuitem['id'];

			foreach($home99detail['value'] as $tbitem){

				if($tbitem['id']==$iid) $cu99items[]=array_merge($tbitem,$cuitem,array('price'=>number_format($tbitem['price'],1),'cprice'=>number_format($cuitem['cprice'],1),'commission'=>number_format($cuitem['commission']*TB_TICHENG,1)));
				
			}
		}

		echo json_encode(array('cid'=>$cid,'value'=>$cu99items));
	}

	public function s(){

		$q=$_GET['q'];
		
		$q=is_utf8($q)?urldecode($q):rawurldecode(mb_convert_encoding($q,'utf-8','gb2312'));
		
		$cid=$_GET['cid'];

		tbk('XTICat',array('action'=>'get','sign'=>'catinfo','cid'=>$cid));

		$data=XBR();

		$catinfo=$data['catinfo']['value'][0];

		$bid=$_GET['bid'];

		$page=$_GET['page'];

		search('STbkItem',array('action'=>'filter','sign'=>'searchitems','page'=>$page,'tbcids'=>$catinfo['tbcids'],'bid'=>$bid,'q'=>$q,'limit'=>40));

		$data=XBR();
		//print_r($data);
		$items=$data['searchitems'];

		echo json_encode($items);
	}
}