<?php

    $varString = api_get_self();
    $varUrl = str_replace("node_list.php","node_process.php",$varString);
    $varUrl =  $varUrl.'?id='.$id.'&typenode='.$typenode ;
    
    switch($action){
		case 'add':
			if ($form->validate()){
                $values = $form->getSubmitValues();
				$date = new DateTime();
				$year = $date->format("Y");
				$month = $date->format('m');
				$day = $date->format('j');
				$dateStr = $day.'/'.$month.'/'.$year;
				$params = [
					'title' => $values['title'],
					'date_create' => $dateStr,
					'id_user' => $userId,
                    'typenode' => $values['typenode'],
					'terms_a' => $values['terms_a'],
					'descript' => $values['descript'],
					'id_url' => $idurl
				];
				$result = Database::insert($table, $params);
				if ($result) {
					Display::addFlash(Display::return_message(get_lang('Added')));
                }
                $varUrl =  $varUrl.'?id='.$id.'&action=add';
				header('Location: '.$varUrl);
				exit;
			}
			break;
		case 'edit':
			$form->setDefaults($term);
			if ($form->validate()) {
				$values = $form->getSubmitValues();
				$params = [
					'title' => $values['title'],
					'terms_a' => $values['terms_a'],
					'descript' => $values['descript']
				];
				Database::update($table, $params, ['id = ?' => $id]);
				Display::addFlash(Display::return_message(get_lang('Updated')));
				$varUrl =  $varUrl.'?id='.$id.'&action=edit';
				header('Location: '.$varUrl);
				exit;
			}
			break;
		case 'delete':
			if (!empty($term)){
				Database::delete($table, ['id = ?' => $id]);
                Display::addFlash(Display::return_message(get_lang('Deleted')));
                $varUrl =  $varUrl.'?id='.$id.'&action=delete';
				header('Location: '.$varUrl);
				exit;
			}
			break;
	}