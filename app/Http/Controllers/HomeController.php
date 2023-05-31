<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Page\PageService;

class HomeController extends Controller
{

    /**
     * The service instance
     * @var pageService
     */
    private PageService $pageService;

    /**
     * Constructor
     */
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function index()
    {
        return $this->pageService->index();
    }

    public function dashboardUserData()
    {
        return $this->pageService->dashboardData();
    }
}
