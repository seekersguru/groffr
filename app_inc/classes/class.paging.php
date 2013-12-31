<?php
	class Page
	 {
		var $total_records			= 1;    /// Total Records returned by sql query
		var $records_per_page		= 1;    /// how many records would be displayed at a time
		var $page_name				= "";   /// page name on which the class is called
		var $start					= 0;
		var $page					= 0;
		var $total_page				= 0;
		var $current_page;
		var $remain_page;
		var $show_prev_next			= true;
		var $show_scroll_prev_next	= false;
		var $show_first_last		= false;
		var $show_disabled_links	= true;
		var $scroll_page			= 0;
		var $qry_str				= "";
		var $link_para				= "";
		

		/* returns boolean value if it is last page or not*/
		function is_last_page() {
			return $this->page>=$this->total_page-1?true:false;
		}


		/* param : Void
		 returns boolean value if it is first page or not*/
		function is_first_page(){
			return $this->page==0?true:false;
		}


		function current_page(){
			return $this->page;
		}


		function total_page(){
			return $this->total_page==0?1:$this->total_page;
		}


		//@param : $show = if you want to show desabled links on navigation links.
		//
		function show_disabled_links($show=TRUE){
			$this->show_disabled_links=$show;
		}


		//@param : $link_para = if you want to pass any parameter to link
		//
		function set_link_parameter($link_para){
			$this->link_para=$link_para;
		}


		function set_page_name($page_name){
			$this->page_name=$page_name;
		}


		//@param : str= query string you want to pass to links.
		function set_qry_string($str=""){
			$this->qry_str="&".$str;
		}


		function set_scroll_page($scroll_num=0){
			if($scroll_num!=0)
				$this->scroll_page=$scroll_num;
			else
				$this->scroll_page=$this->total_records;
		}


		function set_total_records($total_records){
			if($total_records<0)
				$total_records=0;
			$this->total_records=$total_records;
		}


		function set_records_per_page($records_per_page){
			if($records_per_page<=0)
				$records_per_page=$this->total_records;
			$this->records_per_page=$records_per_page;
		}
		/* @params
		* 	$page_name = Page name on which class is integrated. i.e. $_SERVER['PHP_SELF']
		*  	$total_records=Total records returnd by sql query.
		* 	$records_per_page=How many projects would be displayed at a time
		*		$scroll_num= How many pages scrolled if we click on scroll page link.
		* 				i.e if we want to scroll 6 pages at a time then pass argument 6.
		* 	$show_prev_next= boolean(true/false) to show prev Next Link
		* 	$show_scroll_prev_next= boolean(true/false) to show scrolled prev Next Link
		* 	$show_first_last= boolean(true/false) to show first last Link to move first and last page.
		*/


		function set_page_data($page_name,$total_records,$records_per_page=1,$scroll_num=0,$show_prev_next=true,$show_scroll_prev_next=false,$show_first_last=false) {
		
			$this->set_total_records($total_records);
			$this->set_records_per_page($records_per_page);
			$this->set_scroll_page($scroll_num);
			$this->set_page_name($page_name);
			$this->show_prev_next=$show_prev_next;
			$this->show_scroll_prev_next=$show_scroll_prev_next;
			$this->show_first_last=$show_first_last;
		}


		/* @params
		*  $user_link= if you want to display your link i.e if you want to user '>>' instead of [first] link then use
		Page::get_first_page_nav(">>") OR for image
		Page::get_first_page_nav("<img src='' alt='first'>")
		$link_para: link parameters i.e if you want ot use another parameters such as class.
		Page::get_first_page_nav(">>","class=myStyleSheetClass")
		*/
		function get_first_page_nav($user_link="",$link_para="") {
			if($this->total_page<=1)
				return;
			if(trim($user_link)=="")
				$user_link=" First ";
			if(!$this->is_first_page()&& $this->show_first_last)
				$user_link= ' <a href="'.$this->page_name.'/page/0'.$this->qry_str.'" '.$link_para.'>'.$user_link.'</a> '." | ";
			elseif($this->show_first_last && $this->show_disabled_links)
				$user_link= $user_link." | ";
				return $user_link;
				
		}


		function get_last_page_nav($user_link="",$link_para="") {
			if($this->total_page<=1)
				return;
			if(trim($user_link)=="")
				$user_link=" Last ";
			if(!$this->is_last_page()&& $this->show_first_last)
            {
			$user_link='<a href="'.$this->page_name.'/page/'.($this->total_page-1).$this->qry_str.'" '.$link_para.'>'.$user_link.'</a>';
            }
			elseif($this->show_first_last && $this->show_disabled_links)
				$user_link= $user_link;
				return $user_link; 
		}
 

		function get_next_page_nav($user_link="",$link_para="") {
			if($this->total_page<=1)
				return;
			if(trim($user_link)=="")
				$user_link=" Next";
			if(!$this->is_last_page()&& $this->show_prev_next)
				$user_link= ' <a href="'.$this->page_name.'/page/'.($this->page+1).$this->qry_str.'" '.$link_para.'>'.$user_link.'</a> '." | ";
			elseif($this->show_prev_next && $this->show_disabled_links)
				$user_link= $user_link." | ";
				return $user_link;
		}


		function get_prev_page_nav($user_link="",$link_para="") {
			if($this->total_page<=1)
				return;
			if(trim($user_link)=="")
				$user_link=" Prev";
			if(!$this->is_first_page()&& $this->show_prev_next)
				$user_link=' <a href="'.$this->page_name.'/page/'.($this->page-1).$this->qry_str.'" '.$link_para.'>'.$user_link.'</a> '." | ";
			elseif($this->show_prev_next && $this->show_disabled_links)
				$user_link= $user_link." | ";
				return $user_link;
		}


		function get_scroll_prev_page_nav($user_link="",$link_para="") {
			if($this->scroll_page>=$this->total_page)
				return;
			if(trim($user_link)=="")
				$user_link=" Prev [$this->scroll_page] ";
			if($this->page>$this->scroll_page &&$this->show_scroll_prev_next)
				$user_link= ' <a href="'.$this->page_name.'/page/'.($this->page-$this->scroll_page).$this->qry_str.'" '.$link_para.'>'.$user_link.'</a> '." | ";
			elseif($this->show_scroll_prev_next && $this->show_disabled_links)
			$user_link= $user_link." | ";
			return $user_link;
		}


		function get_scroll_next_page_nav($user_link="",$link_para="") {
			if($this->scroll_page>=$this->total_page)
				return;
			if(trim($user_link)=="")
				$user_link=" Next [$this->scroll_page]";
			if($this->total_page>$this->page+$this->scroll_page &&$this->show_scroll_prev_next)
				$user_link= ' <a href="'.$this->page_name.'/page/'.($this->page+$this->scroll_page).$this->qry_str.'" '.$link_para.' >'.$user_link.'</a> '." | ";
			elseif($this->show_scroll_prev_next && $this->show_disabled_links)
				$user_link= $user_link." | ";
				return $user_link;
		}


		function get_number_page_nav($link_para="") {
																																																																																																																									
			$j=0;
			$link   ="";
			$scroll_page=$this->scroll_page;

			if($this->page>($scroll_page/2))
				$j=$this->page-intval($scroll_page/2);

			if($j+$scroll_page>$this->total_page)
			$j=$this->total_page-$scroll_page;

			if($j<0)
				 $i=0;
			else
				$i=$j;

			for(;$i<$j+$scroll_page && $i<$this->total_records;$i++)
			{
				if($i==$this->page)
				$link.=	 " <span >".($i+1)." | </span>";
				else
					$link.= ' <a href="'.$this->page_name.'/page/'.$i.$this->qry_str.'" '.$link_para.'>'.($i+1).'</a> '." | ";
			}
			if($this->total_page>1){
			return $link;
			}
		}


		function get_page_nav() {
			if($this->total_records<=0)
			{
				//echo "No Records Found";
				return false;
			}
			$this->calculate();
			$d1=$this->get_first_page_nav("",$this->link_para);
			//$d1.=$this->get_scroll_prev_page_nav("",$this->link_para);
			$d1.=$this->get_prev_page_nav("",$this->link_para);
			$d1.=$this->get_number_page_nav($this->link_para);
			$d1.=$this->get_next_page_nav("",$this->link_para);
			//$d1.=$this->get_scroll_next_page_nav("",$this->link_para);
			$d1.=$this->get_last_page_nav("",$this->link_para);
			return $d1;
			
		}
		function get_page_nav_front_panel() {
			if($this->total_records<=0)
			{
				//echo "No Records Found";
				return false;
			}
			$this->calculate();
			$d1=$this->get_first_page_nav("",$this->link_para);
			//$d1.=$this->get_scroll_prev_page_nav("",$this->link_para);
			$d1.=$this->get_prev_page_nav("",$this->link_para);
			//$d1.=$this->get_number_page_nav($this->link_para);
			$d1.=$this->get_next_page_nav("",$this->link_para);
			//$d1.=$this->get_scroll_next_page_nav("",$this->link_para);
			$d1.=$this->get_last_page_nav("",$this->link_para);
			return $d1;
			
		}


		function calculate() {
		if(isset($_REQUEST['page1'])&&($_REQUEST['page1'])){
			$this->page=@($_REQUEST['page1']-1);
			}else{
			$this->page=@$_REQUEST['page'];
			}
			if(!is_numeric($this->page))
			$this->page=0;
			$this->start=$this->page*$this->records_per_page;
			$this->total_page=@intval($this->total_records/$this->records_per_page);
			if($this->total_records%$this->records_per_page!=0)
			$this->total_page++;
		}


		function get_limit_query($qry="") {
			$this->calculate();
			
			return $qry." LIMIT $this->start,$this->records_per_page";
		}

	}





	/* Example 
        <table width="800" align="center">
        <tr>
            <td align='center'>
        <?
            $sql="SELECT username FROM member";
            $result=@mysql_query($sql);

            $total_records      =   @mysql_num_rows($result);
            $record_per_page    =   10;
            $scroll             =   10;

            $page=new Page(); ///creating new instance of Class Page
            $page->set_page_data($_SERVER['PHP_SELF'],$total_records,$record_per_page,$scroll,true,true,true);

            // if there is any query string you want to pass with links just use
            $page->set_qry_string("name=harish&id=7347");

            // If you want to pass any parameters to page links such that stylesheet or style sheet class
            // $page->set_link_parameter("Class = myStyleSheetClass") OR
            $page->set_link_parameter("style='color:#FF0000;'");

            $result=@mysql_query($page->get_limit_query($sql));
            while($row=mysql_fetch_array($result))
            {
                echo "User : ".$row['username']."<br>";
            }


            echo "<br />";    
            echo $page->get_page_nav();
            echo "</td></tr>";


            echo "<tr><td align='center'>";
            //  if you want to use images as next previous etc. links then use like
            
            $page->get_first_page_nav("<img src='images/icons/first_16.png' alt='First' title='First' border='0' align='absmiddle' hspace='10'>");
            $page->get_prev_page_nav("<img src='images/icons/previous_16.png' alt='Previous' title='Previous' border='0' align='absmiddle' hspace='5'>");
            $page->get_number_page_nav();

            $page->get_next_page_nav("<img src='images/icons/next_16.png' alt='Next' title='Next' border='0' align='absmiddle' hspace='5'>");
            $page->get_last_page_nav("<img src='images/icons/last_16.png' alt='Last' title='Last' border='0' align='absmiddle' hspace='10'>");

        
        </td>
        </tr>
        </table>





	/*	DB INSERT
	CREATE TABLE member ( username varchar(20),password varchar(20));
	INSERT INTO member (username, password) VALUES('nine', 'nineni');
	INSERT INTO member (username, password) VALUES('ten', 'ten123');
	INSERT INTO member (username, password) VALUES('kkkkkakak', 'fffffff');
	INSERT INTO member (username, password) VALUES('dfsf', 'fffffff');
	INSERT INTO member (username, password) VALUES('ram', 'ram');
	INSERT INTO member (username, password) VALUES('wwww', 'ssssss');
	INSERT INTO member (username, password) VALUES('Harish', 'Chauhan');
	INSERT INTO member (username, password) VALUES('harish1', 'Chauhan');
	INSERT INTO member (username, password) VALUES('Harish2', 'Chauhan');
	INSERT INTO member (username, password) VALUES('harish3', 'Chauhan');
	INSERT INTO member (username, password) VALUES('harish4', 'Chauhan');
	INSERT INTO member (username, password) VALUES('raja', 'raja');
	INSERT INTO member (username, password) VALUES('harish5', 'Chauhan');
	INSERT INTO member (username, password) VALUES('rjarajaj', 'raja');
	INSERT INTO member (username, password) VALUES('harish6', 'Chauhan');
	INSERT INTO member (username, password) VALUES('kannan', 'kannan');
	INSERT INTO member (username, password) VALUES('amit', 'bansal');
	INSERT INTO member (username, password) VALUES('mamtadua', 'mitumitu');
	INSERT INTO member (username, password) VALUES('parag', 'parag1');
	INSERT INTO member (username, password) VALUES('parag1', 'parag1');
	INSERT INTO member (username, password) VALUES('raju', 'bhaskar');
	INSERT INTO member (username, password) VALUES('mamta', 'mitumitu');
	INSERT INTO member (username, password) VALUES('meetu', 'mitumitu');
	INSERT INTO member (username, password) VALUES('mitu', 'mitumitu');
	INSERT INTO member (username, password) VALUES('harish12', 'Chauhan');
	INSERT INTO member (username, password) VALUES('sara', 'mitumitu');
	INSERT INTO member (username, password) VALUES('mini', 'mitumitu');
	INSERT INTO member (username, password) VALUES('anand', 'anand12');
	INSERT INTO member (username, password) VALUES('guest2', '123456');
	INSERT INTO member (username, password) VALUES('guest1', '123456');
	INSERT INTO member (username, password) VALUES('dilip', 'singh1');
	INSERT INTO member (username, password) VALUES('meetudua', '123456');
	INSERT INTO member (username, password) VALUES('shikha', '123456');
	INSERT INTO member (username, password) VALUES('jini', '123456');
	INSERT INTO member (username, password) VALUES('kalai', 'kalai');
	INSERT INTO member (username, password) VALUES('abinaya', 'abinaya');
	INSERT INTO member (username, password) VALUES('mama', 'mamamama');
	INSERT INTO member (username, password) VALUES('chpant', '123456');
	INSERT INTO member (username, password) VALUES('test11', 'test11');
	INSERT INTO member (username, password) VALUES('cpant', '123456');
	INSERT INTO member (username, password) VALUES('boy', 'goodboy');
	INSERT INTO member (username, password) VALUES('goodboy', 'harish');
	INSERT INTO member (username, password) VALUES('rohit', '123456');
	INSERT INTO member (username, password) VALUES('goodboy1', 'harish');
	INSERT INTO member (username, password) VALUES('lina', '123456');
	INSERT INTO member (username, password) VALUES('rohit1', '123456');
	INSERT INTO member (username, password) VALUES('rohit2', '123456');
	INSERT INTO member (username, password) VALUES('local', '123456');
	INSERT INTO member (username, password) VALUES('tina', '123456');
	INSERT INTO member (username, password) VALUES('bini', '123456');
	INSERT INTO member (username, password) VALUES('new', 'new123456');
	INSERT INTO member (username, password) VALUES('dinky', '123456');
	INSERT INTO member (username, password) VALUES('mummy', '123456');
	INSERT INTO member (username, password) VALUES('kanaku', 'kanaku');
	INSERT INTO member (username, password) VALUES('annanana', 'annanana');
	INSERT INTO member (username, password) VALUES('manam', 'manam123');
	INSERT INTO member (username, password) VALUES('kanagu12', 'kanagu12');
	INSERT INTO member (username, password) VALUES('kanagu123', 'kanagu123');
	INSERT INTO member (username, password) VALUES('kapil', '123456');
	INSERT INTO member (username, password) VALUES('kamya', '123456');
	INSERT INTO member (username, password) VALUES('test5973', 'test5973');
	INSERT INTO member (username, password) VALUES('test59731', 'test59731');
	INSERT INTO member (username, password) VALUES('test597311243', 'test597311243');
	INSERT INTO member (username, password) VALUES('soni', '123456');
	INSERT INTO member (username, password) VALUES('pooja', '123456');
	INSERT INTO member (username, password) VALUES('aansha', '123456');
	INSERT INTO member (username, password) VALUES('rmamammamama', '123456');
	INSERT INTO member (username, password) VALUES('megha', '123456');
	*/
?>