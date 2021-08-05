<?php

namespace App\Http\Controllers;

use App\Repositories\PostRepository;
use App\Services\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController
{
    private $response;
    private $postRepo;

    public function __construct()
    {
        $this->response = new Response;
        $this->postRepo = new PostRepository;
    }

    public function list()
    {
        $posts = $this->postRepo->getLatest();
        return $this->response->ok($posts);
    }

    public function read($id)
    {
        try {
            $post = $this->postRepo->getFromId($id);
            return $this->response->ok($post);
        } catch (Exception $e) {
            return $this->response->bad($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $post = $this->postRepo->delete($id);
            return $this->response->ok($post);
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
        $posts = $this->postRepo->search($request->query('term'));
        return $this->response->ok($posts);
    }
}