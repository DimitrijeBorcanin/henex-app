<?php

namespace App\Http\Livewire\Users;

use App\Actions\Fortify\CreateNewUser;
use App\Models\Location;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;
use Throwable;

class ShowAll extends Component
{
    use WithPagination;

    private $pagination = 10;
    public $filter = [
        "search" => "",
        "role" => "0",
        "location" => "0"
    ];

    public $user = [
        "name" => '',
        "email" => '',
        "password" => '',
        "password_confirmation" => '',
        "role_id" => '0',
        "location_id" => '0',
        "locations" => []
    ];
    public $selectedRole = 0;

    public $createModalVisible = false;
    public $isEdit = false;
    public $userToUpdate = null;

    public $deleteModalVisible = false;
    public $userToDelete = null;

    private function fetch(){
        $users = User::with('role', 'location')->where('name', 'like', '%'.$this->filter["search"].'%')->where('id', '!=', auth()->id());

        if($this->filter["role"] != 0){
            $users = $users->where('role_id', $this->filter["role"]);
        }

        if($this->filter["location"] != 0){
            $users = $users->where('location_id', $this->filter["location"]);
        }

        return $users->latest()->paginate($this->pagination);
    }

    public function updateRole($userId, $roleId){
        try {
            $user = User::find($userId);
            $user->update(["role_id" => $roleId]);
            $this->dispatchBrowserEvent('flashsuccess', ['message' => 'Uspešno izmenjena uloga!']);
        } catch (Throwable $e){
            $this->dispatchBrowserEvent('flasherror', ['message' => 'Došlo je do greške!']);
        }
    }

    public function updateLocation($userId, $locationId){
        try {
            $user = User::find($userId);
            $user->update(["location_id" => $locationId]);
            $this->dispatchBrowserEvent('success', ['message' => 'Uspešno izmenjena lokacija!']);
        } catch (Throwable $e){
            $this->dispatchBrowserEvent('flasherror', ['message' => 'Došlo je do greške!']);
        }
    }

    public function updatingFilter(){
        $this->resetPage();
    }

    public function showCreateModal(User $user = null){
        if($user->exists){
            $this->isEdit = true;
            $this->userToUpdate = $user;
            $this->user = [
                "name" => $user["name"],
                "email" => $user["email"],
                "password" => '',
                "password_confirmation" => '',
                "role_id" => $user["role_id"],
                "location_id" => $user["location_id"]
            ];
        } else {
            $this->isEdit = false;
        }
        $this->createModalVisible = true;
    }

    public function cancelCreate(){
        $this->resetForm();
        $this->createModalVisible = false;
    }

    public function submitForm(){
        if($this->isEdit){
            $this->updateUser();
        } else {
            $this->createUser();
        }
    }

    public function createUser(){

         if($this->user["role_id"] == 2){
            $this->user["location_id"] = null;
        }

        if($this->user["role_id"] == 3){
            $this->user["locations"] = [$this->user["location_id"]];
        }

        Validator::make($this->user, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', new Password, 'confirmed'],
            'role_id' => ['required', 'not_in:0', 'exists:roles,id'],
            'location_id' => ['required_without:locations', $this->user["role_id"] == 3 ? 'not_in:0' : '', $this->user["role_id"] == 3 ? 'exists:locations,id' : ''],
            'locations' => ['required_without:location_id', 'array', 'min:1'],
            'locations.*' => ['not_in:0', 'exists:locations,id']
        ], [
            'name.required' => 'Ime je obavezno.',
            'name.max' => 'Ime je predugačko.',
            'email.required' => 'Email je obavezan.',
            'email.email' => 'Email nije dobrog formata.',
            'email.max' => 'Email je predugačak.',
            'email.unique' => 'Email već postoji.',
            'password.required' => 'Lozinka je obavezna.',
            'password.confirmed' => 'Potvrda lozinka se ne podudara sa lozinkom.',
            'password.min' => 'Lozinka mora biti bar 8 karaktera.',
            'role_id.required' => 'Uloga je obavezna.',
            'role_id.not_in' => 'Uloga nije izabrana.',
            'role_id.exists' => 'Uloga ne postoji u bazi.',
            'location_id.required_without' => 'Lokacija je obavezna.',
            'location_id.not_in' => 'Lokacija nije izabrana.',
            'location_id.exists' => 'Lokacija ne postoji u bazi.',
            'locations.required_without' => 'Lokacija je obavezna.',
            'locations.min' => 'Mora biti izabrana bar 1 lokacija.',
            'locations.*.not_in' => 'Mora biti izabrana bar 1 lokacija.',
            'locations.*.exists' => 'Lokacija ne postoji u bazi.'

        ])->validate();

