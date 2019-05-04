<?php

$container = \App\Bootstrap::getContainer();

$container->getByType(Nette\Application\Application::class)->run();
