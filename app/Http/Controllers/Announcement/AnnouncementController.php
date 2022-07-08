<?php

declare(strict_types=1);

namespace App\Http\Controllers;

namespace App\Http\Controllers\Announcement;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnnouncementRequest;
use App\Http\Requests\ImageRequest;
use App\Models\Announcement as AnnouncementModel;
use App\Utilities\Result;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * @var Authenticatable
     */
    private $user;

    /**
     * @var Result
     */
    private $result;

    public function __construct(Result $result)
    {
        $this->result = $result;
    }

    /**
     * For uploading image.
     */
    public function upload(ImageRequest $request): JsonResponse
    {
        $file_path = 'https://no-image.jpg';

        $file = $request->file('image');
        $file_name = $request->file('image')->hashName();
        $file->move(public_path('announcement_contents'), $file_name);

        $file_path = env('APP_URL') . '/announcement_contents' . '/' . $file_name;

        return $this->result->success([
            'url'   => $file_path,
        ]);
    }

    /**
     * Fetch all the announcements.
     */
    public function index(Request $request): JsonResponse
    {
        $sortBy = $request->sortBy ?? 'title';
        $sortOrder = $request->sortOrder ?? 'asc';

        $announcements = AnnouncementModel::orderBy($sortBy, $sortOrder)->get();

        return $this->result->success($announcements);
    }

    /**
     * For Fetching single announcement.
     */
    public function get($id): JsonResponse
    {
        $announcement = AnnouncementModel::find($id);

        if (! $announcement) {
            return $this->result->notFound();
        }

        return $this->result->success($announcement);
    }

    /**
     * For adding announcement and saving to the database.
     */
    public function store(AnnouncementRequest $request): JsonResponse
    {
        $data = [
            'title'     => $request->title,
            'excerpt'   => $request->excerpt,
            'receiver'  => $request->receiver,
            'content'   => $request->content,
        ];

        $announcement = AnnouncementModel::create($data);

        if (! $announcement) {
            return $this->result->exception();
        }

        return $this->result->created($announcement, 'Announcement Created');
    }

    /**
     * For updating the announcement data in the database.
     */
    public function update(AnnouncementRequest $request, $id): JsonResponse
    {
        $announcement = AnnouncementModel::find($id);

        if (! $announcement) {
            return $this->result->notFound();
        }

        $announcement->title = $request->title;
        $announcement->excerpt = $request->excerpt;
        $announcement->receiver = $request->receiver;
        $announcement->content = $request->content;
        $announcement->save();

        return $this->result->success($announcement, 'Announcement updated');
    }

    /**
     * For deleting the announcement data in the database.
     */
    public function delete($id): JsonResponse
    {
        $announcement = AnnouncementModel::find($id);

        if (! $announcement) {
            return $this->result->notFound();
        }

        $deleted = $announcement->delete();

        if (! $deleted) {
            return $this->result->exception();
        }

        return $this->result->success($deleted, 'Announcement deleted successfully');
    }
}
