@extends('layouts.master')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.<?php echo base_path(); ?> ss</p>
@stop

@section('content')
    <p>This is my body content. <?php echo $name; ?></p>
@stop