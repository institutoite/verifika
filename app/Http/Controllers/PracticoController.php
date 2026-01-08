<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Practico;
use Mpdf\Mpdf;

class PracticoController extends Controller
   
{
    public function index()
    {
        $user = Auth::user();
        $practicos = Practico::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('practicos.index', compact('practicos'));
    }

     public function edit($id)
    {
        $practico = Practico::findOrFail($id);
        return view('practicos.edit', compact('practico'));
    }

    public function update(Request $request, $id)
    {
        $practico = Practico::findOrFail($id);
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
        $practico->nombre = $request->nombre;
        // No actualizar la fecha de creación
        $practico->save();
        return redirect()->route('practicos.index')->with('success', 'Práctico actualizado correctamente.');
    }
    
    public function ejercicios($id)
    {
        $practico = Practico::with('ejercicios.operandos')->findOrFail($id);
        return view('practicos.ejercicios', compact('practico'));
    }

    public function imprimir($id, $tipo = 'propuestos')
    {
        $practico = Practico::with('ejercicios.operandos')->findOrFail($id);
        if ($tipo === 'multiplicacion') {
            $practicos = collect([$practico]);
            $html = view('practicos.pdfmultiplicacion', compact('practicos'))->render();
            $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
            $mpdf->WriteHTML($html);
            $filename = 'multiplicaciones_' . $practico->id . '.pdf';
            return response($mpdf->Output($filename, 'S'), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ]);
        }
        $html = view('practicos.pdf', compact('practico', 'tipo'))->render();
        $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
        $mpdf->WriteHTML($html);
        $filename = 'practico_' . $practico->id . '_' . $tipo . '.pdf';
        return response($mpdf->Output($filename, 'S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }
    public function destroy($id)
    {
        $practico = Practico::findOrFail($id);
        $practico->delete();
        return redirect()->route('practicos.index')->with('success', 'Práctico eliminado correctamente.');
    }
}
