<?php

class Journal
{
    public $journal_id;
    public $title;
    public $content;
    public $created_at;

    public function __construct($data = [])
    {
        $this->journal_id = $data['journal_id'] ?? '';
        $this->title = $data['title'] ?? '';
        $this->content = $data['content'] ?? '';
        $this->created_at = $data['created_at'] ?? '';
    }
}
