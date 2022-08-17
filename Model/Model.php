<?php

abstract class Model
{

		abstract public function __construct(Database $database);

		abstract public function getAll(): array;

		abstract public function create(array $data): string;

		abstract public function delete(string $id): int;

}