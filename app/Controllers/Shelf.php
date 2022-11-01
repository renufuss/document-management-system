<?php

namespace App\Controllers;

use App\Models\ShelfModel;

class Shelf extends BaseController
{
    protected $shelfModel;
    public function __construct()
    {
        $this->shelfModel = new ShelfModel();
    }

    public function index()
    {
        return view('welcome_message');
    }

    public function validateShelf($shelfId)
    {
        $shelf = $this->shelfModel->find($shelfId);
        if (!is_null($shelf)) {
            return true;
        }
        return false;
    }

    public function validateRoom($roomId = [])
    {
        $shelf = $this->shelfModel->find($roomId);
        if (!is_null($shelf)) {
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
            $shelfId = $this->request->getPost('shelfId');
            $isShelf = $this->validateShelf($shelfId);
            if (!$isShelf) {
                $response['error'] = 'Rak tidak ditemukan';
                return json_encode($response);
            }

            $data = [
                'shelf' => $this->shelfModel->find($shelfId),
                'room' => $this->shelfModel->showRooms($shelfId),
            ];
            $response['success'] =  view('Modal', $data);
            return json_encode($response);
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $shelf = $this->request->getPost();
            $roomId = $this->request->getPost('rooms');

            $isValid = $this->validateData($shelf, $this->shelfModel->getValidationRules(), $this->shelfModel->getValidationMessages());
            if (!$isValid) {
                $response = [
                    'error' => $this->validator->getErrors(),
                    'message'=> 'Gagal menyimpan rak',
                ];
                return json_encode($response);
            }

            $isRoom = $this->validateRoom($roomId);
            if (!$isRoom) {
                $response = [
                    'error' => [
                        'rooms' => 'Ruang tidak boleh kosong',
                    ],
                    'message'=> 'Gagal menyimpan rak',
                ];
                return json_encode($response);
            }

            $this->shelfModel->save($shelf);

            $shelfId = $this->shelfModel->getInsertID();

            $this->shelfModel->removeFromRooms($shelfId);
            $this->shelfModel->addToRooms($shelfId, $roomId);

            $response['success'] = 'Sukses menyimpan rak';

            return json_encode($response);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $shelfId = $this->request->getPost('shelfId');
            $isShelf = $this->validateShelf($shelfId);

            if (!$isShelf) {
                $response['error'] = 'Rak tidak ditemukan';
                return json_encode($response);
            }

            $this->shelfModel->delete($shelfId);
            $response['success'] =  'Rak berhasil dihapus';
            return json_encode($response);
        }
    }
}
