<?php 

declare(strict_types=1);

namespace Cart\Validation\Contracts;

use Psr\Http\Message\ServerRequestInterface as Request;


interface ValidationInterface
{
	public function validate(Request $request, array $rules);

	public function fails();
}