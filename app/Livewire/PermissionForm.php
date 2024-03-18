<?php

namespace App\Livewire;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Masmerise\Toaster\Toastable;
use Spatie\Permission\Models\Permission;

class PermissionForm extends ModalComponent
{
    use Toastable;

    public Permission $permission;
    public $id, $name;

    public function mount($rowId = null)
    {
        $this->permission = Permission::findOrNew($rowId);
        $this->id = $this->permission->id;
        $this->name = $this->permission->name;
    }

    public function render()
    {
        return view('livewire.permission-form');
    }

    public function resetForm()
    {
        $this->id = '';
        $this->name = '';
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:permissions,name,' . $this->permission->id,
        ];
    }

    public function store()
    {
        $validatedData = $this->validate();
        $validatedData['guard_name'] = 'web';

        $this->permission->fill($validatedData);
        $this->permission->save();

        $this->closeModalWithEvents([
            PermissionTable::class => 'permissionsUpdated',
        ]);

        $this->success($this->permission->wasRecentlyCreated ? 'Permission berhasil dibuat' : 'Permission berhasil diupdate');

        $this->resetForm();
    }
}
