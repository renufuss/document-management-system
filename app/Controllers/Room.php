<?php

namespace App\Controllers;

use App\Models\RoomModel;

class Room extends BaseController
{
    protected $roomModel;
    public function __construct()
    {
        $this->roomModel = new RoomModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Ruang',
        ];
        return view('MasterSetup/Room/index', $data);
    }

    public function validateRoom($roomId)
    {
        $room = $this->roomModel->find($roomId);
        if (!is_null($room)) {
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
            $roomId = $this->request->getPost('roomId');
            $isRoom = $this->validateRoom($roomId);
            if (!$isRoom) {
                $response['error'] = 'Ruang tidak ditemukan';
                return json_encode($response);
            }

            $room = $this->roomModel->find($roomId);
            $response['success'] =  view('Modal', $room);
            return json_encode($response);
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $room = $this->request->getPost();
            $isValid = $this->validateData($room, $this->roomModel->getValidationRules(), $this->roomModel->getValidationMessages());

            if (!$isValid) {
                $response = [
                    'error' => $this->validator->getErrors(),
                    'message'=> 'Gagal menyimpan ruang',
                ];
                return json_encode($response);
            }

            $this->roomModel->save($room);
            $response['success'] = 'Sukses menyimpan ruang';

            return json_encode($response);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $roomId = $this->request->getPost('roomId');
            $isRoom = $this->validateRoom($roomId);

            if (!$isRoom) {
                $response['error'] = 'Ruang tidak ditemukan';
                return json_encode($response);
            }

            $this->roomModel->delete($roomId);
            $response['success'] =  'Ruang berhasil dihapus';
            return json_encode($response);
        }
    }
}
