<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Barang as BarangModel;

class Barang extends Component
{
    public $listbrg,$kode, $nama, $satuan, $harga, $jenis,$id_brg;
    public $isModalOpen = 0;

    public function render()
    {
        $this->listbrg = BarangModel::all();
        return view('livewire.barang');
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }

    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }

    private function resetCreateForm(){
        $this->kode = '';
        $this->nama = '';
        $this->satuan = '';
    }
    
    public function store()
    {
        $this->validate([
            'kode' => 'required',
            'nama' => 'required',
            'satuan' => 'required',
        ]);
    
        BarangModel::updateOrCreate(['id' => $this->id_brg], [
            'kode' => $this->kode,
            'nama' => $this->nama,
            'satuan' => $this->satuan,
        ]);

        session()->flash('message', $this->id_brg ? 'Barang updated.' : 'Barang created.');

        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $barang = BarangModel::findOrFail($id);
        $this->id_brg = $id;
        $this->kode = $barang->kode;
        $this->nama = $barang->nama;
        $this->satuan = $barang->satuan;
    
        $this->openModalPopover();
    }
    
    public function delete($id)
    {
        BarangModel::find($id)->delete();
        session()->flash('message', 'Barang deleted.');
    }
}
