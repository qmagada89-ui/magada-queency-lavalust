<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * ProductController
 * Every endpoint here requires a valid JWT access token.
 * require_jwt() runs in the constructor, so an unauthenticated request
 * gets 401 before any product method is reached.
 */
class ProductController extends Controller
{
    protected $auth;

    public function __construct()
    {
        parent::__construct();
        $this->call->database();
        $this->call->library('api');   // also answers CORS preflight (OPTIONS)
        $this->auth = $this->api->require_jwt();
    }

    /** Clean + validate input. $partial = true for PATCH (only check sent fields). */
    private function validate(array $in, bool $partial = false): array
    {
        $data   = [];
        $errors = [];

        if (!$partial || array_key_exists('product_name', $in)) {
            $name = trim((string) ($in['product_name'] ?? ''));
            if ($name === '')              $errors['product_name'] = 'Product name is required.';
            elseif (strlen($name) > 100) $errors['product_name'] = 'Product name must be 100 characters or less.';
            $data['product_name'] = $name;
        }

        if (!$partial || array_key_exists('description', $in)) {
            $data['description'] = trim((string) ($in['description'] ?? ''));
        }

        if (!$partial || array_key_exists('price', $in)) {
            $price = $in['price'] ?? '';
            if (!is_numeric($price) || $price < 0 || $price > 99999999.99) {
                $errors['price'] = 'Price must be a number from 0 to 99,999,999.99.';
            }
            $data['price'] = round((float) $price, 2);
        }

        if (!$partial || array_key_exists('quantity', $in)) {
            $qty = $in['quantity'] ?? '';
            if (filter_var($qty, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) === false) {
                $errors['quantity'] = 'Quantity must be a whole number, 0 or higher.';
            }
            $data['quantity'] = (int) $qty;
        }

        return [$data, $errors];
    }

    private function format(array $row): array
    {
        $row['id']       = (int) $row['id'];
        $row['price']    = (float) $row['price'];
        $row['quantity'] = (int) $row['quantity'];
        return $row;
    }

    private function find($id)
    {
        return $this->db->raw('SELECT * FROM products WHERE id = ?', [(int) $id])
                        ->fetch(PDO::FETCH_ASSOC);
    }

    // GET api/products
    public function index()
    {
        $this->api->require_method('GET');
        $rows = $this->db->raw('SELECT * FROM products ORDER BY id DESC')
                         ->fetchAll(PDO::FETCH_ASSOC);
        $this->api->respond(['data' => array_map([$this, 'format'], $rows)]);
    }

    // GET api/products/{id}
    public function show($id)
    {
        $this->api->require_method('GET');
        $row = $this->find($id);
        if (!$row) $this->api->respond_error('Product not found', 404);
        $this->api->respond(['data' => $this->format($row)]);
    }

    // POST api/products
    public function store()
    {
        $this->api->require_method('POST');
        [$data, $errors] = $this->validate($this->api->body());
        if ($errors) {
            $this->api->respond(['error' => 'Validation failed', 'errors' => $errors], 422);
        }

        $this->db->raw(
            'INSERT INTO products (product_name, description, price, quantity, created_at)
             VALUES (?, ?, ?, ?, NOW())',
            [$data['product_name'], $data['description'], $data['price'], $data['quantity']]
        );

        $this->api->respond(['message' => 'Product added'], 201);
    }

    // PUT api/products/{id}   (PATCH also accepted if you add the route)
    public function update($id)
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? '';
        if (!in_array($method, ['PUT', 'PATCH'], true)) {
            $this->api->respond_error('Method Not Allowed', 405);
        }

        if (!$this->find($id)) $this->api->respond_error('Product not found', 404);

        [$data, $errors] = $this->validate($this->api->body(), $method === 'PATCH');
        if ($errors) {
            $this->api->respond(['error' => 'Validation failed', 'errors' => $errors], 422);
        }
        if (!$data) $this->api->respond_error('Nothing to update', 400);

        $set    = implode(', ', array_map(fn($col) => "$col = ?", array_keys($data)));
        $params = array_values($data);
        $params[] = (int) $id;

        $this->db->raw("UPDATE products SET $set WHERE id = ?", $params);

        $this->api->respond(['message' => 'Product updated', 'data' => $this->format($this->find($id))]);
    }

    // DELETE api/products/{id}
    public function destroy($id)
    {
        $this->api->require_method('DELETE');
        if (!$this->find($id)) $this->api->respond_error('Product not found', 404);

        $this->db->raw('DELETE FROM products WHERE id = ?', [(int) $id]);
        $this->api->respond(['message' => 'Product deleted']);
    }
}
