<?php

    $form = new FormValidator('dictionary', 'post', api_get_self().'?action='.$action.'&id='.$id);

    $h = "<table id='nodeselection' class='styleOfPages' style='width:98%;' >";
    
    $h .= "<tr><td style='text-align:center;padding-bottom:10px;padding-top:10px;border:solid 1px gray;' colspan=3 >";
    $h .= $plugin->get_lang('TypeContent')."</td></tr>";

    $h .= "<tr style='width:98%;background-color:#D8D8D8;padding-top:10px;border-bottom:solid 2px white;' >";
    $h .= "<td style='text-align:center;padding:5px;' >";
    $h .= "<img src='img/wordsmatch.png' /></td>";
    $h .= "<td style='text-align:center;width:60%;' >Finds The words</td>";
    $h .= "<td style='text-align:center;width:20%;'>";
    $h .= "<a href='node_list.php?typenode=wordsmatch' class='btn btn-primary' >";
    $h .= "<em class='fa'></em>&nbsp;".$plugin->get_lang('Use')."&nbsp;</a>";
    $h .= "</td>";
    $h .= "</tr>";

    $h .= "<tr style='width:98%;background-color:#D8D8D8;padding-top:10px;border-bottom:solid 2px white;' >";
    $h .= "<td style='text-align:center;padding:5px;' >";
    $h .= "<img src='img/dragthewords.png' /></td>";
    $h .= "<td style='text-align:center;width:60%;' >Drag the words</td>";
    $h .= "<td style='text-align:center;width:20%;'>";
    $h .= "<a href='node_list.php?typenode=dragthewords' class='btn btn-primary' >";
    $h .= "<em class='fa'></em>&nbsp;".$plugin->get_lang('Use')."&nbsp;</a>";
    $h .= "</td>";
    $h .= "</tr>";
    
    $h .= "</table>";

    $h .= $tds;

    $form->addText('title',get_lang('Title'),false);


    $form->addText('descript',get_lang('Description'),false);

    $typeNodeForm = $form->addText('typenode','typenode',false);
    $typeNodeForm->setValue($typenode);

    $form->addText('terms_a','terms_a',false);

    $form->addElement('static','','',$h);

    $form->addButtonSave(get_lang('Save'));
