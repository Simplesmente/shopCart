<?php 

declare(strict_types=1);

namespace Cart\Validation;

use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Exceptions\NestedValidationException;

use Cart\Validation\Contracts\ValidationInterface;

/**
* 
*/
class Validator implements ValidationInterface
{
	/**
	 * [$errors description]
	 * @var [bool]
	 */
	public $errors;


	public function validate(Request $request, array $rules)
	{
		foreach ($rules as $field => $rule) {
			
			try {
				
				$rule->setName(ucfirst($field))->assert($request->getParam($field));

			} catch (NestedValidationException $e) {

				$this->errors[$field] = $e->getMessages();
				
			}
		}

		$_SESSION['errors'] = $this->errors;

		return $this;
	}

	public function fails()
	{
		return !empty($this->erros);
	}
}