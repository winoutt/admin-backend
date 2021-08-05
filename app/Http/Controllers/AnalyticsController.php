<?php

namespace App\Http\Controllers;

use App\Repositories\AuthorStarViewRepository;
use App\Repositories\ChatArchiveRepository;
use App\Repositories\ChatRepository;
use App\Repositories\CommentHashtagRepository;
use App\Repositories\CommentMentionRepository;
use App\Repositories\CommentRepository;
use App\Repositories\CommentVoteRepository;
use App\Repositories\ConnectionRepository;
use App\Repositories\FavouriteRepository;
use App\Repositories\HashtagRepository;
use App\Repositories\LinkPreviewRepository;
use App\Repositories\MessageRepository;
use App\Repositories\NoteRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\PollChoiceRepository;
use App\Repositories\PollRepository;
use App\Repositories\PollVoteRepository;
use App\Repositories\PostAlbumPhotoRepository;
use App\Repositories\PostHashtagRepository;
use App\Repositories\PostMentionRepository;
use App\Repositories\PostRepository;
use App\Repositories\PostUnfollowRepository;
use App\Repositories\ReportingRepository;
use App\Repositories\StarRepository;
use App\Repositories\TeamRepository;
use App\Repositories\UnfollowRepository;
use App\Repositories\UserRepository;
use App\Repositories\WebsiteRepository;
use App\Services\Response;

class AnalyticsController
{
    private $response;
    private $authorStarViewRepo;
    private $chatRepo;
    private $chatArchiveRepo;
    private $commentRepo;
    private $commentHashtagRepo;
    private $commentMentionRepo;
    private $commentVoteRepo;
    private $connectionRepo;
    private $favouriteRepo;
    private $hashtagRepo;
    private $linkPreviewRepo;
    private $messageRepo;
    private $noteRepo;
    private $notificationRepo;
    private $pollRepo;
    private $pollChoiceRepo;
    private $pollVoteRepo;
    private $postRepo;
    private $postAlbumPhotoRepo;
    private $postHashtagRepo;
    private $postMentionRepo;
    private $postUnfollowRepo;
    private $reportingRepo;
    private $starRepo;
    private $teamRepo;
    private $unfollowRepo;
    private $userRepo;
    private $websiteRepo;

    public function __construct()
    {
        $this->response = new Response;
        $this->authorStarViewRepo = new AuthorStarViewRepository;
        $this->chatRepo = new ChatRepository;
        $this->chatArchiveRepo = new ChatArchiveRepository;
        $this->commentRepo = new CommentRepository;
        $this->commentHashtagRepo = new CommentHashtagRepository;
        $this->commentMentionRepo = new CommentMentionRepository;
        $this->commentVoteRepo = new CommentVoteRepository;
        $this->connectionRepo = new ConnectionRepository;
        $this->favouriteRepo = new FavouriteRepository;
        $this->hashtagRepo = new HashtagRepository;
        $this->linkPreviewRepo = new LinkPreviewRepository;
        $this->messageRepo = new MessageRepository;
        $this->noteRepo = new NoteRepository;
        $this->notificationRepo = new NotificationRepository;
        $this->pollRepo = new PollRepository;
        $this->pollChoiceRepo = new PollChoiceRepository;
        $this->pollVoteRepo = new PollVoteRepository;
        $this->postRepo = new PostRepository;
        $this->postAlbumPhotoRepo = new PostAlbumPhotoRepository;
        $this->postHashtagRepo = new PostHashtagRepository;
        $this->postMentionRepo = new PostMentionRepository;
        $this->postUnfollowRepo = new PostUnfollowRepository;
        $this->reportingRepo = new ReportingRepository;
        $this->starRepo = new StarRepository;
        $this->teamRepo = new TeamRepository;
        $this->unfollowRepo = new UnfollowRepository;
        $this->userRepo = new UserRepository;
        $this->websiteRepo = new WebsiteRepository;
    }

    public function counts ()
    {
        $counts = [
            'chats' => $this->chatRepo->getCount(),
            'chatArchives' => $this->chatArchiveRepo->getCount(),
            'comments' => $this->commentRepo->getCount(),
            'commentHashtags' => $this->commentHashtagRepo->getCount(),
            'commentMentions' => $this->commentMentionRepo->getCount(),
            'authorStarViews' => $this->authorStarViewRepo->getCount(),
            'commentVotes' => $this->commentVoteRepo->getCount(),
            'connections' => $this->connectionRepo->getCount(),
            'favorites' => $this->favouriteRepo->getCount(),
            'hashtags' => $this->hashtagRepo->getCount(),
            'lastMessages' => $this->chatRepo->getCount(),
            'linkPreviews' => $this->linkPreviewRepo->getCount(),
            'messages' => $this->messageRepo->getCount(),
            'notes' => $this->noteRepo->getCount(),
            'notifications' => $this->notificationRepo->getCount(),
            'pollChoices' => $this->pollChoiceRepo->getCount(),
            'pollVotes' => $this->pollVoteRepo->getCount(),
            'postAlbumPhotos' => $this->postAlbumPhotoRepo->getCount(),
            'postHashtags' => $this->postHashtagRepo->getCount(),
            'postMentions' => $this->postMentionRepo->getCount(),
            'posts' => [
                'count' => $this->postRepo->getCount(),
                'texts' => $this->postRepo->getCountByType('text'),
                'images' => $this->postRepo->getCountByType('image'),
                'videos' => $this->postRepo->getCountByType('video'),
                'audios' => $this->postRepo->getCountByType('audio'),
                'documents' => $this->postRepo->getCountByType('document'),
                'articles' => $this->postRepo->getCountByType('article'),
                'albums' => $this->postRepo->getCountByType('album'),
                'polls' => $this->pollRepo->getCount(),
            ],
            'postUnfollows' => $this->postUnfollowRepo->getCount(),
            'reportings' => [
                'count' => $this->reportingRepo->getCount(),
                'users' => $this->userRepo->getReportingsCount(),
                'posts' => $this->postRepo->getReportingsCount(),
                'comments' => $this->commentRepo->getReportingsCount(),
            ],
            'stars' => $this->starRepo->getCount(),
            'teams' => $this->teamRepo->getCount(),
            'unfollows' => $this->unfollowRepo->getCount(),
            'users' => [
                'count' => $this->userRepo->getCount(),
                'males' => $this->userRepo->getCountByGender('male'),
                'females' => $this->userRepo->getCountByGender('female'),
                'online' => $this->userRepo->getOnlineCount(),
                'banned' => $this->userRepo->getBannedCount(),
            ],
            'websites' => [
                'count' => $this->websiteRepo->getCount(),
                'personal' => $this->websiteRepo->getPersonalCount(),
                'company' => $this->websiteRepo->getCompanyCount(),
            ],
        ];
        return $this->response->ok($counts);
    }

    public function topCountries()
    {
        $topCountries = $this->userRepo->topCountries();
        return $this->response->ok($topCountries);
    }

    public function monthlyStatistics()
    {
        $statistics = [
            'users' => $this->userRepo->monthlyStatistics(),
            'posts' => $this->postRepo->monthlyStatistics(),
            'stars' => $this->starRepo->monthlyStatistics(),
            'comments' => $this->commentRepo->monthlyStatistics(),
        ];
        return $this->response->ok($statistics);
    }
}