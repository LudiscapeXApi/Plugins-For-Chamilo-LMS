<?php
/* For license terms, see /license.txt */

require_once __DIR__.'/../../main/inc/global.inc.php';

api_protect_admin_script();

echo 'USERS<br>';

/*
$sqlMiniMaj = 'ALTER TABLE user ADD email_canonical VARCHAR(255) NOT NULL';
Database::query($sqlMiniMaj);

$sqlUser = "UPDATE user SET email_canonical = email";
Database::query($sqlUser);

$sqlMiniMaj = 'ALTER TABLE user ADD locked TINYINT(1) NOT NULL';
Database::query($sqlMiniMaj);

$sqlMiniMaj = ('ALTER TABLE user ADD enabled TINYINT(1) NOT NULL');
Database::query($sqlMiniMaj);
$sql = "UPDATE user SET enabled = '1' WHERE active = 1";
Database::query($sql);

$sqlMiniMaj = ('ALTER TABLE user ADD expired TINYINT(1) NOT NULL');
Database::query($sqlMiniMaj);

$sqlMiniMaj = ('ALTER TABLE user ADD credentials_expired TINYINT(1)');
Database::query($sqlMiniMaj);

$sqlMiniMaj = ('ALTER TABLE user ADD credentials_expire_at DATETIME DEFAULT NULL');
Database::query($sqlMiniMaj);

$sqlMiniMaj = ('ALTER TABLE user ADD expires_at DATETIME DEFAULT NULL');
Database::query($sqlMiniMaj);

$sqlMiniMaj = ('ALTER TABLE user ADD address VARCHAR(250) DEFAULT NULL;');
Database::query($sqlMiniMaj);

$sqlMiniMaj = "ALTER TABLE user ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL;";
Database::query($sqlMiniMaj);

$sqlMiniMaj = "ALTER TABLE user ADD roles LONGTEXT NOT NULL COMMENT '(DC2Type:array)'";
Database::query($sqlMiniMaj);

$sqlMiniMaj = "UPDATE user SET roles = 'a:0:{}'";
Database::query($sqlMiniMaj);

$sqlMiniMaj = ('ALTER TABLE user ADD profile_completed TINYINT(1) DEFAULT NULL;');
Database::query($sqlMiniMaj);

$sqlMiniMaj = ("ALTER TABLE c_lp ADD COLUMN accumulate_scorm_time INT NOT NULL DEFAULT 1");
Database::query($sqlMiniMaj);

*/

$sql = "SELECT * FROM user LIMIT 5;";
$resultset = Database::query($sql);

while ($row = Database::fetch_array($resultset)){

    $id = $row['id'];
    
    
    echo 'username_canonical:'.$row['username_canonical'].'&nbsp;&nbsp;';
    echo 'email_canonical:'.$row['email_canonical'].'&nbsp;';
    echo '<br>';
    /*
    $result[$id] = array(
        'id' => $row['id'],
        'user_id' => $row['user_id'],
        'username' => $row['username'],
        'username_canonical' => $row['username_canonical'],
        'email' => $row['email'],
        'email_canonical' => $row['email_canonical'],
    );
    */
    
}