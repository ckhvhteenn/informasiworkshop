<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\WorkshopRepositoryInterface;


class FrontService
{
    protected $categoryRepository;
    protected $workshopRepository;

    public function __construct(WorkshopRepositoryInterface $workshopRepository,
    CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->workshopRepository = $workshopRepository;
    }

    public function getFrontPageData()
    {
        $categories = $this->categoryRepository->getAllcategories();
        $newWorkshops = $this->workshopRepository->getAllWorkshops();

        return compact('categories', 'newWorkshops');
    }
}
