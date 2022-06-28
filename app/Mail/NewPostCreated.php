<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;

class NewPostCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $post; // We have an instance of the Post model inside the mail view

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        // Construct the post instance
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->from('noreply@example.com')
        ->subject('A new post was created')
        ->view('mail.posts.created');
    }
}
