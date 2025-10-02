<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IPs;
use App\Models\Equipo;

use TCPDF;

class IPsController extends Controller
{
    public function index()
    {
        $ips = IPs::with(['equipo'])->get();
        return view('ips.index', compact('ips'));
    }
    public function create()
    {
        $equipos = Equipo::all();
        $ips = IPs::all();
        return view('ips.create', compact('equipos'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|exists:equipos,codigo',
            'ip' => 'required',
            'subred' => 'nullable',
            'gateway' => 'nullable',
            'mac' => 'nullable',
            'puerto' => 'nullable',
            'switch' => 'nullable',
        ]);

        IPs::create($validated);

        return redirect()->route('ips.index')->with('success', 'IP asignado correctamente.');
    }
    public function edit($id)
    {
        $ip = IPs::with('equipo')->findOrFail($id);
        return view('ips.edit', compact('ip'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'ip' => 'required',
            'subred' => 'nullable',
            'gateway' => 'nullable',
            'mac' => 'nullable',
            'puerto' => 'nullable',
            'switch' => 'nullable',
        ]);

        $ip = IPs::findOrFail($id);

        // Actualizamos SOLO los campos editables
        $ip->update($validated);

        return redirect()->route('ips.index')->with('success', 'IP actualizada correctamente.');
    }

    public function buscar(Request $request)
    {
        $query = $request->input('ip');

        $ips = IPs::with(['equipo'])
            ->where('codigo', 'like', "%{$query}%")
            ->get();

        return view('ips.index', compact('ips'));
    }

}
