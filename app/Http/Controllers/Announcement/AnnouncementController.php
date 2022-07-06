<?php

namespace App\Http\Controllers\Announcement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement as AnnouncementModel;

class AnnouncementController extends Controller
{
    
    /**
     * Fetching all the announcements
     */
    public function test()
    {
        $test = 'testing';

        return response()->json([
            'announcements' => $test
        ], 200);
    }

    /**
     * For Fetching single announcement
     */
    public function get($id)
    {
        $announcement = AnnouncementModel::find($id);

        return response()->json([
            'successful' => !empty($announcement),
            'data' => [
                'announcement'  => $announcement
            ]
        ], 200);
    }
}
