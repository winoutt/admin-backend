<?php

namespace App\Http\Controllers;

use App\Repositories\ReportingRepository;
use App\Services\Response;
use Exception;

class ReportingController
{
    private $response;
    private $reportingRepo;

    public function __construct()
    {
        $this->response = new Response;
        $this->reportingRepo = new ReportingRepository;
    }

    public function list()
    {
        $reportings = $this->reportingRepo->getReportings();
        return $this->response->ok($reportings);
    }

    public function read ($id)
    {
        try {
            $reporting = $this->reportingRepo->getFromId($id);
            return $this->response->ok($reporting);
        } catch (Exception $e) {
            return $this->response->bad($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $reporting = $this->reportingRepo->delete($id);
            return $this->response->ok($reporting);
        } catch (Exception $e) {
            return $this->response->bad($e->getMessage());
        }
    }

    public function approve($id)
    {
        try {
            $reporting = $this->reportingRepo->approve($id);
            return $this->response->ok($reporting);
        } catch (Exception $e) {
            return $this->response->bad($e->getMessage());
        }
    }
}