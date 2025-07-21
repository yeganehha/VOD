<div class="tvshow-area py-80" dir="rtl">
    <div class="container">
        <div class="row row-cols-xl-5">

            @forelse($movies as $item)

                <div class="col-6 col-md-4 col-lg-3 col-xl">
                    <div class="movie-item">
                        @if(in_array($item->entity->type , collect(\App\Enums\EntityType::cases())->filter(fn($item) => $item->isMultiEpisode())->toArray() ))
                        <span class="movie-quality">قسمت {{ $item->episode }} @if($item->entity->type == \App\Enums\EntityType::MultiSeasonSeries) فصل {{ $item->season }}@endif </span>
                        @endif
                        <div class="movie-img">
                            <img src="{{ $item->getImage(3,4) }}" style="aspect-ratio: 3 / 4;" alt="{{ $item->title ?? $item->entity->title }}">
                            <a href="{{ route('movie.short' , $item->id ) }}" class="movie-play"><i class="icon-play-3"></i></a>
                            <div class="movie-action">
                                <div class="action-item" onclick="toggleFavorite('{{ $item->id }}')">
                                    <i class="@guest far @endguest @auth {{ $item->likedByUsers->isNotEmpty() ? 'fas' : 'far' }} @endauth fa-heart" id="heart-{{ $item->id }}"></i>
                                </div>
                                <div class="action-item"><i class="far fa-share-alt"></i></div>
                            </div>
                        </div>
                        <div class="movie-content" dir="rtl">
                            <h6 class="movie-title"><a href="{{ route('movie.short' , $item->id ) }}">{{ $item->title ?? $item->entity->title }}</a></h6>
                            <div class="movie-info">
                                <span class="movie-time">{{ $item->durationTitle() }}</span>
                                <div class="movie-genre">
                                    @foreach($item->entity->genres()->take(3)->get() as $genre)
                                        <a href="{{ route('genre' , ['genre' => $genre->slug]) }}">{{ $genre->title }}</a>
                                        @if (!$loop->last),
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @empty

            @endforelse


        </div>

        <div class="pagination-area mt-20">
            <div aria-label="Page navigation example">
                {{ $movies->links('pagination::bootstrap-4') }}
            </div>
        </div>

    </div>
</div>
