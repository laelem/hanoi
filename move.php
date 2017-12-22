<?php 
require('config.php'); 
require('functions.php'); 

$pdoStatement = dbConnect();

$params = $_GET;
if (!is_array($params) || array_keys($params) !== ['ind', 'nbBlock']) {
    throw new Exception('Invalid parameters');
}

$pdoStatement = dbConnect();

$sql = 'SELECT block_index, tower_index ';
$sql.= 'FROM move m INNER JOIN block_config b ON m.block_config_fk_id = b.id ';
$sql.= 'WHERE b.number = ? AND m.sequence_position = ? LIMIT 1';

$sth = $pdoStatement->prepare($sql);

$res = $sth->execute([$params['nbBlock'], $params['ind']]);

if ($res === false) {
    throw new Exception('PDO exception - the following SQL request failed : '.$sql);
}

$data = $sth->fetch();

if (empty($data)) {
    throw new Exception('Unexpected response from bdd : move not found');
}

echo $data['block_index'].'|'.$data['tower_index'];