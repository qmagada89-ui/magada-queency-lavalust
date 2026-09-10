<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: ProductController
 * 
 * Automatically generated via CLI.
 */
class ProductController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->call->model('ProductModel');
    }

    public function index()
    {
        $this->call->view('products/index', [
            'products' => $this->ProductModel->getAll(),
            'session'  => $this->session,
        ]);
    }

    public function create()
    {
        if ($this->io->method() == 'post') {
            $this->ProductModel->create([
                'product_name' => $this->io->post('product_name'),
                'description'  => $this->io->post('description'),
                'price'        => $this->io->post('price'),
                'quantity'     => $this->io->post('quantity'),
                'created_at'   => date('Y-m-d H:i:s'),
            ]);
            redirect('products');
        }

        $this->call->view('products/create');
    }

    public function edit($id)
    {
        $product = $this->ProductModel->getById($id);

        if (!$product) {
            redirect('products');
        }

        if ($this->io->method() == 'post') {
            $this->ProductModel->updateProduct($id, [
                'product_name' => $this->io->post('product_name'),
                'description'  => $this->io->post('description'),
                'price'        => $this->io->post('price'),
                'quantity'     => $this->io->post('quantity'),
            ]);
            redirect('products');
        }

        $this->call->view('products/edit', ['product' => $product]);
    }

    public function delete($id)
    {
        $this->ProductModel->deleteProduct($id);
        redirect('products');
    }



}