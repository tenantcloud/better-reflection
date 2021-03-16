<?php

namespace TenantCloud\BetterReflection\Reflection\Attributes;

use Ds\Sequence;

class DelegatedAttributeSequence implements AttributeSequence
{
	public function __construct(
		private Sequence $delegate,
	) {
	}

	public function has(string $className): bool
	{
		return !$this->delegate
			->filter(fn (object $attribute) => $className === get_class($attribute))
			->isEmpty();
	}

	public function clear()
	{
		return $this->delegate->clear();
	}

	public function count(): int
	{
		return $this->delegate->count();
	}

	public function copy(): self
	{
		return new self(
			$this->delegate->copy()
		);
	}

	public function isEmpty(): bool
	{
		return $this->delegate->isEmpty();
	}

	public function toArray(): array
	{
		return $this->delegate->toArray();
	}

	public function getIterator()
	{
		return $this->delegate->getIterator();
	}

	public function offsetExists($offset)
	{
		return $this->delegate->offsetExists($offset);
	}

	public function offsetGet($offset)
	{
		return $this->delegate->offsetGet($offset);
	}

	public function offsetSet($offset, $value)
	{
		$this->delegate->offsetSet($offset, $value);
	}

	public function offsetUnset($offset)
	{
		$this->delegate->offsetUnset($offset);
	}

	public function allocate(int $capacity): void
	{
		$this->delegate->allocate($capacity);
	}

	public function apply(callable $callback): void
	{
		$this->delegate->apply($callback);
	}

	public function capacity(): int
	{
		return $this->delegate->capacity();
	}

	public function contains(...$values): bool
	{
		return $this->delegate->contains(...$values);
	}

	public function filter(callable $callback = null): AttributeSequence
	{
		return new self($this->delegate->filter($callback));
	}

	public function find($value)
	{
		return $this->delegate->find($value);
	}

	public function first()
	{
		return $this->delegate->first();
	}

	public function get(int $index)
	{
		return $this->delegate->get($index);
	}

	public function insert(int $index, ...$values)
	{
		return $this->delegate->insert($index, ...$values);
	}

	public function join(string $glue = null): string
	{
		return $this->delegate->join();
	}

	public function last()
	{
		return $this->delegate->last();
	}

	public function map(callable $callback): AttributeSequence
	{
		return new self($this->delegate->map($callback));
	}

	public function merge($values): AttributeSequence
	{
		return new self($this->delegate->merge($values));
	}

	public function pop()
	{
		return $this->delegate->pop();
	}

	public function push(...$values): void
	{
		$this->delegate->push(...$values);
	}

	public function reduce(callable $callback, $initial = null)
	{
		return $this->delegate->reduce($callback, $initial);
	}

	public function remove(int $index)
	{
		return $this->delegate->remove($index);
	}

	public function reverse(): void
	{
		$this->delegate->reverse();
	}

	public function reversed(): AttributeSequence
	{
		return new self($this->delegate->reversed());
	}

	public function rotate(int $rotations): void
	{
		$this->delegate->rotate($rotations);
	}

	public function set(int $index, $value): void
	{
		$this->delegate->set($index, $value);
	}

	public function shift()
	{
		return $this->delegate->shift();
	}

	public function slice(int $index, int $length = null): AttributeSequence
	{
		return new self($this->delegate->slice($index, $length));
	}

	public function sort(callable $comparator = null): void
	{
		$this->delegate->sort($comparator);
	}

	public function sorted(callable $comparator = null): AttributeSequence
	{
		return new self($this->delegate->sorted($comparator));
	}

	public function sum(): float | int
	{
		return $this->delegate->sum();
	}

	public function unshift(...$values): void
	{
		$this->delegate->unshift(...$values);
	}

	public function jsonSerialize()
	{
		return $this->delegate->jsonSerialize();
	}
}
