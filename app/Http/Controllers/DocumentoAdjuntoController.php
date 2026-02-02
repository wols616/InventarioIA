<?php

namespace App\Http\Controllers;

use App\Models\DocumentoAdjunto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;

class DocumentoAdjuntoController extends Controller
{
    public function index(Request $request)
    {
        $activoId = $request->query('activo');
        if($activoId){
            $docs = DocumentoAdjunto::where('id_activo', $activoId)->get();
        } else {
            $docs = DocumentoAdjunto::all();
        }
        return view('documentos.index', ['documentos' => $docs, 'activoId' => $activoId]);
    }

    public function create(Request $request)
    {
        $activoId = $request->query('activo');
        return view('documentos.create', compact('activoId'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_activo' => 'required|integer',
            'tipo_documento' => 'nullable|string|max:150',
            'archivo' => 'required|file|max:10240',
        ]);

        $file = $request->file('archivo');
        $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_.-]/', '_', $file->getClientOriginalName());
        // store locally in storage/app/public/documentos
        $path = $file->storeAs('documentos', $filename, 'public');
        $publicUrl = Storage::url($path);

        // attempt upload to Supabase Storage if configured
        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_KEY');
        $supabaseBucket = env('SUPABASE_BUCKET');
        if($supabaseUrl && $supabaseKey && $supabaseBucket){
            try {
                $supPath = 'documentos/' . $filename;
                $contents = file_get_contents($file->getRealPath());
                $resp = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $supabaseKey,
                    'Content-Type' => $file->getClientMimeType(),
                ])->put(rtrim($supabaseUrl, '/') . '/storage/v1/object/' . $supabaseBucket . '/' . $supPath, $contents);
                if($resp->successful()){
                    // public URL for supabase storage (may require bucket to be public)
                    $publicUrl = rtrim($supabaseUrl, '/') . '/storage/v1/object/public/' . $supabaseBucket . '/' . $supPath;
                }
            } catch (\Exception $e) {
                // ignore and fall back to local URL
            }
        }

        $doc = DocumentoAdjunto::create([
            'id_activo' => $data['id_activo'],
            'tipo_documento' => $data['tipo_documento'] ?? null,
            'ruta_archivo' => $publicUrl,
        ]);

        return Redirect::route('documentos.index', ['activo' => $data['id_activo']])->with('success', 'Documento guardado.');
    }

    public function show(DocumentoAdjunto $documento)
    {
        return view('documentos.show', compact('documento'));
    }

    public function destroy(DocumentoAdjunto $documento)
    {
        // Optionally delete local file
        try{
            if($documento->ruta_archivo && str_contains($documento->ruta_archivo, '/storage/')){
                // convert URL to storage path
                $path = str_replace('/storage/','',$documento->ruta_archivo);
                Storage::disk('public')->delete($path);
            }
        }catch(\Exception $e){}

        $documento->delete();
        return Redirect::back()->with('success', 'Documento eliminado');
    }
}
