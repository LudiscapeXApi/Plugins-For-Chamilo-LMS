<?php

	function minimizeCSS($css){
		$css = preg_replace('/\/\*((?!\*\/).)*\*\//', '', $css); // negative look ahead
		$css = preg_replace('/\s{2,}/', ' ', $css);
		$css = preg_replace('/\s*([:;{}])\s*/', '$1', $css);
		$css = preg_replace('/;}/', '}', $css);
		return $css;
	}
	
	function sanitize_output($buffer) {
		$search = array(
			'/\>[^\S ]+/s',     // strip whitespaces after tags, except space
			'/[^\S ]+\</s',     // strip whitespaces before tags, except space
			'/(\s)+/s',         // shorten multiple whitespace sequences
			'/<!--(.|\s)*?-->/' // Remove HTML comments
		);
		$replace = array(
			'>',
			'<',
			'\\1',
			''
		);
		
		$buffer = preg_replace($search, $replace, $buffer);

		return $buffer;
	}

	function recupPart($file,$tag){
		
		$art = "";
		
		try {
		
			$html = file_get_contents($file);
			
			$html = str_replace(CHR(13),"",$html);
			$html = str_replace(CHR(10),"",$html);
					
			preg_match('#<div id="'.$tag.'" >(.*)</div>#sU', $html, $resultat);
			
		if($resultat){
			$art = $resultat[0];
		}
		
		 $art = preg_replace("@<div[^>.]*>@","",$art);
		 $art = preg_replace("@</div[^>.]*>@","",$art);

		}catch (Exception $e) {
			echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
		
		$art = str_replace("xdiv","div",$art);
		
		return $art;
		
	}
		
	function dd($date){
		return date("YmdHi",$date);
	}
	
	function recupDir($dirname){
		
		$tab[] = array(); 

		$dir = opendir($dirname); 
		
		while($file = readdir($dir)) {

			//echo $file.'<br />';
			
			if($file != '.' && $file != '..' && $file != ''  && strpos($file,'.html') && !is_dir($dirname.$file))
			{
				$nam = dd(filemtime($dirname.$file)).'!'.$file;
				$tab[] = $nam;
				//echo $nam;
				
			}

		}

		closedir($dir);	
		sort($tab);
		return $tab;
		
	}
	
	function recupFolder($dirname){
	
		$tab[] = array(); 
	
		$dir = opendir($dirname); 
		
		while($file = readdir($dir)) {
			
			if(is_dir($dirname.$file))
			{
				$nam = $file;
				if($nam!='..'&&$nam!='.'){
					$tab[] = $nam;
				}
		
			}
	
		}
	
		closedir($dir);	
		sort($tab);
		return $tab;
		
	}

	function shareSocial($uri){
	
		echo '<div style="border:dotted 1px blue;width:210px;height:40px;float:right;" >';
		echo '<div style="width:150px;float:left;height:32px;" >';
		echo 'Partager ce lien<BR />sur facebook</div>';
		echo '<a class="facebook" href="http://www.facebook.com/share.php?u='.urlencode($uri).'" ' ;
		echo ' onclick="return fbs_click()" target="_blank" >';
		echo '</a></div>';
	
		echo '<div style="float:right;width:70px;height:60px;" ><g:plusone size="medium"></g:plusone></div>';
	
	}
	
	function chercheDefinition($word){
		
		$r = "-";
		
		$data = lit_rss_no_encode("../DATA_ARTICLES/language.xml",array("title","description"));
		
		foreach($data as $tab) {
			
			if($tab[0]==$word){
				$r = $tab[1];
			}
			
		}
		
		return formatSP($r);
	
	}
	
	function constructParagraph($fichier){
	
		$data = lit_rss_no_encode($fichier,array("title","description","description2","description3"));
		
		$ret = "";
		
		$ret = $ret.trouvePhrase($data,'P1',1);
		$ret = $ret.trouvePhrase($data,'P1',2);
		$ret = $ret.trouvePhrase($data,'P1',3);
		
		$ret = $ret.trouvePhrase($data,'P2',1);
		$ret = $ret.trouvePhrase($data,'P2',2);
		$ret = $ret.trouvePhrase($data,'P2',3);
		
		$ret = $ret.trouvePhrase($data,'P3',1);
		$ret = $ret.trouvePhrase($data,'P3',2);
		$ret = $ret.trouvePhrase($data,'P3',3);
		
		$ret = $ret.trouvePhrase($data,'P4',1);
		$ret = $ret.trouvePhrase($data,'P4',2);
		$ret = $ret.trouvePhrase($data,'P4',3);
		
		return formatSP($ret);
		
	}
	
	function formatSP($str){
	
		$pattern = Array("/br!/");
		$rep_pat = Array("<br >");
		$str2 = preg_replace($pattern, $rep_pat, $str);
	
		return $str2;
	
	}
	
	function formatNAME($str){
		
		$pattern = Array("/ /","/'/","/é/");
		$rep_pat = Array("-","par57","/e/");
		$str2 = preg_replace($pattern, $rep_pat, $str);
		
		return $str2;
	
	}

	function convert_locale_for_xls ($text) {
		$return = iconv('UTF-8', 'cp1250', $text);
		return preg_replace("/([\xC2\xC4])([\x80-\xBF])/e",  "chr(ord('\\1')<<6&0xC0|ord('\\2')&0x3F)", $return);
	}

	function stripAccents($string){
	return strtr($string,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
	}
	
	function trouvePhrase($data,$P,$N){
		
		$ret = "";
		
		$r = mt_rand(0,3);
		$c = 0;
		
		foreach($data as $tab) {
			if($tab[0]==$P){
				if($c == $r){
					$ret = htmlentities(utf8_decode($tab[$N]));
				}
				$c ++;
			}
		}
		
		return $ret ;
		
	}

	function lit_rss($fichier,$objets) {

		//$resultat = new array;

		// on lit tout le fichier
		if($chaine = @implode("",@file($fichier))) {

			// on découpe la chaine obtenue en items
			$tmp = preg_split("/<\/?"."channel".">/",$chaine);

			// pour chaque item
			for($i=1;$i<sizeof($tmp)-1;$i+=2)

				
				// on lit chaque objet de l'item
				foreach($objets as $objet) {

					// on découpe la chaine pour obtenir le contenu de l'objet
					$tmp2 = preg_split("/<\/?".$objet.">/",$tmp[$i]);

					// on ajoute le contenu de l'objet au tableau resultat
					$resultat[$i-1][] = htmlentities(utf8_decode(@$tmp2[1]));
				}

			// on retourne le tableau resultat
			return $resultat;
		}
	}
	
	function lit_rss_no_encode($fichier,$objets) {

		//$resultat = new array;

		// on lit tout le fichier
		if($chaine = @implode("",@file($fichier))) {

			// on découpe la chaine obtenue en items
			$tmp = preg_split("/<\/?"."channel".">/",$chaine);

			// pour chaque item
			for($i=1;$i<sizeof($tmp)-1;$i+=2)

				
				// on lit chaque objet de l'item
				foreach($objets as $objet) {

					// on découpe la chaine pour obtenir le contenu de l'objet
					$tmp2 = preg_split("/<\/?".$objet.">/",$tmp[$i]);

					// on ajoute le contenu de l'objet au tableau resultat
					$resultat[$i-1][] = @$tmp2[1];
				}

			// on retourne le tableau resultat
			return $resultat;
		}
	}
	
	function xss_clean($data)
	{

	$data = strip_tags($data);
	// Fix &entity\n;
	$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
	$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
	$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
	$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
	
	// Remove any attribute starting with "on" or xmlns
	$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
	
	// Remove javascript: and vbscript: protocols
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
	$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
	
	// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
	$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
	
	// Remove namespaced elements (we do not need them)
	$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
	
	do
	{
		// Remove really unwanted tags
		$old_data = $data;
		$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
	}
	while ($old_data !== $data);
	
	// we are done...
	return $data;
	}

?>