<h4 class="start-page-title">{{ $post_title }}</h4>
<section class="start-page-section section-comments">
    <div class="container">
        <div class="grid grid--columns" data-equal-container>
            @if(count($comments) > 0)
                @foreach($comments as $comment)
                    <div class="u-flex grid-xs-12 grid-sm-12 grid-md-6 grid-lg-6">
                        <a href="{{ get_comment_link($comment->comment_ID) }}" class="comment-card">
                            <div class="comment-card-icon">
                                <i class="icon-quote"></i>
                            </div>

                            <div class="comment-card-body">
                                <h2 class="comment-card-title">
                                    {{ get_the_title($comment->comment_post_ID) }}
                                </h2>
                                <div class="small-text">
                                    <span class="author">
                                        {{ get_user_meta($comment->user_id)['name_of_council_or_politician'][0] }}, 
                                    </span>
                                    <time class="date">
                                        {{ explode(' ', $comment->comment_date)[0] }}
                                    </time>
                                </div>
                                <p class="card-comment-content">
                                    {{ substr($comment->comment_content, 0, 240) . '...' }}
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <span><?php __('No comments found...', 'modularity-comments') ?></span>
            @endif
        </div>
    </div>
</section>
