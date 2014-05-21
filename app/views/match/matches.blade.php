@extends('layouts.master')

@section('content')
  <div class="row">
    <div class="col-md-12">
      <h1>Upcoming matches</h1>
    </div>
    <div class="col-md-12">
      <table class="table table-condensed center">
        <thead class="center">
          <tr>
            <th>Date</th>
            <th>Home</th>
            <th>vs.</th>
            <th>Away</th>
            <th>Check match</th>
          </tr>
        </thead>
        <tbody>
              @foreach($matches as $match)
                  <tr class="mark">
                    <td>{{$match->date}}</td>
                    <td><a href="{{route('team', array('id'=>$match->hometeam_id))}}">{{$match->hometeam}}</a></td>
                    <td> - </td>
                    <td><a href="{{route('team', array('id'=>$match->awayteam_id))}}">{{$match->awayteam}}</a></td>
                    <td><a href="{{route('match', array('id'=>$match->id))}}"}}><button type="button" class="btn btn-default">Go!</button></a></td>
                  </tr>
              @endforeach
        </tbody>
      </table>
    </div>
  </div>
@stop

@section('css')
<style>
  .center{
    text-align:center;
  }

  .center th {
    text-align:center;
  }
</style>
@stop
