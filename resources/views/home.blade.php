<html>
<body>

@if(session('class'))
<h1> class {{ session('class') }} </h1>
@endif

<form action="/home/search" method="post">
text: <input type="text" name="search"><br>
<input type="submit">
</form>

</body>
</html>