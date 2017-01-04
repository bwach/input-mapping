<?php

require __DIR__ . '/vendor/autoload.php';

$mapping = new \InputMapping\Mapping\SpecializedMapping();

\Controller\SimpleController::handleRequestWithMappingAlgorithm($mapping);