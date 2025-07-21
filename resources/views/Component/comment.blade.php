@foreach($comments as $comment)
    <div class="comment-item">
        <div class="comment-img">
            <img src="{{ $comment->profile->avatarLink() }}" alt="{{ $comment->profile->name }}">
        </div>
        <div class="comment-content">
            <div class="comment-author">
                <div class="author-info" title="{{ verta($comment->created_at)->format('l d F Y H:i') }}">
                    <h5>{{ $comment->profile->name }}</h5>
                    <span><i class="far fa-clock"></i>{{ $comment->created_at->diffForHumans() }}</span>
                </div>
            </div>
            <div class="comment-text">
                <p>{!! nl2br(e($comment->comment)) !!}</p>
            </div>
            {{--                                        <div class="comment-action">--}}
            {{--                                            <a href="#"><i class="far fa-reply"></i>پاسخ</a>--}}
            {{--                                            <a href="#"><i class="far fa-thumbs-up"></i>۲.۵ هزار</a>--}}
            {{--                                            <a href="#"><i class="far fa-thumbs-down"></i>۱.۲ هزار</a>--}}
            {{--                                        </div>--}}
        </div>
    </div>
{{--    @if($comment->chields()->count() > 0)--}}
        @foreach($comment->activeChild as $child)
            <div class="comment-item comment-reply">
                <div class="comment-img">
                    <img src="{{ $child->profile->avatar }}" alt="{{ $child->profile->name }}">
                </div>
                <div class="comment-content">
                    <div class="comment-author">
                        <div class="author-info" title="{{ verta($child->created_at)->format('l d F Y H:i') }}">
                            <h5>{{ $child->profile->name }}</h5>
                            <span><i class="far fa-clock"></i>{{ $child->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="comment-text">
                        <p>{!! nl2br(e($child->comment)) !!}</p>
                    </div>
                </div>
            </div>
        @endforeach
{{--    @endif--}}
@endforeach
