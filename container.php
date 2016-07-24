<?php

$container['pdo'] = function ($container) use ($config) {
    $pdo = new PDO(sprintf(
        "%s:host=%s; dbname=%s%s",
        $config['db']['host'],
        $config['db']['name'],
        isset($config['db']['port']) ? sprintf(
            "; port=%s",
            $config['db']['port']
        ) : ''
    ), $config['db']['user'], $config['db']['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    return $pdo;
};

$container['db'] = function ($container) {
    $pdo = $container->pdo;
    $affectedRows = 0;
    return [
    'insertId' => $pdo->lastInsertId(),
    'affectedRows' => $affectedRows,
    'query' => function (
        $sql,
        $type = 'execute',
        $params = array()
    ) use (
        $pdo,
        $affectedRows
    ) {
        $stmt = $pdo->prepare($sql);
        $ret = $stmt->execute($params);
        $affectedRows = $stmt->rowCount();
        if ($type == 'row') {
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
        if ($type == 'rows') {
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        if ($type == 'numRows') {
            return $affectedRows;
        }
        
        return $ret;
    }];
};

$container['view'] = function ($container) use ($config) {
    $view = new \Slim\Views\Twig($config['template'], [
        'cache' => $config['templateCache'],
        'auto_reload' => true,
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    return $view;
};
