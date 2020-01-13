<h4 class="start-page-title">{{ $post_title }}</h4>
<section class="start-page-section section-comments">
    <div class="container">
        <div class="grid grid--columns" data-equal-container>
            <div class="u-flex grid-xs-12 grid-sm-6 grid-md-6 grid-lg-6">
                @foreach($comments as $comment)
                    <a href="{{ get_comment_link($comment->comment_ID) }}" class="comment-card">
                        <div class="comment-card-icon"></div>
                        <div class="comment-card-body">
                            <h2 class="comment-card-title">
                                {{ get_the_title($comment->comment_post_ID) }}
                            </h2>
                            <div class="small-text">
                                <span class="author">
                                    {{ get_post_meta($comment->comment_post_ID)['name_of_council_or_politician'][0] }}, 
                                </span>
                                <time class="date">
                                    {{ explode(' ', get_post($comment->comment_post_ID)->post_date)[0] }}
                                </time>
                            </div>
                            <p class="card-comment-content">
                                {{ $comment->comment_content }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
