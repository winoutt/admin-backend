<?php

namespace App\Http\Controllers;

use App\Repositories\CommentRepository;
use App\Services\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController
{
    private $response;
    private $commentRepo;

    public function __construct()
    {
        $this->response = new Response;
        $this->commentRepo = new CommentRepository;
    }

    public function list()
    {
        $comments = $this->commentRepo->getLatest();
        return $this->response->ok($comments);
    }

    public function read($id)
    {
        try {
            $comment = $this->commentRepo->getFromId($id);
            return $this->response->ok($comment);
        } catch (Exception $e) {
            return $this->response->bad($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $comment = $this->commentRepo->delete($id);
            return $this->response->ok($comment);
        } catch (Exception $e) {
            return $this->response->bad($e->getMessage());
        }
    }

    public function search(Request $request) {
        $validator = Validator::make($request->query(), [
            'term' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->response->unprocessable($validator);
        }
        $comments = $this->commentRepo->search($request->query('term'));
        return $this->response->ok($comments);
    }
}