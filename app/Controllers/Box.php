<?php

namespace App\Controllers;

use App\Models\BoxModel;

class Box extends BaseController
{
    protected $boxModel;
    public function __construct()
    {
        $this->boxModel = new BoxModel();
    }

    public function index()
    {
        return view('welcome_message');
    }

    public function validateBox($boxId)
    {
        $box = $this->boxModel->find($boxId);
        if (!is_null($box)) {
            return true;
        }
        return false;
    }

    public function validateShelf($shelfId = [])
    {
        $box = $this->boxModel->find($shelfId);
        if (!is_null($box)) {
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
            $boxId = $this->request->getPost('boxId');
            $isBox = $this->validateBox($boxId);
            if (!$isBox) {
                $response['error'] = 'Rak tidak ditemukan';
                return json_encode($response);
            }

            $data = [
                'box' => $this->boxModel->find($boxId),
                'shelf' => $this->boxModel->showShelfs($boxId),
            ];
            $response['success'] =  view('Modal', $data);
            return json_encode($response);
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $box = $this->request->getPost();
            $shelfId = $this->request->getPost('shelfs');

            $isValid = $this->validateData($box, $this->boxModel->getValidationRules(), $this->boxModel->getValidationMessages());
            if (!$isValid) {
                $response = [
                    'error' => $this->validator->getErrors(),
                    'message'=> 'Gagal menyimpan box',
                ];
                return json_encode($response);
            }

            $isShelf = $this->validateShelf($shelfId);
            if (!$isShelf) {
                $response = [
                    'error' => [
                        'shelfs' => 'Rak tidak boleh kosong',
                    ],
                    'message'=> 'Gagal menyimpan box',
                ];
                return json_encode($response);
            }

            $this->boxModel->save($box);

            $boxId = $this->boxModel->getInsertID();

            $this->boxModel->removeFromShelfs($boxId);
            $this->boxModel->addToShelfs($boxId, $shelfId);

            $response['success'] = 'Sukses menyimpan box';

            return json_encode($response);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $boxId = $this->request->getPost('boxId');
            $isBox = $this->validateBox($boxId);

            if (!$isBox) {
                $response['error'] = 'Rak tidak ditemukan';
                return json_encode($response);
            }

            $this->boxModel->delete($boxId);
            $response['success'] =  'Rak berhasil dihapus';
            return json_encode($response);
        }
    }
}
