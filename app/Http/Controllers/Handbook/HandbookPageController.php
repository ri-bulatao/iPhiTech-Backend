<?php

declare(strict_types=1);

namespace App\Http\Controllers\Handbook;

use App\Http\Controllers\Controller;
use App\Utilities\Result;
use Illuminate\Contracts\Auth\Authenticatable;

class HandbookPageController extends Controller
{
    /**
     * @var Authenticatable
     */
    private $user;

    /**
     * @var Result
     */
    private $result;

    public function __construct(
        Result $result
    ) {
        $this->user = auth()->user();
        $this->result = $result;
    }
}
