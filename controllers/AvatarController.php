<?php

class AvatarController extends Controller
{
    public function create()
    {
        $avatarFiles = glob('assets/avatars/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        $worldFiles = glob('assets/worlds/*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        // Prepare data for view
        // Convert paths for web usage (replace backslashes on Windows)
        $avatarFiles = $avatarFiles ? array_map(function ($p) {
            return str_replace('\\', '/', $p); }, $avatarFiles) : [];
        $worldFiles = $worldFiles ? array_map(function ($p) {
            return str_replace('\\', '/', $p); }, $worldFiles) : [];

        $data = [
            'avatars' => $avatarFiles,
            'worlds' => $worldFiles
        ];

        $this->view('avatar/create', $data);
    }
}
