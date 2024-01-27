<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Requests\UpdateDocumentRequest;
use App\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function download(Document $document)
    {
        return Storage::download($document->getFullPath());
    }
    public function destroy(Document $document)
    {
        Storage::delete($document->getFullPath());
        $document->delete();
        return new JsonResponse(['msg'=>'deleted']);
    }

}
