<?php

namespace App\Controllers;

use App\Models\OrderModel;

class Order extends BaseController
{
    protected $orderModel;
    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    public function index()
    {
        return view('welcome_message');
    }

    public function validateOrder($orderId)
    {
        $order = $this->orderModel->find($orderId);
        if (!is_null($order)) {
            return true;
        }
        return false;
    }

    public function validateFolder($folderId = [])
    {
        $order = $this->orderModel->find($folderId);
        if (!is_null($order)) {
            return true;
        }
        return false;
    }

    public function add()
    {
        if ($this->request->isAJAX()) {
            $response['success'] =  view('Modal');
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $orderId = $this->request->getPost('orderId');
            $isOrder = $this->validateOrder($orderId);
            if (!$isOrder) {
                $response['error'] = 'Rak tidak ditemukan';
                return json_encode($response);
            }

            $data = [
                'order' => $this->orderModel->find($orderId),
                'folder' => $this->orderModel->showFolders($orderId),
            ];
            $response['success'] =  view('Modal', $data);
            return json_encode($response);
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $order = $this->request->getPost();
            $folderId = $this->request->getPost('folders');

            $isValid = $this->validateData($order, $this->orderModel->getValidationRules(), $this->orderModel->getValidationMessages());
            if (!$isValid) {
                $response = [
                    'error' => $this->validator->getErrors(),
                    'message'=> 'Gagal menyimpan rak',
                ];
                return json_encode($response);
            }

            $isFolder = $this->validateFolder($folderId);
            if (!$isFolder) {
                $response = [
                    'error' => [
                        'folders' => 'Folder tidak boleh kosong',
                    ],
                    'message'=> 'Gagal menyimpan rak',
                ];
                return json_encode($response);
            }

            $this->orderModel->save($order);

            $orderId = $this->orderModel->getInsertID();

            $this->orderModel->removeFromFolders($orderId);
            $this->orderModel->addToFolders($orderId, $folderId);

            $response['success'] = 'Sukses menyimpan rak';

            return json_encode($response);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $orderId = $this->request->getPost('orderId');
            $isOrder = $this->validateOrder($orderId);

            if (!$isOrder) {
                $response['error'] = 'Rak tidak ditemukan';
                return json_encode($response);
            }

            $this->orderModel->delete($orderId);
            $response['success'] =  'Rak berhasil dihapus';
            return json_encode($response);
        }
    }
}
