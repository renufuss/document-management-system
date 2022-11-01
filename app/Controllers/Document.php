<?php

namespace App\Controllers;

use App\Models\DocumentModel;

class Document extends BaseController
{
    protected $documentModel;
    public function __construct()
    {
        $this->documentModel = new DocumentModel();
    }

    public function index()
    {
        return view('welcome_message');
    }

    public function validateDocument($documentId)
    {
        $document = $this->documentModel->find($documentId);
        if (!is_null($document)) {
            return true;
        }
        return false;
    }

    public function removeDocument($document)
    {
        if (!is_null($document)) {
            $isExist = file_exists('assets/document/' . $document);
            if ($isExist) {
                unlink('assets/document/' . $document);
                return true;
            }
            return false;
        }
    }

    public function uploadDocument($document)
    {
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
            $documentId = $this->request->getPost('documentId');
            $isDocument = $this->validateDocument($documentId);
            if (!$isDocument) {
                $response['error'] = 'Dokumen tidak ditemukan';
                return json_encode($response);
            }

            $document = $this->documentModel->find($documentId);
            $response['success'] =  view('Modal', $document);
            return json_encode($response);
        }
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $documentId = $this->request->getPost('id');

            if (!is_null($documentId)) {
                $isDocument = $this->validateDocument($documentId);
                if (!$isDocument) {
                    $response['error'] = 'Dokumen tidak ditemukan';
                    return json_encode($response);
                }
                $oldDocument = $this->documentModel->find($documentId);
            }

            $document = $this->request->getPost();
            $file = $this->request->getFile('file');

            $isValid = $this->validateData($document, $this->documentModel->getValidationRules(), $this->documentModel->getValidationMessages());
            if (!$isValid) {
                $response = [
                    'error' => $this->validator->getErrors(),
                    'message'=> 'Gagal menyimpan dokumen',
                ];
                return json_encode($response);
            }

            $isUseOldDocument = !is_null($documentId) && $file->getError() == 4;
            if ($isUseOldDocument) {
                $file = $oldDocument->file;
            }

            $isUploaded = $file->getError() != 4;
            if ($isUploaded) {
                $this->removeDocument($oldDocument->file);
                $this->uploadDocument($file);
            }

            $this->documentModel->save($document);
            $response['success'] = 'Sukses menyimpan dokumen';

            return json_encode($response);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $documentId = $this->request->getPost('documentId');
            $isDocument = $this->validateDocument($documentId);

            if (!$isDocument) {
                $response['error'] = 'Dokumen tidak ditemukan';
                return json_encode($response);
            }

            $this->documentModel->delete($documentId);
            $response['success'] =  'Dokumen berhasil dihapus';
            return json_encode($response);
        }
    }

    public function restore()
    {
    }
}
