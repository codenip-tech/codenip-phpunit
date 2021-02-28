<?php

declare(strict_types=1);

namespace App\Http\Transformer;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class RequestBodyTransformer
{
    public function transform(Request $request)
    {
        $request->request = new ParameterBag(\json_decode($request->getContent(), true) ?? []);
    }
}
