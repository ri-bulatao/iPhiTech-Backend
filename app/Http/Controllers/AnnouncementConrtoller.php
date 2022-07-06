<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

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
        $announcement = Announcement::find($id);

        return response()->json([
            'announcement'  => $announcement
        ], 200);
    }

}
