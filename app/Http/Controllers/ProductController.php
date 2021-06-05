<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('produk.index', Produk::all());
    }

    public function add(Request $request)
    {
        $this->validate($request,[
            'nama_produk' => 'required', 
            'keterangan' => 'required', 
            'harga' => 'required', 
            'jumlah' => 'required',
        ]);

        $newProduk = new Produk();
        $newProduk->nama_produk = $request->nama_produk;
        $newProduk->keterangan = $request->keterangan;
        $newProduk->harga = $request->harga;
        $newProduk->jumlah = $request->jumlah;
        $newProduk->save();


        return response()->json($newProduk);
    }

    public function update($id, Request $request)
    {
        $this->validate($request,[
            'nama_produk' => 'required', 
            'keterangan' => 'required', 
            'harga' => 'required', 
            'jumlah' => 'required',
        ]);

        $editProduct = Produk::findOrFail($id);
        $editProduct->nama_produk = $request->nama_produk;
        $editProduct->keterangan = $request->keterangan;
        $editProduct->harga = $request->harga;
        $editProduct->jumlah = $request->jumlah;
        $editProduct->save();
        return response()->json($editProduct);
    }

    public function delete($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return response($produk);
    }

}
