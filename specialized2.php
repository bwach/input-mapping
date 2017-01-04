<?php

require __DIR__ . '/vendor/autoload.php';

$mapping = new \InputMapping\Mapping\Specialized2Mapping();

\Controller\SimpleController::handleRequestWithMappingAlgorithm($mapping);