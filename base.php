<?php

require __DIR__ . '/vendor/autoload.php';

$mapping = new \InputMapping\Mapping\BaseMapping();

\Controller\SimpleController::handleRequestWithMappingAlgorithm($mapping);