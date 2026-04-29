<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Camiseta;
use App\Models\VarianteCamiseta;
use Illuminate\Http\Request;

class VarianteAdminController extends Controller
{
    const TALLAS = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

    public function index()
    {
        $camisetas = Camiseta::with('variantes')
            ->orderBy('cod_cam', 'desc')
            ->paginate(20);

        return view('admin.variantes.index', compact('camisetas'));
    }

    public function edit(Camiseta $camiseta)
    {
        $camiseta->load('variantes');
        $tallas = self::TALLAS;

        return view('admin.variantes.edit', compact('camiseta', 'tallas'));
    }

    public function update(Request $request, Camiseta $camiseta)
    {
        $request->validate([
            'stock'         => 'nullable|array',
            'stock.*'       => 'integer|min:0',
            'nueva_talla'   => 'nullable|string|max:5',
            'nuevo_stock'   => 'nullable|integer|min:0',
        ]);

        // Actualizar stock de variantes existentes
        foreach ($request->input('stock', []) as $codVar => $valor) {
            VarianteCamiseta::where('cod_var', $codVar)
                ->where('cod_cam', $camiseta->cod_cam)
                ->update(['stock' => (int) $valor]);
        }

        // Añadir nueva variante si se indicó talla
        $nuevaTalla = $request->input('nueva_talla');
        if ($nuevaTalla) {
            $existe = $camiseta->variantes()->where('talla', $nuevaTalla)->exists();
            if (!$existe) {
                VarianteCamiseta::create([
                    'cod_cam' => $camiseta->cod_cam,
                    'talla'   => $nuevaTalla,
                    'stock'   => $request->input('nuevo_stock', 0),
                ]);
            }
        }

        return redirect()->route('admin.variantes.edit', $camiseta->cod_cam)
            ->with('success', 'Stock actualizado correctamente.');
    }

    public function destroy(Camiseta $camiseta, VarianteCamiseta $variante)
    {
        abort_if($variante->cod_cam !== $camiseta->cod_cam, 403);
        $variante->delete();

        return redirect()->route('admin.variantes.edit', $camiseta->cod_cam)
            ->with('success', 'Variante eliminada.');
    }
}
