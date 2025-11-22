@extends(layouts.petugas)

@section('title, "Dashboard petugas')

@setcion('content')

<h2>Welcum, {{ $petugas->nama }}</h2>

<hr>

<h3>Informasi Akun</h3>
<ul>
    <li>{{ $petugas->nama }}</li> <li>{{ $petugas->status }}</li>
</ul>

<hr>

<h3>Gawean</h3>


