<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function store(Request $request)
    {
        
        $request->validate([
            'certificate' => 'required|file|max:2048',
        ]);
    
        // Dapatkan file yang diupload
        $file = $request->file('certificate');
    
        // Buat path penyimpanan dengan nama file asli
        $fileName = $file->getClientOriginalName();
        $path = $file->storeAs('certificates', $fileName);
    
        // Ambil data sertifikat dari user yang sedang login
        $certificate = Auth::user()->certificate;
    
        if ($certificate) {
            // Hapus file sertifikat lama
            Storage::delete($certificate->certificate_path);
            // Update sertifikat dengan path baru
            $certificate->update([
                'certificate_path' => $path,
            ]);
        } else {
            // Buat entri sertifikat baru
            Certificate::create([
                'user_id' => Auth::id(),
                'certificate_path' => $path,
            ]);
        }
    
        // Kembalikan respons JSON
        return response()->json([
            'success' => true,
            'message' => 'Sertifikat berhasil diunggah!',
            'certificate_path' => $path
        ], 200);
    
    }
}
