<?php

$console->setHelperSet(
    new Symfony\Component\Console\Helper\HelperSet([
        'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper(
            $serviceManager->get(\Doctrine\ORM\EntityManager::class)->getConnection()
        ),
        'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper(
            $serviceManager->get(\Doctrine\ORM\EntityManager::class)
        )
    ])
);

\Doctrine\DBAL\Tools\Console\ConsoleRunner::addCommands($console);
\Doctrine\ORM\Tools\Console\ConsoleRunner::addCommands($console);

