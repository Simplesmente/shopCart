<?php 

declare(strict_types=1);

namespace Cart\Basket;

use Cart\Support\Storage\Contracts\StorageInterface;
use Cart\Basket\Exceptions\QuantityExceedException;
use Cart\Models\Product;

/**
* 
*/
class Basket 
{	
	/**
	 * [$storage description]
	 * @var [Object Cart\Support\Storage\Contracts\StorageInterface;]
	 */
	private $storage;

	/**
	 * [$product description]
	 * @var [Object Cart\Models\Product]
	 */
	private $product;


	public function __construct(StorageInterface $storage, Product $product)
	{
		$this->storage = $storage;

		$this->product = $product;
	}


	public function add(Product $product, int $quantity)
	{


		if( $this->has($product) ){
			$quantity = $this->get($product)['quantity'] + $quantity;	
		}

		$this->update($product, $quantity);


	}

	public function update(Product $product, int $quantity)
	{
		if(!$this->product->find($product->id)->hasStock($quantity)){
			throw new QuantityExceededException();
			
		}
		
			
		if( $quantity === 0 ){

			$this->remove($product);

			return;
		}

		$this->storage->set((int) $product->id,[
			'product_id' => (int) $product->id,
			'quantity'   => (int) $quantity
		]);
	}


	public function remove(Product $product): bool
	{	
		return $this->storage->unset($product->id);
	}

	public function has(Product $product)
	{
		return $this->storage->exists($product->id);
	}

	public function get(Product $product)
	{	
		return $this->storage->get($product->id);
	}

	public function clear()
	{
		$this->storage->clear();
	}

	public function all()
	{
		$ids = [];

		$items = [];

		foreach ($this->storage->all() as $product) {
			$ids[] = $product['product_id'];
		}

		$products = $this->product->find($ids);

		foreach ($products as $product) {
			
			$product->quantity = $this->get($product)['quantity'];

			$items[] = $product;
		}

		return $items;
	}

	public function itemCount(): int
	{
		return (int) count($this->storage);
	}

	public function subTotal(): float
	{
		$total = 0;

		foreach ($this->all() as $item ) {
			if($item->outOfStock()){
				continue;
			}

			$total = (float) $total + $item->price * $item->quantity;
		}

		return $total;

	}

	public function refresh(): void
	{
		foreach ($this->all() as $item) {
			
			if( !$item->hasStock($item->quantity) ){

				$this->update($item, $item->stock);
			}
		}
	}
}