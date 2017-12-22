<?php

function dbConnect()
{
    $dns = CONFIG_DB_DRIVER.':host='.CONFIG_DB_HOST.';';

    if (CONFIG_DB_PORT) {
        $dns.= 'port='.CONFIG_DB_PORT.';';
    }

    $dns.= 'dbname='.CONFIG_DB_NAME;

    return new PDO($dns, CONFIG_DB_USERNAME, CONFIG_DB_PASSWORD);
}

function getHanoiMoves($nb, $start, $end, $inter, $moves) 
{
    if ($nb !== 0) {
        $moves = getHanoiMoves($nb-1, $start, $inter, $end, $moves);
        $moves[] = ['nb' => $nb, 'end' => $end];
        $moves = getHanoiMoves($nb-1, $inter, $end, $start, $moves);
    } 

    return $moves;
}

function query($pdoStatement, $sql)
{
    $res = $pdoStatement->query($sql);

    if ($res === false) {
        throw new Exception('PDO exception - the following SQL request failed : '.$sql);
    }

    return $res;
}

function initDatabase($pdoStatement)
{
    $tableExists = (query($pdoStatement, "SHOW TABLES")->rowCount() > 0);

    if (!$tableExists) {
        generateDatabase($pdoStatement);
        seedDatabase($pdoStatement);
    }
}

function generateDatabase($pdoStatement)
{
    $sql = 'CREATE TABLE `block_config` (';
        $sql.= '`id` int(11) unsigned NOT NULL AUTO_INCREMENT,';
        $sql.= '`number` smallint(1) unsigned NOT NULL,';
        $sql.= 'PRIMARY KEY (`id`)';
    $sql.= ') ENGINE=InnoDB DEFAULT CHARSET=utf8; '; 

    $sql.= 'CREATE TABLE `move` (';
        $sql.= '`id` int(11) unsigned NOT NULL AUTO_INCREMENT,';
        $sql.= '`block_config_fk_id` int(11) unsigned NOT NULL,';
        $sql.= '`sequence_position` smallint(3) unsigned NOT NULL,';
        $sql.= '`block_index` smallint(1) unsigned NOT NULL,';
        $sql.= '`tower_index` smallint(1) unsigned NOT NULL,';
        $sql.= 'PRIMARY KEY (`id`)';
    $sql.= ') ENGINE=InnoDB DEFAULT CHARSET=utf8; ';

    query($pdoStatement, $sql);
}

function seedDatabase($pdoStatement)
{
    for($i = 1; $i <= CONFIG_MAX_NB_BLOCK; $i++) {
        $sql = 'INSERT INTO block_config (id, number) VALUES ('.$i.', '.$i.')';
        query($pdoStatement, $sql);

        $moves = getHanoiMoves($i, 1, 3, 2, []);
        $sqlValues = [];
        foreach ($moves as $key => $move) {
            $sqlValues[] = '('.$i.', '.$key.', '.$move['nb'].', '.$move['end'].')';
        }

        $sql = 'INSERT INTO move (block_config_fk_id, sequence_position, block_index, tower_index) VALUES ';
        $sql.= implode(',', $sqlValues);

        query($pdoStatement, $sql);
    }
}

