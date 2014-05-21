@foreach($tweets as $tweet)
	<div class="media">
		<a class="pull-left" href="{{Twitter::linkUser($twitterAccount)}}">
			<img class="media-object" src="{{$tweets[0]['user']['profile_image_url']}}">
		</a>
		<div class="media-body">
			<p>{{Twitter::linkify($tweet['text'])}}</p>
		</div>
	</div>
@endforeach
<br />
<a href="{{Twitter::linkUser($twitterAccount)}}" class="btn btn-warning pull-right">Read more tweets</a>