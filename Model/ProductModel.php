<?php

require_once __DIR__ . "/Model.php";

class ProductModel extends Model
{

		private PDO $conn;

		public function __construct(Database $database)
		{
				$this->conn = $database->getConnection();
		}

		public function getAll(): array
		{
				$sql = "SELECT * FROM products";

				$stmt = $this->conn->query($sql);

				$data = [];

				while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
						$data[] = $row;
				}

				return $data;
		}

		public function create(array $data): string
		{
				$sql = "INSERT INTO products (sku, name, price, type, parameter)
								VALUES (:sku, :name, :price, :type, :parameter)";

				$stmt = $this->conn->prepare($sql);

				$stmt->bindValue(":sku", $data["sku"]);
				$stmt->bindValue(":name", $data["name"]);
				$stmt->bindValue(":price", $data["price"]);
				$stmt->bindValue(":type", $data["type"]);
				$stmt->bindValue(":parameter", $data["parameter"]);

				$stmt->execute();

				return $this->conn->lastInsertId();
		}

		public function delete(string $id): int
		{
				$sql = "DELETE FROM products
								WHERE id = :id";

				$stmt = $this->conn->prepare($sql);

				$stmt->bindValue(":id", $id);

				$stmt->execute();

				return $stmt->rowCount();
		}

}