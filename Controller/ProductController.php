<?php

class ProductController
{

		public function __construct(private ProductModel $gateway)
		{
		}

		public function processRequest(string $method, string $id): void
		{
				if ($id != "") {
						$this->processResourceRequest($method, $id);
				} else {
						$this->processCollectionRequest($method);
				}
		}

		private function processResourceRequest(string $method, string $id): void
		{
				switch ($method) {
						case "OPTIONS":
								break;

						case "DELETE":
								$rows = $this->gateway->delete($id);

								echo json_encode([
										"message" => "Product $id deleted",
										"rows" => $rows
								]);
								break;

						default:
								http_response_code(405);
				}
		}

		private function processCollectionRequest(string $method): void
		{
				switch ($method) {
						case "OPTIONS":
								break;

						case "GET":
								echo json_encode($this->gateway->getAll());
								break;

						case "POST":
								$data = (array) json_decode(file_get_contents("php://input"), true);
								var_dump($data);

								http_response_code(201);

								$errors = $this->getValidationErrors($data);

								if ( ! empty($errors)) {
										http_response_code(422);
										echo json_encode(["errors" => $errors]);
								}

								$id = $this->gateway->create($data);

								echo json_encode([
										"message" => "Product created",
										"id" => $id
								]);
								break;

						default:
								http_response_code(405);
				}
		}

		private function getValidationErrors(array $data): array
		{
				$errors = [];

				if (empty($data["sku"])) {
						$errors[] = "sku is required";
				}

				if (empty($data["name"])) {
						$errors[] = "name is required";
				}

				if (empty($data["price"])) {
						$errors[] = "price is required";
				}

				if (empty($data["type"])) {
						$errors[] = "type is required";
				}

				return $errors;
		}
}