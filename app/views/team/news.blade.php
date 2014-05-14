@if(empty($selectedArticles))
	<p>No news avaible</p>
@endif

@foreach($selectedArticles as $article)
	<b><a href="{{$article['link']}}">{{$article['title']}}</a></b>
	<p><?php echo $article['description']; ?></p>
@endforeach