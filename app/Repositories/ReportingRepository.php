<?php

namespace App\Repositories;

use App\Reporting;
use Exception;

class ReportingRepository
{
    private $userRepo;
    private $postRepo;
    private $commentRepo;

    public function __construct()
    {
        $this->userRepo = new UserRepository;
        $this->postRepo = new PostRepository;
        $this->commentRepo = new CommentRepository;
    }

    public function getCount ()
    {
        return Reporting::count();
    }

    public function getReportings()
    {
        return Reporting::latest()->limit(50)->get();
    }

    public function getFromId($id)
    {
        $reporting = Reporting::find($id);
        if (!$reporting) throw new Exception('Reporting not found');
        return $reporting;
    }

    public function delete($id)
    {
        $reporting = $this->getFromId($id);
        $reporting->forceDelete();
        return $reporting;
    }

    public function approve($id)
    {
        $reporting = $this->getFromId($id);
        switch ($reporting->reportable_type) {
            case 'App\User':
                $this->userRepo->block($reporting->reportable_id);
                break;
            case 'App\Post':
                $this->postRepo->delete($reporting->reportable_id);
                break;
            case 'App\Comment':
                $this->commentRepo->delete($reporting->reportable_id);
                break;
            default:
                throw new Exception('Invalid take action request');
        }
        $this->delete($id);
        return $reporting;
    }
}