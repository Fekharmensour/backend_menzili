<?php

namespace App\Services\Member;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function updateBasicInfo(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function updateProfileImage(User $user, UploadedFile $file): bool
    {
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $path = $file->store('profiles', 'public');
        return $user->update(['profile_image' => $path]);
    }

    public function updatePassword(User $user, string $newPassword): bool
    {
        // This works whether the user has a password or if the column is null
        $user->password = Hash::make($newPassword);
        return $user->save();
    }

    public function submitMemberVerification(User $user, array $data): bool
    {
        $member = $user->member;

        if (!$member) {
            return false;
        }

        return $member->update([
            'card_id_front_path' => $data['card_id_front']->store('verifications/ids', 'private'),
            'card_id_back_path'  => $data['card_id_back']->store('verifications/ids', 'private'),
            'member_verified_at' => null,
        ]);
    }

    public function submitAgentVerification(User $user, UploadedFile $document): bool
    {
        $member = $user->member;

        if (!$member || !$member->member_verified_at) {
            return false;
        }

        return $member->update([
            'document_path'     => $document->store('verifications/docs', 'private'),
            'agent_verified_at' => null,
        ]);
    }
}
