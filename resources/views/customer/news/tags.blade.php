<h1>خبرهای دارای برچسب: {{ $tag->name }}</h1>

@forelse($newsList as $news)
    <div class="news-card">
        <h3>{{ $news->title }}</h3>
        <p>{{ Str::limit(strip_tags($news->body), 150) }}</p>
        <a href="{{ route('customer.news.show', $news->id) }}">مشاهده خبر</a>
    </div>
@empty
    <p>هیچ خبری با این برچسب پیدا نشد.</p>
@endforelse

{{ $newsList->links() }}
