@extends('layouts.main-layout')
@section('content')
<h2>Create</h2>
<form enctype="multipart/form-data" action="{{route('store')}}" method="POST">

    @method("POST")
    @csrf

    <label for="name">Name:</label>
    <input type="text" name="name" placeholder="nome piatto"><br>
    <textarea name="description_ingredients" id="" cols="30" rows="10"></textarea>
    <label for="price">Price:</label>
    <input step=".01" type="number" name="price" ><br>
    <label for="food_img">Inserisci immagine</label>
    <input type="file" name="food_img">
    <label for="visible">visibility</label>
    <select name="visible" id="">
        <option value="0">No</option>
        <option value="1">Si</option>
    </select>
    <input type="submit" value="Create">
</form>

@endsection