        try {
            DB::beginTransaction();
            $create = new CreateNewUser();
            $newUser = $create->create($this->user);
            if($this->user["role_id"] == 2 && count($this->user["locations"]) > 0){
                $newUser->locations()->sync($this->user["locations"]);
            }
            DB::commit();
            $this->resetForm();
            $this->createModalVisible = false;
            $this->dispatchBrowserEvent('success', ['message' => 'Uspešno dodat korisnik!']);
        } catch (Throwable $e){
            DB::rollBack();
        }

        
    }

    public function updateUser(){
        $user = User::find($this->userToUpdate["id"]);

        if($this->user["role_id"] == 2){
            $this->user["location_id"] = null;
        }

        if($this->user["role_id"] == 3){
            $this->user["locations"] = [$this->user["location_id"]];
        }

        Validator::make($this->user, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['string', new Password, 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
            'location_id' => ['required_without:locations', $this->user["role_id"] == 3 ? 'not_in:0' : '', $this->user["role_id"] == 3 ? 'exists:locations,id' : ''],
            'locations' => ['required_without:location_id', 'array', 'min:1'],
            'locations.*' => ['not_in:0', 'exists:locations,id']
        ], [
            'name.required' => 'Ime je obavezno.',
            'name.max' => 'Ime je predugačko.',
            'email.required' => 'Email je obavezan.',
            'email.email' => 'Email nije dobrog formata.',
            'email.max' => 'Email je predugačak.',
            'email.unique' => 'Email već postoji.',
            'password.confirmed' => 'Potvrda lozinka se ne podudara sa lozinkom.',
            'password.min' => 'Lozinka mora biti bar 8 karaktera.',
            'role_id.required' => 'Uloga je obavezna.',
            'role_id.not_in' => 'Uloga nije izabrana.',
            'role_id.exists' => 'Uloga ne postoji u bazi.',
            'location_id.required_without' => 'Lokacija je obavezna.',
            'location_id.not_in' => 'Lokacija nije izabrana.',
            'location_id.exists' => 'Lokacija ne postoji u bazi.',
            'locations.required_without' => 'Lokacija je obavezna.',
            'locations.min' => 'Mora biti izabrana bar 1 lokacija.',
            'locations.*.not_in' => 'Mora biti izabrana bar 1 lokacija.',
            'locations.*.exists' => 'Lokacija ne postoji u bazi.'
        ])->validate();

        try {
            if(!empty($this->user["password"]) || !empty($this->user["password_confirmation"])){
                $this->user["password"] = Hash::make($this->user["password"]);
                $user->update($this->user);
            } else {
                $user->update([
                    "name" => $this->user["name"],
                    "email" => $this->user["email"],
                    "role_id" => $this->user["role_id"],
                    "location_id" => $this->user["location_id"],
                ]);
            }
            if($this->user["role_id"] == 2 && count($this->user["locations"]) > 0){
                $user->locations()->sync($this->user["locations"]);
            }
            $this->resetForm();
            $this->isEdit = false;
            $this->userToUpdate = null;
            $this->createModalVisible = false;
            $this->dispatchBrowserEvent('success', ['message' => 'Uspešno izmenjen korisnik!']);
        } catch(Throwable $e){
            DB::rollBack();
        }

        
    }

    public function showDeleteModal($user){
        $this->userToDelete = $user;
        $this->deleteModalVisible = true;
    }

    public function cancelDelete(){
        $this->deleteModalVisible = false;
        $this->userToDelete = null;
    }

    public function deleteUser(){
        if($this->userToDelete != null){
            $user = User::find($this->userToDelete['id']);
            $user->delete();
            $this->deleteModalVisible = false;
            $this->resetPage();
            $this->userToDelete = null;
            $this->dispatchBrowserEvent('success', ['message' => 'Uspešno obrisan korisnik!']);
        }
    }

    public function resetForm(){
        $this->user = [
            "name" => '',
            "email" => '',
            "password" => '',
            "password_confirmation" => '',
            "role_id" => '0',
            "location_id" => '0'
        ];
        $this->selectedRole = 0;
    }

    public function changeSelectedRole(){
        $this->selectedRole = $this->user["role_id"];
    }

    public function render()
    {
        return view('livewire.users.show-all', [
            'users' => $this->fetch(),
            'roles' => Role::all(),
            'locations' => Location::all()
        ]);
    }
}
