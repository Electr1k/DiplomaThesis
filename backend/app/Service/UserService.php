<?php

namespace App\Service;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

readonly class UserService
{
    public function __construct(private UserRepository $userRepository){}

    public function index(array $params): Collection
    {
        return $this->userRepository->getAll($params);
    }

    public function store(array $data): User
    {

        $user = $this->userRepository->store($data);

        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            $path = $data['photo']->store('users/profile-'.$user->id, 'public');
            $user->image = Storage::url($path);
            $user->save();
        }

        return $user;
    }

    public function update(array $data, User $user): User
    {
        if (isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            $path = 'users/profile-' . $user->id;
            Storage::delete($path);

            $path = $data['photo']->store($path, 'public');

            $user->image = Storage::url($path);
            $user->save();
        }

        return $this->userRepository->update($data, $user);
    }

    public function destroy(User $role): ?bool
    {

        return $this->userRepository->destroy($role);
    }

}
