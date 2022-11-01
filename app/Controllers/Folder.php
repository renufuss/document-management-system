<?php

namespace App\Controllers;

use App\Models\FolderModel;

class Folder extends BaseController
{
    protected $folderModel;
    public function __construct()
    {
        $this->folderModel = new FolderModel();
    }

    public function index()
    {
        return view('welcome_message');
    }

    public function validateFolder($folderId)
    {
        $folder = $this->folderModel->find($folderId);
        if (!is_null($folder)) {
            return true;
        }
        return false;
    }

    public function validateBox($boxId = [])
    {
        $folder = $this->folderModel->find($boxId);
        if (!is_null($folder)) {
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
            $folderId = $this->request->getPost('folderId');
            $isFolder = $this->validateFolder($folderId);
            if (!$isFolder) {
                $response['error'] = 'Rak tidak ditemukan';
                return json_encode($response);
            }

            $data = [
                'folder' => $this->folderModel->find($folderId),
                'box' => $this->folderModel->showBoxs($folderId),
            ];
            $response['success'] =  view('Modal', $data);
            return json_encode($response);
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $folder = $this->request->getPost();
            $boxId = $this->request->getPost('boxs');

            $isValid = $this->validateData($folder, $this->folderModel->getValidationRules(), $this->folderModel->getValidationMessages());
            if (!$isValid) {
                $response = [
                    'error' => $this->validator->getErrors(),
                    'message'=> 'Gagal menyimpan rak',
                ];
                return json_encode($response);
            }

            $isBox = $this->validateBox($boxId);
            if (!$isBox) {
                $response = [
                    'error' => [
                        'boxs' => 'Box tidak boleh kosong',
                    ],
                    'message'=> 'Gagal menyimpan rak',
                ];
                return json_encode($response);
            }

            $this->folderModel->save($folder);

            $folderId = $this->folderModel->getInsertID();

            $this->folderModel->removeFromBoxs($folderId);
            $this->folderModel->addToBoxs($folderId, $boxId);

            $response['success'] = 'Sukses menyimpan rak';

            return json_encode($response);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $folderId = $this->request->getPost('folderId');
            $isFolder = $this->validateFolder($folderId);

            if (!$isFolder) {
                $response['error'] = 'Rak tidak ditemukan';
                return json_encode($response);
            }

            $this->folderModel->delete($folderId);
            $response['success'] =  'Rak berhasil dihapus';
            return json_encode($response);
        }
    }
}
