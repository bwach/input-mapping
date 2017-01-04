<?php

namespace Controller;

use Exception;
use InputMapping\Mapping\BaseMapping;
use InputMapping\Validator\InputValidator;
use InputMapping\Mapping\MappingResult;
use InputMapping\Model\Input;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SimpleController
{
    public static function handleRequestWithMappingAlgorithm(BaseMapping $mapping)
    {
        $request = Request::createFromGlobals();
        $response = new Response();

        if ($request->getMethod() != Request::METHOD_POST) {
            $response->setStatusCode(405);
            $response->send();
            return;
        }

        if ($request->headers->get("Content-Type") !== "application/json") {
            $response->setStatusCode(400);
            $response->send();
            return;
        }

        $content = $request->getContent();
        $query = json_decode($content, true);

        if ($content && $query && InputValidator::validate($query)) {
            try {
                $input = Input::fromArray($query);

                /** @var MappingResult $result */
                $result = $mapping->calculate($input);
                $response->setContent(json_encode($result->toArray()));
            } catch (Exception $e /* Pokemon! Gotta' catch 'em all! */) {
                $response->setStatusCode(400);
            }
        } else {
            $response->setStatusCode(400);
        }

        $response->send();
        return;
    }
}