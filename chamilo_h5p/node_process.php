<?php
	
	/* For licensing terms, see /license.txt */
	require_once __DIR__.'/../../main/inc/global.inc.php';
	require_once __DIR__.'/chamilo_h5p.php';
	
	if(api_is_anonymous()){
		echo "<script>setTimeout(function(){location.href = '../../index.php';},1000);</script>";
		exit;
	}

	$id = isset($_GET['id']) ? (int) $_GET['id']:0;
	$typenode = isset($_GET['typenode']) ? Security::remove_XSS($_GET['typenode']) : '';
	
	$terma = "";
	$termb = "";
	$termc = "";

	$opt1 = "";
	$opt2 = "";
	$opt3 = "";
	
	$descript = "";

	$term = null;

	$contentForm = '<p>Error</p>';

	if($id>0){
		
		$sql = "SELECT * FROM plugin_chamilo_h5p WHERE id = $id ";
		$result = Database::query($sql);
		
		while($rowP=Database::fetch_array($result)){
			$typenode = $rowP['typenode'];
			$terma = $rowP['terms_a'];
			$termb = $rowP['terms_b'];
			$termc = $rowP['terms_c'];
			$opt1 = $rowP['opt_1'];
			$opt2 = $rowP['opt_2'];
			$opt3 = $rowP['opt_3'];
			$descript = $rowP['descript'];
		}

		//copyr($source, $dest, $exclude = [], $copied_files = [])
		$fld_id = 'source-'.$id;
		
		$src_h5p ='cache-h5p/launch/source-'.$typenode;
		$dest_h5p ='cache-h5p/launch/'.$fld_id;
		
		//mkdir($dest_h5p);

		recurse_copy($src_h5p, $dest_h5p);

		$content_src ='cache-h5p/launch/'.$fld_id.'/content/content.json';
		$content_flx = file_get_contents($content_src);
		$content_flx = str_replace("@terms_a@",$terma,$content_flx);
		$content_flx = str_replace("@descript@",$descript,$content_flx);
		
		$fp = fopen($content_src,'w');
		fwrite($fp,$content_flx);
		fclose($fp);


		$tar_htm ='cache-h5p/launch/'.$fld_id.'.html';
		$src_h5p = file_get_contents('cache-h5p/launch/source-h.html');

		$src_h5p = str_replace("{folder}",$fld_id,$src_h5p);

		//{folder}
		$fp = fopen($tar_htm,'w');
		fwrite($fp,$src_h5p);
		fclose($fp);
		
		$contentForm = '<iframe frameborder=0 width="100%" height="600px" ';
		$contentForm .= ' style="width:100%;height:600px;" ';
		$contentForm .= ' src="'.$tar_htm.'" >';
		$contentForm .= '</iframe>';	

	}
	$contentForm .= '<h3 style="text-align:center;" >Code embeded</h3>';
	$contentForm .= '<textarea rows=3 style="margin-left:10%;width:80%;margin-right:10%;" >';
	$contentForm .= $contentForm;
	$contentForm .= '</textarea>';
	$contentForm .= '<p style="text-align:center;" >';
	$contentForm .= '<a href="node_list.php" class="btn btn-primary">';
	$contentForm .= '<em class="fa"></em>'.get_lang('Close').'</a>';
	$contentForm .= '</p>';
	$tpl = new Template("H5P");

	$tpl->assign('form', $contentForm);

	$content = $tpl->fetch('/chamilo_h5p/view/node_view.tpl');

	$tpl->assign('content', $content);

	$tpl->display_one_col_template();


	//echo "<script>setTimeout(function(){location.href = 'node_list.php';},1000);</script>";
	function recurse_copy($src,$dst) {
		$dir = opendir($src);
		@mkdir($dst);
		while(false !== ( $file = readdir($dir)) ) {
			if (( $file != '.' ) && ( $file != '..' )) {
				if ( is_dir($src . '/' . $file) ) {
					recurse_copy($src . '/' . $file,$dst . '/' . $file);
				}
				else {
					copy($src . '/' . $file,$dst . '/' . $file);
				}
			}
		}
		closedir($dir);
	}