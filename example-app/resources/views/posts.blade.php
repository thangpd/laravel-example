<h1>All Posts</h1>
<?php


foreach ( $posts as $post ) {

?>
<h1><a href="/posts/{{$post->slug}}">{{$post->title}}</a></h1>
<p>{{$post->desc}}</p>
<?php
echo '<hr>';
}


?>