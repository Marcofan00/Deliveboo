@extends('layouts.main-layout')
@section('content')
<h2>Edit</h2>
<form enctype="multipart/form-data" action="{{route('update.food')}}" method="POST">

    @method("POST")
    @csrf

    <label for="name">Name:</label>
    <input type="text" name="name" value="{{$food -> name }}"><br>
    <textarea value="{{$food -> description_ingredients}}" name="description_ingredients" id="" cols="30" rows="10" ></textarea>
    <label for="price">Price:</label>
    <input value="{{$food -> price }}" step=".01" type="number" name="price" ><br>
    <label for="food_img">Inserisci immagine</label>
    <input value="{{$food -> food_img }}" type="file" name="food_img">
    <label for="visible">visibility</label>
    <select name="visible" id="">
        <option value="0">No</option>
        <option value="1">Si</option>
    </select>
    <input type="submit" value="Edit">
</form>

@endsection