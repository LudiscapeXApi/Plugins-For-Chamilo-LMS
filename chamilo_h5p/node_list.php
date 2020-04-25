<?php
	
	/* For licensing terms, see /license.txt */
	
	require_once __DIR__.'/../../main/inc/global.inc.php';
	require_once __DIR__.'/chamilo_h5p.php';
	
	$language = 'en';
	$platformLanguage = api_get_interface_language();
	$iso = api_get_language_isocode($platformLanguage);
	
	if(!api_is_anonymous()){
		
		$user = api_get_user_info();
		
		if(isset($user['status'])){
			if($user['status']==SESSIONADMIN
			||$user['status']==COURSEMANAGER
			||$user['status']==PLATFORM_ADMIN){
			}else{
				echo "<script>location.href = '../../index.php';</script>";
				exit;
			}
		}
		
	}else{
		echo "<script>location.href = '../../index.php';</script>";
		exit;
	}
	
	$userId = $user['id'];
	
	$vers = 6;
	
	$plugin = chamilo_h5p::create();
	
	//wordsmatch	
	$id = isset($_GET['id']) ? (int) $_GET['id']:0;
	$typenode = isset($_GET['typenode']) ? Security::remove_XSS($_GET['typenode']) : '';
	$action = isset($_GET['action']) ? Security::remove_XSS($_GET['action']):'add';

	$table = 'plugin_chamilo_h5p';
	
	$idurl = api_get_current_access_url_id();
	$UrlWhere = "";
	if ((api_is_platform_admin() || api_is_session_admin()) && api_get_multiple_access_url()) {
        $UrlWhere = " AND id_url = $idurl ";
	}
	
	$sql = "SELECT * FROM $table  WHERE id_user = $userId $UrlWhere ORDER BY title";
	if(isset($_GET['id'])){
		$sql = "SELECT * FROM $table  WHERE id <> $id AND id_user = $userId $UrlWhere LIMIT 2";
	}
	
	$result = Database::query($sql);
	$terms = Database::store_result($result,'ASSOC');
	$countData = count($terms);

	$term = null;

	if($id>0){
		if(!empty($id)){
			$sql = "SELECT * FROM $table WHERE id = $id AND id_user = $userId ";
			$result = Database::query($sql);
			$term = Database::fetch_array($result, 'ASSOC');
			if(empty($term)){
				api_not_allowed(true);
			}
		}
	}

	$tds = '<div id="h5p_title_help" style="display:none;" >'.$plugin->get_lang('h5p_title_help').'</div>';
	$tds .= '<div id="h5p_descr_help" style="display:none;" >'.$plugin->get_lang('h5p_descr_help').'</div>';
	$tds .= '<div id="h5p_cancel" style="display:none;" >'.get_lang('Cancel').'</div>';

	$tds .= '<div id="h5p_wordsmatch_help" style="display:none;" >'.$plugin->get_lang('h5p_wordsmatch_help').'</div>';
	$tds .= '<div id="h5p_wordsmatch_load" style="display:none;" >'.$plugin->get_lang('h5p_wordsmatch_load').'</div>';
	$tds .= '<div id="h5p_wordsmatch_tutor" style="display:none;" >'.$plugin->get_lang('h5p_wordsmatch_tutor').'</div>';
	$tds .= '<div id="h5p_wordsmatch_term_a" style="display:none;" >'.$plugin->get_lang('h5p_wordsmatch_term_a').'</div>';

	$tds .= '<div id="h5p_dragthewords_help" style="display:none;" >'.$plugin->get_lang('h5p_dragthewords_help').'</div>';
	$tds .= '<div id="h5p_dragthewords_load" style="display:none;" >'.$plugin->get_lang('h5p_dragthewords_load').'</div>';
	$tds .= '<div id="h5p_dragthewords_tutor" style="display:none;" >'.$plugin->get_lang('h5p_dragthewords_tutor').'</div>';
	$tds .= '<div id="h5p_dragthewords_term_a" style="display:none;" >'.$plugin->get_lang('h5p_dragthewords_term_a').'</div>';
	
	include("inc/form.php");

	$htmlHeadXtra[] = '<script src="resources/js/interface.js?v='.$vers.'" type="text/javascript" language="javascript"></script>';
	$htmlHeadXtra[] = '<script src="resources/js/app.js?v='.$vers.'" type="text/javascript" language="javascript"></script>';
	$htmlHeadXtra[] = '<script src="resources/js/jquery.dataTables.min.js?v='.$vers.'" type="text/javascript" language="javascript"></script>';
	$htmlHeadXtra[] = "<script>
	$(document).ready(function(){
		$('.data_table').DataTable({
			'iDisplayLength': 50
		});
	} );
	</script>";
	
	if($typenode!=''){
		$htmlHeadXtra[] = "<script>
			$(document).ready(function(){interface$typenode();});
		</script>";
	}

	$htmlHeadXtra[] = "<style>
		.previous{
			margin-right:10px;
			cursor:pointer;
		}
		.next{
			cursor:pointer;
		}
		input[type='radio'] {
			-ms-transform: scale(1.5);
			-webkit-transform: scale(1.5);
			transform: scale(1.5);
		}
	</style>";

	include("inc/switchaction.php");
	
	$tpl = new Template("H5P");
	$tpl->assign('terms', $terms);
	$tpl->assign('form', $form->returnForm());
	
	$content = $tpl->fetch('/chamilo_h5p/view/node_list-v12.tpl');

	$tpl->assign('content', $content);

	$tpl->display_one_col_template();
	