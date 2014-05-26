@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-12">
		<h1>About Coachcenter</h1>
<p><em>Awesome</em> web-service for (<del>soccer</del>) football stats, (safe) betting with your
friends and such.</p>

<p>This was a project for the course Programming Project Databases at the
University of Antwerp. As this was a group project, the following developers have
built the basics of CoachCenter:</p>

<ul class="task-list">
<li><a href="https://github.com/JakobStruye">JakobStruye</a></li>
<li><a href="https://github.com/KristofDM">KristofDM</a></li>
<li><a href="https://github.com/rubenvanassche">rubenvanassche</a></li>
<li><a href="https://github.com/Stijn-Flipper">Stijn-Flipper</a></li>
<li><a href="https://github.com/tomroels">tomroels</a></li>
</ul><p>This project uses <a href="http://laravel.com/">Laravel PHP Framework</a>.</p>

<h2>
<a name="user-content-basic-features" class="anchor" href="#basic-features"><span class="octicon octicon-link"></span></a>Basic features</h2>

<ul class="task-list">
<li>match predictions based upon statistics</li>
<li>suggestions for users using nice visualization of statistical data</li>
<li>updating matches and rankings frequently</li>
<li>e-mail notifications for users when a match is going to play while the user
hasn't made a bet yet.</li>
<li>automatically load new data (including unknown matches like finals)</li>
</ul><p><strong>non-logged users</strong></p>

<ul class="task-list">
<li>view statistical data</li>
<li>view match outcomes (including filtering on competition type and time)</li>
<li>view match predictions</li>
</ul><p><strong>logged-in users</strong></p>

<ul class="task-list">
<li>input match predictions</li>
<li>receive suggestions from system</li>
<li>creating user groups

<ul class="task-list">
<li>view bet scores and ranking in this group</li>
<li>subscribe to other group (after invitation)</li>
</ul>
</li>
</ul><h2>
<a name="user-content-extended-features" class="anchor" href="#extended-features"><span class="octicon octicon-link"></span></a>Extended features</h2>

<p>Of course, there's more!</p>

<ul class="task-list">
<li>News feed</li>
<li>Twitter feed</li>
<li>Facebook integration</li>
<li>Search through the data</li>
</ul><h2>
<a name="user-content-installation" class="anchor" href="#installation"><span class="octicon octicon-link"></span></a>Installation</h2>

<p>Visit <a href="https://github.com/rubenvanassche/Programming-Project-Databases">Github</a> for an overview of our code.</p>
		</div>
	</div>
@stop
