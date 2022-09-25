<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class DocumentDownloadController extends Controller
{
    /**
     * Description : use to download congress draft pdf
     * 
     * @return Response
     */
    public function congressDraft()
    {
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
        return response()->download(
            storage_path('app/public/document/congress-draft.pdf'), 'congress-draft.pdf',
            $headers);
    }

    /**
     * Description : use to download congress draft pdf
     * 
     * @return Response
     */
    public function manualBook()
    {
        $headers = [
            'Content-Type' => 'application/pdf',
        ];
        return response()->download(
            storage_path('app/public/document/manual-book.pdf'), 'manual-book.pdf',
            $headers);
    }
}
