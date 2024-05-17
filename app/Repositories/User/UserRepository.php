<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Models\UserPasswordHistory;
use App\Repositories\User\Interfaces\UserRepositoryInterface;
use App\Traits\AuthenticationTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserRepository implements UserRepositoryInterface
{

    use AuthenticationTrait;

    public function all()
    {
        $users = User::with(['doctype', 'roles'])
            ->where('users.userStatus', 1)
            ->orderBy('users.firstName', 'ASC')
            ->get();

        if (!$users) return $this->error("We could not Find Users", 204);

        return $this->success($users, count($users), "Users Returned!", 200);
    }

    public function getUserById(User $user)
    {
        // TODO: Implement getUserById() method.
    }

    public function addRoleToUserByID($idUser, $idRole)
    {
        // TODO: Implement addRoleToUserByID() method.
    }

    public function inactivateUserById(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) return $this->error("We could not Find the User with ID" . $id, 204);
        $user->userStatus = 0;

        if (!$user->delete()) return $this->error("There was an Error Inactivating this User" . $user->id, 500);

        $user->delete();

        return $this->success([],1,  "Usuario Actualizado",200);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        if (!Hash::check($request->old_password, \auth()->user()->password)) {
            return $this->error("Incorrect Old Password", 204, "");
        }

        $user = User::find(\auth()->user()->id);

        $passwordTemp =  Hash::make($request->new_password);

        $user->password = $passwordTemp;
        $user->passwordExpirationDate = Carbon::now()->addMonths(3);

        if (!$user->save()) return $this->error("Could not change password", 400, "");

        UserPasswordHistory::create([
            'user_id' => \auth()->user()->id,
            'password' => $passwordTemp
        ]);

        return $this->success([], 1, "Password Changed Successfully!", 201);
    }

    public function updateUser(Request $request, $userid = null)
    {
        try {

            if (!$userid) return $this->error("Parametro userid no puede estar vacio", 400, "");

            Validator::make($request->all(), [
                'firstName' => ['required', 'string', 'max:60'],
                'middleName' => ['string', 'max:60'],
                'lastName' => ['required', 'string', 'max:60'],
                'surName' => ['string', 'max:60'],
                //'username' => ['required', 'string', 'max:20'],
                'doc_type_id' => ['required'],
                'document' => ['required', 'max:25'],
                'phone' => ['max:12'],
                'address' => ['string'],
            ])->validate();

            $user = User::find($userid);

            if (!$user) return $this->error("No se encontro ningun usuario con este ID", 400, "");

            $user->firstName = $request->firstName;
            $user->middleName = $request->middleName;
            $user->lastName = $request->lastName;
            $user->surName = $request->surName;
            //$user->username = $request->username;
            $user->doc_type_id = $request->doc_type_id;
            $user->document = $request->document;
            $user->phone = $request->phone;
            $user->address = $request->address;
            //$user->email = $request->email;
            $user->syncRoles($request->role_id);

            if (!$user->update()) return $this->error("Error al actualizar el usuario", 400, "");

            return $this->success($user, 1, "Usuario actualizado Correctamente", 201);


        } catch (\Throwable $th) {
            return $th;
        }
    }
}
